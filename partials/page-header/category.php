<div class="page-header">
	<div class="page-header-container container">
		<div class="page-header-inner">
			<h1 class="archive-title cat-title"><?php single_cat_title( '', TRUE ); ?></h1>
			<?php
			// Show an optional term description.
			$term_description = term_description();
			if ( ! empty( $term_description ) ) :
				printf( '<div class="taxonomy-description">%s</div>', $term_description );
			endif;
			?>
			<?php 
			if ( is_category( 371 ) ) :/* cat = 十分李桑 */
				$leesan_user_id = 2;
				$avatar = get_user_meta( $leesan_user_id, 'avatar', TRUE);
				if ( $avatar ) :
			?>
				<img class="img-thumbnail alignleft margin-top-0 margin-bottom-half" src="<?php echo $avatar; ?>" width="80" height="80" alt="<?php get_the_author_meta( 'nickname', 2 ); ?>">
			<?php
				endif;
				printf( '<div class="user-description">%s</div>', get_the_author_meta( 'description', $leesan_user_id ) );
			endif;
			?> 
		</div>
	</div>
</div>