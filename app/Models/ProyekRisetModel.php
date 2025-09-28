<?php

namespace App\Models;

use CodeIgniter\Model;

class ProyekRisetModel extends Model
{
    protected $table = 'proyek_riset';
    protected $primaryKey = 'id_proyek';
    protected $allowedFields = ['judul', 'deskripsi', 'mitra', 'sumber_dana', 'tahun_mulai', 'tahun_selesai', 'id_user', 'created_at', 'updated_at'];

    /**
     * Mengambil dan memformat data proyek agar siap ditampilkan di view.
     * Fungsi ini menggabungkan data dari database dengan struktur 
     * 'headers' dan 'rows' yang dibutuhkan oleh JavaScript.
     *
     * @return array Data yang sudah diformat.
     */
    protected $returnType = 'array'; // 🔹 tambahkan ini
    public function getProyekDataFormattedForView()
    {
        // 1. Ambil semua data dari database menggunakan instance model ini ($this)
         $semuaProyek = $this->select('proyek_riset.*, users.nama as pembuat')
                        ->join('users', 'users.id = proyek_riset.id_user', 'left')
                        ->findAll();


        // 2. Siapkan header tabel dan array untuk baris data
        $headers = ['Judul','Pembuat', 'Deskripsi','Mitra', 'Sumber Dana', 'Tahun Mulai', 'Tahun Selesai'];
        $rows = [];

        foreach ($semuaProyek as $proyek) {
            $rows[] = [
                $proyek['judul'],
                $proyek['pembuat'],
                $proyek['deskripsi'],
                $proyek['mitra'],
                $proyek['sumber_dana'],
                $proyek['tahun_mulai'],
                $proyek['tahun_selesai']
                
            ];
        }

        // 3. Kembalikan data dalam format yang siap dikirim ke view
        return [
            'riset' => [
                'headers' => $headers,
                'rows' => $rows
            ]
        ];
    }
     // 🔹 Ambil semua proyek riset + nama pembuat
    public function getProyekWithUser()
    {
        return $this->select('proyek_riset.*, users.nama as pembuat')
                    ->join('users', 'users.id = proyek_riset.id_user', 'left')
                    ->findAll();
    }


}
