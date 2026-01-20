<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AsistenJadwalModel;
use App\Models\JadwalModel;
use App\Models\UserModel;

class AsistenJadwal extends BaseController
{
    protected $asistenJadwalModel;
    protected $jadwalModel;
    protected $userModel;

    public function __construct()
    {
        $this->asistenJadwalModel = new AsistenJadwalModel();
        $this->jadwalModel = new JadwalModel();
        $this->userModel = new UserModel();
    }

    //Menampilkan daftar asisten jadwal
    public function index()
    {
        $data = [
            'title' => 'Manajemen Asisten Jadwal',
            'asistenJadwals' => $this->asistenJadwalModel->select('asisten_jadwal.*, jadwal.tanggal, users.nama as asisten_nama')
                ->join('jadwal', 'jadwal.id_jadwal = asisten_jadwal.id_jadwal')
                ->join('users', 'users.id = asisten_jadwal.id_user')
                ->findAll()
        ];

        return view('admin/asisten_jadwal/index', $data);
    }

    //Menampilkan form untuk membuat asisten jadwal baru
    public function new()
    {
        $data = [
            'title' => 'Tambah Asisten Jadwal Baru',
            'jadwals' => $this->jadwalModel->findAll(),
            'users' => $this->userModel->where('role_id', 2)->findAll() // Hanya asisten lab
        ];

        return view('admin/asisten_jadwal/create', $data);
    }

    //Menyimpan asisten jadwal baru
    public function create()
    {
        $data = [
            'id_jadwal' => $this->request->getPost('id_jadwal'),
            'id_user' => $this->request->getPost('id_user'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->asistenJadwalModel->save($data)) {
            return redirect()->to('/admin/asisten-jadwal')->with('success', 'Asisten jadwal berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan asisten jadwal')->withInput();
        }
    }

    //Menampilkan form untuk mengedit asisten jadwal
    public function edit($id)
    {
        $asistenJadwal = $this->asistenJadwalModel->find($id);
        if (!$asistenJadwal) {
            return redirect()->to('/admin/asisten-jadwal')->with('error', 'Asisten jadwal tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Asisten Jadwal',
            'asistenJadwal' => $asistenJadwal,
            'jadwals' => $this->jadwalModel->findAll(),
            'users' => $this->userModel->where('role_id', 2)->findAll() // Hanya asisten lab
        ];

        return view('admin/asisten_jadwal/edit', $data);
    }

    //Memperbarui asisten jadwal
    public function update($id)
    {
        $data = [
            'id_jadwal' => $this->request->getPost('id_jadwal'),
            'id_user' => $this->request->getPost('id_user'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->asistenJadwalModel->update($id, $data)) {
            return redirect()->to('/admin/asisten-jadwal')->with('success', 'Asisten jadwal berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui asisten jadwal')->withInput();
        }
    }

    //Menghapus asisten jadwal
    public function delete($id)
    {
        if ($this->asistenJadwalModel->delete($id)) {
            return redirect()->to('/admin/asisten-jadwal')->with('success', 'Asisten jadwal berhasil dihapus');
        } else {
            return redirect()->to('/admin/asisten-jadwal')->with('error', 'Gagal menghapus asisten jadwal');
        }
    }
}