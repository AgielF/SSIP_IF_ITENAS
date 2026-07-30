<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\RolePermissionModel;
use Config\Services;

class PermissionFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Ensure user is logged in via session
        $sessionUser = session()->get('user');
        
        if (!$sessionUser) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userRole = (int)($sessionUser['role_id'] ?? 0);

        // 2. Admin (Role 1) has access to everything
        if ($userRole === 1) {
            return; 
        }

        // 3. Extract the required menu key from arguments (e.g. ['galeri_admin'])
        $requiredMenu = $arguments[0] ?? null;

        if ($requiredMenu) {
            $permModel = new RolePermissionModel();
            $allowedMenus = $permModel->getRoleMenus($userRole);

            if (!in_array($requiredMenu, $allowedMenus)) {
                return redirect()->to('/')->with('error', 'Anda tidak memiliki hak akses ke halaman tersebut.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
