    <?php
    include '../config/db_connect.php';


    session_start();
    $message = "";
    $toastClass = "";
    
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        $toastClass = $_SESSION['message_class'] ?? 'bg-success';
        unset($_SESSION['message']);
        unset($_SESSION['message_class']);
    }
    
    


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $actie = $_POST['actie'] ?? '';

    if ($actie === 'inloggen') {
    $gebruikersnaam = trim($_POST['gebruikersnaam'] ?? '');
    $wachtwoord = trim($_POST['wachtwoord'] ?? '');

    if ($gebruikersnaam && $wachtwoord) {
        $stmt = $pdo->prepare("SELECT * FROM gebruiker WHERE Gebruikersnaam = ? AND Isactief = 1 LIMIT 1");
        $stmt->execute([$gebruikersnaam]);
        $gebruiker = $stmt->fetch();

        if ($gebruiker && password_verify($wachtwoord, $gebruiker['Wachtwoord'])) {
            // Inloggen geslaagd
            $_SESSION['gebruiker_id'] = $gebruiker['Id'];
            $_SESSION['gebruikersnaam'] = $gebruiker['Gebruikersnaam'];

            // Haal de rol op vóór redirect
            $rolStmt = $pdo->prepare("SELECT Naam FROM rol WHERE GebruikerId = ?");
            $rolStmt->execute([$gebruiker['Id']]);
            $rolData = $rolStmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['rol'] = $rolData ? $rolData['Naam'] : null;

            $_SESSION['message'] = "Welkom terug, " . htmlspecialchars($gebruiker['Voornaam']) . "!";
            $_SESSION['message_class'] = "alert-success";

            header("Location: dashboard.php");
            exit();
        } else {
            $message = "Ongeldige inloggegevens.";
            $toastClass = "alert-danger";
        }
    } else {
        $message = "Vul alle velden in.";
        $toastClass = "alert-warning";
    }
}


    if ($actie === 'registreer') {
        // nieuwe registratiecode
        $voornaam = trim($_POST['voornaam'] ?? '');
        $tussenvoegsel = trim($_POST['tussenvoegsel'] ?? '');
        $achternaam = trim($_POST['achternaam'] ?? '');
        $gebruikersnaam = trim($_POST['gebruikersnaam'] ?? '');
        $wachtwoord = trim($_POST['wachtwoord'] ?? '');

        if ($voornaam && $achternaam && $gebruikersnaam && $wachtwoord) {
            // Check of e-mailadres al bestaat
            $checkStmt = $pdo->prepare("SELECT Id FROM gebruiker WHERE Gebruikersnaam = ?");
            $checkStmt->execute([$gebruikersnaam]);

            if ($checkStmt->rowCount() > 0) {
                $message = "Dit e-mailadres is al in gebruik.";
                $toastClass = "alert-danger";
            } else {
                // Wachtwoord hashen
                $hashedPassword = password_hash($wachtwoord, PASSWORD_DEFAULT);

                // Insert gebruiker
                $insertStmt = $pdo->prepare("INSERT INTO gebruiker (Voornaam, Tussenvoegsel, Achternaam, Gebruikersnaam, Wachtwoord)
                                             VALUES (?, ?, ?, ?, ?)");
                $inserted = $insertStmt->execute([$voornaam, $tussenvoegsel, $achternaam, $gebruikersnaam, $hashedPassword]);

                if ($inserted) {
                    $_SESSION['message'] = "Account succesvol aangemaakt. Log nu in.";
                    $_SESSION['message_class'] = "alert-success";
                    header("Location: login.php");
                    exit();
                } else {
                    $message = "Er is iets misgegaan bij het registreren.";
                    $toastClass = "alert-danger";
                }
            }
        } else {
            $message = "Vul alle verplichte velden in.";
            $toastClass = "alert-warning";
        }
    }
}


    $_SESSION['LAST_ACTIVITY'] = time(); // Reset timer bij activiteit



    
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
        <link rel="stylesheet" href="style/login-style.css">
        <title>Inloggen</title>
    </head>
    <body>

<?php if (!empty($message)): ?>
<div class="alert <?= $toastClass ?> text-white p-3" role="alert">
  <?= htmlspecialchars($message) ?>
</div>
<?php endif; ?>

    <div class="container" id="container">
    <div class="form-container sign-up-container">
<form action="" method="POST">
      <input type="hidden" name="actie" value="registreer"> <!-- Belangrijk -->
    <h1>Account Aanmaken</h1>
    <input type="text" name="voornaam" placeholder="Voornaam" required />
    <input type="text" name="tussenvoegsel" placeholder="Tussenvoegsel (optioneel)" />
    <input type="text" name="achternaam" placeholder="Achternaam" required />
    <input type="email" name="gebruikersnaam" placeholder="E-mailadres" required />
    <input type="password" name="wachtwoord" placeholder="Wachtwoord" required />
    <button type="submit">Registreren</button>
  </form>
</div>


    <div class="form-container sign-in-container">
<form action="" method="POST">
      <input type="hidden" name="actie" value="inloggen"> <!-- Belangrijk -->

    <h1>Inloggen</h1>
    <input type="email" name="gebruikersnaam" placeholder="E-mailadres" required />
    <input type="password" name="wachtwoord" placeholder="Wachtwoord" required />
    <button type="submit">Inloggen</button>
  </form>
</div>


    <div class="overlay-container">
        <div class="overlay">
        <div class="overlay-panel overlay-left">
            <h1>Welkom terug!</h1>
            <p>Log in met je gegevens</p>
            <button class="ghost" id="signIn">Inloggen</button>
            <a href="dashboard.php"></a>
        </div>
        <div class="overlay-panel overlay-right">
            <h1>Hello, Welcome!</h1>
            <p>Maak een account aan</p>
            <button class="ghost" id="signUp">Registreren</button>


        </div>
        </div>
    </div>
    </div>

    <script>
    const container = document.getElementById('container');
    document.getElementById('signUp').addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });
    document.getElementById('signIn').addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });
    setTimeout(() => {
    const alert = document.querySelector('.alert');
    if (alert) {
        alert.remove();
    }
}, 4000);
    </script>
    </body>
    </html>
