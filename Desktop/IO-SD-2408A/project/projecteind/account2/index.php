<?php
session_start(); // Start the session to store session data

if (isset($_POST['submit'])) {
    // Include the configuration file
    include('config/config.php');

    // Create PDO object to connect to the database
    $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=UTF8";
    $pdo = new PDO($dsn, $dbUser, $dbPass);

    // Sanitize form input
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Get form input data
    $voornaam = $_POST['Voornaam'];
    $tussenvoegsel = $_POST['Tussenvoegsel'] ?: NULL; // Handle NULL for middle name
    $achternaam = $_POST['Achternaam'];
    $email = $_POST['Email'];
    $wachtwoord = $_POST['Wachtwoord']; // Hash password

    // Combine the full name
    $fullName = $voornaam;
    if (!empty($tussenvoegsel)) {
        $fullName .= ' ' . $tussenvoegsel;
    }
    $fullName .= ' ' . $achternaam;

    // Prepare the SQL query to insert user data
    $sql = "INSERT INTO Gebruiker (
                        Voornaam, 
                        Tussenvoegsel, 
                        Achternaam,
                        Email, 
                        Wachtwoord, 
                        DatumAangemaakt, 
                        DatumGewijzigd
                    ) 
                    VALUES (
                        :Voornaam,   
                        :Tussenvoegsel,  
                        :Achternaam,    
                        :Email,  
                        :Wachtwoord,     
                        SYSDATE(6),     
                        SYSDATE(6)      
                    );
                    
                    SET @user_id = LAST_INSERT_ID();
                    
                    
                    INSERT INTO Rol (
                        GebruikerId,
                        Naam          
                    ) 
                    VALUES (
                        @user_id,     
                        'Gebruiker'  
                    );
                    ";

    // Prepare the statement
    $statement = $pdo->prepare($sql);

    // Bind values to the SQL statement
    $statement->bindValue(':Voornaam', $voornaam, PDO::PARAM_STR);
    $statement->bindValue(':Tussenvoegsel', $tussenvoegsel, PDO::PARAM_STR);
    $statement->bindValue(':Achternaam', $achternaam, PDO::PARAM_STR);
    $statement->bindValue(':Email', $email, PDO::PARAM_STR);
    $statement->bindValue(':Wachtwoord', $wachtwoord, PDO::PARAM_STR);

    // Execute the query
    $statement->execute();

    // Store the full name in the session
    $_SESSION['full_name'] = $fullName;

    // Optionally, you could store user ID, email, etc., in session as well
    $_SESSION['user_id'] = $pdo->lastInsertId(); // Assuming the user ID is auto-incremented in the database
    $_SESSION['email'] = $email;
    $_SESSION['logged_in'] = true;

    // Redirect the user to the dashboard or login page
    header('Location: dashboard.php');
    exit();
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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-3">
        <div class="row" style="display:<?= $display ?? 'none'; ?>">
            <div class="col-3"></div>
            <div class="col-6">
            </div>
            <div class="col-3"></div>
        </div>

        

        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <form action="index.php" method="POST">
                    <div class="mb-3">
                        <label for="Voornaam" class="form-label">Voornaam</label>
                        <input name="Voornaam" type="text" class="form-control" id="Voornaam" placeholder="Voornaam" value="<?= $_POST['Voornaam'] ?? ''; ?> " required>
                    </div>
                    <div class="mb-3">
                        <label for="naamLand" class="form-label">Tussenvoegsel</label>
                        <input name="Tussenvoegsel" type="text" class="form-control" id="naamLand" placeholder="Tussenvoegsel" value="<?= $_POST['Tussenvoegsel'] ?? ''; ?>" >
                    </div>

                    <div class="mb-3">
                        <label for="naamLand" class="form-label">Achternaam</label>
                        <input name="Achternaam" type="text" class="form-control" id="naamLand" placeholder="Achternaam" value="<?= $_POST['Achternaam'] ?? ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="naamLand" class="form-label">Email</label>
                        <input name="Email" type="text" class="form-control" id="naamLand" placeholder="Email" value="<?= $_POST['Email'] ?? ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="Wachtwoord" class="form-label">Wachtwoord</label>
                        <input name="Wachtwoord" type="password" class="form-control" id="Wachtwoord" placeholder="Wachtwoord" value="<?= $_POST['Wachtwoord'] ?? ''; ?>" required>
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
