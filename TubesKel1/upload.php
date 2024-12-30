<?php
// Include db_connection.php untuk koneksi ke database
include 'db_connection.php';

// Check if file is uploaded
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdfFile'])) {
    $targetDir = "uploads/"; // Directory where the file will be saved
    $fileName = basename($_FILES["pdfFile"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    $nim = $_POST['nim']; // ambil nilai NIM dari form input

    // Check if file is a PDF
    if ($fileType != "pdf") {
        die(json_encode(["message" => "Hanya file PDF yang diperbolehkan."]));
    }

    // Check file size (maksimal 2MB)
    if ($_FILES["pdfFile"]["size"] > 2000000) {
        die(json_encode(["message" => "Ukuran file terlalu besar. Maksimal 2 MB."]));
    }

    // Move file to target directory
    if (move_uploaded_file($_FILES["pdfFile"]["tmp_name"], $targetFilePath)) {
        // Insert into form_berkas table
        $query = "INSERT INTO form_berkas (form_jurusan, form_perpustakaan, form_beta, nim) VALUES (?, ?, ?, ?)";
        $stmt = sqlsrv_prepare($conn, $query, [$fileName, $fileName, $fileName, $nim]);

        if (sqlsrv_execute($stmt)) {
            echo json_encode(["message" => "File berhasil diunggah!", "fileName" => $fileName]);
        } else {
            echo json_encode(["message" => "Terjadi kesalahan saat menyimpan data."]);
        }
    } else {
        echo json_encode(["message" => "Terjadi kesalahan saat mengunggah file."]);
    }
} else {
    echo json_encode(["message" => "Permintaan tidak valid."]);
}
?>
