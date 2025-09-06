<?php

namespace App\Models;

use CodeIgniter\Model;

class PublikasiModel extends Model
{
    protected $table = 'publikasi';
    protected $primaryKey = 'id_publikasi';
    protected $allowedFields = ['jenis_publikasi', 'link_publikasi', 'kategori', 'tanggal_publikasi', 'id_user', 'created_at', 'updated_at', 'penulis_pendamping', 'volume', 'nomor', 'tahun', 'link_doi', 'link_gdrive', 'conference', 'deskripsi'];

    public function getPublikasiDataFormatedView(){
         // 1. Ambil semua data dari database menggunakan instance model ini ($this)
        $semuaProyek = $this->findAll();

        // 2. Siapkan struktur data yang diharapkan oleh view
        $processedData = [
            'jurnal' => [
                'headers' => ['Kategori', 'Tanggal Publikasi', 'Penulis Pendamping', 'Volume', 'Tahun', 'Nomor','conference','deskripsi','link publikasi','',''],
                'rows' => []
            ],
            'prosiding' => [
                'headers' => ['Kategori', 'Tanggal Publikasi', 'Penulis Pendamping', 'Volume', 'Tahun', 'Nomor','conference','deskripsi','link publikasi','',''],
                'rows' => []
            ],
            'paten' => [
                'headers' => ['Kategori', 'Tanggal Publikasi', 'Penulis Pendamping', 'Volume', 'Tahun', 'Nomor','conference','deskripsi','link publikasi','',''],
                'rows' => []
            ]
        ];
        
        // 3. Kelompokkan data dari database ke dalam struktur yang benar
        foreach ($semuaProyek as $pub) {
            $link_publikasi = '<a href="'.esc($pub['link_publikasi'], 'attr').'" class="btn btn-sm btn-info" target="_blank">GDrive</a>';
            $link_doi = '<a href="'.esc($pub['link_publikasi'], 'attr').'" class="btn btn-sm btn-info" target="_blank">GDrive</a>';
            $link_gdrive = '<a href="'.esc($pub['link_publikasi'], 'attr').'" class="btn btn-sm btn-info" target="_blank">GDrive</a>';


            switch ($pub['jenis_publikasi']) {
                case 'jurnal':
                    $processedData['jurnal']['rows'][] = [
                        $pub['kategori'],
                        $pub['tanggal_publikasi'],
                        $pub['penulis_pendamping'],
                        $pub['volume'],
                        $pub['tahun'],
                        $pub['nomor'],
                        $pub['conference'],
                        $pub['deskripsi'],
                        $link_publikasi,
                        $link_doi,
                        $link_gdrive
                    

                    ];
                    break;
                case 'prosiding':
                    $processedData['prosiding']['rows'][] = [
                        $pub['kategori'],
                        $pub['tanggal_publikasi'],
                        $pub['penulis_pendamping'],
                        $pub['volume'],
                        $pub['tahun'],
                        $pub['nomor'],
                        $pub['conference'],
                        $pub['deskripsi'],
                        $link_publikasi,
                        $link_doi,
                        $link_gdrive
                    
                    ];
                    break;
                case 'paten':
                     $processedData['paten']['rows'][] = [
                        $pub['kategori'],
                        $pub['tanggal_publikasi'],
                        $pub['penulis_pendamping'],
                        $pub['volume'],
                        $pub['tahun'],
                        $pub['nomor'],
                        $pub['conference'],
                        $pub['deskripsi'],
                        $link_publikasi,
                        $link_doi,
                        $link_gdrive
                    ];
                    break;

                    
            }
        }


        return $processedData;

    }

}