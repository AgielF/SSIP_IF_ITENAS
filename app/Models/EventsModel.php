<?php

namespace App\Models;

use CodeIgniter\Model;

class EventsModel extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'id_event';
    protected $allowedFields = ['nama_event', 'deskripsi', 'jenis', 'created_by'];

    // Mengaktifkan timestamps agar otomatis diisi oleh CI4
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at'; 
}