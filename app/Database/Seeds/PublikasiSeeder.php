<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PublikasiSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'jenis_publikasi' => 'jurnal',
                'link_publikasi' => 'https://doi.org/10.1000/example1',
                'kategori' => 'Jurnal Nasional',
                'tanggal_publikasi' => '2024-01-15',
                'id_user' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'jenis_publikasi' => 'prosiding',
                'link_publikasi' => 'https://ieeexplore.ieee.org/example2',
                'kategori' => 'Konferensi Internasional',
                'tanggal_publikasi' => '2024-03-20',
                'id_user' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'jenis_publikasi' => 'paten',
                'link_publikasi' => 'https://patents.google.com/example3',
                'kategori' => 'Paten Sederhana',
                'tanggal_publikasi' => '2024-06-10',
                'id_user' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Check if publikasi already exist
        foreach ($data as $publikasi) {
            $existing = $this->db->table('publikasi')->where('link_publikasi', $publikasi['link_publikasi'])->get()->getRow();
            if (!$existing) {
                $this->db->table('publikasi')->insert($publikasi);
            }
        }
    }
} 