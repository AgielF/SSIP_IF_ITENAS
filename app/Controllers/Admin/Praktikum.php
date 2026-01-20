<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PraktikumModel;
use App\Models\UserModel;
use App\Models\JadwalModel;

class Praktikum extends BaseController
{
    protected $praktikumModel;
    protected $userModel;
    protected $jadwalModel;

    public function __construct()
    {
        $this->praktikumModel = new PraktikumModel();
        $this->userModel = new UserModel();
        $this->jadwalModel = new JadwalModel();
    }

    //Menampilkan daftar praktikum
    public function index()
    {
        $data = [
            'title' => 'Manajemen Praktikum',
            'praktikums' => $this->praktikumModel->select('praktikum.*, users.nama as peserta, jadwal.tanggal as jadwal_tanggal')
                ->join('users', 'users.id = praktikum.id_user')
                ->join('jadwal', 'jadwal.id_jadwal = praktikum.id_jadwal')
                ->findAll()
        ];

        return view('admin/praktikum/index', $data);
    }

    //Menampilkan form untuk membuat praktikum baru
    public function new()
    {
        $data = [
            'title' => 'Tambah Praktikum Baru',
            'users' => $this->userModel->where('role_id', 4)->findAll(), // Hanya praktikan
            'jadwals' => $this->jadwalModel->findAll()
        ];

        return view('admin/praktikum/create', $data);
    }

    //Menyimpan praktikum baru
    public function create()
    {
        $data = [
            'id_user' => $this->request->getPost('id_user'),
            'id_jadwal' => $this->request->getPost('id_jadwal'),
            'galeri_prak' => $this->request->getPost('galeri_prak'),
            'desc_aturan' => $this->request->getPost('desc_aturan'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->praktikumModel->save($data)) {
            return redirect()->to('/admin/praktikum')->with('success', 'Praktikum berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan praktikum')->withInput();
        }
    }

    //Menampilkan form untuk mengedit praktikum
    public function edit($id)
    {
        $praktikum = $this->praktikumModel->find($id);
        if (!$praktikum) {
            return redirect()->to('/admin/praktikum')->with('error', 'Praktikum tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Praktikum',
            'praktikum' => $praktikum,
            'users' => $this->userModel->where('role_id', 4)->findAll(), // Hanya praktikan
            'jadwals' => $this->jadwalModel->findAll()
        ];

        return view('admin/praktikum/edit', $data);
    }

    //Memperbarui praktikum
    public function update($id)
    {
        $data = [
            'id_user' => $this->request->getPost('id_user'),
            'id_jadwal' => $this->request->getPost('id_jadwal'),
            'galeri_prak' => $this->request->getPost('galeri_prak'),
            'desc_aturan' => $this->request->getPost('desc_aturan'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->praktikumModel->update($id, $data)) {
            return redirect()->to('/admin/praktikum')->with('success', 'Praktikum berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui praktikum')->withInput();
        }
    }

    //Menghapus praktikum
    public function delete($id)
    {
        if ($this->praktikumModel->delete($id)) {
            return redirect()->to('/admin/praktikum')->with('success', 'Praktikum berhasil dihapus');
        } else {
            return redirect()->to('/admin/praktikum')->with('error', 'Gagal menghapus praktikum');
        }
    }
}