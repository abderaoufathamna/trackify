document.addEventListener('DOMContentLoaded', () => {
    const container = document.querySelector('.container');
    const switchLink = document.querySelector('.overlay-panel a.ghost');

    if (!container || !switchLink) return;

    switchLink.addEventListener('click', (e) => {
        e.preventDefault();
        const destination = switchLink.href;

        container.classList.add('leaving');

        container.addEventListener('animationend', () => {
            window.location.href = destination;
        }, { once: true });
    });
});
