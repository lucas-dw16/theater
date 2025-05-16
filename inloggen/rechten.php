<?php
session_start();

if (!isset($_SESSION['gebruiker_id']) || !isset($_SESSION['rol'])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION['rol'] !== 'Admin') {
    header("Location: geen_toegang.php");
    exit();
}
?>
