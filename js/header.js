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
// DONUT MENU + NOTIFICATIONS + ACCESSIBILITÉ CLAVIER
// ==========================
document.addEventListener('DOMContentLoaded', () => {

    const wrapper = document.querySelector('.donut-hover-zone');
    const trigger = document.getElementById('donutTrigger');
    const donutIcons = document.querySelector('.donut-icons');
    const links = donutIcons?.querySelectorAll('a');

    if (!wrapper || !donutIcons || !trigger) return;

    const showMenu = () => {
        donutIcons.classList.add('active');
    };

    const hideMenu = () => {
        donutIcons.classList.remove('active');
    };

    // Souris
    wrapper.addEventListener('mouseenter', showMenu);
    wrapper.addEventListener('mouseleave', hideMenu);

    // Focus clavier sur le donut
    trigger.addEventListener('focus', showMenu);

    // Focus clavier sur les liens
    links.forEach(link => link.addEventListener('focus', showMenu));

    // Si focus sort du menu → fermer
    donutIcons.addEventListener('focusout', (e) => {
        if (!wrapper.contains(e.relatedTarget)) hideMenu();
    });
});
