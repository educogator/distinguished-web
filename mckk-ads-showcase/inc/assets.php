<?php
/**
 * Small, compiled assets; no build process in production.
 *
 * @package MCKK_ADS_Showcase
 */

/**
 * Enqueue small local frontend assets.
 */
function mckk_ads_assets() {
	wp_enqueue_style( 'mckk-ads-main', get_theme_file_uri( '/assets/css/main.css' ), array(), MCKK_ADS_VERSION );
	$accent = sanitize_hex_color( get_theme_mod( 'mckk_ads_accent', '#A51D2D' ) );
	if ( $accent ) {
		// The accent is decorative. Text and focus colors use independently tested tokens.
		wp_add_inline_style( 'mckk-ads-main', ':root{--mckk-accent:' . $accent . ';}' );
	}
	wp_enqueue_script(
		'mckk-ads-main',
		get_theme_file_uri( '/assets/js/main.js' ),
		array(),
		MCKK_ADS_VERSION,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
	wp_localize_script(
		'mckk-ads-main',
		'mckkAds',
		array(
			'expand'   => __( 'Toggle submenu for', 'mckk-ads-showcase' ),
			'close'    => __( 'Close image', 'mckk-ads-showcase' ),
			'enlarge'  => __( 'Enlarge image', 'mckk-ads-showcase' ),
			'external' => __( 'Open embedded resource', 'mckk-ads-showcase' ),
			'original' => __( 'Open original image', 'mckk-ads-showcase' ),
			'lightbox' => (bool) get_theme_mod( 'mckk_ads_lightbox', true ),
		)
	);
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'mckk_ads_assets' );

/** Reserve the enhanced mobile header layout before the first paint, with fail-open recovery. */
function mckk_ads_navigation_boot() {
	?>
	<script>document.documentElement.classList.add('mckk-pending');window.setTimeout(function(){document.documentElement.classList.remove('mckk-pending');},3000);</script>
	<?php
}
add_action( 'wp_head', 'mckk_ads_navigation_boot', 0 );
