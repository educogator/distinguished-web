<?php
/**
 * Full editor content plus non-destructive discovery.
 *
 * @package MCKK_ADS_Showcase
 */

get_header();
get_template_part( 'template-parts/hero' );
if ( 'page' === get_option( 'show_on_front' ) ) :
	while ( have_posts() ) :
		the_post();
		?>
		<section class="homepage-story wrap" aria-labelledby="homepage-story-title"><div class="section-heading"><span class="eyebrow"><?php esc_html_e( 'Our story', 'mckk-ads-showcase' ); ?></span><h2 id="homepage-story-title"><?php echo esc_html( get_the_title() ? get_the_title() : __( 'Our story', 'mckk-ads-showcase' ) ); ?></h2></div><div class="entry-content">
		<?php
		the_content();
		wp_link_pages();
		?>
		</div><?php edit_post_link( __( 'Edit page', 'mckk-ads-showcase' ), '<p class="edit-link">', '</p>' ); ?></section>
		<?php
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	endwhile;
endif;
mckk_ads_section( 'explore-learning', __( 'Explore learning', 'mckk-ads-showcase' ), mckk_ads_learning_pages() );
mckk_ads_section( 'student-work', __( 'Student digital showcase', 'mckk-ads-showcase' ), mckk_ads_curated_pages(), true );
mckk_ads_section( 'teaching-environment', __( 'Teaching & environment', 'mckk-ads-showcase' ), mckk_ads_pages( array( 'teaching', 'environment' ) ) );
if ( 'posts' === get_option( 'show_on_front' ) ) {
	get_template_part( 'template-parts/post-list' );
} else {
	$mckk_ads_posts = new WP_Query(
		array(
			'post_type'           => 'post',
			'posts_per_page'      => 3,
			'post_status'         => 'publish',
			'has_password'        => false,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		)
	);
	if ( $mckk_ads_posts->have_posts() ) {
		mckk_ads_section( 'journal-title', __( 'From the journal', 'mckk-ads-showcase' ), $mckk_ads_posts->posts );
	}
}
get_footer();
