<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalModel extends Model
{
    protected $table = 'jadwal';
    protected $primaryKey = 'id_jadwal';
    protected $allowedFields = ['id_event', 'tanggal', 'waktu_mulai', 'waktu_selesai', 'ruangan', 'created_at', 'updated_at'];

    public function getJadwalWithDetails()
    {
        // Query untuk mengambil data jadwal dengan detail event
        return $this->select('jadwal.*, events.nama_event')
                    ->join('events', 'events.id_event = jadwal.id_event')
                    ->findAll();
    }
}


    public function getJadwalWithDetails()
    {
        // Query untuk mengambil data jadwal dengan detail event
        return $this->select('jadwal.*, events.nama_event')
                    ->join('events', 'events.id_event = jadwal.id_event')
                    ->findAll();
    }
}