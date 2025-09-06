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
// use App\Models\RekrutmenModel; // Asumsi ada model ini
// use App\Models\RepositoriModel; // Asumsi ada model ini

class Home extends BaseController
{
    // ===================================================================
    // HELPER METHODS (PRIBADI)
    // Logika pengambilan data dipusatkan di sini untuk menghindari duplikasi
    // ===================================================================

    /**
     * Mengambil dan memproses data jadwal.
     */
    private function getProcessedJadwalData(): array
    {
        $jadwalModel = new JadwalModel();
        $asistenJadwalModel = new AsistenJadwalModel();
        $databaseData = $jadwalModel->getJadwalWithDetails();
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
            $asisten = $asistenJadwalModel->getAsistenByJadwal($item['id_jadwal']);
            $instructor = !empty($asisten) ? $asisten[0]['nama'] : 'Belum Ditentukan';
            $processedSchedules[] = [
                'title' => $item['nama_event'], 'lab' => $item['ruangan'], 'status' => $status,
                'status_color' => $status_color, 'date' => $scheduleDate->format('l, d F Y'),
                'time' => date('H:i', strtotime($item['waktu_mulai'])) . ' - ' . date('H:i', strtotime($item['waktu_selesai'])),
                'instructor' => $instructor
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
                'title' => 'Expert Systems',
                'description' => 'Rule-based systems, inference engines, knowledge bases.',
                'icon' => 'fa-cogs'
            ],
            [
                'title' => 'Smart Systems',
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

    public function index()
    {
        $visiMisiModel = new VisiMisiModel();
        $data = [
            'title'     => 'Beranda | Lab. Fisika Dasar',
            'schedules' => $this->getProcessedJadwalData(),
            'visi'      => $visiMisiModel->where('judul', 'Visi')->first()['isi'] ?? '',
            'misi'      => $visiMisiModel->where('judul', 'Misi')->first()['isi'] ?? '',
            'fields'    => $this->getTopicData(),           // Data untuk section topic
        ];
        return view('home_view', $data);
    }
        public function agenda_paginated()
    {
        // Get query parameters for filtering and pagination
        $page = (int)($this->request->getVar('page') ?? 1);
        $limit = (int)($this->request->getVar('limit') ?? 15);
        $search = $this->request->getVar('search');
        $event = $this->request->getVar('event');
        $dateFrom = $this->request->getVar('date_from');
        $dateTo = $this->request->getVar('date_to');

        // Initialize models
        $jadwalModel = new JadwalModel();
        $eventsModel = new EventsModel();
        $asistenJadwalModel = new AsistenJadwalModel();
        $databaseData = $jadwalModel->getJadwalWithDetails();
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
            $asisten = $asistenJadwalModel->getAsistenByJadwal($item['id_jadwal']);
            $instructor = !empty($asisten) ? $asisten[0]['nama'] : 'Belum Ditentukan';
            $processedSchedules[] = [
                'title' => $item['nama_event'], 'lab' => $item['ruangan'], 'status' => $status,
                'status_color' => $status_color, 'date' => $scheduleDate->format('l, d F Y'),
                'time' => date('H:i', strtotime($item['waktu_mulai'])) . ' - ' . date('H:i', strtotime($item['waktu_selesai'])),
                'instructor' => $instructor
            ];
        }
        return $processedSchedules;
    }


    // --- Jadwal & Agenda ---
    public function jadwal()
    {
        $data = ['title' => 'Daftar Jadwal Lab', 'schedules' => $this->getProcessedJadwalData()];
        return view('jadwal_card_view', $data); 
    }

    public function jadwal_admin()
    {
        $data = ['title' => 'Admin: Kelola Jadwal Lab', 'schedules' => $this->getProcessedJadwalData()];
        return view('jadwal_admin_view', $data); 
    }

    public function agenda()
    {
        $data = ['title' => 'Agenda & Acara', 'schedules' => $this->getProcessedJadwalData()];
        return view('acara_list_view', $data);
    }

    //penelitian-proyek
    //publikasi 
    //anggota 
    //dipindahkan sehingga mempunya controller masing-masing

    
    // --- Galeri ---
    public function galeri()
    {
        $galeriModel = new GaleriUmumModel();
        $data = ['title' => 'Galeri', 'gallery' => $galeriModel->findAll()];
        return view('galeri_list_view', $data); 
    }

    public function galeri_admin()
    {
        $galeriModel = new GaleriUmumModel();
        $data = ['title' => 'Admin: Kelola Galeri', 'gallery' => $galeriModel->findAll()];
        return view('galeri_admin_list_view', $data); 
    }


    // --- Repositori ---
    public function repositori()
    {
        // $repositoriModel = new RepositoriModel();
        $data = ['title' => 'Repositori', 'repos'];
        return view('repositori_list_view', $data);
    }

    public function repositori_admin()
    {
        // $repositoriModel = new RepositoriModel();
        $data = ['title' => 'Admin: Kelola Repositori', 'repos'];
        return view('repositori_admin_list_view', $data);
    }

    // --- Rekrutmen ---
    public function rekrutmen()
    {
        // $rekrutmenModel = new RekrutmenModel();
        $data = ['title' => 'Rekrutmen', 'rekrutmen'];
        return view('rekrutmen_view', $data);
    }

    public function rekrutmen_admin()
    {
        // $rekrutmenModel = new RekrutmenModel();
        $data = ['title' => 'Admin: Kelola Rekrutmen', 'rekrutmen'];
        return view('rekrutmen_admin_view', $data);
    }
     public function user_profile()
    {
        // $rekrutmenModel = new RekrutmenModel();
        $data = ['title' => 'user profile', 'profile'];
        return view('user_profile_view', $data);
    }
     public function topic_detail()
    {
        // $rekrutmenModel = new RekrutmenModel();
        $data = ['title' => 'topic detail', 'topic'];
        return view('topic_view', $data);
    }

}
