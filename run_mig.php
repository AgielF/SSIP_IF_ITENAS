<?php
define('ENVIRONMENT', 'testing');
require 'vendor/autoload.php';
require 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/Test/bootstrap.php';

$forge = \Config\Database::forge('tests');
try {
    $mig = new \App\Database\Migrations\CreateRekrutTable($forge);
    $mig->up();
    echo "Rekrut migrated!\n";
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
