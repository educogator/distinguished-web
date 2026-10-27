<?php
/**
 * Accessible primary navigation.
 *
 * @package MCKK_ADS_Showcase
 */

?>
<header class="site-header" id="site-header">
	<div class="header-inner wrap">
		<div class="site-branding">
			<?php
			if ( has_custom_logo() ) {
				the_custom_logo(); }
			?>
			<a class="site-identity" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<span class="site-title"><?php bloginfo( 'name' ); ?></span>
				<?php
				if ( get_bloginfo( 'description' ) ) :
					?>
					<span class="site-tagline"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></span><?php endif; ?>
			</a>
		</div>
		<button class="menu-toggle" type="button" aria-expanded="false" aria-controls="site-navigation"><span class="menu-toggle-icon" aria-hidden="true"></span><span><?php esc_html_e( 'Menu', 'mckk-ads-showcase' ); ?></span></button>
		<nav id="site-navigation" class="site-navigation" aria-label="<?php esc_attr_e( 'Primary', 'mckk-ads-showcase' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_id'        => 'primary-menu',
					'menu_class'     => 'menu',
					'fallback_cb'    => 'mckk_ads_fallback_menu',
					'depth'          => 0,
				)
			);
			?>
			<a class="search-access" href="<?php echo esc_url( home_url( '/?s=' ) ); ?>"><svg aria-hidden="true" width="20" height="20" viewBox="0 0 24 24" fill="none"><circle cx="10.5" cy="10.5" r="6.5" stroke="currentColor" stroke-width="1.7"/><path d="m16 16 5 5" stroke="currentColor" stroke-width="1.7"/></svg><span><?php esc_html_e( 'Search', 'mckk-ads-showcase' ); ?></span></a>
		</nav>
	</div>
	<div class="navigation-backdrop" hidden></div>
</header>
