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

    /**
     * Mengambil dan memproses data anggota lab (personnel).
     */
    private function getProcessedPersonnelData(): array
    {
        $userModel = new UserModel();
        $asisten = $userModel->getAsistenLab();
        $dosen = $userModel->getDosenLab();
        $praktikan = $userModel->praktikan();
        
        $allPersonnel = [];
        foreach ($dosen as $d) { $d['role'] = 'dosen'; $allPersonnel[] = $d; }
        foreach ($asisten as $a) { $a['role'] = 'asisten'; $allPersonnel[] = $a; }
        foreach ($praktikan as $p) { $p['role'] = 'praktikan'; $allPersonnel[] = $p; }
        
        return $allPersonnel;
    }

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
        ];
        return view('home_view', $data);
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

    // --- Anggota Lab ---
    public function asisten()
    {
        $data = ['title' => 'Anggota Laboratorium', 'asisten' => $this->getProcessedPersonnelData()];
        return view('asisten_list_view', $data);
    }

    public function asisten_admin()
    {
        $data = ['title' => 'Admin: Kelola Anggota', 'asisten' => $this->getProcessedPersonnelData()];
        return view('asisten_admin_list_view', $data);
    }

    // --- Penelitian & Proyek ---
    public function penelitian_proyek()
    {
        $proyekModel = new ProyekRisetModel();
        $data = ['title' => 'Penelitian & Proyek', 'projects' => $proyekModel->findAll()];
        return view('penelitian_proyek_list_view', $data); 
    }
    
    public function penelitian_proyek_admin()
    {
        $proyekModel = new ProyekRisetModel();
        $data = ['title' => 'Admin: Kelola Proyek', 'projects' => $proyekModel->findAll()];
        return view('penelitian_proyek_admin_list_view', $data); 
    }

    // --- Publikasi Ilmiah ---
    public function publikasi_ilmiah()
    {
        $publikasiModel = new PublikasiModel();
        $data = ['title' => 'Publikasi Ilmiah', 'publications' => $publikasiModel->findAll()];
        return view('publikasi_ilmiah_list_view', $data); 
    }

    public function publikasi_ilmiah_admin()
    {
        $publikasiModel = new PublikasiModel();
        $data = ['title' => 'Admin: Kelola Publikasi', 'publications' => $publikasiModel->findAll()];
        return view('publikasi_ilmiah_admin_list_view', $data); 
    }
    
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
}
