<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProyekRisetTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_proyek' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'judul' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'topik' => [
                'type' => 'ENUM',
                'constraint' => [
                    'machine learning',
                    'data mining',
                    'deep learning',
                    'artificial intelligence',
                    'expert system',
                    'smart system'
                ],
                'null' => true,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
            ],
            'mitra' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'sumber_dana' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'tahun_mulai' => [
                'type' => 'YEAR',
            ],
            'tahun_selesai' => [
                'type' => 'YEAR',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['akan dilaksanakan', 'sedang dilaksanakan', 'selesai'],
                'default' => 'akan dilaksanakan',
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
        $this->forge->addKey('id_proyek', true);
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('proyek_riset');
    }

    public function down()
    {
        $this->forge->dropTable('proyek_riset');
    }
}