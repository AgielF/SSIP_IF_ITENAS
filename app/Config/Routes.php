<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Rekomendasi untuk konsistensi
$routes->get('/', 'Home::index');
$routes->get('/agenda', 'Home::agenda');
$routes->get('/agenda_paginated', 'Home::agenda_paginated');
$routes->get('/visi-misi', 'Home::visi_misi');
$routes->get('/asisten', 'UserController::index');
$routes->get('/jadwal', 'Home::jadwal');
$routes->get('/jadwal-list', 'Home::jadwal');
$routes->get('/penelitian-proyek', 'ProyekRisetController::index');
$routes->get('/publikasi-ilmiah', 'PublikasiController::index');
$routes->get('/galeri', 'GaleriUmumController::index');
$routes->get('/repositori', 'Home::repositori');
$routes->get('/rekrutmen', 'RekrutController::index');

$routes->get('/modul_praktikum', 'modulPraktikumController::index');

// $routes->get('/user_profile', 'Home::user_profile');
$routes->get('/topic_detail/(:segment)', 'TopicController::detail/$1');

// Rute untuk Penelitian & Proyek
$routes->get('/penelitian/(:segment)', 'TopicController::detail/$1');
$routes->get('/asisten/(:num)', 'UserController::profil/$1');

// routes API Content
$routes->get('/api/visi-misi', 'Api\Content::visiMisi');
$routes->get('/api/proyek-riset', 'Api\Content::proyekRiset');
$routes->get('/api/publikasi', 'Api\Content::publikasi');
$routes->get('/api/galeri', 'Api\Content::galeri');
$routes->get('/api/rekrutmen', 'Api\Content::rekrutmen');
$routes->get('/api/berita', 'Api\Content::berita');
$routes->get('/api/events', 'Api\Content::events');
$routes->get('/api/agenda', 'Api\Content::agenda');
$routes->get('/api/asisten', 'Api\Content::asisten');
$routes->get('/api/asisten-admin', 'Api\Content::asistenAdmin');
$routes->get('/api/jadwal', 'Api\Content::jadwal');
$routes->get('/api/jadwal-list', 'Api\Content::jadwalCard');
$routes->get('/api/penelitian-proyek', 'Api\Content::penelitianProyek');
$routes->get('/api/repositori', 'Api\Content::repositoriPage');
$routes->get('/api/rekrutmen-page', 'Api\Content::rekrutmenPage');
$routes->get('/api/publikasi-page', 'Api\Content::publikasiPage');
$routes->get('/api/peserta-praktikum', 'Api\Content::pesertaPraktikum');

// Admin API routes
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {
    $routes->get('asisten-jadwal', 'AdminApi::getAsistenJadwal');
    $routes->post('asisten-jadwal/create', 'AdminApi::createAsistenJadwal');
    $routes->post('asisten-jadwal/update/(:num)', 'AdminApi::updateAsistenJadwal/$1');
    $routes->post('asisten-jadwal/delete/(:num)', 'AdminApi::deleteAsistenJadwal/$1');
});

// Authentication API routes
$routes->group('api/auth', ['namespace' => 'App\Controllers\Api'], function($routes) {
    $routes->post('login', 'Auth::login');
    $routes->get('profile', 'Auth::profile');
   
});

// UI untuk login & profile
$routes->get('login', 'AuthUi::login');
// Profile butuh login
$routes->get('profile', 'AuthUi::profile', ['filter' => 'auth']);
$routes->get('logout', 'AuthUi::logout');   // 👈 tambahkan ini

// routes khusus admin, dilindungi filter admin
$routes->group('', ['filter' => 'admin'], function($routes) {
    $routes->get('/asisten_admin', 'Admin\Users::asistenAdmin');
    $routes->get('/jadwal_admin', 'Home::jadwal_admin');
    $routes->get('/penelitian-proyek_admin', 'ProyekRisetController::getDataAdmin');
    $routes->get('/publikasi-ilmiah_admin', 'Admin\Publikasi::index');
    $routes->get('/galeri_admin', 'GaleriUmumController::getDataAdmin');
    $routes->get('/repositori_admin','Home::repositori_admin');
    $routes->get('/rekrutmen_admin','RekrutController::admin');

    // Publikasi routes
    $routes->get('/admin/publikasi-ilmiah/new', 'Admin\Publikasi::new');
    $routes->get('/admin/publikasi-ilmiah/edit/(:num)', 'Admin\Publikasi::edit/$1');
    $routes->post('/admin/publikasi-ilmiah/create', 'Admin\Publikasi::create');
    $routes->post('/admin/publikasi-ilmiah/update/(:num)', 'Admin\Publikasi::update/$1');
    $routes->post('/admin/publikasi-ilmiah/delete/(:num)', 'Admin\Publikasi::delete/$1');

    // User management routes
    $routes->get('/admin/users', 'Admin\Users::index');
    $routes->get('/admin/users/new', 'Admin\Users::new');
    $routes->post('/admin/users/create', 'Admin\Users::create');
    $routes->get('/admin/users/edit/(:num)', 'Admin\Users::edit/$1');
    $routes->post('/admin/users/update/(:num)', 'Admin\Users::update/$1');
    $routes->post('/admin/users/delete/(:num)', 'Admin\Users::delete/$1');

    // Publikasi routes
    $routes->get('/admin/publikasi-ilmiah/new', 'Admin\Publikasi::new');
    $routes->get('/admin/publikasi-ilmiah/edit/(:num)', 'Admin\Publikasi::edit/$1');

    // Rekrutmen routes
    $routes->get('/admin/rekrutmen', 'Admin\Rekrut::index');
    $routes->get('/admin/rekrutmen/new', 'Admin\Rekrut::new');
    $routes->post('/admin/rekrutmen/create', 'Admin\Rekrut::create');
    $routes->get('/admin/rekrutmen/edit/(:num)', 'Admin\Rekrut::edit/$1');
    $routes->post('/admin/rekrutmen/update/(:num)', 'Admin\Rekrut::update/$1');
    $routes->post('/admin/rekrutmen/delete/(:num)', 'Admin\Rekrut::delete/$1');

    // Proyek Riset routes
    $routes->get('/admin/proyek-riset', 'Admin\ProyekRiset::index');
    $routes->get('/admin/proyek-riset/new', 'Admin\ProyekRiset::new');
    $routes->post('/admin/proyek-riset/create', 'Admin\ProyekRiset::create');
    $routes->get('/admin/proyek-riset/edit/(:num)', 'Admin\ProyekRiset::edit/$1');
    $routes->post('/admin/proyek-riset/update/(:num)', 'Admin\ProyekRiset::update/$1');
    $routes->post('/admin/proyek-riset/delete/(:num)', 'Admin\ProyekRiset::delete/$1');

    // Galeri routes
    $routes->get('/admin/galeri', 'Admin\GaleriUmum::index');
    $routes->get('/admin/galeri/new', 'Admin\GaleriUmum::new');
    $routes->post('/admin/galeri/create', 'Admin\GaleriUmum::create');
    $routes->get('/admin/galeri/edit/(:num)', 'Admin\GaleriUmum::edit/$1');
    $routes->post('/admin/galeri/update/(:num)', 'Admin\GaleriUmum::update/$1');
    $routes->post('/admin/galeri/delete/(:num)', 'Admin\GaleriUmum::delete/$1');

    // Jadwal routes
    $routes->get('/admin/jadwal', 'Admin\Jadwal::index');
    $routes->get('/admin/jadwal/new', 'Admin\Jadwal::new');
    $routes->post('/admin/jadwal/create', 'Admin\Jadwal::create');
    $routes->get('/admin/jadwal/edit/(:num)', 'Admin\Jadwal::edit/$1');
    $routes->post('/admin/jadwal/update/(:num)', 'Admin\Jadwal::update/$1');
    $routes->post('/admin/jadwal/delete/(:num)', 'Admin\Jadwal::delete/$1');

    // Asisten Jadwal routes
    $routes->get('/admin/asisten-jadwal', 'Admin\AsistenJadwal::index');
    $routes->get('/admin/asisten-jadwal/new', 'Admin\AsistenJadwal::new');
    $routes->post('/admin/asisten-jadwal/create', 'Admin\AsistenJadwal::create');
    $routes->get('/admin/asisten-jadwal/edit/(:num)', 'Admin\AsistenJadwal::edit/$1');
    $routes->post('/admin/asisten-jadwal/update/(:num)', 'Admin\AsistenJadwal::update/$1');
    $routes->post('/admin/asisten-jadwal/delete/(:num)', 'Admin\AsistenJadwal::delete/$1');

    // Peserta Praktikum routes
    $routes->get('/admin/peserta-praktikum', 'Admin\PesertaPraktikum::index');
    $routes->get('/admin/peserta-praktikum/new', 'Admin\PesertaPraktikum::new');
    $routes->post('/admin/peserta-praktikum/create', 'Admin\PesertaPraktikum::create');
    $routes->get('/admin/peserta-praktikum/edit/(:num)', 'Admin\PesertaPraktikum::edit/$1');
    $routes->post('/admin/peserta-praktikum/update/(:num)', 'Admin\PesertaPraktikum::update/$1');
    $routes->post('/admin/peserta-praktikum/delete/(:num)', 'Admin\PesertaPraktikum::delete/$1');

    // Berita routes
    $routes->get('/admin/berita', 'Admin\Berita::index');
    $routes->get('/admin/berita/new', 'Admin\Berita::new');
    $routes->post('/admin/berita/create', 'Admin\Berita::create');
    $routes->get('/admin/berita/edit/(:num)', 'Admin\Berita::edit/$1');
    $routes->post('/admin/berita/update/(:num)', 'Admin\Berita::update/$1');
    $routes->post('/admin/berita/delete/(:num)', 'Admin\Berita::delete/$1');

    // Praktikum routes
    $routes->get('/admin/praktikum', 'Admin\Praktikum::index');
    $routes->get('/admin/praktikum/new', 'Admin\Praktikum::new');
    $routes->post('/admin/praktikum/create', 'Admin\Praktikum::create');
    $routes->get('/admin/praktikum/edit/(:num)', 'Admin\Praktikum::edit/$1');
    $routes->post('/admin/praktikum/update/(:num)', 'Admin\Praktikum::update/$1');
    $routes->post('/admin/praktikum/delete/(:num)', 'Admin\Praktikum::delete/$1');

    // Modul Praktikum routes
    $routes->get('/admin/modul-praktikum', 'Admin\ModulPraktikum::index');
    $routes->get('/admin/modul-praktikum/new', 'Admin\ModulPraktikum::new');
    $routes->post('/admin/modul-praktikum/create', 'Admin\ModulPraktikum::create');
    $routes->get('/admin/modul-praktikum/edit/(:num)', 'Admin\ModulPraktikum::edit/$1');
    $routes->post('/admin/modul-praktikum/update/(:num)', 'Admin\ModulPraktikum::update/$1');
    $routes->post('/admin/modul-praktikum/delete/(:num)', 'Admin\ModulPraktikum::delete/$1');

    // Events routes
    $routes->get('/admin/events', 'Admin\Events::index');
    $routes->get('/admin/events/new', 'Admin\Events::new');
    $routes->post('/admin/events/create', 'Admin\Events::create');
    $routes->get('/admin/events/edit/(:num)', 'Admin\Events::edit/$1');
    $routes->post('/admin/events/update/(:num)', 'Admin\Events::update/$1');
    $routes->post('/admin/events/delete/(:num)', 'Admin\Events::delete/$1');

    // Roles routes
    $routes->get('/admin/roles', 'Admin\Roles::index');
    $routes->get('/admin/roles/new', 'Admin\Roles::new');
    $routes->post('/admin/roles/create', 'Admin\Roles::create');
    $routes->get('/admin/roles/edit/(:num)', 'Admin\Roles::edit/$1');
    $routes->post('/admin/roles/update/(:num)', 'Admin\Roles::update/$1');
    $routes->post('/admin/roles/delete/(:num)', 'Admin\Roles::delete/$1');

    // Visi Misi routes
    $routes->get('/admin/visi-misi', 'Admin\VisiMisi::index');
    $routes->get('/admin/visi-misi/new', 'Admin\VisiMisi::new');
    $routes->post('/admin/visi-misi/create', 'Admin\VisiMisi::create');
    $routes->get('/admin/visi-misi/edit/(:num)', 'Admin\VisiMisi::edit/$1');
    $routes->post('/admin/visi-misi/update/(:num)', 'Admin\VisiMisi::update/$1');
    $routes->post('/admin/visi-misi/delete/(:num)', 'Admin\VisiMisi::delete/$1');

});

// Admin CRUD route web
$routes->get('/admin/rekrut', function() { return redirect()->to('/rekrutmen_admin'); });
$routes->get('/admin/proyek-riset', function() { return redirect()->to('/penelitian-proyek_admin'); });
$routes->get('/admin/publikasi-ilmiah', function() { return redirect()->to('/publikasi-ilmiah_admin'); });
$routes->get('/admin/galeri', function() { return redirect()->to('/galeri_admin'); });
$routes->get('/admin/visi-misi', function() { return redirect()->to('/visi-misi_admin'); });
$routes->get('/admin/jadwal', function() { return redirect()->to('/jadwal_admin'); });
$routes->get('/admin/asisten-jadwal', function() { return redirect()->to('/asisten_admin'); });
$routes->get('/admin/peserta-praktikum', function() { return redirect()->to('/peserta-praktikum_admin'); });
$routes->get('/admin/berita', function() { return redirect()->to('/berita_admin'); });
$routes->get('/admin/praktikum', function() { return redirect()->to('/praktikum_admin'); });
$routes->get('/admin/modul-praktikum', function() { return redirect()->to('/modul-praktikum_admin'); });
$routes->get('/admin/events', function() { return redirect()->to('/events_admin'); });
