<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BeritaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'judul' => 'Workshop Pengembangan Aplikasi Web Modern',
                'konten' => 'Jurusan Informatika akan mengadakan workshop pengembangan aplikasi web modern menggunakan teknologi terbaru. Workshop ini akan diadakan pada tanggal 15 Desember 2024.',
                'kategori' => 'workshop',
                'tanggal' => '2024-12-15',
                'id_user' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'judul' => 'Seminar Nasional Teknologi Informasi 2024',
                'konten' => 'Seminar nasional akan menghadirkan pembicara dari berbagai perusahaan teknologi terkemuka. Acara ini terbuka untuk mahasiswa dan dosen.',
                'kategori' => 'seminar',
                'tanggal' => '2024-11-20',
                'id_user' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'judul' => 'Pengumuman Jadwal Ujian Akhir Semester',
                'konten' => 'Jadwal ujian akhir semester ganjil tahun akademik 2024/2025 telah diumumkan. Mahasiswa diharapkan memeriksa jadwal masing-masing.',
                'kategori' => 'pengumuman',
                'tanggal' => '2024-12-01',
                'id_user' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'judul' => 'Kegiatan Internal: Rapat Koordinasi Dosen',
                'konten' => 'Rapat koordinasi dosen akan diadakan untuk membahas kurikulum dan program kerja semester depan.',
                'kategori' => 'internal',
                'tanggal' => '2024-12-10',
                'id_user' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Check if berita already exist
        foreach ($data as $berita) {
            $existing = $this->db->table('berita')->where('judul', $berita['judul'])->get()->getRow();
            if (!$existing) {
                $this->db->table('berita')->insert($berita);
            }
        }
    }
} 