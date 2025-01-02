<?php

namespace App;
class Connection
{
    private $serverName = "TIMS";
    private $connectionInfo = ["Database" => "sibeta"];
    protected $conn;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        $this->conn = sqlsrv_connect($this->serverName, $this->connectionInfo);
        if ($this->conn === false) {
            die(print_r(sqlsrv_errors(), true));
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
?>