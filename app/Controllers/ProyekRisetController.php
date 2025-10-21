<?php

namespace App\Controllers;

use App\Models\ProyekRisetModel;

class ProyekRisetController extends BaseController
{
    protected $proyekRisetModel;

    public function __construct()
    {
        $this->proyekRisetModel = new ProyekRisetModel();
    }

    // 📋 LIST UNTUK USER
    public function index()
    {
        $risetModel    = new ProyekRisetModel();
        $formattedData = $risetModel->getProyekDataFormattedForView();

        $data = ['data' => $formattedData];
        return view('penelitian_proyek_list_view', $data);
    }

    // 📋 LIST UNTUK ADMIN
    public function getDataAdmin()
    {

        $semuaProyek = $this->proyekRisetModel->getProyekWithUser();

        $data = [
            'title'  => 'Admin: Kelola Proyek Riset',
            'proyek' => $semuaProyek
        ];

        return view('penelitian_proyek_admin_list_view', $data);
    }

    // 🟢 CREATE
    public function create()
    {
        $userId = $this->getUserIdOrRedirect(); // ✅ langsung ambil id user

        $data = [
            'judul'         => $this->request->getPost('judul'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
            'mitra'         => $this->request->getPost('mitra'),
            'sumber_dana'   => $this->request->getPost('sumber_dana'),
            'tahun_mulai'   => $this->request->getPost('tahun_mulai'),
            'tahun_selesai' => $this->request->getPost('tahun_selesai'),
            'id_user'       => $userId, // default admin
            'created_at'    => date('Y-m-d H:i:s')
        ];

        $this->proyekRisetModel->save($data);

        return redirect()->to('/penelitian-proyek_admin')
                         ->with('success', 'Proyek riset berhasil ditambahkan.');
    }

    // 🟡 UPDATE
    public function update($id)
    {
         $userId = $this->getUserIdOrRedirect(); // ✅ langsung ambil id user

        $data = [
            'judul'         => $this->request->getPost('judul'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
            'mitra'         => $this->request->getPost('mitra'),
            'sumber_dana'   => $this->request->getPost('sumber_dana'),
            'tahun_mulai'   => $this->request->getPost('tahun_mulai'),
            'tahun_selesai' => $this->request->getPost('tahun_selesai'),
            'id_user'       => $userId,
            'updated_at'    => date('Y-m-d H:i:s')
        ];

        $this->proyekRisetModel->update($id, $data);

        return redirect()->to('/penelitian-proyek_admin')
                         ->with('success', 'Proyek riset berhasil diperbarui.');
    }

    // 🔴 DELETE
    public function delete($id)
    {
        $this->proyekRisetModel->delete($id);

        return redirect()->to('/penelitian-proyek_admin')
                         ->with('success', 'Proyek riset berhasil dihapus.');
    }

    // 🔍 GET ONE UNTUK EDIT FORM
    public function edit($id)
    {
        $proyek = $this->proyekRisetModel->find($id);

        if (!$proyek) {
            return redirect()->to('/penelitian-proyek_admin')
                             ->with('error', 'Data proyek riset tidak ditemukan.');
        }

        $data = [
            'title'  => 'Edit Proyek Riset',
            'proyek' => $proyek
        ];

        return view('penelitian_proyek_edit_view', $data);
    }
}
