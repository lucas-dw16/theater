<?php
session_start();
require_once '../config/db_connect.php';

$message = "";
$ticket = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $barcode = trim($_POST['barcode'] ?? '');
    if ($barcode !== '') {
        try {
            $stmt = $pdo->prepare("SELECT Id, Nummer, Barcode, Status, Datumaangemaakt FROM Ticket WHERE Barcode = :barcode AND Isactief = 1 LIMIT 1");
            $stmt->execute([':barcode' => $barcode]);
            $ticket = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($ticket) {
                $message = "<div class='alert alert-success'>Ticket gevonden: " . htmlspecialchars($ticket['Nummer']) . "</div>";
            } else {
                $message = "<div class='alert alert-danger'>Ticket niet gevonden of inactief.</div>";
            }
        } catch (PDOException $e) {
            $message = "<div class='alert alert-danger'>Fout bij ophalen van ticket: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>Voer a.u.b. een barcode in.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ticket scannen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Ticket scannen</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../inloggen/dashboard.php"><i class="fa fa-home"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-warning" href="../inloggen/logout.php">Uitloggen</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container">
        <h1 class="mb-4 text-center">Scan een Ticket</h1>
        <?php echo $message; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="barcode" class="form-label">Barcode</label>
                <input type="text" name="barcode" id="barcode" class="form-control" placeholder="Scan hier de barcode" autofocus>
            </div>
            <button type="submit" class="btn btn-primary">Ticket scannen</button>
        </form>

        <?php if ($ticket): ?>
            <div class="mt-4">
                <h3>Ticket details</h3>
                <ul class="list-group">
                    <li class="list-group-item"><strong>ID:</strong> <?= htmlspecialchars($ticket['Id']) ?></li>
                    <li class="list-group-item"><strong>Nummer:</strong> <?= htmlspecialchars($ticket['Nummer']) ?></li>
                    <li class="list-group-item"><strong>Barcode:</strong> <?= htmlspecialchars($ticket['Barcode']) ?></li>
                    <li class="list-group-item"><strong>Status:</strong> <?= htmlspecialchars($ticket['Status']) ?></li>
                    <li class="list-group-item"><strong>Aangemaakt op:</strong> <?= htmlspecialchars($ticket['Datumaangemaakt']) ?></li>
                </ul>
            </div>
        <?php endif; ?>

        <div class="mt-4">
            <a href="../inloggen/dashboard.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Terug naar Dashboard</a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>