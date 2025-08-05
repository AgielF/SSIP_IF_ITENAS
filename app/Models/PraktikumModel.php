<?php

namespace App\Models;

use CodeIgniter\Model;

class PraktikumModel extends Model
{
    protected $table = 'praktikum';
    protected $primaryKey = 'id_prak';
    protected $allowedFields = ['id_user', 'id_jadwal', 'galeri_prak', 'desc_aturan', 'created_at', 'updated_at'];
} 