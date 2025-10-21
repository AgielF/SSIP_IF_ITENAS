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
        return view('auth/profile', ['title' => 'Profile']);
    }
       public function logout()
    {
        // Hapus semua session (token + user)
        session()->destroy();

        // Redirect ke halaman login
        return redirect()->to('/login')->with('success', 'Berhasil logout');
    }
}
