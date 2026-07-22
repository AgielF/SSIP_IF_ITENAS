<?php

namespace App\Models;

use CodeIgniter\Model;

class PraktikumModel extends Model
{
    protected $table = 'praktikum';
    protected $primaryKey = 'id_prak';
    protected $useTimestamps = true; // [T3.1] CI4 mengelola timestamps otomatis
    protected $allowedFields = ['id_user', 'id_jadwal', 'galeri_prak', 'desc_aturan'];
} 