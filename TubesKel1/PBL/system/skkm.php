<?php

use App\Connection;
include '../helper/helper.php';

class Skkm
{
    private $conn;
    public function __construct($conn)
    {
        $this->conn = $conn->getConnection();
    }

    function fetchArray($dataBefore) {
        $dataAfter = [];
        $dataAfter['num_rows'] = 0;
        while ($row = sqlsrv_fetch_array($dataBefore ?? null, SQLSRV_FETCH_ASSOC)) {
            $dataAfter['data'][] = $row; 
            $dataAfter['num_rows']++;    
        }
    
    
        return $dataAfter;
    }
    public function index()
    {


        $columns = ['nim', 'nama', 'nama_jurusan', 'file_sertifikat', 'status'];

        $searchValue = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';
        $orderColumnIndex = isset($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
        $orderDirection = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'asc';
        $orderColumn = isset($columns[$orderColumnIndex]) ? $columns[$orderColumnIndex] : 'nim';
        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $length = isset($_POST['length']) ? intval($_POST['length']) : 10;

        $query = "SELECT * FROM dbo.v_skkm WHERE 1=1";

        if (!empty($searchValue)) {
            $query .= " AND (nim LIKE '%$searchValue%' OR nama LIKE '%$searchValue%' OR nama_jurusan LIKE '%$searchValue%'  OR file_sertifikat LIKE '%$searchValue%' OR status LIKE '%$searchValue%')";
        }

        
        // Hitung total data yang difilter
        $filteredQuery = "SELECT COUNT(*) as filtered FROM ($query) as temp";
        $filteredResult = sqlsrv_query($this->conn, $filteredQuery);
        $filteredData = sqlsrv_fetch_array($filteredResult, SQLSRV_FETCH_ASSOC)['filtered'];

        $query .= " ORDER BY $orderColumn $orderDirection OFFSET $start ROWS FETCH NEXT $length ROWS ONLY";
        $stmt = sqlsrv_query($this->conn, $query);
        if (!$stmt) {die(print_r(sqlsrv_errors(), true));}
        $data = fetchArray($stmt);


        $response = [
            "draw" => isset($_POST['draw']) ? intval($_POST['draw']) : 0,
            "recordsTotal" => countData("dbo.v_skkm") ?? 0,
            "recordsFiltered" => $filteredData ?? 0,
            "data" => $data['data'] ?? []
        ];

        return json_encode($response);
    }

    public function verifikasi()
    {
        $id = $_POST['id'];
        $status = $_POST['status'];


        $query = "UPDATE dbo.sertifikat SET status = ? WHERE no_sertifikat = ?";
        $params = [$status, $id];

        $stmt = sqlsrv_query($this->conn, $query, $params);
       
        if (!$stmt) {
            return 1;
        } else {
            return 0;
        }
    }
}

$connection = new Connection();
$skkm = new Skkm($connection);

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'index') echo $skkm->index();
    if ($_POST['action'] == 'verifikasi') echo $skkm->verifikasi();
}