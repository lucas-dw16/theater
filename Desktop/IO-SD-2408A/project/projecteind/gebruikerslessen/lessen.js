document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("Filter-1").addEventListener("keyup", Filter);
    document.getElementById("Filter-2").addEventListener("change", SortTable);
});

function Filter() {
    let maxPrijs = parseFloat(document.getElementById("Filter-1").value);
    let table = document.getElementById("table-leden");
    let tbody = table.getElementsByTagName("tbody")[0];
    let rows = tbody.getElementsByTagName("tr");
    let zichtbaar = 0;

    for (let i = 0; i < rows.length; i++) {
        let prijsCel = rows[i].getElementsByTagName("td")[5]; 
        if (prijsCel) {
            let prijs = parseFloat(prijsCel.innerText.replace(',', '.'));
            if (!isNaN(maxPrijs) && prijs > maxPrijs) {
                rows[i].style.display = "none";
            } else {
                rows[i].style.display = "";
                zichtbaar++;
            }
        }
    }

    // Verwijder bestaande melding als die er is
    let geenLessenRij = document.getElementById("geen-lessen");
    if (geenLessenRij) {
        geenLessenRij.remove();
    }

    // Als er geen zichtbare rijen meer zijn, toon de melding
    if (zichtbaar === 0) {
        let nieuweRij = document.createElement("tr");
        nieuweRij.id = "geen-lessen";
        nieuweRij.innerHTML = `<td colspan="7" style="text-align: center; font-weight: bold; color: red;">Geen lessen gevonden</td>`;
        tbody.appendChild(nieuweRij);
    }
}

// Functie om de tabel te sorteren op prijs
function SortTable() {
    let table = document.getElementById("table-leden");
    let tbody = table.getElementsByTagName("tbody")[0];
    let rows = Array.from(tbody.getElementsByTagName("tr"));
    let sortType = document.getElementById("Filter-2").value; 


    let echteRijen = rows.filter(row => !row.id || row.id !== "geen-lessen");

    echteRijen.sort((rowA, rowB) => {
        let prijsA = parseFloat(rowA.getElementsByTagName("td")[5].innerText.replace(',', '.'));
        let prijsB = parseFloat(rowB.getElementsByTagName("td")[5].innerText.replace(',', '.'));

        return sortType === "0" ? prijsA - prijsB : prijsB - prijsA;
    });

   
    tbody.innerHTML = "";
    echteRijen.forEach(row => tbody.appendChild(row));

    
    Filter();
}
