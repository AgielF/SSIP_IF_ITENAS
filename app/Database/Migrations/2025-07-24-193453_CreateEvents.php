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
            'created_by'  => ['type' => 'INT', 'unsigned' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_event', true);
        $this->forge->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('events');
    }

    public function down()
    {
        $this->forge->dropTable('events');
    }
}
