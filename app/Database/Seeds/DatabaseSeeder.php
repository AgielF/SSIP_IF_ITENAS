<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('RolesSeeder');
        $this->call('UsersSeeder');
        $this->call('EventsSeeder');
        $this->call('JadwalSeeder');
        $this->call('AsistenJadwalSeeder');
        $this->call('PraktikumSeeder');
        $this->call('RekrutSeeder');
        $this->call('ProyekRisetSeeder');
        $this->call('BeritaSeeder');
        $this->call('GaleriUmumSeeder');
        $this->call('ModulPraktikumSeeder');
        $this->call('PesertaPraktikumSeeder');
        $this->call('VisiMisiSeeder'); 
        $this->call('PublikasiSeeder');
    }
}