<?php
// File: db_connection.php

// Konfigurasi koneksi ke SQL Server
$serverName = "DESKTOP-IHU47I9"; // Nama server SQL Server Anda
$connectionOptions = [
    "Database" => "sibeta",         // Nama database
    "Uid" => "",                    // Username jika diperlukan (kosongkan jika menggunakan autentikasi Windows)
    "PWD" => ""                     // Password jika diperlukan (kosongkan jika menggunakan autentikasi Windows)
];

try {
    // Membuat koneksi PDO
    $conn = new PDO("sqlsrv:Server=$serverName;Database={$connectionOptions['Database']}", 
                    $connectionOptions['Uid'], 
                    $connectionOptions['PWD']);
    
    // Atur mode kesalahan PDO untuk menangani kesalahan
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Jika koneksi berhasil, bisa melanjutkan ke kode lainnya
    echo "Koneksi berhasil ke database SQL Server!";
} catch (PDOException $e) {
    // Menangani kesalahan koneksi
    die("Koneksi gagal: " . $e->getMessage());
}
?>
