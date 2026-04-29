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
                'nama_periode' => '2022/2023',
                'tahun' => 2022,
            ],
            [
                'nama_periode' => '2023/2024',
                'tahun' => 2023,
            ],
            [
                'nama_periode' => '2024/2025',
                'tahun' => 2024,
            ],
            [
                'nama_periode' => '2025/2026',
                'tahun' => 2025,
            ],
        ];

        foreach ($periodeData as $periode) {
            // Cek apakah periode sudah ada berdasarkan nama_periode
            $existing = $this->db->table('periode')->where('nama_periode', $periode['nama_periode'])->get()->getRow();
            if (!$existing) {
                $periode['created_at'] = Time::now();
                $periode['updated_at'] = Time::now();
                $this->db->table('periode')->insert($periode);
            }
        }
    }
}