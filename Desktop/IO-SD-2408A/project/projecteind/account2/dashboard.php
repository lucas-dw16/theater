<?php
// Start the session to check if the user is logged in
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // If not logged in, redirect to the login page
    header("Location: Login/login.php");
    exit();
}
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky">
        <div class="container-fluid">
            <ul>
                <li>
                    <img src="Image/Logo.png" alt="logo" class="logo">
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Homepage</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="lessen.php">Lessen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="dashboard.php">Dashboard</a>
                </li>
                <!-- Display Log In/Log Out based on session -->
                <li class="nav-item">
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                        <a class="nav-link" href="LogUit/index.php">Log Out</a>
                    <?php else: ?>
                        <a class="nav-link" href="Login/login.php">Log In</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Dashboard Content -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h3>Welcome to Your Dashboard</h3>
                <!-- Display a message if the user is not logged in -->
                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                    <p>Hello, <?= isset($_SESSION['full_name']) ? htmlspecialchars($_SESSION['full_name']) : 'Guest'; ?>! You are logged in.</p>
                <?php else: ?>
                    <p>You are not logged in. Some features might not be available. Please <a href="login.php">log in</a> to access all features.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- User Info Section -->
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
        <div class="row mt-4">
            <div class="col-12">
                <h5>Your Account Information</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Field</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Name</td>
                            <td><?= isset($_SESSION['full_name']) ? htmlspecialchars($_SESSION['full_name']) : 'N/A'; ?></td>
                        </tr>
                        <tr>
                            <td>User ID</td>
                            <td><?= isset($_SESSION['user_id']) ? htmlspecialchars($_SESSION['user_id']) : 'N/A'; ?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><?= isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'N/A'; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Actions Section (optional) -->
        <div class="row mt-4">
            <div class="col-12">
                <h5>What would you like to do?</h5>
                <ul>
                    <li><a href="edit_profile.php">Edit Profile</a></li>
                    <li><a href="change_password.php">Change Password</a></li>
                    <!-- Add more options here if needed -->
                </ul>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="mt-5 py-4 bg-dark text-white text-center">
        <p>&copy; <?= date('Y'); ?> FitForFun. All Rights Reserved.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
