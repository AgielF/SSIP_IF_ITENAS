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

class Content extends ResourceController
{
    protected $visiMisiModel;
    protected $proyekRisetModel;
    protected $publikasiModel;
    protected $galeriUmumModel;
    protected $rekrutModel;
    protected $beritaModel;
    protected $eventsModel;

    public function __construct()
    {
        $this->visiMisiModel = new VisiMisiModel();
        $this->proyekRisetModel = new ProyekRisetModel();
        $this->publikasiModel = new PublikasiModel();
        $this->galeriUmumModel = new GaleriUmumModel();
        $this->rekrutModel = new RekrutModel();
        $this->beritaModel = new BeritaModel();
        $this->eventsModel = new EventsModel();
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
}