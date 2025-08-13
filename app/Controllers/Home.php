<?php

namespace App\Controllers;

use App\Models\JadwalModel;
use App\Models\AsistenJadwalModel;
use App\Models\UserModel;
use App\Models\BeritaModel;
use App\Models\GaleriUmumModel;
use App\Models\ProyekRisetModel;
use App\Models\PublikasiModel;
use App\Models\RekrutModel;
use App\Models\ModulPraktikumModel;
use App\Models\VisiMisiModel;

class Home extends BaseController
{
    /**
     * Method untuk menampilkan halaman utama (Beranda).
     * URL: /
     */
    public function index()
    {
        // Get processed schedules
        $processedSchedules = $this->getProcessedJadwalData();
        
        // Get visi & misi data
        $visiMisiModel = new VisiMisiModel();
        $visiRow = $visiMisiModel->where('judul', 'Visi')->first();
        $misiRow = $visiMisiModel->where('judul', 'Misi')->first();
        
        $data = [
            'title'     => 'Beranda | Lab. Fisika Dasar',
            'schedules' => array_slice($processedSchedules, 0, 5), // Show only first 5 schedules on homepage
            'visi' => $visiRow ? $visiRow['isi'] : '',
            'misi' => $misiRow ? $misiRow['isi'] : ''
        ];

        return view('home_view', $data);
    }

    /**
     * Method untuk menampilkan halaman Agenda & Acara.
     * URL: /agenda
     */
    public function agenda()
    {
        $data = [
            'title'     => 'Agenda & Acara | Lab. Fisika Dasar',
            'schedules' => $this->getProcessedJadwalData()
        ];
        return view('acara_list_view', $data);
    }

    /**
     * Method untuk menampilkan halaman Asisten Lab.
     * URL: /asisten
     */
    public function asisten()
    {
        $data = [
            'title'   => 'Anggota Laboratorium',
            'asisten' => $this->getProcessedPersonnelData()
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
            'asisten' => $this->getProcessedPersonnelData()
        ];
        return view('asisten_list_admin_view', $data);
    }

    /**
     * Menampilkan halaman jadwal.
     */
    public function jadwal()
    {
        $data = [
            'title'     => 'Daftar Jadwal Lab',
            'schedules' => $this->getProcessedJadwalData()
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
            'schedules' => $this->getProcessedJadwalData()
        ];
        return view('jadwal_card_admin_view', $data); 
    }

    /**
     * Menampilkan halaman daftar jadwal dalam format list.
     */
    public function jadwal_card()
    {
        $data = [
            'title' => 'Jadwal Laboratorium | Lab. Fisika Dasar',
            'schedules' => $this->getProcessedJadwalData()
        ];
        return view('jadwal_view', $data); 
    }

    /**
     * Menampilkan halaman galeri.
     */
    public function galeri()
    {
        $galeriModel = new GaleriUmumModel();
        $galeri = $galeriModel->select('galeri_umum.*, users.nama as uploader')
                    ->join('users', 'users.id = galeri_umum.id_user')
                    ->findAll();
        
        $data = [
            'title' => 'Galeri Laboratorium | Lab. Fisika Dasar',
            'galeri' => $galeri
        ];
        return view('galeri_list_view', $data); 
    }

    /**
     * Menampilkan halaman galeri untuk admin.
     */
    public function galeri_admin()
    {
        $galeriModel = new GaleriUmumModel();
        $galeri = $galeriModel->select('galeri_umum.*, users.nama as uploader')
                    ->join('users', 'users.id = galeri_umum.id_user')
                    ->findAll();
        
        $data = [
            'title' => 'Admin: Galeri Laboratorium',
            'galeri' => $galeri
        ];
        return view('galeri_list_admin_view', $data); 
    }
    
    /**
     * Menampilkan halaman penelitian dan proyek.
     */
    public function penelitian_proyek()
    {
        $proyekModel = new ProyekRisetModel();
        $proyek = $proyekModel->select('proyek_riset.*, users.nama as penanggung_jawab')
                    ->join('users', 'users.id = proyek_riset.id_user')
                    ->findAll();
        
        $data = [
            'title' => 'Penelitian & Proyek | Lab. Fisika Dasar',
            'proyek' => $proyek
        ];
        return view('penelitian_proyek_list', $data); 
    }
    
    /**
     * Menampilkan halaman penelitian dan proyek untuk admin.
     */
    public function penelitian_proyek_admin()
    {
        $proyekModel = new ProyekRisetModel();
        $proyek = $proyekModel->select('proyek_riset.*, users.nama as penanggung_jawab')
                    ->join('users', 'users.id = proyek_riset.id_user')
                    ->findAll();
        
        $data = [
            'title' => 'Admin: Penelitian & Proyek',
            'proyek' => $proyek
        ];
        return view('penelitian_proyek_list_admin_view', $data); 
    }
    
    /**
     * Menampilkan halaman publikasi ilmiah.
     */
    public function publikasi_ilmiah()
    {
        $publikasiModel = new PublikasiModel();
        $publikasi = $publikasiModel->select('publikasi.*, users.nama as penulis')
                    ->join('users', 'users.id = publikasi.id_user')
                    ->findAll();
        
        $data = [
            'title' => 'Publikasi Ilmiah | Lab. Fisika Dasar',
            'publikasi' => $publikasi
        ];
        return view('publikasi_ilmiah_list_view', $data); 
    }
    
    /**
     * Menampilkan halaman publikasi ilmiah untuk admin.
     */
    public function publikasi_ilmiah_admin()
    {
        $publikasiModel = new PublikasiModel();
        $publikasi = $publikasiModel->select('publikasi.*, users.nama as penulis')
                    ->join('users', 'users.id = publikasi.id_user')
                    ->findAll();
        
        $data = [
            'title' => 'Admin: Publikasi Ilmiah',
            'publikasi' => $publikasi
        ];
        return view('publikasi_ilmiah_list_admin_view', $data); 
    }

    /**
     * Menampilkan halaman repositori.
     */
    public function repositori()
    {
        $modulModel = new ModulPraktikumModel();
        $modul = $modulModel->findAll();
        
        $data = [
            'title' => 'Repositori Modul Praktikum | Lab. Fisika Dasar',
            'modul' => $modul
        ];
        return view('repositori_list_view', $data); 
    }
    
    /**
     * Menampilkan halaman repositori untuk admin.
     */
    public function repositori_admin()
    {
        $modulModel = new ModulPraktikumModel();
        $modul = $modulModel->findAll();
        
        $data = [
            'title' => 'Admin: Repositori Modul Praktikum',
            'modul' => $modul
        ];
        return view('repositori_list_admin_view', $data); 
    }
    
    /**
     * Menampilkan halaman rekrutmen.
     */
    public function rekrutmen()
    {
        $rekrutModel = new RekrutModel();
        $rekrutmen = $rekrutModel->select('rekrut.*, users.nama as pembuat, jadwal.tanggal')
                    ->join('users', 'users.id = rekrut.id_user')
                    ->join('jadwal', 'jadwal.id_jadwal = rekrut.id_jadwal')
                    ->findAll();
        
        $data = [
            'title' => 'Rekrutmen Asisten | Lab. Fisika Dasar',
            'rekrutmen' => $rekrutmen
        ];
        return view('rekrutmen_view', $data); 
    }
    
    /**
     * Menampilkan halaman rekrutmen untuk admin.
     */
    public function rekrutmen_admin()
    {
        $rekrutModel = new RekrutModel();
        $rekrutmen = $rekrutModel->select('rekrut.*, users.nama as pembuat, jadwal.tanggal')
                    ->join('users', 'users.id = rekrut.id_user')
                    ->join('jadwal', 'jadwal.id_jadwal = rekrut.id_jadwal')
                    ->findAll();
        
        $data = [
            'title' => 'Admin: Rekrutmen Asisten',
            'rekrutmen' => $rekrutmen
        ];
        return view('rekrutmen_admin_view', $data); 
    }
    
    /**
     * Menampilkan halaman visi & misi.
     */
    public function visi_misi()
    {
        $visiMisiModel = new VisiMisiModel();
        $visiRow = $visiMisiModel->where('judul', 'Visi')->first();
        $misiRow = $visiMisiModel->where('judul', 'Misi')->first();
        
        $data = [
            'title' => 'Visi & Misi | Lab. Fisika Dasar',
            'visi' => $visiRow ? $visiRow['isi'] : '',
            'misi' => $misiRow ? $misiRow['isi'] : ''
        ];
        return view('visi_misi_page', $data); 
    }

    // === HELPER METHODS ===

    /**
     * Helper method to process personnel data for both user and admin views
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
     * Helper method to process schedule data for both user and admin views
     */
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
}