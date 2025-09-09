<?php

namespace App\Models;

use CodeIgniter\Model;

class GaleriUmumModel extends Model
{
    protected $table = 'galeri_umum';
    protected $primaryKey = 'id_galeri';
    protected $allowedFields = ['kategori', 'keterangan', 'file_url', 'tanggal_upload', 'id_user'];

    // Fungsi tampilkan semua data
    public function getAllData()
    {
        return $this->findAll();
    }

    // Fungsi tampil data dengan join ke users (opsional)
    public function getDataWithUser()
    {
        return $this->select('galeri_umum.*, users.nama as nama_user')
                    ->join('users', 'users.id = galeri_umum.id_user', 'left')
                    ->orderBy('galeri_umum.tanggal_upload', 'DESC')
                    ->findAll();
    }


     public function getDataAdmin(){
        // 1. Ambil semua data dari database dengan join yang diperlukan

    $semuaGaleri =$this->select('galeri_umum.*, users.nama as nama_user')
                    ->join('users', 'users.id = galeri_umum.id_user', 'left')
                    ->orderBy('galeri_umum.tanggal_upload', 'DESC')
                    ->findAll();


                     $headers = ['Preview','Keterangan', 'Kategori','Tanggal Upload'];

                     $rows = [];


     foreach ($semuaGaleri as $items) {

                 $rows[] = [
               
               
                $items['keterangan'],
                $items['file_url'],
                $items['kategori'],
                $items['tanggal_upload']
                 ];

                }

    return [

            'galeri' => [
            'headers' => $headers,
            'rows' => $rows
            ]

            ];
    }

} 