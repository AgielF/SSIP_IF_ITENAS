<?php
$mysqli = new mysqli("127.0.0.1", "root", "", "ssip");
$result = $mysqli->query("SHOW TABLES");
while ($row = $result->fetch_array()) {
    echo $row[0] . "\n";
}
