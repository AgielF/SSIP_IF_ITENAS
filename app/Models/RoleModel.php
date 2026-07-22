<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table = 'roles';
    protected $useTimestamps = false; // Tabel ini tidak menggunakan created_at/updated_at standar
    protected $primaryKey = 'id';
    protected $allowedFields = ['role_name'];
}
