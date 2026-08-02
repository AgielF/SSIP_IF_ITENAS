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
        // Menu berskala CRUD
        $crudMenus = [
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
        ];

        // Menu Aksi Tunggal (Non-CRUD)
        $singleMenus = [
            'jadwal_saya'      => 'Jadwal Saya',
            'sertifikat_klaim' => 'Klaim Sertifikat'
        ];

        // Hanya kelola Role 2 (Asisten) dan Role 3 (Dosen)
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
            'crudMenus'          => $crudMenus,
            'singleMenus'        => $singleMenus,
            'rolesToManage'      => $rolesToManage,
            'currentPermissions' => $currentPermissions
        ];

        return view('hak_akses_admin_view', $data);
    }

    public function update()
    {
        $permissions = $this->request->getPost('permissions') ?? [];
        $rolesToManage = [2, 3]; // 2: Asisten, 3: Dosen

        $this->permissionModel->db->transStart();

        foreach ($rolesToManage as $roleId) {
            $rolePermissions = $permissions[$roleId] ?? [];

            // Hapus hak akses lama untuk role ini
            $this->permissionModel->where('role_id', $roleId)->delete();

            // Insert hak akses baru jika ada yang dipilih
            if (!empty($rolePermissions) && is_array($rolePermissions)) {
                $data = [];
                foreach ($rolePermissions as $key) {
                    $data[] = [
                        'role_id'  => $roleId,
                        'menu_key' => $key
                    ];
                }
                $this->permissionModel->insertBatch($data);
            }
        }

        $this->permissionModel->db->transComplete();

        if ($this->permissionModel->db->transStatus()) {
            return redirect()->back()->with('success', 'Semua hak akses berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui hak akses.');
        }
    }
}
