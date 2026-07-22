<?php

namespace Tests\App\Controllers;

require_once __DIR__ . '/BaseSecurityTest.php';

class DosenSecurityTest extends BaseSecurityTest
{
    public function testDosenRoutesRejectSqlInjection()
    {
        $session = $this->getSessionForRole(3); // Dosen

        foreach ($this->getSqliPayloads() as $payload) {
            // Test 1: Update Proyek Riset
            $response = $this->withSession($session)
                             ->post('/proyek-riset/update/' . $payload, [
                                 'judul' => 'Valid Title'
                             ]);
            
            $response->assertStatus(400); // Bad Request jika id bukan integer
            
            // Test 2: Delete Proyek Riset
            $response = $this->withSession($session)
                             ->post('/proyek-riset/delete/' . $payload);
            $response->assertStatus(400);
        }
    }

    public function testDosenRoutesNeutralizeXss()
    {
        $session = $this->getSessionForRole(3);

        foreach ($this->getXssPayloads() as $payload) {
            // Test input XSS pada judul proyek
            $response = $this->withSession($session)
                             ->post('/proyek-riset/store', [
                                 'judul' => $payload,
                                 'deskripsi' => 'Aman',
                                 'tanggal_mulai' => date('Y-m-d'),
                                 'id_user' => 3
                             ]);
            
            $response->assertRedirect();
            
            // Cek di DB
            $this->seeInDatabase('proyek_riset', ['judul' => $payload]);

            // Cek tampilan (Read)
            $viewResponse = $this->withSession($session)->get('/penelitian-proyek_admin');
            
            $viewResponse->assertDontSee($payload, false);
            $viewResponse->assertSee(esc($payload), false);
        }
    }
}
