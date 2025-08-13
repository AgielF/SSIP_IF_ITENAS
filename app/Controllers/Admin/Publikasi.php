<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PublikasiModel;
use App\Models\UserModel;

class Publikasi extends BaseController
{
    protected $publikasiModel;
    protected $userModel;

    public function __construct()
    {
        $this->publikasiModel = new PublikasiModel();
        $this->userModel = new UserModel();
    }

    //Menampilkan daftar publikasi
    public function index()
    {
        $data = [
            'title' => 'Manajemen Publikasi',
            'publikasis' => $this->publikasiModel->select('publikasi.*, users.nama as creator')
                ->join('users', 'users.id = publikasi.id_user')
                ->findAll()
        ];

        return view('admin/publikasi/index', $data);
    }

    //Menampilkan form untuk membuat publikasi baru
    public function new()
    {
        $data = [
            'title' => 'Tambah Publikasi Baru',
            'users' => $this->userModel->findAll()
        ];

        return view('admin/publikasi/create', $data);
    }

    //Menyimpan publikasi baru
    public function create()
    {
        $data = [
            'jenis_publikasi' => $this->request->getPost('jenis_publikasi'),
            'link_publikasi' => $this->request->getPost('link_publikasi'),
            'kategori' => $this->request->getPost('kategori'),
            'tanggal_publikasi' => $this->request->getPost('tanggal_publikasi'),
            'id_user' => $this->request->getPost('id_user'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->publikasiModel->save($data)) {
            return redirect()->to('/admin/publikasi')->with('success', 'Publikasi berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan publikasi')->withInput();
        }
    }

    //Menampilkan form untuk mengedit publikasi
    public function edit($id)
    {
        $publikasi = $this->publikasiModel->find($id);
        if (!$publikasi) {
            return redirect()->to('/admin/publikasi')->with('error', 'Publikasi tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Publikasi',
            'publikasi' => $publikasi,
            'users' => $this->userModel->findAll()
        ];

        return view('admin/publikasi/edit', $data);
    }

    //Memperbarui publikasi
    public function update($id)
    {
        $data = [
            'jenis_publikasi' => $this->request->getPost('jenis_publikasi'),
            'link_publikasi' => $this->request->getPost('link_publikasi'),
            'kategori' => $this->request->getPost('kategori'),
            'tanggal_publikasi' => $this->request->getPost('tanggal_publikasi'),
            'id_user' => $this->request->getPost('id_user'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->publikasiModel->update($id, $data)) {
            return redirect()->to('/admin/publikasi')->with('success', 'Publikasi berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui publikasi')->withInput();
        }
    }

    //Menghapus publikasi
    public function delete($id)
    {
        if ($this->publikasiModel->delete($id)) {
            return redirect()->to('/admin/publikasi')->with('success', 'Publikasi berhasil dihapus');
        } else {
            return redirect()->to('/admin/publikasi')->with('error', 'Gagal menghapus publikasi');
        }
    }
}