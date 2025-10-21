<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class HashPasswords extends BaseCommand
{
    protected $group       = 'custom';
    protected $name        = 'hash:passwords';
    protected $description = 'Hash existing plain text passwords in database';

    public function run(array $params)
    {
        $db = \Config\Database::connect();

        CLI::write('Checking existing passwords...', 'yellow');

        $users = $db->table('users')->get()->getResultArray();

        $updated = 0;
        foreach ($users as $user) {
            $passwordInfo = password_get_info($user['password']);

            CLI::write("User: {$user['nama']} (ID: {$user['id']})", 'cyan');
            CLI::write("Current password: {$user['password']}", 'cyan');
            CLI::write("Algorithm: {$passwordInfo['algo']}", 'cyan');
            CLI::write("Is hashed: " . ($passwordInfo['algo'] > 0 ? 'YES' : 'NO'), 'cyan');

            // Mengubah langsung semua plain text menjadi hashed
            $hashed = password_hash($user['password'], PASSWORD_DEFAULT);

            $db->table('users')
                ->where('id', $user['id'])
                ->update(['password' => $hashed]);

            CLI::write("✓ Password hashed successfully", 'green');
            CLI::write("New hash: " . substr($hashed, 0, 50) . '...', 'green');
            $updated++;
            CLI::newLine();
        }

        CLI::write("Total users updated: {$updated}", 'green');
        CLI::write('Password hashing complete!', 'green');
    }
}