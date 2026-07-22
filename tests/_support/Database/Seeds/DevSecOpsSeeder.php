<?php

namespace Tests\Support\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DevSecOpsSeeder extends Seeder
{
    public function run()
    {
        // 1. Insert Roles (if not exists)
        $roles = [
            ['id' => 1, 'role_name' => 'Admin'],
            ['id' => 2, 'role_name' => 'Asisten'],
            ['id' => 3, 'role_name' => 'Dosen'],
            ['id' => 4, 'role_name' => 'Mahasiswa'],
        ];
        $this->db->table('roles')->ignore(true)->insertBatch($roles);

        // 2. Insert Users for testing
        $users = [
            [
                'id'       => 1,
                'nomor'    => '111111111',
                'nama'     => 'Admin Test',
                'no_telp'  => '08123456789',
                'jurusan'  => 'Informatika',
                'password' => password_hash('password123', PASSWORD_BCRYPT),
                'role_id'  => 1,
            ],
            [
                'id'       => 2,
                'nomor'    => '222222222',
                'nama'     => 'Asisten Test',
                'no_telp'  => '08123456789',
                'jurusan'  => 'Informatika',
                'password' => password_hash('password123', PASSWORD_BCRYPT),
                'role_id'  => 2,
            ],
            [
                'id'       => 3,
                'nomor'    => '333333333',
                'nama'     => 'Dosen Test',
                'no_telp'  => '08123456789',
                'jurusan'  => 'Informatika',
                'password' => password_hash('password123', PASSWORD_BCRYPT),
                'role_id'  => 3,
            ]
        ];
        $this->db->table('users')->ignore(true)->insertBatch($users);

        // 3. Insert Ruangan
        $ruangan = [
            ['id_ruangan' => 1, 'nama_ruangan' => 'Lab Komputer Dasar'],
        ];
        $this->db->table('ruangan')->ignore(true)->insertBatch($ruangan);

        // 4. Insert Event
        $events = [
            ['id_event' => 1, 'nama_event' => 'Praktikum Pemrograman', 'deskripsi' => 'Test Deskripsi', 'jenis' => 'Praktikum', 'created_by' => 1],
        ];
        $this->db->table('events')->ignore(true)->insertBatch($events);

        // 5. Insert Periode
        $periode = [
            ['id_periode' => 1, 'nama_periode' => 'Ganjil 2026/2027', 'tahun' => '2026', 'status_aktif' => 'aktif'],
        ];
        $this->db->table('periode')->ignore(true)->insertBatch($periode);
    }
}
