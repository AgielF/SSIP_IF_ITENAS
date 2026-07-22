<?php

namespace App\Models;

use CodeIgniter\Model;

class RekrutModel extends Model
{
    protected $table = 'rekrut';
    protected $primaryKey = 'id_rekrut';
    protected $useTimestamps = true; // [T3.1] CI4 mengelola timestamps otomatis
    protected $allowedFields = [
        'id_user', 'id_jadwal', 'deskripsi',
        'status', 'syarat','link_gform'
    ];

    // Untuk publik (gabung user, jadwal, event)
    public function getDataPublik()
    {
        return $this->select('rekrut.*, users.nama as nama_user, jadwal.tanggal, jadwal.waktu_mulai, events.nama_event')
                    ->join('users', 'users.id = rekrut.id_user', 'left')
                    ->join('jadwal', 'jadwal.id_jadwal = rekrut.id_jadwal', 'left')
                    ->join('events', 'events.id_event = jadwal.id_event', 'left')
                    ->orderBy('rekrut.created_at', 'DESC')
                    ->findAll();
    }

    // Untuk admin (format siap table)
 public function getDataAdminFormatted($sort = 'desc')
{
    $semua = $this->select('
                    rekrut.id_rekrut,
                    rekrut.deskripsi,
                    rekrut.status,
                    rekrut.syarat,
                    rekrut.id_jadwal,
                    rekrut.id_user,
                    rekrut.created_at,
                    users.nama as nama_user,
                    jadwal.tanggal,
                    jadwal.waktu_mulai,
                    jadwal.waktu_selesai,
                    events.nama_event
                ')
                ->join('users', 'users.id = rekrut.id_user', 'left')
                ->join('jadwal', 'jadwal.id_jadwal = rekrut.id_jadwal', 'left')
                ->join('events', 'events.id_event = jadwal.id_event', 'left')
                ->orderBy('rekrut.created_at', $sort) // ✅ ASC / DESC langsung dari controller
                ->findAll();

    $rows = [];
    foreach ($semua as $r) {
        $rows[] = [
            'id_rekrut' => $r['id_rekrut'],
            'deskripsi' => $r['deskripsi'],
            'status'    => $r['status'],
            'syarat'    => $r['syarat'],
            'id_jadwal' => $r['id_jadwal'],
            'jadwal'    => (!empty($r['waktu_mulai']) ? date('H:i', strtotime($r['waktu_mulai'])) : '-') 
                           . ' - ' .
                           (!empty($r['waktu_selesai']) ? date('H:i', strtotime($r['waktu_selesai'])) : '-'),
            'pembuat'   => $r['nama_user'] ?? '-',
            'event'     => $r['nama_event'] ?? '-', // <-- Ekor yang rusak sudah dihapus
        ];
    }

    return [
        'rekrutmen' => [
            'headers' => ['Deskripsi', 'Status', 'Syarat', 'Jadwal', 'Pembuat'],
            'rows'    => $rows
        ]
    ];
}


}
