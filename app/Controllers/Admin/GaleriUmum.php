<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GaleriUmumModel;
use App\Models\UserModel;

class GaleriUmum extends BaseController
{
    protected $galeriUmumModel;
    protected $userModel;

    public function __construct()
    {
        $this->galeriUmumModel = new GaleriUmumModel();
        $this->userModel = new UserModel();
    }

    //Menampilkan daftar galeri umum
    public function index()
    {
        $data = [
            'title' => 'Manajemen Galeri Umum',
            'galeriUmums' => $this->galeriUmumModel->select('galeri_umum.*, users.nama as creator')
                ->join('users', 'users.id = galeri_umum.id_user')
                ->findAll()
        ];

        return view('admin/galeri_umum/index', $data);
    }

    //Menampilkan form untuk membuat galeri umum baru
    public function new()
    {
        $data = [
            'title' => 'Tambah Galeri Umum Baru',
            'users' => $this->userModel->findAll()
        ];

        return view('admin/galeri_umum/create', $data);
    }

    //Menyimpan galeri umum baru
    public function create()
    {
        $data = [
            'kategori' => $this->request->getPost('kategori'),
            'keterangan' => $this->request->getPost('keterangan'),
            'file_url' => $this->request->getPost('file_url'),
            'tanggal_upload' => $this->request->getPost('tanggal_upload'),
            'id_user' => $this->request->getPost('id_user')
        ];

        if ($this->galeriUmumModel->save($data)) {
            return redirect()->to('/admin/galeri-umum')->with('success', 'Galeri umum berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan galeri umum')->withInput();
        }
    }

    //Menampilkan form untuk mengedit galeri umum
    public function edit($id)
    {
        $galeriUmum = $this->galeriUmumModel->find($id);
        if (!$galeriUmum) {
            return redirect()->to('/admin/galeri-umum')->with('error', 'Galeri umum tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Galeri Umum',
            'galeriUmum' => $galeriUmum,
            'users' => $this->userModel->findAll()
        ];

        return view('admin/galeri_umum/edit', $data);
    }

    //Memperbarui galeri umum
    public function update($id)
    {
        $data = [
            'kategori' => $this->request->getPost('kategori'),
            'keterangan' => $this->request->getPost('keterangan'),
            'file_url' => $this->request->getPost('file_url'),
            'tanggal_upload' => $this->request->getPost('tanggal_upload'),
            'id_user' => $this->request->getPost('id_user')
        ];

        if ($this->galeriUmumModel->update($id, $data)) {
            return redirect()->to('/admin/galeri-umum')->with('success', 'Galeri umum berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui galeri umum')->withInput();
        }
    }

    //Menghapus galeri umum
    public function delete($id)
    {
        if ($this->galeriUmumModel->delete($id)) {
            return redirect()->to('/admin/galeri-umum')->with('success', 'Galeri umum berhasil dihapus');
        } else {
            return redirect()->to('/admin/galeri-umum')->with('error', 'Gagal menghapus galeri umum');
        }
    }
}