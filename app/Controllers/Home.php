<?php

namespace App\Controllers;

use App\Models\JadwalModel;
use App\Models\AsistenJadwalModel;
class Home extends BaseController
{
    /**
     * Method untuk menampilkan halaman utama (Beranda).
     * URL: /
     */
    public function index()
    {
        $jadwalModel = new JadwalModel();
        $asistenJadwalModel = new AsistenJadwalModel();
        
        // 1. Ambil data gabungan dari database
        $databaseData = $jadwalModel->getJadwalWithDetails();

        // 2. Siapkan array kosong untuk menampung data yang sudah diproses
        $processedSchedules = [];
        $today = new \DateTime('today');

        // 3. Looping dan format data
        foreach ($databaseData as $item) {
            $scheduleDate = new \DateTime($item['tanggal']);
            
            // Tentukan status berdasarkan tanggal
            if ($scheduleDate > $today) {
                $status = 'Upcoming';
                $status_color = 'success';
                $actions = ['details', 'cancel'];
            } elseif ($scheduleDate < $today) {
                $status = 'Completed';
                $status_color = 'primary';
                $actions = ['details', 'report'];
            } else {
                $status = 'Today';
                $status_color = 'warning';
                $actions = ['details', 'reschedule'];
            }

            // Ambil nama asisten (disederhanakan, ambil yang pertama)
            $asisten = $asistenJadwalModel->getAsistenByJadwal($item['id_jadwal']);
            $instructor = !empty($asisten) ? $asisten[0]['nama'] : 'Belum Ditentukan';

            $processedSchedules[] = [
                'title'        => $item['nama_event'],
                'lab'          => $item['ruangan'],
                'status'       => $status,
                'status_color' => $status_color,
                'date'         => $scheduleDate->format('l, d F Y'),
                'time'         => date('H:i', strtotime($item['waktu_mulai'])) . ' - ' . date('H:i', strtotime($item['waktu_selesai'])),
                'instructor'   => $instructor,
                'actions'      => $actions
            ];
        }

        // 4. Kirim data yang sudah diproses ke view
        $data = [
            'title'     => 'Daftar Jadwal Lab',
            'schedules' => $processedSchedules // Gunakan key 'schedules' sesuai kebutuhan view
        ];

        // 5. Siapkan data untuk Visi & Misi
        $model = new \App\Models\VisiMisiModel();
        $visiRow = $model->where('judul', 'Visi')->first();
        $misiRow = $model->where('judul', 'Misi')->first();
        $data['visi'] = $visiRow ? $visiRow['isi'] : '';
        $data['misi'] = $misiRow ? $misiRow['isi'] : '';

        // Memuat view home_view, yang akan dibungkus oleh layout/main.php
        return view('home_view', $data);
    }

    /**
     * Method untuk menampilkan halaman Agenda & Acara.
     * URL: /agenda
     */
    public function agenda()
    {
        $jadwalModel = new JadwalModel();
        $asistenJadwalModel = new AsistenJadwalModel();
        
        // 1. Ambil data gabungan dari database
        $databaseData = $jadwalModel->getJadwalWithDetails();

        // 2. Siapkan array kosong untuk menampung data yang sudah diproses
        $processedSchedules = [];
        $today = new \DateTime('today');

        // 3. Looping dan format data
        foreach ($databaseData as $item) {
            $scheduleDate = new \DateTime($item['tanggal']);
            
            // Tentukan status berdasarkan tanggal
            if ($scheduleDate > $today) {
                $status = 'Upcoming';
                $status_color = 'success';
                $actions = ['details', 'cancel'];
            } elseif ($scheduleDate < $today) {
                $status = 'Completed';
                $status_color = 'primary';
                $actions = ['details', 'report'];
            } else {
                $status = 'Today';
                $status_color = 'warning';
                $actions = ['details', 'reschedule'];
            }

            // Ambil nama asisten (disederhanakan, ambil yang pertama)
            $asisten = $asistenJadwalModel->getAsistenByJadwal($item['id_jadwal']);
            $instructor = !empty($asisten) ? $asisten[0]['nama'] : 'Belum Ditentukan';

            $processedSchedules[] = [
                'title'        => $item['nama_event'],
                'lab'          => $item['ruangan'],
                'status'       => $status,
                'status_color' => $status_color,
                'date'         => $scheduleDate->format('l, d F Y'),
                'time'         => date('H:i', strtotime($item['waktu_mulai'])) . ' - ' . date('H:i', strtotime($item['waktu_selesai'])),
                'instructor'   => $instructor,
                'actions'      => $actions
            ];
        }

        // 4. Kirim data yang sudah diproses ke view
        $data = [
            'title'     => 'Daftar Jadwal Lab',
            'schedules' => $processedSchedules // Gunakan key 'schedules' sesuai kebutuhan view
        ];
        // Memuat view acara_list_view
        return view('acara_list_view', $data);
    }

      public function jadwal()
    {
        $jadwalModel = new JadwalModel();
        $asistenJadwalModel = new AsistenJadwalModel();
        
        // 1. Ambil data gabungan dari database
        $databaseData = $jadwalModel->getJadwalWithDetails();

        // 2. Siapkan array kosong untuk menampung data yang sudah diproses
        $processedSchedules = [];
        $today = new \DateTime('today');

        // 3. Looping dan format data
        foreach ($databaseData as $item) {
            $scheduleDate = new \DateTime($item['tanggal']);
            
            // Tentukan status berdasarkan tanggal
            if ($scheduleDate > $today) {
                $status = 'Upcoming';
                $status_color = 'success';
                $actions = ['details', 'cancel'];
            } elseif ($scheduleDate < $today) {
                $status = 'Completed';
                $status_color = 'primary';
                $actions = ['details', 'report'];
            } else {
                $status = 'Today';
                $status_color = 'warning';
                $actions = ['details', 'reschedule'];
            }

            // Ambil nama asisten (disederhanakan, ambil yang pertama)
            $asisten = $asistenJadwalModel->getAsistenByJadwal($item['id_jadwal']);
            $instructor = !empty($asisten) ? $asisten[0]['nama'] : 'Belum Ditentukan';

            $processedSchedules[] = [
                'title'        => $item['nama_event'],
                'lab'          => $item['ruangan'],
                'status'       => $status,
                'status_color' => $status_color,
                'date'         => $scheduleDate->format('l, d F Y'),
                'time'         => date('H:i', strtotime($item['waktu_mulai'])) . ' - ' . date('H:i', strtotime($item['waktu_selesai'])),
                'instructor'   => $instructor,
                'actions'      => $actions
            ];
        }

        // 4. Kirim data yang sudah diproses ke view
        $data = [
            'title'     => 'Daftar Jadwal Lab',
            'schedules' => $processedSchedules // Gunakan key 'schedules' sesuai kebutuhan view
        ];
        return view('jadwal_card_view', $data); 
    }
      public function jadwal_card()
    {
        $data = [
            'title' => 'Visi & Misi | Lab. Fisika Dasar'
        ];
        // Buat file view baru bernama 'visi_misi_page.php' jika diperlukan
        // atau gabungkan di view lain.
        // Untuk contoh ini, kita anggap ada view khusus.
        return view('jadwal_view', $data); 
    }
      public function galeri()
    {
        $data = [
            'title' => 'Visi & Misi | Lab. Fisika Dasar'
        ];
        // Buat file view baru bernama 'visi_misi_page.php' jika diperlukan
        // atau gabungkan di view lain.
        // Untuk contoh ini, kita anggap ada view khusus.
        return view('galeri_list_view', $data); 
    }
    
    
    public function penelitian_proyek()
    {
        $data = [
            'title' => 'Visi & Misi | Lab. Fisika Dasar'
        ];
        // Buat file view baru bernama 'visi_misi_page.php' jika diperlukan
        // atau gabungkan di view lain.
        // Untuk contoh ini, kita anggap ada view khusus.
        return view('penelitian_proyek_list', $data); 
    }
     public function publikasi_ilmiah()
    {
        $data = [
            'title' => 'Visi & Misi | Lab. Fisika Dasar'
        ];
        // Buat file view baru bernama 'visi_misi_page.php' jika diperlukan
        // atau gabungkan di view lain.
        // Untuk contoh ini, kita anggap ada view khusus.
        return view('publikasi_ilmiah_list_view', $data); 
    }

    // Anda bisa menambahkan method lain untuk halaman lain di sini
    // contoh: public function kontak() { ... }
}
