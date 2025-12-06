<?php

namespace Tests\Support\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Call the main application seeders
        $this->call('App\Database\Seeds\RolesSeeder');
        $this->call('App\Database\Seeds\UsersSeeder');
        $this->call('App\Database\Seeds\EventsSeeder');
        $this->call('App\Database\Seeds\JadwalSeeder');
        $this->call('App\Database\Seeds\AsistenJadwalSeeder');
        $this->call('App\Database\Seeds\PublikasiSeeder');
        $this->call('App\Database\Seeds\PraktikumSeeder');
        $this->call('App\Database\Seeds\RekrutSeeder');
        $this->call('App\Database\Seeds\ProyekRisetSeeder');
        $this->call('App\Database\Seeds\BeritaSeeder');
        $this->call('App\Database\Seeds\GaleriUmumSeeder');
        $this->call('App\Database\Seeds\ModulPraktikumSeeder');
        $this->call('App\Database\Seeds\PesertaPraktikumSeeder');
        $this->call('App\Database\Seeds\VisiMisiSeeder');
    }
}