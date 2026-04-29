<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $token = null;

        // 🔹 1. Cek token di session
        if (session()->has('token')) {
            $token = session()->get('token');
        }

        // 🔹 2. Kalau tidak ada di session, cek di Authorization header
        if (!$token) {
            $authHeader = $request->getHeaderLine('Authorization');
            if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                $token = $matches[1];
            }
        }

        // 🔹 3. Kalau tetap tidak ada, tolak akses
        if (!$token) {
            // Check if it's an API request or AJAX request
            $path = $request->getUri()->getPath();
            $isApi = strpos($path, '/api/') === 0;
            $isAjax = $request->isAJAX() || $request->hasHeader('X-Requested-With');
            
            if ($isApi || $isAjax) {
                return Services::response()
                    ->setJSON(['status' => 'error', 'message' => 'Token required', 'success' => false])
                    ->setStatusCode(401);
            } else {
                return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
            }
        }

        try {
            $jwtSecret = getenv('JWT_SECRET');
            if (empty($jwtSecret) || strlen($jwtSecret) < 32) {
                log_message('error', 'JWT_SECRET not set or too short! This is a security risk.');
                if (ENVIRONMENT === 'production') {
                    throw new \RuntimeException('JWT_SECRET must be configured with minimum 32 characters in production environment');
                }
                $jwtSecret = bin2hex(random_bytes(32)); // Generate secure fallback for development
            }
            $decoded = JWT::decode($token, new Key($jwtSecret, 'HS256'));

            // 🔹 cek role admin
            if ($decoded->role_id != 1) {
                // Check if API or AJAX
                $path = $request->getUri()->getPath();
                $isApi = strpos($path, '/api/') === 0;
                $isAjax = $request->isAJAX() || $request->hasHeader('X-Requested-With');
                
                if ($isApi || $isAjax) {
                    return Services::response()
                        ->setJSON(['status' => 'error', 'message' => 'Access denied', 'success' => false])
                        ->setStatusCode(403);
                } else {
                    return redirect()->to('/')->with('error', 'Akses ditolak.');
                }
            }

            // simpan user agar bisa dipakai controller
            $request->user = $decoded;

        } catch (\Exception $e) {
            // Check if API or AJAX
            $path = $request->getUri()->getPath();
            $isApi = strpos($path, '/api/') === 0;
            $isAjax = $request->isAJAX() || $request->hasHeader('X-Requested-With');
            
            if ($isApi || $isAjax) {
                return Services::response()
                    ->setJSON([
                        'status' => 'error',
                        'message' => 'Invalid token',
                        'success' => false,
                        'error' => $e->getMessage()
                    ])
                    ->setStatusCode(401);
            } else {
                return redirect()->to('/login')->with('error', 'Sesi tidak valid, silakan login kembali.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // tidak perlu
    }
}
