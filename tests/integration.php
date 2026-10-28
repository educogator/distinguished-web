<?php
/** Meaningful local-only theme integration and content-preservation regression checks. */
if ( ! defined( 'WP_CLI' ) || ! WP_CLI || 'local' !== wp_get_environment_type() || '127.0.0.1' !== wp_parse_url( home_url(), PHP_URL_HOST ) ) {
	throw new RuntimeException( 'Integration checks require the isolated localhost fixture.' );
}
$passed = 0;
$assert = static function ( $condition, $label ) use ( &$passed ) {
	if ( ! $condition ) { throw new RuntimeException( $label ); }
	++$passed;
	WP_CLI::log( 'PASS ' . $label );
};
$snapshot = static function () {
	global $wpdb;
	$posts = $wpdb->get_results( "SELECT * FROM {$wpdb->posts} ORDER BY ID", ARRAY_A );
	$meta = $wpdb->get_results( "SELECT * FROM {$wpdb->postmeta} ORDER BY meta_id", ARRAY_A );
	$urls = array();
	foreach ( get_posts( array( 'post_type' => array( 'page', 'post', 'attachment' ), 'post_status' => array( 'publish', 'inherit', 'private', 'draft' ), 'numberposts' => -1 ) ) as $post ) {
		$urls[ $post->ID ] = get_permalink( $post );
	}
	ksort( $urls );
	return array( 'posts' => hash( 'sha256', serialize( $posts ) ), 'meta' => hash( 'sha256', serialize( $meta ) ), 'urls' => $urls, 'reading' => array( get_option( 'show_on_front' ), get_option( 'page_on_front' ), get_option( 'page_for_posts' ) ), 'permalink' => get_option( 'permalink_structure' ) );
};
$initial = $snapshot();
switch_theme( 'twentytwenty' );
switch_theme( 'mckk-ads-showcase' );
$assert( $initial === $snapshot(), 'Theme switching preserves all fixture post rows, metadata, permalinks and Reading settings' );
$assert( null === mckk_ads_public_page( 'qa-nonexistent-page' ), 'Missing reference produces no fabricated page' );
$assert( null === mckk_ads_public_page( 'qa-protected' ), 'Protected page excluded from discovery' );
$draft_id = wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'draft', 'post_title' => 'QA draft', 'post_name' => 'qa-draft' ) );
$private_id = wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'private', 'post_title' => 'QA private', 'post_name' => 'qa-private' ) );
try {
	$assert( null === mckk_ads_public_page( 'qa-draft' ) && null === mckk_ads_public_page( 'qa-private' ), 'Draft and private pages excluded from discovery' );
	$previous_ids = get_theme_mod( 'mckk_ads_showcase_ids', '' );
	$learning = get_page_by_path( 'learning' );
	set_theme_mod( 'mckk_ads_showcase_ids', $draft_id . ',' . $private_id . ',' . get_page_by_path( 'qa-protected' )->ID . ',' . $learning->ID );
	$assert( array( $learning->ID ) === wp_list_pluck( mckk_ads_curated_pages(), 'ID' ), 'Curated IDs filter unpublished and protected records' );
	set_theme_mod( 'mckk_ads_showcase_ids', $previous_ids );
} finally {
	wp_delete_post( $draft_id, true );
	wp_delete_post( $private_id, true );
}
$locations = get_theme_mod( 'nav_menu_locations', array() );
set_theme_mod( 'nav_menu_locations', array() );
$fallback_args = mckk_ads_menu_args( array( 'theme_location' => 'primary' ) );
$assert( ! empty( $fallback_args['menu'] ) && is_nav_menu( $fallback_args['menu'] ), 'Twenty Twenty primary menu reused read-only when unassigned' );
set_theme_mod( 'mckk_ads_reuse_menu', false );
$fallback_args = mckk_ads_menu_args( array( 'theme_location' => 'primary' ) );
$assert( ! isset( $fallback_args['menu'] ), 'Prior-theme menu reuse can be disabled' );
ob_start();
mckk_ads_fallback_menu();
$fallback = ob_get_clean();
$assert( str_contains( $fallback, get_permalink( get_page_by_path( 'environment' ) ) ) && str_contains( $fallback, get_permalink( get_page_by_path( 'environment/qa-environment-child' ) ) ), 'Native fallback preserves actual page hierarchy and URLs' );
set_theme_mod( 'nav_menu_locations', $locations );
remove_theme_mod( 'mckk_ads_reuse_menu' );
$theme = wp_get_theme();
$assert( ! $theme->errors() && MCKK_ADS_VERSION === $theme->get( 'Version' ) && '' === $theme->get( 'Template' ), 'WordPress recognizes standalone release with no parent' );
$assert( has_shortcode( get_page_by_path( 'visual-note-taking-using-ipad' )->post_content, 'mckk_qa_shortcode' ), 'Original shortcode markup remains in the editor database' );
$assert( $initial['posts'] === $snapshot()['posts'] && $initial['meta'] === $snapshot()['meta'], 'Fixture checks leave original posts and metadata unchanged' );
WP_CLI::success( $passed . ' integration checks passed.' );
