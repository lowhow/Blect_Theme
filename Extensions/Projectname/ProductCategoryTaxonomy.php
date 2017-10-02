<?php namespace Extensions\Projectname;
use \Framework\Core\Observer as Observer;
use \Framework\WordPress\Loader as Loader;

class ProductCategoryTaxonomy implements Observer
{
	private $taxonomy; // (max. 20 characters, can not contain capital letters or spaces)
	private $plural_name;
	private $slug;
	private $loader;
	private $post_type;

	public function __construct( Loader $loader, $taxonomy, $plural_name, $slug = null, $post_type = array() )
	{
		$this->loader = $loader;
		$this->taxonomy 		= $taxonomy;
		$this->plural_name 		= $plural_name;
		$this->slug				= $slug;
		$this->post_type 		= $post_type;
	}

	public function handle()
	{
		$this->loader
		->add_action( 'init', $this, 'taxonomy_init' );
		/** Use this to seed Notabilities terms */
		//$this->loader->add_action( 'init', $this, 'create_default_terms' );
		return $this;
	}

	/**
	 * Register Post Type
	 * @return [type] [description]
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	public function taxonomy_init()
	{
		$labels 			= array(
			'name'               => _x( ucFirst( $this->plural_name ), 'post type general name', FW_TEXTDOMAIN ),
			'singular_name'      => _x( ucFirst( $this->taxonomy ), 'post type singular name', FW_TEXTDOMAIN ),
			'search_items'       => _x( 'Search ' . ucFirst( $this->plural_name ), FW_TEXTDOMAIN ),
			'popular_items'       => _x( 'Popular ' . ucFirst( $this->plural_name ), FW_TEXTDOMAIN ),
			'all_items'          => __( 'All ' . ucFirst( $this->plural_name ), FW_TEXTDOMAIN ),
			'parent_item' 	 	 => NULL,
			'parent_item_colon'  => NULL,
			'edit_item'          => __( 'Edit ' . ucFirst( $this->taxonomy ), FW_TEXTDOMAIN ),
			'add_new_item'       => __( 'Add New ' . ucFirst( $this->taxonomy ), FW_TEXTDOMAIN ),
			'new_item_name'      => __( 'New ' . ucFirst( $this->taxonomy ) . ' Name', FW_TEXTDOMAIN ),
			'separate_items_with_commas' => __( 'Separate ' . ucFirst( $this->plural_name ) . ' with commas', 'textdomain' ),
			'add_or_remove_items'        => __( 'Add or  ' . ucFirst( $this->plural_name ) . '  writers', 'textdomain' ),
			'choose_from_most_used'      => __( 'Choose from the most used ' . $this->plural_name, 'textdomain' ),
			'not_found'          => __( 'No ' . $this->plural_name . ' found. ', FW_TEXTDOMAIN ),
			'menu' 				=> __( ucFirst( $this->plural_name ), FW_TEXTDOMAIN )
		);

		$args = array(
			'labels'             	=> $labels,
			'public'             	=> true,
			'show_ui'            	=> true,
			'show_admin_column' 	=> true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'          	=> true,
			'rewrite'            	=> array( 'slug' => $this->slug ),
			'hierarchical'       	=> false,
		);

		register_taxonomy( $this->taxonomy, $this->post_type, $args );

		return $this;
	}

	public function create_default_terms()
	{
		if ( !term_exists( 'New', $this->taxonomy ) )
		{
			wp_insert_term(
				'New',
				$this->taxonomy,
				array(
					'slug'	=> 'new'
				)
			);
		}

		if ( !term_exists( 'Hot Selling', $this->taxonomy ) )
		{
			wp_insert_term(
				'Hot Selling',
				$this->taxonomy,
				array(
					'slug'	=> 'hot-selling'
				)
			);
		}

		if ( !term_exists( 'Featured', $this->taxonomy ) )
		{
			wp_insert_term(
				'Featured',
				$this->taxonomy,
				array(
					'slug'	=> 'featured'
				)
			);
		}

		if ( !term_exists( 'Recommended', $this->taxonomy ) )
		{
			wp_insert_term(
				'Recommended',
				$this->taxonomy,
				array(
					'slug'	=> 'recommended'
				)
			);
		}
	}
}
