<?php
session_start();
require_once '../config/db_connect.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize values from the form
    $nummer = trim($_POST['nummer'] ?? '');
    $barcode = trim($_POST['barcode'] ?? '');
    $status = trim($_POST['status'] ?? '');

    // Basic validation
    if (empty($nummer)) {
        $errors[] = "Nummer is verplicht.";
    }
    if (empty($barcode)) {
        $errors[] = "Barcode is verplicht.";
    }
    if (empty($status)) {
        $errors[] = "Status is verplicht.";
    }
    
    if (empty($errors)) {
        try {
            $sql = "INSERT INTO Ticket (Nummer, Barcode, Status, Datumaangemaakt, Isactief)
                    VALUES (:nummer, :barcode, :status, NOW(), 1)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nummer' => $nummer,
                ':barcode' => $barcode,
                ':status' => $status
            ]);
            $_SESSION['actie_succes'] = "Ticket succesvol aangemaakt.";
            header('Location: ../ticket_overzicht/ticket_overzicht.php');
            exit;
        } catch (PDOException $e) {
            $errors[] = "Fout bij het aanmaken van het ticket: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nieuw Ticket Aanmaken</title>
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
        .terug-knop {
            background-color: #6c757d;
            color: white;
        }
        .submit-knop {
            background-color: #28a745;
            color: white;
        }
        .submit-knop:hover, .terug-knop:hover {
            opacity: 0.85;
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
                        <a class="nav-link" href="../inloggen/dashboard.php">
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
        <h1 class="mb-4 text-center">Maak Nieuw Ticket</h1>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <div><?= htmlspecialchars($error) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form method="post" action="create_ticket.php">
                    <div class="mb-3">
                        <label for="nummer" class="form-label">Nummer</label>
                        <input type="text" class="form-control" id="nummer" name="nummer" value="<?= htmlspecialchars($nummer ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="barcode" class="form-label">Barcode</label>
                        <input type="text" class="form-control" id="barcode" name="barcode" value="<?= htmlspecialchars($barcode ?? '') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <input type="text" class="form-control" id="status" name="status" value="<?= htmlspecialchars($status ?? '') ?>" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="../ticket_overzicht/ticket_overzicht.php" class="btn terugg-knop actieknop">
                            <i class="fa fa-arrow-left"></i> Terug naar Overzicht
                        </a>
                        <button type="submit" class="btn submit-knop actieknop">
                            <i class="fa fa-save"></i> Ticket Aanmaken
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>