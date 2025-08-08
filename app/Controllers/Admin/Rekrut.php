<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RekrutModel;
use App\Models\UserModel;
use App\Models\JadwalModel;

class Rekrut extends BaseController
{
    protected $rekrutModel;
    protected $userModel;
    protected $jadwalModel;

    public function __construct()
    {
        $this->rekrutModel = new RekrutModel();
        $this->userModel = new UserModel();
        $this->jadwalModel = new JadwalModel();
    }
    //Menampilkan daftar rekrutmen
    public function index()
    {
        $data = [
            'title' => 'Manajemen Rekrutmen Asisten Lab',
            'rekrutmen' => $this->rekrutModel->select('rekrut.*, users.nama as pembuat, jadwal.tanggal')
                ->join('users', 'users.id = rekrut.id_user')
                ->join('jadwal', 'jadwal.id_jadwal = rekrut.id_jadwal')
                ->findAll()
        ];

        return view('admin/rekrut/index', $data);
    }
    //Menampilkan form untuk membuat rekrutmen baru
    public function new()
    {
        $data = [
            'title' => 'Tambah Rekrutmen Baru',
            'users' => $this->userModel->findAll(),
            'jadwals' => $this->jadwalModel->findAll()
        ];

        return view('admin/rekrut/create', $data);
    }

    //Menyimpan rekrutmen baru
    public function create()
    {
        $data = [
            'id_user' => $this->request->getPost('id_user'),
            'id_jadwal' => $this->request->getPost('id_jadwal'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'status' => $this->request->getPost('status'),
            'syarat' => $this->request->getPost('syarat'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->rekrutModel->save($data)) {
            return redirect()->to('/admin/rekrut')->with('success', 'Rekrutmen berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan rekrutmen')->withInput();
        }
    }

    //Menampilkan form untuk mengedit rekrutmen
    public function edit($id)
    {
        $rekrut = $this->rekrutModel->find($id);
        if (!$rekrut) {
            return redirect()->to('/admin/rekrut')->with('error', 'Rekrutmen tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Rekrutmen',
            'rekrut' => $rekrut,
            'users' => $this->userModel->findAll(),
            'jadwals' => $this->jadwalModel->findAll()
        ];

        return view('admin/rekrut/edit', $data);
    }

    //Memperbarui rekrutmen
    public function update($id)
    {
        $data = [
            'id_user' => $this->request->getPost('id_user'),
            'id_jadwal' => $this->request->getPost('id_jadwal'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'status' => $this->request->getPost('status'),
            'syarat' => $this->request->getPost('syarat'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->rekrutModel->update($id, $data)) {
            return redirect()->to('/admin/rekrut')->with('success', 'Rekrutmen berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui rekrutmen')->withInput();
        }
    }

    //Menghapus rekrutmen
    public function delete($id)
    {
        if ($this->rekrutModel->delete($id)) {
            return redirect()->to('/admin/rekrut')->with('success', 'Rekrutmen berhasil dihapus');
        } else {
            return redirect()->to('/admin/rekrut')->with('error', 'Gagal menghapus rekrutmen');
        }
    }
}