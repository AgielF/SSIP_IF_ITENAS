<?php

namespace App\Models;

use CodeIgniter\Model;

class ProyekRisetModel extends Model
{
    protected $table = 'proyek_riset';
    protected $primaryKey = 'id_proyek';
    protected $allowedFields = ['judul', 'deskripsi', 'mitra', 'sumber_dana', 'tahun_mulai', 'tahun_selesai', 'id_user', 'created_at', 'updated_at'];
} 