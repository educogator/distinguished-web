<?php
/**
 * Public content link, never a fabricated portfolio item.
 *
 * @package MCKK_ADS_Showcase
 */

$mckk_ads_id   = absint( $args['post_id'] ?? get_the_ID() );
$mckk_ads_item = get_post( $mckk_ads_id );
if ( ! $mckk_ads_item ) {
	return; }
$mckk_ads_title   = get_the_title( $mckk_ads_id );
$mckk_ads_heading = 'h3' === ( $args['heading'] ?? '' ) ? 'h3' : 'h2';
?>
<article class="content-card<?php echo ! empty( $args['showcase'] ) ? ' content-card--showcase' : ''; ?>">
	<a class="card-link" href="<?php echo esc_url( get_permalink( $mckk_ads_id ) ); ?>">
		<div class="card-image">
		<?php
		$mckk_ads_image_id = mckk_ads_preview_image_id( $mckk_ads_id );
		if ( $mckk_ads_image_id ) {
			echo wp_get_attachment_image(
				$mckk_ads_image_id,
				mckk_ads_web_image_size( $mckk_ads_image_id ),
				false,
				array(
					'loading' => 'lazy',
					'alt'     => '',
					'sizes'   => '(min-width: 1024px) 33vw, (min-width: 600px) 50vw, 100vw',
				)
			);
		} else {
			get_template_part( 'template-parts/media-concept' );
		}
		?>
		</div>
		<div class="card-body"><span class="card-kind"><?php echo 'post' === $mckk_ads_item->post_type ? esc_html( get_the_date( '', $mckk_ads_id ) ) : esc_html__( 'Explore', 'mckk-ads-showcase' ); ?></span><<?php echo tag_escape( $mckk_ads_heading ); ?> class="card-title"><?php echo esc_html( $mckk_ads_title ? $mckk_ads_title : __( 'Untitled', 'mckk-ads-showcase' ) ); ?></<?php echo tag_escape( $mckk_ads_heading ); ?>>
		<?php
		if ( mckk_ads_card_summary( $mckk_ads_id ) ) :
			?>
			<p><?php echo esc_html( mckk_ads_card_summary( $mckk_ads_id ) ); ?></p><?php endif; ?><span class="card-arrow"><?php mckk_ads_arrow(); ?></span></div>
	</a>
</article>
