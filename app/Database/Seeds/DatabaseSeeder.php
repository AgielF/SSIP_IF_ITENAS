<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // --- 1. TABEL MASTER (Induk) ---
        $this->call('RolesSeeder');
        $this->call('UsersSeeder');
        $this->call('PeriodeSeeder'); 
        $this->call('RuanganSeeder'); // Pindahkan ke sini (sebelum jadwal)
        
        // --- 2. TABEL TRANSAKSI / MASTER KEDUA ---
        $this->call('EventsSeeder');
        $this->call('JadwalSeeder'); // Sekarang jadwal bisa mengambil id_ruangan
        $this->call('PraktikumSeeder');
        $this->call('BeritaSeeder');
        $this->call('GaleriUmumSeeder');
        $this->call('ModulPraktikumSeeder');
        $this->call('VisiMisiSeeder');
        $this->call('PublikasiSeeder');
        $this->call('ProjectLabSeeder');
        $this->call('ProyekRisetSeeder');
        $this->call('RekrutSeeder');
        $this->call('AsistenSeeder'); 

        // --- 3. TABEL RELASI (Anak) ---
        $this->call('PesertaPraktikumSeeder');
        $this->call('AsistenPeriodeSeeder');
        $this->call('AsistenJadwalSeeder');

        // --- 4. KONFIGURASI SISTEM ---
        $this->call('ConfigSertifikatSeeder');
    }
}