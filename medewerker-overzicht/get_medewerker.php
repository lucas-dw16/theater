<?php
// Bestand: get_medewerker.php
require_once '../config/db_connect.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("
        SELECT m.Id, g.Voornaam, g.Tussenvoegsel, g.Achternaam, g.Gebruikersnaam, m.Medewerkersoort, m.Nummer
        FROM Medewerker m
        JOIN Gebruiker g ON m.GebruikerId = g.Id
    ");
    $medewerkers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'data' => $medewerkers]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Fout: ' . $e->getMessage()]);
}
?>
