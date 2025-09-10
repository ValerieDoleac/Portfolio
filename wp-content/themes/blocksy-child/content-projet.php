<?php
/**
 * Template Part: Carte d'un projet pour l'archive
 * Champs ACF utilisés :
 *  - image_projet (Image) : miniature de fond
 *  - lien (URL) : éventuel lien externe (non utilisé ici)
 */

// Données ACF / WP
$miniature = get_field('image_projet');     // array ACF
$titre     = get_the_title();
$lien_wp   = get_permalink();

// Image de fond
$image_bg_url = $miniature['url'] ?? '';
$style_bg     = $image_bg_url
    ? " style=\"background-image:url('". esc_url($image_bg_url) ."')\""
    : '';
?>
<article class="carte-projet"<?php echo $style_bg; ?>>
    <div class="overlay">
    <!-- Barre titre + lien -->
    <div class="carte-barre"
            style="display:flex; align-items:center; justify-content:space-between; gap:16px; width:100%;">
        <h3 class="titre-projet" style="margin:0;"><?php echo esc_html($titre); ?></h3>

        <a href="<?php echo esc_url($lien_wp); ?>" class="voir-projet">
        Voir le projet
        </a>
    </div>
    </div>
</article>




