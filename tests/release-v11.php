<?php
/** Local regressions for faults discovered in the public v1 installation. */
if ( ! defined( 'WP_CLI' ) || ! WP_CLI || 'local' !== wp_get_environment_type() || '127.0.0.1' !== wp_parse_url( home_url(), PHP_URL_HOST ) ) {
	throw new RuntimeException( 'Local fixture only.' );
}
$created = array();
$mods = get_theme_mods();
$passed = 0;
$assert = static function ( $condition, $label ) use ( &$passed ) {
	if ( ! $condition ) { throw new RuntimeException( $label ); }
	++$passed;
	WP_CLI::log( 'PASS ' . $label );
};
try {
	$resource = wp_insert_post( array( 'post_type' => 'post', 'post_status' => 'publish', 'post_title' => 'QA post resource', 'post_name' => 'qa-post-resource' ) );
	$created[] = $resource;
	$assert( mckk_ads_public_content( 'qa-post-resource' )->ID === $resource, 'Post resources resolve without requiring replacement pages' );
	set_theme_mod( 'mckk_ads_showcase_ids', (string) $resource );
	$assert( wp_list_pluck( mckk_ads_curated_pages(), 'ID' ) === array( $resource ), 'Native curation accepts existing public posts' );
	$page = wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'QA page priority', 'post_name' => 'qa-post-resource' ) );
	$created[] = $page;
	$assert( mckk_ads_public_content( 'qa-post-resource' )->ID === $page, 'An existing page wins when a post has the same slug' );
	$media = get_posts( array( 'post_type' => 'attachment', 'post_status' => 'inherit', 'name' => 'qa-portrait', 'numberposts' => 1 ) )[0];
	$preview = wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'QA inline preview', 'post_content' => '<img class="wp-image-' . $media->ID . '" src="' . wp_get_attachment_url( $media->ID ) . '">' ) );
	$created[] = $preview;
	$assert( mckk_ads_preview_image_id( $preview ) === $media->ID && ! has_post_thumbnail( $preview ), 'A library image in existing content supplies a card preview without setting featured media' );
	$by_url = wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'QA URL preview', 'post_content' => '<img src="' . wp_get_attachment_url( $media->ID ) . '">' ) );
	$created[] = $by_url;
	$assert( mckk_ads_preview_image_id( $by_url ) === $media->ID, 'Classic image URLs resolve to original library attachments' );
	$off = wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'QA preview opt out', 'post_content' => '<img class="wp-image-' . $media->ID . '">' ) );
	$created[] = $off;
	set_theme_mod( 'mckk_ads_content_previews', false );
	$assert( 0 === mckk_ads_preview_image_id( $off ), 'Administrators can disable content-image previews' );
	set_theme_mod( 'mckk_ads_content_previews', true );
	$tiff = wp_insert_attachment( array( 'post_title' => 'QA TIFF', 'post_status' => 'inherit', 'post_mime_type' => 'image/tiff' ) );
	$created[] = $tiff;
	$assert( false === mckk_ads_web_image_size( $tiff ), 'Unsupported TIFF originals are never rendered as hero previews' );
	set_theme_mod( 'mckk_ads_hero_image', $tiff );
	ob_start(); get_template_part( 'template-parts/hero' ); $hero = ob_get_clean();
	$assert( str_contains( $hero, 'Concept illustration' ) && ! str_contains( $hero, '<img' ), 'Unsupported hero selection renders a labelled concept, not a broken image' );
	wp_update_attachment_metadata( $tiff, array( 'width' => 1600, 'height' => 900, 'file' => 'qa.tif', 'sizes' => array( 'large' => array( 'file' => 'qa-1024x576.jpg', 'width' => 1024, 'height' => 576, 'mime-type' => 'image/jpeg' ) ) ) );
	$assert( 'large' === mckk_ads_web_image_size( $tiff ), 'A web-compatible derivative of a TIFF can be selected' );
	$environment = get_page_by_path( 'environment' );
	$related = wp_list_pluck( mckk_ads_menu_related( $environment->ID ), 'ID' );
	$assert( in_array( get_page_by_path( 'environment/qa-environment-child' )->ID, $related, true ), 'Related discovery follows the assigned menu' );
	$assert( 'editorial' === mckk_ads_sanitize_hero_style( 'invalid' ) && 'classic' === mckk_ads_sanitize_hero_style( 'classic' ), 'Hero composition settings are validated' );
} finally {
	foreach ( $created as $id ) { wp_delete_post( $id, true ); }
	update_option( 'theme_mods_mckk-ads-showcase', $mods );
}
WP_CLI::success( $passed . ' v1.1 regression checks passed.' );
