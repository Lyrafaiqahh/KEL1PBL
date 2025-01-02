<?php
session_start();
$_SESSION['menu_active'] = 'pembayaran';

include 'layout/header.php';
include 'pages/pembayaran/index.php';
include 'layout/footer.php';