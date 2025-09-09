document.addEventListener('DOMContentLoaded', () => {
    // ---- Sélecteurs tolérants (archive ET single)
    const overlay = document.getElementById('lightbox');
    if (!overlay) {
        console.warn('[LB] Pas d’overlay #lightbox dans le DOM.');
        return;
    }

    const img = overlay.querySelector('#lightbox-img');
    const prev = overlay.querySelector('.lightbox-prev');
    const next = overlay.querySelector('.lightbox-next');
    const closeBt = overlay.querySelector('.lightbox-close');
    const titleEl = overlay.querySelector('.lightbox-title');
    const catEl = overlay.querySelector('.lightbox-category');

    if (!img || !prev || !next || !closeBt) {
        console.warn('[LB] Overlay incomplet (img/prev/next/close manquants).');
        return;
    }

    // 1) Récupère les items cliquables:
    //  - archive: .captures-projet a.js-lightbox-item
    //  - single : .galerie-projet  a.js-lightbox-item
    let items = Array.from(document.querySelectorAll(
        '.captures-projet a.js-lightbox-item, .galerie-projet a.js-lightbox-item'
    ));

    // fallback si la classe a été oubliée : récupérer tous les <a> à l’intérieur des listes
    if (!items.length) {
        items = Array.from(document.querySelectorAll(
            '.captures-projet a, .galerie-projet a'
        ));
    }

    if (!items.length) {
        console.warn('[LB] Aucun élément cliquable trouvé (.js-lightbox-item).');
        return;
    }

    // 2) Construit la "galerie" plate
    const gallery = items.map((a, i) => ({
        href: a.getAttribute('href'),
        title: a.dataset.title || document.title || '',
        category: a.dataset.category || '',
        group: a.dataset.group || a.closest('[data-lb-group]')?.getAttribute('data-lb-group') || '',
        index: i,
        el: a
    }));

    // 3) Si on est sur l’archive et que tu veux restreindre au groupe cliqué,
    //    on filtrera dynamiquement à l’ouverture (voir openFrom()).
    let index = 0;
    let activeList = gallery; // liste courante (peut être filtrée par group)

    function render(i) {
        if (!activeList.length) return;
        index = (i + activeList.length) % activeList.length; // boucle 1↔N
        const g = activeList[index];
        img.src = g.href;
        if (titleEl) titleEl.textContent = g.title;
        if (catEl) catEl.textContent = g.category;
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

    // Ouvre à partir d’un élément (filtre éventuellement par group)
    function openFrom(anchorEl) {
        const href = anchorEl.getAttribute('href');
        const group = anchorEl.dataset.group
            || anchorEl.closest('[data-lb-group]')?.getAttribute('data-lb-group')
            || '';

        // Si un group est défini, on restreint la liste aux items de ce group (utile sur l’archive)
        activeList = group
            ? gallery.filter(g => g.group === group)
            : gallery.slice();

        // Trouve l’index de l’élément cliqué dans la liste active
        const start = activeList.findIndex(g => g.href === href);
        open(start >= 0 ? start : 0);
    }

    // 4) Gestion des clics sur les vignettes
    items.forEach((a) => {
        a.addEventListener('click', (e) => {
            // Ne pas laisser le navigateur ouvrir l’image
            e.preventDefault();
            openFrom(a);
        });
    });

    // 5) Contrôles Overlay
    prev.addEventListener('click', () => render(index - 1));
    next.addEventListener('click', () => render(index + 1));
    closeBt.addEventListener('click', close);
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) close(); // clic sur le fond
    });

    // 6) Clavier
    document.addEventListener('keydown', (e) => {
        if (overlay.getAttribute('aria-hidden') === 'true') return;
        if (e.key === 'Escape') close();
        if (e.key === 'ArrowLeft') render(index - 1);
        if (e.key === 'ArrowRight') render(index + 1);
    });

    // Debug
    console.log('[LB] OK. Items globaux :', gallery.length);
});




