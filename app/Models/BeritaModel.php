<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table = 'berita';
    protected $primaryKey = 'id_berita';
    protected $allowedFields = ['judul', 'konten', 'kategori', 'tanggal', 'id_user', 'created_at', 'updated_at'];
} 