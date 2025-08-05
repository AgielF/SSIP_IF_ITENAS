<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RekrutSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_user' => 1,
                'id_jadwal' => 1,
                'deskripsi' => 'Rekrutmen Asisten Praktikum Algoritma dan Pemrograman',
                'status' => 'dibuka',
                'syarat' => 'Minimal IPK 3.5, Lulus mata kuliah Algoritma dan Pemrograman dengan nilai minimal B',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_user' => 1,
                'id_jadwal' => 2,
                'deskripsi' => 'Rekrutmen Asisten Praktikum Struktur Data',
                'status' => 'dibuka',
                'syarat' => 'Minimal IPK 3.3, Lulus mata kuliah Struktur Data dengan nilai minimal B+',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_user' => 1,
                'id_jadwal' => 3,
                'deskripsi' => 'Rekrutmen Asisten Praktikum Basis Data',
                'status' => 'ditutup',
                'syarat' => 'Minimal IPK 3.0, Lulus mata kuliah Basis Data dengan nilai minimal B',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Check if rekrut already exist
        foreach ($data as $rekrut) {
            $existing = $this->db->table('rekrut')->where('id_user', $rekrut['id_user'])->where('id_jadwal', $rekrut['id_jadwal'])->get()->getRow();
            if (!$existing) {
                $this->db->table('rekrut')->insert($rekrut);
            }
        }
    }
} 