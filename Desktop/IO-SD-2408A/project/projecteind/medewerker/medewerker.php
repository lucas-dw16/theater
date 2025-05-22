<?php
include('../DB/config.php');

$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=UTF8";
$pdo = new PDO($dsn, $dbUser, $dbPass);

if (isset($_GET['Id'])) {
    $sql = "DELETE FROM Medewerker WHERE Id = :Id";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':Id', $_GET['Id'], PDO::PARAM_INT);
    $statement->execute();

    echo "<div class='alert alert-success'>Medewerker succesvol verwijderd!</div>";
    header("Refresh:2; url=medewerker.php");
    exit;
} else {
    echo "<div class='alert alert-danger'>Geen ID opgegeven!</div>";
}
?>

<?php
include('../DB/config.php');

$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=UTF8";
$pdo = new PDO($dsn, $dbUser, $dbPass);

$sql = "SELECT Id, Voornaam, Tussenvoegsel, Achternaam, Nummer, Medewerkersoort FROM Medewerker";
$statement = $pdo->prepare($sql);
$statement->execute();
$result = $statement->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <title>Medewerker</title>
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

<div class="container">
    <div class="row mb-1">
        <div class="col-2"></div>
        <div class="col-8 title">
            <h3>Overzicht van de Medewerker</h3>
        </div>
        <div class="col-2"></div>
    </div>

    <div class="row mb-3">
        <div class="col-2"></div>
        <div class="col-8">
            <h5>Nieuwe medewerker toevoegen
                <a href='create.php' class="btn btn-success btn-sm">+</a>
            </h5>
        </div>
        <div class="col-2"></div>
    </div>

    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <table class="table table-hover" id="table-lessen">
                <thead>
                    <tr>
                        <th>Voornaam</th>
                        <th>Tussenvoegsel</th>
                        <th>Achternaam</th>
                        <th>Nummer</th>
                        <th>Medewerkersoort</th>
                        <th>Acties</th>
                    </tr>
                </thead>
               <tbody>
<?php if (count($result) === 0): ?>
    </tbody>
    </table>
    <div class="d-flex justify-content-center align-items-center" style="min-height: 200px;">
        <h5 class="text-muted">Geen medewerkers gevonden</h5>
    </div>
<?php else: ?>
    <?php foreach($result as $MedewerkerInfo): ?>
    <tr>
        <td><?= htmlspecialchars($MedewerkerInfo->Voornaam ?? '') ?></td>
        <td><?= htmlspecialchars($MedewerkerInfo->Tussenvoegsel ?? '') ?></td>
        <td><?= htmlspecialchars($MedewerkerInfo->Achternaam ?? '') ?></td>
        <td><?= htmlspecialchars($MedewerkerInfo->Nummer ?? '') ?></td>
        <td><?= htmlspecialchars($MedewerkerInfo->Medewerkersoort ?? '') ?></td>    
        <td>
            <a href="update.php?Id=<?= $MedewerkerInfo->Id ?>" class="btn btn-warning btn-sm">Bewerk</a>
            <a href="delete.php?Id=<?= $MedewerkerInfo->Id ?>" class="btn btn-danger btn-sm"
               onclick="return confirm('Weet je zeker dat je deze medewerker wilt verwijderen?')">
               Verwijder
            </a>
        </td>
    </tr>
    <?php endforeach ?>
<?php endif; ?>
</tbody>

            </table>
        </div>
        <div class="col-2"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
