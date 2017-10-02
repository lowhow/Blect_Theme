<?php namespace Extensions\Projectname;
use \Framework\Core\Observer as Observer;
use \Framework\WordPress\Loader as Loader;

class Ajax implements Observer
{
	private $loader;

	public function __construct( Loader $loader )
	{
		$this->loader = $loader;
	}

	public function handle() 
	{
		$this->loader
		->add_action( 'wp_footer', $this, 'my_action_javascript', 100 )
		->add_action( 'wp_ajax_my_action', $this, 'my_action_callback');

		return $this;
	}

	/**
	 * [my_action_javascript description]
	 * @return [type] [description]
	 */
	public function my_action_javascript() {
		//Set Your Nonce
		$ajax_nonce = wp_create_nonce( 'nonce_string_for_ajax' );
		?>
		<script>
		jQuery( document ).ready( function( $ ) {

			var data = {
				action: 'my_action',
				security: jqueryAjax.security,
				whatever: 1234
			};

			// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
			$.post( jqueryAjax.ajaxurl, data, function(response) {
			    console.log('ajax response: ' + response);
			});
		});
		</script>
		<?php
	}

	/**
	 * [my_action_callback description]
	 * @return [type] [description]
	 */
	function my_action_callback() {
		check_ajax_referer( 'nonce_string_for_ajax', 'security' );

		$whatever = intval( $_POST['whatever'] );
		echo $whatever;
		die(); // this is required to return a proper result
	}

}
