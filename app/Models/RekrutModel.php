<?php

namespace App\Models;

use CodeIgniter\Model;

class RekrutModel extends Model
{
    protected $table = 'rekrut';
    protected $primaryKey = 'id_rekrut';
    protected $allowedFields = ['id_user', 'id_jadwal', 'deskripsi', 'status', 'syarat', 'created_at', 'updated_at'];

    /**
     * Mengambil semua data rekrutmen dengan detail dari tabel user dan jadwal.
     * Menggabungkan tabel rekrut, users, jadwal, dan events.
     *
     * @return array
     */
    //tampil data rekrutmen
    public function index()
    {
        // Menggunakan Query Builder untuk membuat join yang kompleks
        return $this->select('rekrut.*, users.nama as nama_user, jadwal.tanggal, jadwal.waktu_mulai, events.nama_event')
                    ->join('users', 'users.id = rekrut.id_user', 'left') // Mengambil nama user
                    ->join('jadwal', 'jadwal.id_jadwal = rekrut.id_jadwal', 'left') // Mengambil info jadwal
                    ->join('events', 'events.id_event = jadwal.id_event', 'left') // Mengambil nama event dari jadwal
                    ->findAll();
    }
    public function getDataAdmin(){
        // 1. Ambil semua data dari database dengan join yang diperlukan

    $semuaRekrutmen = $this->select('rekrut.*, users.nama as nama_user, jadwal.tanggal, jadwal.waktu_mulai, events.nama_event')

                            ->join('users', 'users.id = rekrut.id_user', 'left')

                            ->join('jadwal', 'jadwal.id_jadwal = rekrut.id_jadwal', 'left')
                            ->join('events', 'events.id_event = jadwal.id_event', 'left')
                            ->findAll();


                     $headers = [ 'Deskripsi', 'Status', 'Syarat'];

                     $rows = [];


     foreach ($semuaRekrutmen as $rekrut) {

                 $rows[] = [
               
                $rekrut['deskripsi'],
                $rekrut['status'],
                $rekrut['syarat'],
                 ];

                }

    return [

            'rekrutmen' => [
            'headers' => $headers,
            'rows' => $rows
            ]

            ];
    }

}
