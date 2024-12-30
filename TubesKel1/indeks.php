<?php
// Aktifkan error reporting untuk membantu debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Memulai sesi
session_start();

// Debug: Cek apakah sesi sudah dimulai
if (isset($_SESSION['nim'])) {
    echo "User sudah login, redirecting ke dashboard...";
    header("Location: dashboard.html");
    exit(); // Jangan lupa untuk exit setelah redirect
}

require_once 'login.class.php'; // Pastikan login.class.php sudah ada

// Proses login ketika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nim = $_POST['nim'];
    $password = $_POST['password'];

    $login = new Login(); // Membuat objek Login
    if ($login->validate($nim, $password)) { // Validasi login
        $_SESSION['nim'] = $nim; // Menyimpan NIM di session
        echo "Login sukses, redirecting ke dashboard...";
        header("Location: dashboard.html"); // Redirect ke dashboard setelah login sukses
        exit(); // Pastikan berhenti setelah redirect
    } else {
        $error = "NIM atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Mahasiswa</title>
    <link rel="stylesheet" href="Login.css">
</head>
<body>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">
                        <div class="text-center mt-4">
                            <h1 class="h2">Login Mahasiswa</h1>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="">
                                    <div class="mb-3">
                                        <label class="form-label">NIM</label>
                                        <input class="form-control" type="text" name="nim" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input class="form-control" type="password" name="password" required>
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-lg btn-primary">Masuk</button>
                                    </div>
                                    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
