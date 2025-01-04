<?php

require_once 'db_connection.php';

// Lakukan tes query
$sql = "SELECT * FROM some_table"; // Ganti 'some_table' dengan tabel Anda
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
} else {
    echo "Koneksi berhasil dan query dieksekusi!";
}
?>
