<?php namespace Framework\Extensions;
use Framework\Core\Observer as Observer;
use Framework\WordPress\Loader as Loader;

class JQueryAjaxify implements Observer
{
	private $loader;

	public function __construct( Loader $loader )
	{
		$this->loader = $loader;
	}

	public function handle() 
	{
		$this->loader
		->add_action( 'wp_enqueue_scripts', $this, 'enqueue_ajax_scripts' );

		return $this;
	}

	/**
	 * [enqueue_ajax_and_ng_scripts description]
	 * @return [type] [description]
	 */
	public function enqueue_ajax_scripts()
	{
		// Using application-js as handler.
		wp_localize_script( 'application-js', 'jqueryAjax', array(
		    // URL to wp-admin/admin-ajax.php to process the request
		    'ajaxurl' => admin_url( 'admin-ajax.php' ),

		    // generate a nonce with a unique ID "myajax-post-comment-nonce"
		    // so that you can check it later when an AJAX request is sent
		    'security' => wp_create_nonce( 'nonce_string_for_ajax' )
		));

		return $this;
	}
}