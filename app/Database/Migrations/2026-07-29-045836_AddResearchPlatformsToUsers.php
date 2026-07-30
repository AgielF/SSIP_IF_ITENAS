<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddResearchPlatformsToUsers extends Migration
{
    public function up()
    {
        $fields = [
            'google_scholar' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'sinta' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'orcid' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'scopus' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
        ];
        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'google_scholar');
        $this->forge->dropColumn('users', 'sinta');
        $this->forge->dropColumn('users', 'orcid');
        $this->forge->dropColumn('users', 'scopus');
    }
}
