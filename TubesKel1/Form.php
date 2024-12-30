<?php
// Memulai sesi
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

    foreach ($_FILES['uploads']['name'] as $index => $fileName) {
        $targetFile = $targetDir . basename($fileName);

        // Validasi file
        if ($_FILES['uploads']['error'][$index] !== UPLOAD_ERR_OK) {
            echo "Terjadi kesalahan saat mengunggah file: $fileName";
            $uploadStatus = false;
            continue;
        }

        // Pindahkan file ke folder uploads
        if (move_uploaded_file($_FILES['uploads']['tmp_name'][$index], $targetFile)) {
            // Simpan data ke database
            include 'db_connection.php';
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
}
?>
