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
        $userSession = session('user');
        if (!$userSession) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Fetch fresh user data from DB to get updated foto
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($userSession['id']);

        if (!$user) {
            return redirect()->to('/login')->with('error', 'User tidak ditemukan.');
        }

        return view('auth/profile', ['title' => 'Profile', 'user' => $user]);
    }
       public function logout()
    {
        // Hapus semua session (token + user)
        session()->destroy();

        // Redirect ke halaman login
        return redirect()->to('/login')->with('success', 'Berhasil logout');
    }
}
