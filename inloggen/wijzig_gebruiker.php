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
    <title>Gegevens wijzigen</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">
    <div class="container">
        <h2>Wijzig jouw gegevens</h2>
        <?php if (isset($succes)): ?>
            <div class="alert alert-success"><?php echo $succes; ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label>Voornaam</label>
                <input type="text" name="voornaam" class="form-control" value="<?php echo htmlspecialchars($user['Voornaam']); ?>" required>
            </div>
            <div class="mb-3">
                <label>Tussenvoegsel</label>
                <input type="text" name="tussenvoegsel" class="form-control" value="<?php echo htmlspecialchars($user['Tussenvoegsel']); ?>">
            </div>
            <div class="mb-3">
                <label>Achternaam</label>
                <input type="text" name="achternaam" class="form-control" value="<?php echo htmlspecialchars($user['Achternaam']); ?>" required>
            </div>
            <div class="mb-3">
                <label>E-mailadres</label>
                <input type="email" name="gebruikersnaam" class="form-control" value="<?php echo htmlspecialchars($user['Gebruikersnaam']); ?>" required>
            </div>

            <div class="mt-3">
    <button type="submit" class="btn btn-primary d-inline-block">Opslaan</button>
    <a href="dashboard.php" class="btn btn-secondary d-inline-block">
        <i class="fa fa-arrow-left"></i> Terug naar dashboard
    </a>
</div>

        </form>
    </div>
    
</body>
</html>
