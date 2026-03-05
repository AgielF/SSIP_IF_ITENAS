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
        $userId = $this->getUserIdOrRedirect(); 
        
        $kategori   = strtolower($this->request->getPost('kategori'));
        $keterangan = $this->request->getPost('keterangan');
        $namaFile   = '';

        // 1. JIKA KATEGORI ADALAH VIDEO
        if ($kategori === 'video') {
            // Ambil URL Embed dari input text link_video
            $namaFile = $this->request->getPost('link_video');
        } 
        // 2. JIKA KATEGORI ADALAH FOTO
        else {
            $file = $this->request->getFile('gambar');
            
            // Cek apakah ada file yang diunggah dan valid
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $namaFile = $file->getRandomName();
                $pathSimpan = FCPATH . 'uploads/galeri';
                
                // Pindahkan file ke public/uploads/galeri
                $file->move($pathSimpan, $namaFile);

                // Compress & Crop Gambar (Ukuran 800x450 / Rasio 16:9)
                $imageService = \Config\Services::image();
                $imagePath = $pathSimpan . '/' . $namaFile;
                $imageService->withFile($imagePath)
                             ->fit(800, 450, 'center')
                             ->save($imagePath);
            }
        }

        // Siapkan data untuk disimpan ke Database
        $data = [
            'kategori'       => $kategori,
            'keterangan'     => $keterangan,
            'file_url'       => $namaFile, // Berisi nama file fisik ATAU link youtube
            'tanggal_upload' => date('Y-m-d H:i:s'),
            'id_user'        => $userId
        ];

        $this->galeriUmumModel->insert($data);
        return redirect()->to('/galeri_admin')->with('success', 'Data galeri berhasil ditambahkan.');
    }

    // 🟡 UPDATE
    public function update($id)
    {
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
                
                // JIKA sebelumnya adalah 'Foto', hapus fisik fotonya di server agar tidak menuh-menuhin storage
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
            'tanggal_upload' => date('Y-m-d H:i:s'), // Opsional: mengupdate tanggal ke saat ini
            'id_user'        => $userId 
        ];

        $this->galeriUmumModel->update($id, $data);
        return redirect()->to('/galeri_admin')->with('success', 'Data galeri berhasil diperbarui.');
    }

    // DELETE
    public function delete($id)
    {
        $galeri = $this->galeriUmumModel->find($id);

        // Hapus file fisik gambar dari folder uploads/galeri
        if ($galeri && !empty($galeri['file_url']) && file_exists(FCPATH . 'uploads/galeri/' . $galeri['file_url'])) {
            unlink(FCPATH . 'uploads/galeri/' . $galeri['file_url']);
        }

        $this->galeriUmumModel->delete($id);
        return redirect()->to('/galeri_admin')->with('success', 'Data berhasil dihapus');
    }
}