<?php
$sql = file_get_contents('/home/agiel-fernanda/kuliah/KP/PROJECT/SSIP_IF_ITENAS/u203366347_ssip_Itenas.sql');
preg_match_all('/CREATE TABLE `([^`]+)` \((.*?)\) ENGINE/s', $sql, $matches);
$schema = [];
foreach ($matches[1] as $index => $table) {
    preg_match_all('/`([^`]+)`/', $matches[2][$index], $colMatches);
    $columns = array_unique($colMatches[1]);
    $schema[$table] = array_values($columns);
}
echo json_encode($schema, JSON_PRETTY_PRINT);
