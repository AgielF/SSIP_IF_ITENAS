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
        return view('asisten_admin_list_view', [
            'title'   => 'Anggota Laboratorium',
            'asisten' => $this->userModel->getProcessedPersonnelData()
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

        $roleMap = [
            4 => 'dosen',
            2 => 'asisten',
            3 => 'praktikan'
        ];
        $user['role'] = $roleMap[$user['role_id']] ?? 'tidak diketahui';

        return view('user_profile_view', [
            'title' => 'Profil Anggota | ' . $user['nama'],
            'user'  => $user
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
