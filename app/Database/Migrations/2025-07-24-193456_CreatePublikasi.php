<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePublikasiTable extends Migration
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
            'judul' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'link_publikasi' => [
                'type' => 'TEXT',
            ],
            'kategori' => [
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
            'tanggal_publikasi' => [
                'type' => 'DATE',
            ],
            'penulis_pendamping' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'volume' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'nomor' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'tahun' => [
                'type' => 'YEAR',
                'null' => true,
            ],
            'link_doi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'link_gdrive' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'conference' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
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