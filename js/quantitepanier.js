(function () {
    async function postJSON(data) {
        const resp = await fetch(location.href, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data),
            credentials: 'same-origin'
        });
        return resp.json();
    }

    function findAncestor(el, selector) {
        while (el && el !== document.body) {
            if (el.matches(selector)) return el;
            el = el.parentElement;
        }
        return null;
    }

    document.getElementById('cart-list')?.addEventListener('click', async function (e) {
        const target = e.target;
        // Trouver l'élément .cart-item parent
        const itemEl = findAncestor(target, '.cart-item');
        if (!itemEl) return;

        // Trouver le bouton réel cliquable : increase / decrease / remove
        // On cherche les éléments qui portent ces classes ou un bouton (fallback)
        const actionBtn = target.closest('.increase, .decrease, .remove, button');
        if (!actionBtn) return;

        const id_fk_panier = parseInt(itemEl.getAttribute('data-id_fk_panier'), 10);
        const qtyEl = itemEl.querySelector('.qty');
        let qty = parseInt(qtyEl.textContent, 10);

        // Incrémenter
        if (actionBtn.classList.contains('increase')) {
            qty++;
            const res = await postJSON({ action: 'update_quantity', id_fk_panier: id_fk_panier, quantite: qty });
            if (res.success) {
                qtyEl.textContent = qty;
            } else {
                alert(res.msg || 'Erreur mise à jour');
            }
            return;
        }

        // Décrémenter
        if (actionBtn.classList.contains('decrease')) {
            qty = Math.max(0, qty - 1);
            const res = await postJSON({ action: 'update_quantity', id_fk_panier: id_fk_panier, quantite: qty });
            if (res.success) {
                if (res.deleted) {
                    itemEl.remove();
                    if (!document.querySelectorAll('.cart-item').length) {
                        document.getElementById('cart-list').innerHTML = '<div class="empty">Ton panier est vide.</div>';
                    }
                } else {
                    qtyEl.textContent = qty;
                }
            } else {
                alert(res.msg || 'Erreur mise à jour');
            }
            return;
        }

        // Supprimer (corbeille)
        if (actionBtn.classList.contains('remove')) {
            if (!confirm('Supprimer cet article du panier ?')) return;
            const res = await postJSON({ action: 'update_quantity', id_fk_panier: id_fk_panier, quantite: 0 });
            if (res.success) {
                itemEl.remove();
                if (!document.querySelectorAll('.cart-item').length) {
                    document.getElementById('cart-list').innerHTML = '<div class="empty">Ton panier est vide.</div>';
                }
            } else {
                alert(res.msg || 'Erreur suppression');
            }
            return;
        }

        // Si on clique sur un <button> sans classes spécifiques, on ne fait rien
    });
})();