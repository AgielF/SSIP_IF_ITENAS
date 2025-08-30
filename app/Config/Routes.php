<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Rekomendasi untuk konsistensi
$routes->get('/', 'Home::index');

$routes->get('/agenda', 'Home::agenda');

$routes->get('/asisten', 'AnggotaController::index');
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

// $routes->get('/user_profile', 'Home::user_profile');

$routes->get('/topic_detail', 'Home::topic_detail');

// Rute untuk Penelitian & Proyek
$routes->get('/penelitian/(:segment)', 'TopicController::detail/$1');

$routes->get('/profil/(:num)', 'AnggotaController::profil/$1');