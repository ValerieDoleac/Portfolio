console.log('[PLB] script chargé');


(function () {
    const overlay = document.querySelector('.plb-overlay');
    const container = overlay?.querySelector('.plb-container');
    const img = overlay?.querySelector('.plb-img');
    const btnPrev = overlay?.querySelector('.plb-prev');
    const btnNext = overlay?.querySelector('.plb-next');
    const btnClose = overlay?.querySelector('.plb-close');
    const titleEl = overlay?.querySelector('.plb-title');
    const catEl = overlay?.querySelector('.plb-cat');

    let items = [];     // [{src,title,cat}]
    let index = 0;
    let lastFocus = null;

    if (!overlay || !container || !img) return;

    function lockScroll(lock) {
        document.documentElement.style.overflow = lock ? 'hidden' : '';
        document.body.style.overflow = lock ? 'hidden' : '';
    }

    function setOrientation() {
        container.classList.remove('is-landscape', 'is-portrait');
        const w = img.naturalWidth, h = img.naturalHeight;
        if (!w || !h) return;
        container.classList.add(w >= h ? 'is-landscape' : 'is-portrait');
    }

    function show(i) {
        if (!items.length) return;
        index = (i + items.length) % items.length; // wrap
        const { src, title, cat } = items[index];

        img.removeAttribute('src');
        titleEl && (titleEl.textContent = title || '');
        catEl && (catEl.textContent = cat || '');

        img.onload = setOrientation;
        img.src = src;

        overlay.hidden = false;
        overlay.classList.add('is-active');
        overlay.setAttribute('aria-hidden', 'false');
        lockScroll(true);
        btnClose?.focus();
    }

    function hide() {
        overlay.classList.remove('is-active');
        overlay.setAttribute('aria-hidden', 'true');
        overlay.hidden = true;
        lockScroll(false);
        lastFocus && lastFocus.focus();
    }

    function next() { show(index + 1); }
    function prev() { show(index - 1); }

    // Clicks sur déclencheurs
    document.addEventListener('click', function (e) {
        const trigger = e.target.closest('a.js-lightbox, button.js-open-gallery');
        if (!trigger) return;

        // 1) Bouton "Aperçu" d'une carte projet
        if (trigger.matches('button.js-open-gallery')) {
            const card = trigger.closest('.carte-projet');
            if (!card) return;
            const links = [...card.querySelectorAll('.captures-projet a.js-lightbox')];
            if (!links.length) return;
            e.preventDefault();
            lastFocus = trigger;
            items = links.map(a => ({
                src: a.getAttribute('href') || a.dataset.src,
                title: a.dataset.title || '',
                cat: a.dataset.category || ''
            }));
            show(0);
            return;
        }

        // 2) Clic direct sur une vignette d'un groupe
        const group = trigger.dataset.lbGroup;
        if (!group) return; // pas un item lightbox => on laisse le lien normal
        e.preventDefault();
        lastFocus = trigger;

        const groupLinks = [...document.querySelectorAll(`a.js-lightbox[data-lb-group="${group}"]`)];
        items = groupLinks.map(a => ({
            src: a.getAttribute('href') || a.dataset.src,
            title: a.dataset.title || '',
            cat: a.dataset.category || ''
        }));
        const start = Math.max(0, groupLinks.indexOf(trigger));
        show(start);
    });

    // Contrôles
    btnNext?.addEventListener('click', next);
    btnPrev?.addEventListener('click', prev);
    btnClose?.addEventListener('click', hide);

    // Fermer en cliquant hors de l'image
    overlay.addEventListener('click', (e) => {
        const inside = e.target.closest('.plb-container, .plb-prev, .plb-next, .plb-close');
        if (!inside) hide();
    });

    // Clavier
    document.addEventListener('keydown', (e) => {
        if (overlay.classList.contains('is-active')) {
            if (e.key === 'Escape') hide();
            if (e.key === 'ArrowRight') next();
            if (e.key === 'ArrowLeft') prev();
        }
    });
})();


