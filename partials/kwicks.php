<?php
if ( ! isset( $module_query_args ) ) return;

$the_query = new WP_query( $module_query_args );

if ( $the_query->have_posts() ) : 

	$counter = 0;
?>

<div class="container">
	<div class="kwickswrap">
		<ul class="kwicks kwicks-horizontal">
		<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
			<?php
			/**
			 * Exclude these post in home page listing
			 */
			if ( ! in_array( $post->ID, $post_to_exclude ) )
				$post_to_exclude[] = $post->ID;
			?>
			<?php 
			$counter++; 	
			$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
			?>
			<li class="post-">
				<div class="kwicks-img-holder" style="background-image: url(<?php echo wp_get_attachment_url( $post_thumbnail_id ); ?>);"></div>
				<div class="jumbowrap"><div class="jumbo101 jumbo101-<?php echo $counter; ?>"></div></div>
				<div class="centerlinkwrap">
					<div class="text-center">
						<a href="<?php the_permalink(); ?>" class="">
							<span class="fa-stack fa-3x">
								<i class="fa fa-circle fa-stack-2x"></i>
								<i class="fa fa-link fa-stack-1x fa-inverse"></i>
							</span>
							<br>
							<h2 class="h4 text-strip"><?php the_title(); ?></h2>
						</a>	
					</div>
				</div>
			</li>
		<?php endwhile; ?>
		</ul>
	</div>
</div>
<?php 
wp_reset_postdata(); 
endif;
/**
 * Cleanup query array for the next user.
 */
unset( $module_args );