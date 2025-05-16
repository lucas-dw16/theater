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
    <div id="navbar-container">
        <div id="top-title">Theater MBO</div>
        <div id="navbar" class="d-none d-lg-block">
            <div class="row">
                <div class="col-1"></div>
                <div class="col-10">
                    <a href="voorstellingen.php">Voorstellingen</a>
                    <a href="index.php">Home</a>
                    <a href="overTheaterMBO.php">Over Theater MBO</a>
                </div>
                <div class="col-1 logincontainer"><a href="inloggen/index.php" class="login">login/register</a></div>
            </div>
        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light d-lg-none" style="background-color: #e3f0ff !important;">
            <div class="container-fluid">
                <span class="navbar-brand">Theater MBO</span>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="voorstellingen.php">Voorstellingen</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="overTheaterMBO.php">Over Theater MBO</a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        <a href="login.php" class="login">login/register</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" 
    crossorigin="anonymous"></script>
</body>

</html>