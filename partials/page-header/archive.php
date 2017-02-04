<div class="page-header">
	<div class="page-header-container container">
		<div class="page-header-inner">
			<h1 class="archive-title">
				<?php
				if ( is_day() ) :
					printf( __( '%s <small>Daily Archives</small>' ), get_the_date() );

				elseif ( is_month() ) :
					printf( __( '%s <small>Monthly Archives</small>' ), get_the_date( _x( 'F Y', 'monthly archives date format', FW_TEXTDOMAIN ) ) );

				elseif ( is_year() ) :
					printf( __( '%s <small>Yearly Archives</small>' ), get_the_date( _x( 'Y', 'yearly archives date format', FW_TEXTDOMAIN ) ) );

				else :
					_e( 'Archives', FW_TEXTDOMAIN );

				endif;
				?>
			</h1>

			<?php
				// Show an optional term description.
				$term_description = term_description();
				if ( ! empty( $term_description ) ) :
					printf( '<div class="taxonomy-description">%s</div>', $term_description );
				endif;
			?>
			<?php 
			global $helper;
			$helper->fw_breadcrumbs();
			?>
		</div>
	</div>
</div><?php // END: .page-header ?>