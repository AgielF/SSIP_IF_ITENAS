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
        $this->jadwalModel=new jadwalModel();

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
        $data = [
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'file_url' => $this->request->getPost('file_url'),
            'id_jadwal' => $this->request->getPost('id_jadwal')
        ];

        $this->modulPraktikumModel->save($data);

        return redirect()->to('/modul_praktikum_admin')
                         ->with('success', 'Proyek riset berhasil ditambahkan.');
    }

    // 🟡 UPDATE
    public function update($id)
    {
         $data = [
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'file_url' => $this->request->getPost('file_url'),
            'id_jadwal' => $this->request->getPost('id_jadwal')
        ];

        $this->modulPraktikumModel->update($id, $data);

        return redirect()->to('/modul_praktikum_admin')
                         ->with('success', 'Proyek riset berhasil diperbarui.');
    }

    // 🔴 DELETE
    public function delete($id)
    {
        $this->modulPraktikumModel->delete($id);

        return redirect()->to('/modul_praktium_admin')
                         ->with('success', 'Proyek riset berhasil dihapus.');
    }

    // 🔍 GET ONE UNTUK EDIT FORM
    public function edit($id)
    {
        $proyek = $this->modulPraktikumModel->find($id);

        if (!$proyek) {
            return redirect()->to('/modul_praktium_admin')
                             ->with('error', 'Data proyek riset tidak ditemukan.');
        }

        $data = [
            'title'  => 'Edit modul praktikum',
            'proyek' => $proyek
        ];

        return view('modul_praktikum_list_admin_view', $data);
    }
}
