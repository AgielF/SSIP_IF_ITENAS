<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    // Kolom yang diizinkan untuk diisi
    protected $allowedFields    = ['nrp', 'nama', 'no_telp', 'jurusan', 'role_id'];

    // Mengaktifkan timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Method kustom untuk mengambil data user beserta nama rolenya.
     * Ini adalah contoh penggunaan JOIN.
     */
    public function getUsersWithRoles()
    {
        return $this->db->table('users')
            ->join('roles', 'roles.id = users.role_id')
            ->select('users.*, roles.role_name')
            ->get()->getResultArray();
    }
}
