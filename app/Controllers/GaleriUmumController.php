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
    public function admin()
    {
        $galerimodelall = $this->galeriUmumModel->getDataAdminFormatted();
        return view('galeri_admin_list_view', [
            'title' => 'Kelola Galeri & Media',
            'media_items' => $galerimodelall['galeri']
        ]);
    }

    // CREATE
    public function create()
    {
        $data = [
            'kategori'       => $this->request->getPost('kategori'),
            'keterangan'     => $this->request->getPost('keterangan'),
            'file_url'       => $this->request->getPost('file_url'),
            'tanggal_upload' => date('Y-m-d H:i:s'),
            'id_user'        => 1 // default admin
        ];

        $this->galeriUmumModel->insert($data);
        return redirect()->to('/galeri_admin')->with('success', 'Data berhasil ditambahkan');
    }

    // UPDATE
    public function update($id)
    {
        $data = [
            'kategori'   => $this->request->getPost('kategori'),
            'keterangan' => $this->request->getPost('keterangan'),
            'file_url'   => $this->request->getPost('file_url'),
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
