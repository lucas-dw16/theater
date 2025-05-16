<?php
session_start();
require_once '../config/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gebruikerId = isset($_POST['gebruiker_id']) ? intval($_POST['gebruiker_id']) : 0;

    // 1. ROL WIJZIGEN
    if (isset($_POST['rol_wijzigen']) && !empty($_POST['nieuwe_rol'])) {
        $nieuweRol = $_POST['nieuwe_rol'];

        // Beveiliging: alleen toegestane rollen
        $toegestaneRollen = ['Lid', 'Medewerker', 'Admin'];
        if (!in_array($nieuweRol, $toegestaneRollen)) {
            $_SESSION['actie_fout'] = "Ongeldige rol geselecteerd.";
            header("Location: account_overzicht.php");
            exit;
        }

        try {
            // Controleer of er al een rol is
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

            $_SESSION['actie_succes'] = "Rol succesvol gewijzigd.";
        } catch (PDOException $e) {
            $_SESSION['actie_fout'] = "Fout bij wijzigen rol: " . $e->getMessage();
        }

        header("Location: account_overzicht.php");
        exit;
    }

    // 2. ACCOUNT VERWIJDEREN
    if (isset($_POST['verwijderen'])) {
        try {
            // Eerst de rol verwijderen
            $pdo->prepare("DELETE FROM Rol WHERE GebruikerId = ?")->execute([$gebruikerId]);

            // Dan de gebruiker
            $pdo->prepare("DELETE FROM Gebruiker WHERE Id = ?")->execute([$gebruikerId]);

            $_SESSION['actie_succes'] = "Account succesvol verwijderd.";
        } catch (PDOException $e) {
            $_SESSION['actie_fout'] = "Fout bij verwijderen: " . $e->getMessage();
        }

        header("Location: account_overzicht.php");
        exit;
    }
}

// Als niets herkend is:
$_SESSION['actie_fout'] = "Ongeldige actie.";
header("Location: account_overzicht.php");
exit;
