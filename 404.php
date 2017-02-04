<?php
/**
 * The template for 404 page
 *
 * @package WordPress
 * @subpackage Vun_Hougkh
 * @since The Starry Night 1.0 with Vun Hougkh 1.0
 */
get_header(); ?>
<?php get_template_part( 'partials/page-header/404' ); ?>
<div class="page-body">
	<div class="page-body-container container">
		<div class="page-body-inner row">
			<?php  
			/**
			 * Primary
			 */
			?>
			<div id="primary" class="content-area col-md-12 margin-bottom-2x">
				<div id="content" class="site-content" role="main">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<header class="entry-header text-center">
							<h1 class="entry-title text-size-huge text-muted"><strong>404</strong></h1>
						</header>
						<div class="page-content  text-center">
							<p><?php _e( 'Sorry, your page cannot be found! A search perhaps?', FW_TEXTDOMAIN ); ?></p>
							<div class="search-box"><?php get_search_form(); ?></div>
						</div>
					</article>	
				</div><?php // END: #content ?>
			</div><?php // END: #primary ?>
		</div><?php // END: .page-body-inner ?>
	</div><?php // END: .page-body-container ?>
</div><?php // END: .page-body ?>
<?php get_footer(); ?>