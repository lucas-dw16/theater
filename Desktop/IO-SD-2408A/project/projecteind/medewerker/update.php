<?php
include('../DB/config.php');

$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=UTF8", $dbUser, $dbPass);

$id = $_GET['Id'] ?? null;
if (!$id) {
    echo "Geen medewerker ID opgegeven.";
    exit;
}

$sql = "SELECT * FROM Medewerker WHERE Id = :id";
$statement = $pdo->prepare($sql);
$statement->execute(['id' => $id]);
$medewerker = $statement->fetch(PDO::FETCH_ASSOC);

if (!$medewerker) {
    echo "Medewerker niet gevonden.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "UPDATE Medewerker SET
                Voornaam = :voornaam,
                Tussenvoegsel = :tussenvoegsel,
                Achternaam = :achternaam,
                Nummer = :nummer,
                Medewerkersoort = :medewerkersoort,
                DatumGewijzigd = NOW()
            WHERE Id = :id";

    $statement = $pdo->prepare($sql);
    $statement->execute([
        'voornaam' => $_POST['Voornaam'],
        'tussenvoegsel' => $_POST['Tussenvoegsel'],
        'achternaam' => $_POST['Achternaam'],
        'nummer' => $_POST['Nummer'],
        'medewerkersoort' => $_POST['Medewerkersoort'],
        'id' => $_POST['Id']
    ]);

    header("Location: medewerker.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Medewerker bewerken</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-custom sticky">
    <div class="container-fluid">
        <ul>
            <li><img src="../Image/Logo.png" alt="logo" class="logo"></li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="../index.html">Homepage</a></li>
            <li class="nav-item"><a class="nav-link" href="../gebruikerslessen/lessen.php">Lessen</a></li>
            <li class="nav-item"><a class="nav-link active" href="../dashboard/dashboard.html">Dashboard</a></li>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    <h2 class="mb-4">Bewerk medewerker</h2>
    <form action="update.php?Id=<?= htmlspecialchars($medewerker['Id']) ?>" method="POST" class="needs-validation" novalidate>
        <input type="hidden" name="Id" value="<?= htmlspecialchars($medewerker['Id']) ?>">

        <div class="mb-3">
            <label class="form-label">Voornaam</label>
            <input type="text" class="form-control" name="Voornaam" value="<?= htmlspecialchars($medewerker['Voornaam']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tussenvoegsel</label>
            <input type="text" class="form-control" name="Tussenvoegsel" value="<?= htmlspecialchars($medewerker['Tussenvoegsel']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Achternaam</label>
            <input type="text" class="form-control" name="Achternaam" value="<?= htmlspecialchars($medewerker['Achternaam']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nummer</label>
            <input type="number" class="form-control" name="Nummer" value="<?= htmlspecialchars($medewerker['Nummer']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Medewerkersoort</label>
            <input type="text" class="form-control" name="Medewerkersoort" value="<?= htmlspecialchars($medewerker['Medewerkersoort']) ?>" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Opslaan</button>
        <a href="medewerker.php" class="btn btn-secondary">Annuleren</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
