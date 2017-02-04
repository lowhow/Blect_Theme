<?php
/**
 * The template for general category listing page
 */
get_header(); ?>
<?php get_template_part( 'partials/page-header/category' ); ?>
<div class="page-body">
	<div class="page-body-container container">
		<div class="page-body-inner row">
			<?php  /* Primary */ ?>
			<div id="primary" class="content-area col-md-8 margin-bottom-2x">
				<div id="content" class="site-content row" role="main">
					<?php 
					if ( have_posts() ) 
					{ 
						$counter = 0;
						while ( have_posts() ) : the_post(); 
							$counter ++;
							if ( $counter % 2 && $counter !== 1 ) echo '<div class="clearfix"></div>';

							get_template_part( 'partials/content/listing-grid-sm2col' );
						endwhile; 
						echo '<div class="clearfix"></div>';
						$helper->t_pagination();
					}
					else
					{
						get_template_part( 'partials/content/none' );
					}
					?>
				</div><?php // END: #content ?>
			</div><?php // END: #primary ?>
			<div class="col-md-4">
				<?php get_sidebar(); ?>
			</div>
		</div><?php // END: .page-body-inner ?>
	</div><?php // END: .page-body-container ?>
</div><?php // END: .page-body ?>
<?php get_footer(); ?>