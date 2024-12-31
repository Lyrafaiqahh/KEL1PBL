<?php
session_start();
include 'db_connection.php'; // Koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash password menggunakan SHA256 untuk mencocokkan di database
    $hashedPassword = hash('sha256', $password);

    // Query untuk memeriksa username dan password di tabel `admin` atau `mahasiswa`
    $query = "
        SELECT nim, nama, role 
        FROM mahasiswa 
        WHERE nim = ? AND password = CONVERT(VARBINARY(MAX), ?)
        UNION
        SELECT nip AS nim, nama, role 
        FROM admin 
        WHERE nip = ? AND password = CONVERT(VARBINARY(MAX), ?)
    ";
    $params = [$username, $hashedPassword, $username, $hashedPassword];
    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false) {
        die("Kesalahan query: " . print_r(sqlsrv_errors(), true));
    }

    // Periksa hasil query
    $user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    if ($user) {
        // Simpan data pengguna ke sesi
        $_SESSION['username'] = $user['nama'];
        $_SESSION['nim'] = $user['nim'];
        $_SESSION['role'] = $user['role'];

        header("Location: dashboard.html"); // Redirect ke halaman dashboard
        exit();
    } else {
        $error = "Username atau password salah!";
    }
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
                <input type="text" name="username" placeholder="Username (NIM/NIP)" required>
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
