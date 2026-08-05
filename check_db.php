<?php
$db = new mysqli('127.0.0.1', 'root', '', 'ssip_v2');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
$result = $db->query("SHOW TABLES");
$tables = [];
while ($row = $result->fetch_array()) {
    $tables[] = $row[0];
}
echo "Tables: " . implode(", ", $tables) . "\n";
$db->close();
