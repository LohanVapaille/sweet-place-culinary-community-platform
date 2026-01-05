<?php if (!isset($_COOKIE['accept_cookies'])): ?>
    <div id="cookie-banner" class="cookies-container">
        <h1>On fait des donuts, mais on aime aussi les cookies !</h1>
        <p>Ce site utilise des cookies pour vous offrir la
            meilleure expérience utilisateur</p>
        <button id="btn-accept-cookies" class="btn">D'accord
            !</button>
    </div>
<?php endif; ?>

<script>document.getElementById('btn-accept-cookies')?.addEventListener('click', function () {
        // Crée un cookie nommé 'accept_cookies' avec la valeur 'true'
        // expires=... définit la durée (ici 30 jours)
        const date = new Date();
        date.setTime(date.getTime() + (30 * 24 * 60 * 60 * 1000));
        document.cookie = "accept_cookies=true; expires=" + date.toUTCString() + "; path=/";

        // Cache la bannière
        document.getElementById('cookie-banner').style.display = 'none';
    });</script>