<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ModulPraktikumModel;
use App\Models\JadwalModel;

class ModulPraktikum extends BaseController
{
    protected $modulPraktikumModel;
    protected $jadwalModel;

    public function __construct()
    {
        $this->modulPraktikumModel = new ModulPraktikumModel();
        $this->jadwalModel = new JadwalModel();
    }

    //Menampilkan daftar modul praktikum
    public function index()
    {
        $data = [
            'title' => 'Manajemen Modul Praktikum',
            'modulPraktikums' => $this->modulPraktikumModel->select('modul_praktikum.*, jadwal.tanggal as jadwal_tanggal')
                ->join('jadwal', 'jadwal.id_jadwal = modul_praktikum.id_jadwal')
                ->findAll()
        ];

        return view('admin/modul_praktikum/index', $data);
    }

    //Menampilkan form untuk membuat modul praktikum baru
    public function new()
    {
        $data = [
            'title' => 'Tambah Modul Praktikum Baru',
            'jadwals' => $this->jadwalModel->findAll()
        ];

        return view('admin/modul_praktikum/create', $data);
    }

    //Menyimpan modul praktikum baru
    public function create()
    {
        $data = [
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'file_url' => $this->request->getPost('file_url'),
            'id_jadwal' => $this->request->getPost('id_jadwal'),
        ];

        if ($this->modulPraktikumModel->save($data)) {
            return redirect()->to('/admin/modul-praktikum')->with('success', 'Modul praktikum berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan modul praktikum')->withInput();
        }
    }

    //Menampilkan form untuk mengedit modul praktikum
    public function edit($id)
    {
        $modulPraktikum = $this->modulPraktikumModel->find($id);
        if (!$modulPraktikum) {
            return redirect()->to('/admin/modul-praktikum')->with('error', 'Modul praktikum tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Modul Praktikum',
            'modulPraktikum' => $modulPraktikum,
            'jadwals' => $this->jadwalModel->findAll()
        ];

        return view('admin/modul_praktikum/edit', $data);
    }

    //Memperbarui modul praktikum
    public function update($id)
    {
        $data = [
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'file_url' => $this->request->getPost('file_url'),
            'id_jadwal' => $this->request->getPost('id_jadwal')
        ];

        if ($this->modulPraktikumModel->update($id, $data)) {
            return redirect()->to('/admin/modul-praktikum')->with('success', 'Modul praktikum berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui modul praktikum')->withInput();
        }
    }

    //Menghapus modul praktikum
    public function delete($id)
    {
        if ($this->modulPraktikumModel->delete($id)) {
            return redirect()->to('/admin/modul-praktikum')->with('success', 'Modul praktikum berhasil dihapus');
        } else {
            return redirect()->to('/admin/modul-praktikum')->with('error', 'Gagal menghapus modul praktikum');
        }
    }
}