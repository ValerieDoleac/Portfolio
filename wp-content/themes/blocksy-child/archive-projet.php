<?php
/**
 * Archive des Projets (CPT: projet)
 */

get_header(); ?>


<!-- Section hero -->
<section class="hero-projets"
    data-bg="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/hero-projets-1920.webp"
    data-bg-fallback="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/hero-projets-1920.jpg">
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
    // Pagination
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


<?php get_footer(); ?>


