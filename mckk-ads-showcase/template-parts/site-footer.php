<?php
/**
 * Native footer.
 *
 * @package MCKK_ADS_Showcase
 */

?>
<footer class="site-footer">
	<div class="wrap footer-top">
		<div><a class="footer-title" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a><p class="footer-pillars"><?php esc_html_e( 'Inspire. Imagine. Impact.', 'mckk-ads-showcase' ); ?></p></div>
		<?php
		if ( has_nav_menu( 'footer' ) ) :
			?>
			<nav aria-label="<?php esc_attr_e( 'Footer', 'mckk-ads-showcase' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'footer-menu',
					'depth'          => 1,
				)
			);
			?>
			</nav><?php endif; ?>
	</div>
	<div class="wrap footer-bottom"><p>&copy; <?php echo esc_html( wp_date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></p>
	<?php
	if ( get_theme_mod( 'mckk_ads_footer_text' ) ) :
		?>
		<p><?php echo esc_html( get_theme_mod( 'mckk_ads_footer_text' ) ); ?></p><?php endif; ?><?php the_privacy_policy_link(); ?><a href="#site-header"><?php esc_html_e( 'Back to top', 'mckk-ads-showcase' ); ?> <?php mckk_ads_arrow(); ?></a></div>
</footer>
