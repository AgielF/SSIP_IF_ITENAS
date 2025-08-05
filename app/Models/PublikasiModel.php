<?php

namespace App\Models;

use CodeIgniter\Model;

class PublikasiModel extends Model
{
    protected $table = 'publikasi';
    protected $primaryKey = 'id_publikasi';
    protected $allowedFields = ['jenis_publikasi', 'link_publikasi', 'kategori', 'tanggal_publikasi', 'id_user', 'created_at', 'updated_at'];
} 