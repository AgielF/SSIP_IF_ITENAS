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

if (!function_exists('hasPermission')) {
    function hasPermission($menuKey, $action = null)
    {
        $session = session();
        $user = $session->get('user');
        if (!$user) {
            return false;
        }

        $userRole = (int)($user['role_id'] ?? 0);

        // Admin (Role 1) memiliki akses ke semua menu/fitur secara default
        if ($userRole === 1) {
            return true;
        }

        // Penanganan khusus untuk menu aksi tunggal (non-CRUD)
        $singleActionMenus = ['jadwal_saya', 'sertifikat_klaim'];
        if (in_array($menuKey, $singleActionMenus)) {
            $fullPermissionKey = $menuKey;
        } else {
            $suffix = $action ? '_' . $action : '_view';
            $fullPermissionKey = $menuKey . $suffix;
        }

        $rolePermModel = new \App\Models\RolePermissionModel();
        $allowedMenus = $rolePermModel->getRoleMenus($userRole);

        return in_array($fullPermissionKey, $allowedMenus);
    }
}
