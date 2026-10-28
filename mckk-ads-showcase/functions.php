<?php
/**
 * Theme bootstrap.
 *
 * @package MCKK_ADS_Showcase
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
define( 'MCKK_ADS_VERSION', '1.1.0' );
foreach ( array( 'theme-setup', 'assets', 'navigation', 'template-functions', 'media', 'customizer' ) as $mckk_ads_module ) {
	require_once get_template_directory() . '/inc/' . $mckk_ads_module . '.php';
}
