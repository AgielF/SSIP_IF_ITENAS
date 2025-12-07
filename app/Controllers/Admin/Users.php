<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoleModel;

class Users extends BaseController
{
    protected $userModel;
    protected $roleModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
    }

    // List semua users
    public function index()
    {
        $data = [
            'title' => 'User Management',
            'users' => $this->userModel->select('users.*, roles.role_name')
                ->join('roles', 'roles.id = users.role_id')
                ->findAll()
        ];

        return view('admin/users/index', $data);
    }

    // form untuk add new user
    public function new()
    {
        $data = [
            'title' => 'Add New User',
            'roles' => $this->roleModel->findAll()
        ];

        return view('admin/users/create', $data);
    }

    // Create user baru
    public function create()
    {
        // Debug: Log the request details
        $isAjax = $this->request->isAJAX();
        $headers = $this->request->getHeaders();
        log_message('debug', 'Users::create called. AJAX: ' . ($isAjax ? 'true' : 'false'));
        log_message('debug', 'Request headers: ' . json_encode($headers));
        log_message('debug', 'X-Requested-With: ' . ($this->request->getHeaderLine('X-Requested-With') ?? 'not set'));

        // Validate input data
        $nomor = $this->request->getPost('nomor');
        $nama = $this->request->getPost('nama');
        $password = $this->request->getPost('password');
        $jurusan = $this->request->getPost('jurusan');
        $role_id = $this->request->getPost('role_id');

        log_message('debug', 'Create data: ' . json_encode([$nomor, $nama, $jurusan, $role_id]));

        // Check for duplicate nomor
        $existingUser = $this->userModel->where('nomor', $nomor)->first();
        if ($existingUser) {
            log_message('debug', 'Duplicate nomor found: ' . $nomor);
            if ($isAjax) {
                log_message('debug', 'Returning JSON response for duplicate');
                return $this->response
                    ->setContentType('application/json')
                    ->setJSON(['success' => false, 'message' => 'Nomor sudah digunakan']);
            }
            return redirect()->back()->with('error', 'Nomor sudah digunakan')->withInput();
        }

        $data = [
            'nomor' => $nomor,
            'nama' => $nama,
            'password' => $password,
            'jurusan' => $jurusan,
            'role_id' => $role_id
        ];

        if ($this->userModel->save($data)) {
            log_message('debug', 'User saved successfully');
            if ($isAjax) {
                log_message('debug', 'Returning JSON response for success');
                return $this->response
                    ->setContentType('application/json')
                    ->setJSON(['success' => true, 'message' => 'User created successfully']);
            }
            return redirect()->to('/admin/users')->with('success', 'User created successfully');
        } else {
            log_message('debug', 'Failed to save user');
            if ($isAjax) {
                log_message('debug', 'Returning JSON response for failure');
                return $this->response
                    ->setContentType('application/json')
                    ->setJSON(['success' => false, 'message' => 'Failed to create user']);
            }
            return redirect()->back()->with('error', 'Failed to create user')->withInput();
        }
    }

    // Edit user
    public function edit($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User not found');
        }

        $data = [
            'title' => 'Edit User',
            'user' => $user,
            'roles' => $this->roleModel->findAll()
        ];

        return view('admin/users/edit', $data);
    }

    // Update user
    public function update($id)
    {
        // Get current user data
        $user = $this->userModel->find($id);
        if (!$user) {
            if ($this->request->isAJAX()) {
                return $this->response
                    ->setContentType('application/json')
                    ->setJSON(['success' => false, 'message' => 'User not found']);
            }
            return redirect()->to('/admin/users')->with('error', 'User not found');
        }

        // debug
        log_message('debug', 'Users::update called for ID: ' . $id . '. AJAX: ' . ($this->request->isAJAX() ? 'true' : 'false'));
        log_message('debug', 'Request method: ' . $this->request->getMethod());
        log_message('debug', 'All POST data: ' . json_encode($this->request->getPost()));

        $nomor = $this->request->getPost('nomor');
        $nama = $this->request->getPost('nama');
        $jurusan = $this->request->getPost('jurusan');
        $role_id = $this->request->getPost('role_id');

        log_message('debug', 'Update data: ' . json_encode(['nomor' => $nomor, 'nama' => $nama, 'jurusan' => $jurusan, 'role_id' => $role_id]));
        log_message('debug', 'Current user role_id: ' . $user['role_id']);

        $data = [];

        // Update nomor if changed and not empty
        if ($nomor !== null && $nomor !== '' && $nomor != $user['nomor']) {
            $existingUser = $this->userModel->where('nomor', $nomor)->where('id !=', $id)->first();
            if ($existingUser) {
                if ($this->request->isAJAX()) {
                    return $this->response
                        ->setContentType('application/json')
                        ->setJSON(['success' => false, 'message' => 'Nomor sudah digunakan oleh user lain']);
                }
                return redirect()->back()->with('error', 'Nomor sudah digunakan oleh user lain')->withInput();
            }
            $data['nomor'] = $nomor;
        }

        // Update nama if changed
        if ($nama !== null && $nama != $user['nama']) {
            $data['nama'] = $nama;
        }

        // Update jurusan if changed
        if ($jurusan !== null && $jurusan != $user['jurusan']) {
            $data['jurusan'] = $jurusan;
        }

        // Update role_id if provided - always update if value is sent (don't skip if same value)
        if ($role_id !== null && $role_id !== '') {
            // Convert to integer for proper comparison and storage
            $role_id = (int)$role_id;
            $current_role_id = (int)$user['role_id'];
            
            // Always update role_id if it's provided, even if it's the same (to ensure update happens)
            $data['role_id'] = $role_id;
            log_message('debug', 'Role ID will be updated from ' . $current_role_id . ' to ' . $role_id);
        } else {
            log_message('debug', 'Role ID not provided in request - keeping current value: ' . $user['role_id']);
        }

        // Only update password if provided
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = $password;
        }

        // If no data to update, return success
        if (empty($data)) {
            if ($this->request->isAJAX()) {
                return $this->response
                    ->setContentType('application/json')
                    ->setJSON(['success' => true, 'message' => 'No changes made']);
            }
            return redirect()->back()->with('info', 'No changes made');
        }

        if ($this->userModel->update($id, $data)) {
            if ($this->request->isAJAX()) {
                return $this->response
                    ->setContentType('application/json')
                    ->setJSON(['success' => true, 'message' => 'User updated successfully']);
            }
            return redirect()->to('/admin/users')->with('success', 'User updated successfully');
        } else {
            if ($this->request->isAJAX()) {
                return $this->response
                    ->setContentType('application/json')
                    ->setJSON(['success' => false, 'message' => 'Failed to update user']);
            }
            return redirect()->back()->with('error', 'Failed to update user')->withInput();
        }
    }

    // Delete user
    public function delete($id)
    {
        if ($this->userModel->delete($id)) {
            if ($this->request->isAJAX()) {
                return $this->response
                    ->setContentType('application/json')
                    ->setJSON(['success' => true, 'message' => 'User deleted successfully']);
            }
            return redirect()->to('/admin/users')->with('success', 'User deleted successfully');
        } else {
            if ($this->request->isAJAX()) {
                return $this->response
                    ->setContentType('application/json')
                    ->setJSON(['success' => false, 'message' => 'Failed to delete user']);
            }
            return redirect()->back()->with('error', 'Failed to delete user');
        }
    }

    // Buat asisten_lab_admin view
    public function asistenAdmin()
    {
        $users = $this->userModel->select('users.*, roles.role_name as role')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->findAll();

        $data = [
            'title' => 'Kelola Anggota Laboratorium',
            'asisten' => $users // Pass raw user data, let the view handle formatting
        ];

        return view('asisten_admin_list_view', $data);
    }
}