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
            $path = strtolower($request->getUri()->getPath());
            $suffix = '_view'; // Aksi default adalah view

            if (strpos($path, 'create') !== false || strpos($path, 'store') !== false || strpos($path, 'add') !== false) {
                $suffix = '_create';
            } elseif (strpos($path, 'update') !== false || strpos($path, 'edit') !== false || strpos($path, 'config') !== false || strpos($path, 'status') !== false || strpos($path, 'sync') !== false) {
                $suffix = '_update';
            } elseif (strpos($path, 'delete') !== false || strpos($path, 'remove') !== false) {
                $suffix = '_delete';
            }

            // Kecualikan menu aksi tunggal (non-CRUD) dari penambahan suffix
            $singleActionMenus = ['jadwal_saya', 'sertifikat_klaim'];
            $fullPermissionKey = in_array($requiredMenu, $singleActionMenus) ? $requiredMenu : $requiredMenu . $suffix;

            $permModel = new RolePermissionModel();
            $allowedMenus = $permModel->getRoleMenus($userRole);

            if (!in_array($fullPermissionKey, $allowedMenus)) {
                $isAjax = $request->isAJAX() || $request->hasHeader('X-Requested-With');
                if ($isAjax) {
                    return Services::response()
                        ->setJSON([
                            'status' => 'error',
                            'message' => 'Anda tidak memiliki akses untuk melakukan tindakan ini.',
                            'success' => false
                        ])
                        ->setStatusCode(403);
                }
                return redirect()->to('/')->with('error', 'Anda tidak memiliki hak akses untuk melakukan aksi ini.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
