<?php
require_once '../config/db_connect.php'; // pas aan als je pad anders is

try {
    $email = 'samir2005@gmail.com';
    $wachtwoord = 'samir2006@';

    // Check of gebruiker al bestaat
    $checkStmt = $pdo->prepare("SELECT Id FROM gebruiker WHERE Gebruikersnaam = ?");
    $checkStmt->execute([$email]);

    if ($checkStmt->rowCount() === 0) {
        // Hash wachtwoord
        $hashedPassword = password_hash($wachtwoord, PASSWORD_DEFAULT);

        // 1. Voeg gebruiker toe
        $insertGebruiker = $pdo->prepare("
            INSERT INTO gebruiker (
                Voornaam, Achternaam, Gebruikersnaam, Wachtwoord,
                IsIngelogd, Ingelogd, Uitgelogd, Isactief,
                Opmerking, Datumaangemaakt, Datumgewijzigd
            ) VALUES (
                'Samir', 'admin', ?, ?, 0, NULL, NULL, 1,
                'Seeded admin account', NOW(), NOW()
            )
        ");
        $insertGebruiker->execute([$email, $hashedPassword]);

        $gebruikerId = $pdo->lastInsertId();

        // 2. Voeg rol toe
        $insertRol = $pdo->prepare("
            INSERT INTO rol (
                GebruikerId, Naam, Isactief, Opmerking, Datumaangemaakt, Datumgewijzigd
            ) VALUES (?, 'admin', 1, 'Volledige toegang', NOW(), NOW())
        ");
        $insertRol->execute([$gebruikerId]);

        // 3. Voeg contact toe
        $insertContact = $pdo->prepare("
            INSERT INTO contact (
                GebruikerId, Email, Mobiel, Isactief, Opmerking,
                Datumaangemaakt, Datumgewijzigd
            ) VALUES (?, ?, '0612345678', 1, 'Admin contactgegevens', NOW(), NOW())
        ");
        $insertContact->execute([$gebruikerId, $email]);

        echo "✅ admin account succesvol aangemaakt.";
    } else {
        echo "⚠️ admin bestaat al.";
    }
} catch (PDOException $e) {
    echo "❌ Fout bij het toevoegen: " . $e->getMessage();
}
?>
