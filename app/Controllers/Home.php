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
        $data = [
            'title'     => 'Agenda & Acara | Lab. Fisika Dasar',
            'schedules' => $this->getProcessedJadwalData()
        ];
        return view('acara_list_view', $data);
    }

    /**
     * Method untuk menampilkan halaman Agenda & Acara dengan filter dan pagination.
     * URL: /agenda?page=1&limit=5&search=...
     */
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
        
        // 1. Ambil data gabungan dari database
        $databaseData = $jadwalModel->getJadwalWithDetails();

        // 2. Siapkan array kosong untuk menampung data yang sudah diproses
        $processedSchedules = [];
        $today = new \DateTime('today');

        // 3. Looping dan format data
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

        // 4. Kirim data yang sudah diproses ke view
        $data = [
            'title'     => 'Daftar Jadwal Lab',
            'schedules' => $processedSchedules // Gunakan key 'schedules' sesuai kebutuhan view
        ];
        // Memuat view acara_list_view
        return view('acara_list_view', $data);
    }

    /**
     * Mengambil dan memproses data anggota lab (personnel).
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
     * Method untuk menampilkan halaman Asisten Lab dengan filter dan pagination.
     * URL: /asisten?page=1&limit=5&search=...
     */
    public function asisten_paginated()
    {
        // Get query parameters for filtering and pagination
        $page = (int)($this->request->getVar('page') ?? 1);
        $limit = (int)($this->request->getVar('limit') ?? 15);
        $search = $this->request->getVar('search');
        $role = $this->request->getVar('role');

        // Initialize model
        $userModel = new UserModel();

        // Build query with filters
        $builder = $userModel->select('users.*, roles.role_name as role_name')
                    ->join('roles', 'roles.id = users.role_id');

        // Apply filters if provided
        if ($search) {
            $builder->groupStart()
                ->like('users.nama', $search)
                ->orLike('users.nomor', $search)
                ->groupEnd();
        }

        if ($role) {
            $builder->where('users.role_id', $role);
        }

        // Get total count before pagination
        $total = $builder->countAllResults(false); // false to keep the query builder

        // Apply pagination
        $offset = ($page - 1) * $limit;
        $users = $builder->limit($limit, $offset)->findAll();

        // Process personnel data
        $allPersonnel = [];
        
        foreach ($users as $user) {
            // Determine role based on role_id
            switch ($user['role_id']) {
                case 1:
                    $user['role'] = 'admin';
                    break;
                case 2:
                    $user['role'] = 'dosen';
                    break;
                case 3:
                    $user['role'] = 'asisten';
                    break;
                case 4:
                    $user['role'] = 'praktikan';
                    break;
                default:
                    $user['role'] = 'user';
            }
            $allPersonnel[] = $user;
        }

        // Prepare response with pagination info
        $pagination = [
            'page' => (int)$page,
            'limit' => (int)$limit,
            'total' => (int)$total,
            'pages' => ceil($total / $limit)
        ];

        $data = [
            'title' => 'Anggota Laboratorium',
            'asisten' => $allPersonnel,
            'pagination' => $pagination,
            'search' => $search,
            'role' => $role
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
     * Menampilkan halaman jadwal dengan filter dan pagination.
     */
    public function jadwal_paginated()
    {
        return $this->agenda_paginated(); // Reuse the same logic
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
     * Menampilkan halaman daftar jadwal dalam format list dengan filter dan pagination.
     */
    public function jadwal_card_paginated()
    {
        return $this->agenda_paginated(); // Reuse the same logic
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
     * Menampilkan halaman galeri dengan filter dan pagination.
     */
    public function galeri_paginated()
    {
        // Get query parameters for filtering and pagination
        $page = (int)($this->request->getVar('page') ?? 1);
        $limit = (int)($this->request->getVar('limit') ?? 15);
        $search = $this->request->getVar('search');
        $kategori = $this->request->getVar('kategori');
        $dateFrom = $this->request->getVar('date_from');
        $dateTo = $this->request->getVar('date_to');

        // Initialize model
        $galeriModel = new GaleriUmumModel();

        // Build query with filters
        $builder = $galeriModel->select('galeri_umum.*, users.nama as uploader')
                    ->join('users', 'users.id = galeri_umum.id_user');

        // Apply filters if provided
        if ($search) {
            $builder->groupStart()
                ->like('galeri_umum.keterangan', $search)
                ->orLike('galeri_umum.kategori', $search)
                ->groupEnd();
        }

        if ($kategori) {
            $builder->where('galeri_umum.kategori', $kategori);
        }

        if ($dateFrom) {
            $builder->where('galeri_umum.tanggal_upload >=', $dateFrom);
        }

        if ($dateTo) {
            $builder->where('galeri_umum.tanggal_upload <=', $dateTo);
        }

        // Get total count before pagination
        $total = $builder->countAllResults(false); // false to keep the query builder

        // Apply pagination
        $offset = ($page - 1) * $limit;
        $galeri = $builder->limit($limit, $offset)->findAll();

        // Prepare response with pagination info
        $pagination = [
            'page' => (int)$page,
            'limit' => (int)$limit,
            'total' => (int)$total,
            'pages' => ceil($total / $limit)
        ];

        $data = [
            'title' => 'Galeri Laboratorium | Lab. Fisika Dasar',
            'galeri' => $galeri,
            'pagination' => $pagination,
            'search' => $search,
            'kategori' => $kategori,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo
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
     * Menampilkan halaman penelitian dan proyek dengan filter dan pagination.
     */
    public function penelitian_proyek_paginated()
    {
        // Get query parameters for filtering and pagination
        $page = (int)($this->request->getVar('page') ?? 1);
        $limit = (int)($this->request->getVar('limit') ?? 15);
        $search = $this->request->getVar('search');
        $mitra = $this->request->getVar('mitra');
        $tahun = $this->request->getVar('tahun');

        // Initialize model
        $proyekModel = new ProyekRisetModel();

        // Build query with filters
        $builder = $proyekModel->select('proyek_riset.*, users.nama as penanggung_jawab')
                    ->join('users', 'users.id = proyek_riset.id_user');

        // Apply filters if provided
        if ($search) {
            $builder->groupStart()
                ->like('proyek_riset.judul', $search)
                ->orLike('proyek_riset.deskripsi', $search)
                ->groupEnd();
        }

        if ($mitra) {
            $builder->where('proyek_riset.mitra', $mitra);
        }

        if ($tahun) {
            $builder->where('proyek_riset.tahun_mulai <=', $tahun)
                ->where('proyek_riset.tahun_selesai >=', $tahun);
        }

        // Get total count before pagination
        $total = $builder->countAllResults(false); // false to keep the query builder

        // Apply pagination
        $offset = ($page - 1) * $limit;
        $proyek = $builder->limit($limit, $offset)->findAll();

        // Prepare response with pagination info
        $pagination = [
            'page' => (int)$page,
            'limit' => (int)$limit,
            'total' => (int)$total,
            'pages' => ceil($total / $limit)
        ];

        $data = [
            'title' => 'Penelitian & Proyek | Lab. Fisika Dasar',
            'proyek' => $proyek,
            'pagination' => $pagination,
            'search' => $search,
            'mitra' => $mitra,
            'tahun' => $tahun
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
        
        // Transform data into the format expected by the view
        $transformedData = $this->transformPublikasiData($publikasi);
        
        $data = [
            'title' => 'Publikasi Ilmiah | Lab. Fisika Dasar',
            'publikasi' => $publikasi,
            'publicationData' => $transformedData
        ];
        return view('publikasi_ilmiah_list_view', $data);
    }
    
    /**
     * Menampilkan halaman publikasi ilmiah dengan filter dan pagination.
     */
    public function publikasi_ilmiah_paginated()
    {
        // Get query parameters for filtering and pagination
        $page = (int)($this->request->getVar('page') ?? 1);
        $limit = (int)($this->request->getVar('limit') ?? 15);
        // Ensure limit is at least 1 to prevent DivisionByZeroError
        $limit = max(1, $limit);
        $search = $this->request->getVar('search');
        $kategori = $this->request->getVar('kategori');
        $jenis = $this->request->getVar('jenis');
        $dateFrom = $this->request->getVar('date_from');
        $dateTo = $this->request->getVar('date_to');

        // Initialize model
        $publikasiModel = new PublikasiModel();

        // Build query with filters
        $builder = $publikasiModel->select('publikasi.*, users.nama as penulis')
                    ->join('users', 'users.id = publikasi.id_user');

        // Apply filters if provided
        if ($search) {
            $builder->groupStart()
                ->like('publikasi.jenis_publikasi', $search)
                ->orLike('publikasi.kategori', $search)
                ->groupEnd();
        }

        if ($kategori) {
            $builder->where('publikasi.kategori', $kategori);
        }

        if ($jenis) {
            $builder->where('publikasi.jenis_publikasi', $jenis);
        }

        if ($dateFrom) {
            $builder->where('publikasi.tanggal_publikasi >=', $dateFrom);
        }

        if ($dateTo) {
            $builder->where('publikasi.tanggal_publikasi <=', $dateTo);
        }

        // Get total count before pagination
        $total = $builder->countAllResults(false); // false to keep the query builder

        // Apply pagination
        $offset = ($page - 1) * $limit;
        $publikasi = $builder->limit($limit, $offset)->findAll();
        
        // Transform data into the format expected by the view
        $transformedData = $this->transformPublikasiData($publikasi);

        // Prepare response with pagination info
        $pagination = [
            'page' => (int)$page,
            'limit' => (int)$limit,
            'total' => (int)$total,
            'pages' => ceil($total / $limit)
        ];

        $data = [
            'title' => 'Publikasi Ilmiah | Lab. Fisika Dasar',
            'publikasi' => $publikasi,
            'publicationData' => $transformedData,
            'pagination' => $pagination,
            'search' => $search,
            'kategori' => $kategori,
            'jenis' => $jenis,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo
        ];
        
        // Debug information - you can remove this after testing
        echo "<pre>";
        echo "Total items in database: " . $total . "\n";
        echo "Current page: " . $page . "\n";
        echo "Items per page (limit): " . $limit . "\n";
        echo "Offset: " . $offset . "\n";
        echo "Number of items retrieved: " . count($publikasi) . "\n";
        echo "Transformed data count:\n";
        echo "  Jurnal: " . count($transformedData['jurnal']['rows']) . "\n";
        echo "  Prosiding: " . count($transformedData['prosiding']['rows']) . "\n";
        echo "  Paten: " . count($transformedData['paten']['rows']) . "\n";
        echo "</pre>";
        
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
     * Menampilkan halaman repositori dengan filter dan pagination.
     */
    public function repositori_paginated()
    {
        // Get query parameters for filtering and pagination
        $page = (int)($this->request->getVar('page') ?? 1);
        $limit = (int)($this->request->getVar('limit') ?? 15);
        $search = $this->request->getVar('search');

        // Initialize model
        $modulModel = new ModulPraktikumModel();

        // Build query with filters
        $builder = $modulModel->select('modul_praktikum.*, jadwal.tanggal as jadwal_tanggal')
                    ->join('jadwal', 'jadwal.id_jadwal = modul_praktikum.id_jadwal');

        // Apply filters if provided
        if ($search) {
            $builder->groupStart()
                ->like('modul_praktikum.judul', $search)
                ->orLike('modul_praktikum.deskripsi', $search)
                ->groupEnd();
        }

        // Get total count before pagination
        $total = $builder->countAllResults(false); // false to keep the query builder

        // Apply pagination
        $offset = ($page - 1) * $limit;
        $modul = $builder->limit($limit, $offset)->findAll();

        // Prepare response with pagination info
        $pagination = [
            'page' => (int)$page,
            'limit' => (int)$limit,
            'total' => (int)$total,
            'pages' => ceil($total / $limit)
        ];

        $data = [
            'title' => 'Repositori Modul Praktikum | Lab. Fisika Dasar',
            'modul' => $modul,
            'pagination' => $pagination,
            'search' => $search
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
     * Menampilkan halaman rekrutmen dengan filter dan pagination.
     */
    public function rekrutmen_paginated()
    {
        // Get query parameters for filtering and pagination
        $page = (int)($this->request->getVar('page') ?? 1);
        $limit = (int)($this->request->getVar('limit') ?? 10);
        $search = $this->request->getVar('search');
        $status = $this->request->getVar('status');

        // Initialize model
        $rekrutModel = new RekrutModel();

        // Build query with filters
        $builder = $rekrutModel->select('rekrut.*, users.nama as pembuat, jadwal.tanggal')
                    ->join('users', 'users.id = rekrut.id_user')
                    ->join('jadwal', 'jadwal.id_jadwal = rekrut.id_jadwal');

        // Apply filters if provided
        if ($search) {
            $builder->groupStart()
                ->like('rekrut.deskripsi', $search)
                ->orLike('rekrut.syarat', $search)
                ->groupEnd();
        }

        if ($status) {
            $builder->where('rekrut.status', $status);
        }

        // Get total count before pagination
        $total = $builder->countAllResults(false); // false to keep the query builder

        // Apply pagination
        $offset = ($page - 1) * $limit;
        $rekrutmen = $builder->limit($limit, $offset)->findAll();

        // Prepare response with pagination info
        $pagination = [
            'page' => (int)$page,
            'limit' => (int)$limit,
            'total' => (int)$total,
            'pages' => ceil($total / $limit)
        ];

        $data = [
            'title' => 'Rekrutmen Asisten | Lab. Fisika Dasar',
            'rekrutmen' => $rekrutmen,
            'pagination' => $pagination,
            'search' => $search,
            'status' => $status
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
        $asisten = $userModel->getAsistenLab();
        $dosen = $userModel->getDosenLab();
        $praktikan = $userModel->praktikan();
        
        $allPersonnel = [];
        foreach ($dosen as $d) { $d['role'] = 'dosen'; $allPersonnel[] = $d; }
        foreach ($asisten as $a) { $a['role'] = 'asisten'; $allPersonnel[] = $a; }
        foreach ($praktikan as $p) { $p['role'] = 'praktikan'; $allPersonnel[] = $p; }
        
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
