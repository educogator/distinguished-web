<?php
/**
 * Native theme features; no database mutation on activation.
 *
 * @package MCKK_ADS_Showcase
 */

/**
 * Register native WordPress theme features.
 */
function mckk_ads_setup() {
	load_theme_textdomain( 'mckk-ads-showcase', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support(
		'custom-logo',
		array(
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
	add_editor_style( 'assets/css/editor.css' );
	register_nav_menus(
		array(
			'primary' => __( 'Primary navigation', 'mckk-ads-showcase' ),
			'footer'  => __( 'Footer navigation', 'mckk-ads-showcase' ),
		)
	);
}
add_action( 'after_setup_theme', 'mckk_ads_setup' );

/**
 * Declare a conservative default content width.
 */
function mckk_ads_content_width() {
	$GLOBALS['content_width'] = 800;
}
add_action( 'after_setup_theme', 'mckk_ads_content_width', 0 );
