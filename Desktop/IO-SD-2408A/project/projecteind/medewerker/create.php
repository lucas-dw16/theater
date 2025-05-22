<?php
    if (isset($_POST['submit'])) {
        
        include('../DB/config.php');
 
        $dsn = "mysql:host=$dbHost;
                dbname=$dbName;
                charset=UTF8";
 
       
        $pdo = new PDO($dsn, $dbUser, $dbPass);
 
      
        $sql = "INSERT INTO Medewerker
                (
                    Voornaam
                    ,Tussenvoegsel
                    ,Achternaam
                    ,Nummer
                    ,Medewerkersoort
                )
                VALUES
                (
                    :Voornaam
                    ,:Tussenvoegsel
                    ,:Achternaam
                    ,:Nummer
                    ,:Medewerkersoort
                )";
 
      
        $statement = $pdo->prepare($sql);
 
       
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
 
        
        $statement->bindValue(':Voornaam', trim($_POST['Voornaam']), PDO::PARAM_STR);
        $statement->bindValue(':Tussenvoegsel', trim($_POST['Tussenvoegsel']), PDO::PARAM_STR);
        $statement->bindValue(':Achternaam', trim($_POST['Achternaam']), PDO::PARAM_STR);
        $statement->bindValue(':Nummer', trim($_POST['Nummer']), PDO::PARAM_INT);
        $statement->bindValue(':Medewerkersoort', trim($_POST['Medewerkersoort']), PDO::PARAM_STR);
 
       
        $statement->execute();
 
       
        $display = 'flex';
 
        
        header('Refresh:2; url=medewerker.php');
    }
?>
 
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Medewerkers</title>
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
            De Medewerker is opgeslagen, u wordt doorgestuurd naar de homepagina
          </div>
        </div>
        <div class="col-3"></div>
      </div>
 
      <div class="row mb-1">
        <div class="col-3"></div>
        <div class="col-6 text-primary"><h3>Voer een nieuwe medewerker in:</h3></div>
      </div>
 
      <div class="row">
          <div class="col-3"></div>
          <div class="col-6">              
              <form action="create.php" method="POST">
                <div class="mb-3">
                    <label for="Voornaam" class="form-label">Voornaam</label>
                    <input name="Voornaam" type="text" class="form-control" id="Voornaam" placeholder="Voornaam" value="<?= $_POST['Voornaam'] ?? ''; ?>"required>
                </div>
 
                <div class="mb-3">
                    <label for="Tussenvoegsel" class="form-label">Tussenvoegsel</label>
                    <input name="Tussenvoegsel" type="text" class="form-control" id="Tussenvoegsel"  placeholder="Tussenvoegsel" value="<?= $_POST['Tussenvoegsel'] ?? ''; ?>">
                </div>
 
                <div class="mb-3">
                    <label for="Achternaam" class="form-label">Achternaam</label>
                    <input name="Achternaam" type="text" class="form-control" id="Achternaam" placeholder="Achternaam" value="<?= $_POST['Achternaam'] ?? ''; ?>"required>
                </div>
 
                <div class="mb-3">
                    <label for="Nummer" class="form-label">Nummer</label>
                    <input name="Nummer" type="number" class="form-control" id="Nummer" placeholder="Nummer" value="<?= $_POST['Nummer'] ?? ''; ?>"required>
                </div>

                <div class="mb-3">
                    <label for="Medewerkersoort" class="form-label">Medewerkersoort</label>
                    <input name="Medewerkersoort" type="text" class="form-control" id="Medewerkersoort" placeholder="Medewerkersoort" value="<?= $_POST['Medewerkersoort'] ?? ''; ?>"required>
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
    <script src="script.js"></script>
    
  </body>
</html>
