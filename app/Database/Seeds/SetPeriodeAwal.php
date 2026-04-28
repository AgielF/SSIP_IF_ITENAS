<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SetPeriodeAwal extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // Buat periode default
        $db->table('periode')->insert([
            'nama_periode' => 'Genap 2025/2026',
            'tahun'        => '2026',
            'status_aktif' => 'aktif',
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ]);
        $idPeriode = $db->insertID();

        // Ambil semua asisten (role_id = 2)
        $asisten = $db->table('users')->where('role_id', 2)->get()->getResultArray();

        // Masukkan ke tabel pivot
        $dataPivot = [];
        foreach ($asisten as $a) {
            $dataPivot[] = [
                'id_user'    => $a['id'],
                'id_periode' => $idPeriode,
                'jabatan'    => 'Asisten Praktikum',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }
        if (!empty($dataPivot)) {
            $db->table('asisten_periode')->insertBatch($dataPivot);
        }
    }
}