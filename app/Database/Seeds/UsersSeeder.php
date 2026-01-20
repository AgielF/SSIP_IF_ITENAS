<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nomor' => '152022001',
                'nama' => 'Jeffry Sukmawidiajja',
                'no_telp' => '08123456789',
                'jurusan' => 'Informatika',
                'role_id' => 1, // admin
                'password' => 'admin123', // Delete kalau kebutuhan yang harus password unique
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nomor' => '152022002',
                'nama' => 'Mohammad Rohman',
                'no_telp' => '08234567890',
                'jurusan' => 'Informatika',
                'role_id' => 2, // asisten
                'password' => 'asisten123', // Delete kalau kebutuhan yang harus password unique
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nomor' => 'D001',
                'nama' => 'Dr. Sarah Wijaya',
                'no_telp' => '08111222333',
                'jurusan' => 'Informatika',
                'role_id' => 3, // dosen
                'password' => 'dosen123', // Delete kalau kebutuhan yang harus password unique
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nomor' => 'D002',
                'nama' => 'Prof. Bambang Sutrisno',
                'no_telp' => '08222333444',
                'jurusan' => 'Informatika',
                'role_id' => 3, // dosen
                'password' => 'dosen123', // Delete kalau kebutuhan yang harus password unique
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nomor' => '152022005',
                'nama' => 'Ahmad Fauzi',
                'no_telp' => '08555666777',
                'jurusan' => 'Informatika',
                'role_id' => 2, // asisten
                'password' => 'asisten123',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Cek users ada atau tidak
        foreach ($data as $user) {
            $existing = $this->db->table('users')->where('nomor', $user['nomor'])->get()->getRow();
            if ($existing) {
                // Update data kecuali password (jangan timpa password yang sudah di-hash)
                $updateData = [
                    'nama' => $user['nama'],
                    'no_telp' => $user['no_telp'],
                    'jurusan' => $user['jurusan'],
                    'role_id' => $user['role_id'],
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $this->db->table('users')->where('nomor', $user['nomor'])->update($updateData);
            } else {
                // Add user baru - pastikan password di-hash
                $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
                $this->db->table('users')->insert($user);
            }
        }

        // Pastikan semua password ter-hash setelah seeding
        $this->ensureAllPasswordsHashed();
    }

    /**
     * Pastikan semua password di database sudah ter-hash
     */
    private function ensureAllPasswordsHashed()
    {
        $users = $this->db->table('users')->get()->getResultArray();

        foreach ($users as $user) {
            $passwordInfo = password_get_info($user['password']);

            // Jika password belum di-hash, hash sekarang
            if ($passwordInfo['algo'] === 0) {
                $hashed = password_hash($user['password'], PASSWORD_DEFAULT);
                $this->db->table('users')
                         ->where('id', $user['id'])
                         ->update(['password' => $hashed]);
            }
        }
    }
}