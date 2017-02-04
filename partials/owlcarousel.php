<?php
if ( ! isset( $module_query_args ) ) return;
$the_query = new WP_query( $module_query_args );
if ( $the_query->have_posts() ) : 
	$counter = 0;
?>
<div class="owlcarouselwrap visible-xs-block">
	<ul class="owlcarousel list-unstyled margin-bottom-0">
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		<?php
		/**
		 * Exclude these post in home page listing
		 */
		if ( ! in_array( $post->ID, $post_to_exclude ) ) $post_to_exclude[] = $post->ID;
		$counter++; 
		$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
		?>
		<li class="post-">
			<div class="owl-img-holder" style="background-image: url(<?php echo wp_get_attachment_url( $post_thumbnail_id ); ?>);"></div>
			<div class="centerlinkwrap text-center">
				<h2 class="h4 text-strip"><a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a></h2>
			</div>
		</li>
	<?php endwhile; ?>
	</ul>
</div>
<?php 
wp_reset_postdata(); 

endif;
/**
 * Cleanup query array for the next user.
 */
unset( $module_args );

?>