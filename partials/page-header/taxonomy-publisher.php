<?php global $helper; ?>
<div class="page-header">
	<div class="page-header-container container">
		<div class="page-header-inner">
			<?php if ( $helper->t_get_the_term_avatar() ) : ?>
			<img class="img-thumbnail alignleft margin-top-0 margin-bottom-half" src="<?php echo $helper->t_get_the_term_avatar(); ?>" width="100" height="100" alt="<?php single_term_title( '', TRUE ); ?>">
			<?php endif; ?>
			<h1 class="archive-title cat-title "><?php single_term_title( '', TRUE ); ?> <small><?php _e( 'Publisher', FW_TEXTDOMAIN ) ?></small></h1>
			<?php
			// Show an optional term description.
			$term_description = term_description();
			if ( ! empty( $term_description ) ) :
				printf( '<div class="taxonomy-description">%s</div>', $term_description );
			endif;
			?>
		</div>
	</div>
</div>