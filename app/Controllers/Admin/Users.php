<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\PeriodeModel;
use App\Models\AsistenPeriodeModel;

class Users extends BaseController
{
    protected UserModel $userModel;
    protected RoleModel $roleModel;
    protected PeriodeModel $periodeModel;
    protected AsistenPeriodeModel$asistenPeriodeModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
        $this->periodeModel = new PeriodeModel();
        $this->asistenPeriodeModel = new AsistenPeriodeModel();
    }

    // List semua users
    public function index()
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

    // form untuk add new user
    public function new()
    {
        // Redirect ke asisten_admin, form add ada di modal
        return redirect()->to('/asisten_admin');
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
        $id_periode = $this->request->getPost('id_periode');

        log_message('debug', 'Create data: ' . json_encode([$nomor, $nama, $jurusan, $role_id, $id_periode]));

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

        // Start transaction
        $this->userModel->db->transStart();

        // First, insert user without foto
        $data = [
            'nomor' => $nomor,
            'nama' => $nama,
            'password' => $password,
            'jurusan' => $jurusan,
            'role_id' => $role_id
        ];

        $userId = $this->userModel->insert($data);
        if (!$userId) {
            $this->userModel->db->transRollback();
            log_message('debug', 'Failed to save user');
            if ($isAjax) {
                return $this->response
                    ->setContentType('application/json')
                    ->setJSON(['success' => false, 'message' => 'Failed to create user']);
            }
            return redirect()->back()->with('error', 'Failed to create user')->withInput();
        }

        // If user is asisten (role 2) and id_periode is provided, insert into asisten_periode
        if ($role_id == 2 && !empty($id_periode)) {
            $this->asistenPeriodeModel->insert([
                'id_user' => $userId,
                'id_periode' => $id_periode,
                'jabatan' => 'Asisten Praktikum',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        // Handle file upload
        $fotoPath = null;
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $uploadPath = ROOTPATH . 'public/uploads/photos/' . $userId . '/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $newName = $foto->getRandomName();
            $foto->move($uploadPath, $newName);
            $fotoPath = 'uploads/photos/' . $userId . '/' . $newName;

            // Update user with foto path
            $this->userModel->update($userId, ['foto' => $fotoPath]);
        }

        // Complete transaction
        $this->userModel->db->transComplete();

        log_message('debug', 'User saved successfully');
        if ($isAjax) {
            return $this->response
                ->setContentType('application/json')
                ->setJSON(['success' => true, 'message' => 'User created successfully']);
        }
        return redirect()->to('/asisten_admin')->with('success', 'User created successfully');
    }

    // Edit user
    public function edit(int $id)
    {
        // Redirect ke asisten_admin, form edit ada di modal
        return redirect()->to('/asisten_admin');
    }

    // Update user
    public function update(int $id)
    {
        // Get current user data
        $user = $this->userModel->find($id);
        if (!$user) {
            if ($this->request->isAJAX()) {
                return $this->response
                    ->setContentType('application/json')
                    ->setJSON(['success' => false, 'message' => 'User not found']);
            }
            return redirect()->to('/asisten_admin')->with('error', 'User not found');
        }

        // debug
        log_message('debug', 'Users::update called for ID: ' . $id . '. AJAX: ' . ($this->request->isAJAX() ? 'true' : 'false'));
        log_message('debug', 'Request method: ' . $this->request->getMethod());
        log_message('debug', 'All POST data: ' . json_encode($this->request->getPost()));

        $nomor = $this->request->getPost('nomor');
        $nama = $this->request->getPost('nama');
        $jurusan = $this->request->getPost('jurusan');
        $role_id = $this->request->getPost('role_id');
        $id_periode = $this->request->getPost('id_periode');

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

        // Handle file upload for foto
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $uploadPath = ROOTPATH . 'public/uploads/photos/' . $id . '/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $newName = $foto->getRandomName();
            $foto->move($uploadPath, $newName);
            $data['foto'] = 'uploads/photos/' . $id . '/' . $newName;
        }

        // Start transaction
        $this->userModel->db->transStart();

        // If no data to update, return success
        if (empty($data)) {
            $this->userModel->db->transComplete();
            if ($this->request->isAJAX()) {
                return $this->response
                    ->setContentType('application/json')
                    ->setJSON(['success' => true, 'message' => 'No changes made']);
            }
            return redirect()->back()->with('info', 'No changes made');
        }

        if ($this->userModel->update($id, $data)) {
            // Handle periode update for asisten
            if ($role_id == 2) {
                if (!empty($id_periode)) {
                    // Check if relation already exists
                    $existingRelasi = $this->asistenPeriodeModel->where('id_user', $id)->first();

                    if ($existingRelasi) {
                        // Update if exists
                        $this->asistenPeriodeModel->update($existingRelasi['id'], [
                            'id_periode' => $id_periode,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                    } else {
                        // Insert new if not exists
                        $this->asistenPeriodeModel->insert([
                            'id_user' => $id,
                            'id_periode' => $id_periode,
                            'jabatan' => 'Asisten Praktikum',
                            'created_at' => date('Y-m-d H:i:s')
                        ]);
                    }
                } else {
                    // If role is asisten but no periode selected, remove relation
                    $this->asistenPeriodeModel->where('id_user', $id)->delete();
                }
            } else {
                // If role changed away from asisten, remove periode relation
                $this->asistenPeriodeModel->where('id_user', $id)->delete();
            }

            // Complete transaction
            $this->userModel->db->transComplete();

            if ($this->request->isAJAX()) {
                return $this->response
                    ->setContentType('application/json')
                    ->setJSON(['success' => true, 'message' => 'User updated successfully']);
            }
            return redirect()->to('/asisten_admin')->with('success', 'User updated successfully');
        } else {
            $this->userModel->db->transRollback();
            if ($this->request->isAJAX()) {
                return $this->response
                    ->setContentType('application/json')
                    ->setJSON(['success' => false, 'message' => 'Failed to update user']);
            }
            return redirect()->back()->with('error', 'Failed to update user')->withInput();
        }
    }

    // Delete user
    public function delete(int $id)
    {
        if ($this->userModel->delete($id)) {
            if ($this->request->isAJAX()) {
                return $this->response
                    ->setContentType('application/json')
                    ->setJSON(['success' => true, 'message' => 'User deleted successfully']);
            }
            return redirect()->to('/asisten_admin')->with('success', 'User deleted successfully');
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
        $users = $this->userModel->select('users.*, roles.role_name as role, periode.nama_periode')
            ->join('roles', 'roles.id = users.role_id', 'left')
            ->join('asisten_periode', 'asisten_periode.id_user = users.id', 'left')
            ->join('periode', 'periode.id_periode = asisten_periode.id_periode', 'left')
            ->findAll();

        // Process users
        $processedUsers = [];
        foreach ($users as $user) {
            $user['nama_periode'] = $user['nama_periode'] ?? '-';
            $processedUsers[] = $user;
        }

        $data = [
            'title' => 'Kelola Anggota Laboratorium',
            'asisten' => $processedUsers, // Pass raw user data, let the view handle formatting
            'listPeriode' => $this->periodeModel->findAll()
        ];

        return view('asisten_admin_list_view', $data);
    }
}