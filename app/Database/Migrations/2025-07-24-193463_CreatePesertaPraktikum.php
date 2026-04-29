<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePesertaPraktikumTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
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
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['terdaftar', 'lulus', 'tidak lulus'],
            ],
            'nilai' => [
                'type' => 'FLOAT',
                'null' => true
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_jadwal', 'jadwal', 'id_jadwal', 'CASCADE', 'CASCADE');
        $this->forge->createTable('peserta_praktikum');
    }

    public function down()
    {
        $this->forge->dropTable('peserta_praktikum');
    }
}