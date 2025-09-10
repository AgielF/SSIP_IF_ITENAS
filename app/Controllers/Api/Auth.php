<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use App\Models\AsistenJadwalModel;
use App\Models\JadwalModel;
use App\Models\PublikasiModel;
use App\Models\RoleModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth extends ResourceController
{
    use ResponseTrait;

    private $userModel;
    private $asistenJadwalModel;
    private $jadwalModel;
    private $publikasiModel;
    private $roleModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->asistenJadwalModel = new AsistenJadwalModel();
        $this->jadwalModel = new JadwalModel();
        $this->publikasiModel = new PublikasiModel();
        $this->roleModel = new RoleModel();
    }

    /**
     * Login endpoint
     */
    public function login()
{
    try {
        $nomor    = $this->request->getPost('nomor');
        $password = $this->request->getPost('password');

        if (!$nomor || !$password) {
            return redirect()->back()->with('error', 'Nomor dan password harus diisi');
        }

        $user = $this->userModel->where('nomor', $nomor)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        if ($user['password'] !== $password) {
            return redirect()->back()->with('error', 'Password salah');
        }

        // Generate JWT
        $key = getenv('JWT_SECRET') ?: 'your-secret-key';
        $payload = [
            'iat'     => time(),
            'exp'     => time() + 86400, // 24 jam
            'uid'     => $user['id'],
            'nomor'   => $user['nomor'],
            'nama'    => $user['nama'],
            'role_id' => $user['role_id']
        ];
        $token = JWT::encode($payload, $key, 'HS256');

        // Simpan token ke session
        session()->set('token', $token);
        session()->set('user', [
            'id'      => $user['id'],
            'nomor'   => $user['nomor'],
            'nama'    => $user['nama'],
            'role_id' => $user['role_id']
        ]);

        // Redirect sesuai role
        if ($user['role_id'] == 1) {
            return redirect()->to('/asisten_admin');
        } else {
            return redirect()->to('/dashboard');
        }

    } catch (\Throwable $e) {
        return redirect()->back()->with('error', 'Login gagal: ' . $e->getMessage());
    }
}


    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }


    /**
     * Profile endpoint
     */
   use ResponseTrait;

    public function profile()
    {
        $authHeader = $this->request->getHeaderLine('Authorization');

        if (!$authHeader) {
            return $this->respond([
                'status' => 'error',
                'message' => 'Authorization header missing'
            ], 401);
        }

        if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return $this->respond([
                'status' => 'error',
                'message' => 'Invalid Authorization header format'
            ], 401);
        }

        $jwt = $matches[1];

        try {
            $key = getenv('JWT_SECRET') ?: 'your-secret-key';
            $decoded = JWT::decode($jwt, new Key($key, 'HS256'));

            return $this->respond([
                'status' => 'success',
                'user' => [
                    'id' => $decoded->uid,
                    'nomor' => $decoded->nomor,
                    'nama' => $decoded->nama,
                    'role_id' => $decoded->role_id,
                ]
            ]);
        } catch (\Exception $e) {
            return $this->respond([
                'status' => 'error',
                'message' => 'Token invalid: ' . $e->getMessage()
            ], 401);
        }
    }
}
