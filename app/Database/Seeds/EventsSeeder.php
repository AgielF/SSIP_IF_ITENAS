<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EventsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_event' => 'Praktikum Basis Data',
                'deskripsi'  => 'Praktikum untuk mahasiswa semester 4',
                'jenis'      => 'praktikum',
                'created_by'  => 1, // id user yang membuat event
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'nama_event' => 'Seminar AI',
                'deskripsi'  => 'Seminar tentang Artificial Intelligence',
                'jenis'      => 'seminar',
                'created_by'  => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'nama_event' => 'Lomba Programming',
                'deskripsi'  => 'Lomba programming tingkat fakultas',
                'jenis'      => 'lomba',
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