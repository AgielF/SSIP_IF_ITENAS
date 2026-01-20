<?php
namespace Tests\System;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;

class FunctionalTest extends CIUnitTestCase
{
    use FeatureTestTrait, DatabaseTestTrait;

    protected $migrate = true;
    protected $seed = 'Tests\Support\Database\Seeds\DatabaseSeeder';

    public function testCompleteUserManagementWorkflow()
    {
        // 1. Login sebagai admin
        $this->loginAsAdmin();

        // 2. Akses halaman admin asisten
        $response = $this->get('/asisten_admin');
        $this->assertTrue($response->isOK(), 'Admin should access asisten admin page');

        // 3. Tambah user baru
        $userData = [
            'nomor' => '152022999',
            'nama' => 'Test User',
            'no_telp' => '081234567890',
            'jurusan' => 'Informatika',
            'password' => 'testpass123',
            'role_id' => 2
        ];

        $response = $this->post('/asisten/store', $userData);
        $this->assertTrue($response->isRedirect(), 'Store should redirect after success');

        // 4. Verifikasi user ditambahkan
        $userModel = new \App\Models\UserModel();
        $user = $userModel->where('nomor', '152022999')->first();
        $this->assertNotNull($user, 'User should be created in database');

        // 5. Update user
        $updateData = [
            'nomor' => '152022999',
            'nama' => 'Updated Test User',
            'jurusan' => 'Sistem Informasi',
            'role_id' => 3
        ];

        $response = $this->post("/asisten/update/{$user['id']}", $updateData);
        $this->assertTrue($response->isRedirect(), 'Update should redirect after success');

        // 6. Verifikasi user diupdate
        $updatedUser = $userModel->find($user['id']);
        $this->assertEquals('Updated Test User', $updatedUser['nama'], 'User name should be updated');
        $this->assertEquals('Sistem Informasi', $updatedUser['jurusan'], 'User jurusan should be updated');

        // 7. Hapus user
        $response = $this->get("/asisten/delete/{$user['id']}");
        $this->assertTrue($response->isRedirect(), 'Delete should redirect after success');

        // 8. Verifikasi user dihapus
        $deletedUser = $userModel->find($user['id']);
        $this->assertNull($deletedUser, 'User should be deleted from database');
    }

    public function testCompletePublicationWorkflow()
    {
        // 1. Login sebagai admin
        $this->loginAsAdmin();

        // 2. Akses halaman admin publikasi
        $response = $this->get('/publikasi-ilmiah_admin');
        $this->assertTrue($response->isOK(), 'Admin should access publikasi admin page');

        // 3. Tambah publikasi baru
        $pubData = [
            'jenis_publikasi' => 'jurnal',
            'link_publikasi' => 'https://example.com/paper',
            'kategori' => 'Machine Learning',
            'tanggal_publikasi' => '2024-01-15',
            'penulis_pendamping' => 'John Doe, Jane Smith',
            'deskripsi' => 'Research paper about ML algorithms'
        ];

        $response = $this->post('/publikasi-ilmiah/store', $pubData);
        $this->assertTrue($response->isRedirect(), 'Store should redirect after success');

        // 4. Verifikasi publikasi ditambahkan
        $pubModel = new \App\Models\PublikasiModel();
        $pub = $pubModel->where('link_publikasi', 'https://example.com/paper')->first();
        $this->assertNotNull($pub, 'Publication should be created in database');

        // 5. Update publikasi
        $updateData = [
            'jenis_publikasi' => 'prosiding',
            'kategori' => 'Updated ML Research',
            'deskripsi' => 'Updated research paper description'
        ];

        $response = $this->post("/publikasi-ilmiah/update/{$pub['id_publikasi']}", $updateData);
        $this->assertTrue($response->isRedirect(), 'Update should redirect after success');

        // 6. Hapus publikasi
        $response = $this->get("/publikasi-ilmiah/delete/{$pub['id_publikasi']}");
        $this->assertTrue($response->isRedirect(), 'Delete should redirect after success');
    }

    private function loginAsAdmin()
    {
        $this->post('/api/auth/login', [
            'nomor' => '152022001',
            'password' => 'admin123'
        ]);
    }
}