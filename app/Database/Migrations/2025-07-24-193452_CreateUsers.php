<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
{
    public function up()
    {
         $this->forge->addField([
            'id'        => ['type' => 'INT', 'auto_increment' => true, 'unsigned' => true],
            'nrp'       => ['type' => 'VARCHAR', 'constraint' => 9, 'unique' => true],
            'nama'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'no_telp'   => ['type' => 'VARCHAR', 'constraint' => 15],
            'jurusan'   => ['type' => 'VARCHAR', 'constraint' => 100],
            'role_id'   => ['type' => 'INT', 'unsigned' => true],
            'created_at'=> ['type' => 'DATETIME', 'null' => true],
            'updated_at'=> ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('role_id', 'roles', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
