<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Theater MBO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT"
        crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- navbar-->
    <div id="navbar-container">
        <div class="text-center mb-0"><h5>Theater MBO</h5></div>
        <div id="navbar" class="d-none d-lg-block">
            <div class="row">
                <div class="col-1"></div>
                <div class="col-10">
                    <a id="voorstellingen-desktop">Voorstellingen</a>
                    <a id="home-desktop">Home</a>
                    <a id="overTheaterMBO-desktop">Over Theater MBO</a>
                </div>
                <div class="col-1 logincontainer">
                    <a id="login-desktop" class="login">login/register</a>
                </div>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light d-lg-none">
            <div class="container-fluid">
                <span class="navbar-brand">Theater MBO</span>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a id="voorstellingen-mobile" class="nav-link">Voorstellingen</a>
                        </li>
                        <li class="nav-item">
                            <a id="home-mobile" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item">
                            <a id="overTheaterMBO-mobile" class="nav-link">Over Theater MBO</a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        <a id="login-mobile" class="login">login/register</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <div>
        <h2 class="text-center m-4">Theater MBO</h2>
    </div>

    <!-- slideshow-->
    <div class="w-75 mx-auto">
        <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="10000">
                    <img src="https://www.louwmanmuseum.nl/app/uploads/2020/01/k2_Y8A3819.jpg" class="d-block w-100" alt="..." style="height: 500px; object-fit: cover;">
                </div>
                <div class="carousel-item" data-bs-interval="2000">
                    <img src="https://www.theaterkrant.nl/wp-content/uploads/2022/10/Een-leuk-avondje-uit-Kurt-van-der-Elst-scaled-e1665740748889-1240x814.jpg" class="d-block w-100" alt="..." style="height: 500px; object-fit: cover;">
                </div>
                <div class="carousel-item">
                    <img src="https://www.jansstheater.nl/img/webp/_9119_1737934534.webp" class="d-block w-100" alt="..." style="height: 500px; object-fit: cover;">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <!-- tekst en foto-->
    <div class="w-75 mx-auto">
        <div class="row">
            <div class="col-6">
                <h2 class="m-4">Over Theater MBO</h2>
                <p>Theater MBO is een platform dat studenten de kans biedt om hun talenten te tonen en
                    te ontwikkelen. We organiseren verschillende voorstellingen en evenementen waar studenten hun
                    vaardigheden kunnen laten zien.</p>
            </div>
            <div class="col-6">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS1TQwaJHQpZnzanhlBgCCOsbSjj8m5LXjPTA&s" alt="...">
            </div>
        </div>
    </div>

    <div class="mt-5 mb-5" style="background-color: #4A90E2; padding: 20px; color: white;">
        <h2 class="text-center m-4">Onze Voorstellingen</h2>
    </div>

    <!-- Hier begint het overzicht van de voorstellingen -->
    

    <!-- bootstrap link-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>