<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddJudulToPublikasi extends Migration
{
    public function up()
    {
        $this->forge->addColumn('publikasi', [
            'judul' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'jenis_publikasi'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('publikasi', 'judul');
    }
}
