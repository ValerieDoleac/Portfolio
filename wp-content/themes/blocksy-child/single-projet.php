<?php get_header();
?>

<main class="single-projet">
    <?php
    if (have_posts()) : while (have_posts()) : the_post();
        // Champs ACF
        $contexte = get_field('contexte');
        $technologies = get_field('technologies');
        $lien = get_field('lien');
        $miniature = get_field('image_projet');
        $images = [
            get_field('image_1'),
            get_field('image_2'),
            get_field('image_3'),
            get_field('image_4'),
            get_field('image_5'),
        ];
    ?>

    <section class="projet-content">
        <h2><?php the_title(); ?></h2>

        <?php if ($miniature) : ?>
            <div class="miniature">
                <img src="<?= esc_url($miniature['url']); ?>" alt="<?= esc_attr($miniature['alt']); ?>">
            </div>
        <?php endif; ?>

        <p><strong>Contexte :</strong> <?= esc_html($contexte); ?></p>
        <p><strong>Technologies :</strong> <?= esc_html($technologies); ?></p>

        <?php if ($lien) : ?>
            <p><a href="<?= esc_url($lien); ?>" target="_blank" class="projet-lien">Voir le site</a></p>
        <?php endif; ?>

        <div class="galerie">
            <?php foreach ($images as $image) :
                if ($image) :
                    $width = $image['width'];
                    $height = $image['height'];
                    $orientation = ($height > $width) ? 'portrait' : 'paysage';
            ?>
                <a href="<?= esc_url($image['url']); ?>" class="lightbox <?= $orientation; ?>">
                    <img src="<?= esc_url($image['sizes']['medium']); ?>" alt="<?= esc_attr($image['alt']); ?>">
                </a>
            <?php endif;
            endforeach; ?>
        </div>


        <div class="retour-projets">
            <a href="<?php echo get_post_type_archive_link('projet'); ?>" class="btn-retour">
                Retour aux projets
            </a>
        </div>
    </section>

    <?php endwhile; endif; ?>
</main>





<?php get_footer(); ?>
