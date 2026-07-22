<?php
define('FCPATH', __DIR__ . '/public/');
$_SERVER['CI_ENVIRONMENT'] = 'testing';
require 'vendor/autoload.php';

// Bootstrap CI4 test environment
require 'vendor/codeigniter4/framework/system/Test/bootstrap.php';


$runner = \Config\Services::migrations();
try {
    echo "Running migrations...\n";
    $runner->setGroup('tests')->latest();
    echo "Migrations successful!\n";
} catch (\Throwable $e) {
    echo "Migration Error: " . $e->getMessage() . "\n";
}

$seeder = \Config\Database::seeder();
try {
    echo "Running seeder...\n";
    $seeder->call('Tests\Support\Database\Seeds\DevSecOpsSeeder');
    echo "Seeding successful!\n";
} catch (\Throwable $e) {
    echo "Seeding Error: " . $e->getMessage() . "\n";
}
