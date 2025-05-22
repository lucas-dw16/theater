<?php
// Bestand: MedewerkersOV.php
session_start();

// Controleer of gebruiker is ingelogd en admin is
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medewerker Overzicht</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Medewerker Overzicht</h2>
    <div id="alertBox"></div>

<button class="btn btn-success mb-3" onclick="showAddForm()">+ Medewerker Toevoegen</button>
<div id="medewerkerForm" class="mb-4" style="display: none;">
    <h5>Nieuwe Medewerker</h5>
    <form id="addMedewerkerForm">
        <input type="text" name="voornaam" placeholder="Voornaam" required class="form-control mb-2">
        <input type="text" name="tussenvoegsel" placeholder="Tussenvoegsel" class="form-control mb-2">
        <input type="text" name="achternaam" placeholder="Achternaam" required class="form-control mb-2">
        <input type="email" name="gebruikersnaam" placeholder="E-mailadres" required class="form-control mb-2">
        <input type="text" name="medewerkersoort" placeholder="Soort medewerker" required class="form-control mb-2">
        <input type="number" name="nummer" placeholder="Medewerkernummer" required class="form-control mb-2">
        <button type="submit" class="btn btn-primary">Toevoegen</button>
    </form>
</div>

    <div id="wijzigMedewerkerForm" class="mb-4" style="display: none;">
    <h5>Medewerker Wijzigen</h5>
    <form id="editMedewerkerForm">
        <input type="hidden" name="id" id="edit-id">
        <input type="text" name="voornaam" id="edit-voornaam" required class="form-control mb-2">
        <input type="text" name="tussenvoegsel" id="edit-tussenvoegsel" class="form-control mb-2">
        <input type="text" name="achternaam" id="edit-achternaam" required class="form-control mb-2">
        <input type="email" name="gebruikersnaam" id="edit-gebruikersnaam" required class="form-control mb-2">
        <input type="text" name="medewerkersoort" id="edit-soort" required class="form-control mb-2">
        <input type="number" name="nummer" id="edit-nummer" required class="form-control mb-2">
        <button type="submit" class="btn btn-primary">Opslaan</button>
    </form>
</div>


    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Naam</th>
                <th>E-mailadres</th>
                <th>Soort</th>
                <th>Nummer</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody id="medewerkerTableBody">
            <!-- Rijen worden via JavaScript geladen -->
        </tbody>
    </table>
</div>

<script src="medewerker.js"></script>
</body>
</html>