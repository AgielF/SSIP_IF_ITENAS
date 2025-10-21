<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GaleriUmumSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kategori' => 'foto',
                'keterangan' => 'Foto kegiatan praktikum di laboratorium komputer',
                'file_url' => '/uploads/galeri/praktikum_lab.jpg',
                'tanggal_upload' => '2024-12-01',
                'id_user' => 1,
            ],
            [
                'kategori' => 'video',
                'keterangan' => 'Video dokumentasi seminar teknologi informasi',
                'file_url' => '/uploads/galeri/seminar_tech.mp4',
                'tanggal_upload' => '2024-11-20',
                'id_user' => 1,
            ],
            [
                'kategori' => 'foto',
                'keterangan' => 'Foto kegiatan workshop coding',
                'file_url' => '/uploads/galeri/workshop_coding.jpg',
                'tanggal_upload' => '2024-12-05',
                'id_user' => 2,
            ],
            [
                'kategori' => 'foto',
                'keterangan' => 'Foto kegiatan lomba programming',
                'file_url' => '/uploads/galeri/lomba_programming.jpg',
                'tanggal_upload' => '2024-11-15',
                'id_user' => 4,
            ],
        ];

        // Check if galeri_umum already exist
        foreach ($data as $galeri) {
            $existing = $this->db->table('galeri_umum')->where('file_url', $galeri['file_url'])->get()->getRow();
            if (!$existing) {
                $this->db->table('galeri_umum')->insert($galeri);
            }
        }
    }
} 