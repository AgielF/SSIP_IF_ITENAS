<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ModulPraktikumSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'judul' => 'Modul Praktikum Algoritma dan Pemrograman',
                'deskripsi' => 'Modul praktikum untuk mata kuliah Algoritma dan Pemrograman semester 1',
                'file_url' => '/uploads/modul/modul_algoritma.pdf',
                'id_jadwal' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'judul' => 'Modul Praktikum Struktur Data',
                'deskripsi' => 'Modul praktikum untuk mata kuliah Struktur Data semester 2',
                'file_url' => '/uploads/modul/modul_struktur_data.pdf',
                'id_jadwal' => 2,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'judul' => 'Modul Praktikum Basis Data',
                'deskripsi' => 'Modul praktikum untuk mata kuliah Basis Data semester 3',
                'file_url' => '/uploads/modul/modul_basis_data.pdf',
                'id_jadwal' => 3,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'judul' => 'Modul Praktikum Pemrograman Web',
                'deskripsi' => 'Modul praktikum untuk mata kuliah Pemrograman Web semester 4',
                'file_url' => '/uploads/modul/modul_web.pdf',
                'id_jadwal' => 4,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Check if modul_praktikum already exist
        foreach ($data as $modul) {
            $existing = $this->db->table('modul_praktikum')->where('judul', $modul['judul'])->get()->getRow();
            if (!$existing) {
                $this->db->table('modul_praktikum')->insert($modul);
            }
        }
    }
} 