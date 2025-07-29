<?php

namespace App\Controllers;

use App\Models\EventsModel;

class EventsController extends BaseController
{
    /**
     * Menampilkan daftar semua event.
     */
    public function index()
    {
        $eventModel = new EventsModel();
        $data = [
            'title'  => 'Daftar Event',
            'events' => $eventModel->findAll()
        ];
        return view('events/index', $data);
    }

    /**
     * Menyimpan event baru.
     */
    public function create()
    {
        $eventModel = new EventsModel();
        $data = [
            'nama_event' => $this->request->getPost('nama_event'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'jenis'      => $this->request->getPost('jenis'),
        ];
        $eventModel->insert($data);
        return redirect()->to('/events');
    }

    // Method lain seperti edit, update, dan delete bisa ditambahkan di sini.
}
