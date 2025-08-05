<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGaleriUmum extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_galeri' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'kategori' => [
                'type' => 'ENUM',
                'constraint' => ['foto', 'video'],
            ],
            'keterangan' => [
                'type' => 'TEXT',
            ],
            'file_url' => [
                'type' => 'TEXT',
            ],
            'tanggal_upload' => [
                'type' => 'DATE',
            ],
            'id_user' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
        ]);
        $this->forge->addKey('id_galeri', true);
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('galeri_umum');
    }

    public function down()
    {
        $this->forge->dropTable('galeri_umum');
    }
} 