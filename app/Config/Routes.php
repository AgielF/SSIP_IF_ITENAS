<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Rekomendasi untuk konsistensi
$routes->get('/', 'Home::index');

$routes->get('/agenda', 'Home::agenda');
$routes->get('/visi-misi', 'Home::visi_misi');

$routes->get('/asisten', 'Home::asisten');
$routes->get('/asisten_admin', 'Home::asisten_admin');

$routes->get('/jadwal', 'Home::jadwal');
$routes->get('/jadwal-list', 'Home::jadwal_card');
$routes->get('/jadwal_admin', 'Home::jadwal_admin');

$routes->get('/penelitian-proyek', 'Home::penelitian_proyek');
$routes->get('/penelitian-proyek_admin', 'Home::penelitian_proyek_admin');

$routes->get('/publikasi-ilmiah', 'Home::publikasi_ilmiah');
$routes->get('/publikasi-ilmiah_admin', 'Home::publikasi_ilmiah_admin');

$routes->get('/galeri', 'Home::galeri');
$routes->get('/galeri_admin', 'Home::galeri_admin');

$routes->get('/repositori', 'Home::repositori');
$routes->get('/repositori_admin','Home::repositori_admin');

$routes->get('/rekrutmen', 'Home::rekrutmen');
$routes->get('/rekrutmen_admin','Home::rekrutmen_admin');

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

// Admin CRUD route web
// 1. Rekrutmen
$routes->get('/admin/rekrut', 'Admin\Rekrut::index');
$routes->get('/admin/rekrut/new', 'Admin\Rekrut::new');
$routes->post('/admin/rekrut/create', 'Admin\Rekrut::create');
$routes->post('/admin/rekrut/edit/(:num)', 'Admin\Rekrut::edit/$1');
$routes->put('/admin/rekrut/update/(:num)', 'Admin\Rekrut::update/$1');
$routes->delete('/admin/rekrut/delete/(:num)', 'Admin\Rekrut::delete/$1');

// 2.Proyek Riset
$routes->get('/admin/proyek-riset', 'Admin\ProyekRiset::index');
$routes->get('/admin/proyek-riset/new', 'Admin\ProyekRiset::new');
$routes->post('/admin/proyek-riset/create', 'Admin\ProyekRiset::create');
$routes->post('/admin/proyek-riset/edit/(:num)', 'Admin\ProyekRiset::edit/$1');
$routes->put('/admin/proyek-riset/update/(:num)', 'Admin\ProyekRiset::update/$1');
$routes->delete('/admin/proyek-riset/delete/(:num)', 'Admin\ProyekRiset::delete/$1');

// 3. Publikasi Ilmiah
$routes->get('/admin/publikasi-ilmiah', 'Admin\PublikasiIlmiah::index');
$routes->get('/admin/publikasi-ilmiah/new', 'Admin\PublikasiIlmiah::new');
$routes->post('/admin/publikasi-ilmiah/create', 'Admin\PublikasiIlmiah::create');
$routes->post('/admin/publikasi-ilmiah/edit/(:num)', 'Admin\PublikasiIlmiah::edit/$1');
$routes->put('/admin/publikasi-ilmiah/update/(:num)', 'Admin\PublikasiIlmiah::update/$1');
$routes->delete('/admin/publikasi-ilmiah/delete/(:num)', 'Admin\PublikasiIlmiah::delete/$1');

// 4. Galeri
$routes->get('/admin/galeri', 'Admin\Galeri::index');
$routes->get('/admin/galeri/new', 'Admin\Galeri::new');
$routes->post('/admin/galeri/create', 'Admin\Galeri::create');
$routes->post('/admin/galeri/edit/(:num)', 'Admin\Galeri::edit/$1');
$routes->put('/admin/galeri/update/(:num)', 'Admin\Galeri::update/$1');
$routes->delete('/admin/galeri/delete/(:num)', 'Admin\Galeri::delete/$1');

// 5. Visi Misi
$routes->get('/admin/visi-misi', 'Admin\VisiMisi::index');
$routes->get('/admin/visi-misi/edit', 'Admin\VisiMisi::edit');
$routes->put('/admin/visi-misi/update', 'Admin\VisiMisi::update');
$routes->delete('/admin/visi-misi/delete', 'Admin\VisiMisi::delete');

// 6. Jadwal
$routes->get('/admin/jadwal', 'Admin\Jadwal::index');
$routes->get('/admin/jadwal/new', 'Admin\Jadwal::new');
$routes->post('/admin/jadwal/create', 'Admin\Jadwal::create');
$routes->post('/admin/jadwal/edit/(:num)', 'Admin\Jadwal::edit/$1');
$routes->put('/admin/jadwal/update/(:num)', 'Admin\Jadwal::update/$1');
$routes->delete('/admin/jadwal/delete/(:num)', 'Admin\Jadwal::delete/$1');

// 7. Asisten Jadwal
$routes->get('/admin/asisten-jadwal', 'Admin\AsistenJadwal::index');
$routes->get('/admin/asisten-jadwal/new', 'Admin\AsistenJadwal::new');
$routes->post('/admin/asisten-jadwal/create', 'Admin\AsistenJadwal::create');
$routes->post('/admin/asisten-jadwal/edit/(:num)', 'Admin\AsistenJadwal::edit/$1');
$routes->put('/admin/asisten-jadwal/update/(:num)', 'Admin\AsistenJadwal::update/$1');
$routes->delete('/admin/asisten-jadwal/delete/(:num)', 'Admin\AsistenJadwal::delete/$1');

// 8. Peserta Praktikum
$routes->get('/admin/peserta-praktikum', 'Admin\PesertaPraktikum::index');
$routes->get('/admin/peserta-praktikum/new', 'Admin\PesertaPraktikum::new');
$routes->post('/admin/peserta-praktikum/create', 'Admin\PesertaPraktikum::create');
$routes->post('/admin/peserta-praktikum/edit/(:num)', 'Admin\PesertaPraktikum::edit/$1');
$routes->put('/admin/peserta-praktikum/update/(:num)', 'Admin\PesertaPraktikum::update/$1');
$routes->delete('/admin/peserta-praktikum/delete/(:num)', 'Admin\PesertaPraktikum::delete/$1');

// 9. User Management
$routes->get('/admin/user-management', 'Admin\UserManagement::index');
$routes->get('/admin/user-management/new', 'Admin\UserManagement::new');
$routes->post('/admin/user-management/create', 'Admin\UserManagement::create');
$routes->post('/admin/user-management/edit/(:num)', 'Admin\UserManagement::edit/$1');
$routes->put('/admin/user-management/update/(:num)', 'Admin\UserManagement::update/$1');
$routes->delete('/admin/user-management/delete/(:num)', 'Admin\UserManagement::delete/$1');

// 10. Berita
$routes->get('/admin/berita', 'Admin\Berita::index');
$routes->get('/admin/berita/new', 'Admin\Berita::new');
$routes->post('/admin/berita/create', 'Admin\Berita::create');
$routes->post('/admin/berita/edit/(:num)', 'Admin\Berita::edit/$1');
$routes->put('/admin/berita/update/(:num)', 'Admin\Berita::update/$1');
$routes->delete('/admin/berita/delete/(:num)', 'Admin\Berita::delete/$1');

// 11. Praktikum
$routes->get('/admin/praktikum', 'Admin\Praktikum::index');
$routes->get('/admin/praktikum/new', 'Admin\Praktikum::new');
$routes->post('/admin/praktikum/create', 'Admin\Praktikum::create');
$routes->post('/admin/praktikum/edit/(:num)', 'Admin\Praktikum::edit/$1');
$routes->put('/admin/praktikum/update/(:num)', 'Admin\Praktikum::update/$1');
$routes->delete('/admin/praktikum/delete/(:num)', 'Admin\Praktikum::delete/$1');

// 12. Modul Praktikum
$routes->get('/admin/modul-praktikum', 'Admin\ModulPraktikum::index');
$routes->get('/admin/modul-praktikum/new', 'Admin\ModulPraktikum::new');
$routes->post('/admin/modul-praktikum/create', 'Admin\ModulPraktikum::create');
$routes->post('/admin/modul-praktikum/edit/(:num)', 'Admin\ModulPraktikum::edit/$1');
$routes->put('/admin/modul-praktikum/update/(:num)', 'Admin\ModulPraktikum::update/$1');
$routes->delete('/admin/modul-praktikum/delete/(:num)', 'Admin\ModulPraktikum::delete/$1');

// 13. Events
$routes->get('/admin/events', 'Admin\Events::index');
$routes->get('/admin/events/new', 'Admin\Events::new');
$routes->post('/admin/events/create', 'Admin\Events::create');
$routes->post('/admin/events/edit/(:num)', 'Admin\Events::edit/$1');
$routes->put('/admin/events/update/(:num)', 'Admin\Events::update/$1');
$routes->delete('/admin/events/delete/(:num)', 'Admin\Events::delete/$1');


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