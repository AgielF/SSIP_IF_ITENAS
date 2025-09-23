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
    $search   = $this->request->getVar('search');
    $kategori = $this->request->getVar('kategori');
    $sort     = $this->request->getVar('sort') ?? 'newest';
    $limit    = $this->request->getVar('limit') ?? 10;

    $builder = $this->publikasiModel;

    if ($search) {
        $builder->groupStart()
            ->like('kategori', $search)
            ->orLike('penulis_pendamping', $search)
            ->orLike('deskripsi', $search)
            ->groupEnd();
    }

    if ($kategori) {
        $builder->where('jenis_publikasi', $kategori);
    }

    if ($sort === 'newest') {
        $builder->orderBy('tanggal_publikasi', 'DESC');
    } else {
        $builder->orderBy('tanggal_publikasi', 'ASC');
    }

    $data = [
        'publicationData' => $builder->paginate($limit),
        'pager'           => $this->publikasiModel->pager,
        'search'          => $search,
        'kategori'        => $kategori,
        'sort'            => $sort,
        'limit'           => $limit,
    ];

    return view('publikasi_ilmiah_admin_list_view', $data);
}


    public function store()
    {
        $data = [
            'jenis_publikasi'   => $this->request->getPost('jenis_publikasi'),
            'link_publikasi'    => $this->request->getPost('link_publikasi'),
            'kategori'          => $this->request->getPost('kategori'),
            'tanggal_publikasi' => $this->request->getPost('tanggal_publikasi'),
            'penulis_pendamping'=> $this->request->getPost('penulis_pendamping'),
            'volume'            => $this->request->getPost('volume'),
            'nomor'             => $this->request->getPost('nomor'),
            'tahun'             => $this->request->getPost('tahun'),
            'link_doi'          => $this->request->getPost('link_doi'),
            'link_gdrive'       => $this->request->getPost('link_gdrive'),
            'conference'        => $this->request->getPost('conference'),
            'deskripsi'         => $this->request->getPost('deskripsi'),
            'id_user'           => 1, // Default admin
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s')
        ];

        $this->publikasiModel->insert($data);
        return redirect()->to('/publikasi-ilmiah_admin')->with('success', 'Publikasi berhasil ditambahkan');
    }

    public function update($id_publikasi)
{
    $data = [
        'jenis_publikasi'   => $this->request->getPost('jenis_publikasi'),
        'link_publikasi'    => $this->request->getPost('link_publikasi'),
        'kategori'          => $this->request->getPost('kategori'),
        'tanggal_publikasi' => $this->request->getPost('tanggal_publikasi'),
        'penulis_pendamping'=> $this->request->getPost('penulis_pendamping'),
        'volume'            => $this->request->getPost('volume'),
        'nomor'             => $this->request->getPost('nomor'),
        'tahun'             => $this->request->getPost('tahun'),
        'link_doi'          => $this->request->getPost('link_doi'),
        'link_gdrive'       => $this->request->getPost('link_gdrive'),
        'conference'        => $this->request->getPost('conference'),
        'deskripsi'         => $this->request->getPost('deskripsi'),
        'id_user'           => 1,
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
