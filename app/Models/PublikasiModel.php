<?php

namespace App\Models;

use CodeIgniter\Model;

class PublikasiModel extends Model
{
    protected $table = 'publikasi';
    protected $primaryKey = 'id_publikasi';
    protected $allowedFields = [
        'jenis_publikasi',
        'link_publikasi',
        'kategori',
        'tanggal_publikasi',
        'id_user',
        'created_at',
        'updated_at',
        'penulis_pendamping',
        'volume',
        'nomor',
        'tahun',
        'link_doi',
        'link_gdrive',
        'conference',
        'deskripsi'
    ];

    public function getPublikasiDataFormatedView()
    {
        // Join ke tabel users supaya bisa ambil nama penulis utama
    $semuaProyek = $this->select('publikasi.*, users.nama as penulis_utama')
                        ->join('users', 'users.id = publikasi.id_user', 'left')
                        ->findAll();

        $processedData = [
            'jurnal' => [
                'headers' => [
                    'Kategori',
                    'Tanggal Publikasi',
                    'Penulis Utama',
                    'Penulis Pendamping',
                    'Volume',
                    'Tahun',
                    'Nomor',
                    'Conference',
                    'Deskripsi',
                    'Link Publikasi',
                    'Link DOI',
                    'Link Gdrive'
                ],
                'rows' => []
            ],
            'prosiding' => [
                'headers' => [
                    'Kategori',
                    'Tanggal Publikasi',
                     'Penulis Utama',
                    'Penulis Pendamping',
                    'Volume',
                    'Tahun',
                    'Nomor',
                    'Conference',
                    'Deskripsi',
                    'Link Publikasi',
                    'Link DOI',
                    'Link Gdrive'
                ],
                'rows' => []
            ],
            'paten' => [
                'headers' => [
                    'Kategori',
                    'Tanggal Publikasi',
                     'Penulis Utama',
                    'Penulis Pendamping',
                    'Volume',
                    'Tahun',
                    'Nomor',
                    'Conference',
                    'Deskripsi',
                    'Link Publikasi',
                    'Link DOI',
                    'Link Gdrive'
                ],
                'rows' => []
            ]
        ];

        foreach ($semuaProyek as $pub) {
            $link_publikasi = '<a href="' . esc($pub['link_publikasi'], 'attr') . '" class="btn btn-sm btn-info" target="_blank">Link Publikasi</a>';
            $link_doi = '<a href="' . esc($pub['link_doi'], 'attr') . '" class="btn btn-sm btn-info" target="_blank">Link DOI</a>';
            $link_gdrive = '<a href="' . esc($pub['link_gdrive'], 'attr') . '" class="btn btn-sm btn-info" target="_blank">Link Gdrive</a>';

            $row = [
                $pub['kategori'],
                $pub['tanggal_publikasi'],
                $pub['penulis_utama'],
                $pub['penulis_pendamping'],
                $pub['volume'],
                $pub['tahun'],
                $pub['nomor'],
                $pub['conference'],
                $pub['deskripsi'],
                $link_publikasi,
                $link_doi,
                $link_gdrive,
                $pub['id_publikasi'] // simpan ID di akhir untuk tombol edit/delete
            ];

            if ($pub['jenis_publikasi'] === 'jurnal') {
                $processedData['jurnal']['rows'][] = $row;
            } elseif ($pub['jenis_publikasi'] === 'prosiding') {
                $processedData['prosiding']['rows'][] = $row;
            } elseif ($pub['jenis_publikasi'] === 'paten') {
                $processedData['paten']['rows'][] = $row;
            }
        }

        return $processedData;
    }
}
