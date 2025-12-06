<?php

namespace App\Models;

use CodeIgniter\Model;

class EventsModel extends Model
{
    protected $table            = 'events';
    protected $primaryKey       = 'id_event';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    
    // Kolom yang diizinkan untuk diisi
    protected $allowedFields    = ['nama_event', 'deskripsi', 'jenis'];

    // Mengaktifkan timestamps, disesuaikan dengan nama kolom di ERD
    protected $useTimestamps = true;
    protected $createdField  = 'created_at'; // Sesuai ERD
    protected $updatedField  = ''; // Tidak ada updated_at di ERD
}
