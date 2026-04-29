<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePraktikumTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_prak' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'id_jadwal' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'galeri_prak' => [
                'type' => 'BLOB',
                'null' => true,
            ],
            'desc_aturan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_prak', true);
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_jadwal', 'jadwal', 'id_jadwal', 'CASCADE', 'CASCADE');
        $this->forge->createTable('praktikum');
    }

    public function down()
    {
        $this->forge->dropTable('praktikum');
    }
}