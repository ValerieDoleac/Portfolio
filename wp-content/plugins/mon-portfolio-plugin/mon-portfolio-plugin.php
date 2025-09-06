<?php
/**
 * Plugin Name: Mon Portfolio Plugin
 * Description: Plugin personnalisé pour gérer les projets de mon portfolio.
 * Version: 1.0
 * Author: Valérie Doléac
 */

 // Sécurité
if (!defined('ABSPATH')) {
    exit;
}

 // CPT Projets
function mpp_register_projets_post_type() {
    $labels = array(
        'name' => 'Projets',
        'singular_name' => 'Projet',
        'menu_name' => 'Projets',
        'add_new' => 'Ajouter un projet',
        'add_new_item' => 'Ajouter un nouveau projet',
        'edit_item' => 'Modifier le projet',
        'new_item' => 'Nouveau projet',
        'view_item' => 'Voir le projet',
        'all_items' => 'Tous les projets',
    );

    $args = array(
        'label' => 'Projets',
        'labels' => $labels,
        'public' => true,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => array('title', 'editor', 'thumbnail'),
        'has_archive' => true,
        'rewrite' => array('slug' => 'projets'),
        'show_in_rest' => true,
    );

    register_post_type('projet', $args);
}
add_action('init', 'mpp_register_projets_post_type');
