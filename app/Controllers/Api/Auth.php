<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use App\Models\AsistenJadwalModel;
use App\Models\JadwalModel;
use App\Models\PublikasiModel;
use App\Models\RoleModel;
use App\Models\ProyekRisetModel;
use App\Libraries\JwtHelper;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth extends ResourceController
{
    use ResponseTrait;

    private UserModel $userModel;
    private AsistenJadwalModel $asistenJadwalModel;
    private JadwalModel $jadwalModel;
    private PublikasiModel $publikasiModel;
    private RoleModel $roleModel;
    private ProyekRisetModel $proyekRisetModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->asistenJadwalModel = new AsistenJadwalModel();
        $this->jadwalModel = new JadwalModel();
        $this->publikasiModel = new PublikasiModel();
        $this->roleModel = new RoleModel();
        $this->proyekRisetModel = new ProyekRisetModel();
    }

    public function login()
    {
        try {
            // Rate Limiting untuk mencegah brute force
            $this->checkRateLimit();

            $nomor    = trim($this->request->getPost('nomor'));
            $password = $this->request->getPost('password');

            // Validasi input dasar
            if (!$nomor || !$password) {
                $this->recordFailedAttempt();
                return redirect()->back()->withInput()->with('error', 'Nomor dan password harus diisi');
            }

            // [T2.4] FILTER_SANITIZE_STRING dihapus (deprecated sejak PHP 8.1).
            // Validasi format NIM sudah cukup dihandle oleh preg_match di bawah.

            // Validasi format NIM/Username dihapus sesuai permintaan

            // Cek password minimal 6 karakter
            if (strlen($password) < 6) {
                $this->recordFailedAttempt();
                return redirect()->back()->withInput()->with('error', 'Password minimal 6 karakter');
            }

            // Cari user di database
            $user = $this->userModel->where('nomor', $nomor)->first();

            // Pengecekan Hash Password menggunakan fungsi bawaan PHP yang aman
            if (!$user || !password_verify($password, $user['password'])) {
                $this->recordFailedAttempt();
                return redirect()->back()->withInput()->with('error', 'NIM / Username atau Password salah');
            }

            // Reset login gagal counter jika login berhasil
            $this->resetFailedAttempts();

            // [T1.2] Gunakan JwtHelper terpusat — tidak ada lagi hardcoded secret.
            // Referensi: OWASP A02 Cryptographic Failures.
            $key     = JwtHelper::getSecretKey();
            $payload = JwtHelper::buildPayload($user, 3600);
            $token   = JWT::encode($payload, $key, 'HS256');

            // Simpan data di Session (Monolitik)
            session()->set([
                'token'         => $token,
                'login_time'    => time(),
                'last_activity' => time(),
                'user'          => [
                    'id'      => $user['id'],
                    'nomor'   => $user['nomor'],
                    'nama'    => $user['nama'],
                    'role_id' => $user['role_id'],
                    'foto'    => $user['foto']
                ]
            ]);

            // Redirect berdasarkan Role
            return ($user['role_id'] == 1)
                ? redirect()->to('/asisten_admin')
                : redirect()->to('/profile');
    
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());

            if (str_contains($e->getMessage(), 'Terlalu banyak percobaan')) {
                return redirect()->back()->withInput()->with('error', $e->getMessage());
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan saat login');
        }
    }

    private function checkRateLimit()
    {
        $ip = $this->request->getIPAddress();
        $attempts = session()->get('login_attempts_' . $ip) ?? 0;
        $lastAttempt = session()->get('last_attempt_' . $ip) ?? 0;

        if (time() - $lastAttempt > 60) {
            $this->resetFailedAttempts();
            return;
        }

        if ($attempts >= 5) {
            $remainingTime = 60 - (time() - $lastAttempt);
            $seconds = ceil($remainingTime);
            throw new \Exception("Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik.");
        }
    }

    private function recordFailedAttempt()
    {
        $ip = $this->request->getIPAddress();
        $attempts = session()->get('login_attempts_' . $ip) ?? 0;

        session()->set([
            'login_attempts_' . $ip => $attempts + 1,
            'last_attempt_' . $ip => time()
        ]);

        log_message('warning', 'Failed login attempt from IP: ' . $ip . ', Attempt: ' . ($attempts + 1) . ', User-Agent: ' . $this->request->getUserAgent());
    }

    private function resetFailedAttempts()
    {
        $ip = $this->request->getIPAddress();
        session()->remove([
            'login_attempts_' . $ip,
            'last_attempt_' . $ip
        ]);
    }
}