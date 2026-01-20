<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKelasToJadwal extends Migration
{
    public function up()
    {
        $this->forge->addColumn('jadwal', [
            'kelas' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
                'after' => 'ruangan'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('jadwal', 'kelas');
    }
}
