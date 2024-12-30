<?php
$password = 'pass1234'; // Ganti dengan password yang ingin di-hash
echo password_hash($password, PASSWORD_DEFAULT);
?>