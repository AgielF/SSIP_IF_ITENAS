<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class AsistenPeriodeSeeder extends Seeder
{
    public function run()
    {
        // Ambil semua asisten (role_id = 2) dari tabel users
        $asisten = $this->db->table('users')
            ->where('role_id', 2)
            ->get()
            ->getResultArray();

        $asistenPeriodeData = [];

        // Assign asisten ke periode berdasarkan pola
        // Asisten dengan nomor 1520220XX ke periode 2022/2023
        // Asisten dengan nomor 1520230XX ke periode 2023/2024 (jika ada)
        // Dan seterusnya

        foreach ($asisten as $person) {
            // cek apakah asisten sudah memiliki relasi dengan periode
            $existingRelation = $this->db->table('asisten_periode')
                ->where('id_user', $person['id'])
                ->get()
                ->getRow();

            if (!$existingRelation) {
                // Ekstrak tahun dari nomor (format: 15202[tahun]00X)
                $nomor = $person['nomor'];
                $tahun = substr($nomor, 5, 2); // Ambil digit ke-6 dan 7 dari nomor

                // Map tahun ke periode
                $periodeMap = [
                    '22' => 1, // Periode ID 1 untuk 2022/2023
                    '23' => 2, // Periode ID 2 untuk 2023/2024
                    '24' => 3, // Periode ID 3 untuk 2024/2025
                    '25' => 4, // Periode ID 4 untuk 2025/2026
                ];

                $periodeId = $periodeMap[$tahun] ?? 4; // Default ke periode terbaru jika tidak match

                $asistenPeriodeData[] = [
                    'id_user' => $person['id'],
                    'id_periode' => $periodeId,
                    'jabatan' => 'Asisten Praktikum',
                    'created_at' => Time::now(),
                    'updated_at' => Time::now(),
                ];
            }
        }

        if (!empty($asistenPeriodeData)) {
            $this->db->table('asisten_periode')->insertBatch($asistenPeriodeData);
        }
    }
}