<?php
/**
 * Small native presentation controls.
 *
 * @package MCKK_ADS_Showcase
 */

/**
 * Normalize an optional list of existing content IDs.
 *
 * @param mixed $value User setting.
 * @return string
 */
function mckk_ads_sanitize_ids( $value ) {
	return implode( ',', array_slice( array_unique( array_filter( array_map( 'absint', explode( ',', (string) $value ) ) ) ), 0, 12 ) );
}

/**
 * Normalize a native boolean setting.
 *
 * @param mixed $value User setting.
 * @return bool
 */
function mckk_ads_sanitize_checkbox( $value ) {
	return (bool) $value;
}

/**
 * Validate the optional hero composition.
 *
 * @param mixed $value Saved setting.
 * @return string
 */
function mckk_ads_sanitize_hero_style( $value ) {
	return in_array( $value, array( 'editorial', 'classic' ), true ) ? $value : 'editorial';
}

/**
 * Register a small set of native presentation controls.
 *
 * @param WP_Customize_Manager $manager Customizer instance.
 */
function mckk_ads_customize( $manager ) {
	$manager->add_section( 'mckk_ads_showcase', array( 'title' => __( 'Showcase presentation', 'mckk-ads-showcase' ) ) );
	$settings = array(
		'mckk_ads_content_previews' => array(
			'default'           => true,
			'sanitize_callback' => 'mckk_ads_sanitize_checkbox',
		),
		'mckk_ads_hero_style'       => array(
			'default'           => 'editorial',
			'sanitize_callback' => 'mckk_ads_sanitize_hero_style',
		),
		'mckk_ads_hero_image'       => array(
			'default'           => 0,
			'sanitize_callback' => 'absint',
		),
		'mckk_ads_showcase_ids'     => array(
			'default'           => '',
			'sanitize_callback' => 'mckk_ads_sanitize_ids',
		),
		'mckk_ads_footer_text'      => array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_textarea_field',
		),
		'mckk_ads_accent'           => array(
			'default'           => '#A51D2D',
			'sanitize_callback' => 'sanitize_hex_color',
		),
		'mckk_ads_lightbox'         => array(
			'default'           => true,
			'sanitize_callback' => 'mckk_ads_sanitize_checkbox',
		),
		'mckk_ads_reuse_menu'       => array(
			'default'           => true,
			'sanitize_callback' => 'mckk_ads_sanitize_checkbox',
		),
	);
	foreach ( $settings as $id => $setting ) {
		$manager->add_setting( $id, $setting );
	}
	$manager->add_control(
		new WP_Customize_Media_Control(
			$manager,
			'mckk_ads_hero_image',
			array(
				'section'     => 'mckk_ads_showcase',
				'label'       => __( 'Homepage hero image', 'mckk-ads-showcase' ),
				'description' => __( 'Choose approved photography from the existing media library. Falls back to the homepage featured image; use JPEG, PNG, WebP or AVIF. An original concept illustration appears when no web-compatible image is available.', 'mckk-ads-showcase' ),
				'mime_type'   => 'image',
			)
		)
	);
	$manager->add_control(
		'mckk_ads_showcase_ids',
		array(
			'section'     => 'mckk_ads_showcase',
			'label'       => __( 'Student work: existing page or post IDs', 'mckk-ads-showcase' ),
			'description' => __( 'Up to 12 comma-separated page or post IDs, in order. Only published, unprotected content appears. Leave blank for existing Showcase, Repository and Visual Note-taking pages. No new content is created.', 'mckk-ads-showcase' ),
			'type'        => 'text',
		)
	);
	$manager->add_control(
		'mckk_ads_footer_text',
		array(
			'section' => 'mckk_ads_showcase',
			'label'   => __( 'Footer text', 'mckk-ads-showcase' ),
			'type'    => 'textarea',
		)
	);
	$manager->add_control(
		new WP_Customize_Color_Control(
			$manager,
			'mckk_ads_accent',
			array(
				'section'     => 'mckk_ads_showcase',
				'label'       => __( 'Decorative accent', 'mckk-ads-showcase' ),
				'description' => __( 'Affects decorative rules only. Text, links and focus indicators keep accessible contrast.', 'mckk-ads-showcase' ),
			)
		)
	);
	$manager->add_control(
		'mckk_ads_hero_style',
		array(
			'section' => 'mckk_ads_showcase',
			'label'   => __( 'Hero composition', 'mckk-ads-showcase' ),
			'type'    => 'select',
			'choices' => array(
				'editorial' => __( 'Editorial panorama', 'mckk-ads-showcase' ),
				'classic'   => __( 'Compact split', 'mckk-ads-showcase' ),
			),
		)
	);
	foreach ( array(
		'mckk_ads_content_previews' => __( 'Use an existing content image when a card has no featured image', 'mckk-ads-showcase' ),
		'mckk_ads_lightbox'         => __( 'Enhance compatible image links with an accessible lightbox', 'mckk-ads-showcase' ),
		'mckk_ads_reuse_menu'       => __( 'Use the existing Twenty Twenty primary menu when no menu is assigned', 'mckk-ads-showcase' ),
	) as $id => $label ) {
		$manager->add_control(
			$id,
			array(
				'section' => 'mckk_ads_showcase',
				'label'   => $label,
				'type'    => 'checkbox',
			)
		);
	}
}
add_action( 'customize_register', 'mckk_ads_customize' );
