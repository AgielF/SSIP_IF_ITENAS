<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PesertaPraktikumSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Removed all praktikan entries since praktikan role was removed
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