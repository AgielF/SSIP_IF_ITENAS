<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nrp' => '123456789',
                'nama' => 'Budi',
                'no_telp' => '08123456789',
                'jurusan' => 'Informatika',
                'role_id' => 1, // pastikan role_id sesuai data di roles
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            // Tambahkan data lain sesuai kebutuhan
        ];

        foreach ($data as $user) {
            $this->db->table('users')->insert($user);
        }
    }
}