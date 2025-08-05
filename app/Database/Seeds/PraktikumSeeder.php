<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PraktikumSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_user' => 2,
                'id_jadwal' => 1,
                'galeri_prak' => null,
                'desc_aturan' => 'Praktikum Algoritma dan Pemrograman - Dilarang menggunakan AI untuk coding',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_user' => 3,
                'id_jadwal' => 2,
                'galeri_prak' => null,
                'desc_aturan' => 'Praktikum Struktur Data - Wajib mengumpulkan laporan dalam format PDF',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_user' => 4,
                'id_jadwal' => 3,
                'galeri_prak' => null,
                'desc_aturan' => 'Praktikum Basis Data - Menggunakan MySQL dan phpMyAdmin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Check if praktikum already exist
        foreach ($data as $praktikum) {
            $existing = $this->db->table('praktikum')->where('id_user', $praktikum['id_user'])->where('id_jadwal', $praktikum['id_jadwal'])->get()->getRow();
            if (!$existing) {
                $this->db->table('praktikum')->insert($praktikum);
            }
        }
    }
} 