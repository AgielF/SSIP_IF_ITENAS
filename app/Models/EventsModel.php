<?php

namespace App\Models;

use CodeIgniter\Model;

class EventsModel extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'id_event';
    protected $allowedFields = ['nama_event', 'deskripsi', 'jenis', 'created_by', 'created_at', 'updated_at'];

    public function getEventsWithCreator()
    {
        return $this->select('events.*, users.nama as creator_name')
                    ->join('users', 'users.id = events.created_by')
                    ->findAll();
    }
}
