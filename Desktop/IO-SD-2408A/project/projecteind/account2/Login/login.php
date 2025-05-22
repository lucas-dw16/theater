<?php
session_start(); // Start the session

if (isset($_POST['submit'])) {
    // Include the configuration file
    include('../config/config.php');

    // Create PDO object to connect to the database
    $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=UTF8";
    $pdo = new PDO($dsn, $dbUser, $dbPass);

    // Sanitize form input
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Get email and password entered by the user
    $email = $_POST['Email'];
    $password = $_POST['Wachtwoord'];

    // Prepare SQL query to get user data including full name
    $sql = "SELECT * FROM Gebruiker WHERE Email = :Email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':Email', $email, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch user data from database
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // If user exists and the password matches
    if ($user && $user['Wachtwoord'] == $password) {
        // Combine first name, middle name, and last name to get full name
        $full_name = $user['Voornaam'] . ' ' . ($user['Tussenvoegsel'] ? $user['Tussenvoegsel'] . ' ' : '') . $user['Achternaam'];

        // Login successful, start session
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $user['Id'];
        $_SESSION['email'] = $user['Email'];
        $_SESSION['full_name'] = $full_name; // Store full name in session

        // Redirect to dashboard
        header('Location: ../dashboard.php');
        exit();
    } else {
        // Invalid login credentials
        $error_message = "Invalid email or password.";
    }
}
?>

<!-- HTML Form for Login -->
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-3">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <h3 class="text-primary">Login</h3>
                <!-- Show error message if any -->
                <?php if (isset($error_message)): ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($error_message) ?>
                    </div>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label for="Email" class="form-label">Email</label>
                        <input name="Email" type="email" class="form-control" id="Email" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <label for="Wachtwoord" class="form-label">Password</label>
                        <input name="Wachtwoord" type="password" class="form-control" id="Wachtwoord" placeholder="Password" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button name="submit" type="submit" class="btn btn-primary btn-lg">Login</button>
                        <h5>Heeft u nog geen account? <a href="../index.php">Registreer hier</a></h5>
                    </div>
                </form>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
</body>
</html>
