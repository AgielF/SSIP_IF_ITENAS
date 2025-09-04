<?php

namespace App\Models;

use CodeIgniter\Model;

class PesertaPraktikumModel extends Model
{
    protected $table = 'peserta_praktikum';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_user', 'id_jadwal', 'status', 'nilai'];
} 
