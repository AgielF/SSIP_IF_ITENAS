<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\AsistenJadwalModel;

class JadwalModel extends Model
{
    protected $table = 'jadwal';
    protected $primaryKey = 'id_jadwal';
    protected $allowedFields = ['id_event', 'tanggal', 'waktu_mulai', 'waktu_selesai', 'ruangan', 'kelas', 'created_at', 'updated_at'];

    public function getJadwalWithDetails()
    {
        return $this->select('jadwal.*, events.nama_event')
                    ->join('events', 'events.id_event = jadwal.id_event')
                    ->findAll();
    }
}
