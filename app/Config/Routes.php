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

// Authentication API routes
$routes->group('api/auth', ['namespace' => 'App\Controllers\Api'], function($routes) {
    $routes->post('login', 'Auth::login');
    $routes->get('profile', 'Auth::profile');
});

// UI untuk login & profile
$routes->get('login', 'AuthUi::login');
$routes->get('profile', 'AuthUi::profile');

// routes khusus admin, dilindungi filter admin
$routes->group('', ['filter' => 'admin'], function($routes) {
    $routes->get('/asisten_admin', 'Admin\Users::asistenAdmin');
    $routes->get('/jadwal_admin', 'Home::jadwal_admin');
    $routes->get('/penelitian-proyek_admin', 'ProyekRisetController::getDataAdmin');
    $routes->get('/publikasi-ilmiah_admin', 'Admin\Publikasi::index');
    $routes->get('/galeri_admin', 'GaleriUmumController::getDataAdmin');
    $routes->get('/repositori_admin','Home::repositori_admin');
    $routes->get('/rekrutmen_admin','RekrutController::admin');

    // Admin CRUD routes for API calls (protected by admin filter)
    $routes->post('/admin/publikasi-ilmiah/create', 'Admin\Publikasi::create');
    $routes->post('/admin/publikasi-ilmiah/update/(:num)', 'Admin\Publikasi::update/$1');
    $routes->post('/admin/publikasi-ilmiah/delete/(:num)', 'Admin\Publikasi::delete/$1');

    // User management routes
    $routes->get('/admin/users', 'Admin\Users::index');
    $routes->get('/admin/users/new', 'Admin\Users::new');
    $routes->post('/admin/users/create', 'Admin\Users::create');
    $routes->post('/admin/users/edit/(:num)', 'Admin\Users::edit/$1');
    $routes->post('/admin/users/update/(:num)', 'Admin\Users::update/$1');
    $routes->post('/admin/users/delete/(:num)', 'Admin\Users::delete/$1');
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

// API Admin Routes  
$routes->group('api/admin', ['namespace' => 'App\Controllers\Api'], function($routes) {
    // Rekrutmen API
    $routes->get('rekrutmen', 'AdminApi::getRekrutmen');
    $routes->post('rekrutmen', 'AdminApi::createRekrutmen');
    $routes->put('rekrutmen/(:num)', 'AdminApi::updateRekrutmen/$1');
    $routes->delete('rekrutmen/(:num)', 'AdminApi::deleteRekrutmen/$1');
    
    // Proyek Riset API
    $routes->get('proyek-riset', 'AdminApi::getProyekRiset');
    $routes->post('proyek-riset', 'AdminApi::createProyekRiset');
    $routes->put('proyek-riset/(:num)', 'AdminApi::updateProyekRiset/$1');
    $routes->delete('proyek-riset/(:num)', 'AdminApi::deleteProyekRiset/$1');
    
    // Publikasi Ilmiah API
    $routes->get('publikasi', 'AdminApi::getPublikasi');
    $routes->post('publikasi', 'AdminApi::createPublikasi');
    $routes->put('publikasi/(:num)', 'AdminApi::updatePublikasi/$1');
    $routes->delete('publikasi/(:num)', 'AdminApi::deletePublikasi/$1');
    
    // Galeri API
    $routes->get('galeri', 'AdminApi::getGaleri');
    $routes->post('galeri', 'AdminApi::createGaleri');
    $routes->put('galeri/(:num)', 'AdminApi::updateGaleri/$1');
    $routes->delete('galeri/(:num)', 'AdminApi::deleteGaleri/$1');
    
    // Visi Misi API
    $routes->get('visi-misi', 'AdminApi::getVisiMisi');
    $routes->put('visi-misi/(:num)', 'AdminApi::updateVisiMisi/$1');
    
    // Jadwal API
    $routes->get('jadwal', 'AdminApi::getJadwal');
    $routes->post('jadwal', 'AdminApi::createJadwal');
    $routes->put('jadwal/(:num)', 'AdminApi::updateJadwal/$1');
    $routes->delete('jadwal/(:num)', 'AdminApi::deleteJadwal/$1');
    
    // Asisten Jadwal API
    $routes->get('asisten-jadwal', 'AdminApi::getAsistenJadwal');
    $routes->post('asisten-jadwal', 'AdminApi::createAsistenJadwal');
    $routes->put('asisten-jadwal/(:num)', 'AdminApi::updateAsistenJadwal/$1');
    $routes->delete('asisten-jadwal/(:num)', 'AdminApi::deleteAsistenJadwal/$1');
    
    // Peserta Praktikum API
    $routes->get('peserta-praktikum', 'AdminApi::getPesertaPraktikum');
    $routes->post('peserta-praktikum', 'AdminApi::createPesertaPraktikum');
    $routes->put('peserta-praktikum/(:num)', 'AdminApi::updatePesertaPraktikum/$1');
    $routes->delete('peserta-praktikum/(:num)', 'AdminApi::deletePesertaPraktikum/$1');
    
    // User Management API
    $routes->get('users', 'AdminApi::getUsers');
    $routes->post('users', 'AdminApi::createUser');
    $routes->put('users/(:num)', 'AdminApi::updateUser/$1');
    $routes->delete('users/(:num)', 'AdminApi::deleteUser/$1');
    
    // Berita API
    $routes->get('berita', 'AdminApi::getBerita');
    $routes->post('berita', 'AdminApi::createBerita');
    $routes->put('berita/(:num)', 'AdminApi::updateBerita/$1');
    $routes->delete('berita/(:num)', 'AdminApi::deleteBerita/$1');
    
    // Praktikum API
    $routes->get('praktikum', 'AdminApi::getPraktikum');
    $routes->post('praktikum', 'AdminApi::createPraktikum');
    $routes->put('praktikum/(:num)', 'AdminApi::updatePraktikum/$1');
    $routes->delete('praktikum/(:num)', 'AdminApi::deletePraktikum/$1');
    
    // Modul Praktikum API
    $routes->get('modul-praktikum', 'AdminApi::getModulPraktikum');
    $routes->post('modul-praktikum', 'AdminApi::createModulPraktikum');
    $routes->put('modul-praktikum/(:num)', 'AdminApi::updateModulPraktikum/$1');
    $routes->delete('modul-praktikum/(:num)', 'AdminApi::deleteModulPraktikum/$1');
    
    // Events API
    $routes->get('events', 'AdminApi::getEvents');
    $routes->post('events', 'AdminApi::createEvent');
    $routes->put('events/(:num)', 'AdminApi::updateEvent/$1');
    $routes->delete('events/(:num)', 'AdminApi::deleteEvent/$1');
});