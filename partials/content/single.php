<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 */
global $helper;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header margin-bottom-half">
		<span class="entry-meta"><?php $helper->t_entry_date(); ?></span>
		<span class="delimiter"></span>
		<span class="entry-meta"><?php $helper->t_entry_publisher(); ?></span>
		<span class="delimiter"></span>
		<span class="entry-meta"><?php $helper->t_entry_author(); ?></span>
		<span class="delimiter"></span>
		<span class="entry-meta"><?php $helper->t_entry_cat(); ?></span>
	</header>

	<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
		<div class="margin-bottom-1x hidden">
			<?php the_post_thumbnail( 'full', array( 'class' => 'img-responsive img-responsive-full' ) ); ?>
		</div>
	<?php endif; ?>

	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', FW_TEXTDOMAIN ) ); ?>
		<br class="margin-bottom-1x">
		<span class="entry-meta"><?php $helper->t_entry_tag(); ?></span>
		<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php if ( is_single() && get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
			<?php get_template_part( 'author-bio' ); ?>
		<?php endif; ?>
	</footer><!-- .entry-meta -->
</article><!-- #post -->
