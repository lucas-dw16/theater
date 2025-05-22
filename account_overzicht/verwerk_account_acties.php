<?php
session_start();
require_once '../config/db_connect.php';

header('Content-Type: text/plain');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gebruikerId = isset($_POST['gebruiker_id']) ? intval($_POST['gebruiker_id']) : 0;

    // ROL WIJZIGEN
    if (isset($_POST['rol_wijzigen']) && !empty($_POST['nieuwe_rol'])) {
        $nieuweRol = $_POST['nieuwe_rol'];

        // Alleen toegestane rollen
        $toegestaneRollen = ['Lid', 'Medewerker', 'Admin'];
        if (!in_array($nieuweRol, $toegestaneRollen)) {
            echo "error: Ongeldige rol geselecteerd.";
            exit;
        }

        try {
            // Rol check
            $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM Rol WHERE GebruikerId = ?");
            $checkStmt->execute([$gebruikerId]);
            $bestaat = $checkStmt->fetchColumn();

            if ($bestaat > 0) {
                $stmt = $pdo->prepare("UPDATE Rol SET Naam = ?, Datumgewijzigd = NOW() WHERE GebruikerId = ?");
                $stmt->execute([$nieuweRol, $gebruikerId]);
            } else {
                $stmt = $pdo->prepare("INSERT INTO Rol (GebruikerId, Naam, Isactief, Opmerking, Datumaangemaakt, Datumgewijzigd) 
                                       VALUES (?, ?, 1, '', NOW(), NOW())");
                $stmt->execute([$gebruikerId, $nieuweRol]);
            }

            echo "success";
        } catch (PDOException $e) {
            echo "error: Fout bij wijzigen rol - " . $e->getMessage();
        }
        exit;
    }

    // ACCOUNT VERWIJDEREN
    if (isset($_POST['verwijderen'])) {
        try {
            $pdo->prepare("DELETE FROM Rol WHERE GebruikerId = ?")->execute([$gebruikerId]);
            $pdo->prepare("DELETE FROM Gebruiker WHERE Id = ?")->execute([$gebruikerId]);
            echo "success";
        } catch (PDOException $e) {
            echo "error: Fout bij verwijderen - " . $e->getMessage();
        }
        exit;
    }

    // Ongeldige actie
    echo "error: Ongeldige actie.";
    exit;
}

// Geen POST-verzoek
echo "error: Ongeldige aanvraag.";
exit;
