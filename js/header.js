// ==========================
// MENU BURGER (mobile)
// ==========================
const burger = document.getElementById('burger');
const mobileMenu = document.getElementById('mobileMenu');

if (burger && mobileMenu) {
    burger.addEventListener('click', () => {
        mobileMenu.style.display =
            mobileMenu.style.display === 'flex' ? 'none' : 'flex';
    });
}

// ==========================
// DONUT MENU + NOTIFICATIONS
// ==========================
document.addEventListener('DOMContentLoaded', () => {

    const wrapper = document.querySelector('.donut-hover-zone'); // zone hover
    const donutIcons = document.querySelector('.donut-icons');
    const notifDot = document.querySelector('.notif-dot');
    const basketIcon = donutIcons?.querySelector('.bxs-basket');

    if (!wrapper || !donutIcons) return;

    // 🔔 Afficher notif donut si ajout panier
    if (notifDot && sessionStorage.getItem('panierNotif') === 'true') {
        notifDot.style.display = 'block';
    }

    // 🟢 OUVERTURE MENU (hover sur TOUTE la zone)
    wrapper.addEventListener('mouseenter', () => {
        donutIcons.style.display = 'block';
        donutIcons.style.opacity = '1';
        donutIcons.style.pointerEvents = 'auto';

        // badge panier
        if (basketIcon && sessionStorage.getItem('panierNotif') === 'true') {
            basketIcon.classList.add('basket-notif');
        }

        // retirer point rouge du donut
        if (notifDot) {
            notifDot.style.display = 'none';
        }
    });

    // 🔴 FERMETURE MENU (quand on quitte TOUTE la zone)
    wrapper.addEventListener('mouseleave', () => {
        donutIcons.style.opacity = '0';
        donutIcons.style.pointerEvents = 'none';

        setTimeout(() => {
            donutIcons.style.display = 'none';
        }, 200);
    });

});
