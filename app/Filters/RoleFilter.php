<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $token = null;

        // cek token di session
        if (session()->has('token')) {
            $token = session()->get('token');
        }

        // cek di header Authorization
        if (!$token) {
            $authHeader = $request->getHeaderLine('Authorization');
            if ($authHeader && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                $token = $matches[1];
            }
        }

        if (!$token) {
            return Services::response()
                ->setJSON(['status' => 'error', 'message' => 'Token required'])
                ->setStatusCode(401);
        }

        try {
            $decoded = JWT::decode($token, new Key(getenv('JWT_SECRET') ?: 'your-secret-key', 'HS256'));

            // 🔹 Ambil role yang diizinkan dari $arguments
            $allowedRoles = $arguments ?? [];

            if (!in_array($decoded->role_id, $allowedRoles)) {
                return Services::response()
                    ->setJSON(['status' => 'error', 'message' => 'Access denied'])
                    ->setStatusCode(403);
            }

            // simpan user supaya bisa dipakai di controller
            $request->user = $decoded;

        } catch (\Exception $e) {
            return Services::response()
                ->setJSON([
                    'status' => 'error',
                    'message' => 'Invalid token',
                    'error' => $e->getMessage()
                ])
                ->setStatusCode(401);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
