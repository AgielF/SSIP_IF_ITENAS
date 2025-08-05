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
                'deskripsi' => 'Penelitian untuk mengembangkan sistem informasi akademik yang terintegrasi untuk perguruan tinggi',
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
                'deskripsi' => 'Penelitian menggunakan algoritma machine learning untuk memprediksi kelulusan mahasiswa berdasarkan data akademik',
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
                'deskripsi' => 'Penelitian pengembangan aplikasi mobile untuk monitoring kesehatan pasien secara real-time',
                'mitra' => 'Rumah Sakit Umum Daerah',
                'sumber_dana' => 'DIKTI',
                'tahun_mulai' => 2024,
                'tahun_selesai' => 2027,
                'id_user' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Check if proyek_riset already exist
        foreach ($data as $proyek) {
            $existing = $this->db->table('proyek_riset')->where('judul', $proyek['judul'])->get()->getRow();
            if (!$existing) {
                $this->db->table('proyek_riset')->insert($proyek);
            }
        }
    }
} 