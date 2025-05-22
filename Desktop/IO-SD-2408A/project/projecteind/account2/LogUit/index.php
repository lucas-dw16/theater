<?php
session_start(); // Start the session to access session data

// Destroy session on logout
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to the login page or home page after logging out
header('Location: ../dashboard.php');
exit();
?>
