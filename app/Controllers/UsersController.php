<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;

class UsersController extends BaseController
{
    /**
     * Menampilkan daftar semua pengguna beserta rolenya.
     */
    public function index()
    {
        $userModel = new UserModel();
        $data = [
            'title' => 'Daftar Pengguna',
            'users' => $userModel->getUsersWithRoles() // Menggunakan method custom dari model
        ];

        return view('users/index', $data);
    }

    /**
     * Menampilkan form untuk membuat pengguna baru.
     */
    public function new()
    {
        $roleModel = new RoleModel();
        $data = [
            'title' => 'Tambah Pengguna Baru',
            'roles' => $roleModel->findAll()
        ];
        return view('users/new', $data);
    }

    /**
     * Menyimpan data pengguna baru ke database.
     */
    public function create()
    {
        $userModel = new UserModel();
        $data = [
            'nrp'     => $this->request->getPost('nrp'),
            'nama'    => $this->request->getPost('nama'),
            'no_telp' => $this->request->getPost('no_telp'),
            'jurusan' => $this->request->getPost('jurusan'),
            'role_id' => $this->request->getPost('role_id'),
            // Tambahkan validasi dan hashing password di sini
        ];

        $userModel->insert($data);

        return redirect()->to('/users');
    }

    // Method lain seperti edit, update, dan delete bisa ditambahkan di sini.
}