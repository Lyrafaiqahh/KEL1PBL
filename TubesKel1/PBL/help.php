<?php
session_start();
$_SESSION['menu_active'] = 'help';

include 'layout/header.php';
include 'pages/help/index.php';
include 'layout/footer.php';