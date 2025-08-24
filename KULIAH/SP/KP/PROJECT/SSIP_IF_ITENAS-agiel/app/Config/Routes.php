<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Rekomendasi untuk konsistensi
$routes->get('/', 'Home::index');
$routes->get('/agenda', 'Home::agenda');
$routes->get('/asisten', 'Home::asisten');
$routes->get('/jadwal', 'Home::jadwal');
$routes->get('/jadwal-list', 'Home::jadwal_card');
$routes->get('/penelitian-proyek', 'Home::penelitian_proyek');
$routes->get('/publikasi-ilmiah', 'Home::publikasi_ilmiah');
$routes->get('/galeri', 'Home::galeri');
