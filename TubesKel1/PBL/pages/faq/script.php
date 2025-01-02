<?php
require_once "../../connection.php"; // Pastikan file connection.php sudah sesuai

use App\Connection;

// Buat instance koneksi database
$db = new Connection();
$conn = $db->getConnection();

// Query untuk mengambil data dari tabel `faq`
$sql = "SELECT id_faq, pertanyaan, jawaban FROM dbo.faq";
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    // Kirim error dalam format JSON jika query gagal
    header('Content-Type: application/json');
    echo json_encode(["error" => sqlsrv_errors()]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Tangkap data JSON dari request body
    $input = json_decode(file_get_contents('php://input'), true);


    // Validasi input
    if (!isset($input['pertanyaan']) || !isset($input['jawaban'])) {
        http_response_code(400);
        echo json_encode(["error" => "Data tidak lengkap."]);
        exit;
    }

    // Data dari input
    $pertanyaan = $input['pertanyaan'];
    $jawaban = $input['jawaban'];

    // Query untuk menyimpan data ke tabel `faq`
    $sql = "INSERT INTO dbo.faq (pertanyaan, jawaban) VALUES (?, ?)";
    $params = [$pertanyaan, $jawaban];
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        http_response_code(500);
        echo json_encode(["error" => sqlsrv_errors()]);
        exit;
    }

    // Jika berhasil
    http_response_code(201); // Status 201 Created
    echo json_encode(["message" => "Pertanyaan dan jawaban berhasil ditambahkan."]);
    exit;
}

// Hasil query disimpan dalam array
$faqData = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $faqData[] = [
        "pertanyaan" => $row['pertanyaan'],
        "jawaban" => $row['jawaban'],
    ];
}

// Output data sebagai JSON
header('Content-Type: application/json');
echo json_encode($faqData);

// Bebaskan resource SQLSRV
sqlsrv_free_stmt($stmt);
