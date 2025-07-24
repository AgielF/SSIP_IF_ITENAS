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
                'create_at'  => 1, // id user yang membuat event
            ],
            [
                'nama_event' => 'Seminar AI',
                'deskripsi'  => 'Seminar tentang Artificial Intelligence',
                'jenis'      => 'seminar',
                'create_at'  => 1,
            ],
        ];

        foreach ($data as $event) {
            $this->db->table('events')->insert($event);
        }
    }
}