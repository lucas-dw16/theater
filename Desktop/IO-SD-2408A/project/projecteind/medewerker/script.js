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


