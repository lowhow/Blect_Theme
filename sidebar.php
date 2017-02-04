<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Vun_Hougkh
 * @since The Starry Night 1.0 with Vun Hougkh 1.0
 */
global $helper;
global $post_to_exclude;
?>
<div id="secondary" class="margin-bottom-2x">
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div><?php // END: #primary-sidebar ?>
	<?php endif; ?>
</div><?php // END: #secondary ?>
