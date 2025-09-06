<?php
/**
 * Template Part: Carte d'un projet pour l'archive
 */

// Données
$miniature = get_field('image_projet');
$captures  = get_field('captures_projet'); // ACF "Galerie"
$titre     = get_the_title();
$lien      = get_permalink();
$group     = 'proj-' . get_the_ID();

// Image de fond par défaut
$image_bg = $miniature ? esc_url($miniature['url']) : 'URL_PAR_DEFAUT';
?>
<article class="carte-projet" style="background-image: url('<?php echo $image_bg; ?>')">
    <div class="overlay">
    <h3 class="titre-projet"><?php echo esc_html($titre); ?></h3>

    <div class="actions" style="display:flex; gap:10px; align-items:center;">
        <a href="<?php echo esc_url($lien); ?>" class="projet-button">Voir le projet</a>

        <?php if (!empty($captures) && is_array($captures)) : ?>
        <button type="button"
                class="projet-button js-open-gallery"
                aria-label="Voir les captures du projet <?php echo esc_attr($titre); ?>">
            Aperçu
        </button>
        <?php endif; ?>
    </div>
    </div>

    <?php if (!empty($captures) && is_array($captures)) : ?>
    <ul class="captures-projet" hidden>
        <?php foreach ($captures as $img) :
        $full  = esc_url($img['url']);
        $thumb = esc_url($img['sizes']['medium'] ?? $img['url']);
        ?>
        <li>
            <a href="<?php echo $full; ?>"
                class="js-lightbox"
                data-lb-group="<?php echo esc_attr($group); ?>"
                data-title="<?php echo esc_attr($titre); ?>"
                data-category="Capture">
            <img src="<?php echo $thumb; ?>" alt="">
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
</article>

