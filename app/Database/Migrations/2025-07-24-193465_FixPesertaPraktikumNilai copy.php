<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixPesertaPraktikumNilai extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('peserta_praktikum', [
            'nilai' => [
                'type' => 'FLOAT',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('peserta_praktikum', [
            'nilai' => [
                'type' => 'FLOAT',
                'null' => false,
            ],
        ]);
    }
} 