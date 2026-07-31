<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldsToPublikasi extends Migration
{
    public function up()
    {
        $fields = [
            'lokasi_conference' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'publisher_jurnal' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
        ];
        $this->forge->addColumn('publikasi', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('publikasi', 'lokasi_conference');
        $this->forge->dropColumn('publikasi', 'publisher_jurnal');
    }
}
