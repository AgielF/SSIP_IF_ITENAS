<?php

namespace App\Controllers;

use App\Models\PublikasiModel;

class PublikasiController extends BaseController
{
    protected $publikasiModel;

    public function __construct()
    {
        $this->publikasiModel = new PublikasiModel();
    }

    public function index()
    {
        $formattedData = $this->publikasiModel->getPublikasiDataFormatedView();
        return view('publikasi_ilmiah_list_view', ['publicationData' => $formattedData]);
    }

    public function getDataAdmin()
    {
        $userModel = new \App\Models\UserModel();

        // Get all users for dropdown selection (dosen, asisten, kepala lab)
        $allUsers = $userModel->whereIn('role_id', [1, 2, 3])->findAll();
        
        $search   = $this->request->getVar('search');
        $kategori = $this->request->getVar('kategori');
        $sort     = $this->request->getVar('sort') ?? 'newest';
        
        // 🛡️ PASTIKAN LIMIT ADALAH ANGKA (Cegah Error-Based SQLi)
        $limit    = (int) ($this->request->getVar('limit') ?? 10);
        if ($limit <= 0) {
            $limit = 10;
        }

        // ✅ Panggil function join dari model
        $builder = $this->publikasiModel->getDataWithUser();

        if ($search) {
            $builder->groupStart()
                ->like('publikasi.kategori', $search)
                ->orLike('publikasi.penulis_pendamping', $search)
                ->orLike('publikasi.deskripsi', $search)
                ->orLike('users.nama', $search)
                ->groupEnd();
        }

        if ($kategori) {
            $builder->where('publikasi.jenis_publikasi', $kategori);
        }

        $builder->orderBy('publikasi.tanggal_publikasi', $sort === 'newest' ? 'DESC' : 'ASC');

        $data = [
            'publicationData' => $builder->paginate($limit),
            'pager'           => $this->publikasiModel->pager,
            'search'          => $search,
            'kategori'        => $kategori,
            'sort'            => $sort,
            'limit'           => $limit,
            'allUsers'        => $allUsers, // For dropdown selection
        ];

        return view('publikasi_ilmiah_admin_list_view', $data);
    }

    public function store()
    {
        // 🛡️ 1. VALIDASI INPUT KETAT
        $rules = [
            'id_user'            => 'required|numeric',
            'jenis_publikasi'    => 'required|max_length[100]',
            'judul'              => 'required|max_length[255]',
            'kategori'           => 'required|max_length[100]',
            'tanggal_publikasi'  => 'permit_empty|valid_date',
            'penulis_pendamping' => 'permit_empty|max_length[255]',
            'volume'             => 'permit_empty|max_length[50]',
            'topik'              => 'required|max_length[100]',
            'nomor'              => 'permit_empty|max_length[50]',
            'tahun'              => 'permit_empty|numeric|exact_length[4]',
            'link_publikasi'     => 'permit_empty|max_length[500]',
            'link_doi'           => 'permit_empty|max_length[500]',
            'link_gdrive'        => 'permit_empty|max_length[500]',
            'conference'         => 'permit_empty|max_length[255]',
            'lokasi_conference'  => 'permit_empty|max_length[255]',
            'publisher_jurnal'   => 'permit_empty|max_length[255]',
            'deskripsi'          => 'permit_empty'
        ];

        // PERBAIKAN: Tangkap detail pesan error jika form tidak lengkap
        if (!$this->validate($rules)) {
            $errors = $this->validator->getErrors();
            $errorMessage = 'Gagal: ' . implode(', ', $errors);
            return redirect()->back()->withInput()->with('error', $errorMessage);
        }

        $selectedUserId = $this->request->getPost('id_user');

        // PERBAIKAN: Role ID 1, 2, 3 diizinkan
        $userModel = new \App\Models\UserModel();
        $selectedUser = $userModel->where('id', $selectedUserId)->whereIn('role_id', [1, 2, 3])->first();
        if (!$selectedUser) {
            return redirect()->back()->withInput()->with('error', 'Penulis yang dipilih tidak valid.');
        }

        $penulisPendamping = $this->request->getPost('penulis_pendamping');

        // 🛡️ 2. TRY-CATCH ERROR HANDLING
        try {
            $data = [
                'jenis_publikasi'   => $this->request->getPost('jenis_publikasi'),
                'link_publikasi'    => $this->request->getPost('link_publikasi'),
                'judul'             => $this->request->getPost('judul'),
                'kategori'          => $this->request->getPost('kategori'),
                'tanggal_publikasi' => $this->request->getPost('tanggal_publikasi'),
                'penulis_pendamping'=> $penulisPendamping,
                'volume'            => $this->request->getPost('volume'),
                'topik'             => $this->request->getPost('topik'),
                'nomor'             => $this->request->getPost('nomor'),
                'tahun'             => $this->request->getPost('tahun'),
                'link_doi'          => $this->request->getPost('link_doi'),
                'link_gdrive'       => $this->request->getPost('link_gdrive'),
                'conference'        => $this->request->getPost('conference'),
                'lokasi_conference' => $this->request->getPost('lokasi_conference'),
                'publisher_jurnal'  => $this->request->getPost('publisher_jurnal'),
                'deskripsi'         => $this->request->getPost('deskripsi'),
                'id_user'           => $selectedUserId,
            ];

            $this->publikasiModel->insert($data);
            return redirect()->to('/publikasi-ilmiah_admin')->with('success', 'Publikasi berhasil ditambahkan');
            
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat menyimpan publikasi.');
        }
    }

    public function update($id_publikasi)
    {
        // 🛡️ 1. PASTIKAN ID NUMERIC
        if (!is_numeric($id_publikasi)) {
            return redirect()->to('/publikasi-ilmiah_admin')->with('error', 'ID Publikasi tidak valid.');
        }

        // 🛡️ 2. VALIDASI INPUT KETAT
        $rules = [
            'id_user'            => 'required|numeric',
            'jenis_publikasi'    => 'required|max_length[100]',
            'judul'              => 'required|max_length[255]',
            'kategori'           => 'required|max_length[100]',
            'tanggal_publikasi'  => 'permit_empty|valid_date',
            'penulis_pendamping' => 'permit_empty|max_length[255]',
            'volume'             => 'permit_empty|max_length[50]',
            'topik'              => 'required|max_length[100]',
            'nomor'              => 'permit_empty|max_length[50]',
            'tahun'              => 'permit_empty|numeric|exact_length[4]',
            'link_publikasi'     => 'permit_empty|max_length[500]',
            'link_doi'           => 'permit_empty|max_length[500]',
            'link_gdrive'        => 'permit_empty|max_length[500]',
            'conference'         => 'permit_empty|max_length[255]',
            'lokasi_conference'  => 'permit_empty|max_length[255]',
            'publisher_jurnal'   => 'permit_empty|max_length[255]',
            'deskripsi'          => 'permit_empty'
        ];

        // PERBAIKAN: Tangkap detail pesan error jika form tidak lengkap
        if (!$this->validate($rules)) {
            $errors = $this->validator->getErrors();
            $errorMessage = 'Gagal: ' . implode(', ', $errors);
            return redirect()->back()->withInput()->with('error', $errorMessage);
        }

        $selectedUserId = $this->request->getPost('id_user');

        // Validate selected user exists
        $userModel = new \App\Models\UserModel();
        $selectedUser = $userModel->where('id', $selectedUserId)->whereIn('role_id', [1, 2, 3])->first();
        if (!$selectedUser) {
            return redirect()->back()->withInput()->with('error', 'Penulis yang dipilih tidak valid.');
        }

        $penulisPendamping = $this->request->getPost('penulis_pendamping');

        // 🛡️ 3. TRY-CATCH ERROR HANDLING
        try {
            $data = [
                'jenis_publikasi'   => $this->request->getPost('jenis_publikasi'),
                'link_publikasi'    => $this->request->getPost('link_publikasi'),
                'judul'             => $this->request->getPost('judul'),
                'kategori'          => $this->request->getPost('kategori'),
                'tanggal_publikasi' => $this->request->getPost('tanggal_publikasi'),
                'penulis_pendamping'=> $penulisPendamping,
                'volume'            => $this->request->getPost('volume'),
                'topik'             => $this->request->getPost('topik'),
                'nomor'             => $this->request->getPost('nomor'),
                'tahun'             => $this->request->getPost('tahun'),
                'link_doi'          => $this->request->getPost('link_doi'),
                'link_gdrive'       => $this->request->getPost('link_gdrive'),
                'conference'        => $this->request->getPost('conference'),
                'lokasi_conference' => $this->request->getPost('lokasi_conference'),
                'publisher_jurnal'  => $this->request->getPost('publisher_jurnal'),
                'deskripsi'         => $this->request->getPost('deskripsi'),
                'id_user'           => $selectedUserId,
            ];

            $this->publikasiModel->update($id_publikasi, $data);
            return redirect()->to('/publikasi-ilmiah_admin')->with('success', 'Publikasi berhasil diperbarui');

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem saat memperbarui publikasi.');
        }
    }

    public function delete($id_publikasi)
    {
        // 🛡️ PASTIKAN ID NUMERIC & TRY-CATCH
        if (!is_numeric($id_publikasi)) {
            return redirect()->to('/publikasi-ilmiah_admin')->with('error', 'ID Publikasi tidak valid.');
        }

        try {
            $this->publikasiModel->delete($id_publikasi);
            return redirect()->to('/publikasi-ilmiah_admin')->with('success', 'Publikasi berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/publikasi-ilmiah_admin')->with('error', 'Gagal menghapus publikasi.');
        }
    }
}