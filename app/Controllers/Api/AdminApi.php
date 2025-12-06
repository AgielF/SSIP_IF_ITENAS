<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\RekrutModel;
use App\Models\ProyekRisetModel;
use App\Models\PublikasiModel;
use App\Models\GaleriUmumModel;
use App\Models\VisiMisiModel;
use App\Models\JadwalModel;
use App\Models\AsistenJadwalModel;
use App\Models\PesertaPraktikumModel;
use App\Models\UserModel;
use App\Models\BeritaModel;
use App\Models\PraktikumModel;
use App\Models\ModulPraktikumModel;
use App\Models\EventsModel;

class AdminApi extends ResourceController
{
    use ResponseTrait;
    protected $rekrutModel;
    protected $proyekRisetModel;
    protected $publikasiModel;
    protected $galeriUmumModel;
    protected $visiMisiModel;
    protected $jadwalModel;
    protected $asistenJadwalModel;
    protected $pesertaPraktikumModel;
    protected $userModel;
    protected $beritaModel;
    protected $praktikumModel;
    protected $modulPraktikumModel;
    protected $eventsModel;

    public function __construct()
    {
        // Initialize all models
        $this->rekrutModel = new RekrutModel();
        $this->proyekRisetModel = new ProyekRisetModel();
        $this->publikasiModel = new PublikasiModel();
        $this->galeriUmumModel = new GaleriUmumModel();
        $this->visiMisiModel = new VisiMisiModel();
        $this->jadwalModel = new JadwalModel();
        $this->asistenJadwalModel = new AsistenJadwalModel();
        $this->pesertaPraktikumModel = new PesertaPraktikumModel();
        $this->userModel = new UserModel();
        $this->beritaModel = new BeritaModel();
        $this->praktikumModel = new PraktikumModel();
        $this->modulPraktikumModel = new ModulPraktikumModel();
        $this->eventsModel = new EventsModel();
    }

    // untuk autentikasi csrf
    private function checkAuth()
    {
        
        return true;
    }

    // Rekrutmen API methods
    public function getRekrutmen()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        $rekrutmen = $this->rekrutModel->select('rekrut.*, users.nama as pembuat, jadwal.tanggal')
            ->join('users', 'users.id = rekrut.id_user')
            ->join('jadwal', 'jadwal.id_jadwal = rekrut.id_jadwal')
            ->findAll();

        return $this->respond($rekrutmen);
    }

    public function createRekrutmen()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        $data = [
            'id_user' => 1, // Default to admin user ID
            'id_jadwal' => $this->request->getPost('id_jadwal'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'status' => $this->request->getPost('status'),
            'syarat' => $this->request->getPost('syarat'),
            'link_gform' => $this->request->getPost('link_gform'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->rekrutModel->save($data)) {
            $data['id_rekrut'] = $this->rekrutModel->getInsertID();
            return $this->respondCreated($data);
        } else {
            return $this->fail('Failed to create rekrutmen');
        }
    }

    public function updateRekrutmen($id = null)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        $data = [
            'id_user' => 1, // Default to admin user ID
            'id_jadwal' => $this->request->getPost('id_jadwal'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'status' => $this->request->getPost('status'),
            'syarat' => $this->request->getPost('syarat'),
            'link_gform' => $this->request->getPost('link_gform'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->rekrutModel->update($id, $data)) {
            $data['id_rekrut'] = $id;
            return $this->respond($data);
        } else {
            return $this->fail('Failed to update rekrutmen');
        }
    }

    public function deleteRekrutmen($id = null)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        if ($this->rekrutModel->delete($id)) {
            return $this->respondDeleted(['id' => $id]);
        } else {
            return $this->fail('Failed to delete rekrutmen');
        }
    }

    // Proyek Riset API methods
    public function getProyekRiset()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        // Get query parameters for filtering and pagination
        $page = (int)($this->request->getVar('page') ?? 1);
        $limit = (int)($this->request->getVar('limit') ?? 10);
        $search = $this->request->getVar('search');
        $mitra = $this->request->getVar('mitra');
        $tahun = $this->request->getVar('tahun');

        // Build query with filters
        $builder = $this->proyekRisetModel->select('proyek_riset.*, users.nama as penanggung_jawab')
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
        $response = [
            'data' => $proyek,
            'pagination' => [
                'page' => (int)$page,
                'limit' => (int)$limit,
                'total' => (int)$total,
                'pages' => ceil($total / $limit)
            ]
        ];

        return $this->respond($response);
    }

    public function createProyekRiset()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        $data = [
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'mitra' => $this->request->getPost('mitra'),
            'sumber_dana' => $this->request->getPost('sumber_dana'),
            'tahun_mulai' => $this->request->getPost('tahun_mulai'),
            'tahun_selesai' => $this->request->getPost('tahun_selesai'),
            'id_user' => 1, // Default to admin user ID
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->proyekRisetModel->save($data)) {
            $data['id_proyek'] = $this->proyekRisetModel->getInsertID();
            return $this->respondCreated($data);
        } else {
            return $this->fail('Failed to create proyek riset');
        }
    }

    public function updateProyekRiset($id = null)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        $data = [
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'mitra' => $this->request->getPost('mitra'),
            'sumber_dana' => $this->request->getPost('sumber_dana'),
            'tahun_mulai' => $this->request->getPost('tahun_mulai'),
            'tahun_selesai' => $this->request->getPost('tahun_selesai'),
            'id_user' => 1, // Default to admin user ID
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->proyekRisetModel->update($id, $data)) {
            $data['id_proyek'] = $id;
            return $this->respond($data);
        } else {
            return $this->fail('Failed to update proyek riset');
        }
    }

    public function deleteProyekRiset($id = null)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        if ($this->proyekRisetModel->delete($id)) {
            return $this->respondDeleted(['id' => $id]);
        } else {
            return $this->fail('Failed to delete proyek riset');
        }
    }

    // Publikasi API methods
    public function getPublikasi()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

       // Pagination
        $page = (int)($this->request->getVar('page') ?? 1);
        $limit = (int)($this->request->getVar('limit') ?? 10);
        $search = $this->request->getVar('search');
        $kategori = $this->request->getVar('kategori');
        $jenis = $this->request->getVar('jenis');
        $dateFrom = $this->request->getVar('date_from');
        $dateTo = $this->request->getVar('date_to');

        $builder = $this->publikasiModel->select('publikasi.*, users.nama as penulis')
            ->join('users', 'users.id = publikasi.id_user');

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

        // Prepare response with pagination info
        $response = [
            'data' => $publikasi,
            'pagination' => [
                'page' => (int)$page,
                'limit' => (int)$limit,
                'total' => (int)$total,
                'pages' => ceil($total / $limit)
            ]
        ];

        return $this->respond($response);
    }

    public function createPublikasi()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        $data = [
            'jenis_publikasi' => $this->request->getPost('jenis_publikasi'),
            'link_publikasi' => $this->request->getPost('link_publikasi'),
            'kategori' => $this->request->getPost('kategori'),
            'tanggal_publikasi' => $this->request->getPost('tanggal_publikasi'),
            'id_user' => 1, // Default to admin user ID
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->publikasiModel->save($data)) {
            $data['id_publikasi'] = $this->publikasiModel->getInsertID();
            return $this->respondCreated($data);
        } else {
            return $this->fail('Failed to create publikasi');
        }
    }

    public function updatePublikasi($id = null)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        $data = [
            'jenis_publikasi' => $this->request->getPost('jenis_publikasi'),
            'link_publikasi' => $this->request->getPost('link_publikasi'),
            'kategori' => $this->request->getPost('kategori'),
            'tanggal_publikasi' => $this->request->getPost('tanggal_publikasi'),
            'id_user' => 1, // Default to admin user ID
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->publikasiModel->update($id, $data)) {
            $data['id_publikasi'] = $id;
            return $this->respond($data);
        } else {
            return $this->fail('Failed to update publikasi');
        }
    }

    public function deletePublikasi($id = null)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        if ($this->publikasiModel->delete($id)) {
            return $this->respondDeleted(['id' => $id]);
        } else {
            return $this->fail('Failed to delete publikasi');
        }
    }

    // Galeri API methods
    public function getGaleri()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        // Get query parameters for filtering and pagination
        $page = (int)($this->request->getVar('page') ?? 1);
        $limit = (int)($this->request->getVar('limit') ?? 10);
        $search = $this->request->getVar('search');
        $kategori = $this->request->getVar('kategori');
        $dateFrom = $this->request->getVar('date_from');
        $dateTo = $this->request->getVar('date_to');

        // Build query with filters
        $builder = $this->galeriUmumModel->select('galeri_umum.*, users.nama as uploader')
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
        $response = [
            'data' => $galeri,
            'pagination' => [
                'page' => (int)$page,
                'limit' => (int)$limit,
                'total' => (int)$total,
                'pages' => ceil($total / $limit)
            ]
        ];

        return $this->respond($response);
    }

    public function createGaleri()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        $data = [
            'kategori' => $this->request->getPost('kategori'),
            'keterangan' => $this->request->getPost('keterangan'),
            'file_url' => $this->request->getPost('file_url'),
            'tanggal_upload' => $this->request->getPost('tanggal_upload'),
            'id_user' => 1, // Default to admin user ID
        ];

        if ($this->galeriUmumModel->save($data)) {
            $data['id_galeri'] = $this->galeriUmumModel->getInsertID();
            return $this->respondCreated($data);
        } else {
            return $this->fail('Failed to create galeri');
        }
    }

    public function updateGaleri($id = null)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        $data = [
            'kategori' => $this->request->getPost('kategori'),
            'keterangan' => $this->request->getPost('keterangan'),
            'file_url' => $this->request->getPost('file_url'),
            'tanggal_upload' => $this->request->getPost('tanggal_upload'),
            'id_user' => 1, // Default to admin user ID
        ];

        if ($this->galeriUmumModel->update($id, $data)) {
            $data['id_galeri'] = $id;
            return $this->respond($data);
        } else {
            return $this->fail('Failed to update galeri');
        }
    }

    public function deleteGaleri($id = null)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        if ($this->galeriUmumModel->delete($id)) {
            return $this->respondDeleted(['id' => $id]);
        } else {
            return $this->fail('Failed to delete galeri');
        }
    }

    // Visi Misi API methods
    public function getVisiMisi()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        $visiMisi = $this->visiMisiModel->findAll();

        return $this->respond($visiMisi);
    }

    public function updateVisiMisi($id = null)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        $data = [
            'judul' => $this->request->getPost('judul'),
            'isi' => $this->request->getPost('isi'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->visiMisiModel->update($id, $data)) {
            $data['id'] = $id;
            return $this->respond($data);
        } else {
            return $this->fail('Failed to update visi misi');
        }
    }

    // Jadwal API methods
    public function getJadwal()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        // Get query parameters for filtering and pagination
        $page = (int)($this->request->getVar('page') ?? 1);
        $limit = (int)($this->request->getVar('limit') ?? 10);
        $search = $this->request->getVar('search');
        $event = $this->request->getVar('event');
        $dateFrom = $this->request->getVar('date_from');
        $dateTo = $this->request->getVar('date_to');

        // Build query with filters
        $builder = $this->jadwalModel->select('jadwal.*, events.nama_event')
            ->join('events', 'events.id_event = jadwal.id_event');

        // Apply filters if provided
        if ($search) {
            $builder->groupStart()
                ->like('events.nama_event', $search)
                ->orLike('jadwal.ruangan', $search)
                ->groupEnd();
        }

        if ($event) {
            $builder->where('jadwal.id_event', $event);
        }

        if ($dateFrom) {
            $builder->where('jadwal.tanggal >=', $dateFrom);
        }

        if ($dateTo) {
            $builder->where('jadwal.tanggal <=', $dateTo);
        }

        // Get total count before pagination
        $total = $builder->countAllResults(false); // false to keep the query builder

        // Apply pagination
        $offset = ($page - 1) * $limit;
        $jadwal = $builder->limit($limit, $offset)->findAll();

        // Prepare response with pagination info
        $response = [
            'data' => $jadwal,
            'pagination' => [
                'page' => (int)$page,
                'limit' => (int)$limit,
                'total' => (int)$total,
                'pages' => ceil($total / $limit)
            ]
        ];

        return $this->respond($response);
    }

    public function createJadwal()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        $data = [
            'id_event' => $this->request->getPost('id_event'),
            'tanggal' => $this->request->getPost('tanggal'),
            'waktu_mulai' => $this->request->getPost('waktu_mulai'),
            'waktu_selesai' => $this->request->getPost('waktu_selesai'),
            'ruangan' => $this->request->getPost('ruangan'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->jadwalModel->save($data)) {
            $data['id_jadwal'] = $this->jadwalModel->getInsertID();
            return $this->respondCreated($data);
        } else {
            return $this->fail('Failed to create jadwal');
        }
    }

    public function updateJadwal($id = null)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        $data = [
            'id_event' => $this->request->getPost('id_event'),
            'tanggal' => $this->request->getPost('tanggal'),
            'waktu_mulai' => $this->request->getPost('waktu_mulai'),
            'waktu_selesai' => $this->request->getPost('waktu_selesai'),
            'ruangan' => $this->request->getPost('ruangan'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->jadwalModel->update($id, $data)) {
            $data['id_jadwal'] = $id;
            return $this->respond($data);
        } else {
            return $this->fail('Failed to update jadwal');
        }
    }

    public function deleteJadwal($id = null)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        if ($this->jadwalModel->delete($id)) {
            return $this->respondDeleted(['id' => $id]);
        } else {
            return $this->fail('Failed to delete jadwal');
        }
    }

    // Asisten Jadwal API methods
    public function getAsistenJadwal()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        // Get query parameters for filtering and pagination
        $page = (int)($this->request->getVar('page') ?? 1);
        $limit = (int)($this->request->getVar('limit') ?? 10);
        $search = $this->request->getVar('search');
        $jadwal = $this->request->getVar('jadwal');

        // Build query with filters
        $builder = $this->asistenJadwalModel->select('asisten_jadwal.*, jadwal.tanggal, users.nama as asisten_nama')
            ->join('jadwal', 'jadwal.id_jadwal = asisten_jadwal.id_jadwal')
            ->join('users', 'users.id = asisten_jadwal.id_user');

        // Apply filters if provided
        if ($search) {
            $builder->like('users.nama', $search);
        }

        if ($jadwal) {
            $builder->where('asisten_jadwal.id_jadwal', $jadwal);
        }

        // Get total count before pagination
        $total = $builder->countAllResults(false); // false to keep the query builder

        // Apply pagination
        $offset = ($page - 1) * $limit;
        $asistenJadwal = $builder->limit($limit, $offset)->findAll();

        // Prepare response with pagination info
        $response = [
            'data' => $asistenJadwal,
            'pagination' => [
                'page' => (int)$page,
                'limit' => (int)$limit,
                'total' => (int)$total,
                'pages' => ceil($total / $limit)
            ]
        ];

        return $this->respond($response);
    }

    public function createAsistenJadwal()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        $data = [
            'id_jadwal' => $this->request->getPost('id_jadwal'),
            'id_user' => $this->request->getPost('id_user'), // Get actual user ID from form
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->asistenJadwalModel->save($data)) {
            $data['id_asisten_jadwal'] = $this->asistenJadwalModel->getInsertID();
            return $this->respondCreated($data);
        } else {
            return $this->fail('Failed to create asisten jadwal');
        }
    }

    public function updateAsistenJadwal($id = null)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        $data = [
            'id_jadwal' => $this->request->getPost('id_jadwal'),
            'id_user' => $this->request->getPost('id_user'), // Get actual user ID from form
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->asistenJadwalModel->update($id, $data)) {
            $data['id_asisten_jadwal'] = $id;
            return $this->respond($data);
        } else {
            return $this->fail('Failed to update asisten jadwal');
        }
    }

    public function deleteAsistenJadwal($id = null)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        if ($this->asistenJadwalModel->delete($id)) {
            return $this->respondDeleted(['id' => $id]);
        } else {
            return $this->fail('Failed to delete asisten jadwal');
        }
    }

    // Peserta Praktikum API methods
    public function getPesertaPraktikum()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        // Get query parameters for filtering and pagination
        $page = (int)($this->request->getVar('page') ?? 1);
        $limit = (int)($this->request->getVar('limit') ?? 10);
        $search = $this->request->getVar('search');
        $jadwal = $this->request->getVar('jadwal');
        $status = $this->request->getVar('status');

        // Build query with filters
        $builder = $this->pesertaPraktikumModel->select('peserta_praktikum.*, users.nama as peserta, jadwal.tanggal as jadwal_tanggal')
            ->join('users', 'users.id = peserta_praktikum.id_user')
            ->join('jadwal', 'jadwal.id_jadwal = peserta_praktikum.id_jadwal');

        // Apply filters if provided
        if ($search) {
            $builder->like('users.nama', $search);
        }

        if ($jadwal) {
            $builder->where('peserta_praktikum.id_jadwal', $jadwal);
        }

        if ($status) {
            $builder->where('peserta_praktikum.status', $status);
        }

        // Get total count before pagination
        $total = $builder->countAllResults(false); // false to keep the query builder

        // Apply pagination
        $offset = ($page - 1) * $limit;
        $pesertaPraktikum = $builder->limit($limit, $offset)->findAll();

        // Prepare response with pagination info
        $response = [
            'data' => $pesertaPraktikum,
            'pagination' => [
                'page' => (int)$page,
                'limit' => (int)$limit,
                'total' => (int)$total,
                'pages' => ceil($total / $limit)
            ]
        ];

        return $this->respond($response);
    }

    public function createPesertaPraktikum()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        $data = [
            'id_user' => 1, // Default to admin user ID
            'id_jadwal' => $this->request->getPost('id_jadwal'),
            'status' => $this->request->getPost('status'),
            'nilai' => $this->request->getPost('nilai')
        ];

        if ($this->pesertaPraktikumModel->save($data)) {
            $data['id_peserta_praktikum'] = $this->pesertaPraktikumModel->getInsertID();
            return $this->respondCreated($data);
        } else {
            return $this->fail('Failed to create peserta praktikum');
        }
    }

    public function updatePesertaPraktikum($id = null)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        $data = [
            'id_user' => 1, // Default to admin user ID
            'id_jadwal' => $this->request->getPost('id_jadwal'),
            'status' => $this->request->getPost('status'),
            'nilai' => $this->request->getPost('nilai')
        ];

        if ($this->pesertaPraktikumModel->update($id, $data)) {
            $data['id_peserta_praktikum'] = $id;
            return $this->respond($data);
        } else {
            return $this->fail('Failed to update peserta praktikum');
        }
    }

    public function deletePesertaPraktikum($id = null)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        if ($this->pesertaPraktikumModel->delete($id)) {
            return $this->respondDeleted(['id' => $id]);
        } else {
            return $this->fail('Failed to delete peserta praktikum');
        }
    }

    // User Management API methods
    public function getUsers()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        // Get query parameters for filtering and pagination
        $page = (int)($this->request->getVar('page') ?? 1);
        $limit = (int)($this->request->getVar('limit') ?? 10);
        $search = $this->request->getVar('search');
        $role = $this->request->getVar('role');
        $jurusan = $this->request->getVar('jurusan');

        // Build query with filters
        $builder = $this->userModel->select('users.*, roles.role_name as role_name')
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

        if ($jurusan) {
            $builder->like('users.jurusan', $jurusan);
        }

        // Get total count before pagination
        $total = $builder->countAllResults(false); // false to keep the query builder

        // Apply pagination
        $offset = ($page - 1) * $limit;
        $users = $builder->limit($limit, $offset)->findAll();

        // Prepare response with pagination info
        $response = [
            'data' => $users,
            'pagination' => [
                'page' => (int)$page,
                'limit' => (int)$limit,
                'total' => (int)$total,
                'pages' => ceil($total / $limit)
            ]
        ];

        return $this->respond($response);
    }

    public function createUser()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        $data = $this->request->getPost();

        if ($this->userModel->save($data)) {
            $data['id'] = $this->userModel->getInsertID();
            return $this->respondCreated($data);
        } else {
            return $this->fail('Failed to create user');
        }
    }

    public function updateUser($id = null)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        $data = $this->request->getPost();

        if ($this->userModel->update($id, $data)) {
            $data['id'] = $id;
            return $this->respond($data);
        } else {
            return $this->fail('Failed to update user');
        }
    }

    public function deleteUser($id = null)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        if ($this->userModel->delete($id)) {
            return $this->respondDeleted(['id' => $id]);
        } else {
            return $this->fail('Failed to delete user');
        }
    }

    // Berita API methods
    public function getBerita()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        // Get query parameters for filtering and pagination
        $page = (int)($this->request->getVar('page') ?? 1);
        $limit = (int)($this->request->getVar('limit') ?? 10);
        $search = $this->request->getVar('search');
        $kategori = $this->request->getVar('kategori');
        $dateFrom = $this->request->getVar('date_from');
        $dateTo = $this->request->getVar('date_to');

        // Build query with filters
        $builder = $this->beritaModel->select('berita.*, users.nama as creator')
            ->join('users', 'users.id = berita.id_user');

        // Apply filters if provided
        if ($search) {
            $builder->groupStart()
                ->like('berita.judul', $search)
                ->orLike('berita.konten', $search)
                ->groupEnd();
        }

        if ($kategori) {
            $builder->where('berita.kategori', $kategori);
        }

        if ($dateFrom) {
            $builder->where('berita.tanggal >=', $dateFrom);
        }

        if ($dateTo) {
            $builder->where('berita.tanggal <=', $dateTo);
        }

        // Get total count before pagination
        $total = $builder->countAllResults(false); // false to keep the query builder

        // Apply pagination
        $offset = ($page - 1) * $limit;
        $berita = $builder->limit($limit, $offset)->findAll();

        // Prepare response with pagination info
        $response = [
            'data' => $berita,
            'pagination' => [
                'page' => (int)$page,
                'limit' => (int)$limit,
                'total' => (int)$total,
                'pages' => ceil($total / $limit)
            ]
        ];

        return $this->respond($response);
    }

    public function createBerita()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        $data = [
            'judul' => $this->request->getPost('judul'),
            'konten' => $this->request->getPost('konten'),
            'kategori' => $this->request->getPost('kategori'),
            'tanggal' => $this->request->getPost('tanggal'),
            'id_user' => 1, // Default to admin user ID
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->beritaModel->save($data)) {
            $data['id_berita'] = $this->beritaModel->getInsertID();
            return $this->respondCreated($data);
        } else {
            return $this->fail('Failed to create berita');
        }
    }

    public function updateBerita($id = null)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        $data = [
            'judul' => $this->request->getPost('judul'),
            'konten' => $this->request->getPost('konten'),
            'kategori' => $this->request->getPost('kategori'),
            'tanggal' => $this->request->getPost('tanggal'),
            'id_user' => 1, // Default to admin user ID
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->beritaModel->update($id, $data)) {
            $data['id_berita'] = $id;
            return $this->respond($data);
        } else {
            return $this->fail('Failed to update berita');
        }
    }

    public function deleteBerita($id = null)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        if ($this->beritaModel->delete($id)) {
            return $this->respondDeleted(['id' => $id]);
        } else {
            return $this->fail('Failed to delete berita');
        }
    }

    // Praktikum API methods
    public function getPraktikum()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        $praktikum = $this->praktikumModel->select('praktikum.*, users.nama as peserta, jadwal.tanggal as jadwal_tanggal')
            ->join('users', 'users.id = praktikum.id_user')
            ->join('jadwal', 'jadwal.id_jadwal = praktikum.id_jadwal')
            ->findAll();

        return $this->respond($praktikum);
    }

    public function createPraktikum()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        $data = [
            'id_user' => 1, // Default to admin user ID
            'id_jadwal' => $this->request->getPost('id_jadwal'),
            'galeri_prak' => $this->request->getPost('galeri_prak'),
            'desc_aturan' => $this->request->getPost('desc_aturan'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->praktikumModel->save($data)) {
            $data['id_praktikum'] = $this->praktikumModel->getInsertID();
            return $this->respondCreated($data);
        } else {
            return $this->fail('Failed to create praktikum');
        }
    }

    public function updatePraktikum($id = null)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        $data = [
            'id_user' => 1, // Default to admin user ID
            'id_jadwal' => $this->request->getPost('id_jadwal'),
            'galeri_prak' => $this->request->getPost('galeri_prak'),
            'desc_aturan' => $this->request->getPost('desc_aturan'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->praktikumModel->update($id, $data)) {
            $data['id_praktikum'] = $id;
            return $this->respond($data);
        } else {
            return $this->fail('Failed to update praktikum');
        }
    }

    public function deletePraktikum($id = null)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        if ($this->praktikumModel->delete($id)) {
            return $this->respondDeleted(['id' => $id]);
        } else {
            return $this->fail('Failed to delete praktikum');
        }
    }

    // Modul Praktikum API methods
    public function getModulPraktikum()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        $modulPraktikum = $this->modulPraktikumModel->select('modul_praktikum.*, jadwal.tanggal as jadwal_tanggal')
            ->join('jadwal', 'jadwal.id_jadwal = modul_praktikum.id_jadwal')
            ->findAll();

        return $this->respond($modulPraktikum);
    }

    public function createModulPraktikum()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        $data = [
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'file_url' => $this->request->getPost('file_url'),
            'id_jadwal' => $this->request->getPost('id_jadwal'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->modulPraktikumModel->save($data)) {
            $data['id_modul'] = $this->modulPraktikumModel->getInsertID();
            return $this->respondCreated($data);
        } else {
            return $this->fail('Failed to create modul praktikum');
        }
    }

    public function updateModulPraktikum($id = null)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        $data = [
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'file_url' => $this->request->getPost('file_url'),
            'id_jadwal' => $this->request->getPost('id_jadwal')
        ];

        if ($this->modulPraktikumModel->update($id, $data)) {
            $data['id_modul'] = $id;
            return $this->respond($data);
        } else {
            return $this->fail('Failed to update modul praktikum');
        }
    }

    public function deleteModulPraktikum($id = null)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        if ($this->modulPraktikumModel->delete($id)) {
            return $this->respondDeleted(['id' => $id]);
        } else {
            return $this->fail('Failed to delete modul praktikum');
        }
    }

    // Events API methods
    public function getEvents()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        // Get query parameters for filtering and pagination
        $page = (int)($this->request->getVar('page') ?? 1);
        $limit = (int)($this->request->getVar('limit') ?? 10);
        $search = $this->request->getVar('search');
        $jenis = $this->request->getVar('jenis');

        // Build query with filters
        $builder = $this->eventsModel->select('events.*, users.nama as creator')
            ->join('users', 'users.id = events.created_by');

        // Apply filters if provided
        if ($search) {
            $builder->groupStart()
                ->like('events.nama_event', $search)
                ->orLike('events.deskripsi', $search)
                ->groupEnd();
        }

        if ($jenis) {
            $builder->where('events.jenis', $jenis);
        }

        // Get total count before pagination
        $total = $builder->countAllResults(false); // false to keep the query builder

        // Apply pagination
        $offset = ($page - 1) * $limit;
        $events = $builder->limit($limit, $offset)->findAll();

        // Prepare response with pagination info
        $response = [
            'data' => $events,
            'pagination' => [
                'page' => (int)$page,
                'limit' => (int)$limit,
                'total' => (int)$total,
                'pages' => ceil($total / $limit)
            ]
        ];

        return $this->respond($response);
    }

    public function createEvent()
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        $data = [
            'nama_event' => $this->request->getPost('nama_event'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'jenis' => $this->request->getPost('jenis'),
            'created_by' => $this->request->getPost('created_by'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->eventsModel->save($data)) {
            $data['id_event'] = $this->eventsModel->getInsertID();
            return $this->respondCreated($data);
        } else {
            return $this->fail('Failed to create event');
        }
    }

    public function updateEvent($id = null)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        $data = [
            'nama_event' => $this->request->getPost('nama_event'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'jenis' => $this->request->getPost('jenis'),
            'created_by' => $this->request->getPost('created_by'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->eventsModel->update($id, $data)) {
            $data['id_event'] = $id;
            return $this->respond($data);
        } else {
            return $this->fail('Failed to update event');
        }
    }

    public function deleteEvent($id = null)
    {
        if (!$this->checkAuth()) {
            return $this->failUnauthorized('Unauthorized');
        }

        if ($this->eventsModel->delete($id)) {
            return $this->respondDeleted(['id' => $id]);
        } else {
            return $this->fail('Failed to delete event');
        }
    }
}