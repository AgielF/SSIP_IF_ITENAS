<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePublikasi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_publikasi' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'jenis_publikasi' => [
                'type' => 'ENUM',
                'constraint' => ['jurnal', 'prosiding', 'paten'],
            ],
            'link_publikasi' => [
                'type' => 'TEXT',
            ],
            'kategori' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'tanggal_publikasi' => [
                'type' => 'DATE',
            ],
            'id_user' => [
                'type' => 'INT',
                'unsigned' => true,
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
        $this->forge->addKey('id_publikasi', true);
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('publikasi');
    }

    public function down()
    {
        $this->forge->dropTable('publikasi');
    }
} 