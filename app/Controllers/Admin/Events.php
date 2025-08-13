<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EventModel;
use App\Models\UserModel;

class Events extends BaseController
{
    protected $eventModel;
    protected $userModel;

    public function __construct()
    {
        $this->eventModel = new EventModel();
        $this->userModel = new UserModel();
    }

    //Menampilkan daftar events
    public function index()
    {
        $data = [
            'title' => 'Manajemen Events',
            'events' => $this->eventModel->select('events.*, users.nama as creator')
                ->join('users', 'users.id = events.created_by')
                ->findAll()
        ];

        return view('admin/events/index', $data);
    }

    //Menampilkan form untuk membuat event baru
    public function new()
    {
        $data = [
            'title' => 'Tambah Event Baru',
            'users' => $this->userModel->findAll()
        ];

        return view('admin/events/create', $data);
    }

    //Menyimpan event baru
    public function create()
    {
        $data = [
            'nama_event' => $this->request->getPost('nama_event'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'jenis' => $this->request->getPost('jenis'),
            'created_by' => $this->request->getPost('created_by'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->eventModel->save($data)) {
            return redirect()->to('/admin/events')->with('success', 'Event berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Gagal menambahkan event')->withInput();
        }
    }

    //Menampilkan form untuk mengedit event
    public function edit($id)
    {
        $event = $this->eventModel->find($id);
        if (!$event) {
            return redirect()->to('/admin/events')->with('error', 'Event tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Event',
            'event' => $event,
            'users' => $this->userModel->findAll()
        ];

        return view('admin/events/edit', $data);
    }

    //Memperbarui event
    public function update($id)
    {
        $data = [
            'nama_event' => $this->request->getPost('nama_event'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'jenis' => $this->request->getPost('jenis'),
            'created_by' => $this->request->getPost('created_by'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->eventModel->update($id, $data)) {
            return redirect()->to('/admin/events')->with('success', 'Event berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui event')->withInput();
        }
    }

    //Menghapus event
    public function delete($id)
    {
        if ($this->eventModel->delete($id)) {
            return redirect()->to('/admin/events')->with('success', 'Event berhasil dihapus');
        } else {
            return redirect()->to('/admin/events')->with('error', 'Gagal menghapus event');
        }
    }
}