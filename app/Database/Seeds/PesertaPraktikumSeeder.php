<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PesertaPraktikumSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_user' => 5,
                'id_jadwal' => 1,
                'status' => 'terdaftar',
                'nilai' => null,
            ],
            [
                'id_user' => 6,
                'id_jadwal' => 1,
                'status' => 'lulus',
                'nilai' => 85.5,
            ],
            [
                'id_user' => 7,
                'id_jadwal' => 1,
                'status' => 'tidak lulus',
                'nilai' => 45.0,
            ],
            [
                'id_user' => 8,
                'id_jadwal' => 2,
                'status' => 'terdaftar',
                'nilai' => null,
            ],
            [
                'id_user' => 9,
                'id_jadwal' => 2,
                'status' => 'lulus',
                'nilai' => 92.0,
            ],
            [
                'id_user' => 10,
                'id_jadwal' => 3,
                'status' => 'terdaftar',
                'nilai' => null,
            ],
        ];

        // Check if peserta_praktikum already exist
        foreach ($data as $peserta) {
            $existing = $this->db->table('peserta_praktikum')->where('id_user', $peserta['id_user'])->where('id_jadwal', $peserta['id_jadwal'])->get()->getRow();
            if (!$existing) {
                $this->db->table('peserta_praktikum')->insert($peserta);
            }
        }
    }
} 