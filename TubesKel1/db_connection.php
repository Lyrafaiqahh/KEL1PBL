<?php
// File: db_connection.php

// Koneksi ke SQL Server
$serverName = "DESKTOP-IHU47I9";
$connectionOptions = [
    "Database" => "sibeta",
    "Uid" => "",  // Ganti dengan username SQL Server Anda
    "PWD" => ""   // Ganti dengan password SQL Server Anda
];

// Membuat koneksi
$conn = sqlsrv_connect($serverName, $connectionOptions);

// Periksa koneksi
if ($conn === false) {
    die(json_encode(["message" => "Koneksi gagal: " . print_r(sqlsrv_errors(), true)]));
}
?>
