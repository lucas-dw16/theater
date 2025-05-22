<?php
session_start();
require_once '../config/db_connect.php';

try {
    // Haal actieve ticketgegevens op uit de Ticket tabel
    $sql = "SELECT t.Id, t.Nummer, t.Barcode, t.Status, t.Datumaangemaakt
            FROM Ticket t
            WHERE t.Isactief = 1
            ORDER BY t.Datumaangemaakt DESC";
    $result = $pdo->query($sql);
} catch (PDOException $e) {
    die("<p class='text-danger'>Fout bij ophalen van tickets: " . $e->getMessage() . "</p>");
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ticketoverzicht</title>
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
        .bekijk-knop {
            background-color: #007bff;
            color: white;
        }
        .verwijder-knop {
            background-color: #dc3545;
            color: white;
        }
        .bekijk-knop:hover, .verwijder-knop:hover {
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
    <!-- Navigatiebalk -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Ticketbeheer</a>
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
        <h1 class="mb-4 text-center">Ticketoverzicht</h1>
        <div class="mb-3">
            <a href="create_ticket.php" class="btn btn-success">
                <i class="fa fa-plus"></i> handmatig ticket toevoegen
            </a>
        </div>
        <div class="mb-3">
            <input type="text" id="zoekInput" class="form-control" placeholder="Zoek op nummer, barcode of status...">
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
                            <th>ID</th>
                            <th>Nummer</th>
                            <th>Barcode</th>
                            <th>Status</th>
                            <th>Aangemaakt op</th>
                            <th>Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['Id']) ?></td>
                                <td><?= htmlspecialchars($row['Nummer']) ?></td>
                                <td><?= htmlspecialchars($row['Barcode']) ?></td>
                                <td><?= htmlspecialchars($row['Status']) ?></td>
                                <td><?= htmlspecialchars($row['Datumaangemaakt']) ?></td>
                                <td>
                                    <a href="delete_ticket.php?id=<?= htmlspecialchars($row['Id']) ?>" class="actieknop verwijder-knop" onclick="return confirm('Weet u zeker dat u dit ticket wilt verwijderen?');">
                                        <i class="fa fa-trash"></i> Verwijderen
                                    </a>
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
            <p class="alert alert-warning">Geen tickets te weergeven.</p>
        <?php endif; ?>
    </div>

    <script src="script.js"></script>
</body>
</html>
