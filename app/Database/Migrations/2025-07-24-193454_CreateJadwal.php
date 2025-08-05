<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJadwal extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jadwal'     => ['type' => 'INT', 'auto_increment' => true, 'unsigned' => true],
            'id_event'      => ['type' => 'INT', 'unsigned' => true],
            'tanggal'       => ['type' => 'DATE'],
            'waktu_mulai'   => ['type' => 'TIME'],
            'waktu_selesai' => ['type' => 'TIME'],
            'ruangan'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_jadwal', true);
        $this->forge->addForeignKey('id_event', 'events', 'id_event', 'CASCADE', 'CASCADE');
        $this->forge->createTable('jadwal');
    }

    public function down()
    {
        $this->forge->dropTable('jadwal');
    }
}
