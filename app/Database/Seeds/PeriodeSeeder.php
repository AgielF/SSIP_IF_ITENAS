<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class PeriodeSeeder extends Seeder
{
    public function run()
    {
        $periodeData = [
            [
                'nama_periode' => 'Genap 2022/2023',
                'tahun' => 2022,
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
            [
                'nama_periode' => 'Genap 2023/2024',
                'tahun' => 2023,
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
            [
                'nama_periode' => 'Genap 2024/2025',
                'tahun' => 2024,
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
            [
                'nama_periode' => 'Genap 2025/2026',
                'tahun' => 2025,
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
        ];

        $this->db->table('periode')->insertBatch($periodeData);
    }
}