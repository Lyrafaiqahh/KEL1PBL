<?php
session_start();
$_SESSION['menu_active'] = 'formbeta';

include 'layout/header.php';
include 'pages/formbeta/index.php';
include 'layout/footer.php';