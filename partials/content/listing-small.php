<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
global $helper;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="media">

		<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
		<a class="media-left entry-thumbnail-medium" href="<?php the_permalink(); ?>">
			<?php the_post_thumbnail( 'thumbnail' ); ?>
		</a>
		<?php endif; ?>

		<div class="media-body">
			<h3 class="media-heading entry-title title-sm"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
			<span class="entry-meta"><?php $helper->t_entry_date(); ?></span>
			<span class="delimiter"></span>
			<span class="entry-meta"><?php $helper->t_entry_author(); ?></span>
			<span class="delimiter"></span>
			<span class="entry-meta"><?php $helper->t_entry_cat(); ?></span>
			<div class="entry-summary"><?php the_excerpt(); ?></div>
			<span class="entry-meta"><?php $helper->t_entry_tag(); ?></span>
		</div>

	</div>
</article>
<hr>
