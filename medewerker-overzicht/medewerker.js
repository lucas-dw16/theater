// Bestand: medewerker.js

// Bij het laden van de pagina, haal de medewerkers op
window.addEventListener("DOMContentLoaded", () => {
    laadMedewerkers();

    // Formulier voor toevoegen afhandelen
    document.getElementById("addMedewerkerForm").addEventListener("submit", function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch("add_medewerker.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            toonAlert(data.message, data.success);
            if (data.success) {
                this.reset();
                laadMedewerkers();
            }
        });
    });
});

// Medewerkers ophalen en in de tabel tonen
function laadMedewerkers() {
    fetch("get_medewerker.php")
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById("medewerkerTableBody");
            tbody.innerHTML = "";

            if (data.success && data.data.length > 0) {
                data.data.forEach((medewerker, index) => {
                    const rij = document.createElement("tr");
rij.innerHTML = `
    <td>${index + 1}</td>
    <td>${medewerker.Voornaam} ${medewerker.Tussenvoegsel ?? ''} ${medewerker.Achternaam}</td>
    <td>${medewerker.Gebruikersnaam}</td>
    <td>${medewerker.Medewerkersoort}</td>
    <td>${medewerker.Nummer}</td>
    <td>
    <button class="btn btn-warning btn-sm me-2" onclick="toonWijzigForm(${medewerker.Id})">Wijzig</button>

<button onclick="verwijderMedewerker(${medewerker.Id})" class="btn btn-danger btn-sm">Verwijderen</button>
    </td>
`;

                    tbody.appendChild(rij);
                });
            } else {
                const rij = document.createElement("tr");
                rij.innerHTML = `<td colspan="6" class="text-center">Geen medewerkers gevonden.</td>`;
                tbody.appendChild(rij);
            }
        });
}

// Medewerker verwijderen
function verwijderMedewerker(id) {
    if (!confirm("Weet je zeker dat je deze medewerker wilt verwijderen?")) return;

    const formData = new FormData();
    formData.append("id", id);

    fetch("delete_medewerker.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        toonAlert(data.message, data.success);
        if (data.success) {
            laadMedewerkers();
        }
    });
}

// Helper: toon succes- of foutmelding
function toonAlert(boodschap, isSucces) {
    const alertBox = document.getElementById("alertBox");
    alertBox.innerHTML = `<div class="alert ${isSucces ? 'alert-success' : 'alert-danger'}">${boodschap}</div>`;
    setTimeout(() => alertBox.innerHTML = "", 4000);
}

// Formulier tonen/verbergen
function showAddForm() {
    const form = document.getElementById("medewerkerForm");
    form.style.display = form.style.display === "none" ? "block" : "none";
}
function toonWijzigForm(id) {
    fetch("get_medewerker.php")
        .then(res => res.json())
        .then(data => {
            const medewerker = data.data.find(m => m.Id == id);
            if (!medewerker) return;

            document.getElementById("wijzigMedewerkerForm").style.display = "block";

            document.getElementById("edit-id").value = medewerker.Id;
            document.getElementById("edit-voornaam").value = medewerker.Voornaam;
            document.getElementById("edit-tussenvoegsel").value = medewerker.Tussenvoegsel;
            document.getElementById("edit-achternaam").value = medewerker.Achternaam;
            document.getElementById("edit-gebruikersnaam").value = medewerker.Gebruikersnaam;
            document.getElementById("edit-soort").value = medewerker.Medewerkersoort;
            document.getElementById("edit-nummer").value = medewerker.Nummer;
        });
}
document.getElementById("editMedewerkerForm").addEventListener("submit", function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch("update_medewerker.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        toonAlert(data.message, data.success);
        if (data.success) {
            this.reset();
            document.getElementById("wijzigMedewerkerForm").style.display = "none";
            laadMedewerkers();
        }
    });
});
