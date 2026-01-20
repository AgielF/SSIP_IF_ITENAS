<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AsistenJadwalSeeder extends Seeder
{
    public function run()
    {
        // Get all jadwal IDs
        $jadwalIds = $this->db->table('jadwal')->select('id_jadwal')->get()->getResultArray();
        $jadwalIds = array_column($jadwalIds, 'id_jadwal');

        // Get assistant user IDs (role_id = 2)
        $assistantIds = $this->db->table('users')
            ->select('id')
            ->where('role_id', 2)
            ->get()->getResultArray();
        $assistantIds = array_column($assistantIds, 'id');

        if (empty($jadwalIds) || empty($assistantIds)) {
            echo "No jadwal or assistants found. Skipping assignment creation.\n";
            return;
        }

        // Create sample assignments
        $assignments = [];

        // Assign assistants to first few jadwals
        foreach ($jadwalIds as $index => $jadwalId) {
            if ($index >= count($assistantIds)) break;

            $assignments[] = [
                'id_jadwal' => $jadwalId,
                'id_user' => $assistantIds[$index],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
        }

        // Insert assignments if they don't exist
        foreach ($assignments as $assignment) {
            $exists = $this->db->table('asisten_jadwal')
                ->where('id_jadwal', $assignment['id_jadwal'])
                ->where('id_user', $assignment['id_user'])
                ->get()->getRow();

            if (!$exists) {
                $this->db->table('asisten_jadwal')->insert($assignment);
                echo "Assigned assistant {$assignment['id_user']} to jadwal {$assignment['id_jadwal']}\n";
            }
        }
    }
}