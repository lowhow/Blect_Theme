<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
global $helper;
$post_format = get_post_format();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="row margin-bottom-1x">	
		<div class="col-sm-12">
			<h3 class="media-heading entry-title list-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
			<div class="entry-summary"><?php echo get_the_excerpt(); ?></div>
			<p class="small text-muted semitransparent"><?php echo get_permalink(); ?></p>
		</div>
	</div>
</article>


