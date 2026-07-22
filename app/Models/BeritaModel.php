<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table = 'berita';
    protected $primaryKey = 'id_berita';
    protected $useTimestamps = true; // [T3.1] CI4 mengelola timestamps otomatis
    protected $allowedFields = ['judul', 'konten', 'kategori', 'tanggal', 'id_user'];
} 