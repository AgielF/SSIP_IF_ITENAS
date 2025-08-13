<?php

namespace App\Controllers;

use App\Models\RoleModel;

class RolesController extends BaseController
{
    /**
     * Menampilkan daftar semua role.
     */
    public function index()
    {
        $roleModel = new RoleModel();
        $data = [
            'title' => 'Daftar Role Pengguna',
            'roles' => $roleModel->findAll()
        ];
        return view('roles/index', $data);
    }

    /**
     * Menyimpan role baru.
     */
    public function create()
    {
        $roleModel = new RoleModel();
        $data = [
            'role_name' => $this->request->getPost('role_name'),
        ];
        $roleModel->insert($data);
        return redirect()->to('/roles');
    }

    // Method lain seperti edit, update, dan delete bisa ditambahkan di sini.
}