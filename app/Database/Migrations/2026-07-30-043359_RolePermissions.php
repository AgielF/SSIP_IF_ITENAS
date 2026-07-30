<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RolePermissions extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'role_id'     => ['type' => 'INT', 'constraint' => 11],
            'menu_key'    => ['type' => 'VARCHAR', 'constraint' => 100],
        ]);
        $this->forge->addKey('id', true);
        // unique key to prevent duplicate permission
        $this->forge->addUniqueKey(['role_id', 'menu_key']);
        $this->forge->createTable('role_permissions');
        
        // Insert initial seed data based on current access
        $db = \Config\Database::connect();
        $builder = $db->table('role_permissions');
        
        $seedData = [
            // Asisten (Role 2) default permissions
            ['role_id' => 2, 'menu_key' => 'jadwal_saya'],
            ['role_id' => 2, 'menu_key' => 'jadwal_admin'],
            ['role_id' => 2, 'menu_key' => 'sertifikat_klaim'],
            
            // Dosen (Role 3) default permissions
            ['role_id' => 3, 'menu_key' => 'project_lab_admin'],
            ['role_id' => 3, 'menu_key' => 'penelitian_proyek_admin'],
            ['role_id' => 3, 'menu_key' => 'publikasi_ilmiah_admin']
        ];
        
        $builder->insertBatch($seedData);
    }

    public function down()
    {
        $this->forge->dropTable('role_permissions');
    }
}
