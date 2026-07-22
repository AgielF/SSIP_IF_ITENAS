<?php
$mysqli = new mysqli("127.0.0.1", "root", "");
$mysqli->query("DROP DATABASE IF EXISTS ssip_if_itenas_test");
$mysqli->query("CREATE DATABASE ssip_if_itenas_test");
echo "Database ssip_if_itenas_test recreated.\n";
