<?php
/**
 * Archive des Projets (CPT: projet)
 */

get_header(); ?>

<!-- Section hero -->
<section class="hero-projets">
    <div class="container">
        <h2 class="titre-projets">Projets</h2>
    </div>
</section>

<main id="primary" class="projets-page-wrapper container">

    <?php if ( have_posts() ) : ?>
    <div class="grille-projets">
        <?php
        while ( have_posts() ) :
            the_post();
            get_template_part( 'content', 'projet' ); // ta carte projet (sans overlay)
        endwhile;
        ?>
    </div>

    <?php
    // Pagination si nécessaire (selon ton thème)
    the_posts_pagination( array(
        'mid_size'  => 2,
        'prev_text' => __('← Précédent', 'textdomain'),
        'next_text' => __('Suivant →', 'textdomain'),
    ) );
    ?>

    <?php else : ?>
        <p><?php _e( 'Aucun projet pour le moment.', 'textdomain' ); ?></p>
    <?php endif; ?>

    <?php get_sidebar(); ?>

</main>

<!-- Lightbox (UNE SEULE FOIS sur la page) -->
<div id="lightbox" class="lightbox-overlay" aria-hidden="true" role="dialog" aria-label="Galerie de projets">
    <button class="lightbox-close" aria-label="Fermer">×</button>
    <button class="lightbox-prev" aria-label="Image précédente">←</button>

    <div class="lightbox-image-wrapper" role="document">
        <img id="lightbox-img" src="" alt="">
        <div class="lightbox-caption">
            <span class="lightbox-title"></span>
            <span class="lightbox-category"></span>
        </div>
    </div>

    <button class="lightbox-next" aria-label="Image suivante">→</button>
</div>


<?php get_footer(); ?>


