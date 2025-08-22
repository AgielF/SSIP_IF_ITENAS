<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldsToPublikasi extends Migration
{
    public function up()
    {
        // Add new fields to publikasi table
        $fields = [
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
        ];
        
        $this->forge->addColumn('publikasi', $fields);
    }

    public function down()
    {
        // Drop the added columns
        $this->forge->dropColumn('publikasi', [
            'penulis_pendamping',
            'volume',
            'nomor',
            'tahun',
            'link_doi',
            'link_gdrive',
            'conference',
            'deskripsi'
        ]);
    }
}