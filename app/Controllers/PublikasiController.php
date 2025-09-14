<?php

namespace App\Controllers;

use App\Models\PublikasiModel;

class PublikasiController extends BaseController
{
    /**
     * Menampilkan daftar semua anggota laboratorium.
     * (Fungsi ini tidak diubah, sudah benar)
     */
    public function index()
    {
        $publikasiModel = new PublikasiModel();
        $formattedData = $publikasiModel->getPublikasiDataFormatedView();

          // 3. Menyiapkan array data untuk dikirim ke view.
        //    Kunci 'data' di sini harus cocok dengan yang diharapkan oleh file view.
        $publicationData = ['publicationData' => $formattedData];
        return view('publikasi_ilmiah_list_view', $publicationData); // Asumsi ini view untuk daftar anggota
        }
    
     public function getDataAdmin()
    {
         // 1. Membuat instance (objek) baru dari ProyekRisetModel
        $risetModel = new PublikasiModel();

        // 2. Memanggil method dari model untuk mendapatkan data yang sudah siap pakai
        $formattedData = $risetModel->getPublikasiDataFormatedView();

        // 3. Menyiapkan array data untuk dikirim ke view.
        //    Kunci 'data' di sini harus cocok dengan yang diharapkan oleh file view.
        $publicationData = ['publicationData' => $formattedData];
        return view('publikasi_ilmiah_admin_list_view', $publicationData); // Asumsi ini view untuk daftar anggota
    }

 
  
}