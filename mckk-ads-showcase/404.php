<?php
/**
 * Missing destinations retain native 404 behavior.
 *
 * @package MCKK_ADS_Showcase
 */

get_header();
get_template_part( 'template-parts/breadcrumbs' );
?>
<section class="wrap empty-state"><p class="eyebrow">404</p><h1><?php esc_html_e( 'A different direction.', 'mckk-ads-showcase' ); ?></h1><p><?php esc_html_e( 'This page could not be found. Search the site or return to the homepage.', 'mckk-ads-showcase' ); ?></p><?php get_search_form(); ?><p><a class="text-link" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'mckk-ads-showcase' ); ?> <?php mckk_ads_arrow(); ?></a></p></section>
<?php get_footer(); ?>
