<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Cek apakah session user ada
        $user = session()->get('user');

        if (!$user) {
            // Kalau belum login, redirect ke login
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Kalau ada user, lanjutkan ke controller
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu dipakai, tapi harus ada
    }
}
