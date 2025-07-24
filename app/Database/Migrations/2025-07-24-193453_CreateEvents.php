<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEvents extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_event'   => ['type' => 'INT', 'auto_increment' => true, 'unsigned' => true],
            'nama_event' => ['type' => 'VARCHAR', 'constraint' => 50],
            'deskripsi'  => ['type' => 'TEXT'],
            'jenis'      => ['type' => 'ENUM', 'constraint' => ['praktikum', 'seminar', 'lomba', 'rapat']],
            'create_at'  => ['type' => 'INT', 'unsigned' => true],
        ]);
        $this->forge->addKey('id_event', true);
        $this->forge->addForeignKey('create_at', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('events');
    }

    public function down()
    {
        $this->forge->dropTable('events');
    }
}
