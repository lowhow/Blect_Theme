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
	<div class="row">	
		<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
			<div class="col-sm-6 col-md-6">
				<a class="text-center entry-thumbnail entry-thumbnail-full" href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail( 'medium', array( 'class' => 'img-responsive img-responsive-full  margin-bottom-half' ) ); ?>
				</a>
			</div>
		<?php endif; ?>

		<div class="<?php echo has_post_thumbnail() ? 'col-sm-6 col-md-6' : 'col-sm-12' ?>">
			<h3 class="media-heading entry-title list-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
			<span class="entry-meta"><?php $helper->t_entry_date(); ?></span>
			<span class="delimiter"></span>
			<span class="entry-meta"><?php $helper->t_entry_publisher(); ?></span>
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
