<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RolePermissionModel;

class HakAksesController extends BaseController
{
    protected $permissionModel;

    public function __construct()
    {
        $this->permissionModel = new RolePermissionModel();
    }

    public function index()
    {
        // Define all available menus that can be assigned
        $availableMenus = [
            'asisten_admin'           => 'Kelola Users',
            'events_admin'            => 'Kelola Events',
            'ruangan_admin'           => 'Kelola Ruangan',
            'rekrutmen_admin'         => 'Kelola Rekrutmen',
            'berita_admin'            => 'Kelola Berita',
            'penelitian_proyek_admin' => 'Kelola Penelitian Proyek',
            'publikasi_ilmiah_admin'  => 'Kelola Publikasi Ilmiah',
            'galeri_admin'            => 'Kelola Galeri',
            'modul_praktikum_admin'   => 'Kelola Modul',
            'jadwal_admin'            => 'Kelola Jadwal',
            'project_lab_admin'       => 'Kelola Project Laboratorium',
            'visi_misi_admin'         => 'Kelola Content Visi Misi',
            'periode_admin'           => 'Kelola Periode Asisten',
            'sertifikat_admin'        => 'Kelola Sertifikat',
            // asisten specific
            'jadwal_saya'             => 'Jadwal Saya',
            'sertifikat_klaim'        => 'Klaim Sertifikat'
        ];

        // We only manage Role 2 (Asisten) and Role 3 (Dosen)
        $rolesToManage = [
            2 => 'Asisten',
            3 => 'Dosen'
        ];

        $currentPermissions = [];
        foreach ($rolesToManage as $roleId => $roleName) {
            $currentPermissions[$roleId] = $this->permissionModel->getRoleMenus($roleId);
        }

        $data = [
            'title'              => 'Kelola Hak Akses (RBAC)',
            'availableMenus'     => $availableMenus,
            'rolesToManage'      => $rolesToManage,
            'currentPermissions' => $currentPermissions
        ];

        return view('hak_akses_admin_view', $data);
    }

    public function update()
    {
        $roleId = $this->request->getPost('role_id');
        $permissions = $this->request->getPost('permissions') ?? [];

        if (!$roleId) {
            return redirect()->back()->with('error', 'Role ID tidak valid.');
        }

        if ($this->permissionModel->updateRolePermissions($roleId, $permissions)) {
            return redirect()->back()->with('success', 'Hak akses berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui hak akses.');
        }
    }
}
