<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JadwalSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Praktikum Machine Learning (id_event = 1)
            [
                'id_event'   => 1,
                'tanggal'    => '2025-12-02',
                'waktu_mulai'  => '08:00:00',
                'waktu_selesai'=> '10:00:00',
                'ruangan'      => 'Lab Komputer 1',
                'kelas'       => 'A',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'id_event'   => 1,
                'tanggal'    => '2025-12-09',
                'waktu_mulai'  => '13:00:00',
                'waktu_selesai'=> '15:00:00',
                'ruangan'      => 'Lab Komputer 1',
                'kelas'       => 'B',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],

            // Deep Learning (id_event = 2)
            [
                'id_event'   => 2,
                'tanggal'    => '2025-12-03',
                'waktu_mulai'  => '09:00:00',
                'waktu_selesai'=> '11:00:00',
                'ruangan'      => 'Lab Komputer 2',
                'kelas'       => 'A',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'id_event'   => 2,
                'tanggal'    => '2025-12-10',
                'waktu_mulai'  => '14:00:00',
                'waktu_selesai'=> '16:00:00',
                'ruangan'      => 'Lab Komputer 2',
                'kelas'       => 'B',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],

            // Expert System (id_event = 3)
            [
                'id_event'   => 3,
                'tanggal'    => '2025-12-04',
                'waktu_mulai'  => '10:00:00',
                'waktu_selesai'=> '12:00:00',
                'ruangan'      => 'Lab Komputer 3',
                'kelas'       => 'A',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'id_event'   => 3,
                'tanggal'    => '2025-12-11',
                'waktu_mulai'  => '13:30:00',
                'waktu_selesai'=> '15:30:00',
                'ruangan'      => 'Lab Komputer 3',
                'kelas'       => 'B',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],

            // Artificial Intelligence (id_event = 4)
            [
                'id_event'   => 4,
                'tanggal'    => '2025-12-05',
                'waktu_mulai'  => '08:30:00',
                'waktu_selesai'=> '10:30:00',
                'ruangan'      => 'Lab Komputer 4',
                'kelas'       => 'A',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'id_event'   => 4,
                'tanggal'    => '2025-12-12',
                'waktu_mulai'  => '14:30:00',
                'waktu_selesai'=> '16:30:00',
                'ruangan'      => 'Lab Komputer 4',
                'kelas'       => 'B',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],

            // Smart System (id_event = 5)
            [
                'id_event'   => 5,
                'tanggal'    => '2025-12-06',
                'waktu_mulai'  => '09:30:00',
                'waktu_selesai'=> '11:30:00',
                'ruangan'      => 'Lab Sistem Cerdas',
                'kelas'       => 'A',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'id_event'   => 5,
                'tanggal'    => '2025-12-13',
                'waktu_mulai'  => '13:00:00',
                'waktu_selesai'=> '15:00:00',
                'ruangan'      => 'Lab Sistem Cerdas',
                'kelas'       => 'B',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],

            // Data Mining (id_event = 6)
            [
                'id_event'   => 6,
                'tanggal'    => '2025-12-07',
                'waktu_mulai'  => '10:30:00',
                'waktu_selesai'=> '12:30:00',
                'ruangan'      => 'Lab Data Mining',
                'kelas'       => 'A',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'id_event'   => 6,
                'tanggal'    => '2025-12-14',
                'waktu_mulai'  => '14:00:00',
                'waktu_selesai'=> '16:00:00',
                'ruangan'      => 'Lab Data Mining',
                'kelas'       => 'B',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
        ];

        // Check if jadwal already exist
        foreach ($data as $jadwal) {
            $existing = $this->db->table('jadwal')->where('id_event', $jadwal['id_event'])->where('tanggal', $jadwal['tanggal'])->get()->getRow();
            if (!$existing) {
                $this->db->table('jadwal')->insert($jadwal);
            }
        }
    }
}