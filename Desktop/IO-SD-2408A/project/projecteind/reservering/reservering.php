<?php
    include('../DB/config.php');

    $dsn = "mysql:host=$dbHost;
            dbname=$dbName;
            charset=UTF8";

    $pdo = new PDO($dsn, $dbUser, $dbPass);

    $sql = "SELECT  RS.Id
                   ,RS.Voornaam
                   ,RS.Tussenvoegsel
                   ,RS.Achternaam
                   ,RS.Nummer
                   ,RS.Datum
                   ,RS.Tijd
                   ,RS.Reserveringstatus
    
            FROM Reservering AS RS";

    $statement = $pdo->prepare($sql);
    $statement->execute();
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
                    <a class="nav-link" href="../gebruikerslessen/lessen.php">lessen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="../dashboard/dashboard.html">Dashboard</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="row mb-1">
            <div class="col-2"></div>
            <div class="col-8 title"><h3>Overzicht van de reserveringen</h3></div>
            <div class="col-2"></div>
        </div>
    </div>

    <!-- Knop voor toevoegen van reserveringen -->
    <div class="container text-center my-3">
        <a href="toevoegen.php" class="btn btn-primary">Reservering toevoegen</a>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-2"></div>
            <div class="col-8">
                <table class="table table-hover" id="table-reservering">
                    <thead>
                        <th>Voornaam</th>
                        <th>Tussenvoegsel</th>
                        <th>Achternaam</th>
                        <th>Nummer</th>
                        <th>Datum</th>
                        <th>Tijd</th>
                        <th>Reserveringstatus</th>
                    </thead>
                    <tbody>
                        <?php foreach($result as $ReserveringInfo) : ?>
                            <tr>
                              <td><?= $ReserveringInfo->Voornaam ?></td>
                              <td><?= $ReserveringInfo->Tussenvoegsel ?></td>
                              <td><?= $ReserveringInfo->Achternaam ?></td>
                              <td><?= $ReserveringInfo->Nummer ?></td>
                              <td><?= $ReserveringInfo->Datum ?></td>
                              <td><?= $ReserveringInfo->Tijd ?></td>
                              <td><?= $ReserveringInfo->Reserveringstatus ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>        
            <div class="col-2"></div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>
</html>
