<?php
/**
 * Native results include pages/posts according to WordPress and installed plugins.
 *
 * @package MCKK_ADS_Showcase
 */

get_header();
get_template_part( 'template-parts/breadcrumbs' );
?>
<section class="wrap listing-section"><header class="section-heading"><p class="eyebrow"><?php esc_html_e( 'Discover', 'mckk-ads-showcase' ); ?></p><h1><?php esc_html_e( 'Search', 'mckk-ads-showcase' ); ?></h1><?php get_search_form(); ?></header>
<?php
if ( have_posts() ) :
	?>
	<p class="results-summary">
	<?php
	/* translators: %s: Visitor's search query. */
	printf( esc_html__( 'Results for “%s”', 'mckk-ads-showcase' ), esc_html( get_search_query() ) );
	?>
	</p><div class="card-grid">
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
	<div class="empty-state"><h2><?php esc_html_e( 'No matching content', 'mckk-ads-showcase' ); ?></h2><p><?php esc_html_e( 'Try a different word or explore the navigation above.', 'mckk-ads-showcase' ); ?></p></div><?php endif; ?></section>
<?php get_footer(); ?>
