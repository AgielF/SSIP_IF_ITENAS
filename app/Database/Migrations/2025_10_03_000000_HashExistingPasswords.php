<?php 
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HashExistingPasswords extends Migration
{
    public function up()
    {
        // Selalu hash ulang semua password saat migration dijalankan
        // Ini memastikan password selalu dalam kondisi ter-hash
        $users = $this->db->table('users')->get()->getResultArray();

        foreach ($users as $user) {
            // Selalu hash ulang, terlepas dari status sebelumnya
            // Ini lebih aman karena memastikan semua password ter-hash
            $hashed = password_hash($user['password'], PASSWORD_DEFAULT);
            $this->db->table('users')
                     ->where('id', $user['id'])
                     ->update(['password' => $hashed]);
        }
    }

    public function down()
    {
        // Gabisa di un hash
    }
}