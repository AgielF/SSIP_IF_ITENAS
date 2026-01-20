<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
class ProyekRisetSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'judul' => 'Pengembangan Sistem Informasi Akademik Berbasis Web',
                'topik' => 'smart system',
                'status' => 'sedang dilaksanakan',
                'deskripsi' => 'Penelitian untuk mengembangkan sistem informasi akademik...',
                'mitra' => 'Universitas Indonesia',
                'sumber_dana' => 'DIKTI',
                'tahun_mulai' => 2024,
                'tahun_selesai' => 2026,
                'id_user' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'judul' => 'Implementasi Machine Learning untuk Prediksi Kelulusan Mahasiswa',
                'topik' => 'machine learning',
                'status' => 'akan dilaksanakan',
                'deskripsi' => 'Penelitian menggunakan algoritma machine learning...',
                'mitra' => 'Institut Teknologi Bandung',
                'sumber_dana' => 'LPDP',
                'tahun_mulai' => 2023,
                'tahun_selesai' => 2025,
                'id_user' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'judul' => 'Pengembangan Aplikasi Mobile untuk Monitoring Kesehatan',
                'topik' => 'expert system',
                'status' => 'sedang dilaksanakan',
                'deskripsi' => 'Penelitian pengembangan aplikasi mobile...',
                'mitra' => 'Rumah Sakit Umum Daerah',
                'sumber_dana' => 'DIKTI',
                'tahun_mulai' => 2024,
                'tahun_selesai' => 2027,
                'id_user' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // clean seed
        $this->db->table('proyek_riset')->truncate();
        $this->db->table('proyek_riset')->insertBatch($data);
    }
}
