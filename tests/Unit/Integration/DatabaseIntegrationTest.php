<?php
namespace Tests\Integration;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

class DatabaseIntegrationTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate = true;
    protected $seed = 'Tests\Support\Database\Seeds\DatabaseSeeder';

    public function testAllTablesExist()
    {
        $expectedTables = [
            'roles', 'users', 'events', 'jadwal', 'asisten_jadwal',
            'publikasi', 'praktikum', 'rekrut', 'proyek_riset',
            'berita', 'galeri_umum', 'modul_praktikum', 'peserta_praktikum'
        ];

        foreach ($expectedTables as $table) {
            $this->assertTrue(
                $this->db->tableExists($table),
                "Table {$table} should exist in database"
            );
        }
    }

    public function testForeignKeyRelationships()
    {
        // Test: User memiliki role yang valid
        $userModel = new \App\Models\UserModel();
        $users = $userModel->findAll();

        foreach ($users as $user) {
            $roleModel = new \App\Models\RoleModel();
            $role = $roleModel->find($user['role_id']);

            $this->assertNotNull($role, "User {$user['nama']} should have valid role");
        }
    }

    public function testSeedDataIntegrity()
    {
        // Test: Admin user ada
        $userModel = new \App\Models\UserModel();
        $admin = $userModel->where('nomor', '152022001')->first();

        $this->assertNotNull($admin, 'Admin user should exist');
        $this->assertEquals(1, $admin['role_id'], 'Admin should have role_id = 1');

        // Test: Roles lengkap
        $roleModel = new \App\Models\RoleModel();
        $roles = $roleModel->findAll();

        $this->assertCount(4, $roles, 'Should have 4 roles');

        $roleNames = array_column($roles, 'role_name');
        $this->assertContains('admin', $roleNames, 'Should have admin role');
        $this->assertContains('asisten', $roleNames, 'Should have asisten role');
        $this->assertContains('mahasiswa', $roleNames, 'Should have mahasiswa role');
        $this->assertContains('dosen', $roleNames, 'Should have dosen role');
    }
}