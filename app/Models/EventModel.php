<?php

namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'id_event';
    protected $allowedFields = ['nama_event', 'deskripsi', 'jenis', 'created_by', 'created_at', 'updated_at'];
}
