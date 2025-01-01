<?php
session_start();
require_once 'db_connection.php';

if (!isset($_SESSION['nim'])) {
    die("Anda belum login. Silakan login terlebih dahulu.");
}

$nim = $_SESSION['nim'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Direktori tempat file diunggah berdasarkan kategori
    $targetDir = "formUpload/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // Buat folder formUpload jika belum ada
    }

    // Folder khusus untuk setiap jenis file
    $targetDirJurusan = $targetDir . "jurusan/";
    $targetDirPerpustakaan = $targetDir . "perpustakaan/";
    $targetDirBeta = $targetDir . "beta/";

    // Pastikan folder untuk masing-masing kategori sudah ada
    if (!is_dir($targetDirJurusan)) mkdir($targetDirJurusan, 0777, true);
    if (!is_dir($targetDirPerpustakaan)) mkdir($targetDirPerpustakaan, 0777, true);
    if (!is_dir($targetDirBeta)) mkdir($targetDirBeta, 0777, true);

    // Variabel untuk menyimpan path file
    $fileJurusan = null;
    $filePerpustakaan = null;
    $fileBeta = null;
    $uploadStatus = true;

    // Loop melalui file yang diunggah
    if (isset($_FILES['uploads']['name']) && is_array($_FILES['uploads']['name'])) {
        foreach ($_FILES['uploads']['name'] as $index => $fileName) {
            // Tentukan nama file tujuan (gunakan NIM untuk membuat nama file unik)
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            $targetFile = null;

            // Tentukan folder dan file path berdasarkan jenis file
            if ($index == 0) {
                $targetFile = $targetDirJurusan . $nim . "_" . basename($fileName);
            } elseif ($index == 1) {
                $targetFile = $targetDirPerpustakaan . $nim . "_" . basename($fileName);
            } elseif ($index == 2) {
                $targetFile = $targetDirBeta . $nim . "_" . basename($fileName);
            }

            // Validasi file (memastikan file yang diunggah adalah PDF)
            if (strtolower($fileType) !== 'pdf') {
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

            // Pindahkan file ke folder yang sesuai
            if (move_uploaded_file($_FILES['uploads']['tmp_name'][$index], $targetFile)) {
                echo "File berhasil dipindahkan: $fileName<br>";

                // Tentukan file berdasarkan index form
                if ($index == 0) {
                    $fileJurusan = $targetFile;
                } elseif ($index == 1) {
                    $filePerpustakaan = $targetFile;
                } elseif ($index == 2) {
                    $fileBeta = $targetFile;
                }
            } else {
                echo "Gagal memindahkan file: $fileName.<br>";
                $uploadStatus = false;
            }
        }

        // Jika semua file berhasil diunggah, simpan data ke database
        if ($uploadStatus) {
            try {
                // Query untuk menyimpan data ke database
                $query = "INSERT INTO form_berkas (form_jurusan, form_perpustakaan, form_beta, nim) 
                          VALUES (?, ?, ?, ?)";
                $params = [$fileJurusan, $filePerpustakaan, $fileBeta, $nim];

                // Menyiapkan dan mengeksekusi query
                $stmt = sqlsrv_query($conn, $query, $params);

                if ($stmt) {
                    echo "File berhasil diunggah dan data berhasil disimpan di database.<br>";
                } else {
                    echo "Gagal menyimpan data ke database.<br>";
                    print_r(sqlsrv_errors());
                }
            } catch (Exception $e) {
                echo "Kesalahan: " . $e->getMessage() . "<br>";
            }
        } else {
            echo "Gagal mengunggah file. Periksa kembali file yang diunggah.<br>";
        }
    } else {
        echo "Tidak ada file yang diunggah.<br>";
    }
}
?>
