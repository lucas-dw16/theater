<?php
include '../config/db_connect.php';
// Verbind met de database

session_start();

$message = "";
$toastClass = "";
// Als er een eerdere melding in de sessie staat (bijv. na redirect), haal die op

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $toastClass = $_SESSION['message_class'] ?? 'alert-success';
    unset($_SESSION['message'], $_SESSION['message_class']);
}
// Verwerk het formulier als het een POST-verzoek is (dus als iemand probeert in te loggen)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gebruikersnaam = trim($_POST['gebruikersnaam'] ?? '');
    $wachtwoord = trim($_POST['wachtwoord'] ?? '');
    // Controleer of beide velden zijn ingevuld

    if (!empty($gebruikersnaam) && !empty($wachtwoord)) 
            // Bereid een SQL-query voor om gebruiker + rol op te halen via LEFT JOIN
{
        $stmt = $pdo->prepare("SELECT g.Id, g.Wachtwoord, r.Naam AS Rol 
                               FROM gebruiker g 
                               LEFT JOIN Rol r ON g.Id = r.GebruikerId 
                               WHERE g.Gebruikersnaam = ?");
        $stmt->execute([$gebruikersnaam]);
        // Controleer of er een gebruiker is gevonden

        if ($stmt->rowCount() > 0) 
                // Haal de gegevens van de gebruiker op
{
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($wachtwoord, $user['Wachtwoord'])) {
                $_SESSION['gebruiker_id'] = $user['Id'];
                $_SESSION['gebruikersnaam'] = $gebruikersnaam;
                $_SESSION['rol'] = $user['Rol'];
                $_SESSION['logged_in'] = true;

                $_SESSION['message'] = 'Je bent succesvol ingelogd!';
                $_SESSION['message_class'] = 'alert-success';
                header("Location: ../index.php");
                exit();
            } else 
                            // Wachtwoord klopt niet
{
                $message = "Onjuist e-mailadres of wachtwoord.";
                $toastClass = "alert-danger";
            }
        } else             // Geen gebruiker gevonden met dat e-mailadres

        {
            $message = "E-mailadres niet gevonden.";
            $toastClass = "alert-warning";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="inloggen.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
  <link rel="shortcut icon" href="https://cdn-icons-png.flaticon.com/512/295/295128.png" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="inloggen.css" />
  <link rel="stylesheet" href="inloggen.css">
  <script src="inloggen.js"></script>



  <title>Inloggen</title>
  <style>
    .alert {
      position: fixed;
      top: 20px;
      right: 20px;
      z-index: 1050;
      min-width: 300px;
      padding: 15px 20px;
      border-radius: 8px;
      font-weight: bold;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      opacity: 0.95;
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top shadow">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="../index.php">Theater Aurora</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="../index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../index.php#voorstellingen">Voorstellingen</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../index.php#over">Over</a>
        </li>
      </ul>

      <div class="d-flex align-items-center">
        <button class="btn btn-sm btn-light me-2" onclick="document.body.classList.toggle('dark-mode')">
          🌗 Donker/licht
        </button>
        <?php if (isset($_SESSION['gebruiker_id'])): ?>
          <a href="logout.php" class="btn btn-outline-light">Uitloggen</a>
        <?php else: ?>
          <a href="login.php" class="btn btn-outline-light">Inloggen</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>


<!-- Zorg dat het formulier niet onder navbar geplakt zit -->
<div style="margin-top: 90px;"></div>

<?php if (!empty($message)): ?>
  <div class="alert <?= $toastClass ?> p-3" role="alert">
    <?= htmlspecialchars($message) ?>
  </div>
<?php endif; ?>

<div class="container" id="container">
  <div class="form-container sign-up-container">
    <form action="registratie.php" method="POST">
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
      </div>
      <div class="overlay-panel overlay-right">
        <h1>Hello, Welcome!</h1>
        <p>Maak een account aan</p>
        <button class="ghost" id="signUp">Registreren</button>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

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
    if (alert) alert.remove();
  }, 4000);
  window.addEventListener('scroll', function () {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
      navbar.classList.add('bg-dark');
    } else {
      navbar.classList.remove('bg-dark');
    }
  });
document.getElementById("loginForm").addEventListener("submit", function (e) {
  const username = this.gebruikersnaam.value.trim();
  const password = this.wachtwoord.value.trim();

  if (username === "" || password === "") {
    e.preventDefault();
    alert("Vul zowel gebruikersnaam als wachtwoord in.");
  }
});
</script>

</body>
</html>
