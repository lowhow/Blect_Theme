<?php global $helper; ?>
<div class="page-header">
	<div class="page-header-container container">
		<div class="page-header-inner">
			<h1 class="archive-title cat-title"><?php single_term_title( '', TRUE ); ?> <small><?php _e( 'Tags', FW_TEXTDOMAIN ) ?></small>
			</h1>

			<?php
				// Show an optional term description.
				$term_description = term_description();
				if ( ! empty( $term_description ) ) :
					printf( '<div class="taxonomy-description">%s</div>', $term_description );
				endif;
			?>
			<?php $helper->fw_breadcrumbs(); ?>
		</div>
	</div>
</div><?php // END: .page-header ?>