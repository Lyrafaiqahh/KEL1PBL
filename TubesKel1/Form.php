<?php
// Memulai sesi
require_once 'db_connection.php';
session_start();

// Pastikan pengguna telah login dan memiliki NIM dalam sesi
if (!isset($_SESSION['nim'])) {
    die("Anda belum login. Silakan login terlebih dahulu.");
}

// Ambil NIM dari sesi
$nim = $_SESSION['nim'];

// Periksa apakah file diunggah
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetDir = "uploads/";
    $uploadStatus = true;

    if (isset($_FILES['jurusan_file']['name']) && is_array($_FILES['jurusan_file']['name'])) {
        foreach ($_FILES['jurusan_file']['name'] as $index => $fileName) {
            $targetFile = $targetDir . basename($fileName);
            
            // Validasi file
            if ($_FILES['jurusan_file']['error'][$index] !== UPLOAD_ERR_OK) {
                echo "Terjadi kesalahan saat mengunggah file: $fileName<br>";
                $uploadStatus = false;
                continue;
            }

            // Pindahkan file ke folder uploads
            if (move_uploaded_file($_FILES['jurusan_file']['tmp_name'][$index], $targetFile)) {
                // Simpan data ke database
                $query = "INSERT INTO form_berkas (form_jurusan, nim) VALUES (?, ?)";
                $params = [$fileName, $nim];
                $stmt = sqlsrv_prepare($conn, $query, $params);

                if (sqlsrv_execute($stmt)) {
                    echo "File berhasil diunggah: $fileName. Data berhasil disimpan di database.<br>";
                } else {
                    echo "Gagal menyimpan data ke database untuk file: $fileName.<br>";
                }
            } else {
                echo "Gagal memindahkan file: $fileName.<br>";
            }
        }
    } else {
        echo "No files uploaded or invalid files.<br>";
    }
}
?>
