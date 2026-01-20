<?php

namespace App\Models;

use CodeIgniter\Model;

class EventsModel extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'id_event';
    protected $allowedFields = ['nama_event', 'deskripsi', 'jenis', 'created_by', 'created_at', 'updated_at'];

    // Mengaktifkan timestamps, disesuaikan dengan nama kolom di ERD
    protected $useTimestamps = true;
    protected $createdField  = 'created_at'; // Sesuai ERD
    protected $updatedField  = ''; // Tidak ada updated_at di ERD
}
