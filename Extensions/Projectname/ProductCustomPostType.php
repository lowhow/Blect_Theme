<?php namespace Extensions\Projectname;
use \Framework\Core\CustomPostType as CustomPostType;
use \Framework\Core\Observer as Observer;
use \Framework\WordPress\Loader as Loader;

class ProductCustomPostType extends CustomPostType  implements Observer
{
	private $post_type; // (max. 20 characters, can not contain capital letters or spaces)
	private $plural_name;
	private $slug;
	private $loader;

	public function __construct( Loader $loader, $post_type, $plural_name, $slug = null )
	{
		$this->loader = $loader;
		$this->post_type 		= $post_type;
		$this->plural_name 		= $plural_name;
		$this->slug				= $slug;
	}

	public function handle()
	{
		$this->loader
		->add_action( 'init', $this, 'custom_post_type_init' );
		remove_filter( 'the_content', 'wpautop' );
        add_filter( 'the_content', 'wpautop', 99 );
        add_filter( 'the_content', 'shortcode_unautop', 100 );

		return $this;
	}

	/**
	 * Register Post Type
	 * @return [type] [description]
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	public function custom_post_type_init()
	{
		$labels 			= array(
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

		$args = array(
			'desciption' 		 	=> 'Create Product',
			'labels'             	=> $labels,
			'public'             	=> true,
			'show_in_rest' 			=> true,
			'exclude_from_search'	=> false,
			'publicly_queryable' 	=> true,
			'show_ui'            	=> true,
			'show_in_nav_menus' 	=> false,
			'show_in_menu'       	=> true,
			'show_in_admin_bar' 	=> true,
			'menu_position'			=> '21.5',
			'menu_icon' 			=> 'dashicons-screenoptions',
			'query_var'          	=> true,
			'rewrite'            	=> array( 'slug' => $this->post_type, 'with_front' => FALSE ),
			'capability_type'    	=> 'post',
			'has_archive'        	=> true,
			'hierarchical'       	=> false,
			'supports'           	=> array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		);

		register_post_type( $this->post_type, $args );

		return $this;
	}
}
