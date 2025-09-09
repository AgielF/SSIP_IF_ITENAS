<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GaleriUmumModel; // Import RekrutModel

class GaleriUmumController extends BaseController
{
    /**
     * Menampilkan halaman rekrutmen publik.
     */
    //tampil data rekrutmen
    public function index()
    {
        $galeriModel = new GaleriUmumModel();

        // Ambil data galeri + user uploader
        $gallery_items = $galeriModel->getDataWithUser();
        $data = [
            'title' => 'Galeri & Media',
            'gallery_items' => $gallery_items
        ];

        return view('galeri_list_view', $data);
    }


    //tampil data rekrutmen admin
   public function admin()
{
     $galeriModel = new GaleriUmumModel();

        // Ambil semua data galeri (DESC biar terbaru duluan)
        $media_items = $galeriModel->orderBy('tanggal_upload', 'DESC')->findAll();

        $data = [
            'title' => 'Kelola Galeri & Media',
            'media_items' => $media_items
        ];

        return view('galeri_admin_list_view', $data);
    }

    public function getDataAdmin(){
         $galeriModel = new GaleriUmumModel();

         $galerimodelall=$galeriModel->getDataAdmin();
         
         $data = [
            'title' => 'Kelola Galeri & Media',
            'media_items' => $galerimodelall['galeri'] // ✅ langsung ambil
        ];

          return view('galeri_admin_list_view', $data);

    }
    
}

