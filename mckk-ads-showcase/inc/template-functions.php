<?php
/**
 * Read-only presentation helpers.
 *
 * @package MCKK_ADS_Showcase
 */

/**
 * Resolve a published, unprotected existing page.
 *
 * @param string $path Existing page path.
 * @return WP_Post|null
 */
function mckk_ads_public_page( $path ) {
	$page = get_page_by_path( trim( $path, '/' ), OBJECT, 'page' );
	return $page && 'publish' === $page->post_status && ! $page->post_password ? $page : null;
}

/**
 * Resolve a public page or post without changing its original URL.
 *
 * @param string $path Existing content path.
 * @return WP_Post|null
 */
function mckk_ads_public_content( $path ) {
	$page = mckk_ads_public_page( $path );
	if ( $page ) {
		return $page;
	}
	$post = get_page_by_path( trim( $path, '/' ), OBJECT, 'post' );
	return $post && is_post_publicly_viewable( $post ) && ! $post->post_password ? $post : null;
}

/**
 * Resolve known page paths without fabricating missing content.
 *
 * @param string[] $paths Existing page paths.
 * @return WP_Post[]
 */
function mckk_ads_pages( $paths ) {
	$pages = array();
	foreach ( $paths as $path ) {
		$page = mckk_ads_public_content( $path );
		if ( $page ) {
			$pages[ $page->ID ] = $page;
		}
	}
	return array_values( $pages );
}

/**
 * Resolve brief-supplied learning references.
 *
 * @return WP_Post[]
 */
function mckk_ads_learning_pages() {
	return mckk_ads_pages( array( 'stem-ar', 'everyone-can-code-in-learning', 'visual-note-taking-using-ipad', 'koleq-podcast-with-garageband', 'garageband-mini-orchestra', 'mckk-apple-tech-leader', 'mckk-repository', 'showcase', 'house-rewards-programme' ) );
}

/**
 * Read curated existing public page records.
 *
 * @return WP_Post[]
 */
function mckk_ads_curated_pages() {
	$ids = mckk_ads_sanitize_ids( get_theme_mod( 'mckk_ads_showcase_ids', '' ) );
	if ( $ids ) {
		return get_posts(
			array(
				'post_type'        => array( 'page', 'post' ),
				'suppress_filters' => false,
				'post_status'      => 'publish',
				'has_password'     => false,
				'post__in'         => array_map( 'absint', explode( ',', $ids ) ),
				'orderby'          => 'post__in',
				'posts_per_page'   => 12,
			)
		);
	}
	return mckk_ads_pages( array( 'showcase', 'mckk-repository', 'visual-note-taking-using-ipad' ) );
}

/**
 * Render links to real existing content.
 *
 * @param WP_Post[] $pages Existing public pages.
 * @param bool      $showcase Whether to use showcase presentation.
 */
function mckk_ads_cards( $pages, $showcase = false ) {
	foreach ( $pages as $page ) {
		get_template_part(
			'template-parts/' . ( $showcase ? 'showcase-card' : 'content-card' ),
			null,
			array(
				'post_id' => $page->ID,
				'heading' => 'h3',
			)
		);
	}
}

/**
 * Read only deliberately authored excerpts.
 *
 * @param int $post_id Existing content ID.
 * @return string
 */
function mckk_ads_card_summary( $post_id ) {
	// Only deliberately authored excerpts. Do not execute shortcodes or invent summaries.
	$post = get_post( $post_id );
	return $post && ! $post->post_password ? wp_strip_all_tags( $post->post_excerpt ) : '';
}

/**
 * Render a discovery section only when content exists.
 *
 * @param string    $id Section heading identifier.
 * @param string    $title Translated interface title.
 * @param WP_Post[] $pages Existing public records.
 * @param bool      $showcase Whether to use showcase cards.
 */
function mckk_ads_section( $id, $title, $pages, $showcase = false ) {
	if ( ! $pages ) {
		return;
	}
	?>
	<section class="discovery-section wrap" aria-labelledby="<?php echo esc_attr( $id ); ?>">
		<div class="section-heading"><span class="eyebrow"><?php esc_html_e( 'Discover MCKK', 'mckk-ads-showcase' ); ?></span><h2 id="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $title ); ?></h2></div>
		<div class="card-grid<?php echo $showcase ? ' card-grid--showcase' : ''; ?>"><?php mckk_ads_cards( $pages, $showcase ); ?></div>
	</section>
	<?php
}

/**
 * Render the real publication date for posts.
 */
function mckk_ads_post_meta() {
	if ( 'post' === get_post_type() ) {
		echo '<p class="post-meta"><time datetime="' . esc_attr( get_the_date( DATE_W3C ) ) . '">' . esc_html( get_the_date() ) . '</time></p>';
	}
}

/**
 * Render pagination for the native main query.
 */
function mckk_ads_pagination() {
	the_posts_pagination(
		array(
			'mid_size'  => 1,
			'prev_text' => __( 'Previous', 'mckk-ads-showcase' ),
			'next_text' => __( 'Next', 'mckk-ads-showcase' ),
		)
	);
}

/** Render a decorative arrow without relying on device-specific symbol fonts. */
function mckk_ads_arrow() {
	echo '<svg aria-hidden="true" width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M6 18 18 6M6 6h12v12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
}
