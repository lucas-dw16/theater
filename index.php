<?php
session_start();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="../img/logo.png">

  <title>Theater Aurora</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="style.css">
</head>
<body>
<!-- Decoratieve vormen -->
<div class="shapes-container">
  <div class="circle circle1"></div>
  <div class="circle circle2"></div>
  <div class="triangle triangle1"></div>
  <div class="triangle triangle2"></div>
</div>


<!-- Popup nieuwsbrief melding -->
<div class="popup-newsletter" id="popupNewsletter">
  <strong>Blijf op de hoogte!</strong>
  <p>Meld je aan voor onze nieuwsbrief.</p>
  <button class="btn btn-primary btn-sm" onclick="document.getElementById('popupNewsletter').style.display='none'">Sluiten</button>
</div>

<!-- NAVBAR -->
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
        <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#voorstellingen">Voorstellingen</a></li>
        <li class="nav-item"><a class="nav-link" href="#over">Over</a></li>

        <?php if (isset($_SESSION['gebruiker_id'])): ?>
          <li class="nav-item"><a class="nav-link" href="inloggen/dashboard.php">Dashboard</a></li>
                  <li class="nav-item"><a class="nav-link" href="boeken.php">Tickets</a></li>

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

<!-- Popup nieuwsbrief melding -->
<div class="popup-newsletter" id="popupNewsletter">
  <strong>Blijf op de hoogte!</strong>
  <p>Meld je aan voor onze nieuwsbrief.</p>
  <button class="btn btn-primary btn-sm" onclick="document.getElementById('popupNewsletter').style.display='none'">Sluiten</button>
</div>

<!-- HERO -->
<section class="hero-section text-white d-flex align-items-center" style="height: 90vh; background: url('img/image.png') center/cover no-repeat;">
  <div class="container text-center">
    <h1 class="display-4 mb-3">Welkom bij Theater Aurora</h1>
    <p class="lead mb-4">Een podium voor magie, passie en talent. Beleef het bij ons.</p>
    
    <!-- Knoppen naast elkaar -->
    <div class="d-flex justify-content-center gap-3">
      <a href="inloggen/login.php" class="btn btn-outline-light btn-lg">Inloggen</a>
      <a href="#voorstellingen" class="btn btn-light btn-lg text-primary">Voorstellingen</a>
    </div>
  </div>
</section>


<!-- VOORSTELLINGEN -->
<section class="voorstellingen text-center" id="voorstellingen">
  <div class="container">
    <h2 class="display-5 mb-4">Onze Voorstellingen</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <img src="img/Voorstelling 1" alt="Voorstelling 1">
        <h4 class="mt-3">De Nachtstem</h4>
        <p>Een duister sprookje vol muziek, schaduw en licht.</p>
        <button  class="boeken"><a href="boeken.php" class="btn btn-warning boeken1">Koop</a>
</button>
      </div>
      <div class="col-md-4">
        <img src="img/Voorstelling 2" alt="Voorstelling 2">
        <h4 class="mt-3">Stilte in de Storm</h4>
        <p>Een meeslepend toneelstuk over verlies en hoop.</p>
        <button  class="boeken"><a href="boeken.php" class="btn btn-warning boeken1">Koop</a>
</button>
      </div>
      <div class="col-md-4">
        <img src="img/Voorstelling 3" alt="Voorstelling 3">
        <h4 class="mt-3">Dans der Tijden</h4>
        <p>Een dansvoorstelling waarin generaties elkaar raken.</p>
        <button  class="boeken"><a href="boeken.php" class="btn btn-warning boeken1">Koop</a>
</button>

      </div>
    </div>
  </div>
</section>
<section id="countdown-section" class="bg-dark text-white text-center py-5">
  <h2 class="fw-bold">Volgende voorstelling begint over:</h2>
  <div id="countdown" class="display-5 mt-3"></div>
  <p class="mt-3">Mis het niet – koop nu je tickets!</p>
</section>

<!-- OVER SECTION -->
<section id="over" class="py-5 bg-light text-dark">
  <!-- Glow Circle Light Effect -->
  <div class="container">
    <div class="row align-items-center">
      <!-- Tekst -->
      <div class="col-md-6 mb-4 mb-md-0">
        <div class="over-glow-circle"></div>

        <h2 class="fw-bold">Over Theater Aurora</h2>
        <p class="lead">Theater Aurora is meer dan een podium. Het is een plek waar verhalen tot leven komen, emoties worden gedeeld en kunst wordt gevierd. Sinds onze oprichting brengen wij voorstellingen die raken, inspireren en verbinden.</p>
        <p>Van moderne musicals tot klassiek toneel en vernieuwende dans, ons gevarieerde programma biedt voor ieder wat wils. Wij geloven dat theater een krachtig middel is om mensen samen te brengen en cultuur toegankelijk te maken voor iedereen.</p>
        <a href="#voorstellingen" class="btn btn-outline-primary mt-3">Bekijk voorstellingen</a>
      </div>

      <!-- Afbeelding -->
      <div class="col-md-6">
        <img src="img/teaterzaal.png" alt="Theaterzaal Aurora" class="img-fluid rounded shadow">
      </div>
    </div>
  </div>
</section>

<footer style="background: linear-gradient(to right, #44006b, #8f00ff); color: white; padding: 4rem 1rem;">
  <div class="container">
    <!-- Nieuwsbrief -->
    <div class="row mb-5 align-items-center">
      <div class="col-md-6">
        <h2 class="fw-bold" style="background: linear-gradient(to right, #00bfff, #ff00aa); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Onze nieuwsbrief ontvangen?</h2>
        <p class="mt-2">Twee keer per maand als eerste op de hoogte van nieuwe voorstellingen en aanbiedingen?<br>
        <small>Lees onze <a href="#" class="text-white text-decoration-underline">privacy- en cookieverklaring</a>.</small></p>
      </div>
      <div class="col-md-6">
        <form class="row g-2">
          <div class="col-8">
            <input type="email" class="form-control form-control-lg" placeholder="Je e-mailadres">
          </div>
          <div class="col-4">
            <button class="btn btn-primary btn-lg w-100">Inschrijven</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Info blokken -->
    <div class="row text-start text-white">
      <div class="col-md-4 mb-3">
        <h5 class="fw-bold">Handige links</h5>
        <ul class="list-unstyled">
          <li><a href="#" class="text-white text-decoration-none">Bereikbaarheid</a></li>
          <li><a href="#" class="text-white text-decoration-none">Contact</a></li>
          <li><a href="#" class="text-white text-decoration-none">Veelgestelde vragen</a></li>
          <li><a href="#" class="text-white text-decoration-none">Inloggen</a></li>
          <li><a href="#" class="text-white text-decoration-none">Technische gegevens</a></li>
        </ul>
      </div>
      <div class="col-md-4 mb-3">
        <h5 class="fw-bold">Zakelijke verhuur</h5>
        <ul class="list-unstyled">
          <li><a href="#" class="text-white text-decoration-none">Ruimtes</a></li>
          <li><a href="#" class="text-white text-decoration-none">Mogelijkheden</a></li>
          <li><a href="#" class="text-white text-decoration-none">Faciliteiten</a></li>
        </ul>
      </div>
      <div class="col-md-4 mb-3">
        <h5 class="fw-bold">Contactgegevens</h5>
        <p>Marnixstraat 402<br><strong>Mail ons</strong><br><strong>Bel ons:</strong> van 11.00 tot 20.00 uur</p>
      </div>
    </div>

    <!-- Social + logo -->
<div class="row mt-4 align-items-center">
  <div class="col-md-6">
    <div class="social-icons">
      <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
      <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
      <a href="#" class="text-white me-3"><i class="fab fa-youtube fa-lg"></i></a>
      <a href="#" class="text-white me-3"><i class="fab fa-tiktok fa-lg"></i></a>
    </div>
  </div>
  <div class="col-md-6 text-end">
<a href="index.php">
  <img src="../img/logo.png" alt="Aurora Logo" style="height: 80px; width: auto;">
</a>
  </div>
</div>


    <!-- Onderkant -->
    <div class="mt-4 text-center border-top pt-3">
      <small>
        <a href="#" class="text-white text-decoration-none me-3">Privacy- en cookieverklaring</a>
        <a href="#" class="text-white text-decoration-none me-3">Disclaimer</a>
        <a href="#" class="text-white text-decoration-none">Voorwaarden</a>
      </small>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<script>
  window.addEventListener('scroll', function () {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  });

  document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      const email = form.querySelector("input[type='email']").value;
      if (email.trim() === "") {
        alert("Voer een geldig e-mailadres in.");
        return;
      }
      alert("Bedankt voor je inschrijving! We houden je op de hoogte.");
      form.reset();
    });

    // popup na 10 sec tonen
    setTimeout(() => {
      document.getElementById('popupNewsletter').style.display = 'block';
    }, 10000);
  });
  // Afteller naar volgende voorstelling
const countdownDate = new Date("May 30, 2025 20:00:00").getTime();
const countdownEl = document.getElementById("countdown");

function updateCountdown() {
  const now = new Date().getTime();
  const distance = countdownDate - now;
  if (distance < 0) {
    countdownEl.innerHTML = "De voorstelling is begonnen!";
    return;
  }
  const days = Math.floor(distance / (1000 * 60 * 60 * 24));
  const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  const seconds = Math.floor((distance % (1000 * 60)) / 1000);
  countdownEl.innerHTML = `${days} dagen ${hours}u ${minutes}m ${seconds}s`;
}
updateCountdown();
setInterval(updateCountdown, 1000);
// Check alle links op de pagina of ze bestaan voordat je navigeert
document.querySelectorAll("a[href]").forEach(link => {
  link.addEventListener("click", function (e) {
    const url = this.getAttribute("href");

    // Negeer anchors (#) of javascript:void links
    if (url.startsWith("#") || url.startsWith("javascript")) return;

    // Verhindert standaardnavigatie tijdelijk
    e.preventDefault();

    fetch(url, { method: "HEAD" })
      .then(response => {
        if (response.ok) {
          window.location.href = url;
        } else {
          alert("⚠️ Deze pagina is momenteel niet beschikbaar.");
        }
      })
      .catch(() => {
        alert("⚠️ Er is een fout opgetreden. Probeer het later opnieuw.");
      });
  });
});

</script>
</body>
</html>