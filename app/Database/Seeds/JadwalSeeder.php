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
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'id_event'   => 2,
                'tanggal'    => '2025-08-05',
                'waktu_mulai'  => '13:00:00',
                'waktu_selesai'=> '15:00:00',
                'ruangan'      => 'Aula',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'id_event'   => 3,
                'tanggal'    => '2025-08-10',
                'waktu_mulai'  => '09:00:00',
                'waktu_selesai'=> '11:00:00',
                'ruangan'      => 'Lab 2',
                'created_at'   => date('Y-m-d H:i:s'),
                'updated_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'id_event'   => 1,
                'tanggal'    => '2025-08-15',
                'waktu_mulai'  => '14:00:00',
                'waktu_selesai'=> '16:00:00',
                'ruangan'      => 'Lab 3',
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