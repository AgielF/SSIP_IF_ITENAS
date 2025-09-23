<?php

namespace App\Models;

use CodeIgniter\Model;

class GaleriUmumModel extends Model
{
    protected $table = 'galeri_umum';
    protected $primaryKey = 'id_galeri';
    protected $allowedFields = [
        'kategori', 'keterangan', 'file_url',
        'tanggal_upload', 'id_user'
    ];

    // Ambil semua data galeri dengan join user
    public function getDataWithUser()
    {
        return $this->select('galeri_umum.*, users.nama as nama_user')
                    ->join('users', 'users.id = galeri_umum.id_user', 'left')
                    ->orderBy('galeri_umum.tanggal_upload', 'DESC')
                    ->findAll();
    }

    // Ambil data khusus untuk admin (sudah diformat header + rows)
    public function getDataAdminFormatted()
    {
        $semuaGaleri = $this->select('galeri_umum.*, users.nama as nama_user')
                            ->join('users', 'users.id = galeri_umum.id_user', 'left')
                            ->orderBy('galeri_umum.tanggal_upload', 'DESC')
                            ->findAll();

        $headers = ['ID', 'Kategori', 'Keterangan', 'File', 'Tanggal Upload'];
        $rows = [];

        foreach ($semuaGaleri as $item) {
            $rows[] = [
                $item['id_galeri'],
                $item['kategori'],
                $item['keterangan'],
                $item['file_url'],
                $item['tanggal_upload'],
            ];
        }

        return [
            'galeri' => [
                'headers' => $headers,
                'rows'    => $rows
            ]
        ];
    }
}
