<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PesertaPraktikumModel;
use App\Models\UserModel;
use App\Models\JadwalModel;

class PesertaPraktikum extends BaseController
{
    protected $pesertaPraktikumModel;
    protected $userModel;
    protected $jadwalModel;

    public function __construct()
    {
        $this->pesertaPraktikumModel = new PesertaPraktikumModel();
        $this->userModel = new UserModel();
        $this->jadwalModel = new JadwalModel();
    }

    //Menampilkan daftar peserta praktikum
    public function index()
    {
        $data = [
            'title' => 'Manajemen Peserta Praktikum',
            'pesertaPraktikums' => $this->pesertaPraktikumModel->select('peserta_praktikum.*, users.nama as peserta, jadwal.tanggal as jadwal_tanggal')
                ->join('users', 'users.id = peserta_praktikum.id_user')
                ->join('jadwal', 'jadwal.id_jadwal = peserta_praktikum.id_jadwal')
                ->findAll()
        ];

        return view('admin/peserta_praktikum/index', $data);
    }

    //Menampilkan form untuk membuat peserta praktikum baru
    public function new()
    {
        $data = [
            'title' => 'Tambah Peserta Praktikum Baru',
            'users' => $this->userModel->where('role_id', 4)->findAll(), // Hanya praktikan
            'jadwals' => $this->jadwalModel->findAll()
        ];

        return view('admin/peserta_praktikum/create', $data);
    }

    //Menyimpan peserta praktikum baru
    public function create()
    {
        $data = [
            'id_user' => $this->request->getPost('id_user'),
            'id_jadwal' => $this->request->getPost('id_jadwal'),
            'status' => $this->request->getPost('status'),
            'nilai' => $this->request->getPost('nilai')
        ];

        if ($this->pesertaPraktikumModel->save($data)) {
            return redirect()->to('/admin/peserta-praktikum')->with('success', 'Peserta praktikum berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan peserta praktikum')->withInput();
        }
    }

    //Menampilkan form untuk mengedit peserta praktikum
    public function edit($id)
    {
        $pesertaPraktikum = $this->pesertaPraktikumModel->find($id);
        if (!$pesertaPraktikum) {
            return redirect()->to('/admin/peserta-praktikum')->with('error', 'Peserta praktikum tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Peserta Praktikum',
            'pesertaPraktikum' => $pesertaPraktikum,
            'users' => $this->userModel->where('role_id', 4)->findAll(), // Hanya praktikan
            'jadwals' => $this->jadwalModel->findAll()
        ];

        return view('admin/peserta_praktikum/edit', $data);
    }

    //Memperbarui peserta praktikum
    public function update($id)
    {
        $data = [
            'id_user' => $this->request->getPost('id_user'),
            'id_jadwal' => $this->request->getPost('id_jadwal'),
            'status' => $this->request->getPost('status'),
            'nilai' => $this->request->getPost('nilai')
        ];

        if ($this->pesertaPraktikumModel->update($id, $data)) {
            return redirect()->to('/admin/peserta-praktikum')->with('success', 'Peserta praktikum berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui peserta praktikum')->withInput();
        }
    }

    //Menghapus peserta praktikum
    public function delete($id)
    {
        if ($this->pesertaPraktikumModel->delete($id)) {
            return redirect()->to('/admin/peserta-praktikum')->with('success', 'Peserta praktikum berhasil dihapus');
        } else {
            return redirect()->to('/admin/peserta-praktikum')->with('error', 'Gagal menghapus peserta praktikum');
        }
    }
}