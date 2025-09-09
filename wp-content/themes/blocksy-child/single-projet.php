<?php
/**
 * Template: Single Projet
 */
get_header();
?>

<main class="single-projet">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post();

    // Champs ACF
    $contexte    = get_field('contexte');
    $technos     = get_field('technologies');
    $lien_site   = get_field('lien');             // URL externe éventuelle
    $miniature   = get_field('image_projet');     // Image principale (array)

    // Construit la liste des captures à partir des champs image_1..image_5
    $captures = [];
    for ($k = 1; $k <= 5; $k++) {
        $img = get_field("image_{$k}");
        if ( is_array($img) && ! empty($img['url']) ) {
            $captures[] = $img;
        }
    }
    $has_gallery = ! empty($captures);
    $titre_page  = get_the_title();

?>
    <section class="projet-content container">
        <h1 class="projet-titre"><?php echo esc_html($titre_page); ?></h1>

        <?php if ( $miniature && ! empty($miniature['url']) ) : ?>
        <figure class="projet-miniature">
            <img src="<?php echo esc_url($miniature['url']); ?>"
                alt="<?php echo esc_attr($miniature['alt'] ?: $titre_page); ?>">
        </figure>
        <?php endif; ?>

        <?php if ( $contexte ) : ?>
            <p><strong>Contexte :</strong> <?php echo esc_html($contexte); ?></p>
        <?php endif; ?>

        <?php if ( $technos ) : ?>
            <p><strong>Technologies :</strong> <?php echo esc_html($technos); ?></p>
        <?php endif; ?>

        <?php if ( $lien_site ) : ?>
            <p>
                <a class="projet-lien" href="<?php echo esc_url($lien_site); ?>" target="_blank" rel="noopener">
                    Voir le site
                </a>
            </p>
        <?php endif; ?>

        <?php if ( $has_gallery ) : ?>
        <!-- Galerie de 5 vignettes cliquables -->
        <section class="single-projet-galerie">
            <ul class="galerie-projet">
                <?php foreach ( $captures as $i => $img ) :
                    $full   = esc_url($img['url']); // plein format
                    $thumb  = esc_url($img['sizes']['medium_large'] ?? ($img['sizes']['medium'] ?? $img['url']));
                    $alt    = esc_attr($img['alt'] ?: $titre_page);
                    $w      = isset($img['width'], $img['height']) ? (int)$img['width'] : 0;
                    $h      = isset($img['height']) ? (int)$img['height'] : 0;
                    $orien  = ($h > $w && $w) ? 'portrait' : 'paysage';
                ?>
                <li>
                    <a href="<?php echo $full; ?>"
                        class="js-lightbox-item <?php echo $orien; ?>"
                        data-group="proj-<?php echo get_the_ID(); ?>"
                        data-index="<?php echo $i; ?>"
                        data-title="<?php echo $alt; ?>"
                        data-category="Capture">
                        <img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>">
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </section>
        <?php endif; ?>
    </section>

    <!-- Overlay Lightbox (une seule fois sur la page) -->
    <div id="lightbox" class="lightbox-overlay" aria-hidden="true" role="dialog" aria-label="<?php esc_attr_e('Galerie du projet','textdomain'); ?>">
        <button class="lightbox-close" aria-label="<?php esc_attr_e('Fermer','textdomain'); ?>">×</button>
        <button class="lightbox-prev"  aria-label="<?php esc_attr_e('Image précédente','textdomain'); ?>">←</button>

    <div class="lightbox-image-wrapper" role="document">
        <img id="lightbox-img" src="" alt="">
        <div class="lightbox-caption">
            <span class="lightbox-title"></span>
            <span class="lightbox-category"></span>
        </div>
    </div>

    <button class="lightbox-next"  aria-label="<?php esc_attr_e('Image suivante','textdomain'); ?>">→</button>
    </div>

<?php endwhile; endif; ?>
</main>

<?php
get_footer();