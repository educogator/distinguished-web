<?php
/**
 * Editorial hero with approved media or a clearly labelled original concept illustration.
 *
 * @package MCKK_ADS_Showcase
 */

$mckk_ads_hero_id = absint( get_theme_mod( 'mckk_ads_hero_image' ) );
if ( ! $mckk_ads_hero_id && 'page' === get_option( 'show_on_front' ) && ! post_password_required( get_option( 'page_on_front' ) ) ) {
	$mckk_ads_hero_id = get_post_thumbnail_id( get_option( 'page_on_front' ) );
}
$mckk_ads_size  = mckk_ads_web_image_size( $mckk_ads_hero_id );
$mckk_ads_style = mckk_ads_sanitize_hero_style( get_theme_mod( 'mckk_ads_hero_style', 'editorial' ) );
?>
<section class="hero wrap hero--<?php echo esc_attr( $mckk_ads_style ); ?><?php echo $mckk_ads_size ? ' hero--with-media' : ''; ?>" aria-labelledby="hero-title">
	<div class="hero-copy">
		<p class="eyebrow"><span class="status-mark" aria-hidden="true"></span><?php bloginfo( 'name' ); ?></p>
		<h1 id="hero-title"><span class="hero-word"><?php esc_html_e( 'Inspire.', 'mckk-ads-showcase' ); ?></span> <span class="hero-word"><?php esc_html_e( 'Imagine.', 'mckk-ads-showcase' ); ?></span> <span class="hero-word hero-word--accent"><?php esc_html_e( 'Impact.', 'mckk-ads-showcase' ); ?></span></h1>
		<?php if ( get_bloginfo( 'description' ) ) : ?>
		<p class="hero-description"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></p>
		<?php endif; ?>
		<div class="hero-actions">
		<?php foreach ( array( 'learning', 'showcase', 'teaching' ) as $mckk_ads_path ) : ?>
			<?php $mckk_ads_page = mckk_ads_public_content( $mckk_ads_path ); ?>
			<?php if ( $mckk_ads_page ) : ?>
			<a class="button<?php echo 'learning' === $mckk_ads_path ? '' : ' button--secondary'; ?>" href="<?php echo esc_url( get_permalink( $mckk_ads_page ) ); ?>"><?php echo esc_html( get_the_title( $mckk_ads_page ) ); ?><?php mckk_ads_arrow(); ?></a>
			<?php endif; ?>
		<?php endforeach; ?>
		</div>
	</div>
	<figure class="hero-media<?php echo $mckk_ads_size ? '' : ' hero-media--concept'; ?>" data-hero-media>
		<?php if ( $mckk_ads_size ) : ?>
			<?php
			echo wp_get_attachment_image(
				$mckk_ads_hero_id,
				$mckk_ads_size,
				false,
				array(
					'loading'       => 'eager',
					'fetchpriority' => 'high',
					'sizes'         => 'editorial' === $mckk_ads_style ? '(min-width: 1240px) 1100px, 92vw' : '(min-width: 960px) 50vw, 92vw',
				)
			);
			?>
		<?php endif; ?>
		<div class="hero-concept-fallback" <?php echo $mckk_ads_size ? 'hidden' : ''; ?>><?php get_template_part( 'template-parts/media-concept' ); ?><p class="concept-caption"><?php esc_html_e( 'Concept illustration · Not student work', 'mckk-ads-showcase' ); ?></p></div>
		<?php if ( $mckk_ads_size && wp_get_attachment_caption( $mckk_ads_hero_id ) ) : ?>
		<figcaption class="hero-original-caption"><?php echo esc_html( wp_get_attachment_caption( $mckk_ads_hero_id ) ); ?></figcaption>
		<?php endif; ?>
	</figure>
	<div class="hero-index" aria-hidden="true"><span>01 / <?php esc_html_e( 'Inspire', 'mckk-ads-showcase' ); ?></span><span>02 / <?php esc_html_e( 'Imagine', 'mckk-ads-showcase' ); ?></span><span>03 / <?php esc_html_e( 'Impact', 'mckk-ads-showcase' ); ?></span></div>
</section>
