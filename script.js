document.addEventListener("DOMContentLoaded", function () {
    // Navigation function with a URL existence check
    function navigate(element, url) {
        if (element) {
            element.addEventListener("click", function (e) {
                e.preventDefault();
                // Use fetch to send a HEAD request to check if the URL exists
                fetch(url, { method: 'HEAD' })
                    .then(response => {
                        if (response.ok) {
                            window.location.href = url;
                        } else {
                            alert("pagina niet gevonden, excuus voor het ongemak");
                        }
                    })
                    .catch(error => {
                        console.error("Error checking URL:", error);
                        alert("Error checking page: " + url);
                    });
            });
        }
    }

    // Map element IDs to their respective URLs
    const links = [
        { id: "voorstellingen-desktop", url: "voorstellingen.php" },
        { id: "home-desktop", url: "index.php" },
        { id: "overTheaterMBO-desktop", url: "overTheaterMBO.php" },
        { id: "login-desktop", url: "inloggen/login.php" },
        { id: "voorstellingen-mobile", url: "voorstellingen.php" },
        { id: "home-mobile", url: "index.php" },
        { id: "overTheaterMBO-mobile", url: "overTheaterMBO.php" },
        { id: "login-mobile", url: "inloggen/login.php" }
    ];

    // Set up navigation with existence check for each link
    links.forEach(link => {
        const element = document.getElementById(link.id);
        navigate(element, link.url);
    });
});