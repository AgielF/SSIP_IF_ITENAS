<?php

namespace Tests\App\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use App\Libraries\JwtHelper;
use Firebase\JWT\JWT;

class BaseSecurityTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $refresh = false;
    protected $migrate = false;
    protected $namespace = 'App';
    
    // Load prerequisites from seeder
    protected $seed = 'Tests\Support\Database\Seeds\DevSecOpsSeeder';

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Helper to mock Session & JWT for a specific role
     * @param int $roleId
     * @return array session data to be used with ->withSession()
     */
    protected function getSessionForRole(int $roleId): array
    {
        $payload = [
            'uid' => $roleId, // Using seeded user ID mapping
            'role_id' => $roleId,
            'iat' => time(),
            'exp' => time() + 3600
        ];
        $key = JwtHelper::getSecretKey();
        $token = JWT::encode($payload, $key, 'HS256');

        return [
            'user' => [
                'id' => $roleId,
                'role_id' => $roleId,
                'nama' => 'Test User Role ' . $roleId
            ],
            'jwt' => $token
        ];
    }

    /**
     * Return list of common SQLi Payloads
     */
    protected function getSqliPayloads(): array
    {
        return [
            "' OR 1=1 --",
            "\"; DROP TABLE users; #",
            "1' UNION SELECT * FROM users --"
        ];
    }

    /**
     * Return list of common XSS Payloads
     */
    protected function getXssPayloads(): array
    {
        return [
            "<script>alert('XSS_TEST')</script>",
            "\"><svg/onload=alert(1)>"
        ];
    }
}
