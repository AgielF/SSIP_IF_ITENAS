<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EventsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_event' => 'Machine Learning Research',
                'deskripsi'  => 'Penelitian dan pengembangan algoritma machine learning',
                'jenis'      => 'penelitian',
                'created_by'  => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'nama_event' => 'Data Mining Workshop',
                'deskripsi'  => 'Workshop praktis data mining dan pattern recognition',
                'jenis'      => 'workshop',
                'created_by'  => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'nama_event' => 'Deep Learning Seminar',
                'deskripsi'  => 'Seminar tentang deep learning untuk NLP dan computer vision',
                'jenis'      => 'seminar',
                'created_by'  => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'nama_event' => 'Artificial Intelligence Conference',
                'deskripsi'  => 'Konferensi nasional artificial intelligence dan aplikasi nya',
                'jenis'      => 'konferensi',
                'created_by'  => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'nama_event' => 'Expert Systems Development',
                'deskripsi'  => 'Pengembangan sistem pakar berbasis rule dan inference engine',
                'jenis'      => 'penelitian',
                'created_by'  => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'nama_event' => 'Smart Systems Innovation',
                'deskripsi'  => 'Inovasi sistem cerdas untuk predictive dan recommendation systems',
                'jenis'      => 'penelitian',
                'created_by'  => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'nama_event' => 'Praktikum Machine Learning',
                'deskripsi'  => 'Praktikum supervised & unsupervised learning',
                'jenis'      => 'praktikum',
                'created_by'  => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'nama_event' => 'Praktikum Data Mining',
                'deskripsi'  => 'Praktikum clustering, classification, dan association',
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
