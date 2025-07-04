<?php
session_start();

// Voorstellinglijst (kan ook uit database komen)
$voorstellingen = [
    [
        'naam' => 'De Nachtstem',
        'prijs' => 25.00,
        'image' => 'img/Voorstelling 1.png'
    ],
    [
        'naam' => 'Stilte in de Storm',
        'prijs' => 30.00,
        'image' => 'img/voorstelling 2.png'
    ],
    [
        'naam' => 'Dans der Tijden',
        'prijs' => 28.50,
        'image' => 'img/Voorstelling 3.png'
    ],
];

// Voeg toe aan winkelwagen via GET (zonder database!)
if (isset($_GET['add'])) {
    $toevoegen = $_GET['add'];
    $gevonden = array_filter($voorstellingen, fn($v) => $v['naam'] === $toevoegen);
    if ($gevonden) {
        $item = array_values($gevonden)[0];
        $gevondenIndex = array_search($item['naam'], array_column($_SESSION['winkelwagen'] ?? [], 'naam'));
        if ($gevondenIndex !== false) {
            $_SESSION['winkelwagen'][$gevondenIndex]['aantal'] += 1;
        } else {
            $_SESSION['winkelwagen'][] = [
                'naam' => $item['naam'],
                'prijs' => $item['prijs'],
                'aantal' => 1
            ];
        }
    }
    header("Location: boeken.php");
    exit;
}

// Verwijder uit winkelwagen via GET
if (isset($_GET['delete'])) {
    $_SESSION['winkelwagen'] = array_filter($_SESSION['winkelwagen'], fn($item) => $item['naam'] !== $_GET['delete']);
    header("Location: boeken.php");
    exit;
}

// Bereken totaal
$totaal = 0;
$items = $_SESSION['winkelwagen'] ?? [];
foreach ($items as $item) {
    $totaal += $item['prijs'] * $item['aantal'];
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
</head>
<style>
     .navbar {
      transition: background-color 0.3s;
    }
    .navbar.scrolled {
      background-color: #002855 !important;
      box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }
    #paypal-button-container {
  max-width: 400px;
  margin: 0 auto;
}

#payment-status {
  text-align: center;
  font-size: 1.2rem;
}

</style>

<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-primary">
  <div class="container-fluid">
<a class="navbar-brand d-flex align-items-center" href="#">
  <img src="../img/logo.png" alt="Aurora Logo" style="height: 40px; width: auto; margin-right: 10px;">
  Theater Aurora
</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php#voorstellingen">Voorstellingen</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php#over">Over</a></li>
        <?php if (isset($_SESSION['gebruiker_id'])): ?>
          <li class="nav-item"><a class="nav-link" href="inloggen/dashboard.php">Dashboard</a></li>
        <?php endif; ?>
      </ul>
      <?php if (isset($_SESSION['gebruiker_id'])): ?>
        <a href="inloggen/logout.php" class="btn btn-outline-light">Uitloggen</a>
      <?php else: ?>
        <a href="inloggen/login.php" class="btn btn-outline-light">Inloggen</a>
      <?php endif; ?>
      <div id="darkToggle">
  <button class="btn btn-sm btn-secondary" onclick="document.body.classList.toggle('dark-mode')">🌓 Donker/licht</button>
</div>
    </div>
  </div>
</nav>
   <h1>Theater Aurora</h1>

<div class="container mt-5">
  <h2 class="mb-4">🎟️ Boek Tickets</h2>
  <div class="row mb-3">
<?php foreach ($voorstellingen as $voorstelling): ?>
  <div class="card" style="width: 18rem;">
    <img src="<?= $voorstelling['image'] ?>" class="card-img-top" alt="<?= $voorstelling['naam'] ?>">
    <div class="card-body">
      <h5 class="card-title"><?= htmlspecialchars($voorstelling['naam']) ?></h5>
      <p class="card-text">Prijs: €<?= number_format($voorstelling['prijs'], 2, ',', '.') ?></p>
<a href="boeken.php?add=<?= urlencode($voorstelling['naam']) ?>" class="btn btn-primary">Toevoegen</a>
    </div>
  </div>
<?php endforeach; ?>

  </div>

  <h4 class="mt-5">🛒 Winkelwagen</h4>
  <table class="table table-bordered">
    <thead>
      <tr><th>Voorstelling</th><th>Aantal</th><th>Prijs</th><th>Subtotaal</th><th></th></tr>
    </thead>
    <tbody>
      <?php foreach ($items as $item): ?>
        <tr>
          <td><?= htmlspecialchars($item['naam']) ?></td>
          <td><?= $item['aantal'] ?></td>
          <td>€<?= number_format($item['prijs'], 2, ',', '.') ?></td>
          <td>€<?= number_format($item['prijs'] * $item['aantal'], 2, ',', '.') ?></td>
          <td><a href="?delete=<?= urlencode($item['naam']) ?>" class="btn btn-danger btn-sm">Verwijder</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
    <tfoot>
      <tr><th colspan="3" class="text-end">Totaal</th><th colspan="2">€<?= number_format($totaal, 2, ',', '.') ?></th></tr>
    </tfoot>
  </table>
</div>
<div id="paypal-button-container" class="mt-4"></div>
<div id="payment-status" class="mt-3 fw-bold"></div>

<!-- PayPal SDK -->
<script src="https://www.paypal.com/sdk/js?client-id=sb&currency=EUR"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
  const totalAmount = <?= number_format($totaal, 2, '.', '') ?>;

  paypal.Buttons({
    style: {
      shape: 'rect',
      color: 'blue',
      layout: 'vertical',
      label: 'pay',
    },
    createOrder: function (data, actions) {
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: totalAmount
          },
          description: 'Tickets Theater Aurora'
        }]
      });
    },
    onApprove: function (data, actions) {
      return actions.order.capture().then(function (details) {
        document.getElementById('payment-status').innerHTML = `
          ✅ Betaling gelukt! Dank je wel, ${details.payer.name.given_name}.
        `;
      });
    },
    onCancel: function (data) {
      document.getElementById('payment-status').innerHTML = '⚠️ Betaling geannuleerd.';
    },
    onError: function (err) {
      console.error(err);
      document.getElementById('payment-status').innerHTML = '❌ Er is een fout opgetreden bij de betaling.';
    }
  }).render('#paypal-button-container');
});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
