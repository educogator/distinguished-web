<?php
/**
 * Document header.
 *
 * @package MCKK_ADS_Showcase
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#main-content"><?php esc_html_e( 'Skip to content', 'mckk-ads-showcase' ); ?></a>
<?php get_template_part( 'template-parts/site-header' ); ?>
<main id="main-content" tabindex="-1">
