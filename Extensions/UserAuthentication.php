<?php namespace Framework\Extensions;
use Framework\Core\Observer as Observer;
use Framework\WordPress\Loader as Loader;

class UserAuthentication implements Observer
{
	private $loader;
	public $system_message;

	public function __construct( Loader $loader )
	{
		$this->loader = $loader;
	}

	public function handle() 
	{
		$this->loader
		->add_action('template_redirect', $this, 'log_in')
		->add_action('template_redirect', $this, 'verify_password_reset')
		->add_action('template_redirect', $this, 'reset_password')
		->add_action('template_redirect', $this, 'send_password_reset_link')
		->add_action('fw_user_authentication_system_message', $this, 'system_message');
		
		// add_shortcode( 'fw_login_form', array( $this, 'login_form' ) );

		return $this;
	}

	public function system_message()
	{
		$message = '';
		if ( isset( $this->system_message['error'] ) )
		{
			$message = implode('<br>', $this->system_message['error'] );
			$message = '<div class="alert alert-danger">' . $message . '</div>';		
		}
		elseif( isset( $this->system_message['success'] ) )
		{
			$message = implode('<br>', $this->system_message['success'] );
			$message = '<div class="alert alert-success">' . $message . '</div>';	
		}
		echo $message;
	}

	/**
	 * Log in the user.
	 * 
	 * Needs POST Data as below:
	 * $_POST['user_login'], 
	 * $_POST['user_pass'], 
	 * wp_verify_nonce( $_POST['login_nonce'] to match 'login-nonce' wp_nonce.
	 * @return [type] [description]
	 */
	public function log_in()
	{
		if( isset( $_POST['user_login'] ) && wp_verify_nonce( $_POST['login_nonce'], 'login-nonce') ) 
		{
			/** Error when no password enter */
			if( ! isset( $_POST['user_pass']) || $_POST['user_pass'] == '') {
				$this->system_message['error'][] = __('Please enter a password');
				return false;
			}
	 		
			// this returns the user ID and other info from the user name
			$user = get_user_by('login', $_POST['user_login'] );
 
			if( ! $user ) 
			{				
				$this->system_message['error'][] = __('Invalid ID or password');
				return false;
			}
	 
			// check the user's login with their password
			if( ! wp_check_password( $_POST['user_pass'], $user->user_pass, $user->ID) ) {
				// if the password is incorrect for the specified user
				$this->system_message['error'][] = __('Invalid ID or password');
			}
	 
			// only log the user in if there are no errors
			if( empty( $this->system_message['error'] )) 
			{
				wp_set_auth_cookie( $user->ID, false, true );
				wp_set_current_user( $user->ID );	
				do_action('wp_login', $_POST['user_login']);
	 
				wp_redirect( home_url() ); exit;
			}
		}
	}

	public function reset_password()
	{
		if ( isset( $_POST['user_pass'] ) && $_POST['user_pass'] !== '' && 
			isset( $_POST['user_pass_confirm'] ) && $_POST['user_pass_confirm'] !== '' && 
			wp_verify_nonce( $_POST['resetpassword_nonce'], 'resetpassword-nonce') && is_page('forgot-password') )
		{

			$user = get_user_by('id', $_POST['user_id'] );

			if ( ! $user )
			{
				$this->system_message['error'][] = __('Invalid user.');
				return false;
			}

			if( empty( $this->system_message['error'] ) ) 
			{
				delete_user_meta( $user->ID, 'password_reset');
				wp_set_password( $_POST['user_pass'], $user->ID );
				wp_set_auth_cookie( $user->ID, false, true );
				wp_set_current_user( $user->ID );	
				do_action('wp_login', $user->user_login );

				wp_redirect( home_url() ); exit;
			}
		}
	}

	/**
	 * Verify password reset link.
	 * @return [type] [description]
	 */
	public function verify_password_reset()
	{		
		if ( is_page('forgot-password') && isset( $_GET['user'] ) && isset( $_GET['reset_key'] ) && $_GET['user'] !== '' && $_GET['reset_key'] !== '' && ! isset( $_POST['resetpassword_nonce'] )  )
		{
			$user = get_user_by('id', trim( $_GET['user'] ) );
			if ( ! $user )
			{
				//$this->system_message['error'][] = __('Invalid user');
				//wp_redirect( get_permalink( get_page_by_path( 'forgot-password' ) ) );
				$this->system_message['error'][] = __('Link no longer valid. Please request for another.');	
				// get_template_part('reset-password');
				//exit;
				return false;
			}

			$password_reset = get_user_meta( $user->ID, 'password_reset', true );
			if ( ! isset( $password_reset['key'] ) || $password_reset['key'] !== trim( $_GET['reset_key'] ) )
			{
				//$this->system_message['error'][] = __('Invalid key');
				//wp_redirect( get_permalink( get_page_by_path( 'forgot-password' ) ) );
				$this->system_message['error'][] = __('Link no longer valid. Please request for another.');	
				// get_template_part('reset-password');
				// exit;
				return false;
			}

			$blogtime = current_time( 'timestamp' ); 

			if ( ! isset( $password_reset['expiration'] ) || $blogtime >= $password_reset['expiration'] )
			{
				//$this->system_message['error'][] = __('Expired link');
				//wp_redirect( get_permalink( get_page_by_path( 'forgot-password' ) ) );
				$this->system_message['error'][] = __('Link no longer valid. Please request for another.');	
				//get_template_part('reset-password');
				//exit;
				return false;
			}	
			
			//wp_redirect( get_permalink( get_page_by_path( 'reset-password' ) ) );
			$this->system_message['success'][] = __('Please enter your new password.');	
			get_template_part('reset-password');
			exit;
		}

		if ( is_page('forgot-password') && isset( $_POST['resetpassword_nonce'] ) && ! wp_verify_nonce( $_POST['resetpassword_nonce'], 'resetpassword-nonce') )
		{
			$this->system_message['error'][] = __('Invalid link. Please request for another.');	
			return false;
		}
	}

	/**
	 * Forgot Password
	 * @return [type] [description]
	 */
	public function send_password_reset_link()
	{
		if( isset( $_POST['user_email'] ) && wp_verify_nonce( $_POST['forgotpassword_nonce'], 'forgotpassword-nonce') ) 
		{
			$email = trim( $_POST['user_email'] );
			// this returns the user ID and other info from the user name
			$user = get_user_by('email', $email );

			if( ! $user ) 
			{				
				$this->system_message['error'][] = __('Invalid email');
				return false;
			}

			$key = $this->generate_unique_key( $email );

			$blogtime = current_time( 'timestamp' ); 

			$expiration = strtotime('+7 days', $blogtime); // 7 days to expiration.

			$args = array(
				'key'			=> $key,
				'expiration'	=> $expiration,
			);
			$usermeta_added = update_user_meta( $user->ID, 'password_reset', $args );

			if ( ! $usermeta_added )
			{
				$this->system_message['error'][] = __('Request to reset password failed.');
				return false;
			}

			$args = array(
				'email_template' 	=> trailingslashit( FW_DIR ) . 'EmailTemplates/default.php',
				'sender'			=> 'BLECT Solution <no-reply@blect.info>',
				'to'				=> array( 'low how <lowhow@gmail.com>' ),
				'subject'	 		=> 'Request for Password Reset',
				'message_title'		=> '',
				'message'			=> $this->get_reset_password_mail_content( $user ),
				'attachments'		=> array(),
			);
			$mailer = new Mailer( $args );
			$result = $mailer->send();

			if ( !$result )
			{
				$this->system_message['error'][] = __('Failed to send password reset link.');
				return false;
			}

			$pos = strpos( $email, '@');

          	$deformed_email = substr_replace( $email, '**********', 0, $pos );
            $this->system_message['success'][] = __('Reset link has been sent to ' . $deformed_email );
		}
	}

	/**
	 * Email content used when sending password reset link
	 * @param  [type] $user [description]
	 * @return [type]       [description]
	 * @todo Write better reset message.
	 */
	private function get_reset_password_mail_content( $user )
	{
		$password_reset = get_user_meta( $user->ID, 'password_reset', true );
		$password_reset_url = trailingslashit( home_url('forgot-password') ). '?user=' . $user->ID . '&reset_key=' . $password_reset['key'];
		ob_start(); ?> 
		
		<tr>
  			<!-- Hero headline goes here. Manually add <br /> to insert line breaks to fine tune. -->
  			<td class="inner-width" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 18px; color: #ffffff;">
  				<br>
				Dear <?php echo $user->user_nicename; ?>,<br><br>
				Please follow the link below to reset your password.
  			</td>
  		</tr>
  		<tr>
  			<!-- Hero button -->
  			<td class="inner-width" style="padding-top: 25px;">
  				<div style="text-align:center;">
	  				<!--[if mso]>
					<v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="<?php echo $password_reset_url; ?>" style="height: 44px; v-text-anchor: middle; width: 172px;" arcsize="12%" strokecolor="#ff4200" fillcolor="#ff4200">
					<w:anchorlock/>
					<center style="color: #ffffff; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: bold;">Reset Password</center>
					</v:roundrect>
					<![endif]-->
					<a href="<?php echo $password_reset_url; ?>" style="background-color: #ff4200; border: 1px solid #ff4200; border-radius: 5px; color: #ffffff; display: inline-block; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: bold; line-height: 44px; text-align: center; text-decoration: none; width: 172px; -webkit-text-size-adjust: none; mso-hide: all;">Reset Password</a>
				</div>
  			</td>
  		</tr>
		<?php
		return ob_get_clean();
	}

	/**
	 * [generate_unique_key description]
	 * @param  [type] $key [description]
	 * @return [type]      [description]
	 */
	private function generate_unique_key( $key )
	{
		$salt = wp_generate_password( 20 );
		$key = sha1( $salt . $key . uniqid( time(), true ) );
		return $key;
	}


	public function register_user()
	{
		// register a user.
	}

	public function activate_user()
	{

	}
}