<?php
$mysqli = new mysqli("127.0.0.1", "root", "", "ssip_if_itenas_test");
$mysqli->query("SET FOREIGN_KEY_CHECKS = 0");
$result = $mysqli->query("SHOW TABLES");
while ($row = $result->fetch_array()) {
    $mysqli->query("DROP TABLE IF EXISTS " . $row[0]);
}
$mysqli->query("SET FOREIGN_KEY_CHECKS = 1");
