<?php
// Bestand: delete_medewerker.php
require_once '../config/db_connect.php';

header('Content-Type: application/json');

// Controleer of medewerker ID is meegegeven
if (isset($_POST['id'])) {
    $medewerkerId = intval($_POST['id']);

    try {
        // Zoek de bijbehorende gebruikerId
        $stmt = $pdo->prepare("SELECT GebruikerId FROM Medewerker WHERE Id = ?");
        $stmt->execute([$medewerkerId]);

        if ($stmt->rowCount() === 0) {
            echo json_encode(['success' => false, 'message' => 'Medewerker niet gevonden.']);
            exit();
        }

        $gebruikerId = $stmt->fetchColumn();

        // Verwijder de gebruiker (cascade verwijdert automatisch ook medewerker en rol)
        $delete = $pdo->prepare("DELETE FROM Gebruiker WHERE Id = ?");
        $delete->execute([$gebruikerId]);

        echo json_encode(['success' => true, 'message' => 'Medewerker succesvol verwijderd.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Fout bij verwijderen: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Geen medewerker ID opgegeven.']);
}
?>