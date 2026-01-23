<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class ProjectLabSeeder extends Seeder
{
    public function run()
    {
        // 1. Insert Data Project Lab
        $projects = [
            [
                'judul'           => 'Sistem Deteksi Hama Tanaman dengan CNN',
                'deskripsi'       => 'Mengembangkan aplikasi mobile berbasis AI untuk mendeteksi jenis hama pada tanaman padi menggunakan metode Convolutional Neural Network.',
                'topik'           => 'deep learning',
                'status'          => 'sedang dilaksanakan',
                'teknologi'       => 'Python, TensorFlow, Flutter',
                'link_repository' => 'https://github.com/lab-ti/deteksi-hama',
                'link_deploy'     => null,
                'tanggal_mulai'   => '2023-10-01',
                'tanggal_selesai' => null,
                'created_by'      => 1, // Asumsi ID User Admin/Dosen
                'created_at'      => Time::now(),
                'updated_at'      => Time::now(),
            ],
            [
                'judul'           => 'Smart Dashboard Monitoring Server Lab',
                'deskripsi'       => 'Dashboard real-time untuk memantau suhu dan load server laboratorium menggunakan ESP32.',
                'topik'           => 'smart system',
                'status'          => 'selesai',
                'teknologi'       => 'Laravel, VueJS, MQTT, C++',
                'link_repository' => 'https://github.com/lab-ti/smart-server',
                'link_deploy'     => 'https://dashboard.lab-ti.ac.id',
                'tanggal_mulai'   => '2023-01-15',
                'tanggal_selesai' => '2023-06-20',
                'created_by'      => 1,
                'created_at'      => Time::now(),
                'updated_at'      => Time::now(),
            ]
        ];

        // Insert Batch ke tabel project_lab
        $this->db->table('project_lab')->insertBatch($projects);

        // Ambil ID project yang baru saja diinsert (untuk relasi pivot)
        // Cara manual (asumsi auto increment mereset atau urut)
        // Project 1 ID = 1, Project 2 ID = 2.
        
        // 2. Insert Data Anggota (Pivot Table)
        $members = [
            // Anggota untuk Project 1 (Deteksi Hama)
            [
                'id_project'   => 1,
                'id_user'      => 2, // Mahasiswa A
                'role_project' => 'AI Engineer',
                'joined_at'    => Time::now(),
            ],
            [
                'id_project'   => 1,
                'id_user'      => 3, // Mahasiswa B
                'role_project' => 'Mobile Developer',
                'joined_at'    => Time::now(),
            ],
            
            // Anggota untuk Project 2 (Smart Dashboard)
            [
                'id_project'   => 2,
                'id_user'      => 2, // Mahasiswa A (Ikut 2 project)
                'role_project' => 'Fullstack Dev',
                'joined_at'    => '2023-01-20 08:00:00',
            ],
        ];

        $this->db->table('project_lab_members')->insertBatch($members);
    }
}