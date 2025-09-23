<?php

namespace App\Models;

use CodeIgniter\Model;

class RekrutModel extends Model
{
    protected $table = 'rekrut';
    protected $primaryKey = 'id_rekrut';
    protected $allowedFields = [
        'id_user', 'id_jadwal', 'deskripsi',
        'status', 'syarat', 'created_at', 'updated_at'
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
    public function getDataAdminFormatted()
{
    
    $semua = $this->select('rekrut.id_rekrut, rekrut.deskripsi, rekrut.status, rekrut.syarat, 
                        rekrut.id_jadwal, jadwal.tanggal, jadwal.waktu_mulai, jadwal.waktu_selesai, events.nama_event')
              ->join('jadwal', 'jadwal.id_jadwal = rekrut.id_jadwal', 'left')
              ->join('events', 'events.id_event = jadwal.id_event', 'left')
              ->orderBy('rekrut.created_at', 'DESC')
              ->findAll();


    $headers = ['Deskripsi', 'Status', 'Syarat', 'Jadwal'];
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
];



}


    return [
        'rekrutmen' => [
            'headers' => $headers,
            'rows'    => $rows
        ]
    ];
}

}
