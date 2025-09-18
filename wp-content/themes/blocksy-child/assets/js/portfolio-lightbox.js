document.addEventListener('DOMContentLoaded', () => {
    const overlay = document.querySelector('#lightbox');
    if (!overlay) { console.warn('[LB] Pas de #lightbox'); return; }

    const img = overlay.querySelector('#lightbox-img');
    const closeBtns = overlay.querySelectorAll('.lightbox-close');
    const prevBtns = overlay.querySelectorAll('.lightbox-prev');
    const nextBtns = overlay.querySelectorAll('.lightbox-next');

    const items = Array.from(document.querySelectorAll(
        '.captures-projet a.js-lightbox-item, .galerie-projet a.js-lightbox-item, .captures-projet a, .galerie-projet a'
    ));

    console.log('[LB] items:', items.length);
    if (!items.length || !img) return;

    let index = 0;
    let lastFocusEl = null; // pour restaurer le focus

    function render(i) {
        index = (i + items.length) % items.length;
        const href = items[index].getAttribute('href');
        console.log('[LB] render', index, href);
        img.src = href;
    }

    function open(i) {
        console.log('[LB] open', i);
        lastFocusEl = document.activeElement;        // mémorise l’élément actif
        render(i);
        overlay.style.display = 'flex';
        overlay.setAttribute('aria-hidden', 'false');
        overlay.setAttribute('aria-modal', 'true');
        overlay.setAttribute('tabindex', '-1');
        overlay.focus({ preventScroll: true });      // optionnel
        document.body.style.overflow = 'hidden';
    }

    function close() {
        console.log('[LB] close');
        // enlève le focus des descendants AVANT d’aria-hidden
        const active = document.activeElement;
        if (overlay.contains(active)) {
            active.blur();
        }
        overlay.setAttribute('aria-hidden', 'true');
        overlay.style.display = 'none';
        document.body.style.overflow = '';
        // restaure le focus
        if (lastFocusEl && typeof lastFocusEl.focus === 'function') {
            lastFocusEl.focus();
        }
    }

    // Ouvre à partir des vignettes
    items.forEach((a, i) => {
        a.addEventListener('click', (e) => {
            e.preventDefault();
            open(i);
        });
    });

    // Précédente / Suivante (desktop + si tu les gardes en mobile)
    prevBtns.forEach(btn => btn.addEventListener('click', (e) => {
        e.preventDefault();
        render(index - 1);
    }));
    nextBtns.forEach(btn => btn.addEventListener('click', (e) => {
        e.preventDefault();
        render(index + 1);
    }));

    // Fermeture via la croix
    closeBtns.forEach(btn => btn.addEventListener('click', (e) => {
        e.preventDefault();
        close();
    }));

    // Clique sur le fond (extérieur au contenu) → ferme
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
            close();
        }
    });

    // Clavier
    document.addEventListener('keydown', (e) => {
        if (overlay.getAttribute('aria-hidden') === 'true') return;
        if (e.key === 'Escape') close();
        if (e.key === 'ArrowLeft') render(index - 1);
        if (e.key === 'ArrowRight') render(index + 1);
    });

    // Swipe (mobile)
    let startX = 0;
    overlay.addEventListener('touchstart', (e) => {
        startX = e.changedTouches[0].clientX;
    }, { passive: true });

    overlay.addEventListener('touchend', (e) => {
        const dx = e.changedTouches[0].clientX - startX;
        if (Math.abs(dx) > 40) {
            dx > 0 ? render(index - 1) : render(index + 1);
        }
    }, { passive: true });
});











