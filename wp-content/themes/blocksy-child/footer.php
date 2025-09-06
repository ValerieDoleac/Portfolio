<?php
/**
 * Footer du thème enfant
 */
?>

<footer class="site-footer">
    <p>&copy; <?php echo date('Y'); ?> Valérie Doléac. Tous droits réservés.</p>
</footer>

<!-- Portfolio Lightbox -->
<div class="plb-overlay" aria-hidden="true" hidden>
    <button class="plb-close" aria-label="Fermer">&times;</button>

    <button class="plb-prev" aria-label="Précédente">‹</button>
    <div class="plb-container">
        <img class="plb-img" alt="">
    </div>
    <button class="plb-next" aria-label="Suivante">›</button>

    <div class="plb-text">
        <span class="plb-title"></span>
        <span class="plb-cat"></span>
    </div>
</div>


<?php wp_footer(); ?>
</body>
</html>

