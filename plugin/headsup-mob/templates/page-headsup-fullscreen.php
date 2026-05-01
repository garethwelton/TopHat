<?php
/**
 * Heads Up Fullscreen page template — fallback only.
 * Normally the `template_redirect` action in headsup-mob.php sends the user
 * straight to the game asset URL (so PWA install works). This template only
 * runs if that redirect was suppressed.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$game_url = plugins_url( 'assets/game.html', dirname( __FILE__ ) . '/headsup-mob.php' );

if ( ! headers_sent() ) {
    wp_safe_redirect( $game_url, 302 );
    exit;
}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="refresh" content="0;url=<?php echo esc_url( $game_url ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="theme-color" content="#1a1a2e">
<title><?php echo esc_html( get_the_title() ); ?></title>
<style>
  html, body { margin:0; padding:0; height:100%; background:#1a1a2e; color:#fff; font-family:-apple-system,sans-serif; display:flex; align-items:center; justify-content:center; text-align:center; }
  a { color:#f1c40f; }
</style>
</head>
<body>
<div>
  <p>Loading Heads Up Mob…</p>
  <p><a href="<?php echo esc_url( $game_url ); ?>">Tap here if not redirected</a></p>
</div>
</body>
</html>
