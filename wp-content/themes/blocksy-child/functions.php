<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style(
            'chld_thm_cfg_child',
            trailingslashit( get_stylesheet_directory_uri() ) . 'style.css',
            array( 'ct-main-styles','ct-admin-frontend-styles','ct-page-title-styles' )
        );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );

// END ENQUEUE PARENT ACTION

/**
 * Enqueue des scripts/styles du thème enfant
 */
add_action('wp_enqueue_scripts', function () {
    // Charger la nouvelle lightbox uniquement sur portfolio/projets
    $need_lb = is_post_type_archive('projet') || is_singular('projet') || is_page('portfolio');

    if ($need_lb) {
        // CSS de la nouvelle lightbox
        wp_enqueue_style(
            'portfolio-lightbox',
            get_stylesheet_directory_uri() . '/assets/css/portfolio-lightbox.css',
            array('chld_thm_cfg_child'),
            filemtime(get_stylesheet_directory() . '/assets/css/portfolio-lightbox.css')
        );

        // JS de la nouvelle lightbox
        wp_enqueue_script(
            'portfolio-lightbox',
            get_stylesheet_directory_uri() . '/assets/js/portfolio-lightbox.js',
            array(), // ajoute 'jquery' si nécessaire
            filemtime(get_stylesheet_directory() . '/assets/js/portfolio-lightbox.js'),
            true
        );
    }

    // Ton JS global
    wp_enqueue_script(
        'portfolio-custom',
        get_stylesheet_directory_uri() . '/assets/js/custom.js',
        array(),
        filemtime(get_stylesheet_directory() . '/assets/js/custom.js'),
        true
    );
}, 20);








