<?php

namespace App\Controllers;

use App\Models\JadwalModel;
use App\Models\AsistenJadwalModel;

class JadwalController extends BaseController
{
    /**
     * Menampilkan daftar semua jadwal beserta detail event.
     */
    public function index()
    {
        $jadwalModel = new JadwalModel();
        $data = [
            'title'  => 'Daftar Jadwal',
            'jadwal' => $jadwalModel->getJadwalWithDetails()
        ];
        return view('jadwal/index', $data);
    }

    /**
     * Menampilkan detail satu jadwal, termasuk asisten yang bertugas.
     */
    public function show($id_jadwal)
    {
        $jadwalModel = new JadwalModel();
        $asistenJadwalModel = new AsistenJadwalModel();

        $data = [
            'title'    => 'Detail Jadwal',
            'jadwal'   => $jadwalModel->getJadwalWithDetails(), // Perlu modifikasi di model
            'asisten'  => $asistenJadwalModel->getAsistenByJadwal($id_jadwal)
        ];

        return view('jadwal/show', $data);
    }

    // Method lain seperti create, edit, update, dan delete bisa ditambahkan di sini.
}
