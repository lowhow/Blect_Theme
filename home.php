<?php
/**
 * The template for home page
 *
 * @package WordPress
 * @subpackage Vun_Hougkh
 * @since The Starry Night 1.0 with Vun Hougkh 1.0
 */
get_header();
global $helper;
?>
	<div class="page-body">
		<div class="page-body-container container">
			<div class="page-body-inner row">
				<div id="primary" class="content-area col-md-8">
					<div class="well">
						<i class="fal fa-anchor"></i>
						<button class="hamburger hamburger--slider is-active" type="button">
							<span class="hamburger-box">
						    	<span class="hamburger-inner"></span>
						  	</span>
						</button>
					</div>
					<?php if ( ! is_paged() ) : ?>
					<?php endif; // END: is_paged() ?>
				</div>
				<div class="col-md-4 margin-top-1x"><?php get_sidebar(); ?></div>
			</div>
		</div>
	</div>
<?php get_footer(); ?>