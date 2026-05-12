<?php

namespace App\Controllers;

use App\Models\ProyekRisetModel;

class ProyekRisetController extends BaseController
{
    protected ProyekRisetModel $proyekRisetModel;

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
        $userModel = new \App\Models\UserModel();

        $semuaProyek = $this->proyekRisetModel->getProyekWithUser();

        // Get all users for dropdown selection (dosen and asisten only)
        $allUsers = $userModel->whereIn('role_id', [1, 2, 3])->findAll();

        $data = [
            'title'  => 'Admin: Kelola Proyek Riset',
            'proyek' => $semuaProyek,
            'allUsers' => $allUsers // For dropdown selection
        ];

        return view('penelitian_proyek_admin_list_view', $data);
    }

    // 🟢 CREATE
    public function create()
    {
        // Validate that user is admin (role_id = 1)
        if (!session()->get('user') || session()->get('user')['role_id'] != 1) {
            return redirect()->to('/login')->with('error', 'Akses ditolak. Hanya admin yang dapat menambah proyek.');
        }

        // 🛡️ 1. VALIDASI INPUT
        $rules = [
            'judul'         => 'required|max_length[255]',
            'topik'         => 'required|max_length[100]',
            'deskripsi'     => 'required',
            'mitra'         => 'permit_empty|max_length[255]',
            'sumber_dana'   => 'permit_empty|max_length[255]',
            'tahun_mulai'   => 'required|numeric|exact_length[4]',
            'tahun_selesai' => 'permit_empty|numeric|exact_length[4]',
            'status'        => 'required|max_length[50]',
            'id_user'       => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Format data tidak valid. Silakan periksa kembali isian Anda.');
        }

        $selectedUserId = $this->request->getPost('id_user');

        // Validate selected user exists and is dosen/asisten
        $userModel = new \App\Models\UserModel();
        $selectedUser = $userModel->where('id', $selectedUserId)->whereIn('role_id', [1, 2, 3])->first();
        if (!$selectedUser) {
            return redirect()->back()->withInput()->with('error', 'Penulis yang dipilih tidak valid.');
        }

        // 🛡️ 2. TRY-CATCH ERROR HANDLING
        try {
            $data = [
                'judul'         => $this->request->getPost('judul'),
                'topik'         => $this->request->getPost('topik'),
                'deskripsi'     => $this->request->getPost('deskripsi'),
                'mitra'         => $this->request->getPost('mitra'),
                'sumber_dana'   => $this->request->getPost('sumber_dana'),
                'tahun_mulai'   => $this->request->getPost('tahun_mulai'),
                'tahun_selesai' => $this->request->getPost('tahun_selesai'),
                'status'        => $this->request->getPost('status'),
                'id_user'       => $selectedUserId,
                'created_at'    => date('Y-m-d H:i:s')
            ];

            $this->proyekRisetModel->save($data);

            return redirect()->to('/penelitian-proyek_admin')
                ->with('success', 'Proyek riset berhasil ditambahkan.');
                
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat menyimpan data proyek.');
        }
    }

    // 🟡 UPDATE
    public function update($id)
    {
        // Validate that user is admin (role_id = 1)
        if (!session()->get('user') || session()->get('user')['role_id'] != 1) {
            return redirect()->to('/login')->with('error', 'Akses ditolak. Hanya admin yang dapat mengedit proyek.');
        }

        // 🛡️ 1. PASTIKAN ID NUMERIC
        if (!is_numeric($id)) {
            return redirect()->to('/penelitian-proyek_admin')->with('error', 'ID Proyek tidak valid.');
        }

        // 🛡️ 2. VALIDASI INPUT
        $rules = [
            'judul'         => 'required|max_length[255]',
            'topik'         => 'required|max_length[100]',
            'deskripsi'     => 'required',
            'mitra'         => 'permit_empty|max_length[255]',
            'sumber_dana'   => 'permit_empty|max_length[255]',
            'tahun_mulai'   => 'required|numeric|exact_length[4]',
            'tahun_selesai' => 'permit_empty|numeric|exact_length[4]',
            'status'        => 'required|max_length[50]',
            'id_user'       => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Format data tidak valid. Silakan periksa kembali isian Anda.');
        }

        $selectedUserId = $this->request->getPost('id_user');

        // Validate selected user exists and is dosen/asisten
        $userModel = new \App\Models\UserModel();
        $selectedUser = $userModel->where('id', $selectedUserId)->whereIn('role_id', [2, 3])->first();
        if (!$selectedUser) {
            return redirect()->back()->with('error', 'Penulis yang dipilih tidak valid.');
        }

        // 🛡️ 3. TRY-CATCH ERROR HANDLING
        try {
            $data = [
                'judul'         => $this->request->getPost('judul'),
                'topik'         => $this->request->getPost('topik'),
                'deskripsi'     => $this->request->getPost('deskripsi'),
                'mitra'         => $this->request->getPost('mitra'),
                'sumber_dana'   => $this->request->getPost('sumber_dana'),
                'tahun_mulai'   => $this->request->getPost('tahun_mulai'),
                'tahun_selesai' => $this->request->getPost('tahun_selesai'),
                'status'        => $this->request->getPost('status'),
                'id_user'       => $selectedUserId,
                'updated_at'    => date('Y-m-d H:i:s')
            ];

            $this->proyekRisetModel->update($id, $data);

            return redirect()->to('/penelitian-proyek_admin')
                ->with('success', 'Proyek riset berhasil diperbarui.');
                
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat memperbarui data proyek.');
        }
    }

    // 🔴 DELETE
    public function delete($id)
    {
        // 🛡️ PASTIKAN ID NUMERIC & TRY-CATCH
        if (!is_numeric($id)) {
            return redirect()->to('/penelitian-proyek_admin')->with('error', 'ID Proyek tidak valid.');
        }

        try {
            $this->proyekRisetModel->delete($id);
            return redirect()->to('/penelitian-proyek_admin')
                             ->with('success', 'Proyek riset berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to('/penelitian-proyek_admin')
                             ->with('error', 'Gagal menghapus proyek. Data mungkin terikat dengan tabel lain.');
        }
    }

    // 🔍 GET ONE UNTUK EDIT FORM
    public function edit($id)
    {
        if (!is_numeric($id)) {
            return redirect()->to('/penelitian-proyek_admin')->with('error', 'ID Proyek tidak valid.');
        }

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