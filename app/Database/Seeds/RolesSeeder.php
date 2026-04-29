<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $roleData = [
            ['role_name' => 'admin'],
            ['role_name' => 'asisten'],
            ['role_name' => 'dosen'],
            ['role_name' => 'praktikan']
        ];

        foreach ($roleData as $role) {
            // Cek apakah role sudah ada berdasarkan role_name
            $existing = $this->db->table('roles')->where('role_name', $role['role_name'])->get()->getRow();
            if (!$existing) {
                $this->db->table('roles')->insert($role);
            }
        }
    }
}
