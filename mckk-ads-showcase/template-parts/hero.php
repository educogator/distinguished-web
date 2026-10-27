<?php
/**
 * Theme interface and an optional existing-library image.
 *
 * @package MCKK_ADS_Showcase
 */

$mckk_ads_hero_id = absint( get_theme_mod( 'mckk_ads_hero_image' ) );
if ( ! $mckk_ads_hero_id && 'page' === get_option( 'show_on_front' ) && ! post_password_required( get_option( 'page_on_front' ) ) ) {
	$mckk_ads_hero_id = get_post_thumbnail_id( get_option( 'page_on_front' ) );
}
?>
<section class="hero wrap<?php echo $mckk_ads_hero_id ? ' hero--with-media' : ''; ?>" aria-labelledby="hero-title">
	<div class="hero-copy">
		<p class="eyebrow"><span class="status-mark" aria-hidden="true"></span><?php bloginfo( 'name' ); ?></p>
		<h1 id="hero-title"><?php esc_html_e( 'Inspire.', 'mckk-ads-showcase' ); ?><br><?php esc_html_e( 'Imagine.', 'mckk-ads-showcase' ); ?><br><span><?php esc_html_e( 'Impact.', 'mckk-ads-showcase' ); ?></span></h1>
		<?php
		if ( get_bloginfo( 'description' ) ) :
			?>
			<p class="hero-description"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></p><?php endif; ?>
		<div class="hero-actions">
		<?php
		foreach ( array( 'learning', 'showcase', 'teaching' ) as $mckk_ads_path ) :
			$mckk_ads_page = mckk_ads_public_page( $mckk_ads_path );
			?>
			<?php
			if ( $mckk_ads_page ) :
				?>
				<a class="button<?php echo 'learning' === $mckk_ads_path ? '' : ' button--secondary'; ?>" href="<?php echo esc_url( get_permalink( $mckk_ads_page ) ); ?>"><?php echo esc_html( get_the_title( $mckk_ads_page ) ); ?><?php mckk_ads_arrow(); ?></a><?php endif; ?>
		<?php endforeach; ?>
		</div>
	</div>
	<?php if ( $mckk_ads_hero_id ) : ?>
	<figure class="hero-media">
		<?php
		echo wp_get_attachment_image(
			$mckk_ads_hero_id,
			'full',
			false,
			array(
				'loading'       => 'eager',
				'fetchpriority' => 'high',
				'sizes'         => '(min-width: 960px) 50vw, 100vw',
			)
		);
		?>
								<?php
								if ( wp_get_attachment_caption( $mckk_ads_hero_id ) ) :
									?>
	<figcaption><?php echo esc_html( wp_get_attachment_caption( $mckk_ads_hero_id ) ); ?></figcaption><?php endif; ?></figure>
	<?php endif; ?>
	<div class="hero-index" aria-hidden="true"><span>01 / <?php esc_html_e( 'Inspire', 'mckk-ads-showcase' ); ?></span><span>02 / <?php esc_html_e( 'Imagine', 'mckk-ads-showcase' ); ?></span><span>03 / <?php esc_html_e( 'Impact', 'mckk-ads-showcase' ); ?></span></div>
</section>
