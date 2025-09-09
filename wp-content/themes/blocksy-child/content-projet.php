<?php
/**
 * Template Part: Carte d'un projet pour l'archive
 * Compatible avec ACF:
 *  - image_projet (Image) : miniature de fond
 *  - image_1..image_5 (Image) : captures
 *  - lien (URL) : lien externe éventuel
 */

// Données ACF / WP
$miniature = get_field('image_projet');     // array ACF
$titre     = get_the_title();
$lien_wp   = get_permalink();
$lien_ext  = get_field('lien');             // si tu veux "Voir le site"
$group     = 'proj-' . get_the_ID();

// Construit le tableau des captures à partir de image_1..image_5
$captures = [];
for ($k = 1; $k <= 5; $k++) {
    $img = get_field("image_{$k}");
    if (is_array($img) && !empty($img['url'])) {
        $captures[] = $img;
    }
}

// Image de fond
$image_bg_url = $miniature['url'] ?? '';
$style_bg     = $image_bg_url ? " style=\"background-image:url('". esc_url( $image_bg_url ) ."')\"" : '';
?>
<article class="carte-projet"<?php echo $style_bg; ?>>
    <div class="overlay">
        <h3 class="titre-projet"><?php echo esc_html($titre); ?></h3>

        <div class="actions" style="display:flex; gap:10px; align-items:center;">
        <!-- Choisis l’un des deux liens ci-dessous -->
        <a href="<?php echo esc_url($lien_wp); ?>" class="projet-lien">Voir le projet</a>
        <?php if ($lien_ext) : ?>
            <a href="<?php echo esc_url($lien_ext); ?>" target="_blank" rel="noopener" class="projet-lien">Voir le site</a>
        <?php endif; ?>

        <?php if (!empty($captures)) : ?>
            <button
                type="button"
                class="projet-button js-open-gallery"
                data-lb-group="<?php echo esc_attr($group); ?>"
                aria-label="<?php echo esc_attr('Voir les captures du projet '.$titre); ?>">
                Aperçu
            </button>
        <?php endif; ?>
    </div>

    <!-- Debug temporaire à retirer quand OK -->
    <!-- <p style="color:#fff;font-weight:bold;">Captures: <?php echo count($captures); ?></p> -->
    </div>

    <?php if (!empty($captures)) : ?>
    <!-- Liste cachée pour la lightbox -->
    <ul class="captures-projet" data-lb-group="<?php echo esc_attr($group); ?>" hidden>
        <?php foreach ($captures as $i => $img) :
        $full  = esc_url($img['url']);
        $thumb = esc_url($img['sizes']['medium_large'] ?? ($img['sizes']['medium'] ?? $img['url']));
        ?>
        <li>
            <a
            href="<?php echo $full; ?>"
            class="js-lightbox-item"
            data-group="<?php echo esc_attr($group); ?>"
            data-index="<?php echo (int)$i; ?>"
            data-title="<?php echo esc_attr($titre); ?>"
            data-category="Capture">
            <img src="<?php echo $thumb; ?>" alt="">
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
</article>



