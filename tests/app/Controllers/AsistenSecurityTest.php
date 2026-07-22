<?php

namespace Tests\App\Controllers;

require_once __DIR__ . '/BaseSecurityTest.php';

class AsistenSecurityTest extends BaseSecurityTest
{
    public function testAsistenRoutesRejectSqlInjection()
    {
        $session = $this->getSessionForRole(2); // Asisten

        foreach ($this->getSqliPayloads() as $payload) {
            // Test 1: Update Jadwal (SQLi on ID)
            $response = $this->withSession($session)
                             ->post('/jadwal/update/' . $payload, [
                                 'id_ruangan' => 1,
                                 'id_event' => 1
                             ]);
            
            // Asalkan tidak HTTP 500 (Server Error)
            $response->assertStatus(400); 
            
            // Test 2: Delete Jadwal
            $response = $this->withSession($session)
                             ->post('/jadwal/delete/' . $payload);
            $response->assertStatus(400);
        }
    }

    public function testAsistenRoutesNeutralizeXss()
    {
        $session = $this->getSessionForRole(2);

        foreach ($this->getXssPayloads() as $payload) {
            // Jadwal tidak punya field input teks murni yang raw (biasanya time, fk),
            // tapi misal ada field kelas yang ditambahkan di form.
            $response = $this->withSession($session)
                             ->post('/jadwal/store', [
                                 'id_event' => 1,
                                 'id_ruangan' => 1,
                                 'tanggal' => date('Y-m-d'),
                                 'waktu_mulai' => '08:00',
                                 'waktu_selesai' => '10:00',
                                 'kelas' => $payload // Injecting XSS here
                             ]);
            
            $response->assertRedirect();
            
            // Cek di tampilan jadwal
            $viewResponse = $this->withSession($session)->get('/jadwal_admin');
            
            $viewResponse->assertDontSee($payload, false);
            $viewResponse->assertSee(esc($payload), false);
        }
    }
}
