
document.addEventListener("DOMContentLoaded", function () {

    // couple selectId -> imgId
    const pairs = [
        { selectId: "beignet", imgId: "img-beignet" },
        { selectId: "fourrage", imgId: "img-fourrage" },
        { selectId: "glacage", imgId: "img-glacage" },
        { selectId: "topping", imgId: "img-topping" },
        { selectId: "sucresale", imgId: "img-type" }
    ];

    pairs.forEach(pair => {
        const sel = document.getElementById(pair.selectId);
        const img = document.getElementById(pair.imgId);
        if (!sel || !img) return;

        const defaultSrc = img.src || "";

        function updateFromSelect() {
            const opt = sel.options[sel.selectedIndex];
            // priorité : data-img sur l'option
            const dataImg = opt && opt.dataset && opt.dataset.img ? opt.dataset.img.trim() : "";
            if (dataImg) {
                img.src = dataImg;
                img.alt = opt.text || sel.value;
                return;
            }
            // sinon : fallback au src par défaut
            img.src = defaultSrc;
            img.alt = sel.value || img.alt;
        }

        sel.addEventListener("change", updateFromSelect);
        // initialise l'image correctement au chargement (utile si POST repopule le select)
        updateFromSelect();
    });

    function updateText(selectId, spanId, defaultText = "Pas sélectionné") {
        const select = document.getElementById(selectId);
        const span = document.getElementById(spanId);

        function refresh() {
            const selectedOption = select.options[select.selectedIndex];
            span.textContent = selectedOption.value
                ? selectedOption.textContent
                : defaultText;
        }

        // Mise à jour au chargement
        refresh();

        // Mise à jour au changement
        select.addEventListener("change", refresh);
    }

    // Liaisons
    updateText("sucresale", "name-type");
    updateText("beignet", "name-beignet");
    updateText("fourrage", "name-fourrage");
    updateText("glacage", "name-glacage");
    updateText("topping", "name-topping");


});

