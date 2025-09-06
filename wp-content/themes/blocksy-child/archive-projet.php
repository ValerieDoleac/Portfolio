<?php
/**
 * Template personnalisé pour les archives des projets
 * (remplace le <h1> par un <h2>)
 */

get_header();
?>

<!-- Section hero personnalisée -->
<section class="hero-projets">
    <div class="container">
        <h2 class="titre-projets">Projets</h2>
    </div>
</section>

<!-- Section des projets -->
<div class="projets-page-wrapper">
    <?php if (have_posts()) : ?>
        <div class="grille-projets">
            <?php while (have_posts()) : the_post(); ?>
                <?php get_template_part('content', 'projet'); ?>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>


    <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>

