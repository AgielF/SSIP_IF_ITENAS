<?php

namespace App\Models;

use CodeIgniter\Model;

class GaleriUmumModel extends Model
{
    protected $table = 'galeri_umum';
    protected $primaryKey = 'id_galeri';
    protected $allowedFields = ['kategori', 'keterangan', 'file_url', 'tanggal_upload', 'id_user'];
} 