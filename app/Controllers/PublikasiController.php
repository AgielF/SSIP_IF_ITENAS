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

        // Get all users for dropdown selection (dosen and asisten only)
        $allUsers = $userModel->whereIn('role_id', [1, 2, 3])->findAll();
    $search   = $this->request->getVar('search');
        $kategori = $this->request->getVar('kategori');
        $sort     = $this->request->getVar('sort') ?? 'newest';
        $limit    = $this->request->getVar('limit') ?? 10;

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
        // Validate that user is admin (role_id = 1)
        if (!session()->get('user') || session()->get('user')['role_id'] != 1) {
            return redirect()->to('/login')->with('error', 'Akses ditolak. Hanya admin yang dapat menambah publikasi.');
        }

        $selectedUserId = $this->request->getPost('id_user'); // Selected author from dropdown

        // Validate selected user exists and is dosen/asisten
        $userModel = new \App\Models\UserModel();
        $selectedUser = $userModel->where('id', $selectedUserId)->whereIn('role_id', [2, 3])->first();
        if (!$selectedUser) {
            return redirect()->back()->withInput()->with('error', 'Penulis yang dipilih tidak valid.');
        }

        // Handle penulis pendamping from dropdown
        $penulisPendamping = $this->request->getPost('penulis_pendamping');

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
            'deskripsi'         => $this->request->getPost('deskripsi'),
            'id_user'           => $selectedUserId, // Use selected user as author
            'created_at'        => date('Y-m-d H:i:s'),
        ];

        $this->publikasiModel->insert($data);
        return redirect()->to('/publikasi-ilmiah_admin')->with('success', 'Publikasi berhasil ditambahkan');
    }

    public function update($id_publikasi)
    {
        // Validate that user is admin (role_id = 1)
        if (!session()->get('user') || session()->get('user')['role_id'] != 1) {
            return redirect()->to('/login')->with('error', 'Akses ditolak. Hanya admin yang dapat mengedit publikasi.');
        }

        $selectedUserId = $this->request->getPost('id_user'); // Selected author from dropdown

        // Validate selected user exists and is dosen/asisten
        $userModel = new \App\Models\UserModel();
        $selectedUser = $userModel->where('id', $selectedUserId)->whereIn('role_id', [1, 2, 3])->first();
        if (!$selectedUser) {
            return redirect()->back()->with('error', 'Penulis yang dipilih tidak valid.');
        }

        // Handle penulis pendamping from dropdown
        $penulisPendamping = $this->request->getPost('penulis_pendamping');

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
            'deskripsi'         => $this->request->getPost('deskripsi'),
            'id_user'           => $selectedUserId, // Use selected user as author
            'updated_at'        => date('Y-m-d H:i:s')
        ];

    $this->publikasiModel->update($id_publikasi, $data);
    return redirect()->to('/publikasi-ilmiah_admin')->with('success', 'Publikasi berhasil diperbarui');
}

public function delete($id_publikasi)
{
    $this->publikasiModel->delete($id_publikasi);
    return redirect()->to('/publikasi-ilmiah_admin')->with('success', 'Publikasi berhasil dihapus');
}

}
