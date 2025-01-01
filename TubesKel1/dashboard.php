<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['nim'])) {
    header("Location: index.php"); // Redirect ke halaman login jika belum login
    exit;
}

$nim = $_SESSION['nim'];
$userData = [];

// Fetch data user dari database
$query = "SELECT nama, prodi, fakultas FROM mahasiswa WHERE nim = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $nim);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
} else {
    die("User tidak ditemukan.");
}
?>
