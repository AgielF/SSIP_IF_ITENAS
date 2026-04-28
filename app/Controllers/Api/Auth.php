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
//     public function login()
// {
//     $nomor = $this->request->getPost('nomor');
//     $password = $this->request->getPost('password');

//     log_message('debug', "Login attempt - Nomor: {$nomor}"); // debug only

//     $user = $this->userModel->where('nomor', $nomor)->first();

//     if (!$user) {
//         log_message('debug', "User not found for nomor: {$nomor}");
//         return redirect()->back()->with('error', 'User tidak ditemukan');
//     }

//     // Debug info (remove in production)
//     log_message('debug', "DB hash for user {$user['nomor']}: " . substr($user['password'],0,60));
//     log_message('debug', "password_get_info: " . json_encode(password_get_info($user['password'])));

//     $ok = password_verify($password, $user['password']);
//     log_message('debug', "password_verify result: " . ($ok ? "OK" : "FAILED"));

//     if (!$ok) {
//         return redirect()->back()->with('error', 'Password salah');
//     }

//     // jika ok -> buat token & session seperti sebelumnya
//     // ...
// }



//    
public function login()
{
    try {
        $nomor    = trim($this->request->getPost('nomor'));
        $password = trim($this->request->getPost('password'));

        if (!$nomor || !$password) {
            return redirect()->back()->withInput()
                ->with('error', 'Nomor dan password harus diisi');
        }

        $user = $this->userModel->where('nomor', $nomor)->first();

        if (!$user || !$this->userModel->verifyPassword($password, $user['password'])) {
            return redirect()->back()->withInput()
                ->with('error', 'NIM / Username atau Password salah');
        }

        // JWT
        $key = getenv('JWT_SECRET') ?: 'your-secret-key';
        $payload = [
            'iat'     => time(),
            'exp'     => time() + 86400,
            'uid'     => $user['id'],
            'nomor'   => $user['nomor'],
            'nama'    => $user['nama'],
            'role_id' => $user['role_id']
        ];

        $token = JWT::encode($payload, $key, 'HS256');

        session()->set([
            'token' => $token,
            'user'  => [
                'id'      => $user['id'],
                'nomor'   => $user['nomor'],
                'nama'    => $user['nama'],
                'role_id' => $user['role_id'],
                'foto'    => $user['foto']
            ]
        ]);

        return ($user['role_id'] == 1)
            ? redirect()->to('/asisten_admin')
            : redirect()->to('/profile');

    } catch (\Throwable $e) {
        log_message('error', $e->getMessage());
        return redirect()->back()->with('error', 'Terjadi kesalahan saat login');
    }
}



    public function logout()
{
    session()->remove('user');
    session()->destroy();

    return redirect()->to('/login')->with('success', 'Berhasil logout');
}

    /**
     * Profile endpoint
     */
   use ResponseTrait;

  public function profile()
{
    // 1. Ambil data user dari session
    $user = session()->get('user');

    if (!$user) {
        // Jika belum login, redirect ke halaman login
        return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
    }

    // 2. Mapping role
    $roles = [
        1 => 'Admin',
        2 => 'Asisten',
        3 => 'Dosen',
        
    ];

    // Override role_id dengan nama role (karena di view kamu memanggilnya dengan $user['role_id'])
    $user['role_id'] = $roles[$user['role_id']] ?? 'Tidak diketahui';

    // 3. Ambil ID user dari session dengan aman
    // Kita cek apakah disimmpan sebagai 'id' atau 'id_user'
    $userId = $user['id'] ?? $user['id_user'] ?? null;

    // 4. Instansiasi Model
    $publikasiModel = new \App\Models\PublikasiModel();
    $proyekModel    = new \App\Models\ProyekRisetModel();

    // 5. Query data Publikasi & Proyek Riset
    if ($userId) {
        // ✅ Memanggil getDataWithUser() agar tabel users ter-join dan 'penulis_utama' terbaca
        $publicationData = $publikasiModel->getDataWithUser()
                                          ->where('publikasi.id_user', $userId)
                                          ->findAll();
                                          
        // Mengambil data proyek riset biasa (sesuaikan dengan field di ProyekRisetModel)
        $proyekData = $proyekModel->where('id_user', $userId)->findAll();
    } else {
        // Jika karena alasan tertentu ID tidak terbaca, kirim array kosong agar tidak error di view
        $publicationData = [];
        $proyekData = [];
    }
    dd([
        '1. Isi Session User' => $user,
        '2. ID User yg Digunakan' => $userId,
        '3. Hasil Data Publikasi' => $publicationData,
        '4. Hasil Data Proyek' => $proyekData
    ]);

    // 6. Siapkan data untuk dikirim ke view
    $data = [
        'title'           => 'Profil Saya | ' . $user['nama'],
        'user'            => $user,
        'publicationData' => $publicationData,
        'proyekData'      => $proyekData
    ];

    return view('auth/profile', $data);
}

}
