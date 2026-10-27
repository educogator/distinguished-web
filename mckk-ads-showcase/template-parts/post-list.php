<?php
/**
 * Native query loop.
 *
 * @package MCKK_ADS_Showcase
 */

$mckk_ads_listing_title = get_the_title( get_option( 'page_for_posts' ) );
$mckk_ads_heading       = is_front_page() ? 'h2' : 'h1';
?>
<section class="wrap listing-section" aria-labelledby="listing-title"><div class="section-heading"><<?php echo tag_escape( $mckk_ads_heading ); ?> id="listing-title">
<?php
if ( is_front_page() ) {
	esc_html_e( 'From the journal', 'mckk-ads-showcase' );
} elseif ( is_archive() ) {
	the_archive_title();
} else {
	echo esc_html( $mckk_ads_listing_title ? $mckk_ads_listing_title : __( 'Journal', 'mckk-ads-showcase' ) ); }
?>
</<?php echo tag_escape( $mckk_ads_heading ); ?>>
<?php
if ( is_archive() ) {
	the_archive_description( '<div class="archive-description">', '</div>' ); }
?>
</div>
<?php
if ( have_posts() ) :
	?>
	<div class="card-grid">
	<?php
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/content-card' );
endwhile;
	?>
</div>
	<?php
	mckk_ads_pagination(); else :
		?>
	<p><?php esc_html_e( 'There is no published content to show here yet.', 'mckk-ads-showcase' ); ?></p>
		<?php
		get_search_form();
endif;
	?>
</section>
