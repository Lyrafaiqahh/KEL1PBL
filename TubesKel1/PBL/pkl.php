<?php
session_start();
$_SESSION['menu_active'] = 'pkl';

include 'layout/header.php';
include 'pages/pkl/index.php';
include 'layout/footer.php';