<?php
    if (isset($_POST['submit'])) {
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
 
        /**
         * Correct the SQL Query
         */
        $sql = "INSERT INTO Les
             (Naam, Datum, Tijd, MinAantalPersonen, MaxAantalPersonen, Beschikbaarheid)
             VALUES
             (:Naam, :Datum, :Tijd, :MinAantalPersonen, :MaxAantalPersonen, :Beschikbaarheid)";

 
        /**
         * Maak het sql-statement klaar voor PDO
         */
        $statement = $pdo->prepare($sql);
 
        /**
         * Schoonmaken filteren van het $_POST array
         */
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
 
        /**
         * Het binden van de $_POST- waarden aan de placeholders in de $sql-query
         */
        $statement->bindValue(':Naam', trim($_POST['Naam']), PDO::PARAM_STR);
        $statement->bindValue(':Datum', trim($_POST['Datum']), PDO::PARAM_INT);
        $statement->bindValue(':Tijd', trim($_POST['Tijd']), PDO::PARAM_INT);
        $statement->bindValue(':MinAantalPersonen', trim($_POST['MinAantalPersonen']), PDO::PARAM_INT);
        $statement->bindValue(':MaxAantalPersonen', trim($_POST['MaxAantalPersonen']), PDO::PARAM_INT);
        $statement->bindValue(':Beschikbaarheid', trim($_POST['Beschikbaarheid']), PDO::PARAM_STR);
 
        /**
         * Voer de query uit.
         */
        $statement->execute();
 
        /**
         * Maak de succesmelding zichtbaar
         */
        $display = 'flex';
 
        /**
         * Stuur de gebruiker door naar de index pagina
         */
        header('Refresh:2; url=lessen2.php');
    }
?>
 
 <!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>fitness</title>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  </head>
  <body>
    <div class="container mt-3">
      <div class="row" style="display:<?= $display ?? 'none'; ?>">
        <div class="col-3"></div>
        <div class="col-6">
          <div class="alert alert-success text-center" role="alert">
            De les is opgeslagen, u wordt doorgestuurd naar de homepagina
          </div>
        </div>
        <div class="col-3"></div>
      </div>
 
      <div class="row mb-1">
        <div class="col-3"></div>
        <div class="col-6 text-primary"><h3>Voer een nieuwe les in:</h3></div>
        <div class="col-3"></div>
      </div>
 
      <div class="row">
          <div class="col-3"></div>
          <div class="col-6">              
              <form action="create.php" method="POST">
                <div class="mb-3">
                    <label for="Naam" class="form-label">Naam</label>
                    <input name="Naam" type="text" class="form-control" id="Naam" placeholder="Naam" value="<?= $_POST['Naam'] ?? ''; ?>">
                </div>
 
                <div class="mb-3">
                    <label for="Datum" class="form-label">Datum</label>
                    <input name="Datum" type="date" class="form-control" id="Datum"  placeholder="Datum" min="0" max="25500000000000000000000000" value="<?= $_POST['Datum'] ?? ''; ?>">
                </div>
 
                <div class="mb-3">
                    <label for="Tijd" class="form-label">Tijd</label>
                    <input name="Tijd" type="time" class="form-control" id="Tijd" placeholder="Tijd" min="0" max="200" value="<?= $_POST['Tijd'] ?? ''; ?>">
                </div>
 
                <div class="mb-3">
                    <label for="MinAantalPersonen" class="form-label">Min aantal peronen</label>
                    <input name="MinAantalPersonen" type="number" class="form-control" id="MinAantalPersonen" placeholder="MinAantalPersonen" min="1" value="<?= $_POST['MinAantalPersonen'] ?? ''; ?>">
                </div>
 
                <div class="mb-3">
                    <label for="MaxAantalPersonen" class="form-label">Max aantal peronen</label>
                    <input name="MaxAantalPersonen" type="number" class="form-control" id="MaxAantalPersonen" placeholder="MaxAantalPersonen" max="255" value="<?= $_POST['MaxAantalPersonen'] ?? ''; ?>">
                </div>
 
                <div class="mb-3">
                <label class="form-label">Beschikbaarheid</label>
                <select name="Beschikbaarheid" class="form-control" >
                    <option value="">Selecteer een status</option>
                    <option value="In behandeling">beschikbaar</option>
                    <option value="Bevestigd">afgelopen</option>
                    <option value="Geannuleerd">Gepland</option>
                </select>
                </div>
 
                <div class="d-grid gap-2">
                    <button name="submit" value="submit" type="submit" class="btn btn-primary btn-lg">Verzenden</button>
                </div>
              </form>
        </div>
        <div class="col-3"></div>
      </div>
    </div>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>