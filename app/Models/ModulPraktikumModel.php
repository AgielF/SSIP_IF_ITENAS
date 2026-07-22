<?php

namespace App\Models;

use CodeIgniter\Model;

class ModulPraktikumModel extends Model
{
    protected $table = 'modul_praktikum';
    protected $primaryKey = 'id_modul';
    protected $useTimestamps = true; // [T3.1] CI4 mengelola timestamps otomatis
    protected $allowedFields = ['judul', 'deskripsi', 'file_url', 'id_jadwal'];
} 