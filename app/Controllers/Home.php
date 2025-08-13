<?php

namespace App\Controllers;

use App\Models\JadwalModel;
use App\Models\AsistenJadwalModel;
use App\Models\UserModel;
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

    /**
     * Method untuk menampilkan halaman Asisten Lab.
     * URL: /asisten
     */
    private function getProcessedPersonnelData(): array
    {
        $userModel = new UserModel();
        
        // Mengambil data user berdasarkan role
        $asisten = $userModel->getAsistenLab();
        $dosen = $userModel->getDosenLab();
        $praktikan = $userModel->praktikan();
        
        // Array untuk semua user
        $allPersonnel = [];
        
        // Menambahkan 'role' untuk setiap jenis user dan menggabungkannya
        foreach ($asisten as $a) {
            $a['role'] = 'asisten';
            $allPersonnel[] = $a;
        }
        
        foreach ($dosen as $d) {
            $d['role'] = 'dosen';
            $allPersonnel[] = $d;
        }
        
        foreach ($praktikan as $p) {
            $p['role'] = 'praktikan';
            $allPersonnel[] = $p;
        }
        
        return $allPersonnel;
    }

    /**
     * Menampilkan halaman daftar anggota lab untuk pengguna biasa.
     */
    public function asisten()
    {
        $data = [
            'title'   => 'Anggota Laboratorium',
            'asisten' => $this->getProcessedPersonnelData() // Panggil helper method
        ];
        return view('asisten_list_view', $data);
    }

    /**
     * Menampilkan halaman daftar anggota lab untuk admin.
     */
    public function asisten_admin()
    {
        $data = [
            'title'   => 'Admin: Kelola Anggota Laboratorium',
            'asisten' => $this->getProcessedPersonnelData() // Panggil helper method yang sama
        ];
        // Admin view mungkin memiliki tombol Edit/Hapus, jadi view-nya berbeda
        return view('asisten_list_admin_view', $data);
    }
     private function getProcessedJadwalData(): array
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
        
        return $processedSchedules;
    }
       public function jadwal()
    {
        $data = [
            'title'     => 'Daftar Jadwal Lab',
            'schedules' => $this->getProcessedJadwalData() // Panggil helper method
        ];
        return view('jadwal_card_view', $data); 
    }

    /**
     * Menampilkan halaman jadwal untuk admin.
     */
    public function jadwal_admin()
    {
        $data = [
            'title'     => 'Admin: Daftar Jadwal Lab',
            'schedules' => $this->getProcessedJadwalData() // Panggil helper method yang sama
        ];
        return view('jadwal_card_admin_view', $data); 
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
      public function galeri_admin()
    {
        $data = [
            'title' => 'Visi & Misi | Lab. Fisika Dasar'
        ];
        // Buat file view baru bernama 'visi_misi_page.php' jika diperlukan
        // atau gabungkan di view lain.
        // Untuk contoh ini, kita anggap ada view khusus.
        return view('galeri_list_admin_view', $data); 
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
    public function penelitian_proyek_admin()
    {
           $data = [
            'title' => 'Visi & Misi | Lab. Fisika Dasar'
        ];
        // Buat file view baru bernama 'visi_misi_page.php' jika diperlukan
        // atau gabungkan di view lain.
        // Untuk contoh ini, kita anggap ada view khusus.
        return view('penelitian_proyek_list_admin_view', $data); 
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
    public function publikasi_ilmiah_admin()
    {
        $data = [
            'title' => 'Visi & Misi | Lab. Fisika Dasar'
        ];
        // Buat file view baru bernama 'visi_misi_page.php' jika diperlukan
        // atau gabungkan di view lain.
        // Untuk contoh ini, kita anggap ada view khusus.
        return view('publikasi_ilmiah_list_admin_view', $data); 
    }


      public function repositori()
    {
        $data = [
            'title' => 'Visi & Misi | Lab. Fisika Dasar'
        ];
        // Buat file view baru bernama 'visi_misi_page.php' jika diperlukan
        // atau gabungkan di view lain.
        // Untuk contoh ini, kita anggap ada view khusus.
        return view('repositori_list_view', $data); 
    }
      public function repositori_admin()
    {
        $data = [
            'title' => 'Visi & Misi | Lab. Fisika Dasar'
        ];
        // Buat file view baru bernama 'visi_misi_page.php' jika diperlukan
        // atau gabungkan di view lain.
        // Untuk contoh ini, kita anggap ada view khusus.
        return view('repositori_list_admin_view', $data); 
    }
       public function rekrutmen()
    {
        $data = [
            'title' => 'Visi & Misi | Lab. Fisika Dasar'
        ];
        // Buat file view baru bernama 'visi_misi_page.php' jika diperlukan
        // atau gabungkan di view lain.
        // Untuk contoh ini, kita anggap ada view khusus.
        return view('rekrutmen_view', $data); 
    }
      public function rekrutmen_admin()
    {
        $data = [
            'title' => 'Visi & Misi | Lab. Fisika Dasar'
        ];
        // Buat file view baru bernama 'visi_misi_page.php' jika diperlukan
        // atau gabungkan di view lain.
        // Untuk contoh ini, kita anggap ada view khusus.
        return view('rekrutmen_admin_view', $data); 
    }



    // Anda bisa menambahkan method lain untuk halaman lain di sini
    // contoh: public function kontak() { ... }
}