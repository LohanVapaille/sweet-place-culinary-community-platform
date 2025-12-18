
document.addEventListener('DOMContentLoaded', () => {
    const container = document.querySelector('.cards-container');
    const cards = Array.from(container.querySelectorAll('.userdonuts'));

    const filterType = document.getElementById('filterType');
    const filterPrice = document.getElementById('filterPrice');
    const filterLikes = document.getElementById('filterLikes');
    const filterNote = document.getElementById('filterNote');
    const filterName = document.getElementById('filterName');

    function applyFilters() {
        let filteredCards = [...cards];

        // Filtre type
        const typeValue = filterType.value;
        if (typeValue !== 'all') {
            filteredCards = filteredCards.filter(card => card.dataset.type.toLowerCase() === typeValue);
        }

        // Tri prix
        if (filterPrice.value === 'priceAsc') {
            filteredCards.sort((a, b) => parseFloat(a.dataset.prix) - parseFloat(b.dataset.prix));
        } else if (filterPrice.value === 'priceDesc') {
            filteredCards.sort((a, b) => parseFloat(b.dataset.prix) - parseFloat(a.dataset.prix));
        }

        // Tri likes
        if (filterLikes.value === 'likesAsc') {
            filteredCards.sort((a, b) => parseInt(a.dataset.nblike) - parseInt(b.dataset.nblike));
        } else if (filterLikes.value === 'likesDesc') {
            filteredCards.sort((a, b) => parseInt(b.dataset.nblike) - parseInt(a.dataset.nblike));
        }

        // Tri note
        if (filterNote.value === 'noteAsc') {
            filteredCards.sort((a, b) => parseFloat(a.dataset.note) - parseFloat(b.dataset.note));
        } else if (filterNote.value === 'noteDesc') {
            filteredCards.sort((a, b) => parseFloat(b.dataset.note) - parseFloat(a.dataset.note));
        }

        // Tri nom
        if (filterName.value === 'nameAsc') {
            filteredCards.sort((a, b) => a.dataset.name.localeCompare(b.dataset.name));
        } else if (filterName.value === 'nameDesc') {
            filteredCards.sort((a, b) => b.dataset.name.localeCompare(a.dataset.name));
        }

        // Réaffichage
        filteredCards.forEach(card => card.closest('.onecard-container').style.display = '');
        cards.forEach(card => {
            if (!filteredCards.includes(card)) {
                card.closest('.onecard-container').style.display = 'none';
            }
        });

        filteredCards.forEach(card => container.appendChild(card.closest('.onecard-container')));
    }

    // Écouteurs
    [filterType, filterPrice, filterLikes, filterNote, filterName].forEach(select => {
        select.addEventListener('change', applyFilters);
    });
});
