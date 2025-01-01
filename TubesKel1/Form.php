<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['nim'])) {
    die("Anda belum login. Silakan login terlebih dahulu.");
}

$nim = $_SESSION['nim'];
$targetDir = "formUpload/";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pastikan direktori tujuan ada
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

    // Variabel untuk menyimpan path file
    $fileJurusan = null;
    $filePerpustakaan = null;
    $fileBeta = null;

    // Loop melalui file yang diunggah
    if (!empty($_FILES['uploads']['name']) && is_array($_FILES['uploads']['name'])) {
        foreach ($_FILES['uploads']['name'] as $index => $fileName) {
            $fileTmpPath = $_FILES['uploads']['tmp_name'][$index];
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

            // Validasi: hanya file PDF yang diperbolehkan
            if (strtolower($fileType) !== 'pdf') {
                echo "File tidak valid: hanya PDF yang diperbolehkan ($fileName).<br>";
                continue;
            }

            // Tentukan folder penyimpanan berdasarkan prefiks nama file
            if (stripos($fileName, 'jurusan') === 0) {
                $filePath = $targetDir . $nim . "_jurusan_" . $fileName;
                $fileJurusan = $filePath;
            } elseif (stripos($fileName, 'perpustakaan') === 0) {
                $filePath = $targetDir . $nim . "_perpustakaan_" . $fileName;
                $filePerpustakaan = $filePath;
            } elseif (stripos($fileName, 'bebas') === 0) {
                $filePath = $targetDir . $nim . "_bebas_" . $fileName;
                $fileBeta = $filePath;
            } else {
                echo "File dengan nama tidak dikenali: $fileName.<br>";
                continue;
            }

            // Pindahkan file ke direktori target
            if (move_uploaded_file($fileTmpPath, $filePath)) {
                echo "File berhasil diunggah: $fileName.<br>";
            } else {
                echo "Gagal mengunggah file: $fileName.<br>";
            }
        }

        // Simpan ke database hanya jika salah satu file berhasil diunggah
        if ($fileJurusan || $filePerpustakaan || $fileBeta) {
            try {
                // Query untuk menyimpan data ke database
                $query = "INSERT INTO form_berkas (form_jurusan, form_perpustakaan, form_beta, nim) VALUES (?, ?, ?, ?)";
                $params = [$fileJurusan, $filePerpustakaan, $fileBeta, $nim];

                // Menyiapkan dan menjalankan query
                $stmt = sqlsrv_query($conn, $query, $params);

                if ($stmt) {
                    echo "File berhasil disimpan ke database.<br>";
                } else {
                    echo "Gagal menyimpan data ke database.<br>";
                    print_r(sqlsrv_errors());
                }
            } catch (Exception $e) {
                echo "Kesalahan: " . $e->getMessage() . "<br>";
            }
        } else {
            echo "Tidak ada file yang diunggah atau dikenali.<br>";
        }
    } else {
        echo "Tidak ada file yang diunggah.<br>";
    }
}
?>
