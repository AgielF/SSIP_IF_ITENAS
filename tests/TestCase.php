<?php

namespace Tests;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;
use Firebase\JWT\JWT;

abstract class TestCase extends CIUnitTestCase
{
    use FeatureTestTrait, DatabaseTestTrait;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Fungsi bantuan untuk menyuntikkan session login secara otomatis
     */
    protected function loginAsAdmin()
    {
        $key = getenv('JWT_SECRET') ?: 'rahasia-kita-bersama';
        $payload = [
            'iat'     => time(),
            'exp'     => time() + 3600,
            'uid'     => 1,
            'nomor'   => '152022001', // Sesuaikan dengan data di seeder Anda
            'nama'    => 'Admin SSIP',
            'role_id' => 1
        ];

        $token = JWT::encode($payload, $key, 'HS256');

        return $this->withSession([
            'token'      => $token,
            'login_time' => time(),
            'user'       => [
                'id'      => 1,
                'nomor'   => '152022001',
                'nama'    => 'Admin SSIP',
                'role_id' => 1
            ]
        ]);
    }
}