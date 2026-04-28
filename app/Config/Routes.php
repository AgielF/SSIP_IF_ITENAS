<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// publik
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

$routes->get('contact', 'ContactController::index');
$routes->post('contact/send', 'ContactController::send');

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

$routes->get('/project-lab', 'ProjectLabController::index');
$routes->get('/project-lab/(:num)', 'ProjectLabController::detail/$1');

// routes khusus admin, dilindungi filter admin
$routes->group('', ['filter' => 'admin'], function($routes) {
    $routes->get('/asisten_admin', 'UserController::getDataAdmin');
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

        // CRUD action (POST) – tidak perlu filter admin kalau sudah dicek di controller
    $routes->post('/rekrutmen/store', 'RekrutController::store');
    $routes->post('/rekrutmen/update/(:num)', 'RekrutController::update/$1');
    $routes->post('/rekrutmen/delete/(:num)', 'RekrutController::delete/$1');

    //CRUD galeri
    $routes->post('galeri_admin/store', 'GaleriUmumController::create');
    $routes->post('galeri_admin/update/(:num)', 'GaleriUmumController::update/$1');
    $routes->get('galeri_admin/delete/(:num)', 'GaleriUmumController::delete/$1');

    $routes->get('/modul_praktikum_admin','modulPraktikumController::admin');
    //CRUD modul
    $routes->post('modul-praktikum/create', 'modulPraktikumController::create');
    $routes->post('modul-praktikum/update/(:num)', 'modulPraktikumController::update/$1');
    $routes->get('modul-praktikum/delete/(:num)', 'modulPraktikumController::delete/$1');

    // CRUD
    $routes->get('rekrutmen/create', 'RekrutController::create');     // Form tambah
    $routes->post('rekrutmen/store', 'RekrutController::store');      // Proses tambah
    $routes->get('rekrutmen/edit/(:num)', 'RekrutController::edit/$1');   // Form edit
    $routes->post('rekrutmen/update/(:num)', 'RekrutController::update/$1'); // Proses update
    $routes->get('rekrutmen/delete/(:num)', 'RekrutController::delete/$1'); // Hapus



    $routes->post('asisten/store', 'UserController::store');   // Tambah data
    $routes->post('asisten/update/(:num)', 'UserController::update/$1'); // Update data
    $routes->get('asisten/delete/(:num)', 'UserController::delete/$1'); // Hapus data


    $routes->post('berita/store', 'beritaController::store');   // Tambah data
    $routes->post('berita/update/(:num)', 'beritaController::update/$1'); // Update data
    $routes->get('berita/delete/(:num)', 'beritaController::delete/$1'); // Hapus data

    $routes->get('peserta-praktikum','PesertaPraktikumController::index');
    $routes->post('peserta-praktikum/store', 'PesertaPraktikumController::create');   // Tambah data
    $routes->post('peserta-praktikum/update/(:num)', 'PesertaPraktikumController::update/$1'); // Update data
    $routes->get('peserta-praktikum/delete/(:num)', 'PesertaPraktikumController::delete/$1'); // Hapus data

    $routes->get('visi-misi_admin','VisiMisiController::index');
    $routes->post('visi-misi_admin/store', 'VisiMisiController::create');   // Tambah data
    $routes->post('visi-misi_admin/update/(:num)', 'VisiMisiController::update/$1'); // Update data
    $routes->post('visi-misi_admin/delete/(:num)', 'VisiMisiController::delete/$1'); // Hapus data

    // file: app/Config/Routes.php

    $routes->get('/events', 'EventsController::index');      // list events
    $routes->post('/events/store', 'EventsController::store');   // simpan event baru
    $routes->post('/events/update/(:num)', 'EventsController::update/$1'); // update event
    $routes->get('/events/delete/(:num)', 'EventsController::delete/$1');  // hapus event
});

// Admin (1) dan Asisten (2)
$routes->group('', ['filter' => 'role:1,2'], function($routes) {

    //jadwal admin
    $routes->get('/jadwal_admin', 'JadwalController::admin');
    //CRUD jadwal
    $routes->post('/jadwal/store', 'JadwalController::store');
    $routes->post('/jadwal/update/(:num)', 'JadwalController::update/$1');
    $routes->get('/jadwal/delete/(:num)', 'JadwalController::delete/$1');

});


// Admin (1) dan Dosen(3)
$routes->group('', ['filter' => 'role:1,3'], function($routes) {

    // PENELITIAN PROYEK RISET
    $routes->get('/penelitian-proyek_admin', 'ProyekRisetController::getDataAdmin');
    // CRUD Proyek Riset (non API style)3e
    $routes->post('proyek-riset/store', 'ProyekRisetController::create');
    $routes->post('proyek-riset/update/(:num)', 'ProyekRisetController::update/$1');
    $routes->get('proyek-riset/delete/(:num)', 'ProyekRisetController::delete/$1');
    // Ambil detail satu proyek (edit form)
    $routes->get('proyek-riset/(:num)', 'ProyekRisetController::edit/$1');
    // Jika mau ambil detail satu proyek"
    // $routes->get('proyek-riset/(:num)', 'ProyekRisetController::edit/$1');

    //publikasi ilmiah
     $routes->get('/publikasi-ilmiah_admin', 'PublikasiController::getDataAdmin');
    
     //CRUD
    $routes->post('publikasi-ilmiah/store', 'PublikasiController::store');   // Tambah data
    $routes->post('publikasi-ilmiah/update/(:num)', 'PublikasiController::update/$1'); // Update data
    $routes->get('publikasi-ilmiah/delete/(:num)', 'PublikasiController::delete/$1'); // Hapus data

    //project-lab
     $routes->get('/project-lab_admin', 'ProjectLabController::getDataAdmin');
    $routes->post('/project-lab/create', 'ProjectLabController::create');
    $routes->post('/project-lab/update/(:num)', 'ProjectLabController::update/$1');
    $routes->get('/project-lab/delete/(:num)', 'ProjectLabController::delete/$1');
    $routes->post('/project-lab/member/add', 'ProjectLabController::addMember');


});

