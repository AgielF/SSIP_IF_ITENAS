<?php

namespace App\Controllers;

use App\Models\ModulPraktikumModel;
use App\Models\JadwalModel;

class modulPraktikumController extends BaseController
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

        // ✅ kirim ke view dengan key
        return view('modul_praktikum_list_view', [
            'modulPraktikum' => $modulPraktikum
        ]);
    }
    public function admin()
{
    $modulPraktikum = $this->modulPraktikumModel
        ->select('modul_praktikum.*, jadwal.tanggal as jadwal_tanggal')
        ->join('jadwal', 'jadwal.id_jadwal = modul_praktikum.id_jadwal')
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
        $file = $this->request->getFile('file_modul');
        $file_url = '';

        // Validasi dan handle file upload
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Validasi tipe file (PDF only)
            if ($file->getMimeType() !== 'application/pdf') {
                return redirect()->to('/modul_praktikum_admin')
                                 ->with('error', 'Hanya file PDF yang diperbolehkan.');
            }

            // Validasi ukuran file (max 10MB)
            if ($file->getSize() > 10 * 1024 * 1024) {
                return redirect()->to('/modul_praktikum_admin')
                                 ->with('error', 'Ukuran file maksimal 10MB.');
            }

            // Move file ke folder uploads/modul/
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/modul', $newName);
            $file_url = $newName;
        } else if ($this->request->getPost('file_url') && empty($file_url)) {
            // Fallback jika hanya text URL yang diberikan
            $file_url = $this->request->getPost('file_url');
        }

        $data = [
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'file_url' => $file_url,
            'id_jadwal' => $this->request->getPost('id_jadwal')
        ];

        $this->modulPraktikumModel->save($data);

        return redirect()->to('/modul_praktikum_admin')
                         ->with('success', 'Modul praktikum berhasil ditambahkan.');
    }

    // 🟡 UPDATE
    public function update($id)
    {
        $modul = $this->modulPraktikumModel->find($id);
        if (!$modul) {
            return redirect()->to('/modul_praktikum_admin')
                             ->with('error', 'Data modul praktikum tidak ditemukan.');
        }

        $file = $this->request->getFile('file_modul');
        $file_url = $modul['file_url']; // Keep existing file by default

        // Validasi dan handle file upload jika ada file baru
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Validasi tipe file (PDF only)
            if ($file->getMimeType() !== 'application/pdf') {
                return redirect()->to('/modul_praktikum_admin')
                                 ->with('error', 'Hanya file PDF yang diperbolehkan.');
            }

            // Validasi ukuran file (max 10MB)
            if ($file->getSize() > 10 * 1024 * 1024) {
                return redirect()->to('/modul_praktikum_admin')
                                 ->with('error', 'Ukuran file maksimal 10MB.');
            }

            // Hapus file lama jika ada
            if (!empty($modul['file_url'])) {
                $oldPath = WRITEPATH . 'uploads/modul/' . $modul['file_url'];
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            // Move file baru ke folder uploads/modul/
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/modul', $newName);
            $file_url = $newName;
        } else if ($this->request->getPost('file_url') && $this->request->getPost('file_url') !== $modul['file_url']) {
            // Update hanya jika ada perubahan text URL
            $file_url = $this->request->getPost('file_url');
        }

        $data = [
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'file_url' => $file_url,
            'id_jadwal' => $this->request->getPost('id_jadwal')
        ];

        $this->modulPraktikumModel->update($id, $data);

        return redirect()->to('/modul_praktikum_admin')
                         ->with('success', 'Modul praktikum berhasil diperbarui.');
    }

    // 🔴 DELETE
    public function delete($id)
    {
        $modul = $this->modulPraktikumModel->find($id);
        
        // Hapus file jika ada
        if ($modul && !empty($modul['file_url'])) {
            $filePath = WRITEPATH . 'uploads/modul/' . $modul['file_url'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $this->modulPraktikumModel->delete($id);

        return redirect()->to('/modul_praktikum_admin')
                         ->with('success', 'Modul praktikum berhasil dihapus.');
    }

    // 🔍 GET ONE UNTUK EDIT FORM
    public function edit($id)
    {
        $modul = $this->modulPraktikumModel->find($id);

        if (!$modul) {
            return redirect()->to('/modul_praktikum_admin')
                             ->with('error', 'Data modul praktikum tidak ditemukan.');
        }

        $jadwalList = $this->jadwalModel->findAll();

        $data = [
            'title'  => 'Edit modul praktikum',
            'modul' => $modul,
            'jadwalList' => $jadwalList
        ];

        return view('modul_praktikum_edit_view', $data);
    }

    // 📥 DOWNLOAD FILE PDF
    public function download($filename)
    {
        $filePath = WRITEPATH . 'uploads/modul/' . basename($filename);

        // Validasi file exists
        if (!file_exists($filePath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('File tidak ditemukan');
        }

        // Validasi file extension
        if (!preg_match('/\.pdf$/i', $filePath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('File tidak valid');
        }

        return $this->response
                    ->setHeader('Content-Type', 'application/pdf')
                    ->setHeader('Content-Disposition', 'attachment; filename="' . basename($filePath) . '"')
                    ->download($filePath, null);
    }

    // 👁️ PREVIEW FILE PDF
    public function preview($filename)
    {
        $filePath = WRITEPATH . 'uploads/modul/' . basename($filename);

        // Validasi file exists
        if (!file_exists($filePath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('File tidak ditemukan');
        }

        // Validasi file extension
        if (!preg_match('/\.pdf$/i', $filePath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('File tidak valid');
        }

        return $this->response
                    ->setHeader('Content-Type', 'application/pdf')
                    ->setHeader('Content-Disposition', 'inline; filename="' . basename($filePath) . '"')
                    ->download($filePath, null);
    }
}
