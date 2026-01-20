<?php

namespace App\Models;

use CodeIgniter\Model;

class AsistenModel extends Model
{
    protected $table = 'asisten_jadwal';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_jadwal', 'id_user', 'created_at', 'updated_at'];
}
