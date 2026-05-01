<?php
/**
 * Plugin Name: Heads Up Mob
 * Description: Heads Up-style party game. Use [headsup_game] on any page, or pick the "Heads Up Fullscreen" page template to redirect to the installable PWA.
 * Version: 1.8.1
 * Author: Gareth Welton
 */

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'HEADSUP_MOB_TEMPLATE_KEY', 'headsup-mob/templates/page-headsup-fullscreen.php' );

/**
 * Shortcode: [headsup_game height="90vh"]
 */
function headsup_mob_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'height' => '90vh',
    ), $atts, 'headsup_game' );

    $url = plugins_url( 'assets/game.html', __FILE__ );
    $height = esc_attr( $atts['height'] );

    return sprintf(
        '<div class="headsup-mob-wrap" style="width:100%%;max-width:100%%;">
            <iframe src="%s"
                style="width:100%%;height:%s;border:0;display:block;border-radius:12px;background:#1a1a2e;"
                allow="fullscreen; accelerometer; gyroscope; autoplay"
                allowfullscreen></iframe>
        </div>',
        esc_url( $url ),
        $height
    );
}
add_shortcode( 'headsup_game', 'headsup_mob_shortcode' );

/**
 * Register the "Heads Up Fullscreen" page template option in the page editor.
 */
function headsup_mob_add_template( $templates ) {
    $templates[ HEADSUP_MOB_TEMPLATE_KEY ] = 'Heads Up Fullscreen';
    return $templates;
}
add_filter( 'theme_page_templates', 'headsup_mob_add_template' );

/**
 * When a page using our template is loaded, redirect to the game asset URL.
 * Done on `template_redirect` so headers haven't been sent yet — much more reliable
 * than redirecting from inside a template file.
 */
function headsup_mob_template_redirect() {
    if ( ! is_page() ) return;
    $selected = get_post_meta( get_queried_object_id(), '_wp_page_template', true );
    if ( HEADSUP_MOB_TEMPLATE_KEY !== $selected ) return;

    $game_url = plugins_url( 'assets/game.html', __FILE__ );
    wp_safe_redirect( $game_url, 302 );
    exit;
}
add_action( 'template_redirect', 'headsup_mob_template_redirect' );

/**
 * Fallback: if for any reason template_redirect didn't fire (e.g. another plugin
 * intercepts), make sure the template loader still finds our file rather than 404ing.
 */
function headsup_mob_load_template( $template ) {
    if ( ! is_page() ) return $template;
    $selected = get_post_meta( get_queried_object_id(), '_wp_page_template', true );
    if ( HEADSUP_MOB_TEMPLATE_KEY === $selected ) {
        $plugin_template = plugin_dir_path( __FILE__ ) . 'templates/page-headsup-fullscreen.php';
        if ( file_exists( $plugin_template ) ) return $plugin_template;
    }
    return $template;
}
add_filter( 'template_include', 'headsup_mob_load_template' );
