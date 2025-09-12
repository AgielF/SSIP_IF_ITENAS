<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RekrutModel;
use App\Models\JadwalModel;

class RekrutController extends BaseController
{
    /**
     * Menampilkan halaman rekrutmen publik.
     */
    public function index()
    {
        $rekrutModel = new RekrutModel();

        $data = [
            'title'     => 'Informasi Rekrutmen',
            'rekrutmen' => $rekrutModel->index()
        ];

        return view('rekrutmen_view', $data);
    }

    /**
     * Halaman admin untuk kelola rekrutmen.
     */
    public function admin()
    {
        $rekrutModel = new RekrutModel();
        $jadwalModel = new JadwalModel();

        $data = [
            'title'     => 'Admin: Kelola Rekrutmen',
            'rekrutmen' => $rekrutModel->getDataAdmin()['rekrutmen'],
            'jadwal'    => $jadwalModel
                            ->select('jadwal.*, events.nama_event')
                            ->join('events', 'events.id_event = jadwal.id_event', 'left')
                            ->findAll()
        ];

        return view('rekrutmen_admin_view', $data);
    }

    /**
     * Tambah data.
     */
    public function store()
    {
        $rekrutModel = new RekrutModel();

        $data = [
            'id_user'    => 1, // sementara hardcode user
            'id_jadwal'  => $this->request->getPost('id_jadwal'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'status'     => $this->request->getPost('status'),
            'syarat'     => $this->request->getPost('syarat'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $rekrutModel->insert($data);

        return redirect()->to('/rekrutmen_admin')->with('success', 'Rekrutmen berhasil ditambahkan.');
    }

    /**
     * Update data.
     */
    public function update($id)
    {
        $rekrutModel = new RekrutModel();

        $data = [
            'id_user'    => 1,
            'id_jadwal'  => $this->request->getPost('id_jadwal'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'status'     => $this->request->getPost('status'),
            'syarat'     => $this->request->getPost('syarat'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $rekrutModel->update($id, $data);

        return redirect()->to('/rekrutmen_admin')->with('success', 'Rekrutmen berhasil diperbarui.');
    }

    /**
     * Hapus data.
     */
    public function delete($id)
    {
        $rekrutModel = new RekrutModel();
        $rekrutModel->delete($id);

        return redirect()->to('/rekrutmen_admin')->with('success', 'Rekrutmen berhasil dihapus.');
    }
}
