<?php
session_start();
$_SESSION['menu_active'] = 'kompen';

include 'layout/header.php';
include 'pages/kompen/index.php';
include 'layout/footer.php';