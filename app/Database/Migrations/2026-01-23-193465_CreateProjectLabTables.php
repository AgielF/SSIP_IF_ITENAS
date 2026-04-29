<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProjectLabTables extends Migration
{
    public function up()
    {
        // ==========================================
        // Tabel 1: project_lab
        // ==========================================
        $this->forge->addField([
            'id_project' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'deskripsi' => [
                'type' => 'TEXT',
            ],
            'topik' => [
                'type'       => 'ENUM',
                'constraint' => [
                    'machine learning', 'data mining', 'deep learning', 
                    'artificial intelligence', 'expert system', 'smart system'
                ],
                'null'       => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['akan dilaksanakan', 'sedang dilaksanakan', 'selesai'],
                'default'    => 'akan dilaksanakan',
            ],
            'teknologi' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'comment'    => 'Contoh: Python, TensorFlow, IoT',
            ],
            'link_repository' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'link_deploy' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'tanggal_mulai' => [
                'type' => 'DATE',
            ],
            'tanggal_selesai' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true, // Sesuaikan dengan id di tabel users
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

        $this->forge->addKey('id_project', true);
        // Menambahkan Foreign Key ke tabel users
        // Pastikan tabel 'users' sudah ada sebelumnya
        $this->forge->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('project_lab');

        // ==========================================
        // Tabel 2: project_lab_members (Pivot)
        // ==========================================
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_project' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'role_project' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'default'    => 'member',
                'comment'    => 'Role spesifik di project: Frontend, Backend, dll',
            ],
            'joined_at' => [
                'type'    => 'DATETIME',
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addKey('id', true);
        
        // Foreign Keys untuk tabel pivot
        $this->forge->addForeignKey('id_project', 'project_lab', 'id_project', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('project_lab_members');
    }

    public function down()
    {
        // Hapus tabel pivot dulu karena dia punya FK ke tabel utama
        $this->forge->dropTable('project_lab_members');
        $this->forge->dropTable('project_lab');
    }
}