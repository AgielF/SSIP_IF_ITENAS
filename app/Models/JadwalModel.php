<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalModel extends Model
{
    protected $table = 'jadwal';
    protected $primaryKey = 'id_jadwal';
    protected $allowedFields = ['id_event', 'tanggal', 'waktu_mulai', 'waktu_selesai', 'ruangan', 'created_at', 'updated_at'];
}
