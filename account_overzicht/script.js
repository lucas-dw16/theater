document.addEventListener("DOMContentLoaded", () => {
    const zoekInput = document.getElementById("zoekInput");
    const tabelRijen = document.querySelectorAll("tbody tr");

    zoekInput.addEventListener("keyup", () => {
        const zoekterm = zoekInput.value.toLowerCase();

        tabelRijen.forEach(rij => {
            const tekst = rij.textContent.toLowerCase();
            rij.style.display = tekst.includes(zoekterm) ? "" : "none";
        });
    });
});
