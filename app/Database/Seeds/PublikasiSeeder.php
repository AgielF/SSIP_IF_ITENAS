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
        'topik' => 'machine learning',
        'link_publikasi' => 'https://doi.org/10.1000/example1',
        'kategori' => 'Jurnal Nasional',
        'tanggal_publikasi' => '2024-01-15',
        'id_user' => 1,
        'penulis_pendamping' => 'Dr. Budi Santoso, M.Kom',
        'volume' => '15',
        'nomor' => '3',
        'conference' => null,
        'tahun' => '2024',
        'link_doi' => 'https://doi.org/10.1000/example1',
        'link_gdrive' => 'https://drive.google.com/file/example1',
        'deskripsi' => 'Penelitian ini membahas penerapan teknologi informasi...',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ],
    [
        'jenis_publikasi' => 'prosiding',
        'topik' => 'deep learning',
        'link_publikasi' => 'https://ieeexplore.ieee.org/example2',
        'kategori' => 'Konferensi Internasional',
        'tanggal_publikasi' => '2024-03-20',
        'id_user' => 2,
        'penulis_pendamping' => 'Dr. Siti Nurhaliza, S.T., M.T.',
        'volume' => null,
        'nomor' => null,
        'conference' => 'ICCSAT 2024',
        'tahun' => '2024',
        'link_doi' => 'https://doi.org/10.1109/ICCSAT2024.123456',
        'link_gdrive' => 'https://drive.google.com/file/example2',
        'deskripsi' => 'Makalah ini mempresentasikan hasil penelitian...',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ],
    [
        'jenis_publikasi' => 'paten',
        'topik' => 'smart system',
        'link_publikasi' => 'https://patents.google.com/example3',
        'kategori' => 'Paten Sederhana',
        'tanggal_publikasi' => '2024-06-10',
        'id_user' => 3,
        'penulis_pendamping' => 'Prof. Ahmad Rizki, Ph.D.',
        'volume' => null,
        'nomor' => null,
        'conference' => null,
        'tahun' => '2024',
        'link_doi' => 'https://doi.org/10.1000/paten123',
        'link_gdrive' => 'https://drive.google.com/file/example3',
        'deskripsi' => 'Paten ini menjelaskan sistem inovatif...',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
    ],
];


        // optional: biar clean
        $this->db->table('publikasi')->truncate();
        $this->db->table('publikasi')->insertBatch($data);
    }
}
