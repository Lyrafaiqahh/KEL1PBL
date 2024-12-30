<?php
class User {
    public function __construct() {
        // Inisialisasi user jika diperlukan
    }

    // Cek apakah user sudah login
    public function isLoggedIn() {
        return isset($_SESSION['nim']); // Cek apakah sesi NIM ada
    }

    // Mendapatkan NIM user yang sedang login
    public function getUserNIM() {
        return isset($_SESSION['nim']) ? $_SESSION['nim'] : null;
    }

    // Logout user
    public function logout() {
        session_unset(); // Menghapus semua variabel sesi
        session_destroy(); // Menghancurkan sesi
    }
}
?>
