<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nomor', 'nama', 'no_telp', 'jurusan', 'role_id', 'created_at', 'updated_at'];

    public function getUserByRole($roleId)
    {
        return $this->select('users.*, roles.role_name')
            ->join('roles', 'roles.id = users.role_id')
            ->findAll();
    }

    public function getAsistenLab () 
    {
        return $this->where('role_id', 2)->findAll();
    }
    
    public function getDosenLab()
    {
        return $this->where('role_id', 4)->findAll();
    }

    public function praktikan(){
        return $this->where('role_id', 3)->findAll();
    }
    
    public function getUsersWithRoles()
    {
        return $this->select('users.*, roles.role_name')
                    ->join('roles', 'roles.id = users.role_id')
                    ->findAll();
    }
}