<?php namespace Framework\Core;

abstract class CustomPostType implements Observer
{
	private $post_type; // (max. 20 characters, can not contain capital letters or spaces)
	private $plural_name;
	private $slug;
	private $labels;


	public function __construct( $post_type, $plural_name, $slug = null )
	{
		$this->post_type 		= $post_type;
		$this->plural_name 		= $plural_name;
		$this->slug				= $slug;
	}


	public function handle() 
	{	
		$this->construct_labels();
		add_action( 'init', array( $this, 'custom_post_type_init' ) );
		add_filter( 'post_updated_messages', array( $this, 'custom_post_type_updated_messages' ) );
		add_action( 'contextual_help', array( $this, 'custom_type_post_add_help_text' ), 10, 3 );

		return $this;
	}


	public function construct_labels()
	{
		$this->labels 			= array(
			'name'               => _x( ucFirst( $this->plural_name ), 'post type general name', FW_TEXTDOMAIN ),
			'singular_name'      => _x( ucFirst( $this->post_type ), 'post type singular name', FW_TEXTDOMAIN ),
			'menu_name'          => _x( ucFirst( $this->plural_name ), 'admin menu', FW_TEXTDOMAIN ),
			'name_admin_bar'     => _x( ucFirst( $this->post_type ), 'add new on admin bar', FW_TEXTDOMAIN ),
			'add_new'            => _x( 'Add New', $this->post_type, FW_TEXTDOMAIN ),
			'add_new_item'       => __( 'Add New ' . ucFirst( $this->post_type ), FW_TEXTDOMAIN ),
			'new_item'           => __( 'New ' . ucFirst( $this->post_type ), FW_TEXTDOMAIN ),
			'edit_item'          => __( 'Edit ' . ucFirst( $this->post_type ), FW_TEXTDOMAIN ),
			'view_item'          => __( 'View ' . ucFirst( $this->post_type ), FW_TEXTDOMAIN ),
			'all_items'          => __( 'All ' . ucFirst( $this->plural_name ), FW_TEXTDOMAIN ),
			'search_items'       => __( 'Search ' . ucFirst( $this->plural_name ), FW_TEXTDOMAIN ),
			'parent_item_colon'  => __( 'Parent ' . ucFirst( $this->plural_name ) . ':', FW_TEXTDOMAIN ),
			'not_found'          => __( 'No ' . $this->plural_name . ' found. ', FW_TEXTDOMAIN ),
			'not_found_in_trash' => __( 'No ' . $this->plural_name . ' found in Trash.', FW_TEXTDOMAIN )
		);
	}


	/**
	 * Register Post Type
	 * @return [type] [description]
	 */
	public function custom_post_type_init() 
	{
		$args = array(
			'labels'             => $this->labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => $this->slug ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
		);

		register_post_type( $this->post_type, $args );

		return $this;
	}


	/**
	 * Customizing messages
	 * @param  [type] $messages [description]
	 * @return [type]           [description]
	 */
	public function custom_post_type_updated_messages( $messages )
	{
		$post             = get_post();
		$post_type        = get_post_type( $post );
		$post_type_object = get_post_type_object( $post_type );

		$messages[ $this->post_type ] = array(
			0  => '', // Unused. Messages start at index 1.
			1  => __( ucFirst( $this->post_type ) .' updated.', FW_TEXTDOMAIN ),
			2  => __( 'Custom field updated.', FW_TEXTDOMAIN ),
			3  => __( 'Custom field deleted.', FW_TEXTDOMAIN ),
			4  => __( ucFirst( $this->post_type ) . ' updated.', FW_TEXTDOMAIN ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( __( ucFirst( $this->post_type ) . ' restored to revision from %s', FW_TEXTDOMAIN ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6  => __( ucFirst( $this->post_type ) . ' published.', FW_TEXTDOMAIN ),
			7  => __( ucFirst( $this->post_type ) . ' saved.', FW_TEXTDOMAIN ),
			8  => __( ucFirst( $this->post_type ) . ' submitted.', FW_TEXTDOMAIN ),
			9  => sprintf(
				__( ucFirst( $this->post_type ) . ' scheduled for: <strong>%1$s</strong>.', FW_TEXTDOMAIN ),
				// translators: Publish box date format, see http://php.net/date
				date_i18n( __( 'M j, Y @ G:i', FW_TEXTDOMAIN ), strtotime( $post->post_date ) )
			),
			10 => __( ucFirst( $this->post_type )  . ' draft updated.', FW_TEXTDOMAIN )
		);

		if ( $post_type_object->publicly_queryable ) {
			$permalink = get_permalink( $post->ID );

			$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View ' . $this->post_type, FW_TEXTDOMAIN ) );
			$messages[ $post_type ][1] .= $view_link;
			$messages[ $post_type ][6] .= $view_link;
			$messages[ $post_type ][9] .= $view_link;

			$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
			$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview ' . $this->post_type, FW_TEXTDOMAIN ) );
			$messages[ $post_type ][8]  .= $preview_link;
			$messages[ $post_type ][10] .= $preview_link;
		}

		return $messages;
	}


	/**
	 * Adding contextual help
	 * @param  [type] $contextual_help [description]
	 * @param  [type] $screen_id       [description]
	 * @param  [type] $screen          [description]
	 * @return [type]                  [description]
	 */
	public function custom_type_post_add_help_text( $contextual_help, $screen_id, $screen )
	{
		//$contextual_help .= var_dump( $screen ); // use this to help determine $screen->id
		if ( $this->post_type == $screen->id ) {
			$contextual_help =
			'<p>' . __('Things to remember when adding or editing a book:', FW_TEXTDOMAIN) . '</p>' .
			'<ul>' .
			'<li>' . __('Specify the correct genre such as Mystery, or Historic.', FW_TEXTDOMAIN) . '</li>' .
			'<li>' . __('Specify the correct writer of the book.  Remember that the Author module refers to you, the author of this book review.', FW_TEXTDOMAIN) . '</li>' .
			'</ul>' .
			'<p>' . __('If you want to schedule the book review to be published in the future:', FW_TEXTDOMAIN) . '</p>' .
			'<ul>' .
			'<li>' . __('Under the Publish module, click on the Edit link next to Publish.', FW_TEXTDOMAIN) . '</li>' .
			'<li>' . __('Change the date to the date to actual publish this article, then click on Ok.', FW_TEXTDOMAIN) . '</li>' .
			'</ul>' .
			'<p><strong>' . __('For more information:', FW_TEXTDOMAIN) . '</strong></p>' .
			'<p>' . __('<a href="http://codex.wordpress.org/Posts_Edit_SubPanel" target="_blank">Edit Posts Documentation</a>', FW_TEXTDOMAIN) . '</p>' .
			'<p>' . __('<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>', FW_TEXTDOMAIN) . '</p>' ;
		} elseif ( 'edit-' . $this->post_type == $screen->id ) {
			$contextual_help =
			'<p>' . __('This is the help screen displaying the table of books blah blah blah.', FW_TEXTDOMAIN) . '</p>' ;
		}

		return $contextual_help;
	}

}