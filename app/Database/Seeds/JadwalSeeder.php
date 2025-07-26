<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JadwalSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_event'   => 1,
                'tanggal'    => '2025-08-01',
                'waktu_mulai'  => '08:00:00',
                'waktu_selesai'=> '10:00:00',
                'ruangan'      => 'Lab 1',
            ],
            [
                'id_event'   => 2,
                'tanggal'    => '2025-08-05',
                'waktu_mulai'  => '13:00:00',
                'waktu_selesai'=> '15:00:00',
                'ruangan'      => 'Aula',
            ],
        ];

        foreach ($data as $jadwal) {
            $this->db->table('jadwal')->insert($jadwal);
        }
    }
}