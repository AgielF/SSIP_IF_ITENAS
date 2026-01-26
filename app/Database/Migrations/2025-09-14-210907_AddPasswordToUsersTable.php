<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPasswordToUsersTable extends Migration
{
    public function up()
    {
        $result = $this->db->query("SHOW COLUMNS FROM users LIKE 'password'")->getRow();
        if (!$result) {
            $this->forge->addColumn('users', [
                'password' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ],
            ]);
        }
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'password');
    }
}
