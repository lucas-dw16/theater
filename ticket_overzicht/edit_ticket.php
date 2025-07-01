<?php
// edit_ticket.php

session_start();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ticket_overzicht.php");
    exit;
}

$ticketId = intval($_GET['id']);

$host = 'localhost';
$dbname = 'theater';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = isset($_POST['id']) ? trim($_POST['id']) : '';
        $barcode = isset($_POST['barcode']) ? trim($_POST['barcode']) : '';
        $status = isset($_POST['status']) ? trim($_POST['status']) : '';

        if ($id && $barcode && $status) {
            $stmt = $pdo->prepare("UPDATE ticket SET Id = :newid, Barcode = :barcode, Status = :status WHERE Id = :id");
            $stmt->bindParam(':newid', $id, PDO::PARAM_INT);
            $stmt->bindParam(':barcode', $barcode);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $ticketId, PDO::PARAM_INT);
            $stmt->execute();

            header("Location: ticket_overzicht.php");
            exit;
        } else {
            $error = "Vul alle velden in.";
        }
    }

    $stmt = $pdo->prepare("SELECT * FROM ticket WHERE Id = :id");
    $stmt->bindParam(':id', $ticketId, PDO::PARAM_INT);
    $stmt->execute();
    $ticket = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$ticket) {
        header("Location: ticket_overzicht.php");
        exit;
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Ticket Bewerken</title>
    <link rel="stylesheet" href="edit_pagina.css">
</head>
<body>
    <h1>Ticket Bewerken</h1>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        <label>Nummer: <input type="text" name="nummer" value="<?php echo htmlspecialchars($ticket['Nummer']); ?>" required></label><br>
        <label>Barcode: <input type="text" name="barcode" value="<?php echo htmlspecialchars($ticket['Barcode']); ?>" required></label><br>
        <label>Status: <input type="text" name="status" value="<?php echo htmlspecialchars($ticket['Status']); ?>" required></label><br>    
        <button type="submit">Opslaan</button>
        <a href="ticket_overzicht.php">Annuleren</a>
    </form>
</body>
</html>