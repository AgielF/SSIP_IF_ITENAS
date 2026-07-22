<?php

namespace App\Middleware;

use CodeIgniter\Filters\FilterInterface; // Mengganti BaseMiddleware dengan FilterInterface bawaan CI4
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\JwtHelper;

// Ubah 'extends BaseMiddleware' menjadi 'implements FilterInterface'
class SessionSecurityMiddleware implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $uri = $request->getUri()->getPath();

        // 1. Pengecualian Route (Sangat penting agar proses login tidak dicegat)
        if (in_array($uri, ['/login', '/register', '/api/auth/login']) ||
            strpos($uri, '/assets/') === 0 ||
            strpos($uri, '/css/') === 0 ||
            strpos($uri, '/js/') === 0 ||
            strpos($uri, '/images/') === 0) {
            return;
        }

        // 2. Cek Timeout Sesi Login (Disinkronkan jadi 1 Jam / 3600 detik)
        $loginTime = session()->get('login_time');
        if ($loginTime && (time() - $loginTime) > 3600) { 
            session()->destroy();
            return redirect()->to('/login')->with('error', 'Sesi telah berakhir (1 Jam). Silakan login kembali.');
        }

        // 3. Cek Timeout Aktivitas Idle (Tetap 30 Menit / 1800 detik)
        $lastActivity = session()->get('last_activity');
        if ($lastActivity && (time() - $lastActivity) > 1800) { 
            session()->destroy();
            return redirect()->to('/login')->with('error', 'Anda tidak aktif selama 30 menit. Silakan login kembali.');
        }

        // Update waktu aktivitas terakhir jika masih aktif
        session()->set('last_activity', time());

        // 4. Cek apakah Session User ada
        $user = session()->get('user');
        if (!$user && !in_array($uri, ['/', '/about', '/contact'])) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // 5. Validasi Token JWT
        $token = session()->get('token');
        if ($token) {
            try {
                // [T1.2] Gunakan JwtHelper terpusat — tidak ada lagi hardcoded fallback.
                $key     = JwtHelper::getSecretKey();
                $decoded = \Firebase\JWT\JWT::decode($token, new \Firebase\JWT\Key($key, 'HS256'));

                // Cek kadaluarsa Token
                if ($decoded->exp < time()) {
                    session()->destroy();
                    return redirect()->to('/login')->with('error', 'Token telah kadaluarsa. Silakan login kembali.');
                }
            } catch (\Exception $e) {
                log_message('error', 'JWT validation failed: ' . $e->getMessage());
                session()->destroy();
                return redirect()->to('/login')->with('error', 'Sesi tidak valid atau telah dirusak. Silakan login kembali.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Headers keamanan
        if (!$response->hasHeader('X-Frame-Options')) {
            $response->setHeader('X-Frame-Options', 'DENY');
        }
        if (!$response->hasHeader('X-Content-Type-Options')) {
            $response->setHeader('X-Content-Type-Options', 'nosniff');
        }
        if (!$response->hasHeader('X-XSS-Protection')) {
            $response->setHeader('X-XSS-Protection', '1; mode=block');
        }
    }
}