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

        $user['role_id_label'] = $roles[$user['role_id']] ?? 'Tidak diketahui';

        // Ambil ID dan Nama dengan aman
        $userId   = $user['id'] ?? $user['id_user'] ?? null;
        $userName = $user['nama'] ?? '';

        $publikasiModel = new \App\Models\PublikasiModel();
        $proyekModel    = new \App\Models\ProyekRisetModel();

        if ($userId) {
            // 🔍 QUERY PUBLIKASI: Ambil jika user adalah Penulis Utama (id_user) ATAU Penulis Pendamping (nama)
            $publicationData = $publikasiModel->getDataWithUser()
                                              ->groupStart()
                                                  ->where('publikasi.id_user', $userId)
                                                  ->orLike('publikasi.penulis_pendamping', $userName)
                                              ->groupEnd()
                                              ->findAll();
                                              
            // 🔍 QUERY PROYEK: Ambil jika user adalah Ketua (id_user) ATAU Mitra/Anggota (nama)
            $proyekData = $proyekModel->groupStart()
                                      ->where('id_user', $userId)
                                      ->orLike('mitra', $userName)
                                      ->groupEnd()
                                      ->findAll();
        } else {
            $publicationData = [];
            $proyekData = [];
        }

        $data = [
            'title'           => 'Profil Saya | ' . $userName,
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