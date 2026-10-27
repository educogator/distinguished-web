<?php
/**
 * Original hierarchy, native permalinks.
 *
 * @package MCKK_ADS_Showcase
 */

if ( is_front_page() ) {
	return; }
?>
<nav class="breadcrumbs wrap" aria-label="<?php esc_attr_e( 'Breadcrumb', 'mckk-ads-showcase' ); ?>"><ol><li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'mckk-ads-showcase' ); ?></a></li>
<?php
if ( is_page() ) :
	foreach ( array_reverse( get_post_ancestors( get_queried_object_id() ) ) as $mckk_ads_ancestor ) :
		?>
<li><a href="<?php echo esc_url( get_permalink( $mckk_ads_ancestor ) ); ?>"><?php echo esc_html( get_the_title( $mckk_ads_ancestor ) ); ?></a></li>
		<?php
	endforeach;
endif;
?>
<li><span aria-current="page">
<?php
if ( is_singular() ) {
	the_title();
} elseif ( is_search() ) {
	esc_html_e( 'Search', 'mckk-ads-showcase' );
} elseif ( is_404() ) {
	esc_html_e( 'Page not found', 'mckk-ads-showcase' );
} elseif ( is_home() ) {
	esc_html_e( 'Journal', 'mckk-ads-showcase' );
} else {
	echo esc_html( wp_strip_all_tags( get_the_archive_title() ) ); }
?>
</span></li></ol></nav>
