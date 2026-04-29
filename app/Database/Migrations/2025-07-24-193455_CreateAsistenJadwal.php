<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAsistenJadwalTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
                'unsigned' => true
            ],
            'id_jadwal' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'id_user' => [
                'type' => 'INT',
                'unsigned' => true
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
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_jadwal', 'jadwal', 'id_jadwal', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('asisten_jadwal');
    }

    public function down()
    {
        $this->forge->dropTable('asisten_jadwal');
    }
}