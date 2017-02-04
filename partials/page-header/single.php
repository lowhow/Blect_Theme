<div class="page-header">
	<div class="page-header-container container">
		<div class="page-header-inner">
			<h1 class="page-title single-title"><?php echo get_the_title() ?></h1>
			<?php 
			global $helper;
			$helper->fw_breadcrumbs();
			?>
			<?php edit_post_link( __( '<i class="fa fa-edit"></i> Edit', FW_TEXTDOMAIN ), '<span class="edit-link">', '</span>' ); ?>
		</div>
	</div>
</div><?php // END: .page-header ?>