// filter op naam van een lid

function myFunction() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("myInput");
    inputType = document.getElementById("myInputType");
    filter = input.value.toUpperCase();
    table = document.getElementById("table-leden");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[inputType.value];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}

// zorg dat alle velden verplicht ingevuld moeten zijn
document.querySelector("form").addEventListener("submit", function(event) {
    let inputs = document.querySelectorAll("input[required]");
    let valid = true;

    inputs.forEach(input => {
        if (input.value.trim() === "") {
            valid = false;
            input.classList.add("is-invalid"); 
        } else {
            input.classList.remove("is-invalid");
        }
    });

    if (!valid) {
        event.preventDefault();
        alert("Vul alle verplichte velden in!");
    }
});

document.addEventListener("DOMContentLoaded", function () {
    let filterActive = false; // Start met filter UIT
    const toggleButton = document.getElementById("toggleFilter");
    const table = document.getElementById("table-leden");
    const rows = table.getElementsByTagName("tr");

    toggleButton.addEventListener("click", function () {
        filterActive = !filterActive; // Toggle status
        toggleButton.textContent = filterActive ? "Toon alle leden" : "Toon alleen nieuwe leden";

        let currentMonth = new Date().getMonth() + 1; // Huidige maand (1-12)
        let currentYear = new Date().getFullYear(); // Huidig jaar

        for (let i = 1; i < rows.length; i++) { // Start vanaf 1 om de tabelkop over te slaan
            let dateCell = rows[i].getElementsByTagName("td")[6]; // Kolom met inschrijvingsdatum
            if (dateCell) {
                let inschrijfDatum = new Date(dateCell.textContent.trim());
                let rowMonth = inschrijfDatum.getMonth() + 1;
                let rowYear = inschrijfDatum.getFullYear();

                if (filterActive) {
                    // Filter AAN: verberg oude leden, toon nieuwe leden
                    if (rowMonth !== currentMonth || rowYear !== currentYear) {
                        rows[i].style.display = "none"; 
                    } else {
                        rows[i].style.display = ""; 
                    }
                } else {
                    // Filter UIT: toon ALLE leden
                    rows[i].style.display = ""; 
                }
            }
        }
    });
});



