<?php
/**
 * Read-only web-compatible media previews. Never import or rewrite source content.
 *
 * @package MCKK_ADS_Showcase
 */

/**
 * Find a browser-compatible image size, including derivatives of a TIFF upload.
 *
 * @param int $id Attachment ID.
 * @return string|false
 */
function mckk_ads_web_image_size( $id ) {
	if ( ! $id ) {
		return false;
	}
	$types = array( 'image/jpeg', 'image/png', 'image/webp', 'image/avif', 'image/gif' );
	if ( in_array( get_post_mime_type( $id ), $types, true ) ) {
		return 'large';
	}
	$metadata = wp_get_attachment_metadata( $id );
	foreach ( array( 'large', 'medium_large', 'medium', 'thumbnail' ) as $size ) {
		if ( in_array( $metadata['sizes'][ $size ]['mime-type'] ?? '', $types, true ) ) {
			return $size;
		}
	}
	return false;
}

/**
 * Read an existing library image from featured media or the original content markup.
 *
 * @param int $post_id Existing public page or post ID.
 * @return int
 */
function mckk_ads_preview_image_id( $post_id ) {
	static $cache = array();
	if ( isset( $cache[ $post_id ] ) ) {
		return $cache[ $post_id ];
	}
	$cache[ $post_id ] = 0;
	$post              = get_post( $post_id );
	if ( ! $post || ! is_post_publicly_viewable( $post ) || $post->post_password ) {
		return 0;
	}
	$id = get_post_thumbnail_id( $post_id );
	if ( mckk_ads_web_image_size( $id ) ) {
		$cache[ $post_id ] = $id;
		return $id;
	}
	if ( ! get_theme_mod( 'mckk_ads_content_previews', true ) ) {
		return 0;
	}
	$processor = new WP_HTML_Tag_Processor( $post->post_content );
	$uploads   = wp_upload_dir();
	while ( $processor->next_tag( 'IMG' ) ) {
		$id = 0;
		if ( preg_match( '/\bwp-image-(\d+)\b/', (string) $processor->get_attribute( 'class' ), $matches ) ) {
			$id = absint( $matches[1] );
		} else {
			$url = (string) $processor->get_attribute( 'src' );
			if ( str_starts_with( $url, trailingslashit( $uploads['baseurl'] ) ) ) {
				$id = attachment_url_to_postid( $url );
				if ( ! $id ) {
					$id = attachment_url_to_postid( preg_replace( '/-\d+x\d+(?=\.[a-zA-Z]+$)/', '', $url ) );
				}
			}
		}
		if ( mckk_ads_web_image_size( $id ) ) {
			$cache[ $post_id ] = $id;
			return $id;
		}
	}
	return 0;
}
