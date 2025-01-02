<?php
session_start();
$_SESSION['menu_active'] = 'kuisioner';

include 'layout/header.php';
include 'pages/kuisioner/index.php';
include 'layout/footer.php';