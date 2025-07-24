<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['nama_role' => 'admin'],
            ['nama_role' => 'asisten'],
            ['nama_role' => 'mahasiswa'],
        ];

        // Simple Queries
        foreach ($data as $role) {
            $this->db->table('roles')->insert($role);
        }
    }
}
