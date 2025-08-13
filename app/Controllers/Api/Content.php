<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\VisiMisiModel;
use App\Models\ProyekRisetModel;
use App\Models\PublikasiModel;
use App\Models\GaleriUmumModel;
use App\Models\RekrutModel;
use App\Models\BeritaModel;
use App\Models\EventsModel;
use App\Models\JadwalModel;
use App\Models\AsistenJadwalModel;
use App\Models\UserModel;
use App\Models\PesertaPraktikumModel;
use App\Models\ModulPraktikumModel;

class Content extends ResourceController
{
    protected $visiMisiModel;
    protected $proyekRisetModel;
    protected $publikasiModel;
    protected $galeriUmumModel;
    protected $rekrutModel;
    protected $beritaModel;
    protected $eventsModel;
    protected $jadwalModel;
    protected $asistenJadwalModel;
    protected $userModel;
    protected $pesertaPraktikumModel;
    protected $modulPraktikumModel;

    public function __construct()
    {
        $this->visiMisiModel = new VisiMisiModel();
        $this->proyekRisetModel = new ProyekRisetModel();
        $this->publikasiModel = new PublikasiModel();
        $this->galeriUmumModel = new GaleriUmumModel();
        $this->rekrutModel = new RekrutModel();
        $this->beritaModel = new BeritaModel();
        $this->eventsModel = new EventsModel();
        $this->jadwalModel = new JadwalModel();
        $this->asistenJadwalModel = new AsistenJadwalModel();
        $this->userModel = new UserModel();
        $this->pesertaPraktikumModel = new PesertaPraktikumModel();
        $this->modulPraktikumModel = new ModulPraktikumModel();
    }

    public function visiMisi()
    {
        $visi = $this->visiMisiModel->where('judul', 'Visi')->first();
        $misi = $this->visiMisiModel->where('judul', 'Misi')->first();
        
        return $this->respond([
            'visi' => $visi ? $visi['isi'] : '',
            'misi' => $misi ? $misi['isi'] : ''
        ]);
    }

    public function proyekRiset()
    {
        $proyek = $this->proyekRisetModel->select('proyek_riset.*, users.nama as penanggung_jawab')
                    ->join('users', 'users.id = proyek_riset.id_user')
                    ->findAll();
        return $this->respond($proyek);
    }

    public function publikasi()
    {
        $publikasi = $this->publikasiModel->select('publikasi.*, users.nama as penulis')
                    ->join('users', 'users.id = publikasi.id_user')
                    ->findAll();
        return $this->respond($publikasi);
    }

    public function galeri()
    {
        $galeri = $this->galeriUmumModel->select('galeri_umum.*, users.nama as uploader')
                    ->join('users', 'users.id = galeri_umum.id_user')
                    ->findAll();
        return $this->respond($galeri);
    }

    public function rekrutmen()
    {
        $rekrutmen = $this->rekrutModel->select('rekrut.*, users.nama as pembuat, jadwal.tanggal')
                    ->join('users', 'users.id = rekrut.id_user')
                    ->join('jadwal', 'jadwal.id_jadwal = rekrut.id_jadwal')
                    ->findAll();
        return $this->respond($rekrutmen);
    }

    public function berita()
    {
        $berita = $this->beritaModel->select('berita.*, users.nama as penulis')
                    ->join('users', 'users.id = berita.id_user')
                    ->findAll();
        return $this->respond($berita);
    }

    public function events()
    {
        $events = $this->eventsModel->select('events.*, users.nama as creator')
                    ->join('users', 'users.id = events.created_by')
                    ->findAll();
        return $this->respond($events);
    }

    public function agenda()
    {
        // Get data jadwal
        $databaseData = $this->jadwalModel->getJadwalWithDetails();
        
        // array untuk menyimpan jadwal yang telah diproses
        $processedSchedules = [];
        $today = new \DateTime('today');
        
        foreach ($databaseData as $item) {
            $scheduleDate = new \DateTime($item['tanggal']);
            
            // Status berdasarkan tanggal
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
            
            // Get nama staff pengajar
            $asisten = $this->asistenJadwalModel->getAsistenByJadwal($item['id_jadwal']);
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
        
        return $this->respond($processedSchedules);
    }

    public function asisten()
    {
        // Get data asisten, dosen, and praktikan
        $asisten = $this->userModel->getAsistenLab();
        $dosen = $this->userModel->getDosenLab();
        $praktikan = $this->userModel->praktikan();
        
        // Array untuk all users
        $allPersonnel = [];
        
        // Mengambil role untuk setiap jenis pengguna dan merge semuanya
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
        
        return $this->respond($allPersonnel);
    }

    public function asistenAdmin()
    {
        // metode ini sama seperti asisten() dan ada informas khusus untuk admin
        return $this->asisten();
    }

    public function jadwal()
    {
        return $this->agenda();
    }

    public function jadwalCard()
    {
        return $this->agenda();
    }

    public function penelitianProyek()
    {
        $proyek = $this->proyekRisetModel->select('proyek_riset.*, users.nama as penanggung_jawab')
                    ->join('users', 'users.id = proyek_riset.id_user')
                    ->findAll();
        return $this->respond($proyek);
    }

public function repositoriPage()
    {
        $modul = $this->modulPraktikumModel->findAll();
        return $this->respond($modul);
    }

    public function rekrutmenPage()
    {
        $rekrutmen = $this->rekrutModel->select('rekrut.*, users.nama as pembuat, jadwal.tanggal')
                    ->join('users', 'users.id = rekrut.id_user')
                    ->join('jadwal', 'jadwal.id_jadwal = rekrut.id_jadwal')
                    ->findAll();
        return $this->respond($rekrutmen);
    }

    public function publikasiPage()
    {
        $publikasi = $this->publikasiModel->select('publikasi.*, users.nama as penulis')
                    ->join('users', 'users.id = publikasi.id_user')
                    ->findAll();
        return $this->respond($publikasi);
    }
    public function pesertaPraktikum()
    {
        $peserta = $this->pesertaPraktikumModel->select('peserta_praktikum.*, users.nama as nama_peserta, jadwal.tanggal')
                    ->join('users', 'users.id = peserta_praktikum.id_user')
                    ->join('jadwal', 'jadwal.id_jadwal = peserta_praktikum.id_jadwal')
                    ->findAll();
        return $this->respond($peserta);
    }

    public function visiMisiPage()
    {
        $visiRow = $this->visiMisiModel->where('judul', 'Visi')->first();
        $misiRow = $this->visiMisiModel->where('judul', 'Misi')->first();
        
        return $this->respond([
            'visi' => $visiRow ? $visiRow['isi'] : '',
            'misi' => $misiRow ? $misiRow['isi'] : ''
        ]);
    }

    public function repositori()
    {
        $modul = $this->modulPraktikumModel->findAll();
        return $this->respond($modul);
    }

    public function penelitianProyekPage()
    {
        $proyek = $this->proyekRisetModel->select('proyek_riset.*, users.nama as penanggung_jawab')
                    ->join('users', 'users.id = proyek_riset.id_user')
                    ->findAll();
        return $this->respond($proyek);
    }
}