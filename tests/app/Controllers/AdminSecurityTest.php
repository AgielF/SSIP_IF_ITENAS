<?php

namespace Tests\App\Controllers;

require_once __DIR__ . '/BaseSecurityTest.php';

class AdminSecurityTest extends BaseSecurityTest
{
    /**
     * TAHAP 1: UJI COBA SQL INJECTION (SQLi)
     * Mengirim payload SQLi ke berbagai titik krusial admin untuk memastikan Query Builder aman.
     */
    public function testAdminRoutesRejectSqlInjection()
    {
        $session = $this->getSessionForRole(1); // Admin

        foreach ($this->getSqliPayloads() as $payload) {
            // Test 1: Update Profil (Mass Assignment / SQLi on ID)
            $response = $this->withSession($session)
                             ->post('/admin/users/update/' . $payload, [
                                 'nama' => 'Hacked Name',
                                 'role_id' => 1
                             ]);
            
            // Should not return 500. Usually CI4 returns 400, 404, or handles it as invalid int
            $response->assertStatus(400); // Atau status apa pun selain 500 (Server Error)
            
            // Test 2: Delete Users (SQLi on ID)
            $response = $this->withSession($session)
                             ->post('/admin/users/delete/' . $payload);
            $response->assertStatus(400);

            // Test 3: SQLi on POST payload data (Create User)
            $response = $this->withSession($session)
                             ->post('/admin/users/create', [
                                 'nomor'    => $payload,
                                 'nama'     => $payload,
                                 'password' => 'password123',
                                 'role_id'  => 4
                             ]);
            
            // Validation should fail, not DB error. So expecting 400 Bad Request / Validation fail
            $response->assertStatus(400);
        }
    }

    /**
     * TAHAP 2: UJI COBA XSS (STORED XSS)
     * Memastikan payload XSS di escape saat ditampilkan.
     */
    public function testAdminRoutesNeutralizeXss()
    {
        $session = $this->getSessionForRole(1); // Admin

        foreach ($this->getXssPayloads() as $payload) {
            // Insert data with XSS payload
            $response = $this->withSession($session)
                             ->post('/periode_admin/store', [
                                 'nama_periode' => $payload,
                                 'status' => 'Aktif'
                             ]);
            
            // Seharusnya sukses disimpan, tapi saat dirender harus escaped
            $response->assertRedirect();
            
            // Cek di DB (tabel periode)
            $this->seeInDatabase('periode', ['nama_periode' => $payload]);

            // Cek di tampilan list (Read)
            $viewResponse = $this->withSession($session)->get('/periode_admin');
            
            // Pastikan payload murni TIDAK ada di response (menandakan tidak dieksekusi)
            $viewResponse->assertDontSee($payload, false);
            
            // Pastikan versi escaped ada
            $viewResponse->assertSee(esc($payload), false);
        }
    }

    /**
     * TAHAP 3: UJI COBA CRUD NORMAL (Fungsionalitas Aman)
     */
    public function testAdminCanPerformNormalCrud()
    {
        $session = $this->getSessionForRole(1);

        // CREATE Periode
        $response = $this->withSession($session)->post('/periode_admin/store', [
            'nama_periode' => 'Genap 2026',
            'status' => 'Aktif'
        ]);
        $response->assertRedirect();
        $this->seeInDatabase('periode', ['nama_periode' => 'Genap 2026']);

        // CREATE Ruangan
        $response = $this->withSession($session)->post('/admin/ruangan/create', [
            'nama_ruangan' => 'Lab Basis Data'
        ]);
        // Sesuai route admin/ruangan/create
        $response->assertStatus(201); // AdminApi biasanya API JSON return
        $this->seeInDatabase('ruangan', ['nama_ruangan' => 'Lab Basis Data']);
    }
}
