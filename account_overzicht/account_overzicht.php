<?php
session_start();
require_once '../config/db_connect.php';

// Controleer of de gebruiker is ingelogd

try {
    $sql = "SELECT g.Id, Voornaam, Tussenvoegsel, Achternaam, Gebruikersnaam, g.Isactief, g.Datumaangemaakt, r.Naam AS Rol
            FROM Gebruiker g
            LEFT JOIN Rol r ON g.Id = r.GebruikerId
            ORDER BY g.Datumaangemaakt DESC";
    $result = $pdo->query($sql);
} catch (PDOException $e) {
    die("<p class='text-danger'>Fout bij ophalen van accounts: " . $e->getMessage() . "</p>");
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Belangrijk voor mobiel -->
    <title>Accountoverzicht</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

    <style>
        .actieknop {
            padding: 6px 12px;
            margin: 2px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .wijzig-knop {
            background-color: #007bff;
            color: white;
        }

        .verwijder-knop {
            background-color: #dc3545;
            color: white;
        }

        .verwijder-knop:hover, .wijzig-knop:hover {
            opacity: 0.85;
        }

        .success {
            color: green;
            margin-top: 10px;
        }

        .error {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navigatiebalk met hamburger -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Accountbeheer</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#hoofdMenu" aria-controls="hoofdMenu" aria-expanded="false" aria-label="Toggle navigatie">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="hoofdMenu">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="../inloggen/dashboard.php">
                        <i class="fa fa-home"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Instellingen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-warning" href="../inloggen/logout.php">Uitloggen</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <div class="container py-4">
        <h1 class="mb-4 text-center">Accountoverzicht</h1>

        <div class="mb-3">
            <input type="text" id="zoekInput" class="form-control" placeholder="Zoek op naam of gebruikersnaam...">
        </div>

        <?php if ($result && $result->rowCount() > 0): ?>
            <?php if (isset($_SESSION['actie_succes'])): ?>
                <div class="alert alert-success"><?= $_SESSION['actie_succes']; unset($_SESSION['actie_succes']); ?></div>
            <?php endif; ?>
            <?php if (isset($_SESSION['actie_fout'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['actie_fout']; unset($_SESSION['actie_fout']); ?></div>
            <?php endif; ?>

            <!-- Responsive table wrapper -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover bg-white">
                    <thead class="table-light">
                        <tr>
                            <th>nummer</th>
                            <th>Naam</th>
                            <th>Gebruikersnaam</th>
                            <th>Rol</th>
                            <th>Actief</th>
                            <th>Aangemaakt op</th>
                            <th>Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['Id']) ?></td>
                                <td><?= htmlspecialchars(trim($row['Voornaam'] . ' ' . $row['Tussenvoegsel'] . ' ' . $row['Achternaam'])) ?></td>
                                <td><?= htmlspecialchars($row['Gebruikersnaam']) ?></td>
                                <td><?= htmlspecialchars($row['Rol'] ?? 'Onbekend') ?></td>
                                <td><?= $row['Isactief'] ? 'Ja' : 'Nee' ?></td>
                                <td><?= htmlspecialchars($row['Datumaangemaakt']) ?></td>
                                <td>
                                    <form method="post" action="verwerk_account_acties.php" class="d-inline">
                                        <input type="hidden" name="gebruiker_id" value="<?= $row['Id'] ?>">
                                        <select name="nieuwe_rol" class="form-select form-select-sm d-inline w-auto">
                                            <option value="Lid">Lid</option>
                                            <option value="Medewerker">Medewerker</option>
                                            <option value="Admin">Admin</option>
                                        </select>
                                        <button type="submit" name="rol_wijzigen" class="actieknop wijzig-knop btn btn-sm">Wijzig</button>
                                    </form>
                                    <form method="post" action="verwerk_account_acties.php" class="d-inline" onsubmit="return confirm('Weet je zeker dat je dit account wilt verwijderen?');">
                                        <input type="hidden" name="gebruiker_id" value="<?= $row['Id'] ?>">
                                        <button type="submit" name="verwijderen" class="actieknop verwijder-knop btn btn-sm">Verwijder</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="d-grid gap-2 mt-4">
                <a href="../inloggen/dashboard.php" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Terug naar dashboard
                </a>
            </div>
        <?php else: ?>
            <p class="alert alert-warning">Geen accounts te weergeven.</p>
        <?php endif; ?>
    </div>
<!-- Bootstrap Bundle met Popper (vereist voor navbar toggling) -->

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
