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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Medewerker Overzicht</title>
    <link rel="stylesheet" href="style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container-fluid">
    <a class="navbar-brand" href="#">Medewerker overzicht</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="nav">

      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="../inloggen/dashboard.php"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="nav-item"><a class="nav-link text-warning" href="../inloggen/logout.php">Uitloggen</a></li>
      </ul>
    </div>
  </div>
</nav>


<div class="container mt-5">
    <h2 class="mb-4">Medewerker Overzicht</h2>
    <div id="alertBox"></div>

    <button class="btn btn-success mb-3" onclick="showAddForm()">+ Medewerker Toevoegen</button>

    <div id="medewerkerForm" class="mb-4" style="display:none;">
        <h5>Nieuwe Medewerker</h5>
        <form id="addMedewerkerForm">
            <input type="text" name="voornaam" placeholder="Voornaam" required class="form-control mb-2" />
            <input type="text" name="tussenvoegsel" placeholder="Tussenvoegsel" class="form-control mb-2" />
            <input type="text" name="achternaam" placeholder="Achternaam" required class="form-control mb-2" />
            <input type="email" name="gebruikersnaam" placeholder="E-mailadres" required class="form-control mb-2" />
            <input type="text" name="medewerkersoort" placeholder="Soort medewerker" required class="form-control mb-2" />
            <input type="number" name="nummer" placeholder="Medewerkernummer" required class="form-control mb-2" />
            <button type="submit" class="btn btn-primary">Toevoegen</button>
        </form>
    </div>

    <div id="wijzigMedewerkerForm" class="mb-4" style="display:none;">
        <h5>Medewerker Wijzigen</h5>
        <form id="editMedewerkerForm">
            <input type="hidden" name="id" id="edit-id" />
            <input type="text" name="voornaam" id="edit-voornaam" required class="form-control mb-2" />
            <input type="text" name="tussenvoegsel" id="edit-tussenvoegsel" class="form-control mb-2" />
            <input type="text" name="achternaam" id="edit-achternaam" required class="form-control mb-2" />
            <input type="email" name="gebruikersnaam" id="edit-gebruikersnaam" required class="form-control mb-2" />
            <input type="text" name="medewerkersoort" id="edit-soort" required class="form-control mb-2" />
            <input type="number" name="nummer" id="edit-nummer" required class="form-control mb-2" />
            <button type="submit" class="btn btn-primary">Opslaan</button>
        </form>
    </div>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Naam</th>
                <th>E-mailadres</th>
                <th>Soort</th>
                <th>Nummer</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody id="medewerkerTableBody"></tbody>
    </table>

    <a href="../inloggen/dashboard.php" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> Terug naar Dashboard
    </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="medewerker.js"></script>

</body>
</html>
