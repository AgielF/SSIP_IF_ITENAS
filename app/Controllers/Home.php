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
    private function getProcessedJadwalData($limit = null): array
    {
        // Initialize models
        $jadwalModel = new JadwalModel();
        $asistenJadwalModel = new AsistenJadwalModel();
        $databaseData = $jadwalModel->getJadwalWithDetails();
        
        // Sort by date ascending to get upcoming schedules first
        usort($databaseData, function($a, $b) {
            return strtotime($a['tanggal']) - strtotime($b['tanggal']);
        });
        
        // Apply limit if specified
        if ($limit !== null) {
            $databaseData = array_slice($databaseData, 0, $limit);
        }
        
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
            
            // Get assistants for this schedule from our pre-fetched data
            $asisten = $asistenBySchedule[$item['id_jadwal']] ?? [];
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
            'title'     => 'Beranda | Lab. Fisika Dasar',
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
        return view('repositori_list_view', $data);
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
