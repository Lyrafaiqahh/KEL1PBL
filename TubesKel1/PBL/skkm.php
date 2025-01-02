<?php
session_start();
$_SESSION['menu_active'] = 'skkm';

include 'layout/header.php';
include 'pages/skkm/index.php';
include 'layout/footer.php';