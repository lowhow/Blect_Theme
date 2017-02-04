<div class="page-header">
	<div class="page-header-container container">
		<div class="page-header-inner">
			<?php global $wp_query; ?>
			<h2 class="archive-title search-title"><i class="fa fa-search fa-fw text-muted semitransparent"></i>	<?php printf( __( 'Search Results %1$s %2$s', FW_TEXTDOMAIN ), '"<b>' . get_search_query() . '</b>"', ''); ?>
				<small><em><?php global $wp_query; echo $wp_query->found_posts ?> found</em></small>
			</h2>
			
			<?php
			?> 
		</div>
	</div>
</div>