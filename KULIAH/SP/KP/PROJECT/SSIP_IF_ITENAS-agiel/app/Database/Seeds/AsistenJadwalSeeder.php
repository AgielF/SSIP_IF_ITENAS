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
            ],
            [
                'id_jadwal' => 2,
                'id_user'   => 1,
            ],
        ];

        foreach ($data as $asisten) {
            $this->db->table('asisten_jadwal')->insert($asisten);
        }
    }
}