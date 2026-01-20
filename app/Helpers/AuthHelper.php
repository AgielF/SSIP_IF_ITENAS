<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function checkAdminToken()
{
    $session = session();
    $token = $session->get('jwt');

    if (!$token) {
        return ['status' => false, 'message' => 'Token required'];
    }

    try {
        $key = getenv('JWT_SECRET') ?: 'your-secret-key';
        $decoded = JWT::decode($token, new Key($key, 'HS256'));

        if ((int)$decoded->role_id !== 1) {
            return ['status' => false, 'message' => 'Access denied. Admin only.'];
        }

        return ['status' => true, 'data' => $decoded];
    } catch (\Exception $e) {
        return ['status' => false, 'message' => 'Token invalid: ' . $e->getMessage()];
    }
}
