<?php
if ( have_posts() ) : ?>

	<div class="module module-red">
		<div class="module-heading">
			<h3 class="module-title">最新文章</h3>
		</div>	
		<div class="row">
			<?php while ( have_posts() ) : the_post(); ?>
			<div <?php post_class( 'media col-sm-6' ); ?>>
				<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
				<a class="media-left entry-thumbnail entry-thumbnail-thumbnail" href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail( 'thumbnail' ); ?>
				</a>
				<?php endif; ?>
			
				<div class="media-body">
					<h3 class="media-heading entry-title title-sm"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
					<span class="entry-meta"><?php $helper->t_entry_date(); ?></span>
				</div>
			</div>
			<?php endwhile; ?>
		</div>
	</div>
	<?php $helper->t_pagination(); ?>
<?php else : ?>
	<p><?php _e( 'Sorry, no posts matched your criteria.', FW_TEXTDOMAIN ); ?></p>
<?php endif; 

/**
 * Cleanup query array for the next user.
 */
unset( $module_args );