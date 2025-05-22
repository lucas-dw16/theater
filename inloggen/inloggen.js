// Voeg een event listener toe aan het formulier met ID 'loginForm' die reageert op het 'submit'-event
document.getElementById("loginForm").addEventListener("submit", function (e) {
        // Haal en trim de waarde van het gebruikersnaamveld uit het formulier (witruimtes verwijderen)

    const username = this.gebruikersnaam.value.trim();
        // Haal en trim de waarde van het wachtwoordveld uit het formulier

    const password = this.wachtwoord.value.trim();
    // Controleer of gebruikersnaam of wachtwoord leeg is

    if (username === "" || password === "")
                // Voorkom dat het formulier wordt verzonden
 {
        e.preventDefault();
                // Toon een waarschuwing aan de gebruiker

        alert("Vul zowel gebruikersnaam als wachtwoord in.");
    }
});
