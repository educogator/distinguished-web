<?php
/**
 * Native comments, moderation and reply behavior.
 *
 * @package MCKK_ADS_Showcase
 */

if ( post_password_required() ) {
	return; }
?>
<section id="comments" class="comments-area wrap" aria-label="<?php esc_attr_e( 'Discussion', 'mckk-ads-showcase' ); ?>">
<?php
if ( have_comments() ) :
	?>
	<h2><?php esc_html_e( 'Discussion', 'mckk-ads-showcase' ); ?></h2><ol class="comment-list">
	<?php
	wp_list_comments(
		array(
			'style'       => 'ol',
			'short_ping'  => true,
			'avatar_size' => 48,
		)
	);
	?>
	</ol>
	<?php
	the_comments_navigation();
endif;
?>
<?php
if ( ! comments_open() && get_comments_number() ) :
	?>
	<p><?php esc_html_e( 'Comments are closed.', 'mckk-ads-showcase' ); ?></p><?php endif; ?>
<?php comment_form(); ?>
</section>
