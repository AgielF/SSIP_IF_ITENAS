<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EventsModel;

class Events extends BaseController
{
    protected $eventsModel;

    public function __construct()
    {
        $this->eventsModel = new EventsModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Admin - Kelola Events',
            'events' => $this->eventsModel->findAll()
        ];

        return view('event_list_admin_view', $data);
    }

    public function new()
    {
        $data = [
            'title' => 'Admin - Tambah Event Baru'
        ];

        return view('admin/events/new', $data);
    }

    public function create()
    {
        $data = [
            'nama_event' => $this->request->getPost('nama_event'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'jenis' => $this->request->getPost('jenis'),
            'created_by' => session()->get('user')['id'] ?? 1,
        ];

        if ($this->eventsModel->insert($data)) {
            return redirect()->to('/admin/events')->with('success', 'Event berhasil ditambahkan');
        }

        return redirect()->back()->with('error', 'Gagal menambahkan event');
    }

    public function edit($id)
    {
        $event = $this->eventsModel->find($id);

        if (!$event) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title' => 'Admin - Edit Event',
            'event' => $event
        ];

        return view('admin/events/edit', $data);
    }

    public function update($id)
    {
        $data = [
            'nama_event' => $this->request->getPost('nama_event'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'jenis' => $this->request->getPost('jenis'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->eventsModel->update($id, $data)) {
            return redirect()->to('/admin/events')->with('success', 'Event berhasil diupdate');
        }

        return redirect()->back()->with('error', 'Gagal mengupdate event');
    }

    public function delete($id)
    {
        if ($this->eventsModel->delete($id)) {
            return redirect()->to('/admin/events')->with('success', 'Event berhasil dihapus');
        }

        return redirect()->back()->with('error', 'Gagal menghapus event');
    }
}