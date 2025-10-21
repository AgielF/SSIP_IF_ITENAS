<?php

namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
    protected $table      = 'events';
    protected $primaryKey = 'id_event';

    protected $allowedFields = ['nama_event', 'deskripsi', 'jenis','created_by'];

    // Aktifkan fitur otomatis isi created_at & updated_at
    protected $useTimestamps = true;  
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
