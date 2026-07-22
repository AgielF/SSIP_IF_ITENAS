<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSertifikatFeature extends Migration
{
    public function up()
    {
        // =========================================================
        // 1. Tambah kolom 'status_tugas' pada tabel 'asisten_periode'
        // =========================================================
        $fields = [
            'status_tugas' => [
                'type'       => 'ENUM',
                'constraint' => ['belum selesai', 'selesai'],
                'default'    => 'belum selesai',
                'after'      => 'jabatan',
            ],
        ];
        $this->forge->addColumn('asisten_periode', $fields);

        // =========================================================
        // 2. Buat tabel baru 'config_sertifikat'
        // =========================================================
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'template_gambar' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'comment'    => 'Path relatif file background sertifikat (JPG/PNG)',
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'deskripsi_template' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'nama_kepala_lab' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'ttd_kepala_lab' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'comment'    => 'Path relatif file PNG tanda tangan Kepala Lab',
            ],
            'nama_ketua_prodi' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'ttd_ketua_prodi' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'comment'    => 'Path relatif file PNG tanda tangan Ketua Prodi',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('config_sertifikat');
    }

    public function down()
    {
        // Hapus kolom yang ditambahkan ke asisten_periode
        $this->forge->dropColumn('asisten_periode', 'status_tugas');

        // Hapus tabel config_sertifikat
        $this->forge->dropTable('config_sertifikat', true);
    }
}
