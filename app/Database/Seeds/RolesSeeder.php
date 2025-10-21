<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['role_name' => 'admin'],
            ['role_name' => 'asisten'],
            ['role_name' => 'dosen'],
        ];

        foreach ($data as $role) {
            $existing = $this->db->table('roles')->where('role_name', $role['role_name'])->get()->getRow();
            if (!$existing) {
                $this->db->table('roles')->insert($role);
            }
        }
    }
}
