<?php
namespace Tests\Integration;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;

class ApiIntegrationTest extends CIUnitTestCase
{
    use FeatureTestTrait, DatabaseTestTrait;

    protected $migrate = true;
    protected $seed = 'Tests\Support\Database\Seeds\DatabaseSeeder';

    public function testApiContentEndpoints()
    {
        $endpoints = [
            '/api/visi-misi',
            '/api/proyek-riset',
            '/api/publikasi',
            '/api/galeri',
            '/api/rekrutmen',
            '/api/berita',
            '/api/events',
            '/api/asisten'
        ];

        foreach ($endpoints as $endpoint) {
            $response = $this->get($endpoint);

            $this->assertTrue(
                $response->isOK(),
                "Endpoint {$endpoint} should return OK status"
            );

            // Test: Response adalah JSON
            $contentType = $response->getHeaderLine('Content-Type');
            $this->assertStringContainsString(
                'application/json',
                $contentType,
                "Endpoint {$endpoint} should return JSON"
            );
        }
    }

    public function testAuthenticationFlow()
    {
        // Test: Login berhasil
        $response = $this->post('/api/auth/login', [
            'nomor' => '152022001',
            'password' => 'admin123'
        ]);

        $this->assertTrue(
            $response->isRedirect(),
            'Login should redirect after success'
        );

        // Test: Session memiliki token
        $this->assertNotEmpty(
            session('token'),
            'Session should have JWT token after login'
        );
    }
}