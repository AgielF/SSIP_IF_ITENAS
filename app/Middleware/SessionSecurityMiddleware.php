<?php

namespace App\Middleware;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Middleware\BaseMiddleware;

class SessionSecurityMiddleware extends BaseMiddleware
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Skip middleware for login, register, and static assets
        $uri = $request->getUri()->getPath();
        if (in_array($uri, ['/login', '/register']) ||
            strpos($uri, '/assets/') === 0 ||
            strpos($uri, '/css/') === 0 ||
            strpos($uri, '/js/') === 0 ||
            strpos($uri, '/images/') === 0) {
            return;
        }

        // Check session timeout (2 hours)
        $loginTime = session()->get('login_time');
        if ($loginTime && (time() - $loginTime) > 7200) { // 2 hours
            session()->destroy();
            return redirect()->to('/login')->with('error', 'Sesi telah berakhir. Silakan login kembali.');
        }

        // Check user activity timeout (30 minutes)
        $lastActivity = session()->get('last_activity');
        if ($lastActivity && (time() - $lastActivity) > 1800) { // 30 minutes
            session()->destroy();
            return redirect()->to('/login')->with('error', 'Sesi tidak aktif terlalu lama. Silakan login kembali.');
        }

        // Update last activity
        session()->set('last_activity', time());

        // Validate user session
        $user = session()->get('user');
        if (!$user && !in_array($uri, ['/', '/about', '/contact'])) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Validate JWT token if exists
        $token = session()->get('token');
        if ($token) {
            try {
                $key = getenv('JWT_SECRET') ?: 'fallback-secret-key';
                $decoded = \Firebase\JWT\JWT::decode($token, new \Firebase\JWT\Key($key, 'HS256'));

                // Check if token is expired
                if ($decoded->exp < time()) {
                    session()->destroy();
                    return redirect()->to('/login')->with('error', 'Token telah kadaluarsa. Silakan login kembali.');
                }
            } catch (\Exception $e) {
                log_message('error', 'JWT validation failed: ' . $e->getMessage());
                session()->destroy();
                return redirect()->to('/login')->with('error', 'Sesi tidak valid. Silakan login kembali.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Add security headers if not already set
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