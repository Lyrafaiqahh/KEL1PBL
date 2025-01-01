<?php
// File: db_connection.php

// Konfigurasi koneksi ke SQL Server
$serverName = "DESKTOP-IHU47I9"; // Nama server SQL Server Anda
$database = "sibeta";
$uid = "";
$pass = "";

$connection = [
"Database" => $database,
"Uid" => $uid,
"PWD" => $pass

];

$conn = sqlsrv_connect($serverName, $connection);
if(!$conn)
die(print_r(sqlsrv_errors(),true));


?>
