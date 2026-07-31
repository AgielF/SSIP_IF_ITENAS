<?php

namespace App\Models;

use CodeIgniter\Model;

class PublikasiModel extends Model
{
    protected $table = 'publikasi';
    protected $primaryKey = 'id_publikasi';
    protected $useTimestamps = true; // [T3.1] CI4 mengelola timestamps otomatis
    protected $allowedFields = [
        'jenis_publikasi',
        'link_publikasi',
        'kategori',
        'tanggal_publikasi',
        'id_user',
        'penulis_pendamping',
        'volume',
        'nomor',
        'tahun',
        'link_doi',
        'link_gdrive',
        'conference',
        'deskripsi',
        'topik',
        'judul',
        'lokasi_conference',
        'publisher_jurnal'

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
                    'Judul', 'Kategori', 'Topik', 'Tanggal Publikasi', 'Penulis Utama', 'Penulis Pendamping',
                    'Volume', 'Tahun', 'Publisher Jurnal', 'Nomor', 'Deskripsi', 'Link Publikasi', 'Link DOI', 'Link Gdrive'
                ],
                'rows' => []
            ],
            'prosiding' => [
                'headers' => [
                    'Judul', 'Kategori', 'Topik', 'Tanggal Publikasi', 'Penulis Utama', 'Penulis Pendamping',
                    'Conference', 'Lokasi Conference', 'Nomor', 'Deskripsi', 'Link Publikasi', 'Link DOI', 'Link Gdrive'
                ],
                'rows' => []
            ],
            'paten' => [
                'headers' => [
                    'Judul', 'Kategori', 'Topik', 'Tanggal Publikasi', 'Penulis Utama', 'Penulis Pendamping',
                    'Volume', 'Tahun', 'Nomor', 'Deskripsi', 'Link Publikasi', 'Link DOI', 'Link Gdrive'
                ],
                'rows' => []
            ]
        ];

        foreach ($semuaProyek as $pub) {
            $link_publikasi = !empty($pub['link_publikasi']) ? '<a href="' . esc($pub['link_publikasi'], 'attr') . '" class="btn btn-sm btn-info" target="_blank">Link Publikasi</a>' : '-';
            $link_doi = !empty($pub['link_doi']) ? '<a href="' . esc($pub['link_doi'], 'attr') . '" class="btn btn-sm btn-info" target="_blank">Link DOI</a>' : '-';
            $link_gdrive = !empty($pub['link_gdrive']) ? '<a href="' . esc($pub['link_gdrive'], 'attr') . '" class="btn btn-sm btn-info" target="_blank">Link Gdrive</a>' : '-';

            if ($pub['jenis_publikasi'] === 'jurnal') {
                $processedData['jurnal']['rows'][] = [
                    $pub['judul'] ?? '-', $pub['kategori'] ?? '-', $pub['topik'] ?? '-', $pub['tanggal_publikasi'] ?? '-',
                    $pub['penulis_utama'] ?? '-', $pub['penulis_pendamping'] ?? '-', $pub['volume'] ?? '-',
                    $pub['tahun'] ?? '-', $pub['publisher_jurnal'] ?? '-', $pub['nomor'] ?? '-', $pub['deskripsi'] ?? '-',
                    $link_publikasi, $link_doi, $link_gdrive
                ];
            } elseif ($pub['jenis_publikasi'] === 'prosiding') {
                $processedData['prosiding']['rows'][] = [
                    $pub['judul'] ?? '-', $pub['kategori'] ?? '-', $pub['topik'] ?? '-', $pub['tanggal_publikasi'] ?? '-',
                    $pub['penulis_utama'] ?? '-', $pub['penulis_pendamping'] ?? '-', $pub['conference'] ?? '-',
                    $pub['lokasi_conference'] ?? '-', $pub['nomor'] ?? '-', $pub['deskripsi'] ?? '-',
                    $link_publikasi, $link_doi, $link_gdrive
                ];
            } elseif ($pub['jenis_publikasi'] === 'paten') {
                $processedData['paten']['rows'][] = [
                    $pub['judul'] ?? '-', $pub['kategori'] ?? '-', $pub['topik'] ?? '-', $pub['tanggal_publikasi'] ?? '-',
                    $pub['penulis_utama'] ?? '-', $pub['penulis_pendamping'] ?? '-', $pub['volume'] ?? '-',
                    $pub['tahun'] ?? '-', $pub['nomor'] ?? '-', $pub['deskripsi'] ?? '-',
                    $link_publikasi, $link_doi, $link_gdrive
                ];
            }
        }

        return $processedData;
    }
    public function getDataWithUser(){
         return $this->select('publikasi.*, users.nama as penulis_utama')
                    ->join('users', 'users.id = publikasi.id_user', 'left');
    }
    public function getPublikasiByTopik(string $topik)
{
    return $this->select('publikasi.*, users.nama as penulis_utama')
                ->join('users', 'users.id = publikasi.id_user', 'left')
                ->where('publikasi.topik', $topik)
                ->findAll();
}

}
