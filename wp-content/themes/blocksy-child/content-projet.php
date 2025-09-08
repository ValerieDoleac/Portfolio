<?php
/**
 * Template Part: Carte d'un projet pour l'archive
 * Affiche une carte projet + une liste cachée des captures pour la lightbox.
 */

// Données ACF / WP
$miniature = get_field('image_projet');           // Image principale du projet (array ACF)
$captures  = get_field('captures_projet');        // Galerie ACF (array d'images)
$titre     = get_the_title();
$lien      = get_permalink();
$group     = 'proj-' . get_the_ID();              // Identifiant de groupe pour la lightbox

// Image de fond
$image_bg_url = $miniature['url'] ?? '';
$style_bg     = $image_bg_url ? " style=\"background-image:url('". esc_url( $image_bg_url ) ."')\"" : '';
?>
<article class="carte-projet"<?php echo $style_bg; ?>>
    <div class="overlay">
    <h3 class="titre-projet"><?php echo esc_html( $titre ); ?></h3>

    <div class="actions" style="display:flex; gap:10px; align-items:center;">
        <a href="<?php echo esc_url( $lien ); ?>" class="projet-lien">Voir le projet</a>

        <?php if ( ! empty( $captures ) && is_array( $captures ) ) : ?>
        <button
            type="button"
            class="projet-button js-open-gallery"
            data-lb-group="<?php echo esc_attr( $group ); ?>"
            aria-label="<?php echo esc_attr( 'Voir les captures du projet ' . $titre ); ?>">
            Aperçu
        </button>
        <?php endif; ?>
    </div>
    </div>

    <?php if ( ! empty( $captures ) && is_array( $captures ) ) : ?>
    <!-- Liste cachée utilisée par le script de lightbox -->
    <ul class="captures-projet" data-lb-group="<?php echo esc_attr( $group ); ?>" hidden>
        <?php
        $i = 0;
        foreach ( $captures as $img ) :
        // Sécurise les tailles
        $full  = isset( $img['url'] ) ? esc_url( $img['url'] ) : '';
        $thumb = isset( $img['sizes']['medium_large'] ) ? esc_url( $img['sizes']['medium_large'] )
                : ( isset( $img['sizes']['medium'] ) ? esc_url( $img['sizes']['medium'] ) : $full );

        if ( ! $full ) { continue; }
        ?>
        <li>
            <a
                href="<?php echo $full; ?>"
                class="js-lightbox-item"
                data-group="<?php echo esc_attr( $group ); ?>"
                data-index="<?php echo (int) $i; ?>"
                data-title="<?php echo esc_attr( $titre ); ?>"
                data-category="Capture">
                <img src="<?php echo $thumb; ?>" alt="">
            </a>
        </li>
        <?php
        $i++;
        endforeach; ?>
    </ul>
    <?php endif; ?>
</article>


