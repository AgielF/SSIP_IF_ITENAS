<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalModel extends Model
{
    protected $table            = 'jadwal';
    protected $primaryKey       = 'id_jadwal';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    // Kolom yang diizinkan untuk diisi
    protected $allowedFields    = ['id_event', 'tanggal', 'waktu_mulai', 'waktu_selesai', 'ruangan'];

    // Tidak ada timestamps di tabel ini
    protected $useTimestamps = false;

    /**
     * Method kustom untuk mengambil jadwal beserta semua detail event-nya.
     */
    public function getJadwalWithDetails()
    {
        return $this->db->table('jadwal')
            ->join('events', 'events.id_event = jadwal.id_event')
            // UBAH BAGIAN INI: Memilih semua kolom dari kedua tabel
            ->select('jadwal.*, events.*')
            ->get()->getResultArray();
    }
}
