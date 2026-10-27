<?php
/**
 * Context from actual hierarchy or explicit brief-supplied references.
 *
 * @package MCKK_ADS_Showcase
 */

$mckk_ads_id           = get_the_ID();
$mckk_ads_related      = get_pages(
	array(
		'parent'      => $mckk_ads_id,
		'sort_column' => 'menu_order,post_title',
		'post_status' => 'publish',
		'number'      => 12,
	)
);
$mckk_ads_learning     = mckk_ads_public_page( 'learning' );
$mckk_ads_learning_ids = wp_list_pluck( mckk_ads_learning_pages(), 'ID' );
if ( in_array( $mckk_ads_id, $mckk_ads_learning_ids, true ) || ( $mckk_ads_learning && $mckk_ads_id === $mckk_ads_learning->ID ) ) {
	$mckk_ads_related = mckk_ads_learning_pages();
} elseif ( ! $mckk_ads_related && wp_get_post_parent_id( $mckk_ads_id ) ) {
	$mckk_ads_related = get_pages(
		array(
			'parent'      => wp_get_post_parent_id( $mckk_ads_id ),
			'sort_column' => 'menu_order,post_title',
			'post_status' => 'publish',
			'number'      => 12,
		)
	);
}
$mckk_ads_related = array_values(
	array_filter(
		$mckk_ads_related,
		static function ( $item ) use ( $mckk_ads_id ) {
			return $item->ID !== $mckk_ads_id && ! $item->post_password;
		}
	)
);
mckk_ads_section( 'related-title', __( 'Continue exploring', 'mckk-ads-showcase' ), $mckk_ads_related );
