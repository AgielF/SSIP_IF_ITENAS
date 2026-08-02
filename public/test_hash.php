<?php
header('Content-Type: text/plain');

$password = 'admin123';
$hash_default = password_hash($password, PASSWORD_DEFAULT);
$hash_bcrypt = password_hash($password, PASSWORD_BCRYPT);

echo "PASSWORD_DEFAULT: " . $hash_default . "\n";
echo "PASSWORD_BCRYPT:  " . $hash_bcrypt . "\n";

// Test matching
$known_hash = '$2y$10$TODkqd.59cu4sO9nN7nv6uYR/bv.EcRdJl/xqJGFnSlYj3oWT/PFW';
echo "Verify default hash against 'admin123': " . (password_verify($password, $known_hash) ? 'MATCH' : 'NO MATCH') . "\n";
