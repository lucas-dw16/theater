<?php
// Bestand: add_medewerker.php
require_once '../config/db_connect.php';

header('Content-Type: application/json');

// Controleer of alle vereiste POST-waarden aanwezig zijn
if (
    isset($_POST['voornaam'], $_POST['achternaam'], $_POST['gebruikersnaam'], $_POST['medewerkersoort'], $_POST['nummer'])
) {
    try {
        $voornaam = trim($_POST['voornaam']);
        $tussenvoegsel = trim($_POST['tussenvoegsel'] ?? '');
        $achternaam = trim($_POST['achternaam']);
        $gebruikersnaam = trim($_POST['gebruikersnaam']);
        $medewerkersoort = trim($_POST['medewerkersoort']);
        $nummer = intval($_POST['nummer']);

        if (!is_numeric($_POST['nummer']) || $nummer <= 0 || $nummer > 9999) {
            echo json_encode(['success' => false, 'message' => 'Ongeldig medewerkernummer. Vul een nummer in tussen 1 en 9999.']);
            exit();
        }

        // ✅ Controleer of e-mailadres al bestaat
        $checkEmail = $pdo->prepare("SELECT Id FROM gebruiker WHERE Gebruikersnaam = ?");
        $checkEmail->execute([$gebruikersnaam]);
        if ($checkEmail->rowCount() > 0) {
            echo json_encode(['success' => false, 'message' => 'Dit e-mailadres is al in gebruik.']);
            exit();
        }

        // ✅ Controleer of nummer al bestaat
        $checkNummer = $pdo->prepare("SELECT Id FROM medewerker WHERE Nummer = ?");
        $checkNummer->execute([$nummer]);
        if ($checkNummer->rowCount() > 0) {
            echo json_encode(['success' => false, 'message' => 'Dit medewerker nummer is al in gebruik.']);
            exit();
        }

        // ✅ Maak standaard wachtwoord aan
        $wachtwoord = password_hash("default123", PASSWORD_DEFAULT);

        // ✅ Voeg gebruiker toe
        $insertUser = $pdo->prepare("
            INSERT INTO gebruiker (Voornaam, Tussenvoegsel, Achternaam, Gebruikersnaam, Wachtwoord)
            VALUES (?, ?, ?, ?, ?)
        ");
        $insertUser->execute([$voornaam, $tussenvoegsel, $achternaam, $gebruikersnaam, $wachtwoord]);
        $gebruikerId = $pdo->lastInsertId();

        // ✅ Voeg rol toe
        $insertRol = $pdo->prepare("INSERT INTO rol (GebruikerId, Naam) VALUES (?, ?)");
        $insertRol->execute([$gebruikerId, 'medewerker']);

        // ✅ Voeg medewerker toe
        $insertMedewerker = $pdo->prepare("
            INSERT INTO medewerker (GebruikerId, Nummer, Medewerkersoort)
            VALUES (?, ?, ?)
        ");
        $insertMedewerker->execute([$gebruikerId, $nummer, $medewerkersoort]);

        echo json_encode(['success' => true, 'message' => 'Medewerker succesvol toegevoegd.']);

    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Fout bij toevoegen: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Niet alle verplichte velden zijn ingevuld.']);
}
?>
