<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GaleriUmumModel;

class GaleriUmumController extends BaseController
{
    protected $galeriUmumModel;

    public function __construct()
    {
        $this->galeriUmumModel = new GaleriUmumModel();
    }

    // Untuk user publik
    public function index()
    {
        $gallery_items = $this->galeriUmumModel->getDataWithUser();
        return view('galeri_list_view', [
            'title' => 'Galeri & Media',
            'gallery_items' => $gallery_items
        ]);
    }

    // Untuk admin
    public function admin()
    {
        $sort = $this->request->getGet('sort') ?? 'DESC'; // default terbaru
        $galerimodelall = $this->galeriUmumModel->getDataAdminFormatted($sort);

        return view('galeri_admin_list_view', [
            'title'       => 'Kelola Galeri & Media',
            'media_items' => $galerimodelall['galeri'],
            'sort'        => $sort
        ]);
    }

    // 🟢 CREATE
    public function create()
    {
        $userId   = $this->getUserIdOrRedirect();
        $kategori = strtolower($this->request->getPost('kategori'));
        $namaFile = '';

        // 🛡️ 1. VALIDASI INPUT DASAR
        $rules = [
            'kategori'   => 'required|max_length[50]',
            'keterangan' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/galeri_admin')->with('error', 'Format data tidak valid: ' . implode(', ', $this->validator->getErrors()));
        }

        // 🛡️ 2. TRY-CATCH ERROR HANDLING
        try {
            // 1. JIKA KATEGORI ADALAH VIDEO
            if ($kategori === 'video') {
                $namaFile = $this->request->getPost('link_video');

            // 2. JIKA KATEGORI ADALAH FOTO
            } else {
                $file = $this->request->getFile('gambar');

                if ($file && $file->isValid() && !$file->hasMoved()) {

                    // [T3.3] Ganti pengecekan getMimeType() manual dengan CI4 validation rules.
                    // Referensi: OWASP A04 Insecure Design & OWASP File Upload Cheat Sheet.
                    $validationRules = [
                        'gambar' => [
                            'label' => 'File Gambar',
                            'rules' => [
                                'uploaded[gambar]',
                                'max_size[gambar,2048]',          // Max 2MB
                                'is_image[gambar]',               // Harus berupa gambar valid
                                'mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]',
                                'ext_in[gambar,jpg,jpeg,png,webp]', // Double-check ekstensi
                            ],
                            'errors' => [
                                'is_image'  => 'File yang diupload harus berupa gambar (JPG, PNG, WEBP).',
                                'max_size'  => 'Ukuran gambar maksimal 2MB.',
                                'mime_in'   => 'Format file tidak didukung. Gunakan JPG, PNG, atau WEBP.',
                                'ext_in'    => 'Ekstensi file tidak diizinkan.',
                            ],
                        ],
                    ];

                    if (!$this->validate($validationRules)) {
                        return redirect()->to('/galeri_admin')
                                         ->with('error', $this->validator->listErrors());
                    }

                    $namaFile   = $file->getRandomName();
                    $pathSimpan = FCPATH . 'uploads/galeri';
                    $file->move($pathSimpan, $namaFile);

                    // Compress & Crop Gambar (Ukuran 800x450 / Rasio 16:9)
                    $imageService = \Config\Services::image();
                    $imagePath    = $pathSimpan . '/' . $namaFile;
                    $imageService->withFile($imagePath)
                                 ->fit(800, 450, 'center')
                                 ->save($imagePath);
                }
            }

            $data = [
                'kategori'       => $kategori,
                'keterangan'     => $this->request->getPost('keterangan'),
                'file_url'       => $namaFile,
                'tanggal_upload' => date('Y-m-d H:i:s'),
                'id_user'        => $userId
            ];

            $this->galeriUmumModel->insert($data);
            return redirect()->to('/galeri_admin')->with('success', 'Data galeri berhasil ditambahkan.');

        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat menyimpan data galeri.');
        }
    }

    // 🟡 UPDATE
    public function update($id)
    {
        // 🛡️ PASTIKAN ID NUMERIC
        if (!is_numeric($id)) {
            return redirect()->to('/galeri_admin')->with('error', 'ID Galeri tidak valid.');
        }

        // 🛡️ 1. VALIDASI INPUT DASAR
        $rules = [
            'kategori'   => 'required|max_length[50]',
            'keterangan' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Format data tidak valid: ' . implode(', ', $this->validator->getErrors()));
        }

        // 🛡️ 2. TRY-CATCH ERROR HANDLING
        try {
            $userId = $this->getUserIdOrRedirect(); 
            $galeriLama = $this->galeriUmumModel->find($id);
            
            $kategoriBaru = strtolower($this->request->getPost('kategori'));
            $keterangan   = $this->request->getPost('keterangan');
            
            // Default: Gunakan file/link lama
            $namaFile = $galeriLama['file_url']; 

            // 1. JIKA KATEGORI BARU ADALAH VIDEO
            if ($kategoriBaru === 'video') {
                $linkVideoBaru = $this->request->getPost('link_video');
                
                if (!empty($linkVideoBaru)) {
                    $namaFile = $linkVideoBaru;
                    
                    // JIKA sebelumnya adalah 'Foto', hapus fisik fotonya di server
                    if (strtolower($galeriLama['kategori']) === 'foto' && !empty($galeriLama['file_url'])) {
                        $oldFilePath = FCPATH . 'uploads/galeri/' . $galeriLama['file_url'];
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }
                }
            } 
            // 2. JIKA KATEGORI BARU ADALAH FOTO
            else {
                $file = $this->request->getFile('gambar');
                
                // Cek jika ada file FOTO BARU yang diupload admin
                if ($file && $file->isValid() && !$file->hasMoved()) {

                    // 🛡️ Validasi MIME type gambar
                    $validationRules = [
                        'gambar' => [
                            'label' => 'File Gambar',
                            'rules' => [
                                'uploaded[gambar]',
                                'max_size[gambar,2048]',
                                'is_image[gambar]',
                                'mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]',
                                'ext_in[gambar,jpg,jpeg,png,webp]',
                            ],
                        ],
                    ];

                    if (!$this->validate($validationRules)) {
                        return redirect()->to('/galeri_admin')->with('error', $this->validator->listErrors());
                    }
                    
                    // Hapus foto lama jika memang tipe aslinya foto dan ada file-nya
                    if (strtolower($galeriLama['kategori']) === 'foto' && !empty($galeriLama['file_url'])) {
                        $oldFilePath = FCPATH . 'uploads/galeri/' . $galeriLama['file_url'];
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }

                    $namaFileBaru = $file->getRandomName();
                    $pathSimpan   = FCPATH . 'uploads/galeri';
                    
                    // Pindahkan file baru
                    $file->move($pathSimpan, $namaFileBaru);

                    // Compress & Crop Gambar Baru (Ukuran 800x450 / Rasio 16:9)
                    $imageService = \Config\Services::image();
                    $imagePath    = $pathSimpan . '/' . $namaFileBaru;
                    $imageService->withFile($imagePath)
                                 ->fit(800, 450, 'center')
                                 ->save($imagePath);

                    // Timpa $namaFile dengan nama file yang baru saja diupload
                    $namaFile = $namaFileBaru;
                }
            }

            $data = [
                'kategori'       => $kategoriBaru,
                'keterangan'     => $keterangan,
                'file_url'       => $namaFile,
                'tanggal_upload' => date('Y-m-d H:i:s'),
                'id_user'        => $userId 
            ];

            $this->galeriUmumModel->update($id, $data);
            return redirect()->to('/galeri_admin')->with('success', 'Data galeri berhasil diperbarui.');

        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat memperbarui data galeri.');
        }
    }

    // DELETE
    public function delete($id)
{
    if (!is_numeric($id)) return redirect()->to('/galeri_admin')->with('error', 'ID tidak valid');
    try {
        $galeri = $this->galeriUmumModel->find($id);
        if ($galeri && !empty($galeri['file_url']) && file_exists(FCPATH . 'uploads/galeri/' . $galeri['file_url'])) {
            unlink(FCPATH . 'uploads/galeri/' . $galeri['file_url']);
        }
        $this->galeriUmumModel->delete($id);
        return redirect()->to('/galeri_admin')->with('success', 'Data berhasil dihapus');
    } catch (\Throwable $e) {
        return redirect()->to('/galeri_admin')->with('error', 'Gagal menghapus data galeri.');
    }
}
}