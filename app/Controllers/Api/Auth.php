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
     * 
     * @return mixed
     */
    public function login()
    {
        $nomor = $this->request->getPost('nomor');
        $password = $this->request->getPost('password');

        // Validate input
        if (!$nomor || !$password) {
            return $this->fail('Nomor dan password harus diisi', 400);
        }

        // Find user by nomor
        $user = $this->userModel->where('nomor', $nomor)->first();
        
        if (!$user) {
            return $this->fail('User tidak ditemukan', 404);
        }

        // Verify password (in a real app, you would hash the password)
        // For now, we'll just check if password field is not empty
        if (empty($user['password'])) {
            return $this->fail('Password belum diatur', 400);
        }

        // In a real app, you would use password_verify() here
        if ($password !== $user['password']) {
            return $this->fail('Password salah', 401);
        }

        // Generate JWT token
        $key = getenv('JWT_SECRET') ?: 'your-secret-key';
        $iat = time();
        $exp = $iat + (60 * 60 * 24); // Token valid for 24 hours

        $payload = [
            'iat' => $iat,
            'exp' => $exp,
            'uid' => $user['id'],
            'nomor' => $user['nomor'],
            'nama' => $user['nama'],
            'role_id' => $user['role_id']
        ];

        $token = JWT::encode($payload, $key, 'HS256');

        return $this->respond([
            'status' => 'success',
            'message' => 'Login berhasil',
            'data' => [
                'token' => $token,
                'user' => [
                    'id' => $user['id'],
                    'nomor' => $user['nomor'],
                    'nama' => $user['nama'],
                    'no_telp' => $user['no_telp'],
                    'jurusan' => $user['jurusan'],
                    'role_id' => $user['role_id']
                ]
            ]
        ]);
    }

    /**
     * Profile endpoint
     * 
     * @return mixed
     */
    public function profile()
    {
        // Get token from header
        $header = $this->request->getHeaderLine('Authorization');
        $token = null;
        
        if (!empty($header) && preg_match('/Bearer\s+(.*)$/i', $header, $matches)) {
            $token = $matches[1];
        }

        if (empty($token)) {
            return $this->failUnauthorized('Token tidak ditemukan');
        }

        try {
            $key = getenv('JWT_SECRET') ?: 'your-secret-key';
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            
            // Get user data
            $user = $this->userModel->find($decoded->uid);
            
            if (!$user) {
                return $this->failNotFound('User tidak ditemukan');
            }

            // Get user role
            $role = $this->roleModel->find($user['role_id']);
            $user['role'] = $role ? $role['role_name'] : 'Unknown';

            // Get schedule data for assistants
            $schedules = [];
            if ($user['role_id'] == 2 || $user['role_id'] == 4) { // asisten or dosen
                $asistenJadwal = $this->asistenJadwalModel
                    ->where('id_user', $user['id'])
                    ->findAll();
                
                foreach ($asistenJadwal as $aj) {
                    $jadwal = $this->jadwalModel->find($aj['id_jadwal']);
                    if ($jadwal) {
                        $schedules[] = $jadwal;
                    }
                }
            }

            // Get publications for lecturers/assistants
            $publications = [];
            if ($user['role_id'] == 2 || $user['role_id'] == 4) { // asisten or dosen
                // Get publications where user is the main author
                $mainAuthorPublications = $this->publikasiModel
                    ->where('id_user', $user['id'])
                    ->findAll();
                
                // Get publications where user is listed as co-author
                $coAuthorPublications = $this->publikasiModel
                    ->like('penulis_pendamping', $user['nama'])
                    ->findAll();
                
                // Merge both arrays
                $publications = array_merge($mainAuthorPublications, $coAuthorPublications);
                
                // Remove duplicates based on id_publikasi
                $uniquePublications = [];
                $seenIds = [];
                foreach ($publications as $publication) {
                    if (!in_array($publication['id_publikasi'], $seenIds)) {
                        $uniquePublications[] = $publication;
                        $seenIds[] = $publication['id_publikasi'];
                    }
                }
                
                $publications = $uniquePublications;
            }

            // Prepare response data
            $responseData = [
                'user' => $user,
                'schedules' => $schedules,
                'publications' => $publications
            ];

            return $this->respond([
                'status' => 'success',
                'data' => $responseData
            ]);
        } catch (\Exception $e) {
            return $this->failUnauthorized('Token tidak valid: ' . $e->getMessage());
        }
    }
}