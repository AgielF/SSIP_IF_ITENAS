<?php

namespace App\Middleware;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Middleware\BaseMiddleware;

class RateLimitMiddleware extends BaseMiddleware
{
    public function before(RequestInterface $request, $arguments = null){

        $ip = $request->getIPAddress();
        $key = 'login_attempts_' . $ip;
        $attempts = session()->get($key) ?? 0;

        if ($attempts >= 5) {
            return redirect()->back()->with('error', 'Terlalu banyak percobaan login. Silakan coba lagi nanti.');
        }

        return $request;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null){
        // Tidak ada tindakan setelah permintaan
        if($response->getStatusCode() === 302 && session()->getFlashdata('error')){
            $ip = $request->getIPAddress();
            $key = 'login_attempts_' . $ip;
            $attempts = session()->get($key) ?? 0;
            session()->set($key, $attempts + 1);
        }
    }
}