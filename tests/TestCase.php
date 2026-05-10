<?php

namespace Tests;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;
use Firebase\JWT\JWT;

abstract class TestCase extends CIUnitTestCase
{
    use FeatureTestTrait, DatabaseTestTrait;

    protected $migrate     = true;
    protected $refresh     = true;
    protected $namespace   = 'App';
    protected $basePath    = APPPATH . 'Database';
    protected $seed        = 'DatabaseSeeder'; 

    protected function loginAs(int $roleId, string $nomor = '152022001', string $nama = 'User Test')
    {
        // 1. Patok ID secara pasti berdasarkan Role
        $id = 1;
        if ($roleId == 2) $id = 6;
        if ($roleId == 3) $id = 2;

        $userData = [
            'id'        => $id,
            'id_user'   => $id,
            'user_id'   => $id,
            'nomor'     => $nomor,
            'nama'      => $nama,
            'role_id'   => $roleId,
            'logged_in' => true
        ];

        // 3. Siapkan token JWT
        $key = env('JWT_SECRET', 'rahasia_keamanan_sistem_ssip_lab_itenas_2026_aman!');
        $payload = [
            'iat'     => time(),
            'exp'     => time() + 3600,
            'uid'     => $id,
            'id'      => $id,
            'id_user' => $id,
            'user_id' => $id,
            'nomor'   => $nomor,
            'role_id' => $roleId
        ];
        
        $token = JWT::encode($payload, $key, 'HS256');

        // 🔥 KUNCI PERBAIKAN: Tempelkan header secara permanen ke server testing
        $_SERVER['HTTP_AUTHORIZATION'] = 'Bearer ' . $token;

        return $this->withSession([
                        'user'      => $userData,
                        'id'        => $id,
                        'id_user'   => $id,
                        'user_id'   => $id,
                        'logged_in' => true
                    ])
                    ->withHeaders(['Authorization' => 'Bearer ' . $token]);
    }
}