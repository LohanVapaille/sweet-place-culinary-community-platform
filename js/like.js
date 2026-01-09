
document.addEventListener('DOMContentLoaded', () => {

  // Gestion clavier (Enter / Space => clic simulé)
  document.addEventListener('keydown', (e) => {
    const heart = e.target.closest('.btnlike');
    if (!heart) return;

    if (e.key === 'Enter' || e.key === ' ') {
      e.preventDefault();
      heart.click();
    }
  });

  // Delegated click handler
  document.addEventListener('click', async (e) => {
    const heart = e.target.closest('.btnlike');
    if (!heart) return;

    const id = heart.dataset.id;
    if (!id) return;

    if (heart.dataset.locked === '1') return;
    heart.dataset.locked = '1';


    const container = heart.closest('.onecard-container') || heart.closest('.card') || document;
    const counterEl = container.querySelector('.nb_like');
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


      if (typeof data.likes !== 'undefined' && counterEl) {

        const likesNum = Number(data.likes);
        if (!Number.isNaN(likesNum)) {
          counterEl.textContent = likesNum;
        } else {

          const current = Number(counterEl.textContent) || 0;
          counterEl.textContent = data.liked ? current + 1 : Math.max(0, current - 1);
        }
      }


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


  document.addEventListener('mouseover', (e) => {
    const heart = e.target.closest('.btnlike');
    if (!heart) return;

    if (!heart.dataset.liked) {
      heart.classList.add('bxs-heart', 'hover-temp');
      heart.classList.remove('bx-heart');
    }
  });

  document.addEventListener('mouseout', (e) => {
    const heart = e.target.closest('.btnlike');
    if (!heart) return;

    if (heart.classList.contains('hover-temp') && !heart.dataset.liked) {
      heart.classList.remove('bxs-heart', 'hover-temp');
      heart.classList.add('bx-heart');
    }
  });


  document.querySelectorAll('.btnlike').forEach(heart => {
    if (heart.dataset.liked === '1' || heart.getAttribute('data-liked') === '1') {
      heart.dataset.liked = '1';
      heart.classList.remove('bx-heart');
      heart.classList.add('bxs-heart');
    } else {
      delete heart.dataset.liked;
      heart.classList.remove('bxs-heart');
      heart.classList.add('bx-heart');
    }
  });
});
