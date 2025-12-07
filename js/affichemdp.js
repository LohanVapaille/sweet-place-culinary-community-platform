document.querySelectorAll('.toggle-pw').forEach(function (icon) {
    icon.addEventListener('click', function () {
        const input = this.previousElementSibling;
        if (input.type === 'password') {
            input.type = 'text';
            this.classList.remove('bx-low-vision');
            this.classList.add('bx-show-alt');
        } else {
            input.type = 'password';
            this.classList.remove('bx-show-alt');
            this.classList.add('bx-low-vision');
        }
    });
});

