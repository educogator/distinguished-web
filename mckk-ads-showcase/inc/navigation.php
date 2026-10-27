<?php
/**
 * Reuse existing WordPress menu data and page hierarchy.
 *
 * @package MCKK_ADS_Showcase
 */

/**
 * Reuse a previous primary menu without changing its stored assignment.
 *
 * @param array $args WordPress menu arguments.
 * @return array
 */
function mckk_ads_menu_args( $args ) {
	if ( 'primary' !== ( $args['theme_location'] ?? '' ) || has_nav_menu( 'primary' ) ) {
		return $args;
	}
	if ( get_theme_mod( 'mckk_ads_reuse_menu', true ) ) {
		$previous = get_option( 'theme_mods_twentytwenty', array() );
		$menu_id  = absint( $previous['nav_menu_locations']['primary'] ?? 0 );
		if ( $menu_id && is_nav_menu( $menu_id ) ) {
			$args['menu'] = $menu_id;
		}
	}
	return $args;
}
add_filter( 'wp_nav_menu_args', 'mckk_ads_menu_args' );

/**
 * Render actual published pages when no menu is assigned.
 */
function mckk_ads_fallback_menu() {
	echo '<ul id="primary-menu" class="menu"><li><a href="' . esc_url( home_url( '/' ) ) . '"' . ( is_front_page() ? ' aria-current="page"' : '' ) . '>' . esc_html__( 'Home', 'mckk-ads-showcase' ) . '</a></li>';
	wp_list_pages(
		array(
			'title_li' => '',
			'depth'    => 0,
			'exclude'  => absint( get_option( 'page_on_front' ) ),
		)
	);
	echo '</ul>';
}
