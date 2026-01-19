<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Rekomendasi untuk konsistensi
$routes->get('/', 'Home::index');

$routes->get('/berita', 'beritaController::index');

$routes->get('/asisten', 'UserController::index');

$routes->get('/jadwal', 'JadwalController::index');
$routes->get('/jadwal-praktikum', 'JadwalController::praktikum');
$routes->get('/jadwal-list', 'Home::jadwal_card');

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

$routes->get('/organisasi', 'OrganizationController::index');

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
$routes->get('logout', 'AuthUi::logout');   // tambahkan ini

// routes khusus admin, dilindungi filter admin
$routes->group('', ['filter' => 'admin'], function($routes) {
    $routes->get('/asisten_admin', 'UserController::getDataAdmin');
    $routes->get('/jadwal_admin', 'JadwalController::admin');
    $routes->get('/jadwal/admin', 'JadwalController::admin'); // Alternative route
    $routes->get('/penelitian-proyek_admin', 'ProyekRisetController::getDataAdmin');
    $routes->get('/publikasi-ilmiah_admin', 'PublikasiController::getDataAdmin');
    $routes->get('/galeri_admin', 'GaleriUmumController::admin');
    $routes->get('/repositori_admin','Home::repositori_admin');
    $routes->get('/rekrutmen_admin','RekrutController::admin');
    // $routes->get('/modul_praktikum_admin','modulPraktikumController::admin');
    $routes->get('/berita_admin','beritaController::admin');
    $routes->get('/peserta-praktikum_admin','PesertaPraktikumController::admin');
    $routes->get('/events_admin','EventsController::admin');

    // User management routes
    $routes->get('/admin/users', 'Admin\Users::index');
    $routes->get('/admin/users/new', 'Admin\Users::new');
    $routes->post('/admin/users/create', 'Admin\Users::create');
    $routes->get('/admin/users/edit/(:num)', 'Admin\Users::edit/$1');
    $routes->post('/admin/users/update/(:num)', 'Admin\Users::update/$1');
    $routes->post('/admin/users/delete/(:num)', 'Admin\Users::delete/$1');

});

// Admin (1) dan Asisten (2)
$routes->group('', ['filter' => 'role:1,2'], function($routes) {
    $routes->get('/modul_praktikum_admin','modulPraktikumController::admin');
});




// CRUD action (POST) – tidak perlu filter admin kalau sudah dicek di controller
$routes->post('/rekrutmen/store', 'RekrutController::store');
$routes->post('/rekrutmen/update/(:num)', 'RekrutController::update/$1');
$routes->post('/rekrutmen/delete/(:num)', 'RekrutController::delete/$1');


//CRUD galeri
$routes->post('galeri_admin/store', 'GaleriUmumController::create');
$routes->post('galeri_admin/update/(:num)', 'GaleriUmumController::update/$1');
$routes->get('galeri_admin/delete/(:num)', 'GaleriUmumController::delete/$1');

//CRUD modul
$routes->post('modul-praktikum/create', 'modulPraktikumController::create');
$routes->post('modul-praktikum/update/(:num)', 'modulPraktikumController::update/$1');
$routes->get('modul-praktikum/delete/(:num)', 'modulPraktikumController::delete/$1');


// PENELITIAN PROYEK RISET
// CRUD Proyek Riset (non API style)3e
$routes->post('proyek-riset/store', 'ProyekRisetController::create');
$routes->post('proyek-riset/update/(:num)', 'ProyekRisetController::update/$1');
$routes->get('proyek-riset/delete/(:num)', 'ProyekRisetController::delete/$1');

// Ambil detail satu proyek (edit form)
$routes->get('proyek-riset/(:num)', 'ProyekRisetController::edit/$1');

// Jika mau ambil detail satu proyek
$routes->get('proyek-riset/(:num)', 'ProyekRisetController::edit/$1');


// CRUD
$routes->get('rekrutmen/create', 'RekrutController::create');     // Form tambah
$routes->post('rekrutmen/store', 'RekrutController::store');      // Proses tambah

$routes->get('rekrutmen/edit/(:num)', 'RekrutController::edit/$1');   // Form edit
$routes->post('rekrutmen/update/(:num)', 'RekrutController::update/$1'); // Proses update

$routes->get('rekrutmen/delete/(:num)', 'RekrutController::delete/$1'); // Hapus


//CRUD jadwal
$routes->post('/jadwal/store', 'JadwalController::store');
$routes->post('/jadwal/update/(:num)', 'JadwalController::update/$1');
$routes->get('/jadwal/delete/(:num)', 'JadwalController::delete/$1');


$routes->post('asisten/store', 'UserController::store');   // Tambah data
$routes->post('asisten/update/(:num)', 'UserController::update/$1'); // Update data
$routes->get('asisten/delete/(:num)', 'UserController::delete/$1'); // Hapus data

$routes->post('publikasi-ilmiah/store', 'PublikasiController::store');   // Tambah data
$routes->post('publikasi-ilmiah/update/(:num)', 'PublikasiController::update/$1'); // Update data
$routes->get('publikasi-ilmiah/delete/(:num)', 'PublikasiController::delete/$1'); // Hapus data

$routes->post('berita/store', 'beritaController::store');   // Tambah data
$routes->post('berita/update/(:num)', 'beritaController::update/$1'); // Update data
$routes->get('berita/delete/(:num)', 'beritaController::delete/$1'); // Hapus data

$routes->get('peserta-praktikum','PesertaPraktikumController::index');
$routes->post('peserta-praktikum/store', 'PesertaPraktikumController::create');   // Tambah data
$routes->post('peserta-praktikum/update/(:num)', 'PesertaPraktikumController::update/$1'); // Update data
$routes->get('peserta-praktikum/delete/(:num)', 'PesertaPraktikumController::delete/$1'); // Hapus data


// file: app/Config/Routes.php

$routes->get('/events', 'EventsController::index');      // list events
$routes->post('/events/store', 'EventsController::store');   // simpan event baru
$routes->post('/events/update/(:num)', 'EventsController::update/$1'); // update event
$routes->get('/events/delete/(:num)', 'EventsController::delete/$1');  // hapus event


