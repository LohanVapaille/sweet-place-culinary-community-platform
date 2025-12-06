// like.js (universel, gère classes bx / bxs et hover)
document.addEventListener('DOMContentLoaded', () => {
  // Delegated click handler
  document.addEventListener('click', async (e) => {
    const heart = e.target.closest('.btnlike');
    if (!heart) return;

    const id = heart.dataset.id;
    if (!id) return;

    if (heart.dataset.locked === '1') return;
    heart.dataset.locked = '1';

    const card = heart.closest('.card');
    const counterEl = card ? card.querySelector('.nb_like') : null;
    const source = heart.dataset.source || 'composition';
    const endpoint = source === 'base' ? 'like_base.php' : 'like.php';

    try {
      const resp = await fetch(endpoint, {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        // Envoi uniforme { id: ... } — like.php accepte aussi id_composition
        body: JSON.stringify({ id: id })
      });

      const text = await resp.text();
      let data;
      try { data = JSON.parse(text); } catch (err) {
        console.error('Réponse non JSON:', text);
        alert('Réponse serveur inattendue. Voir console.');
        return;
      }

      console.log(data);

      if (resp.status === 401) {

        window.location.href = data.redirect;
        return;
      }

      if (!data.success) {
        console.error('Erreur like:', data);
        alert(data.message || 'Erreur lors du like.');
        return;
      }

      // Mettre à jour compteur
      if (typeof data.likes !== 'undefined' && counterEl) {
        counterEl.textContent = data.likes;
      }

      // Mettre à jour état durable (dataset.liked) et classes d'icône
      if (data.liked) {
        heart.dataset.liked = '1';
        heart.classList.remove('bx-heart');
        heart.classList.add('bxs-heart');
      } else {
        delete heart.dataset.liked;
        heart.classList.remove('bxs-heart');
        heart.classList.add('bx-heart');
      }

    } catch (err) {
      console.error('Erreur fetch:', err);
      alert('Erreur réseau. Voir console.');
    } finally {
      heart.dataset.locked = '0';
    }
  });

  // Hover effect (delegated)
  document.addEventListener('mouseover', (e) => {
    const heart = e.target.closest('.btnlike');
    if (!heart) return;

    // si pas déjà liked, montrer icône pleine au hover
    if (!heart.dataset.liked) {
      heart.classList.add('bxs-heart', 'hover-temp');
      heart.classList.remove('bx-heart');
    }
  });

  document.addEventListener('mouseout', (e) => {
    const heart = e.target.closest('.btnlike');
    if (!heart) return;

    // si on avait ajouté l'effet hover (hover-temp) et ce n'est pas liked, on retire
    if (heart.classList.contains('hover-temp') && !heart.dataset.liked) {
      heart.classList.remove('bxs-heart', 'hover-temp');
      heart.classList.add('bx-heart');
    }
  });

  // Optionnel : au chargement, si ton HTML utilise data-liked="1", synchroniser classes
  document.querySelectorAll('.btnlike').forEach(heart => {
    if (heart.dataset.liked === '1' || heart.getAttribute('data-liked') === '1') {
      // état déjà liké côté serveur -> icone pleine
      heart.dataset.liked = '1';
      heart.classList.remove('bx-heart');
      heart.classList.add('bxs-heart');
    } else {
      // état non liké -> icone vide
      delete heart.dataset.liked;
      heart.classList.remove('bxs-heart');
      heart.classList.add('bx-heart');
    }
  });
});
