<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProyekRisetModel;
use App\Models\UserModel;

class ProyekRiset extends BaseController
{
    protected $proyekRisetModel;
    protected $userModel;

    public function __construct()
    {
        $this->proyekRisetModel = new ProyekRisetModel();
        $this->userModel = new UserModel();
    }

    //Menampilkan daftar proyek riset
    public function index()
    {
        $data = [
            'title' => 'Manajemen Proyek Riset',
            'proyek' => $this->proyekRisetModel->select('proyek_riset.*, users.nama as penanggung_jawab')
                ->join('users', 'users.id = proyek_riset.id_user')
                ->findAll()
        ];

        return view('admin/proyek_riset/index', $data);
    }

    //Menampilkan form untuk membuat proyek riset baru
    public function new()
    {
        $data = [
            'title' => 'Tambah Proyek Riset Baru',
            'users' => $this->userModel->findAll()
        ];

        return view('admin/proyek_riset/create', $data);
    }

    //Menyimpan proyek riset baru
    public function create()
    {
        $data = [
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'mitra' => $this->request->getPost('mitra'),
            'sumber_dana' => $this->request->getPost('sumber_dana'),
            'tahun_mulai' => $this->request->getPost('tahun_mulai'),
            'tahun_selesai' => $this->request->getPost('tahun_selesai'),
            'id_user' => $this->request->getPost('id_user'),
        ];

        if ($this->proyekRisetModel->save($data)) {
            return redirect()->to('/admin/proyek-riset')->with('success', 'Proyek riset berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan proyek riset')->withInput();
        }
    }

    // Menampilkan form untuk mengedit proyek riset
     
    public function edit($id)
    {
        $proyek = $this->proyekRisetModel->find($id);
        if (!$proyek) {
            return redirect()->to('/admin/proyek-riset')->with('error', 'Proyek riset tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Proyek Riset',
            'proyek' => $proyek,
            'users' => $this->userModel->findAll()
        ];

        return view('admin/proyek_riset/edit', $data);
    }

    // Memperbarui proyek riset
    public function update($id)
    {
        $data = [
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'mitra' => $this->request->getPost('mitra'),
            'sumber_dana' => $this->request->getPost('sumber_dana'),
            'tahun_mulai' => $this->request->getPost('tahun_mulai'),
            'tahun_selesai' => $this->request->getPost('tahun_selesai'),
            'id_user' => $this->request->getPost('id_user'),
        ];

        if ($this->proyekRisetModel->update($id, $data)) {
            return redirect()->to('/admin/proyek-riset')->with('success', 'Proyek riset berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui proyek riset')->withInput();
        }
    }

    // Menghapus proyek riset
    public function delete($id)
    {
        if ($this->proyekRisetModel->delete($id)) {
            return redirect()->to('/admin/proyek-riset')->with('success', 'Proyek riset berhasil dihapus');
        } else {
            return redirect()->to('/admin/proyek-riset')->with('error', 'Gagal menghapus proyek riset');
        }
    }
}