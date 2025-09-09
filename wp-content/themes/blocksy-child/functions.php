<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/* ============================================================
 * Child Theme Configurator (laisser tel quel)
 * ============================================================ */
if ( ! function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

if ( ! function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style(
            'chld_thm_cfg_child',
            trailingslashit( get_stylesheet_directory_uri() ) . 'style.css',
            array( 'ct-main-styles','ct-admin-frontend-styles','ct-page-title-styles' )
        );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );

/* ============================================================
 * Helpers
 * ============================================================ */

/** Version de fichier basée sur filemtime si possible, sinon version du thème. */
function vd_asset_version( $relative_path ) {
    $abs = trailingslashit( get_stylesheet_directory() ) . ltrim( $relative_path, '/\\' );
    if ( file_exists( $abs ) ) {
        $mtime = @filemtime( $abs );
        if ( $mtime ) return $mtime;
    }
    $theme = wp_get_theme();
    return $theme->get( 'Version' ) ?: '1.0.0';
}

/* ============================================================
 * Enqueue des assets du thème enfant
 * ============================================================ */
function vd_enqueue_child_assets() {

    // --- Lightbox UNIQUEMENT sur la page d'un projet
    if ( is_singular( 'projet' ) ) {

        // CSS lightbox
        $lb_css_rel = 'assets/css/portfolio-lightbox.css';
        $lb_css_abs = trailingslashit( get_stylesheet_directory() ) . $lb_css_rel;
        if ( file_exists( $lb_css_abs ) ) {
            wp_enqueue_style(
                'vd-portfolio-lightbox',
                get_stylesheet_directory_uri() . '/' . $lb_css_rel,
                array( 'chld_thm_cfg_child' ),
                vd_asset_version( $lb_css_rel )
            );
        }

        // JS lightbox (vanilla)
        $lb_js_rel = 'assets/js/portfolio-lightbox.js';
        $lb_js_abs = trailingslashit( get_stylesheet_directory() ) . $lb_js_rel;
        if ( file_exists( $lb_js_abs ) ) {
            wp_enqueue_script(
                'vd-portfolio-lightbox',
                get_stylesheet_directory_uri() . '/' . $lb_js_rel,
                array(),
                vd_asset_version( $lb_js_rel ),
                true
            );
        }
    }

    // --- JS global (si présent)
    $custom_js_rel = 'assets/js/custom.js';
    $custom_js_abs = trailingslashit( get_stylesheet_directory() ) . $custom_js_rel;
    if ( file_exists( $custom_js_abs ) ) {
        wp_enqueue_script(
            'vd-portfolio-custom',
            get_stylesheet_directory_uri() . '/' . $custom_js_rel,
            array(),
            vd_asset_version( $custom_js_rel ),
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'vd_enqueue_child_assets', 20 );









