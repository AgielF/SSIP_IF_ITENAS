<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJadwalTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jadwal' => [
                'type' => 'INT',
                'auto_increment' => true,
                'unsigned' => true
            ],
            'id_event' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'tanggal' => [
                'type' => 'DATE'
            ],
            'waktu_mulai' => [
                'type' => 'TIME'
            ],
            'waktu_selesai' => [
                'type' => 'TIME'
            ],
            'id_ruangan' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'null' => true
            ],
            'kelas' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true
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
        $this->forge->addKey('id_jadwal', true);
        $this->forge->addForeignKey('id_event', 'events', 'id_event', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_ruangan', 'ruangan', 'id_ruangan', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('jadwal');
    }

    public function down()
    {
        $this->forge->dropTable('jadwal');
    }
}