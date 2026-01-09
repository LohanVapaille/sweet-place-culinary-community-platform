document.querySelectorAll('.subscribe-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const userId = btn.getAttribute('data-user');

        fetch('subscribe.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `user_id=${encodeURIComponent(userId)}`
        })
            .then(res => {

                if (res.status === 401) {

                    window.location.href = 'connexion.php';
                    throw new Error('Not logged in');
                }

                const ct = res.headers.get('content-type') || '';
                if (!ct.includes('application/json')) {
                    throw new Error('Réponse non-JSON reçue (' + ct + ')');
                }
                if (!res.ok) {
                    throw new Error('Erreur réseau: ' + res.status);
                }
                return res.json();
            })
            .then(data => {
                if (!data || !data.status) return;
                if (data.status === 'subscribed') {
                    btn.textContent = 'Suivit';
                    btn.classList.add('following');
                    btn.classList.remove('follow');
                } else if (data.status === 'unsubscribed') {
                    btn.textContent = "Suivre";
                    btn.classList.remove('following');
                    btn.classList.add('follow');
                } else if (data.status === 'not_logged_in') {

                    window.location.href = 'connexion.php';
                } else {
                    console.warn('Réponse inattendue:', data);
                }
            })
            .catch(err => {
                console.error('Erreur subscribe:', err);

            });
    });
});
