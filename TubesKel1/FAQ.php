<?php
// Sertakan koneksi database
require_once 'db_connection.php';

// Mulai sesi untuk mendapatkan data login
session_start();

// Fungsi untuk mengambil semua data FAQ
function getFAQ($conn) {
    $sql = "SELECT id_faq, pertanyaan, jawaban, nim FROM faq WHERE jawaban IS NOT NULL"; // Hanya ambil data dengan jawaban
    $stmt = sqlsrv_query($conn, $sql);

    $faq_data = [];
    if ($stmt) {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
            $faq_data[] = $row;
        }
    }
    return $faq_data;
}

// Fungsi untuk menambah data FAQ
function createFAQ($conn, $pertanyaan, $nim) {
    $sql = "INSERT INTO faq (pertanyaan, jawaban, nim) VALUES (?, NULL, ?)";
    $stmt = sqlsrv_prepare($conn, $sql, [$pertanyaan, $nim]);

    if ($stmt && sqlsrv_execute($stmt)) {
        return "Pertanyaan berhasil ditambahkan dan dicatat!";
    } else {
        return "Error: " . print_r(sqlsrv_errors(), true);
    }
}

// Tangani request method
$request_method = $_SERVER['REQUEST_METHOD'];
$response = [];

// Pastikan pengguna sudah login
if (!isset($_SESSION['nim'])) {
    $response = ["message" => "Unauthorized. Silakan login terlebih dahulu."];
} else {
    $nim = $_SESSION['nim']; // Dapatkan NIM dari sesi login

    switch ($request_method) {
        case 'GET':
            // Ambil data FAQ
            $response = getFAQ($conn);
            break;

        case 'POST':
            // Tambah data FAQ
            if (isset($_POST['pertanyaan'])) {
                $pertanyaan = $_POST['pertanyaan'];
                $message = createFAQ($conn, $pertanyaan, $nim);
                $response = ["message" => $message];
            } else {
                $response = ["message" => "Pertanyaan harus diisi!"];
            }
            break;

        default:
            $response = ["message" => "Method not allowed"];
            break;
    }
}

// Kembalikan response dalam format JSON
header('Content-Type: application/json');
echo json_encode($response);

// Tutup koneksi
sqlsrv_close($conn);
?>
