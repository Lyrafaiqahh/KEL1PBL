<?php
// Mulai sesi
session_start();

// Inisialisasi data pembayaran
if (!isset($_SESSION['data_pembayaran'])) {
    $_SESSION['data_pembayaran'] = [];
}

// Proses form jika data dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'] ?? '';
    $nim = $_POST['nim'] ?? '';
    $jumlah = $_POST['jumlah'] ?? '';

    if (!empty($nama) && !empty($nim) && !empty($jumlah)) {
        // Tambahkan data ke sesi
        $_SESSION['data_pembayaran'][] = [
            'nama' => $nama,
            'nim' => $nim,
            'jumlah' => $jumlah,
        ];
        $message = "Data pembayaran berhasil disimpan!";
        header("Location: script.php");
        exit();
    } else {
        $message = "Harap isi semua field.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
        }
        .form-section {
            max-width: 500px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .form-section h2 {
            margin-top: 0;
        }
        .form-section form label {
            display: block;
            margin: 10px 0 5px;
        }
        .form-section form input, .form-section form button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }
        .form-section form button {
            background-color: #3498db;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .form-section form button:hover {
            background-color: #2980b9;
        }
        a {
            display: block;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            color: #3498db;
        }
        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 20px;
            box-sizing: border-box;
        }
        .sidebar h2 {
            margin-top: 0;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        .sidebar ul li {
            margin: 15px 0;
        }
        .sidebar ul li a {
            color: #ecf0f1;
            text-decoration: none;
        }
    </style>
</head>
<body>
     <!-- Sidebar -->
     <div class="sidebar">
        <h2>Admin</h2>
        <ul>
            <li><a href="form.php">Tambah Data Pembayaran</a></li>
            <li><a href="script.php">Data Pembayaran</a></li>
        </ul>
    </div>
    <div class="form-section">
        <h2>Tambah Data Pembayaran</h2>
        <?php if (isset($message)): ?>
            <p style="color: green;"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form action="form.php" method="POST">
            <label for="nama">Nama Mahasiswa:</label>
            <input type="text" id="nama" name="nama" required>

            <label for="nim">NIM Mahasiswa:</label>
            <input type="text" id="nim" name="nim" required>

            <label for="jumlah">Jumlah Pembayaran (Rp):</label>
            <input type="number" id="jumlah" name="jumlah" required>

            <button type="submit">Simpan</button>
        </form>
        <a href="index.php">Kembali ke Dashboard</a>
    </div>
</body>
</html>
