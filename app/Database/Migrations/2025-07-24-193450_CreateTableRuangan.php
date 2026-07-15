<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableRuangan extends Migration 
{
    public function up()
    {
        $this->forge->addField([
            'id_ruangan' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'nama_ruangan' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'kapasitas' => [
                'type' => 'INT',
                'constraint' => 11
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
        ]);
        $this->forge->addKey('id_ruangan', true);
        $this->forge->createTable('ruangan');
    }

    public function down()
    {
        $this->forge->dropTable('ruangan');
    }
}