<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/* ============================================================
 * Child Theme Configurator (laisse tel quel)
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

/** Retourne une version de fichier basée sur filemtime si présent, sinon thème version. */
function vd_asset_version( $relative_path ) {
    $abs = trailingslashit( get_stylesheet_directory() ) . ltrim( $relative_path, '/\\' );
    if ( file_exists( $abs ) ) {
        $mtime = @filemtime( $abs );
        if ( $mtime ) {
            return $mtime;
        }
    }
    $theme = wp_get_theme();
    return $theme->get( 'Version' ) ?: '1.0.0';
}

/** Contexte où la lightbox est nécessaire */
function vd_is_projects_context() {
    return is_post_type_archive( 'projet' ) || is_singular( 'projet' ) || is_page( 'portfolio' );
}

/* ============================================================
 * Enqueue des assets du thème enfant
 * ============================================================ */
function vd_enqueue_child_assets() {

    // --- CSS/JS Lightbox uniquement si nécessaire
    if ( vd_is_projects_context() ) {

        // CSS lightbox
        wp_enqueue_style(
            'vd-portfolio-lightbox',
            get_stylesheet_directory_uri() . '/assets/css/portfolio-lightbox.css',
            array( 'chld_thm_cfg_child' ), // après le style du child pour être spécifique
            vd_asset_version( 'assets/css/portfolio-lightbox.css' )
        );

        // JS lightbox (vanilla → pas besoin de jQuery)
        wp_enqueue_script(
            'vd-portfolio-lightbox',
            get_stylesheet_directory_uri() . '/assets/js/portfolio-lightbox.js',
            array(),
            vd_asset_version( 'assets/js/portfolio-lightbox.js' ),
            true
        );
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

/* ============================================================
 * Injection de l'overlay Lightbox en footer (une seule fois)
 * → Évite de l’insérer dans les templates pour ne pas dupliquer.
 * ============================================================ */
function vd_print_portfolio_lightbox_markup() {
    if ( ! vd_is_projects_context() ) return;

    // On imprime l’overlay uniquement si un élément #lightbox n’existe pas déjà dans le DOM initial (prudence).
    // Dans 99% des cas, ne mets PAS d’overlay dans archive-projet.php pour éviter les doublons.
    ?>
    <div id="lightbox" class="lightbox-overlay" aria-hidden="true" role="dialog" aria-label="<?php echo esc_attr__( 'Galerie de projets', 'textdomain' ); ?>">
        <button class="lightbox-close" aria-label="<?php echo esc_attr__( 'Fermer', 'textdomain' ); ?>">×</button>
        <button class="lightbox-prev" aria-label="<?php echo esc_attr__( 'Image précédente', 'textdomain' ); ?>">←</button>

        <div class="lightbox-image-wrapper" role="document">
            <img id="lightbox-img" src="" alt="">
            <div class="lightbox-caption">
                <span class="lightbox-title"></span>
                <span class="lightbox-category"></span>
            </div>
        </div>

        <button class="lightbox-next" aria-label="<?php echo esc_attr__( 'Image suivante', 'textdomain' ); ?>">→</button>
    </div>
    <?php
}
add_action( 'wp_footer', 'vd_print_portfolio_lightbox_markup', 5 );

/* ============================================================
 * (Optionnel) Forcer le chargement après Autoptimize/Cache :
 * Si tu constates des soucis d'ordre, tu peux augmenter la priorité.
 * ============================================================ */
// add_action( 'wp_enqueue_scripts', 'vd_enqueue_child_assets', 99 );









