<?php
session_start();

if (!isset($_SESSION['gebruiker_id'])) {
    echo '
    <!DOCTYPE html>
    <html lang="nl">
    
    <head>
      <meta charset="UTF-8">
      <title>Toegang geweigerd</title>
      <meta http-equiv="refresh" content="5;url=inloggen/login.php">
      <style>
        body {
          font-family: Arial, sans-serif;
          text-align: center;
          margin-top: 100px;
          background-color: #f8d7da;
          color: #721c24;
        }
        .box {
          display: inline-block;
          padding: 30px;
          border: 2px solid #f5c6cb;
          background-color: #f8d7da;
          border-radius: 10px;
        }
        #countdown {
          font-weight: bold;
        }
      </style>
    </head>
    <body>
      <div class="box">
        <h2>⛔ Je bent niet ingelogd</h2>
        <p>Je wordt binnen <span id="countdown">5</span> seconden doorgestuurd naar de loginpagina...</p>
      </div>

      <script>
        let count = 5;
        const el = document.getElementById("countdown");
        setInterval(() => {
          count--;
          if (count > 0) {
            el.textContent = count;
          }
        }, 1000);
      </script>
    </body>
    </html>
    ';
    exit;
}
?>

<?php

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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
<h1 class="text-center mt-4 mb-4">🎭 Theater Aurora</h1>

<div class="container-sm mt-4 mb-5">
  <h2 class="mb-4">🎟️ Boek Tickets</h2>
<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 mb-3">
<?php foreach ($voorstellingen as $voorstelling): ?>
  <div class="col">
    <div class="card h-100">
      <img src="<?= $voorstelling['image'] ?>" class="card-img-top img-fluid" alt="<?= $voorstelling['naam'] ?>">
      <div class="card-body">
        <h5 class="card-title"><?= htmlspecialchars($voorstelling['naam']) ?></h5>
        <p class="card-text">Prijs: €<?= number_format($voorstelling['prijs'], 2, ',', '.') ?></p>
        <a href="boeken.php?add=<?= urlencode($voorstelling['naam']) ?>" class="btn btn-primary">Toevoegen</a>
      </div>
    </div>
  </div>
<?php endforeach; ?>



<hr class="my-5">

<div class="card shadow-sm p-4">
  <h4 class="mb-4">🛒 Winkelwagen</h4>
  <div class="table-responsive">
    <table class="table table-striped align-middle text-center">
      <thead class="table-primary">
        <tr>
          <th scope="col">Voorstelling</th>
          <th scope="col">Aantal</th>
          <th scope="col">Prijs</th>
          <th scope="col">Subtotaal</th>
          <th scope="col">Actie</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($items)): ?>
          <tr>
            <td colspan="5" class="text-muted text-center py-4">
              Je winkelwagen is leeg. Voeg tickets toe om te bestellen.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($items as $item): ?>
            <tr>
              <td><?= htmlspecialchars($item['naam']) ?></td>
              <td><?= (int)$item['aantal'] ?></td>
              <td>€<?= number_format($item['prijs'], 2, ',', '.') ?></td>
              <td>€<?= number_format($item['prijs'] * $item['aantal'], 2, ',', '.') ?></td>
              <td>
                <a href="?delete=<?= urlencode($item['naam']) ?>"
                   class="btn btn-sm btn-outline-danger"
                   aria-label="Verwijder <?= htmlspecialchars($item['naam']) ?>">
                  Verwijder
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
      <?php if (!empty($items)): ?>
        <tfoot>
          <tr>
            <th colspan="3" class="text-end">Totaal</th>
            <th colspan="2">€<?= number_format($totaal, 2, ',', '.') ?></th>
          </tr>
        </tfoot>
      <?php endif; ?>
    </table>
  </div>
</div>

<!-- PayPal en status -->
<div id="paypal-button-container" class="mt-4"></div>
<div id="payment-status" class="mt-3 fw-bold text-center"></div>


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
