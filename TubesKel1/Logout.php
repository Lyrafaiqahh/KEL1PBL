<?php
// logout.php
session_start();
$user = new User();
$user->logout();
header("Location: login.php");
exit();

?>
