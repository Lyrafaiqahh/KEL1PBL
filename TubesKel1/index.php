<?php
session_start();
include 'db_connection.php'; // File untuk koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Query untuk mengambil data mahasiswa berdasarkan NIM
    $query = "SELECT nim, password, nama, role FROM mahasiswa WHERE nim = ?";
    $params = [$username]; // Parameter untuk query

    // Eksekusi query
    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Periksa apakah ada data yang ditemukan
    if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        // Verifikasi password (tanpa hash, langsung plaintext)
        if ($password === $row['password']) {
            // Login berhasil, simpan sesi
            $_SESSION['username'] = $row['nama'];
            $_SESSION['nim'] = $row['nim'];
            $_SESSION['role'] = $row['role'];

            header("Location: dashboard.html"); // Redirect ke halaman form.php
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "NIM tidak ditemukan!";
    }

    // Bebaskan statement
    sqlsrv_free_stmt($stmt);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bebas Tanggungan</title>
    <link rel="stylesheet" href="Login.css">
</head>
<body>
    <div class="background"></div>
    <div class="login-container">
        <div class="login-box">
            <img src="img/polinema.png" alt="Logo Polinema" class="logo">
            <h2>BEBAS TANGGUNGAN</h2>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
            <form method="POST" action="index.php" id="loginForm">
                <input type="text" name="username" placeholder="Username (NIM)" required>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <span id="togglePassword" onclick="togglePasswordVisibility()">👁️</span>
                </div>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById("password");
            const toggleIcon = document.getElementById("togglePassword");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.textContent = "🔒";
            } else {
                passwordInput.type = "password";
                toggleIcon.textContent = "👁️";
            }
        }
    </script>
</body>
</html>
