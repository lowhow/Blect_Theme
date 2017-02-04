<?php namespace Framework\Extensions;

class Mailer
{
	private $email_config;

	public function __construct( $email_config_array )
	{
		$this->email_config = $email_config_array;
	}

	/**
	 * [extension_template_method description]
	 * @return [type] [description]
	 */
	public function send() 
	{	
		$message = file_get_contents( $this->email_config['email_template'] );
		/* Message Body */
		$message = str_ireplace('{{title}}', $this->email_config['message_title'], $message);
		$message = str_ireplace('{{message}}', $this->email_config['message'], $message);

		$to = $this->email_config['to'];
		$subject = $this->email_config['subject'];
		$headers[] = 'From: '. $this->email_config['sender'];
		$headers[] = 'Content-Type: text/html; charset=UTF-8';
		$attachments = array();	
		if ( isset( $this->email_config['subject'] ) && ! empty( $this->email_config['subject'] ) )
			$attachments = $this->email_config['attachments'];	

		add_filter( 'wp_mail_content_type', array( $this, 'set_html_content_type' ) );

		$result = wp_mail( $to, $subject, $message, $headers, $attachments );

		remove_filter( 'wp_mail_content_type', array( $this, 'set_html_content_type' ) );

		return $result;
	}

	/**
	 * [set_html_content_type description]
	 */
	public function set_html_content_type() {
		return 'text/html';
	}
}