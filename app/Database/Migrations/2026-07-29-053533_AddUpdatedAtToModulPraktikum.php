<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUpdatedAtToModulPraktikum extends Migration
{
    public function up()
    {
        $this->forge->addColumn('modul_praktikum', [
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('modul_praktikum', 'updated_at');
    }
}
