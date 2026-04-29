<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePeriodeTables extends Migration
{
    public function up()
    {
        // 1. Tabel 'periode'
        $this->forge->addField([
            'id_periode'   => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'nama_periode' => ['type' => 'VARCHAR', 'constraint' => '50'],
            'tahun'        => ['type' => 'YEAR', 'constraint' => 4],
            'status_aktif' => ['type' => 'ENUM', 'constraint' => ['aktif', 'tidak aktif'], 'default' => 'tidak aktif'],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id_periode', true);
        $this->forge->createTable('periode');

        // 2. Tabel Pivot 'asisten_periode'
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'id_user'    => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true],
            'id_periode' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true],
            'jabatan'    => ['type' => 'VARCHAR', 'constraint' => '100', 'default' => 'Asisten Praktikum'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        
        // Relasi Foreign Key
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_periode', 'periode', 'id_periode', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('asisten_periode');
    }

    public function down()
    {
        // Drop tabel anak dulu, baru tabel induk
        $this->forge->dropTable('asisten_periode');
        $this->forge->dropTable('periode');
    }
}