<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GaleriUmumModel;

class GaleriUmumController extends BaseController
{
    protected $galeriUmumModel;

    public function __construct()
    {
        $this->galeriUmumModel = new GaleriUmumModel();
    }

    // Untuk user publik
    public function index()
    {
        $gallery_items = $this->galeriUmumModel->getDataWithUser();
        return view('galeri_list_view', [
            'title' => 'Galeri & Media',
            'gallery_items' => $gallery_items
        ]);
    }

    // Untuk admin
    // Untuk admin
public function admin()
{
    $sort = $this->request->getGet('sort') ?? 'DESC'; // default terbaru

    $galerimodelall = $this->galeriUmumModel->getDataAdminFormatted($sort);

    return view('galeri_admin_list_view', [
        'title'       => 'Kelola Galeri & Media',
        'media_items' => $galerimodelall['galeri'],
        'sort'        => $sort
    ]);
}


    // CREATE
    public function create()
    {
        $userId = $this->getUserIdOrRedirect(); // ✅ langsung ambil id user 
        $data = [
            'kategori'       => $this->request->getPost('kategori'),
            'keterangan'     => $this->request->getPost('keterangan'),
            'file_url'       => $this->request->getPost('file_url'),
            'tanggal_upload' => date('Y-m-d H:i:s'),
            'id_user'        => $userId // default admin
        ];

        $this->galeriUmumModel->insert($data);
        return redirect()->to('/galeri_admin')->with('success', 'Data berhasil ditambahkan');
    }

    // UPDATE
    public function update($id)
    {
        $userId = $this->getUserIdOrRedirect(); // ✅ langsung ambil id user 
        $data = [
            'kategori'   => $this->request->getPost('kategori'),
            'keterangan' => $this->request->getPost('keterangan'),
            'file_url'   => $this->request->getPost('file_url'),
            'tanggal_upload' => date('Y-m-d H:i:s'),
            'id_user'        => $userId // default admin
        ];

        $this->galeriUmumModel->update($id, $data);
        return redirect()->to('/galeri_admin')->with('success', 'Data berhasil diupdate');
    }

    // DELETE
    public function delete($id)
    {
        $this->galeriUmumModel->delete($id);
        return redirect()->to('/galeri_admin')->with('success', 'Data berhasil dihapus');
    }
}
