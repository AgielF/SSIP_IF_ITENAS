<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EventsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_event' => 'Praktikum Machine Learning',
                'deskripsi'  => 'Praktikum supervised & unsupervised learning algorithms',
                'jenis'      => 'praktikum',
                'created_by'  => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'nama_event' => 'Deep Learning',
                'deskripsi'  => 'Praktikum neural networks dan deep learning architectures',
                'jenis'      => 'praktikum',
                'created_by'  => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'nama_event' => 'Expert Systems',
                'deskripsi'  => 'Praktikum sistem pakar berbasis rule dan inference engine',
                'jenis'      => 'praktikum',
                'created_by'  => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'nama_event' => 'Artificial Intelligence',
                'deskripsi'  => 'Praktikum konsep dasar dan aplikasi artificial intelligence',
                'jenis'      => 'praktikum',
                'created_by'  => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'nama_event' => 'Smart Systems',
                'deskripsi'  => 'Praktikum sistem cerdas untuk IoT dan automation',
                'jenis'      => 'praktikum',
                'created_by'  => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'nama_event' => 'Data Mining',
                'deskripsi'  => 'Praktikum clustering, classification, dan association rules',
                'jenis'      => 'praktikum',
                'created_by'  => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
        ];

        // Check if events already exist
        foreach ($data as $event) {
            $existing = $this->db->table('events')->where('nama_event', $event['nama_event'])->get()->getRow();
            if (!$existing) {
                $this->db->table('events')->insert($event);
            }
        }
    }
}
