<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RekrutModel; // Import RekrutModel

class RekrutController extends BaseController
{
    /**
     * Menampilkan halaman rekrutmen publik.
     */
    //tampil data rekrutmen
    public function index()
    {
        $rekrutModel = new RekrutModel();

        $data = [
            'title'      => 'Informasi Rekrutmen',
            'rekrutmen' => $rekrutModel->index()
        ];

        // Anda perlu membuat view 'rekrutmen_view.php' untuk menampilkan ini
        return view('rekrutmen_view', $data);
    }

    /**
     * Menampilkan halaman admin untuk mengelola rekrutmen.
     */

    //tampil data rekrutmen admin
   public function admin()
{
    $rekrutModel = new RekrutModel();
    $rekrutmenData = $rekrutModel->getDataAdmin();

    $data = [
        'title' => 'Admin: Kelola Rekrutmen',
        'rekrutmen' => $rekrutmenData['rekrutmen'] // langsung ambil
    ];

    return view('rekrutmen_admin_view', $data);
}
}
