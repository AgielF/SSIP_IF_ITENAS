<?php

namespace App\Models;

use CodeIgniter\Model;

class RekrutModel extends Model
{
    protected $table = 'rekrut';
    protected $primaryKey = 'id_rekrut';
    protected $allowedFields = ['id_user', 'id_jadwal', 'deskripsi', 'status', 'syarat', 'created_at', 'updated_at'];
} 