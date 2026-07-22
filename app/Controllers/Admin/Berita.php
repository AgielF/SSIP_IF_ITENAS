<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BeritaModel;
use App\Models\UserModel;

class Berita extends BaseController
{
    protected $beritaModel;
    protected $userModel;

    public function __construct()
    {
        $this->beritaModel = new BeritaModel();
        $this->userModel = new UserModel();
    }

    //Menampilkan daftar berita
    public function index()
    {
        $data = [
            'title' => 'Manajemen Berita',
            'beritas' => $this->beritaModel->select('berita.*, users.nama as creator')
                ->join('users', 'users.id = berita.id_user')
                ->findAll()
        ];

        return view('admin/berita/index', $data);
    }

    //Menampilkan form untuk membuat berita baru
    public function new()
    {
        $data = [
            'title' => 'Tambah Berita Baru',
            'users' => $this->userModel->findAll()
        ];

        return view('admin/berita/create', $data);
    }

    //Menyimpan berita baru
    public function create()
    {
        $data = [
            'judul' => $this->request->getPost('judul'),
            'konten' => $this->request->getPost('konten'),
            'kategori' => $this->request->getPost('kategori'),
            'tanggal' => $this->request->getPost('tanggal'),
            'id_user' => $this->request->getPost('id_user'),
        ];

        if ($this->beritaModel->save($data)) {
            return redirect()->to('/admin/berita')->with('success', 'Berita berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan berita')->withInput();
        }
    }

    //Menampilkan form untuk mengedit berita
    public function edit($id)
    {
        $berita = $this->beritaModel->find($id);
        if (!$berita) {
            return redirect()->to('/admin/berita')->with('error', 'Berita tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Berita',
            'berita' => $berita,
            'users' => $this->userModel->findAll()
        ];

        return view('admin/berita/edit', $data);
    }

    //Memperbarui berita
    public function update($id)
    {
        $data = [
            'judul' => $this->request->getPost('judul'),
            'konten' => $this->request->getPost('konten'),
            'kategori' => $this->request->getPost('kategori'),
            'tanggal' => $this->request->getPost('tanggal'),
            'id_user' => $this->request->getPost('id_user'),
        ];

        if ($this->beritaModel->update($id, $data)) {
            return redirect()->to('/admin/berita')->with('success', 'Berita berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui berita')->withInput();
        }
    }

    //Menghapus berita
    public function delete($id)
    {
        if ($this->beritaModel->delete($id)) {
            return redirect()->to('/admin/berita')->with('success', 'Berita berhasil dihapus');
        } else {
            return redirect()->to('/admin/berita')->with('error', 'Gagal menghapus berita');
        }
    }
}