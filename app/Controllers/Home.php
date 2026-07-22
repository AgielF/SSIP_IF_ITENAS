<?php

namespace App\Controllers;

// Import semua model yang dibutuhkan di satu tempat
use App\Models\JadwalModel;
use App\Models\AsistenJadwalModel;
use App\Models\UserModel;
use App\Models\ProyekRisetModel;
use App\Models\PublikasiModel;
use App\Models\GaleriUmumModel;
use App\Models\VisiMisiModel;
use App\Models\EventsModel;
use App\Models\BeritaModel;
// use App\Models\RekrutmenModel; // Asumsi ada model ini
// use App\Models\RepositoriModel; // Asumsi ada model ini

class Home extends BaseController
{

    /**
     * Mengambil dan memproses data jadwal.
     */
    /**
     * [T2.1] Refactored: Mengambil dan memproses data jadwal.
     *
     * SEBELUM: Menjalankan 1 + N query (satu per jadwal untuk data asisten).
     * SESUDAH : Menggunakan JadwalModel::getJadwalWithAsisten() — SATU query tunggal.
     * Referensi: Refactoring (Martin Fowler).
     */
    private function getProcessedJadwalData(?int $limit = null): array
    {
        $jadwalModel   = new JadwalModel();
        // [T2.1] Satu query: data jadwal + asisten via GROUP_CONCAT + JOIN
        $databaseData  = $jadwalModel->getJadwalWithAsisten($limit);

        $processedSchedules = [];
        $today = new \DateTime('today');

        foreach ($databaseData as $item) {
            $scheduleDate = new \DateTime($item['tanggal']);

            if ($scheduleDate > $today) {
                $status = 'Upcoming'; $status_color = 'success';
            } elseif ($scheduleDate < $today) {
                $status = 'Completed'; $status_color = 'primary';
            } else {
                $status = 'Today'; $status_color = 'warning';
            }

            // nama_asisten sudah tersedia dari GROUP_CONCAT — TIDAK ada query tambahan.
            $namaAsisten = !empty($item['nama_asisten']) ? $item['nama_asisten'] : 'Belum Ditentukan';

            $processedSchedules[] = [
                'id_jadwal'    => $item['id_jadwal'],
                'title'        => $item['nama_event'],
                'kelas'        => $item['kelas'] ?? '',
                'lab'          => $item['ruangan'] ?? '',
                'status'       => $status,
                'status_color' => $status_color,
                'date'         => $scheduleDate->format('l, d F Y'),
                'raw_date'     => $item['tanggal'],
                'time'         => date('H:i', strtotime($item['waktu_mulai'])) . ' - ' . date('H:i', strtotime($item['waktu_selesai'])),
                'instructor'   => $namaAsisten,
            ];
        }

        return $processedSchedules;
    }
    private function getTopicData():array{
         return [
            [
                'title' => 'Machine Learning',
                'description' => 'Supervised & unsupervised learning, evaluation models, ensemble models.',
                'icon' => 'fa-brain'
            ],
            [
                'title' => 'Data Mining',
                'description' => 'Clustering, classification, association, anomalies.',
                'icon' => 'fa-database'
            ],
            [
                'title' => 'Deep Learning',
                'description' => 'Deep Learning for NLP, Deep Learning for Image & Visual, and Time Series & Signal.',
                'icon' => 'fa-layer-group'
            ],
            [
                'title' => 'Artificial Intelligence',
                'description' => 'Fuzzy logic, symbolic AI, heuristics, intelligent agents.',
                'icon' => 'fa-robot'
            ],
            [
                'title' => 'Expert System',
                'description' => 'Rule-based systems, inference engines, knowledge bases.',
                'icon' => 'fa-cogs'
            ],
            [
                'title' => 'Smart System',
                'description' => 'Predictive systems, recommendation systems, adaptive systems.',
                'icon' => 'fa-lightbulb'
            ],
        ];
    }

    /**
     * Mengambil dan memproses data anggota lab (personnel).
     */

    // ===================================================================
    // PUBLIC METHODS (Dapat diakses melalui Routes)
    // Setiap method sekarang menjadi sangat ringkas.
    // ===================================================================

    private function getBeritaData(): array
    {
        // Fetch berita data
        $beritaModel = new BeritaModel();
        $beritaList = $beritaModel->select('berita.*, users.nama as creator')
                                  ->join('users', 'users.id = berita.id_user')
                                  ->orderBy('berita.tanggal', 'DESC')
                                  ->findAll(5); // Limit to 5 latest berita

        return $beritaList;
    }

    public function index()
    {
        $visiMisiModel = new VisiMisiModel();
        $data = [
            'title'     => 'Beranda | Lab. SSIP - Institut Teknologi Nasional Bandung',
            'schedules' => $this->getProcessedJadwalData(6), // Limit to 6 schedules for home page
            'visi'      => $visiMisiModel->where('judul', 'Visi')->first()['isi'] ?? '',
            'misi'      => $visiMisiModel->where('judul', 'Misi')->first()['isi'] ?? '',
            'fields'    => $this->getTopicData(),           // Data untuk section topic
            'berita_list' => $this->getBeritaData()
        ];
        return view('home_view', $data);
    }
    public function agenda_paginated()
    {
        // [T2.1] Refactored: menggunakan getProcessedJadwalData() yang sudah efisien.
        // Duplikasi logika N+1 query yang ada sebelumnya telah dihapus.
        return $this->getProcessedJadwalData();
    }

    //penelitian-proyek
    //publikasi 
    //anggota 
    //dipindahkan sehingga mempunya controller masing-masing

    // --- Repositori ---
    public function repositori()
    {
        // TODO: Implement RepositoriModel when available
        $data = [
            'title' => 'Repositori',
            'repos' => [] // Placeholder for repository data
        ];
        return view('repositori_admin_list_view', $data);
    }

    public function repositori_admin()
    {
        // TODO: Implement RepositoriModel when available
        $data = [
            'title' => 'Admin: Kelola Repositori',
            'repos' => [] // Placeholder for repository data
        ];
        return view('repositori_admin_list_view', $data);
    }

    
}
