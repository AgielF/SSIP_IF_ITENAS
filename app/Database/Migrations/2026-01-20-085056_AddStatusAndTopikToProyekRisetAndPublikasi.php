<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusAndTopikToProyekRisetAndPublikasi extends Migration
{
    public function up()
    {
        // ===== proyek_riset =====
        $this->forge->addColumn('proyek_riset', [
            'topik' => [
                'type' => "ENUM(
                    'machine learning',
                    'data mining',
                    'deep learning',
                    'artificial intelligence',
                    'expert system',
                    'smart system'
                )",
                'null' => true,
                'after' => 'judul',
            ],
            'status' => [
                'type' => "ENUM(
                    'akan dilaksanakan',
                    'sedang dilaksanakan',
                    'selesai'
                )",
                'default' => 'akan dilaksanakan',
                'after' => 'tahun_selesai',
            ],
        ]);

        // ===== publikasi =====
        $this->forge->addColumn('publikasi', [
            'topik' => [
                'type' => "ENUM(
                    'machine learning',
                    'data mining',
                    'deep learning',
                    'artificial intelligence',
                    'expert system',
                    'smart system'
                )",
                'null' => true,
                'after' => 'kategori',
            ],
        ]);
    }

    public function down()
    {
        // rollback aman: hapus field
        $this->forge->dropColumn('proyek_riset', ['topik', 'status']);
        $this->forge->dropColumn('publikasi', 'topik');
    }
}
