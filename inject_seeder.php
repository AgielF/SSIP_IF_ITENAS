<?php
$sqlContent = file_get_contents('/home/agiel-fernanda/kuliah/KP/PROJECT/SSIP_IF_ITENAS/u203366347_ssip_Itenas.sql');

$lines = explode("\n", $sqlContent);
$dataQueries = [];
$currentQuery = '';

foreach ($lines as $line) {
    if (trim($line) == '' || strpos(trim($line), '--') === 0 || strpos(trim($line), '/*!') === 0) {
        continue;
    }

    $currentQuery .= $line . "\n";
    
    if (substr(trim($line), -1) === ';') {
        if (strpos(trim($currentQuery), 'INSERT INTO') === 0 && strpos(trim($currentQuery), 'INSERT INTO `migrations`') === false) {
            $modifiedQuery = str_replace('INSERT INTO', 'INSERT IGNORE INTO', trim($currentQuery));
            $dataQueries[] = $modifiedQuery;
        }
        $currentQuery = '';
    }
}

$seederClass = '<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $db->query("SET FOREIGN_KEY_CHECKS=0;");
';

foreach ($dataQueries as $index => $query) {
    // Escape variables (like $2y$ in password hashes) so PHP does not try to interpolate them
    // We can use NOWDOC <<<\'SQL\' to completely ignore PHP parsing inside the string.
    $seederClass .= <<<PHP
        \$db->query(<<<'SQL'
{$query}
SQL
        );

PHP;
}

$seederClass .= '
        $db->query("SET FOREIGN_KEY_CHECKS=1;");
    }
}
';

file_put_contents('/home/agiel-fernanda/kuliah/KP/PROJECT/SSIP_IF_ITENAS/app/Database/Seeds/DatabaseSeeder.php', $seederClass);
echo "Injected SQL into DatabaseSeeder.php using NOWDOC\n";
