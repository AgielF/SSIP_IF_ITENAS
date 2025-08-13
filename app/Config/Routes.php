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

// Admin CRUD route
// 1. Rekrutmen
$routes->get('/admin/rekrut', 'Admin\Rekrut::index');
$routes->get('/admin/rekrut/new', 'Admin\Rekrut::new');
$routes->post('/admin/rekrut/create', 'Admin\Rekrut::create');
$routes->get('/admin/rekrut/edit/(:num)', 'Admin\Rekrut::edit/$1');
$routes->post('/admin/rekrut/update/(:num)', 'Admin\Rekrut::update/$1');
$routes->get('/admin/rekrut/delete/(:num)', 'Admin\Rekrut::delete/$1');

// 2.Proyek Riset
$routes->get('/admin/proyek-riset', 'Admin\ProyekRiset::index');
$routes->get('/admin/proyek-riset/new', 'Admin\ProyekRiset::new');
$routes->post('/admin/proyek-riset/create', 'Admin\ProyekRiset::create');
$routes->get('/admin/proyek-riset/edit/(:num)', 'Admin\ProyekRiset::edit/$1');
$routes->post('/admin/proyek-riset/update/(:num)', 'Admin\ProyekRiset::update/$1');
$routes->get('/admin/proyek-riset/delete/(:num)', 'Admin\ProyekRiset::delete/$1');

// 3. Publikasi Ilmiah
$routes->get('/admin/publikasi-ilmiah', 'Admin\PublikasiIlmiah::index');
$routes->get('/admin/publikasi-ilmiah/new', 'Admin\PublikasiIlmiah::new');
$routes->post('/admin/publikasi-ilmiah/create', 'Admin\PublikasiIlmiah::create');
$routes->get('/admin/publikasi-ilmiah/edit/(:num)', 'Admin\PublikasiIlmiah::edit/$1');
$routes->post('/admin/publikasi-ilmiah/update/(:num)', 'Admin\PublikasiIlmiah::update/$1');
$routes->get('/admin/publikasi-ilmiah/delete/(:num)', 'Admin\PublikasiIlmiah::delete/$1');

// 4. Galeri
$routes->get('/admin/galeri', 'Admin\Galeri::index');
$routes->get('/admin/galeri/new', 'Admin\Galeri::new');
$routes->post('/admin/galeri/create', 'Admin\Galeri::create');
$routes->get('/admin/galeri/edit/(:num)', 'Admin\Galeri::edit/$1');
$routes->post('/admin/galeri/update/(:num)', 'Admin\Galeri::update/$1');
$routes->get('/admin/galeri/delete/(:num)', 'Admin\Galeri::delete/$1');

// 5. Visi Misi
$routes->get('/admin/visi-misi', 'Admin\VisiMisi::index');
$routes->get('/admin/visi-misi/edit', 'Admin\VisiMisi::edit');
$routes->post('/admin/visi-misi/update', 'Admin\VisiMisi::update');
$routes->get('/admin/visi-misi/delete', 'Admin\VisiMisi::delete');

// 6. Jadwal
$routes->get('/admin/jadwal', 'Admin\Jadwal::index');
$routes->get('/admin/jadwal/new', 'Admin\Jadwal::new');
$routes->post('/admin/jadwal/create', 'Admin\Jadwal::create');
$routes->get('/admin/jadwal/edit/(:num)', 'Admin\Jadwal::edit/$1');
$routes->post('/admin/jadwal/update/(:num)', 'Admin\Jadwal::update/$1');
$routes->get('/admin/jadwal/delete/(:num)', 'Admin\Jadwal::delete/$1');

// 7. Asisten Jadwal
$routes->get('/admin/asisten-jadwal', 'Admin\AsistenJadwal::index');
$routes->get('/admin/asisten-jadwal/new', 'Admin\AsistenJadwal::new');
$routes->post('/admin/asisten-jadwal/create', 'Admin\AsistenJadwal::create');
$routes->get('/admin/asisten-jadwal/edit/(:num)', 'Admin\AsistenJadwal::edit/$1');
$routes->post('/admin/asisten-jadwal/update/(:num)', 'Admin\AsistenJadwal::update/$1');
$routes->get('/admin/asisten-jadwal/delete/(:num)', 'Admin\AsistenJadwal::delete/$1');

// 8. Peserta Praktikum
$routes->get('/admin/peserta-praktikum', 'Admin\PesertaPraktikum::index');
$routes->get('/admin/peserta-praktikum/new', 'Admin\PesertaPraktikum::new');
$routes->post('/admin/peserta-praktikum/create', 'Admin\PesertaPraktikum::create');
$routes->get('/admin/peserta-praktikum/edit/(:num)', 'Admin\PesertaPraktikum::edit/$1');
$routes->post('/admin/peserta-praktikum/update/(:num)', 'Admin\PesertaPraktikum::update/$1');
$routes->get('/admin/peserta-praktikum/delete/(:num)', 'Admin\PesertaPraktikum::delete/$1');

// 9. User Management
$routes->get('/admin/user-management', 'Admin\UserManagement::index');
$routes->get('/admin/user-management/new', 'Admin\UserManagement::new');
$routes->post('/admin/user-management/create', 'Admin\UserManagement::create');
$routes->get('/admin/user-management/edit/(:num)', 'Admin\UserManagement::edit/$1');
$routes->post('/admin/user-management/update/(:num)', 'Admin\UserManagement::update/$1');
$routes->get('/admin/user-management/delete/(:num)', 'Admin\UserManagement::delete/$1');

// 10. Berita
$routes->get('/admin/berita', 'Admin\Berita::index');
$routes->get('/admin/berita/new', 'Admin\Berita::new');
$routes->post('/admin/berita/create', 'Admin\Berita::create');
$routes->get('/admin/berita/edit/(:num)', 'Admin\Berita::edit/$1');
$routes->post('/admin/berita/update/(:num)', 'Admin\Berita::update/$1');
$routes->get('/admin/berita/delete/(:num)', 'Admin\Berita::delete/$1');

// 11. Praktikum
$routes->get('/admin/praktikum', 'Admin\Praktikum::index');
$routes->get('/admin/praktikum/new', 'Admin\Praktikum::new');
$routes->post('/admin/praktikum/create', 'Admin\Praktikum::create');
$routes->get('/admin/praktikum/edit/(:num)', 'Admin\Praktikum::edit/$1');
$routes->post('/admin/praktikum/update/(:num)', 'Admin\Praktikum::update/$1');
$routes->get('/admin/praktikum/delete/(:num)', 'Admin\Praktikum::delete/$1');

// 12. Modul Praktikum
$routes->get('/admin/modul-praktikum', 'Admin\ModulPraktikum::index');
$routes->get('/admin/modul-praktikum/new', 'Admin\ModulPraktikum::new');
$routes->post('/admin/modul-praktikum/create', 'Admin\ModulPraktikum::create');
$routes->get('/admin/modul-praktikum/edit/(:num)', 'Admin\ModulPraktikum::edit/$1');
$routes->post('/admin/modul-praktikum/update/(:num)', 'Admin\ModulPraktikum::update/$1');
$routes->get('/admin/modul-praktikum/delete/(:num)', 'Admin\ModulPraktikum::delete/$1');

// 13. Events
$routes->get('/admin/events', 'Admin\Events::index');
$routes->get('/admin/events/new', 'Admin\Events::new');
$routes->post('/admin/events/create', 'Admin\Events::create');
$routes->get('/admin/events/edit/(:num)', 'Admin\Events::edit/$1');
$routes->post('/admin/events/update/(:num)', 'Admin\Events::update/$1');
$routes->get('/admin/events/delete/(:num)', 'Admin\Events::delete/$1');
