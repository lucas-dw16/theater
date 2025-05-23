<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theater Aurora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light text-dark">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Theater Aurora</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAurora">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarAurora">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a id="home-desktop" class="nav-link" href="#">Home</a></li>
                <li class="nav-item"><a id="voorstellingen-desktop" class="nav-link" href="#">Voorstellingen</a></li>
                <li class="nav-item"><a id="overTheaterMBO-desktop" class="nav-link" href="#">Over</a></li>
                <li class="nav-item"><a id="mangmentDashboard" class="nav-link" href="#">Dashboard</a></li>
            </ul>
            <a id="login-desktop" class="btn btn-outline-light">Login/Register</a>
        </div>
    </div>
</nav>

<!-- CAROUSEL -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="https://www.louwmanmuseum.nl/app/uploads/2020/01/k2_Y8A3819.jpg" class="d-block w-100" alt="..." style="height:500px; object-fit:cover;">
        </div>
        <div class="carousel-item">
            <img src="https://www.theaterkrant.nl/wp-content/uploads/2022/10/Een-leuk-avondje-uit-Kurt-van-der-Elst-scaled-e1665740748889-1240x814.jpg" class="d-block w-100" style="height:500px; object-fit:cover;">
        </div>
        <div class="carousel-item">
            <img src="https://www.jansstheater.nl/img/webp/_9119_1737934534.webp" class="d-block w-100" style="height:500px; object-fit:cover;">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<!-- INFO SECTION -->
<div class="container my-5">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h2>Over Theater Aurora</h2>
            <p>Theater Aurora biedt een podium aan jong talent. We organiseren voorstellingen, workshops en evenementen waar creativiteit centraal staat. Ontdek wat wij doen!</p>
        </div>
        <div class="col-md-6">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS1TQwaJHQpZnzanhlBgCCOsbSjj8m5LXjPTA&s" class="img-fluid rounded" alt="Over Theater Aurora">
        </div>
    </div>
</div>

<!-- CENTRALE VOORSTELLINGEN-SECTIE -->
<section class="py-5" style="background: linear-gradient(to bottom, #003366, #00509d); color: white;">
    <div class="container text-center">
        <h2 class="display-5 fw-bold mb-4">Ervaar Magie in Theater Aurora</h2>
        <p class="lead mb-4">
            Theater is meer dan entertainment. Het is emotie, kunst, verbinding.<br>
            Bij Theater Aurora brengen we unieke voorstellingen tot leven – van moderne toneelstukken tot klassiekers en experimentele producties.
        </p>
        <div class="row justify-content-center mb-4">
            <div class="col-md-8">
                <img src="https://images.unsplash.com/photo-1515165562835-c3b6d454f33f" alt="Theaterscène" class="img-fluid rounded shadow">
            </div>
        </div>
        <p class="mb-4">
            Elk seizoen nodigen we nieuwe makers, studenten en professionals uit om hun talent te tonen.
            Kom kijken, laat je raken, en steun de kunst van morgen.
        </p>
        <a id="voorstellingen-mobile" class="btn btn-light btn-lg px-5 py-2 mt-2">Bekijk het programma</a>
    </div>
</section>


<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>
