<?php
$mysqli = new mysqli("127.0.0.1", "root", "", "ssip_if_itenas_test");
$result = $mysqli->query("SHOW TABLES");
echo "Tables in ssip_if_itenas_test:\n";
while ($row = $result->fetch_array()) {
    echo $row[0] . "\n";
}
