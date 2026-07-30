<?php

namespace App\Models;

use CodeIgniter\Model;

class PesertaPraktikumModel extends Model
{
    protected $table            = 'peserta_praktikum';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    // Kolom yang diizinkan untuk diisi
    protected $allowedFields    = ['id_user', 'id_jadwal', 'status', 'nilai'];

    // Timestamps
    protected $useTimestamps = false; // Asumsikan tidak ada created_at dan updated_at berdasarkan hasil db:table
}
