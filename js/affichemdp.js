document.querySelectorAll('.toggle-pw').forEach(icon => {
    icon.addEventListener('click', () => {
        const input = icon.previousElementSibling;

        if (!input || input.tagName !== 'INPUT') return;

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bx-low-vision', 'bx-show-alt');
        } else {
            input.type = 'password';
            icon.classList.replace('bx-show-alt', 'bx-low-vision');
        }
    });
});
