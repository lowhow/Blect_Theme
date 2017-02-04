<?php namespace Framework\Extensions\Projectname;
use Framework\Core\Observer as Observer;
use Framework\WordPress\Loader as Loader;

class Router implements Observer
{
	private $loader;

	public function __construct( Loader $loader )
	{
		$this->loader = $loader;
	}

	public function handle() 
	{
		$this->loader
		->add_action( 'template_redirect', $this, 'routing_rules' )
		->add_action( 'admin_init', $this, 'restrict_admin_with_redirect', 1 );

		return $this;
	}

	/**
	 * [restrict_admin_with_redirect description]
	 * @return [type] [description]
	 */
	public function restrict_admin_with_redirect()
	{
		// if ( ! current_user_can( 'manage_options' ) && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
		// 	wp_redirect( home_url() ); 
		// 	exit;
		// }
	}

	/**
	 * [extension_template_method description]
	 * @return [type] [description]
	 */
	public function routing_rules() 
	{	
		// if ( ! is_user_logged_in() && ! is_page( array('login', 'forgot-password', 'first-time-login') ) )
		// {
		// 	wp_redirect( get_permalink( get_page_by_path( 'login' ) ) );
		// 	exit;
		// }
		// elseif( is_user_logged_in() && is_page( array('login', 'forgot-password', 'first-time-login') ) )
		// {
		// 	wp_redirect( home_url() );
		// 	exit;
		// }
	}

}