<?php
// Bestand: update_medewerker.php
require_once '../config/db_connect.php';

header('Content-Type: application/json');

if (
    isset($_POST['id'], $_POST['voornaam'], $_POST['achternaam'], $_POST['gebruikersnaam'], $_POST['medewerkersoort'], $_POST['nummer'])
) {
    try {
        $id = intval($_POST['id']);
        $voornaam = trim($_POST['voornaam']);
        $tussenvoegsel = trim($_POST['tussenvoegsel'] ?? '');
        $achternaam = trim($_POST['achternaam']);
        $gebruikersnaam = trim($_POST['gebruikersnaam']);
        $medewerkersoort = trim($_POST['medewerkersoort']);
        $nummer = intval($_POST['nummer']);

        // 1. Haal gebruikerId op via medewerkerId
        $stmt = $pdo->prepare("SELECT GebruikerId FROM Medewerker WHERE Id = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount() === 0) {
            echo json_encode(['success' => false, 'message' => 'Medewerker niet gevonden.']);
            exit();
        }

        $gebruikerId = $stmt->fetchColumn();

        // 2. Update gebruiker
        $updateGebruiker = $pdo->prepare("UPDATE Gebruiker SET Voornaam = ?, Tussenvoegsel = ?, Achternaam = ?, Gebruikersnaam = ? WHERE Id = ?");
        $updateGebruiker->execute([$voornaam, $tussenvoegsel, $achternaam, $gebruikersnaam, $gebruikerId]);

        // 3. Update medewerker
        $updateMedewerker = $pdo->prepare("UPDATE Medewerker SET Medewerkersoort = ?, Nummer = ? WHERE Id = ?");
        $updateMedewerker->execute([$medewerkersoort, $nummer, $id]);

        echo json_encode(['success' => true, 'message' => 'Medewerker succesvol bijgewerkt.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Fout bij bijwerken: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Niet alle vereiste velden zijn ingevuld.']);
}
?>
