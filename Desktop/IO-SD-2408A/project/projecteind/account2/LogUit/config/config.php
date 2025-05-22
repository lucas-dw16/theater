<?php
// config/config.php

// Database credentials
$dbHost = 'localhost';
$dbName = 'fitness';
$dbUser = 'root';
$dbPass = '';

// Create a PDO connection
try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed try again later ");
}
?>
