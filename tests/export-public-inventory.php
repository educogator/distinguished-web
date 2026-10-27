<?php
/** Read-only public page/post inventory for an authorized staging comparison. */
if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	exit;
}
$inventory = array();
foreach ( get_posts( array( 'post_type' => array( 'page', 'post' ), 'post_status' => 'publish', 'has_password' => false, 'posts_per_page' => -1, 'orderby' => 'ID', 'order' => 'ASC' ) ) as $item ) {
	$inventory[] = array(
		'id' => $item->ID,
		'title' => $item->post_title,
		'type' => $item->post_type,
		'parent' => $item->post_parent,
		'slug' => $item->post_name,
		'url' => get_permalink( $item ),
		'content_sha256' => hash( 'sha256', $item->post_content ),
	);
}
WP_CLI::line( wp_json_encode( $inventory, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES ) );
