<?php

namespace App\Controllers;

use App\Models\EventModel;
use App\Models\UserModel;
use App\Controllers\BaseController;

class EventsController extends BaseController
{
    protected $eventModel;
    protected $usersModel;

    public function __construct()
    {
        $this->eventModel = new EventModel();
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
        $userId = $this->getUserIdOrRedirect(); // ✅ langsung ambil id user 
        $data = [
            'nama_event' => $this->request->getPost('nama_event'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'jenis'      => $this->request->getPost('jenis'),
            'created_by' => $userId,
        ];

        if ($this->eventModel->save($data)) {
            return redirect()->to('/events_admin')->with('success', 'Event berhasil ditambahkan');
        }

        return redirect()->back()->with('error', 'Gagal menambahkan event');
    }

    // Update event
    public function update($id)
{
    $userId = $this->getUserIdOrRedirect(); // ambil user login
    
    $data = [
        'nama_event' => $this->request->getPost('nama_event'),
        'deskripsi'  => $this->request->getPost('deskripsi'),
        'jenis'      => $this->request->getPost('jenis'),
        'created_by' => $userId, // ⚡ timpa created_by
    ];

    if ($this->eventModel->update($id, $data)) {
        return redirect()->to('/events_admin')->with('success', 'Event berhasil diperbarui');
    }

    return redirect()->back()->with('error', 'Gagal memperbarui event');
}


    // Hapus event
    public function delete($id)
    {
        if ($this->eventModel->delete($id)) {
            return redirect()->to('/events_admin')->with('success', 'Event berhasil dihapus');
        }

        return redirect()->back()->with('error', 'Gagal menghapus event');
    }
}
