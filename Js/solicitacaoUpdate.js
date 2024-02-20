function removerinput_area_da_visita() {
    const fabrica = document.querySelector("#acesso_fabrica");
    const area_visita = document.querySelector("#area_visita");

    function toggleAreaVisita() {
        const isChecked = !fabrica.checked;
        console.log(isChecked);

        if (isChecked) {
            area_visita.classList.add("d-none");
        } else {
            area_visita.classList.remove("d-none");
        }
    }

    toggleAreaVisita();

    // Add an event listener to the checkbox
    fabrica.addEventListener('change', toggleAreaVisita);
}

removerinput_area_da_visita();