<?php
session_start();

// Check if logout reason is timeout
if (isset($_GET['reason']) && $_GET['reason'] === 'timeout') {
    $message = 'Uw sessie is verlopen, log opnieuw in.';
    $message_class = 'alert-danger'; // correct
} else {
    $message = 'Succesvol uitgelogd.';
    $message_class = 'alert-success'; // correct
}


// Sessie leegmaken en vernietigen
session_unset();
session_destroy();

// Nieuwe sessie starten voor de melding
session_start();
session_regenerate_id(true); // Nieuwe sessie-ID voor veiligheid
$_SESSION['message'] = $message;
$_SESSION['message_class'] = $message_class;

// Terug naar loginpagina
header("Location: login.php");
exit();
