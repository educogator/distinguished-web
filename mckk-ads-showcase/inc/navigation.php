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

/**
 * Read related public content from the existing menu when pages have no database parent.
 *
 * @param int $post_id Current record ID.
 * @return WP_Post[]
 */
function mckk_ads_menu_related( $post_id ) {
	$locations = get_nav_menu_locations();
	$menu_id   = absint( $locations['primary'] ?? 0 );
	if ( ! $menu_id ) {
		$args    = mckk_ads_menu_args( array( 'theme_location' => 'primary' ) );
		$menu_id = absint( $args['menu'] ?? 0 );
	}
	$items   = $menu_id ? wp_get_nav_menu_items( $menu_id ) : array();
	$items   = $items ? $items : array();
	$current = null;
	foreach ( $items as $item ) {
		if ( absint( $item->object_id ) === $post_id && 'post_type' === $item->type ) {
			$current = $item;
			break;
		}
	}
	if ( ! $current ) {
		return array();
	}
	$children   = array_filter(
		$items,
		static function ( $item ) use ( $current ) {
			return absint( $item->menu_item_parent ) === $current->ID;
		}
	);
	$candidates = $children ? $children : array_filter(
		$items,
		static function ( $item ) use ( $current ) {
			return $item->menu_item_parent === $current->menu_item_parent;
		}
	);
	$related    = array();
	foreach ( $candidates as $item ) {
		$post = 'post_type' === $item->type ? get_post( $item->object_id ) : null;
		if ( $post && $post->ID !== $post_id && is_post_publicly_viewable( $post ) && ! $post->post_password ) {
			$related[ $post->ID ] = $post;
		}
	}
	return array_slice( array_values( $related ), 0, 12 );
}
