<?php

namespace App\Controllers;

class AuthUi extends BaseController
{
    public function login()
    {
        return view('auth/login', ['title' => 'Login']);
    }

    public function profile()
    {
        $user = session()->get('user');

        if (!$user) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $roles = [
            1 => 'Kepala Lab',
            2 => 'Asisten',
            3 => 'Dosen',
        ];

        $user['role_id'] = $roles[$user['role_id']] ?? 'Tidak diketahui';

        // Ambil ID dengan aman
        $userId = $user['id'] ?? $user['id_user'] ?? null;

        $publikasiModel = new \App\Models\PublikasiModel();
        $proyekModel    = new \App\Models\ProyekRisetModel();

        if ($userId) {
            $publicationData = $publikasiModel->getDataWithUser()
                                              ->where('publikasi.id_user', $userId)
                                              ->findAll();
                                              
            $proyekData = $proyekModel->where('id_user', $userId)->findAll();
        } else {
            $publicationData = [];
            $proyekData = [];
        }

        // KITA TES DEBUG DI SINI
        

        $data = [
            'title'           => 'Profil Saya | ' . $user['nama'],
            'user'            => $user,
            'publicationData' => $publicationData,
            'proyekData'      => $proyekData
        ];

        return view('auth/profile', $data);
    }
       public function logout()
    {
        // Hapus semua session (token + user)
        session()->destroy();

        // Redirect ke halaman login
        return redirect()->to('/login')->with('success', 'Berhasil logout');
    }
}
