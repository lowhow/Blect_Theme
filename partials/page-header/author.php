<div class="page-header">
	<div class="page-header-container container">
		<div class="page-header-inner">
			<h1 class="archive-title author-title"><?php	printf( __( '%s' ), get_the_author() ); ?> <small><?php _e( 'Archives', FW_TEXTDOMAIN ) ?></small></h1>
			<?php
			// If a user has filled out their description, show a bio on their entries.
			if ( get_the_author_meta( 'description' ) ) : ?>
			<div class="author-info">
		      	<div class="author-avatar">
		      	<?php  
		      	$author_id = get_query_var('author');
		      	$avatar = get_user_meta( $author_id, 'avatar', TRUE);
		      	if ( $avatar ) :
		      	?>
		        	<img class="img-thumbnail alignleft margin-top-0 margin-bottom-half" src="<?php echo $avatar; ?>" width="120" height="120" alt="<?php get_the_author_meta( 'nickname', 2 ); ?>">
		    	<?php endif; 
		    		printf( '<div class="user-description">%s</div>', get_the_author_meta( 'description' ) );
		    	?>
			    </div><?php // END: .author-avatar ?><!-- .author-avatar -->
			</div>              
			<?php endif; ?>
		</div>
	</div>
</div><?php // END: .page-header ?>