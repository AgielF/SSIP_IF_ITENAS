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
        // untuk mencegah brute force attack
        if ($this->isIPBlocked()) {
            log_message('critical', 'Blocked login attempt from blacklisted IP: ' . $this->request->getIPAddress());
            return redirect()->back()->with('error', 'Akses ditolak. Silakan hubungi administrator.');
        }

        // Rate Limiting: buat cek login attempt per IP
        $this->checkRateLimit();

        // Capthca untuk mencegah bot setelah 3 kali gagal login
        $failedCount = session()->get('login_attempts_' . $this->request->getIPAddress()) ?? 0;
        if ($failedCount >= 3) {
            $captchaResponse = $this->request->getPost('captcha');
            if (!$captchaResponse || !$this->verifyCaptcha($captchaResponse)) {
                return redirect()->back()->withInput()
                    ->with('error', 'Captcha harus diisi dengan benar');
            }
        }

        $nomor    = trim($this->request->getPost('nomor'));
        $password = trim($this->request->getPost('password'));

        // validasi input dasar
        if (!$nomor || !$password) {
            $this->recordFailedAttempt();
            return redirect()->back()->withInput()
                ->with('error', 'Nomor dan password harus diisi');
        }

        // untuk mencegah serangan XSS
        $nomor = filter_var(trim($nomor), FILTER_SANITIZE_STRING);
        $password = filter_var(trim($password), FILTER_SANITIZE_STRING);

        // Validate nomor format (NIM format) - prevent SQL injection
        if (!preg_match('/^[0-9]{9}$/', $nomor)) {
            $this->recordFailedAttempt();
            return redirect()->back()->withInput()
                ->with('error', 'Format NIM tidak valid (9 digit angka)');
        }

        // Cek password minimal 6 karakter
        if (strlen($password) < 6) {
            $this->recordFailedAttempt();
            return redirect()->back()->withInput()
                ->with('error', 'Password minimal 6 karakter');
        }

        // mencegah SQL injection
        $suspicious = ['\'', '"', ';', '--', '/*', '*/', 'xp_', 'union', 'select', 'drop', 'delete'];
        foreach ($suspicious as $pattern) {
            if (stripos($nomor, $pattern) !== false || stripos($password, $pattern) !== false) {
                $this->recordFailedAttempt();
                log_message('warning', 'Suspicious login attempt detected from IP: ' . $this->request->getIPAddress());
                return redirect()->back()->withInput()
                    ->with('error', 'Input tidak valid');
            }
        }

        $user = $this->userModel->where('nomor', $nomor)->first();

        if (!$user || !$this->userModel->verifyPassword($password, $user['password'])) {
            $this->recordFailedAttempt();
            return redirect()->back()->withInput()
                ->with('error', 'NIM / Username atau Password salah');
        }

        // reset login gagal counter jika login berhasil
        $this->resetFailedAttempts();

        // JWT
        $key = getenv('JWT_SECRET') ?: 'bin2hex(random_bytes(32))';
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

    } catch (\Exception $e) {
        log_message('error', $e->getMessage());

        // menangani error rate limit secara khusus
        if (str_contains($e->getMessage(), 'Terlalu banyak percobaan')) {
            return redirect()->back()->withInput()
                ->with('error', $e->getMessage());
        }

        return redirect()->back()->with('error', 'Terjadi kesalahan saat login');
    }
}



    public function logout()
{
    session()->remove('user');
    session()->destroy();

    return redirect()->to('/login')->with('success', 'Berhasil logout');
}

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
    $publikasiModel = new PublikasiModel();
    $proyekModel    = new ProyekRisetModel();

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
    // Debug code removed for production

    // 6. Siapkan data untuk dikirim ke view
    $data = [
        'title'           => 'Profil Saya | ' . $user['nama'],
        'user'            => $user,
        'publicationData' => $publicationData,
        'proyekData'      => $proyekData
    ];

    return view('auth/profile', $data);
}

    /**
     * Rate Limiting Methods
     */
    private function checkRateLimit()
    {
        $ip = $this->request->getIPAddress();
        $attempts = session()->get('login_attempts_' . $ip) ?? 0;
        $lastAttempt = session()->get('last_attempt_' . $ip) ?? 0;

        // Reset counter if more than 1 minute has passed
        if (time() - $lastAttempt > 60) { // 1 minute
            $this->resetFailedAttempts();
            return;
        }

        // Block if too many attempts
        if ($attempts >= 5) { // Max 5 attempts per minute
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

        // Log failed login attempts for security monitoring
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

    // untuk generate captcha sederhana (misal: 2 angka + atau -)
    public function generateCaptcha()
    {
        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        $operation = rand(0, 1) ? '+' : '-';

        if ($operation === '-') {
            // hasil harus selalu +
            if ($num1 < $num2) {
                [$num1, $num2] = [$num2, $num1];
            }
        }

        $question = "$num1 $operation $num2";
        $answer = $operation === '+' ? $num1 + $num2 : $num1 - $num2;

        // simpan hasil di session untuk verifikasi
        session()->set('captcha_answer', $answer);

        return $this->response->setJSON([
            'question' => $question,
            'success' => true
        ]);
    }

    /**
     * Verify captcha answer
     */
    private function verifyCaptcha($userAnswer)
    {
        $correctAnswer = session()->get('captcha_answer');
        return $userAnswer == $correctAnswer;
    }

    /**
     * Check if IP is blocked due to security violations
     */
    private function isIPBlocked()
    {
        $ip = $this->request->getIPAddress();

        // Check permanent blacklist (implement in database for production)
        $blacklist = ['127.0.0.1']; // Example - implement proper blacklist
        if (in_array($ip, $blacklist)) {
            return true;
        }

        // Check temporary block (too many failed attempts in short time)
        $failedCount = session()->get('login_attempts_' . $ip) ?? 0;
        $lastAttempt = session()->get('last_attempt_' . $ip) ?? 0;

        // Block permanently if more than 10 failed attempts in 24 hours
        if ($failedCount >= 10 && (time() - $lastAttempt) < 86400) { // 24 hours
            // Log permanent block
            log_message('critical', 'IP permanently blocked due to excessive failed attempts: ' . $ip);
            return true;
        }

        return false;
    }

}
