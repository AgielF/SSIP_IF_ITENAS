<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRekrutTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_rekrut' => [
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
            'deskripsi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['dibuka', 'ditutup'],
            ],
            'syarat' => [
                'type' => 'TEXT',
            ],
            'link_gform' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
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
        $this->forge->addKey('id_rekrut', true);
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_jadwal', 'jadwal', 'id_jadwal', 'CASCADE', 'CASCADE');
        $this->forge->createTable('rekrut');
    }

    public function down()
    {
        $this->forge->dropTable('rekrut');
    }
}