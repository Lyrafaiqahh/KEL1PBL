<?php

include '../connection.php';
include '../helper/helper.php';

class Dashboard
{
    private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }


    public function getCount(): bool|string
    {
        $sql = "SELECT 
                COUNT(CASE WHEN role = 2 THEN 1 END) AS countMahasiswa
            FROM dbo.mahasiswa";

        $stmt = sqlsrv_query($this->conn, $sql);

        if (!$stmt) {
            die(print_r(sqlsrv_errors(), true));
        }
        $data = fetchArray($stmt);

        return json_encode($data['data'][0] ?? []);
        
    }
}

$dashboard = new Dashboard($conn);

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'getCount') echo $dashboard->getCount();
}