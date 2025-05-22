<?php
session_start();
require_once "../config/db_connect.php";

if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['gebruiker_id'];

// Ophalen huidige gegevens
$stmt = $pdo->prepare("SELECT Voornaam, Tussenvoegsel, Achternaam, Gebruikersnaam FROM gebruiker WHERE Id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Bijwerken als het formulier is verzonden
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $voornaam = $_POST['voornaam'];
    $tussenvoegsel = $_POST['tussenvoegsel'] ?? '';
    $achternaam = $_POST['achternaam'];
    $gebruikersnaam = $_POST['gebruikersnaam'];

    $stmt = $pdo->prepare("UPDATE gebruiker SET Voornaam = ?, Tussenvoegsel = ?, Achternaam = ?, Gebruikersnaam = ?, Datumgewijzigd = NOW() WHERE Id = ?");
    $stmt->execute([$voornaam, $tussenvoegsel, $achternaam, $gebruikersnaam, $userId]);

    $succes = "Gegevens succesvol bijgewerkt.";
    // Eventueel ook $_SESSION['gebruikersnaam'] bijwerken
    $_SESSION['gebruikersnaam'] = $gebruikersnaam;
}

define('TIMEOUT', 900); // 15 minuten = 900 seconden

if (!isset($_SESSION['LAST_ACTIVITY'])) {
    $_SESSION['LAST_ACTIVITY'] = time();
} elseif (time() - $_SESSION['LAST_ACTIVITY'] > TIMEOUT) {
    // Sessie verlopen
    header("Location: logout.php?reason=timeout");
    exit();
}

$_SESSION['LAST_ACTIVITY'] = time(); // Reset timer bij activiteit

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- ✅ Dit is essentieel voor mobiel -->
    <title>Gegevens wijzigen</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome voor icoon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                <h2 class="text-center mb-4">Wijzig jouw gegevens</h2>

                <?php if (isset($succes)): ?>
                    <div class="alert alert-success"><?php echo $succes; ?></div>
                <?php endif; ?>

                <form method="post" class="bg-white p-4 rounded shadow-sm">
                    <div class="mb-3">
                        <label for="voornaam" class="form-label">Voornaam</label>
                        <input type="text" id="voornaam" name="voornaam" class="form-control" 
                               value="<?php echo htmlspecialchars($user['Voornaam']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="tussenvoegsel" class="form-label">Tussenvoegsel</label>
                        <input type="text" id="tussenvoegsel" name="tussenvoegsel" class="form-control" 
value="<?php echo isset($user['Tussenvoegsel']) ? htmlspecialchars($user['Tussenvoegsel']) : ''; ?>"
>
                    </div>

                    <div class="mb-3">
                        <label for="achternaam" class="form-label">Achternaam</label>
                        <input type="text" id="achternaam" name="achternaam" class="form-control" 
                               value="<?php echo htmlspecialchars($user['Achternaam']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="gebruikersnaam" class="form-label">E-mailadres</label>
                        <input type="email" id="gebruikersnaam" name="gebruikersnaam" class="form-control" 
                               value="<?php echo htmlspecialchars($user['Gebruikersnaam']); ?>" required>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            Opslaan
                        </button>
                        <a href="dashboard.php" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Terug naar dashboard
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optioneel, voor extra interactiviteit) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
