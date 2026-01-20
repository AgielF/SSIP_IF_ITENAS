<?php

namespace App\Controllers;

use App\Models\UserModel;

class OrganizationController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();

        // Ambil data untuk struktur organisasi
        $kepalaLab = $userModel->where('role_id', 1)->findAll(); // Admin sebagai Kepala Lab
        $dosenLab = $userModel->where('role_id', 3)->findAll();   // Dosen
        $asistenLab = $userModel->where('role_id', 2)->findAll(); // Asisten

        $data = [
            'title' => 'Struktur Organisasi Lab Fisika Dasar',
            'kepalaLab' => $kepalaLab,
            'dosenLab' => $dosenLab,
            'asistenLab' => $asistenLab
        ];

        return view('organization_chart_view', $data);
    }
}