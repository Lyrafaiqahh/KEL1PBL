<?php

class DatabaseConnection {
    private $serverName;
    private $database;
    private $uid;
    private $password;
    private $connection;

    // Constructor untuk inisialisasi parameter koneksi
    public function __construct($serverName, $database, $uid = "", $password = "") {
        $this->serverName = $serverName;
        $this->database = $database;
        $this->uid = $uid;
        $this->password = $password;
    }

    // Metode untuk melakukan koneksi ke database
    public function connect() {
        $connectionInfo = [
            "Database" => $this->database,
            "Uid" => $this->uid,
            "PWD" => $this->password
        ];

        $this->connection = sqlsrv_connect($this->serverName, $connectionInfo);

        if (!$this->connection) {
            // Menampilkan error jika koneksi gagal
            die(print_r(sqlsrv_errors(), true));
        }

        return $this->connection;
    }

    // Metode untuk mendapatkan koneksi
    public function getConnection() {
        if ($this->connection === null) {
            return $this->connect();
        }
        return $this->connection;
    }

    public function closeConnection() {
        if ($this->connection) {
            sqlsrv_close($this->connection);
            $this->connection = null;
        }
    }
}

$serverName = "DESKTOP-IHU47I9";
$database = "sibeta";
$uid = ""; 
$pass = ""; 


$db = new DatabaseConnection($serverName, $database, $uid, $pass);
$conn = $db->connect();
?>
