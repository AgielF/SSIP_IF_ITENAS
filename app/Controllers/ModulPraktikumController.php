<?php

namespace App\Controllers;

use App\Models\ModulPraktikumModel;
use App\Models\JadwalModel;

class ModulPraktikumController extends BaseController
{
    protected $modulPraktikumModel;
    protected $jadwalModel;

    public function __construct()
    {
        $this->modulPraktikumModel = new ModulPraktikumModel();
        $this->jadwalModel = new JadwalModel();
    }

    // 📋 LIST UNTUK USER
    public function index()
    {   
        $modulPraktikum = $this->modulPraktikumModel
            ->select('modul_praktikum.*, jadwal.tanggal as jadwal_tanggal')
            ->join('jadwal', 'jadwal.id_jadwal = modul_praktikum.id_jadwal')
            ->findAll();

        return view('sections/modul_praktikum', [
            'modulPraktikum' => $modulPraktikum
        ]);
    }

    // 📋 LIST UNTUK ADMIN
    public function admin()
    {
        $modulPraktikum = $this->modulPraktikumModel
            ->select('modul_praktikum.*, jadwal.tanggal as jadwal_tanggal')
            ->join('jadwal', 'jadwal.id_jadwal = modul_praktikum.id_jadwal', 'left')
            ->findAll();

        // Ambil semua jadwal untuk select option
        $jadwalList = $this->jadwalModel->findAll();

        return view('modul_praktikum_list_admin_view', [
            'modulPraktikum' => $modulPraktikum,
            'jadwalList'     => $jadwalList
        ]);
    }

    // 🟢 CREATE
    public function create()
    {
        // 🛡️ 1. VALIDASI INPUT
        $rules = [
            'judul'     => 'required|max_length[100]',
            'deskripsi' => 'required',
            'id_jadwal' => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/modul_praktikum_admin')
                             ->with('error', 'Format data tidak valid: ' . implode(', ', $this->validator->getErrors()));
        }

        // 🛡️ 2. TRY-CATCH ERROR HANDLING
        try {
            $file = $this->request->getFile('file_modul');
            $file_url = '';

            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Validasi tipe file (PDF, DOCX, DOC) menggunakan CI4 validation rules
                $fileRules = [
                    'file_modul' => [
                        'label' => 'File Modul',
                        'rules' => 'uploaded[file_modul]|max_size[file_modul,10240]|mime_in[file_modul,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword]|ext_in[file_modul,pdf,doc,docx]',
                    ],
                ];

                if (!$this->validate($fileRules)) {
                    return redirect()->to('/modul_praktikum_admin')
                                     ->with('error', $this->validator->listErrors());
                }

                // Pindahkan file ke folder uploads/modul/
                $newName = $file->getRandomName();
                $file->move(WRITEPATH . 'uploads/modul', $newName);
                $file_url = $newName;
            } else if ($this->request->getPost('file_url') && empty($file_url)) {
                $file_url = $this->request->getPost('file_url');
            }

            $data = [
                'judul'     => $this->request->getPost('judul'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'file_url'  => $file_url,
                'id_jadwal' => $this->request->getPost('id_jadwal')
            ];

            $this->modulPraktikumModel->save($data);

            return redirect()->to('/modul_praktikum_admin')
                             ->with('success', 'Modul praktikum berhasil ditambahkan.');

        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat menyimpan modul.');
        }
    }

    // 🟡 UPDATE
    public function update($id)
    {
        // 🛡️ PASTIKAN ID NUMERIC
        if (!is_numeric($id)) {
            return redirect()->to('/modul_praktikum_admin')->with('error', 'ID Modul tidak valid.');
        }

        // 🛡️ 1. VALIDASI INPUT
        $rules = [
            'judul'     => 'required|max_length[100]',
            'deskripsi' => 'required',
            'id_jadwal' => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                             ->with('error', 'Format data tidak valid: ' . implode(', ', $this->validator->getErrors()));
        }

        // 🛡️ 2. TRY-CATCH ERROR HANDLING
        try {
            $modul = $this->modulPraktikumModel->find($id);
            if (!$modul) {
                return redirect()->to('/modul_praktikum_admin')
                                 ->with('error', 'Data modul praktikum tidak ditemukan.');
            }

            $file = $this->request->getFile('file_modul');
            $file_url = $modul['file_url'];

            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Validasi tipe file menggunakan CI4 validation rules
                $fileRules = [
                    'file_modul' => [
                        'label' => 'File Modul',
                        'rules' => 'uploaded[file_modul]|max_size[file_modul,10240]|mime_in[file_modul,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword]|ext_in[file_modul,pdf,doc,docx]',
                    ],
                ];

                if (!$this->validate($fileRules)) {
                    return redirect()->to('/modul_praktikum_admin')
                                     ->with('error', $this->validator->listErrors());
                }

                // Hapus file lama jika ada
                if (!empty($modul['file_url'])) {
                    $oldPath = WRITEPATH . 'uploads/modul/' . $modul['file_url'];
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                // Pindahkan file baru
                $newName = $file->getRandomName();
                $file->move(WRITEPATH . 'uploads/modul', $newName);
                $file_url = $newName;
            } else if ($this->request->getPost('file_url') && $this->request->getPost('file_url') !== $modul['file_url']) {
                $file_url = $this->request->getPost('file_url');
            }

            $data = [
                'judul'     => $this->request->getPost('judul'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'file_url'  => $file_url,
                'id_jadwal' => $this->request->getPost('id_jadwal')
            ];

            $this->modulPraktikumModel->update($id, $data);

            return redirect()->to('/modul_praktikum_admin')
                             ->with('success', 'Modul praktikum berhasil diperbarui.');

        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat memperbarui modul.');
        }
    }

    // 🔴 DELETE
    public function delete($id)
{
    if (!is_numeric($id)) return redirect()->to('/modul_praktikum_admin')->with('error', 'ID tidak valid');
    try {
        $modul = $this->modulPraktikumModel->find($id);
        if ($modul && !empty($modul['file_url'])) {
            $filePath = WRITEPATH . 'uploads/modul/' . $modul['file_url'];
            if (file_exists($filePath)) unlink($filePath);
        }
        $this->modulPraktikumModel->delete($id);
        return redirect()->to('/modul_praktikum_admin')->with('success', 'Modul praktikum berhasil dihapus.');
    } catch (\Throwable $e) {
        return redirect()->to('/modul_praktikum_admin')->with('error', 'Gagal menghapus modul praktikum.');
    }
}

    
    public function preview($filename)
    {
        // Pastikan file diambil dari folder writable
        $filePath = WRITEPATH . 'uploads/modul/' . basename($filename);

        // Validasi apakah file ada di direktori
        if (!file_exists($filePath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('File tidak ditemukan');
        }

        // Ambil ekstensi file
        $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        if ($ext === 'pdf') {
            // JIKA PDF: Buka langsung di tab browser (Inline)
            $fileData = file_get_contents($filePath);
            return $this->response
                ->setHeader('Content-Type', 'application/pdf')
                ->setHeader('Content-Disposition', 'inline; filename="' . basename($filename) . '"')
                ->setBody($fileData);
                
        } elseif (in_array($ext, ['doc', 'docx'])) {
            // JIKA DOCX/DOC: Paksa untuk langsung di-download
            return $this->response->download($filePath, null);
            
        } else {
            // Jika format tidak dikenali
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Format file tidak didukung');
        }
    }
    // 📥 FORCE DOWNLOAD FILE (Untuk PDF & DOCX)
    public function download($filename)
    {
        $filePath = WRITEPATH . 'uploads/modul/' . basename($filename);

        if (!file_exists($filePath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('File tidak ditemukan');
        }

        // Fungsi ini akan memaksa browser mengunduh file, apapun formatnya
        return $this->response->download($filePath, null);
    }
}