document.addEventListener("DOMContentLoaded", function () {
    const selects = {
        fourrage: document.getElementById('fourrage'),
        glacage: document.getElementById('glacage'),
        topping: document.getElementById('topping')
    };

    const options = {};
    for (const key in selects) {
        options[key] = Array.from(selects[key].options).map(opt => ({
            value: opt.value,
            text: opt.text,
            type: opt.dataset.type, // sucré ou salé
            img: opt.dataset.img
        }));
    }

    function filterSelects(type) {
        for (const key in selects) {
            const select = selects[key];
            select.innerHTML = '';
            const defaultOpt = document.createElement('option');
            defaultOpt.value = '';
            defaultOpt.textContent = '— Choisir —';
            select.appendChild(defaultOpt);

            options[key].forEach(opt => {
                if (!opt.type || opt.type === type) {
                    const optionEl = document.createElement('option');
                    optionEl.value = opt.value;
                    optionEl.textContent = opt.text;
                    optionEl.dataset.type = opt.type;
                    optionEl.dataset.img = opt.img;
                    select.appendChild(optionEl);
                }
            });
        }
    }

    // Radios pour le beignet (donuts / bagel) => type sucré / salé
    const beignetRadios = document.querySelectorAll('input[name="beignet"]');
    const imgBeignet = document.getElementById('img-beignet');

    function updateBeignetImgAndType() {
        const checked = document.querySelector('input[name="beignet"]:checked');
        if (!checked) return;

        // mettre à jour l'image
        imgBeignet.src = checked.dataset.img;

        // déterminer le type pour filtrer les selects
        const type = (checked.value === '1') ? 'sucré' : 'salé';
        document.getElementById('type_final').value = type;
        filterSelects(type);
    }

    beignetRadios.forEach(radio => {
        radio.addEventListener('change', updateBeignetImgAndType);
    });

    // Filtrage initial
    updateBeignetImgAndType();

    // Gestion images pour selects
    Object.keys(selects).forEach(key => {
        const select = selects[key];
        const imgId = 'img-' + key;
        const img = document.getElementById(imgId);
        const defaultSrc = img.src;

        function updateImg() {
            const opt = select.options[select.selectedIndex];
            img.src = (opt && opt.dataset.img) ? opt.dataset.img : defaultSrc;
        }

        select.addEventListener('change', updateImg);
        updateImg();
    });
});
