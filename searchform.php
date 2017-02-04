<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">

	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			<div class="input-group">
			    <input type="search" class="search-field form-control input-lg transparent-bg-light" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', FW_TEXTDOMAIN ) ?>" value="<?php echo get_search_query() ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', FW_TEXTDOMAIN ) ?>" />
			    <span class="input-group-btn">
			        <button class="btn btn-danger search-submit input-lg text-uppercase" type="submit"><i class="fa fa-search fa-fw"></i> <?php echo esc_attr_x( 'Search', 'submit button', FW_TEXTDOMAIN ) ?></button>
			    </span>
		    </div>
		</div>
	</div>

</form>