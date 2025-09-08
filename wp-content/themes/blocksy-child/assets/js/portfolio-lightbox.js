document.addEventListener('DOMContentLoaded', () => {
    // Récupère tous les éléments cliquables (liens vers les captures)
    const items = Array.from(document.querySelectorAll('.captures-projet a.js-lightbox-item'));
    const overlay = document.getElementById('lightbox');
    const img = document.getElementById('lightbox-img');
    const prev = overlay ? overlay.querySelector('.lightbox-prev') : null;
    const next = overlay ? overlay.querySelector('.lightbox-next') : null;
    const closeBtn = overlay ? overlay.querySelector('.lightbox-close') : null;
    const titleEl = overlay ? overlay.querySelector('.lightbox-title') : null;
    const catEl = overlay ? overlay.querySelector('.lightbox-category') : null;

    if (!overlay || !img || !prev || !next || !closeBtn) {
        console.warn('[LB] Overlay incomplet ou absent.');
        return;
    }
    if (!items.length) {
        console.warn('[LB] Aucun élément .js-lightbox-item trouvé.');
        return;
    }

    // On construit une liste à plat de toutes les images cliquables
    const gallery = items.map((a, i) => ({
        href: a.getAttribute('href'),
        title: a.dataset.title || '',
        category: a.dataset.category || '',
        group: a.dataset.group || '', // utile si tu veux restreindre par projet
        index: i
    }));

    let index = 0;

    function render(i) {
        index = (i + gallery.length) % gallery.length; // boucle
        const g = gallery[index];
        img.src = g.href;
        if (titleEl) titleEl.textContent = g.title || '';
        if (catEl) catEl.textContent = g.category || '';
    }
    function open(i) {
        render(i);
        overlay.style.display = 'flex';
        overlay.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }
    function close() {
        overlay.style.display = 'none';
        overlay.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    // Clic sur vignettes -> ouvre
    items.forEach((a) => {
        a.addEventListener('click', (e) => {
            e.preventDefault();
            const i = gallery.findIndex(g => g.href === a.getAttribute('href'));
            open(i >= 0 ? i : 0);
        });
    });

    // Contrôles
    prev.addEventListener('click', () => render(index - 1));
    next.addEventListener('click', () => render(index + 1));
    closeBtn.addEventListener('click', close);
    overlay.addEventListener('click', (e) => { if (e.target === overlay) close(); });

    // Clavier
    document.addEventListener('keydown', (e) => {
        if (overlay.getAttribute('aria-hidden') === 'true') return;
        if (e.key === 'Escape') close();
        if (e.key === 'ArrowLeft') render(index - 1);
        if (e.key === 'ArrowRight') render(index + 1);
    });

    // Debug rapide si besoin
    console.log('[LB] OK. Items:', gallery.length);
});




