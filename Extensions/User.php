<?php namespace Framework\Extensions;
use Framework\Core\Observer as Observer;
use Framework\WordPress\Loader as Loader;

class User implements Observer
{
	private $loader;
	public $login_messages;
	private $tomsapi;

	public function __construct( Loader $loader )
	{
		$this->loader = $loader;
	}

	public function handle() 
	{
		$this->loader
		->add_action('init', $this, 'login_member');;
		
		add_shortcode( 'fw_login_form', array( $this, 'login_form' ) );

		return $this;
	}

	/**
	 * [login_form description]
	 * @return [type] [description]
	 */
	public function login_form()
	{
		if ( !is_user_logged_in() ) 
		{ 
			$output = $this->login_form_fields();
		} else {
			// could show some logged in user info here
			 $output = 'user already logged in.';
		}
		return $output;
	}

	/**
	 * [login_form_fields description]
	 * @return [type] [description]
	 */
	public function login_form_fields() 
	{
		ob_start(); ?> 
		<?php var_dump( $this->login_messages ); ?>
 
		<form class="form-horizontal margin-bottom-2x" role="form" name="loginform" id="loginform" action="" method="post">
		    <div class="form-group">
		        <label class="sr-only" for="user_login">Username</label>
		        <div class="input-group">
		            <div class="input-group-addon"><i class="fa fa-fw fa-user"></i></div>
		            <input type="text" class="form-control" name="user_login" id="user_login" value="" size="20" placeholder="Username" value="">
		        </div>
		    </div>

		    <div class="form-group">
		        <label class="sr-only" for="user_pass">Password</label>
		        <div class="input-group">
		            <div class="input-group-addon"><i class="fa fa-fw fa-asterisk"></i></div>
		            <input type="password" class="form-control" name="user_pass" id="user_pass" class="input" value="" size="20" placeholder="Password">
		        </div>
		    </div>

		    <div class="form-inline text-center margin-top-1x">
		      	<div class="row">
		      		<div class="col-sm-4 padding-left-0 padding-right-0">
		      			<a href="<?php echo esc_url( home_url( '/forgot-password' ) ); ?>" class="">Forgot Password</a><span class="hidden-xs pull-right">|</span>
		      		</div>
		      		<div class="col-sm-4 padding-left-0 padding-right-0">
		      			<a href="" class=""> First Time Login</a><span class="hidden-xs pull-right">|</span>
		      		</div>
		      		<div class="col-sm-4 padding-left-0 padding-right-0">
		      			<a href="" class="">Unlock User ID</a>
		      		</div>
		      	</div>
		    </div>

		    <button type="submit" class="btn btn-warning btn-lg padding-left-2x padding-right-2x aligncenter margin-top-1x" name="wp-submit" id="wp-submit">Log in</button>
		    <input type="hidden" name="login_nonce" value="<?php echo wp_create_nonce('login-nonce'); ?>"/>
		    <input type="hidden" name="redirect_to" value="<?php echo esc_url( home_url() ) ?>">
		</form>

		<?php
		return ob_get_clean();
	}

	/**
	 * [login_member description]
	 * @return [type] [description]
	 */
	public function login_member() 
	{
		if( isset( $_POST['user_login'] ) && wp_verify_nonce( $_POST['login_nonce'], 'login-nonce') ) {

			/** Error when no password enter */
			if( ! isset( $_POST['user_pass']) || $_POST['user_pass'] == '') {
				$this->login_messages['error'][] = __('Please enter a password');
				return false;
			}



			/**
			 * Authenticate with Toms
			 */

	 		
			// this returns the user ID and other info from the user name
			$user = get_user_by('login', $_POST['user_login'] );
 
			if( ! $user) 
			{				
				$this->login_messages['error'][] = __('Invalid ID or password');
			}
	 
			// check the user's login with their password
			if( ! wp_check_password( $_POST['user_pass'], $user->user_pass, $user->ID) ) {
				// if the password is incorrect for the specified user
				$this->login_messages['error'][] = __('Invalid ID or password');
			}
	 
			// only log the user in if there are no errors
			if( empty( $this->login_messages['error'] )) {
	 
				wp_set_auth_cookie( $user->ID, false, true );
				wp_set_current_user( $user->ID );	
				do_action('wp_login', $_POST['user_login']);
	 
				wp_redirect(home_url()); exit;
			}
		}
	}
}