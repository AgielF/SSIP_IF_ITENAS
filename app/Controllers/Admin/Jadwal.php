<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JadwalModel;
use App\Models\EventsModel;

class Jadwal extends BaseController
{
    protected $jadwalModel;
    protected $eventModel;

    public function __construct()
    {
        $this->jadwalModel = new JadwalModel();
        $this->eventModel = new EventsModel();
    }

    //Menampilkan daftar jadwal
    public function index()
    {
        $data = [
            'title' => 'Manajemen Jadwal',
            'jadwals' => $this->jadwalModel->getJadwalWithDetails()
        ];

        return view('admin/jadwal/index', $data);
    }

    //Menampilkan form untuk membuat jadwal baru
    public function new()
    {
        $data = [
            'title' => 'Tambah Jadwal Baru',
            'events' => $this->eventModel->findAll()
        ];

        return view('admin/jadwal/create', $data);
    }

    //Menyimpan jadwal baru
    public function create()
    {
        $data = [
            'id_event' => $this->request->getPost('id_event'),
            'tanggal' => $this->request->getPost('tanggal'),
            'waktu_mulai' => $this->request->getPost('waktu_mulai'),
            'waktu_selesai' => $this->request->getPost('waktu_selesai'),
            'ruangan' => $this->request->getPost('ruangan'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->jadwalModel->save($data)) {
            return redirect()->to('/admin/jadwal')->with('success', 'Jadwal berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan jadwal')->withInput();
        }
    }

    //Menampilkan form untuk mengedit jadwal
    public function edit($id)
    {
        $jadwal = $this->jadwalModel->find($id);
        if (!$jadwal) {
            return redirect()->to('/admin/jadwal')->with('error', 'Jadwal tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Jadwal',
            'jadwal' => $jadwal,
            'events' => $this->eventModel->findAll()
        ];

        return view('admin/jadwal/edit', $data);
    }

    //Memperbarui jadwal
    public function update($id)
    {
        $data = [
            'id_event' => $this->request->getPost('id_event'),
            'tanggal' => $this->request->getPost('tanggal'),
            'waktu_mulai' => $this->request->getPost('waktu_mulai'),
            'waktu_selesai' => $this->request->getPost('waktu_selesai'),
            'ruangan' => $this->request->getPost('ruangan'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->jadwalModel->update($id, $data)) {
            return redirect()->to('/admin/jadwal')->with('success', 'Jadwal berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui jadwal')->withInput();
        }
    }

    //Menghapus jadwal
    public function delete($id)
    {
        if ($this->jadwalModel->delete($id)) {
            return redirect()->to('/admin/jadwal')->with('success', 'Jadwal berhasil dihapus');
        } else {
            return redirect()->to('/admin/jadwal')->with('error', 'Gagal menghapus jadwal');
        }
    }
}