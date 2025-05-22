
<?php
    /**
     * We sluiten het configuratiebestand in bij de pagina
     * index.php
     */
    include('../DB/config.php');

    $dsn = "mysql:host=$dbHost;
            dbname=$dbName;
            charset=UTF8";

    /**
     * Maak een nieuw PDO-object aan zodat we een verbinding
     * kunnen maken met de mysql-server
     */
    $pdo = new PDO($dsn, $dbUser, $dbPass);

    $filter = isset($_GET['filter']) && $_GET['filter'] == 'new';
    /**
     * Dit is de zoekvraag voor de database zodat we 
     * alle achtbanen van Europa selecteren
     */
    $sql = "SELECT  LID.Id
                   ,LID.Voornaam
                   ,LID.Tussenvoegsel
                   ,LID.Achternaam
                   ,LID.Relatienummer
                   ,LID.Mobiel
                   ,LID.Email
    
            FROM Lid AS LID";
            if ($filter) {
                $sql .= " WHERE MONTH(DatumInschrijving) = MONTH(CURRENT_DATE()) 
                          AND YEAR(DatumInschrijving) = YEAR(CURRENT_DATE())";
            }
    

    /**
     * We moeten de sql-query voorbereiden voor de PDO class
     * door middel van de method prepare
     */
    $statement = $pdo->prepare($sql);

    /**
     * We voeren de geprepareerde sql-query uit
     */
    $statement->execute();

    /**
     * We krijgen de records binnen als een indexed-array
     * met daarin objecten
     */
    $result = $statement->fetchAll(PDO::FETCH_OBJ);






    


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Farro:wght@300;400;500;700&family=Luckiest+Guy&family=Passion+One:wght@400;700;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Leden</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom sticky">
        <div class="container-fluid">
            <ul>
                <li>
                    <img src="../Image/Logo.png" alt="logo" class="logo">
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../index.html">Homepage</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../gebruikerslessen/lessen.php">Lessen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="../dashboard/dashboard.html">Dashboard</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="row mb-1 ">
            <div class="col-2"></div>
            <div class="col-8 title"><h3>Overzicht van de leden</h3></div>
            <div class="col-2"></div>
        </div>
    </div> 

    <div class="container">
        <div class="row mb-3">
            <div class="col-2"></div>
            <div class="col-8">
              <h5>Nieuw lid toevoegen
                  <a href="create.php">
                    <i class="bi bi-plus-square-fill text-danger"></i>
                  </a>
              </h5>
            </div>
            <div class="col-2"></div>
        </div>
    </div>

    <div class="container">
        <div class="row mb-1 ">
            <div class="col-2"></div>
            <div class="col-8 title">
                <div class="input-group mb-3">
                    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." class="form-control">
                    <select id="myInputType" class="btn btn-outline-secondary dropdown-toggle       ">
                        <option value="0" selected>Voornaam</option>
                        <option value="2">Achternaam</option>
                    </select>
                </div>
            </div>
            <div class="col-2"></div>
        </div>
    </div> 

    

    <div class="container">
    <h3 id="pageTitle"><?= $filter ? 'Nieuwe leden van deze maand' : 'Overzicht van alle leden' ?></h3> 
    <button id="toggleFilter" class="btn btn-primary">Toon alleen nieuwe leden</button>
    <table class="table">
        
        <tbody>
            <?php foreach ($result as $Lid) : ?>
                <tr>
                    <td><?= htmlspecialchars($Lid->Voornaam) ?></td>
                    <td><?= htmlspecialchars($Lid->Tussenvoegsel ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($Lid->Achternaam) ?></td>
                    <td><?= htmlspecialchars($Lid->Relatienummer) ?></td>
                    <td><?= htmlspecialchars($Lid->Mobiel) ?></td>
                    <td><?= htmlspecialchars($Lid->Email) ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let filterStatus = localStorage.getItem("filterNewMembers");
    let toggleButton = document.getElementById("toggleFilter");

    // Zet de juiste URL afhankelijk van de status
    function updateFilter() {
        let newUrl = window.location.pathname;
        if (filterStatus === "true") {
            newUrl += "?filter=new";
            toggleButton.innerText = "Toon alle leden";
            document.getElementById("pageTitle").innerText = "Nieuwe leden van deze maand";
        } else {
            toggleButton.innerText = "Toon alleen nieuwe leden";
            document.getElementById("pageTitle").innerText = "Overzicht van alle leden";
        }
        window.location.href = newUrl;
    }

    // Als de gebruiker al eerder een filter had ingeschakeld, behoud dit dan
    if (filterStatus === "true" && !window.location.search.includes("filter=new")) {
        window.location.href = window.location.pathname + "?filter=new";
    }

    // Toggle-knop klik-event
    toggleButton.addEventListener("click", function () {
        filterStatus = filterStatus === "true" ? "false" : "true";
        localStorage.setItem("filterNewMembers", filterStatus);
        updateFilter();
    });
});
</script>


    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>
</html>