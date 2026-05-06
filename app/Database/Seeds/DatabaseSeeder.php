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
    $this->call('PeriodeSeeder'); // Naikkan ke atas
    // $this->call('SetPeriodeAwal'); // Jika dipakai, taruh di area master
    
    // --- 2. TABEL TRANSAKSI / MASTER KEDUA ---
    $this->call('EventsSeeder');
    $this->call('JadwalSeeder');
    $this->call('PraktikumSeeder');
    $this->call('BeritaSeeder');
    $this->call('GaleriUmumSeeder');
    $this->call('ModulPraktikumSeeder');
    $this->call('VisiMisiSeeder');
    $this->call('PublikasiSeeder');
    $this->call('ProjectLabSeeder');
    $this->call('ProyekRisetSeeder');
    $this->call('RekrutSeeder');
    $this->call('AsistenSeeder'); // Huruf A kapital

    // --- 3. TABEL RELASI (Anak) ---
    // Pastikan tabel relasi di paling bawah agar induknya sudah terbuat semua
    $this->call('PesertaPraktikumSeeder');
    $this->call('AsistenPeriodeSeeder');
    $this->call('AsistenJadwalSeeder');
}
}