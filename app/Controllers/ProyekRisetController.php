<?php

namespace App\Controllers;

use App\Models\ProyekRisetModel;

class ProyekRisetController extends BaseController
{
    /**
     * Menampilkan daftar semua anggota laboratorium.
     * (Fungsi ini tidak diubah, sudah benar)
     */
    public function index()
    {
         // 1. Membuat instance (objek) baru dari ProyekRisetModel
        $risetModel = new ProyekRisetModel();

        // 2. Memanggil method dari model untuk mendapatkan data yang sudah siap pakai
        $formattedData = $risetModel->getProyekDataFormattedForView();

        // 3. Menyiapkan array data untuk dikirim ke view.
        //    Kunci 'data' di sini harus cocok dengan yang diharapkan oleh file view.
        $data = ['data' => $formattedData];
        return view('penelitian_proyek_list_view', $data); // Asumsi ini view untuk daftar anggota
    }
     public function getDataAdmin()
    {
         // 1. Membuat instance (objek) baru dari ProyekRisetModel
        $risetModel = new ProyekRisetModel();

        // 2. Memanggil method dari model untuk mendapatkan data yang sudah siap pakai
        $formattedData = $risetModel->getProyekDataFormattedForView();

        // 3. Menyiapkan array data untuk dikirim ke view.
        //    Kunci 'data' di sini harus cocok dengan yang diharapkan oleh file view.
        $data = ['data' => $formattedData];
        return view('penelitian_proyek_admin_list_view', $data); // Asumsi ini view untuk daftar anggota
    }

 
  
}