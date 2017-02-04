<?php namespace Framework\Core;
use Framework\WordPress\Loader as Loader;

class MetaBox
{	
	private $id;
	private $title;
	private $callback;
	private $context;
	private $priority;
	private $screens;
	private $callback_args;
	private $loader;
	

	public function __construct( Loader $loader, $metaboxArgs )
	{	
		$this->loader = $loader;

		if ( !isset( $metaboxArgs ) )
		{
			return;
		}

		$this->id 				= $metaboxArgs['id'];
		$this->title 			= $metaboxArgs['title'];
		$this->context 			= $metaboxArgs['context'];
		$this->screens 			= $metaboxArgs['post_type'];
		$this->priority 		= $metaboxArgs['priority'];
		$this->callback 		= $metaboxArgs['callback'];
		$this->fields 			= $metaboxArgs['fields'];

		$this->loader
		->add_action( 'add_meta_boxes', $this, 'add' )
		->add_action( 'save_post', $this, 'save_meta_box_data' );
	}


	public function add()
	{
		foreach ( $this->screens as $screen ) 
		{
			add_meta_box( $this->id, $this->title, $this->callback, $screen, $this->context, $this->priority );
		}
	}


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

}