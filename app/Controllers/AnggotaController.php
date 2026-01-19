<?php

namespace App\Controllers;

use App\Models\UserModel;

class AnggotaController extends BaseController
{
    /**
     * Menampilkan daftar semua anggota laboratorium.
     * (Fungsi ini tidak diubah, sudah benar)
     */
    public function index()
    {
        $userModel = new UserModel();
        $allPersonnel = $userModel->getProcessedPersonnelData();
        $data = [
            'title'   => 'Anggota Laboratorium',
            'asisten' => $allPersonnel 
        ];
        return view('asisten_list_view', $data); // Asumsi ini view untuk daftar anggota
    }
    
    // --- FUNGSI BARU UNTUK MENANGANI HALAMAN PROFIL ---
    /**
     * Menampilkan halaman profil untuk satu anggota.
     * @param int $id - ID pengguna dari URL.
     */
    public function profil($id)
    {
        $userModel = new UserModel();

        // 1. Cari pengguna di database berdasarkan ID
        $user = $userModel->find($id);

        // 2. Jika pengguna tidak ditemukan, tampilkan halaman error 404
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // 3. Tambahkan key 'role' berupa string berdasarkan 'role_id'
        $roleMap = [
            3 => 'dosen',
            2 => 'asisten',
        ];
        $user['role'] = $roleMap[$user['role_id']] ?? 'tidak diketahui';
        
        // 4. Siapkan data untuk dikirim ke view profil
        $data = [
            'title' => 'Profil Anggota | ' . $user['nama'],
            'user'  => $user
        ];

        // 5. Tampilkan view profil dan kirim datanya
        return view('user_profile_view', $data); // Ganti dengan nama file view profil Anda
    }
}