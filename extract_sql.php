<?php
$logPath = '/home/agiel-fernanda/.gemini/antigravity-ide/brain/3caec372-ffd5-4602-8497-1212f16abde4/.system_generated/logs/transcript_full.jsonl';
$lines = file($logPath);
$lastUserInput = '';

foreach ($lines as $line) {
    $data = json_decode($line, true);
    if ($data && isset($data['type']) && $data['type'] === 'USER_INPUT') {
        if (strpos($data['content'], '-- phpMyAdmin SQL Dump') !== false) {
            $lastUserInput = $data['content'];
        }
    }
}

$startPos = strpos($lastUserInput, '-- phpMyAdmin SQL Dump');
if ($startPos !== false) {
    $sql = substr($lastUserInput, $startPos);
    // Remove the trailing tags or quotes if any
    $endPos = strpos($sql, '</USER_REQUEST>');
    if ($endPos !== false) {
        $sql = substr($sql, 0, $endPos);
    }
    $sql = rtrim($sql, '"\' ');
    file_put_contents('/home/agiel-fernanda/kuliah/KP/PROJECT/SSIP_IF_ITENAS/u203366347_ssip_Itenas.sql', $sql);
    echo "Extracted SQL: " . strlen($sql) . " bytes\n";
} else {
    echo "Dump not found\n";
}
