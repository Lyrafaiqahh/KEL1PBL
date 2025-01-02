<?php

use App\Connection;

include '../helper/helper.php';

class Auth
{
    private $conn;
    private $table;

    public function __construct($conn)
    {
        $this->conn = $conn->getConnection();
        $this->table = 'dbo.admin';
    }

    public function verify_login()
    {

        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = sqlsrv_query($this->conn, "SELECT * FROM dbo.admin WHERE nip = ?", array($username));

        $data = fetchArray($sql);

        if ($data['num_rows'] > 0) {
                if ($password == $data['data'][0]['password']) { //iki text biasa

                // if (password_verify($password, $data['data'][0]['password'])) {   //iki gawe lek wis nggawe bycript
                session_start();

                $_SESSION['user'] = [
                    'id' => $data['data'][0]['id'],
                    'nip' => $data['data'][0]['nip'],
                    'role' => $data['data'][0]['role']
                ];

                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function logout()
    {
        // Start the session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Destroy the session
        session_unset(); // Unset all session variables
        session_destroy(); // Destroy the session

        // Optionally, redirect to the login page
        // header("location:/PBL/login.php");
        return true;
    }
}

$connection = new Connection();
$auth = new Auth($connection);

if (isset($_POST['action'])) {
    if ($_POST['action'] == 'verify_login') echo $auth->verify_login();
    if ($_POST['action'] == 'logout') echo $auth->logout();
}
