<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateModulPraktikum extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_modul' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'judul' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
            ],
            'file_url' => [
                'type' => 'TEXT',
            ],
            'id_jadwal' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_modul', true);
        $this->forge->addForeignKey('id_jadwal', 'jadwal', 'id_jadwal', 'CASCADE', 'CASCADE');
        $this->forge->createTable('modul_praktikum');
    }

    public function down()
    {
        $this->forge->dropTable('modul_praktikum');
    }
} 