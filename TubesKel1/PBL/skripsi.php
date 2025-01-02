<?php
session_start();
$_SESSION['menu_active'] = 'skripsi';

include 'layout/header.php';
include 'pages/skripsi/index.php';
include 'layout/footer.php';