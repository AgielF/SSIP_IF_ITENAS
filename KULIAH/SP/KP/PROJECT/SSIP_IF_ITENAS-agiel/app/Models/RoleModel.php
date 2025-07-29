<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table            = 'roles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    
    // Kolom yang diizinkan untuk diisi (mass assignment)
    protected $allowedFields    = ['role_name'];

    // Timestamps
    // Tidak ada kolom created_at/updated_at di tabel ini
    protected $useTimestamps = false;
}
