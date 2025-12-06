<?php
namespace Tests\Regression;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;

class RegressionTest extends CIUnitTestCase
{
    use FeatureTestTrait, DatabaseTestTrait;

    protected $migrate = true;
    protected $seed = 'Tests\Support\Database\Seeds\DatabaseSeeder';

    public function testCriticalFunctionalityAfterChanges()
    {
        // Test: Login masih berfungsi setelah perubahan
        $response = $this->post('/api/auth/login', [
            'nomor' => '152022001',
            'password' => 'admin123'
        ]);
        $this->assertTrue($response->isRedirect(), 'Login should still work');

        // Test: CRUD operations masih berfungsi
        $this->loginAsAdmin();

        // Test: User management masih berfungsi
        $response = $this->get('/asisten_admin');
        $this->assertTrue($response->isOK(), 'Admin page should still load');

        // Test: Toast notifications masih berfungsi
        $userData = [
            'nomor' => '152022888',
            'nama' => 'Regression Test User',
            'jurusan' => 'Informatika',
            'password' => 'test123',
            'role_id' => 2
        ];

        $response = $this->post('/asisten/store', $userData);
        $this->assertTrue($response->isRedirect(), 'CRUD should still work');
        $this->assertNotEmpty(session('success'), 'Toast notification should appear');
    }

    private function loginAsAdmin()
    {
        $this->post('/api/auth/login', [
            'nomor' => '152022001',
            'password' => 'admin123'
        ]);
    }
}