document.addEventListener("DOMContentLoaded", function() {
    // Funzione per filtrare i progetti in base al creatore
    const searchInput = document.getElementById("searchCreator");
    searchInput.addEventListener("keyup", function() {
        const filter = searchInput.value.toLowerCase();
        const projectCards = document.querySelectorAll(".col-md-4");
        projectCards.forEach(card => {
            const creator = card.getAttribute("data-creator").toLowerCase();
            if (creator.indexOf(filter) > -1) {
                card.style.display = "";
            } else {
                card.style.display = "none";
            }
        });
    });


    // Pulsante per resettare il filtro di ricerca e l'ordinamento
    document.getElementById("resetFilters").addEventListener("click", function() {
        searchInput.value = "";
        orderSelect.selectedIndex = 0;
        const projectCards = document.querySelectorAll(".col-md-4");
        projectCards.forEach(card => {
            card.style.display = "";
        });
    });
});
