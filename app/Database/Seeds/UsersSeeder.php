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
                'nomor' => '152022003',
                'nama' => 'Ahmad Rizki',
                'no_telp' => '08345678901',
                'jurusan' => 'Informatika',
                'role_id' => 3, // mahasiswa
                'password' => 'mahasiswa123', // Delete kalau kebutuhan yang harus password unique
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nomor' => '152022004',
                'nama' => 'Siti Nurhaliza',
                'no_telp' => '08456789012',
                'jurusan' => 'Informatika',
                'role_id' => 3, // mahasiswa
                'password' => 'mahasiswa123', // Delete kalau kebutuhan yang harus password unique
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nomor' => '152022005',
                'nama' => 'Budi Santoso',
                'no_telp' => '08567890123',
                'jurusan' => 'Informatika',
                'role_id' => 3, // mahasiswa
                'password' => 'mahasiswa123', // Delete kalau kebutuhan yang harus password unique
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nomor' => '152022006',
                'nama' => 'Dewi Sartika',
                'no_telp' => '08678901234',
                'jurusan' => 'Informatika',
                'role_id' => 3, // mahasiswa
                'password' => 'mahasiswa123', // Delete kalau kebutuhan yang harus password unique
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nomor' => '152022007',
                'nama' => 'Rizki Pratama',
                'no_telp' => '08789012345',
                'jurusan' => 'Informatika',
                'role_id' => 3, // mahasiswa
                'password' => 'mahasiswa123', // Delete kalau kebutuhan yang harus password unique
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nomor' => '152022008',
                'nama' => 'Nina Safitri',
                'no_telp' => '08890123456',
                'jurusan' => 'Informatika',
                'role_id' => 3, // mahasiswa
                'password' => 'mahasiswa123', // Delete kalau kebutuhan yang harus password unique
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nomor' => '152022009',
                'nama' => 'Muhammad Fadli',
                'no_telp' => '08901234567',
                'jurusan' => 'Informatika',
                'role_id' => 3, // mahasiswa
                'password' => 'mahasiswa123', // Delete kalau kebutuhan yang harus password unique
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nomor' => '152022010',
                'nama' => 'Anisa Putri',
                'no_telp' => '08912345678',
                'jurusan' => 'Informatika',
                'role_id' => 3, // mahasiswa
                'password' => 'mahasiswa123', // Delete kalau kebutuhan yang harus password unique
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nomor' => 'D001',
                'nama' => 'Dr. Sarah Wijaya',
                'no_telp' => '08111222333',
                'jurusan' => 'Informatika',
                'role_id' => 4, // dosen
                'password' => 'dosen123', // Delete kalau kebutuhan yang harus password unique
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nomor' => 'D002',
                'nama' => 'Prof. Bambang Sutrisno',
                'no_telp' => '08222333444',
                'jurusan' => 'Informatika',
                'role_id' => 4, // dosen
                'password' => 'dosen123', // Delete kalau kebutuhan yang harus password unique
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Cek users ada atau tidak
        foreach ($data as $user) {
            $existing = $this->db->table('users')->where('nomor', $user['nomor'])->get()->getRow();
            if ($existing) {
                // Update password
                $this->db->table('users')->where('nomor', $user['nomor'])->update([
                    'password' => $user['password'],
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                // Add user baru
                $this->db->table('users')->insert($user);
            }
        }
    }
}