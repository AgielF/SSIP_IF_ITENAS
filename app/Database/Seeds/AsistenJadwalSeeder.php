<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AsistenJadwalSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_jadwal' => 1,
                'id_user'   => 1, // id asisten
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_jadwal' => 2,
                'id_user'   => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_jadwal' => 3,
                'id_user'   => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Check if asisten_jadwal already exist
        foreach ($data as $asisten) {
            $existing = $this->db->table('asisten_jadwal')->where('id_jadwal', $asisten['id_jadwal'])->where('id_user', $asisten['id_user'])->get()->getRow();
            if (!$existing) {
                $this->db->table('asisten_jadwal')->insert($asisten);
            }
        }
    }
}