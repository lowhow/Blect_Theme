<?php namespace Framework\Extensions;
use Framework\Core\Observer as Observer;
use Framework\WordPress\Loader as Loader;
/**
 * @todo  Validate input field.
 */
class DateTimeSubmitBoxes implements Observer
{
	private $loader;
	private $post_types_to_show;
	private $meta_key;
	private $meta_label;

	public function __construct( Loader $loader, $meta_key, $meta_label, $post_types_to_show = array( 'post' ) )
	{
		$this->loader = $loader;
		$this->post_types_to_show = $post_types_to_show;
		$this->meta_label = $meta_label;
		$this->meta_key = $meta_key;	
	}

	public function handle() 
	{
		$this->loader 
		->add_action( 'post_submitbox_misc_actions', $this, 'custom_status_metabox' )
		->add_action( 'save_post', $this, 'save_meta', 10, 3 )
		->add_action( 'admin_head', $this, 'status_css' );

		return $this;
	}

	/**
	 * [custom_status_metabox description]
	 * @return [type] [description]
	 */
	public function custom_status_metabox() {
	    global $post;
	    if ( ! in_array( get_post_type( $post->ID ), $this->post_types_to_show ) )
	  		return;

	    $meta_value = get_post_meta( $post->ID, $this->meta_key, true );
	    if ( $meta_value === '' )
	    {
	    	$meta_value = date( 'M j, Y @ H:i' );
	    	//$meta_value = date( 'M j, Y @ 00:00' );
	    	$meta_display = 'Not Set';
	    	$mm = date( 'm' );
	    	$jj = date( 'd' );
	    	$aa = date( 'Y' );
	    	$hh = '00';
	    	$mn = '00';
	    }
	    else
	    {
	    	$date = strtotime( $meta_value );
	    	$meta_display = date( 'M d, Y @ G:i', $date );
	    	$mm = date( 'm', $date );
	    	$jj = date( 'd', $date );
	    	$aa = date( 'Y', $date );
	    	$hh = '00';
	    	$mn = '00';
	    }
	    ?>

	    <?php  
	    	$wrapper_class = 'div-' . $this->meta_key;
	    	$meta_id = substr( $this->meta_key, 1 );
	    ?>
	    <style>
		select.date-input, input.date-input{
			height: 21px;
			line-height: 14px;
			padding: 0;
			vertical-align: top;
			font-size: 12px;
		}
	    </style>
	    <div class="misc-pub-section <?php echo $wrapper_class; ?>" style="">
	    	<span id="<?php echo $meta_id; ?>"><?php echo $this->meta_label; ?>:<br> <b><?php echo $meta_display; ?></b></span> <a href="#<?php echo $meta_id; ?>" class="edit-<?php echo $meta_id; ?>">Edit</a>
	    	<div class="date-input-wrap" style="display:none;">
	    		<label for="mm_<?php echo $meta_id; ?>" class="screen-reader-text">Month</label>
	    		<select id="mm_<?php echo $meta_id; ?>" name="mm_<?php echo $meta_id; ?>" class="date-input">
					<option value="01" <?php echo $mm == '01'? 'selected' : '' ?>>01-Jan</option>
					<option value="02" <?php echo $mm == '02'? 'selected' : '' ?>>02-Feb</option>
					<option value="03" <?php echo $mm == '03'? 'selected' : '' ?>>03-Mar</option>
					<option value="04" <?php echo $mm == '04'? 'selected' : '' ?>>04-Apr</option>
					<option value="05" <?php echo $mm == '05'? 'selected' : '' ?>>05-May</option>
					<option value="06" <?php echo $mm == '06'? 'selected' : '' ?>>06-Jun</option>
					<option value="07" <?php echo $mm == '07'? 'selected' : '' ?>>07-Jul</option>
					<option value="08" <?php echo $mm == '08'? 'selected' : '' ?>>08-Aug</option>
					<option value="09" <?php echo $mm == '09'? 'selected' : '' ?>>09-Sep</option>
					<option value="10" <?php echo $mm == '10'? 'selected' : '' ?>>10-Oct</option>
					<option value="11" <?php echo $mm == '11'? 'selected' : '' ?>>11-Nov</option>
					<option value="12" <?php echo $mm == '12'? 'selected' : '' ?>>12-Dec</option>
				</select> 
				<label for="jj_<?php echo $meta_id; ?>" class="screen-reader-text">Day</label>
				<input type="text" id="jj_<?php echo $meta_id; ?>" name="jj_<?php echo $meta_id; ?>" value="<?php echo $jj; ?>" size="2" maxlength="2" autocomplete="off" class="date-input">, 
				<label for="aa_<?php echo $meta_id; ?>" class="screen-reader-text">Year</label>
				<input type="text" id="aa_<?php echo $meta_id; ?>" name="aa_<?php echo $meta_id; ?>" value="<?php echo $aa; ?>" size="4" maxlength="4" autocomplete="off" class="date-input date-input-year"> @ 
				<label for="hh_<?php echo $meta_id; ?>" class="screen-reader-text">Hour</label>
				<input type="text" id="hh_<?php echo $meta_id; ?>" name="hh_<?php echo $meta_id; ?>" value="<?php echo $hh; ?>" size="2" maxlength="2" autocomplete="off" class="date-input" readonly> : 
				<label for="mn_<?php echo $meta_id; ?>" class="screen-reader-text">Minute</label>
				<input type="text" id="mn_<?php echo $meta_id; ?>" name="mn_<?php echo $meta_id; ?>" value="<?php echo $mn; ?>" size="2" maxlength="2" autocomplete="off" class="date-input" readonly>
				<input type="hidden" name="fulldate_<?php echo $meta_id; ?>" value="<?php echo $meta_value; ?>">
				<p>
					<a href="#edit_<?php echo $meta_id; ?>" class="save-<?php echo $meta_id; ?> button">OK</a>
					<a href="#edit_<?php echo $meta_id; ?>" class="cancel-<?php echo $meta_id; ?> button-cancel">Cancel</a>
				</p>

			</div>
	    	
	    </div>

	    <script>
	    jQuery( document ).ready(function() {
	    	var wrapper_class = '<?php echo $wrapper_class; ?>';
	    	var meta_id = '<?php echo $meta_id; ?>';
		    //jQuery( '.<?php echo $wrapper_class; ?> .date-input-wrap' ).hide();
		    jQuery( '.edit-<?php echo $meta_id; ?>' ).on( 'click', function(e){
		    	e.preventDefault();
		    	jQuery( this ).hide();
		    	jQuery( '.<?php echo $wrapper_class; ?> .date-input-wrap' ).slideDown('fast');
		    } );
		    jQuery( '.cancel-<?php echo $meta_id; ?>' ).on( 'click', function(e){
		    	e.preventDefault();
		    	jQuery( '.edit-<?php echo $meta_id; ?>' ).show();
		    	jQuery( '.<?php echo $wrapper_class; ?> .date-input-wrap' ).slideUp('fast');
		    } );
		    jQuery( '.save-<?php echo $meta_id; ?>' ).bind( 'click', function(e){
		    	e.preventDefault();
		    	jQuery( '.edit-<?php echo $meta_id; ?>' ).show();
		    	jQuery( '.<?php echo $wrapper_class; ?> .date-input-wrap' ).slideUp('fast');
		    	month = jQuery( '#mm_<?php echo $meta_id; ?>' ).val();
		    	monthName = jQuery( '#mm_<?php echo $meta_id; ?> option:selected' ).html();
		    	monthName = monthName.substring( 3, 6 );
		    	day = jQuery( '#jj_<?php echo $meta_id; ?>' ).val();
		    	year = jQuery( '#aa_<?php echo $meta_id; ?>' ).val();
		    	hour = jQuery( '#hh_<?php echo $meta_id; ?>' ).val();
		    	mins = jQuery( '#mn_<?php echo $meta_id; ?>' ).val();
		    	fulldate = year + '-' + month + '-' + day + ' ' + hour + ':' + mins + ':' + '00';
		    	fulldateToShow = monthName + ' ' + day + ', ' + year + ' @ ' + hour + ':' + mins;
		    	jQuery( 'input[name="fulldate_<?php echo $meta_id; ?>"]' ).val( fulldate );
		    	jQuery( '#<?php echo $meta_id; ?> b' ).html( fulldateToShow );
		    } );
		});
	    </script>
	    <?php
	}

	/**
	 * [save_status description]
	 * @return [type] [description]
	 */
	public function save_meta( $post_id, $post, $update ) {
	    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		
		if ( isset( $_POST['post_type'] ) && in_array( $_POST['post_type'], $this->post_types_to_show ) )
		{
			if ( isset( $_POST["fulldate" . $this->meta_key] ) )
		    {

		    	update_post_meta($post_id, $this->meta_key, $_POST["fulldate" . $this->meta_key]);		
		    }
		}  
	}

	/**
	 * [save_meta_box_data description]
	 * @param  [type] $post_id [description]
	 * @return [type]          [description]
	 */
	public function save_meta_box_data( $post_id ) {

		/*
		 * We need to verify this came from our screen and with proper authorization,
		 * because the save_post action can be triggered at other times.
		 */
		// Check if our nonce is set.
		if ( ! isset( $_POST['myplugin_meta_box_nonce'] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $_POST['myplugin_meta_box_nonce'], 'myplugin_meta_box' ) ) {
			return;
		}

		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		/* OK, it's safe for us to save the data now. */
		
		// Make sure that it is set.
		foreach ( $this->fields as $field) {
		 	if ( ! isset( $_POST[ $field['name'] ] ) )
		 	{
		 		return;
		 	}
		}

		foreach ( $this->fields as $field ) {
			// Sanitize user input.
			$value = sanitize_text_field( $_POST[ $field['name'] ] );

			// Update the meta field in the database.
			update_post_meta( $post_id, $field['key'], $value );
		}
	}

	/**
	 * [status_css description]
	 * @return [type] [description]
	 */
	public function status_css() {
	?>

	<?php
	}


}