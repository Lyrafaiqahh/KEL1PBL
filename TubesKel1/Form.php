<?php
// Memulai sesi
session_start();

// Include file koneksi
require_once 'db_connection.php';

// Pastikan pengguna telah login dan memiliki NIM dalam sesi
if (!isset($_SESSION['nim'])) {
    die("Anda belum login. Silakan login terlebih dahulu.");
}

// Ambil NIM dari sesi
$nim = $_SESSION['nim'];

// Periksa apakah file diunggah
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Direktori tempat file diunggah
    $targetDir = "uploads/";
    $uploadStatus = true;

    // Variabel untuk menyimpan nama file
    $fileJurusan = null;
    $filePerpustakaan = null;
    $fileBeta = null;

    // Loop melalui file yang diunggah
    if (isset($_FILES['uploads']['name']) && is_array($_FILES['uploads']['name'])) {
        foreach ($_FILES['uploads']['name'] as $index => $fileName) {
            // Tentukan nama file tujuan
            $targetFile = $targetDir . basename($fileName);
            
            // Validasi file (memastikan file yang diunggah adalah PDF)
            $fileType = pathinfo($targetFile, PATHINFO_EXTENSION);
            if ($fileType !== 'pdf') {
                echo "Hanya file PDF yang diperbolehkan: $fileName<br>";
                $uploadStatus = false;
                continue;
            }

            // Validasi kesalahan unggahan
            if ($_FILES['uploads']['error'][$index] !== UPLOAD_ERR_OK) {
                echo "Terjadi kesalahan saat mengunggah file: $fileName<br>";
                $uploadStatus = false;
                continue;
            }

            // Pindahkan file ke folder uploads
            if (move_uploaded_file($_FILES['uploads']['tmp_name'][$index], $targetFile)) {
                // Menentukan file berdasarkan index form
                if ($index == 0) {
                    $fileJurusan = $targetFile;
                } elseif ($index == 1) {
                    $filePerpustakaan = $targetFile;
                } elseif ($index == 2) {
                    $fileBeta = $targetFile;
                }
            } else {
                echo "Gagal memindahkan file: $fileName.<br>";
            }
        }

        // Jika ada file yang berhasil diunggah, simpan data ke database
        if ($uploadStatus) {
            try {
                // Query untuk menyimpan data ke database
                $query = "INSERT INTO form_berkas (form_jurusan, form_perpustakaan, form_beta, nim) 
                          VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->execute([$fileJurusan, $filePerpustakaan, $fileBeta, $nim]);

                echo "File berhasil diunggah dan data berhasil disimpan di database.<br>";
            } catch (PDOException $e) {
                echo "Gagal menyimpan data ke database. Error: " . $e->getMessage() . "<br>";
            }
        }
    } else {
        echo "Tidak ada file yang diunggah atau file tidak valid.<br>";
    }
}
?>
