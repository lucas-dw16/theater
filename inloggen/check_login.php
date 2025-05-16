<?php
session_start();
$conn = new mysqli("localhost", "root", "", "theater");

if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

$gebruikersnaam = $_POST['gebruikersnaam'] ?? '';
$wachtwoord = $_POST['wachtwoord'] ?? '';

// Veiligheid: escape invoer
$gebruikersnaam = $conn->real_escape_string($gebruikersnaam);

$sql = "SELECT * FROM Gebruiker WHERE Gebruikersnaam = '$gebruikersnaam'";
$result = $conn->query($sql);

if ($result && $result->num_rows === 1) {
    $user = $result->fetch_assoc();
    // Vergelijk versleuteld wachtwoord
    if (password_verify($wachtwoord, $user['Wachtwoord'])) {
        $_SESSION['user_id'] = $user['Id'];
        $_SESSION['gebruikersnaam'] = $user['Gebruikersnaam'];
        header("Location: dashboard.php");
        exit;
    }
}

header("Location: login.php?error=onjuiste inloggegevens");
exit;
