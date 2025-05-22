<?php
$message = "";
$messageClass = "";

if (isset($_POST['submit'])) {
    include('../DB/config.php');

    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    try {
        $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=UTF8", $dbUser, $dbPass);

        // email check
        $sqlCheck = "SELECT COUNT(*) FROM Lid WHERE Email = :Email";
        $statementCheck = $pdo->prepare($sqlCheck);
        $statementCheck->bindValue(':Email', trim($_POST['Email']), PDO::PARAM_STR);
        $statementCheck->execute();
        $emailExists = $statementCheck->fetchColumn();


        if ($emailExists > 0) {
            // E-mail bestaat dan foutmelding
            $message = "Dit e-mailadres is al in gebruik. Kies een ander e-mailadres.";
            $messageClass = "alert-danger";
        } else {
            // e-mail bestaat niet, dan insert
            $sql = "INSERT INTO Lid (Voornaam, Tussenvoegsel, Achternaam, Relatienummer, Mobiel, Email, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd)
                    VALUES (:Voornaam, :Tussenvoegsel, :Achternaam, :Relatienummer, :Mobiel, :Email, 1, NULL, SYSDATE(6), SYSDATE(6))";


            $statement = $pdo->prepare($sql);
            $statement->bindValue(':Voornaam', trim($_POST['Voornaam']), PDO::PARAM_STR);
            $statement->bindValue(':Tussenvoegsel', trim($_POST['Tussenvoegsel']), PDO::PARAM_STR);
            $statement->bindValue(':Achternaam', trim($_POST['Achternaam']), PDO::PARAM_STR);
            $statement->bindValue(':Relatienummer', trim($_POST['Relatienummer']), PDO::PARAM_INT);
            $statement->bindValue(':Mobiel', trim($_POST['Mobiel']), PDO::PARAM_STR);
            $statement->bindValue(':Email', trim($_POST['Email']), PDO::PARAM_STR);

            $statement->execute();

            
            $message = "De nieuwe lid is succesvol opgeslagen!";
            $messageClass = "alert-success";

        }
    } catch (PDOException $e) {
        $message = "Fout: " . $e->getMessage();
        $messageClass = "alert-danger";
    }
    
    header('Refresh:3; url=leden.php');
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hoogste Achtbanen van Europa</title>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../style.css">
  </head>
  <body>
    <div class="container mt-3">
      <div class="row" style="display:<?= $display ?? 'none'; ?>">
        <div class="col-3"></div>
        <div class="col-6">
          <div class="alert alert-success text-center" role="alert">
           De nieuwe lid is opgeslagen, u wordt doorgestuurd naar de homepagina
          </div>
        </div>
        <div class="col-3"></div>
      </div>

    <?php if (!empty($message)): ?>
     <div class="alert <?= $messageClass; ?> text-center"><?= $message; ?></div>
    <?php endif; ?>

      <div class="row mb-1">  
        <div class="col-3"></div>
        <div class="col-6 "><h3>Voer een nieuwe lid in:</h3></div>
        <div class="col-3"></div>
      </div>

      
      <div class="row">
          <div class="col-3"></div>
          <div class="col-6">              
              <form action="create.php" method="POST">
                <div class="mb-3">
                    <label for="Voornaam" class="form-label">Naam Lid</label>
                    <input name="Voornaam" type="text" class="form-control" id="Voornaam" placeholder="Naam van de lid" value="<?= $_POST['Voornaam'] ?? ''; ?>"required>
                </div>
                <div class="mb-3">
                    <label for="Tussenvoegsel" class="form-label">Tussenvoegsel</label>
                    <input name="Tussenvoegsel" type="text" class="form-control" id="Tussenvoegsel" placeholder="Tussenvoegsel" value="<?= $_POST['Tussenvoegsel'] ?? ''; ?>">
                </div>
                <div class="mb-3">
                    <label for="Achternaam" class="form-label">Achternaam</label>
                    <input name="Achternaam" type="text" class="form-control" id="Achternaam" placeholder="Achternaam" value="<?= $_POST['Achternaam'] ?? ''; ?>"required>
                </div>
                <div class="mb-3">
                    <label for="Relatienummer" class="form-label">Relatienummer</label>
                    <input name="Relatienummer" type="number" class="form-control" id="Relatienummer" placeholder="Relatienummer" value="<?= $_POST['Relatienummer'] ?? ''; ?>"required>
                </div>
                <div class="mb-3">
                    <label for="Mobiel" class="form-label">Mobiel</label>
                    <input name="Mobiel" type="text" class="form-control" id="Mobiel" placeholder="Telefoon nummer"  value="<?= $_POST['Mobiel'] ?? ''; ?>"required>
                </div>
                <div class="mb-3">
                    <label for="Email" class="form-label">Email</label>
                    <input name="Email" type="text" class="form-control" id="Email" placeholder="Email"  value="<?= $_POST['Email'] ?? ''; ?>"required>
                </div>
                
                <div class="d-grid gap-2">
                    <button name="submit" value="submit" type="submit" class="btn btn-sub">Verzenden</button>
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