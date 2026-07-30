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
        $sessionUser = session()->get('user');

        if (!$sessionUser) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $userId = $sessionUser['id'] ?? $sessionUser['id_user'] ?? null;
        
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            session()->destroy();
            return redirect()->to('/login')->with('error', 'Sesi berakhir, silahkan login kembali.');
        }

        $roles = [
            1 => 'Kepala Lab',
            2 => 'Asisten',
            3 => 'Dosen',
        ];

        $user['role_id_label'] = $roles[$user['role_id']] ?? 'Tidak diketahui';

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
    
    public function updateProfile()
    {
        $user = session()->get('user');
        if (!$user) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userId = $user['id'] ?? $user['id_user'] ?? null;
        if (!$userId) {
            return redirect()->back()->with('error', 'ID User tidak ditemukan.');
        }

        $dataUpdate = [];

        // Validasi dan simpan Foto jika diunggah
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $maxSize = 2 * 1024 * 1024;

            if (!in_array($foto->getMimeType(), $allowedTypes) || $foto->getSize() > $maxSize) {
                return redirect()->back()->with('error', 'File tidak valid atau terlalu besar.');
            }

            $extension = strtolower($foto->getExtension());
            $validExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (!in_array($extension, $validExtensions)) {
                return redirect()->back()->with('error', 'Ekstensi file tidak valid.');
            }

            $originalName = $foto->getName();
            if (preg_match('/[<>:"\/\\|?*\x00-\x1f]/', $originalName) || strpos($originalName, '..') !== false) {
                return redirect()->back()->with('error', 'Nama file tidak valid.');
            }

            $uploadPath = FCPATH . 'uploads/photos/' . $userId . '/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $newName = $foto->getRandomName();
            $foto->move($uploadPath, $newName);
            $dataUpdate['foto'] = 'uploads/photos/' . $userId . '/' . $newName;
        }

        // Hanya Dosen atau Kepala Lab yang memproses field penelitian
        $roleIdNum = (int)($user['role_id'] ?? 0);
        if ($roleIdNum === 1 || $roleIdNum === 3) {
            $rules = [
                'google_scholar' => 'permit_empty|valid_url_strict',
                'sinta'          => 'permit_empty|valid_url_strict',
                'orcid'          => 'permit_empty|valid_url_strict',
                'scopus'         => 'permit_empty|valid_url_strict',
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->with('error', 'Format URL tidak valid. Pastikan dimulai dengan http:// atau https://')->withInput();
            }

            $dataUpdate['google_scholar'] = $this->request->getPost('google_scholar');
            $dataUpdate['sinta']          = $this->request->getPost('sinta');
            $dataUpdate['orcid']          = $this->request->getPost('orcid');
            $dataUpdate['scopus']         = $this->request->getPost('scopus');
        }

        if (empty($dataUpdate)) {
            return redirect()->back()->with('info', 'Tidak ada perubahan profil.');
        }

        $userModel = new \App\Models\UserModel();
        if ($userModel->update($userId, $dataUpdate)) {
            // Perbarui data di session
            $updatedSession = array_merge($user, $dataUpdate);
            session()->set('user', $updatedSession);

            return redirect()->to('/profile')->with('success', 'Profil berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui profil.');
    }

    public function logout()
    {
        // Hapus semua session (token + user)
        session()->destroy();

        // Redirect ke halaman login
        return redirect()->to('/login')->with('success', 'Berhasil logout');
    }
}