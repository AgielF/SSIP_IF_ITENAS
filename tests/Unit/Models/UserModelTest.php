<?php
namespace Tests\Unit\Models;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use App\Models\UserModel;

class UserModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate = true;
    protected $seed = 'Tests\Support\Database\Seeds\DatabaseSeeder';

    public function testGetAsistenLabReturnsCorrectData()
    {
        $model = new UserModel();
        $asisten = $model->getAsistenLab();

        // Test: Data tidak kosong
        $this->assertNotEmpty($asisten, 'Asisten data should not be empty');

        // Test: Semua user memiliki role_id = 2 (asisten)
        foreach ($asisten as $user) {
            $this->assertEquals(2, $user['role_id'], 'All users should be asisten (role_id = 2)');
        }

        // Test: Data memiliki field yang diperlukan
        $this->assertArrayHasKey('nama', $asisten[0], 'User should have nama field');
        $this->assertArrayHasKey('nomor', $asisten[0], 'User should have nomor field');
    }

    public function testPasswordVerification()
    {
        $model = new UserModel();
        $plainPassword = 'testpassword123';
        $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

        // Test: Password verification berhasil
        $this->assertTrue(
            $model->verifyPassword($plainPassword, $hashedPassword),
            'Password verification should succeed with correct password'
        );

        // Test: Password verification gagal dengan password salah
        $this->assertFalse(
            $model->verifyPassword('wrongpassword', $hashedPassword),
            'Password verification should fail with incorrect password'
        );
    }
}