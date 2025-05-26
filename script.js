// Wacht tot de hele DOM geladen is voordat scripts uitgevoerd worden
document.addEventListener("DOMContentLoaded", function () {

    // Navigatiefunctie: checkt of URL echt bestaat voordat er naartoe genavigeerd wordt
    function navigate(element, url) {
        if (element) {
            element.addEventListener("click", function (e) {
                e.preventDefault(); // voorkom standaard linkgedrag

                // Verstuur een HEAD-verzoek om te checken of de pagina bestaat (geen volledige inhoud nodig)
                fetch(url, { method: 'HEAD' })
                    .then(response => {
                        if (response.ok) {
                            // Als pagina bestaat (status 200), ga erheen
                            window.location.href = url;
                        } else {
                            // Pagina bestaat niet
                            alert("pagina niet gevonden, excuus voor het ongemak");
                        }
                    })
                    .catch(error => {
                        // Bij netwerkfout of serverfout
                        console.error("Error checking URL:", error);
                        alert("Error checking page: " + url);
                    });
            });
        }
    }

    // Array met id's van knoppen/links en de URLs waar ze naartoe moeten verwijzen
    const links = [
        { id: "voorstellingen-desktop", url: "voorstellingen.php" },
        { id: "home-desktop", url: "index.php" },
        { id: "overTheaterMBO-desktop", url: "overTheaterMBO.php" },
        { id: "login-desktop", url: "inloggen/login.php" },
        { id: "voorstellingen-mobile", url: "voorstellingen.php" },
        { id: "home-mobile", url: "index.php" },
        { id: "overTheaterMBO-mobile", url: "overTheaterMBO.php" },
        { id: "login-mobile", url: "inloggen/login.php" },
        { id: "mangmentDashboard", url: "inloggen/dashboard.php" },
        { id: "voorstellingen", url: "voorstellingen.php" }
    ];

    // Loop door alle links en koppel de navigatie
    links.forEach(link => {
        const element = document.getElementById(link.id);
        navigate(element, link.url); // pas navigatiefunctie toe per item
    });
});
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
