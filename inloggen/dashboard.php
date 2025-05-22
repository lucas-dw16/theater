<?php

session_start();

$message = '';
$message_class = '';

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $message_class = $_SESSION['message_class'] ?? 'alert-success';
    unset($_SESSION['message'], $_SESSION['message_class']);
}

// Timeout instellen
define('TIMEOUT_SECONDS', 900);
if (!isset($_SESSION['LAST_ACTIVITY'])) {
    $_SESSION['LAST_ACTIVITY'] = time();
}
$_SESSION['REMAINING_TIME'] = TIMEOUT_SECONDS - (time() - $_SESSION['LAST_ACTIVITY']);
if ($_SESSION['REMAINING_TIME'] <= 0) {
    header("Location: logout.php?reason=timeout");
    exit();
}
$_SESSION['LAST_ACTIVITY'] = time();

if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: login.php");
    exit();
}

require_once "../config/db_connect.php";

$userId = $_SESSION['gebruiker_id'];
$gebruikersnaam = $_SESSION['gebruikersnaam'];
$rol = $_SESSION['rol'];

$stmt = $pdo->prepare("SELECT Voornaam, Tussenvoegsel, Achternaam FROM gebruiker WHERE Id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$volleNaam = $user['Voornaam'];
if (!empty($user['Tussenvoegsel'])) {
    $volleNaam .= ' ' . $user['Tussenvoegsel'];
}
$volleNaam .= ' ' . $user['Achternaam'];

$currentDate = date("d-m-Y");
if (!isset($_SESSION['rol'])) {
    // Geen rol bekend? Terug naar login
    header("Location: login.php");
    exit();
}

// Optioneel: alleen admin toegang forceren
// if ($_SESSION['rol'] !== 'admin') {
//     header("Location: geen_toegang.php"); // maak zelf zo'n pagina
//     exit();
// }

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?= htmlspecialchars($volleNaam); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <style>
        .user-welcome {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .dashboard-card {
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .role-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-left: 10px;
        }
        .role-admin { background-color: #dc3545; color: white; }
        .role-medewerker { background-color: #28a745; color: white; }
        .sidebar {
            background-color: #343a40;
            color: white;
            min-height: 100vh;
            padding: 15px;
        }
        .sidebar .nav-link { color: rgba(255,255,255,.75); }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: white; font-weight: bold; }
        .menu-header {
            font-size: 12px;
            text-transform: uppercase;
            color: rgba(255,255,255,.5);
            margin: 1rem 0 .5rem;
        }
        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            padding: 15px 20px;
            border-radius: 8px;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            color: white;
        }
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                width: 220px;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
                z-index: 1050;
            }
            .sidebar.active { transform: translateX(0); }
            .overlay-bg {
                display: none;
                position: fixed;
                top: 0; left: 0; right: 0; bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 1040;
            }
            .overlay-bg.show { display: block; }
        }
    </style>
</head>
<body>

<?php if (!empty($message)) : ?>
    <div class="alert <?= $message_class ?> bg-success text-white">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<nav class="navbar navbar-light bg-light d-md-none px-3">
    <button class="btn btn-outline-secondary" id="mobileMenuToggle">
        <i class="fa fa-bars"></i> Menu
    </button>
</nav>

<div class="overlay-bg"></div>

<div class="container-fluid">
    <div class="row">

        <div class="col-md-3 col-lg-2 sidebar" id="sidebarMenu">
            <div class="text-center mb-4">
                <i class="fa fa-user-circle fa-3x"></i>
                <h5 class="mt-2"><?= htmlspecialchars($volleNaam); ?></h5>
                <span class="role-badge <?= $rol === 'admin' ? 'role-admin' : 'role-medewerker'; ?>">
<?php echo htmlspecialchars($rol !== null ? $rol : 'Onbekend'); ?>
                </span>
            </div>
            <a href="wijzig_gebruiker.php" class="btn btn-sm btn-outline-primary w-100 mb-2">Wijzig gegevens</a>

            <div class="menu-header">Overzichten</div>
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link active" href="#"><i class="fa fa-home"></i> Dashboard</a></li>
                <?php if (in_array($rol, ['Medewerker', 'admin'])): ?>
                    <li class="nav-item"><a class="nav-link" href="../account_overzicht/account_overzicht.php"><i class="fa fa-calendar"></i> Accountoverzicht</a></li>
                    <li class="nav-item"><a class="nav-link" href="../medewerker-overzicht/MedewerkersOV.php"><i class="fa fa-users"></i> Medewerker-overzicht</a></li>
                    <li class="nav-item"><a class="nav-link" href="../ticket_overzicht/ticket_overzicht.php"><i class="fa fa-address-card"></i> ticket-overzicht</a></li>
                    <li class="nav-item"><a class="nav-link" href="../ticket_overzicht/tickets_scannen.php"><i class="fa fa-address-card"></i> ticket-scannen</a></li>
                <?php endif; ?>
                <?php if ($rol === 'admin'): ?>
                    <li class="nav-item"><a class="nav-link" href="../Aantal_leden_per_periode/index.php"><i class="fa fa-line-chart"></i> Aantal leden per periode</a></li>
                    <li class="nav-item"><a class="nav-link" href="../overzicht_geplanned lessen/index.php"><i class="fa fa-calendar-check-o"></i> Geplande lessen</a></li>
                    <li class="nav-item"><a class="nav-link" href="../Aantal_reservering_periode/index.html"><i class="fa fa-calendar-check-o"></i> Reserveringen per periode</a></li>
                    <li class="nav-item"><a class="nav-link" href="../reservering/index.html"><i class="fa fa-calendar-check-o"></i> Reserveringsoverzicht</a></li>
                <?php endif; ?>
                <div class="menu-header">Systeem</div>
                <li class="nav-item"><a class="nav-link" href="../index.php"><i class="fa fa-arrow-left"></i> Homepagina</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php"><i class="fa fa-sign-out"></i> Uitloggen</a></li>
            </ul>
        </div>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="user-welcome d-flex justify-content-between align-items-center">
                <h2>Welkom, <?= htmlspecialchars($user['Voornaam']) ?>!</h2>
                <div>Datum: <?= $currentDate ?></div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card dashboard-card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fa fa-user"></i> Persoonlijke gegevens</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>E-mailadres:</strong> <?= htmlspecialchars($gebruikersnaam) ?></p>
                            <p><strong>Naam:</strong> <?= htmlspecialchars($volleNaam) ?></p>
                            <?php
                            $rol = $_SESSION['rol'] ?? 'Onbekend';

                            ?>
                            <p><?= htmlspecialchars($rol); ?>
</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
  const toggleBtn = document.getElementById('mobileMenuToggle');
  const sidebar = document.getElementById('sidebarMenu');
  const overlay = document.querySelector('.overlay-bg');

  toggleBtn?.addEventListener('click', () => {
    sidebar.classList.toggle('active');
    overlay.classList.toggle('show');
  });

  overlay.addEventListener('click', () => {
    sidebar.classList.remove('active');
    overlay.classList.remove('show');
  });

  setTimeout(() => {
    const alert = document.querySelector('.alert');
    if (alert) alert.remove();
  }, 3000);
</script>

</body>
</html>