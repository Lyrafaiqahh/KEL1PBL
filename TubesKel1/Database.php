<?php
// Database.php
class Database {
    // Simulasi data pengguna yang disimpan statis (hardcoded)
    private $users = [
        '12345' => 'password123',  // NIM => Password
        '67890' => 'password456'
    ];

    // Cek apakah NIM dan password cocok
    public function checkUserCredentials($nim, $password) {
        if (isset($this->users[$nim]) && $this->users[$nim] === $password) {
            return true; // Login sukses
        }
        return false; // Login gagal
    }

    // Mendapatkan nama mahasiswa berdasarkan NIM (Simulasi)
    public function getStudentName($nim) {
        $names = [
            '12345' => 'John Doe',
            '67890' => 'Jane Smith'
        ];
        return isset($names[$nim]) ? $names[$nim] : 'Unknown';
    }
}

?>
