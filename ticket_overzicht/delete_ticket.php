<?php
// delete_ticket.php

// Start session if necessary
session_start();

// Check if the 'id' parameter is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // If not, redirect to the overview page (adjust the path as needed)
    header("Location: ticket_overzicht.php");
    exit;
}

// Sanitize the ticket id
$ticketId = intval($_GET['id']);

// Database connection settings (update with your actual configuration)
$host = 'localhost';
$dbname = 'theater';
$user = 'root';
$password = '';

try {
    // Create PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare and execute the DELETE statement
    $stmt = $pdo->prepare("DELETE FROM ticket WHERE Id = :id");
    $stmt->bindParam(':id', $ticketId, PDO::PARAM_INT);
    $stmt->execute();

    // Redirect back to the overview page after deletion (adjust as needed)
    header("Location: ticket_overzicht.php");
    exit;

} catch (PDOException $e) {
    // Handle any errors (consider logging errors in production)
    echo "Error: " . $e->getMessage();
    exit;
}
?>