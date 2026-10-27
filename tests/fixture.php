<?php
/** Local-only, synthetic WordPress test data. Never run against a real school database. */
if ( ! defined( 'WP_CLI' ) || ! WP_CLI || 'local' !== wp_get_environment_type() || '127.0.0.1' !== wp_parse_url( home_url(), PHP_URL_HOST ) ) {
	throw new RuntimeException( 'Fixtures require WP-CLI and an isolated localhost WordPress with environment type local.' );
}
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
$media = array();
foreach ( array( 'landscape', 'portrait' ) as $name ) {
	$existing = get_posts( array( 'post_type' => 'attachment', 'name' => 'qa-' . $name, 'posts_per_page' => 1, 'post_status' => 'inherit' ) );
	if ( $existing ) {
		$media[ $name ] = $existing[0]->ID;
		continue;
	}
	$source = '/workspace/mckk-tools/fixtures/' . $name . '.png';
	$upload = wp_upload_bits( 'qa-' . $name . '.png', null, file_get_contents( $source ) );
	if ( $upload['error'] ) { throw new RuntimeException( $upload['error'] ); }
	$id = wp_insert_attachment( array( 'post_title' => 'Local QA ' . $name, 'post_name' => 'qa-' . $name, 'post_excerpt' => 'Local QA fixture, not school work.', 'post_mime_type' => 'image/png', 'post_status' => 'inherit' ), $upload['file'] );
	wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $upload['file'] ) );
	update_post_meta( $id, '_wp_attachment_image_alt', 'Synthetic ' . $name . ' test image with edge markings' );
	$media[ $name ] = $id;
}
$image_url = wp_get_attachment_url( $media['portrait'] );
$legacy = '<h2>Compatibility fixture</h2><p>LOCAL QA CONTENT. This is synthetic test material, not a student project or institutional claim.</p><p><a href="https://drive.google.com/file/d/QA_FIXTURE/view">Google Drive URL preservation fixture (not a real resource)</a> · <a href="https://www.youtube.com/watch?v=QA_FIXTURE">YouTube URL preservation fixture (not a real resource)</a></p><p><a href="' . esc_url( $image_url ) . '"><img src="' . esc_url( $image_url ) . '" alt="Portrait media fixture with text at the edges" width="900" height="1200"></a></p>[gallery ids="' . implode( ',', $media ) . '" link="file"]<p>[mckk_qa_shortcode]</p><h2>Legacy HTML and resources</h2><div class="wp-caption aligncenter"><p>Classic editor caption fixture.</p></div><p><a download href="' . esc_url( $image_url ) . '">Download fixture image</a></p><div class="wp-block-embed"><div class="wp-block-embed__wrapper"><iframe width="560" height="315" title="Local embed fixture" src="http://127.0.0.1:8080/qa-embed.html"></iframe></div></div><table><thead><tr><th scope="col">Fixture</th><th scope="col">Expected result</th></tr></thead><tbody><tr><td>Native rendering</td><td>Original content and links remain unchanged</td></tr></tbody></table>';
$blocks = '<!-- wp:paragraph --><p>BLOCK_FIXTURE_SENTINEL: This local test page is not production content.</p><!-- /wp:paragraph --><!-- wp:heading --><h2 class="wp-block-heading">Gutenberg compatibility</h2><!-- /wp:heading --><!-- wp:columns {"align":"wide"} --><div class="wp-block-columns alignwide"><!-- wp:column --><div class="wp-block-column"><!-- wp:paragraph --><p>First test column.</p><!-- /wp:paragraph --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:paragraph --><p>Second test column.</p><!-- /wp:paragraph --></div><!-- /wp:column --></div><!-- /wp:columns -->';
$paths = array( 'home' => 'Local QA homepage', 'learning' => 'Learning', 'stem-ar' => 'STEM AR', 'everyone-can-code-in-learning' => 'Everyone Can Code', 'visual-note-taking-using-ipad' => 'Visual Note-taking', 'koleq-podcast-with-garageband' => 'Koleq Podcast', 'garageband-mini-orchestra' => 'GarageBand Mini Orchestra', 'mckk-apple-tech-leader' => 'Apple Tech Leaders', 'mckk-repository' => 'MCKK Repository', 'showcase' => 'Showcase', 'house-rewards-programme' => 'Best Content Awards', 'teaching' => 'Teaching', 'teachers-report-card' => 'Teachers Report Card', 'action-research-on-learning-with-ipad' => 'Action Research', 'apple-teacher-mckk' => 'Apple Teacher MCKK', 'environment' => 'Environment', 'qa-environment-child' => 'QA hierarchy child', 'qa-protected' => 'QA protected page', 'qa-blocks' => 'QA block compatibility', 'journal' => 'Journal' );
$ids = array();
foreach ( $paths as $slug => $title ) {
	$page = get_page_by_path( $slug );
	$args = array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => $title, 'post_name' => $slug, 'post_content' => 'qa-blocks' === $slug ? $blocks : $legacy, 'post_excerpt' => 'Local QA fixture only. Existing editorial content is rendered by WordPress.' );
	if ( 'home' === $slug ) { $args['post_content'] = '<!-- wp:paragraph --><p>HOME_CONTENT_SENTINEL — Local QA fixture. No school content has been copied, replaced or invented.</p><!-- /wp:paragraph --><h2>Inspire. Imagine. Impact.</h2><p>Full historical homepage content remains in its original editor order.</p>'; }
	if ( 'qa-protected' === $slug ) { $args['post_password'] = wp_generate_password( 24 ); $args['post_content'] = 'PROTECTED_CONTENT_SENTINEL'; }
	if ( 'journal' === $slug ) { $args['post_content'] = ''; }
	if ( $page ) { $args['ID'] = $page->ID; }
	$id = wp_insert_post( $args, true );
	if ( is_wp_error( $id ) ) { throw new RuntimeException( $id->get_error_message() ); }
	$ids[ $slug ] = $id;
	if ( 'qa-protected' !== $slug ) { set_post_thumbnail( $id, $media[ 'visual-note-taking-using-ipad' === $slug ? 'portrait' : 'landscape' ] ); }
}
wp_update_post( array( 'ID' => $ids['qa-environment-child'], 'post_parent' => $ids['environment'] ) );
$menu = wp_get_nav_menu_object( 'QA primary' );
$menu_id = $menu ? $menu->term_id : wp_create_nav_menu( 'QA primary' );
if ( ! wp_get_nav_menu_items( $menu_id ) ) {
	$parents = array();
	foreach ( array( 'home', 'learning', 'stem-ar', 'everyone-can-code-in-learning', 'showcase', 'teaching', 'environment', 'qa-environment-child' ) as $slug ) {
		$parent = in_array( $slug, array( 'stem-ar', 'everyone-can-code-in-learning' ), true ) ? $parents['learning'] : ( 'qa-environment-child' === $slug ? $parents['environment'] : 0 );
		$parents[ $slug ] = wp_update_nav_menu_item( $menu_id, 0, array( 'menu-item-object-id' => $ids[ $slug ], 'menu-item-object' => 'page', 'menu-item-type' => 'post_type', 'menu-item-status' => 'publish', 'menu-item-parent-id' => $parent, 'menu-item-title' => 'home' === $slug ? 'Home' : $paths[ $slug ] ) );
	}
	wp_update_nav_menu_item( $menu_id, 0, array( 'menu-item-object-id' => $ids['qa-blocks'], 'menu-item-object' => 'page', 'menu-item-type' => 'post_type', 'menu-item-status' => 'publish', 'menu-item-parent-id' => $parents['stem-ar'] ) );
}
update_option( 'theme_mods_twentytwenty', array( 'nav_menu_locations' => array( 'primary' => $menu_id ) ) );
update_option( 'blogdescription', 'Local QA fixtures · Not a production site' );
update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $ids['home'] );
update_option( 'page_for_posts', $ids['journal'] );
update_option( 'posts_per_page', 2 );
update_option( 'permalink_structure', '/%postname%/' );
for ( $n = 1; $n <= 4; $n++ ) {
	if ( ! get_page_by_path( 'qa-journal-' . $n, OBJECT, 'post' ) ) {
		$id = wp_insert_post( array( 'post_type' => 'post', 'post_status' => 'publish', 'post_name' => 'qa-journal-' . $n, 'post_title' => 'QA journal fixture ' . $n, 'post_content' => $blocks, 'post_date' => '2020-01-0' . $n . ' 12:00:00' ) );
		wp_set_post_categories( $id, array( 1 ) );
	}
}
file_put_contents( WP_CONTENT_DIR . '/../qa-embed.html', '<!doctype html><html lang="en"><title>Local iframe fixture</title><body><p>Local iframe compatibility fixture.</p></body></html>' );
if ( ! is_dir( WPMU_PLUGIN_DIR ) ) { mkdir( WPMU_PLUGIN_DIR ); }
file_put_contents( WPMU_PLUGIN_DIR . '/qa-fixture.php', "<?php\nadd_shortcode('mckk_qa_shortcode', static function () { return '<p>SHORTCODE_RENDERED_SENTINEL</p>'; });\n" );
flush_rewrite_rules( false );
WP_CLI::success( 'Local-only fixtures prepared. No production content involved.' );
