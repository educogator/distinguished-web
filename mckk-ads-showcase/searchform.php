<?php
/**
 * Native WordPress search.
 *
 * @package MCKK_ADS_Showcase
 */

$mckk_ads_search_id = wp_unique_id( 'site-search-' );
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>"><label for="<?php echo esc_attr( $mckk_ads_search_id ); ?>"><?php esc_html_e( 'Search pages and posts', 'mckk-ads-showcase' ); ?></label><div class="search-fields"><input type="search" id="<?php echo esc_attr( $mckk_ads_search_id ); ?>" name="s" value="<?php echo get_search_query(); ?>" placeholder="<?php esc_attr_e( 'What would you like to explore?', 'mckk-ads-showcase' ); ?>" required><button type="submit"><?php esc_html_e( 'Search', 'mckk-ads-showcase' ); ?></button></div></form>
