document.getElementById("loginForm").addEventListener("submit", function (e) {
    const username = this.gebruikersnaam.value.trim();
    const password = this.wachtwoord.value.trim();

    if (username === "" || password === "") {
        e.preventDefault();
        alert("Vul zowel gebruikersnaam als wachtwoord in.");
    }
});
