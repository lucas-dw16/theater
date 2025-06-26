<?php
session_start();
require_once "../config/db_connect.php";

// Sessietime-out van 15 minuten
define('TIMEOUT', 900);
if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: login.php");
    exit();
}
if (!isset($_SESSION['LAST_ACTIVITY'])) {
    $_SESSION['LAST_ACTIVITY'] = time();
} elseif (time() - $_SESSION['LAST_ACTIVITY'] > TIMEOUT) {
    session_destroy();
    header("Location: logout.php?reason=timeout");
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time();

// Ingelogde gebruiker ophalen
$userId = $_SESSION['gebruiker_id'];

// Verwijderen
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['verwijder_account'])) {
    try {
        $pdo->prepare("DELETE FROM Rol WHERE GebruikerId = ?")->execute([$userId]);
        $pdo->prepare("DELETE FROM Gebruiker WHERE Id = ?")->execute([$userId]);
        session_destroy();
        header("Location: account_verwijderd.php");
        exit;
    } catch (PDOException $e) {
        $fout = "Fout bij verwijderen: " . $e->getMessage();
    }
}

// Gegevens bijwerken
if ($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_POST['verwijder_account'])) {
    $voornaam = $_POST['voornaam'] ?? '';
    $tussenvoegsel = $_POST['tussenvoegsel'] ?? '';
    $achternaam = $_POST['achternaam'] ?? '';
    $gebruikersnaam = $_POST['gebruikersnaam'] ?? '';

    try {
        $stmt = $pdo->prepare("UPDATE gebruiker SET Voornaam = ?, Tussenvoegsel = ?, Achternaam = ?, Gebruikersnaam = ?, Datumgewijzigd = NOW() WHERE Id = ?");
        $stmt->execute([$voornaam, $tussenvoegsel, $achternaam, $gebruikersnaam, $userId]);
        $_SESSION['gebruikersnaam'] = $gebruikersnaam;
        $succes = "Gegevens succesvol bijgewerkt.";
    } catch (PDOException $e) {
        $fout = "Fout bij bijwerken: " . $e->getMessage();
    }
}

// Huidige gegevens ophalen
$stmt = $pdo->prepare("SELECT Voornaam, Tussenvoegsel, Achternaam, Gebruikersnaam FROM gebruiker WHERE Id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Gegevens wijzigen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap + FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
            <h2 class="text-center mb-4">Wijzig jouw gegevens</h2>

            <?php if (isset($succes)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($succes) ?></div>
            <?php endif; ?>
            <?php if (isset($fout)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($fout) ?></div>
            <?php endif; ?>

            <form method="post" class="bg-white p-4 rounded shadow-sm">
                <div class="mb-3">
                    <label for="voornaam" class="form-label">Voornaam</label>
                    <input type="text" id="voornaam" name="voornaam" class="form-control" value="<?= htmlspecialchars($user['Voornaam']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="tussenvoegsel" class="form-label">Tussenvoegsel</label>
                    <input type="text" id="tussenvoegsel" name="tussenvoegsel" class="form-control" value="<?= htmlspecialchars($user['Tussenvoegsel'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label for="achternaam" class="form-label">Achternaam</label>
                    <input type="text" id="achternaam" name="achternaam" class="form-control" value="<?= htmlspecialchars($user['Achternaam']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="gebruikersnaam" class="form-label">E-mailadres</label>
                    <input type="email" id="gebruikersnaam" name="gebruikersnaam" class="form-control" value="<?= htmlspecialchars($user['Gebruikersnaam']) ?>" required>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Opslaan</button>
                    <a href="dashboard.php" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Terug naar dashboard
                    </a>
                </div>
            </form>

            <!-- Verwijderknop -->
            <form method="post" onsubmit="return confirm('Weet je zeker dat je je account wilt verwijderen?');" class="mt-3">
                <input type="hidden" name="verwijder_account" value="1">
                <button type="submit" class="btn btn-danger w-100">
                    <i class="fa fa-trash"></i> Verwijder mijn account
                </button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
