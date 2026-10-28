<?php
/**
 * Native post/attachment rendering.
 *
 * @package MCKK_ADS_Showcase
 */

get_header();
get_template_part( 'template-parts/breadcrumbs' );
while ( have_posts() ) :
	the_post();
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'singular-page' ); ?>><header class="entry-header wrap"><?php mckk_ads_post_meta(); ?><h1><?php the_title(); ?></h1></header>
	<?php
	if ( has_post_thumbnail() && ! post_password_required() ) :
		?>
		<figure class="featured-media wrap"><?php the_post_thumbnail( 'full' ); ?>
		<?php
		if ( get_the_post_thumbnail_caption() ) :
			?>
		<figcaption><?php echo esc_html( get_the_post_thumbnail_caption() ); ?></figcaption><?php endif; ?></figure><?php endif; ?>
	<div class="entry-content wrap">
	<?php
	the_content();
	wp_link_pages();
	?>
	</div><div class="wrap"><?php edit_post_link( __( 'Edit post', 'mckk-ads-showcase' ), '<p class="edit-link">', '</p>' ); ?></div></article>
	<div class="wrap post-navigation-wrap">
	<?php
	the_post_navigation(
		array(
			'prev_text' => __( 'Previous: %title', 'mckk-ads-showcase' ),
			'next_text' => __( 'Next: %title', 'mckk-ads-showcase' ),
		)
	);
	?>
											</div>
	<?php
	if ( ! post_password_required() ) {
		get_template_part( 'template-parts/related-content' ); }
	if ( comments_open() || get_comments_number() ) {
		comments_template(); }
endwhile;
get_footer();
