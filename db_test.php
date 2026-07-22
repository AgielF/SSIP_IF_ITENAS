<?php
$mysqli = new mysqli("127.0.0.1", "root", "", "ssip_if_itenas_test");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit(1);
}
echo "Connected successfully to ssip_if_itenas_test.\n";
