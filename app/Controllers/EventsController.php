<?php

namespace App\Controllers;

use App\Models\EventsModel;
use App\Models\UserModel;
use App\Controllers\BaseController;

class EventsController extends BaseController
{
    protected $eventModel;
    protected $userModel;

    public function __construct()
    {
        $this->eventModel = new EventsModel();
        $this->userModel  = new UserModel();
    }

    // Halaman utama list events
    public function index()
    {
        $events = $this->eventModel
            ->select('events.*, users.nama as creator')
            ->join('users', 'users.id = events.created_by', 'left')
            ->orderBy('events.created_at', 'DESC')
            ->findAll();

        $users = $this->userModel->findAll(); // untuk dropdown "Created By"

        return view('event_list_view', [
            'title'  => 'Kelola Events',
            'events' => $events,
            'users'  => $users
        ]);
    }
    // Halaman utama list events
    public function admin()
{
    $events = $this->eventModel
        ->select('events.*, users.nama as creator')
        ->join('users', 'users.id = events.created_by', 'left') // join ke users
        ->orderBy('events.created_at', 'DESC')
        ->findAll();

    $users = $this->userModel->findAll();

    return view('event_list_admin_view', [
        'title'  => 'Kelola Events',
        'events' => $events,
        'users'  => $users
    ]);
}

    // Simpan event baru
    public function store()
    {
        // 🛡️ 1. VALIDASI INPUT
        $rules = [
            'nama_event' => 'required|max_length[50]',
            'deskripsi'  => 'required',
            'jenis'      => 'required|max_length[50]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Format data tidak valid: ' . implode(', ', $this->validator->getErrors()));
        }

        // 🛡️ 2. TRY-CATCH ERROR HANDLING
        try {
            $userId = $this->getUserIdOrRedirect();
            $data = [
                'nama_event' => $this->request->getPost('nama_event'),
                'deskripsi'  => $this->request->getPost('deskripsi'),
                'jenis'      => $this->request->getPost('jenis'),
                'created_by' => $userId,
            ];

            $this->eventModel->save($data);
            return redirect()->to('/events_admin')->with('success', 'Event berhasil ditambahkan');

        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat menyimpan event.');
        }
    }

    // Update event
    public function update($id)
    {
        // 🛡️ PASTIKAN ID NUMERIC
        if (!is_numeric($id)) {
            return redirect()->to('/events_admin')->with('error', 'ID Event tidak valid.');
        }

        // 🛡️ 1. VALIDASI INPUT
        $rules = [
            'nama_event' => 'required|max_length[50]',
            'deskripsi'  => 'required',
            'jenis'      => 'required|max_length[50]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Format data tidak valid: ' . implode(', ', $this->validator->getErrors()));
        }

        // 🛡️ 2. TRY-CATCH ERROR HANDLING
        try {
            $userId = $this->getUserIdOrRedirect();
            $data = [
                'nama_event' => $this->request->getPost('nama_event'),
                'deskripsi'  => $this->request->getPost('deskripsi'),
                'jenis'      => $this->request->getPost('jenis'),
                'created_by' => $userId,
            ];

            $this->eventModel->update($id, $data);
            return redirect()->to('/events_admin')->with('success', 'Event berhasil diperbarui');

        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat memperbarui event.');
        }
    }

    // Hapus event
    public function delete($id)
{
    if (!is_numeric($id)) return redirect()->to('/events_admin')->with('error', 'ID tidak valid');
    try {
        $this->eventModel->delete($id);
        return redirect()->to('/events_admin')->with('success', 'Event berhasil dihapus');
    } catch (\Throwable $e) {
        return redirect()->to('/events_admin')->with('error', 'Gagal menghapus event.');
    }
}
}
