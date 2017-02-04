<?php
/**
 * The template for general single post page
 */
get_header(); ?>
<?php get_template_part( 'partials/page-header/single' ); ?>
<div class="page-body">
	<div class="page-body-container container">
		<div class="page-body-inner row">
			<?php  
			/**
			 * Primary
			 */
			?>
			<div id="primary" class="content-area col-md-8 margin-bottom-2x">
				<div id="content" class="site-content" role="main">
					<?php /** The loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'partials/content/single' ); ?>
						<nav>
							<ul class="pager">
								<li class="previous text-left"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '<i class="fa fa-angle-left fa-lg"></i> ', 'Previous post link', FW_TEXTDOMAIN ) . '</span> <span class="title">%title</span>', $excluded_categories = '1 and 44 and 195' ); ?></li>
								<li class="next text-right"><?php next_post_link( '%link', '<span class="title">%title</span> <span class="meta-nav">' . _x( ' <i class="fa fa-angle-right fa-lg"></i>', 'Next post link', FW_TEXTDOMAIN ) . '</span>', $excluded_categories = '1 and 44 and 195' ); ?></li>
							</ul>
						</nav>
						<?php if ( get_the_author_meta( 'description' ) ) : ?>
						<div id="entry-author-info" class="well  bg-gray-lighter">
							<?php  
							$avatar = get_the_author_meta( 'avatar' );
							if ( $avatar ) :
							?>
							<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><img class="img-thumbnail alignleft margin-top-0 margin-bottom-0" src="<?php echo $avatar; ?>" width="120" height="120" alt="<?php get_the_author_meta( 'nickname'); ?>"></a>
							<h3 class="author-title margin-top-0">
                            	<strong id="author-link"><a class="morelink" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author_meta('nickname'); ?></a></strong>
                            	<small><?php _e( 'Author', FW_TEXTDOMAIN ); ?> </small>
                            </h3>
                            <div class="user-description">
                            	<?php the_author_meta( 'description' ); ?>
                        	</div>
							<?php  
							endif;
							?>
							<div class="clearfix"></div>
						</div>
		                <?php endif; ?>
					<?php endwhile; /** END: The loop */ ?>		
				</div><?php // END: #content ?>
			</div><?php // END: #primary ?>
			<div class="col-md-4 margin-top-1x"><?php get_sidebar(); ?></div>
		</div><?php // END: .page-body-inner ?>
	</div><?php // END: .page-body-container ?>
</div><?php // END: .page-body ?>

<?php get_footer(); ?>