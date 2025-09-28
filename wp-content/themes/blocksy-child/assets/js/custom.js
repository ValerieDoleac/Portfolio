document.addEventListener("DOMContentLoaded", function () {
    const offcanvas = document.getElementById("offcanvas");
    if (!offcanvas) {
        return;
    }

    offcanvas.style.width = "100vw";
    offcanvas.style.left = "0";
    offcanvas.style.maxWidth = "100vw";
    offcanvas.style.backgroundColor = "#1a1a1a";
});

// Animation des titres h3 dans la page "À propos"
document.addEventListener('DOMContentLoaded', function () {
    // Titres H3 de la page À propos (ID = 12)
    const targets = document.querySelectorAll('body.page-id-12 h3.elementor-heading-title');
    if (!targets.length) return;

    const io = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('in-view');
            } else {
                entry.target.classList.remove('in-view'); // rejoue quand on remonte
            }
        });
    }, { threshold: 0.2, rootMargin: '0px 0px -10% 0px' });

    targets.forEach(el => io.observe(el));
});






