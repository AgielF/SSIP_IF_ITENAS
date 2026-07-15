<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class RuanganSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_ruangan' => 'Lab Komputer 1',
                'kapasitas'    => 40,
                'created_at'   => Time::now(),
                'updated_at'   => Time::now(),
            ],
            [
                'nama_ruangan' => 'Lab Komputer 2',
                'kapasitas'    => 40,
                'created_at'   => Time::now(),
                'updated_at'   => Time::now(),
            ],
            [
                'nama_ruangan' => 'Lab Komputer 3',
                'kapasitas'    => 40,
                'created_at'   => Time::now(),
                'updated_at'   => Time::now(),
            ],
            [
                'nama_ruangan' => 'Lab Komputer 4',
                'kapasitas'    => 40,
                'created_at'   => Time::now(),
                'updated_at'   => Time::now(),
            ],
            [
                'nama_ruangan' => 'Lab Sistem Cerdas',
                'kapasitas'    => 30,
                'created_at'   => Time::now(),
                'updated_at'   => Time::now(),
            ],
            [
                'nama_ruangan' => 'Lab Data Mining',
                'kapasitas'    => 30,
                'created_at'   => Time::now(),
                'updated_at'   => Time::now(),
            ]
        ];

        // Insert data ke tabel ruangan
        $this->db->table('ruangan')->insertBatch($data);
    }
}
