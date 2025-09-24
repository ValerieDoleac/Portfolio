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

// chargement de l'image de fond
document.addEventListener('DOMContentLoaded', function () {
    const section = document.querySelector('section.hero-projets');
    if (!section) return;

    const webp = section.getAttribute('data-bg');
    const fallback = section.getAttribute('data-bg-fallback') || webp;

    const img = new Image();
    img.onload = () => {
        section.style.backgroundImage = `url('${webp}')`;
    };
    img.onerror = () => {
        section.style.backgroundImage = `url('${fallback}')`;
    };
    img.src = webp;
});

// ============================================================
// HERO PROJETS : Effet Parallax fluide au scroll
// ============================================================
document.addEventListener("scroll", function () {
    const section = document.querySelector("section.hero-projets");
    if (!section) return;

    let offset = window.pageYOffset;
    section.style.backgroundPositionY = -(offset * 0.3) + "px";
    // 0.3 = vitesse (plus petit = plus lent)
});


