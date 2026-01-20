<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Menampilkan daftar semua anggota laboratorium (untuk user biasa).
     */
    public function index()
    {
        return view('asisten_list_view', [
            'title'   => 'Anggota Laboratorium',
            'asisten' => $this->userModel->getProcessedPersonnelData()
        ]);
    }

    /**
     * Menampilkan daftar semua anggota (untuk admin).
     */
    public function getDataAdmin()
    {
        // Ambil semua user dengan join ke roles table untuk mendapatkan role_name
        $users = $this->userModel->select('users.*, roles.role_name')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->orderBy('users.created_at', 'DESC')
            ->findAll();

        // Map role_name ke format yang konsisten untuk view
        $processedUsers = [];
        foreach ($users as $user) {
            // Pastikan role_name ada, jika tidak gunakan default
            $roleName = $user['role_name'] ?? 'user';
            $user['role'] = strtolower($roleName); // Simpan sebagai lowercase untuk konsistensi
            $processedUsers[] = $user;
        }

        return view('asisten_admin_list_view', [
            'title'   => 'Kelola Anggota Laboratorium',
            'asisten' => $processedUsers
        ]);
    }

    /**
     * Menampilkan profil anggota berdasarkan ID
     */
    public function profil($id)
{
    $user = $this->userModel->find($id);

    if (!$user) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    // Mapping role_id sesuai seed: 1 admin, 2 asisten, 3 dosen, 4 praktikan/mahasiswa
    $roleMap = [
        1 => 'admin',
        2 => 'asisten',
        3 => 'dosen',
        4 => 'praktikan'
    ];
    $user['role'] = $roleMap[$user['role_id']] ?? 'tidak diketahui';

    // 🔹 Ambil data publikasi & proyek
    $publikasiModel = new \App\Models\PublikasiModel();
    $proyekModel    = new \App\Models\ProyekRisetModel();

    $publicationData = $publikasiModel->where('id_user', $id)->findAll() ?? [];
    $proyekData      = $proyekModel->where('id_user', $id)->findAll() ?? [];

    // // 🔹 Debug sementara
    // echo "<pre>";
    // print_r($publicationData);
    // echo "</pre>";
    // exit; // berhenti di sini biar bisa lihat hasil

    return view('user_profile_view', [
        'title'           => 'Profil Anggota | ' . $user['nama'],
        'user'            => $user,
        'publicationData' => $publicationData,
        'proyekData'      => $proyekData
    ]);
}


    /**
     * Tambah user baru
     */
    public function store()
    {
        $data = [
            'nomor'     => $this->request->getPost('nomor'),
            'nama'      => $this->request->getPost('nama'),
            'no_telp'   => $this->request->getPost('no_telp'),
            'jurusan'   => $this->request->getPost('jurusan'),
            'password'  => $this->request->getPost('password'), // tanpa hash
            'role_id'   => $this->request->getPost('role_id'),
            'created_at'=> date('Y-m-d H:i:s'),
        ];

        $this->userModel->insert($data);

        return redirect()->to('/asisten_admin')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Update data user
     */
    public function update($id)
    {
        $updateData = [
            'nomor'     => $this->request->getPost('nomor'),
            'nama'      => $this->request->getPost('nama'),
            'no_telp'   => $this->request->getPost('no_telp'),
            'jurusan'   => $this->request->getPost('jurusan'),
            'role_id'   => $this->request->getPost('role_id'),
            'updated_at'=> date('Y-m-d H:i:s'),
        ];

        if (!empty($this->request->getPost('password'))) {
            $updateData['password'] = $this->request->getPost('password'); // langsung simpan
        }

        $this->userModel->update($id, $updateData);

        return redirect()->to('/asisten_admin')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Hapus user
     */
    public function delete($id)
    {
        $this->userModel->delete($id);
        return redirect()->to('/asisten_admin')->with('success', 'User berhasil dihapus.');
    }
}
