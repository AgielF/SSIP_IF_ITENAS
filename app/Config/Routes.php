<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Rekomendasi untuk konsistensi
$routes->get('/', 'Home::index');

$routes->get('/agenda', 'Home::agenda');

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

// Admin routes
// 1. Dashboard
$routes->get('/admin', 'Admin\Dashboard::index');
$routes->get('/admin/dashboard', 'Admin\Dashboard::index');
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

$routes->get('/galeri_admin', 'Home::galeri_admin');

$routes->get('/repositori', 'Home::repositori');
$routes->get('/repositori_admin','Home::repositori_admin');

$routes->get('/rekrutmen', 'Home::rekrutmen');
$routes->get('/rekrutmen_admin','Home::rekrutmen_admin');
