<?php
include '../config/db_connect.php';
session_start();

$message = "";
$message_class = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $voornaam = trim($_POST['voornaam'] ?? '');
    $tussenvoegsel = trim($_POST['tussenvoegsel'] ?? '');
    $achternaam = trim($_POST['achternaam'] ?? '');
    $gebruikersnaam = trim($_POST['gebruikersnaam'] ?? '');
    $wachtwoord = trim($_POST['wachtwoord'] ?? '');

    if ($voornaam && $achternaam && $gebruikersnaam && $wachtwoord) {
        $checkStmt = $pdo->prepare("SELECT Id FROM gebruiker WHERE Gebruikersnaam = ?");
        $checkStmt->execute([$gebruikersnaam]);

        if ($checkStmt->rowCount() > 0) {
            $message = "Dit e-mailadres is al in gebruik.";
            $message_class = "alert-danger";
        } else {
            $hashedPassword = password_hash($wachtwoord, PASSWORD_DEFAULT);

            $insertStmt = $pdo->prepare("INSERT INTO gebruiker (Voornaam, Tussenvoegsel, Achternaam, Gebruikersnaam, Wachtwoord)
                                         VALUES (?, ?, ?, ?, ?)");
            $inserted = $insertStmt->execute([$voornaam, $tussenvoegsel, $achternaam, $gebruikersnaam, $hashedPassword]);

            if ($inserted) {
                $message = "Account succesvol aangemaakt. Je wordt doorgestuurd naar de loginpagina...";
                $message_class = "alert-success";
                // Automatisch redirect na 5 seconden
                echo '<meta http-equiv="refresh" content="5;url=login.php">';
            } else {
                $message = "Er is iets misgegaan bij het registreren.";
                $message_class = "alert-danger";
            }
        }
    } else {
        $message = "Vul alle verplichte velden in.";
        $message_class = "alert-warning";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="inloggen.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
  <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/295/295128.png">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <title>Registreren</title>
  <style>
    * {
      box-sizing: border-box;
    }
    body {
      font-family: 'Arial', sans-serif;
      background:rgb(246, 245, 247);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .container {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 14px 28px rgb(0, 0, 0), 
                  0 10px 10px rgba(16, 157, 0, 0.94);
      width: 500px;
      max-width: 100%;
      padding: 40px;
    }
    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }
    input {
      padding: 12px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }
    button {
      padding: 12px;
      background-color: #4a90e2;
      border: none;
      color: white;
      border-radius: 20px;
      text-transform: uppercase;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    button:hover {
      background-color: #367bd6;
    }
    .alert {
        color: #fff;
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 1050;
      min-width: 300px;
      padding: 15px 20px;
      border-radius: 8px;
      font-weight: bold;
      box-shadow: 0 4px 8px rgb(255, 255, 255);
      opacity: 0.95;
      background-color: green;
    }
    .alert-danger {
        color: #fff;
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 1050;
      min-width: 300px;
      padding: 15px 20px;
      border-radius: 8px;
      font-weight: bold;
      box-shadow: 0 4px 8px rgb(255, 255, 255);
      opacity: 0.95;
      background-color: red;    }
    .terug-link {
      text-align: center;
      margin-top: 10px;
    }
    .terug-link a {
      color: #4a90e2;
      text-decoration: none;
    }
    .terug-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<?php if (!empty($message)) : ?>
  <div class="alert <?= $message_class ?>" role="alert">
    <?= htmlspecialchars($message) ?>
  </div>
<?php endif; ?>

<div class="container">
  <form method="POST">
    <h2 style="text-align: center;">Account Aanmaken</h2>
    <input type="text" name="voornaam" placeholder="Voornaam" required>
    <input type="text" name="tussenvoegsel" placeholder="Tussenvoegsel (optioneel)">
    <input type="text" name="achternaam" placeholder="Achternaam" required>
    <input type="email" name="gebruikersnaam" placeholder="E-mailadres" required>
    <input type="password" name="wachtwoord" placeholder="Wachtwoord" required>
    <button type="submit">Registreren</button>
    <div class="terug-link">
      <a href="login.php">← Terug naar inloggen</a>
    </div>
  </form>
</div>

<script>
  setTimeout(() => {
    const alert = document.querySelector('.alert');
    if (alert) alert.remove();
  }, 4000);
</script>

</body>
</html>
