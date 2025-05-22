<?php
session_start();
require_once '../config/db_connect.php';

$message = '';
$message_class = '';

try {
    // Controleren of admin al bestaat
    $checkStmt = $pdo->prepare("SELECT * FROM gebruiker WHERE Gebruikersnaam = ?");
    $checkStmt->execute(['admin1@gmail.com']);

    if ($checkStmt->rowCount() > 0) {
        $message = "Admin-gebruiker bestaat al.";
        $message_class = "alert-warning";
    } else {
        // 1. Gebruiker toevoegen
        $hashedPassword = password_hash('admin', PASSWORD_DEFAULT);
        $insertStmt = $pdo->prepare("INSERT INTO gebruiker (Voornaam, Achternaam, Gebruikersnaam, Wachtwoord) VALUES (?, ?, ?, ?)");
        $insertStmt->execute(['Admin', 'Gebruiker', 'admin1@gmail.com', $hashedPassword]);

        // 2. Rol koppelen
        $gebruikerId = $pdo->lastInsertId();
        $rolStmt = $pdo->prepare("INSERT INTO Rol (GebruikerId, Naam) VALUES (?, ?)");
        $rolStmt->execute([$gebruikerId, 'admin']);

        $message = "Admin succesvol aangemaakt!";
        $message_class = "alert-success";
    }
} catch (PDOException $e) {
    $message = "Fout bij aanmaken: " . $e->getMessage();
    $message_class = "alert-danger";
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <title>Admin Aanmaken</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">

<div class="card p-4 shadow" style="min-width: 400px;">
  <h3 class="mb-3">Admin aanmaken</h3>

  <?php if (!empty($message)): ?>
    <div class="alert <?= $message_class ?>">
      <?= htmlspecialchars($message) ?>
    </div>
  <?php endif; ?>

  <form method="POST">
    <button type="submit" class="btn btn-primary w-100">Voeg admin toe</button>
  </form>

  <a href="login.php" class="btn btn-link mt-3">← Terug naar login</a>
</div>

</body>
</html>
