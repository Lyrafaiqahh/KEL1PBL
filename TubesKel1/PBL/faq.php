<?php
session_start();
$_SESSION['menu_active'] = 'faq';

include 'layout/header.php';
include 'pages/faq/index.php';
include 'layout/footer.php';