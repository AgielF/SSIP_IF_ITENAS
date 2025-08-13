<?php

namespace App\Models;

use CodeIgniter\Model;

class AsistenJadwalModel extends Model
{
    protected $table            = 'asisten_jadwal';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    // Kolom yang diizinkan untuk diisi
    protected $allowedFields    = ['id_jadwal', 'id_user'];

    // Tidak ada timestamps di tabel ini
    protected $useTimestamps = false;

    /**
     * Method kustom untuk mengambil asisten dari sebuah jadwal.
     */
    public function getAsistenByJadwal($id_jadwal)
    {
        return $this->db->table('asisten_jadwal')
            ->join('users', 'users.id = asisten_jadwal.id_user')
            ->where('asisten_jadwal.id_jadwal', $id_jadwal)
            ->select('users.nama, users.nomor')
            ->get()->getResultArray();
    }
}