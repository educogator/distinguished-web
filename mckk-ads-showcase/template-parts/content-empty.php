<?php
/**
 * A navigation aid for existing pages whose editor is genuinely empty.
 *
 * @package MCKK_ADS_Showcase
 */

?>
<div class="empty-state page-empty-state">
	<h2><?php esc_html_e( 'Keep exploring.', 'mckk-ads-showcase' ); ?></h2>
	<p><?php esc_html_e( 'Choose a related page below or search the site.', 'mckk-ads-showcase' ); ?></p>
	<?php get_search_form(); ?>
</div>
