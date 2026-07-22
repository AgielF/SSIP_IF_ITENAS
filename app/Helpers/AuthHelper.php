<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Libraries\JwtHelper;

/**
 * [T1.2] Fungsi helper untuk validasi token admin.
 * Menggunakan JwtHelper terpusat — tidak ada lagi hardcoded secret.
 */
function checkAdminToken()
{
    $session = session();
    $token   = $session->get('jwt');

    if (!$token) {
        return ['status' => false, 'message' => 'Token required'];
    }

    try {
        // [T1.2] Gunakan JwtHelper terpusat
        $key     = JwtHelper::getSecretKey();
        $decoded = JWT::decode($token, new Key($key, 'HS256'));

        if ((int)$decoded->role_id !== 1) {
            return ['status' => false, 'message' => 'Access denied. Admin only.'];
        }

        return ['status' => true, 'data' => $decoded];
    } catch (\Exception $e) {
        return ['status' => false, 'message' => 'Token invalid: ' . $e->getMessage()];
    }
}
