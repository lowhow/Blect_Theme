<?php namespace Extensions;
use \Framework\Core\CustomPostType as CustomPostType;
use \Framework\Core\Observer as Observer;
use \Framework\WordPress\Loader as Loader;

class SliderCustomPostType extends CustomPostType  implements Observer
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
		->add_action( 'init', $this, 'custom_post_type_init' )
		->add_action( 'init', $this, 'register_acf_field_group' )
		->add_action( 'wp_footer', $this, 'action_javascript', 100 )
		->add_filter( 'manage_slider_posts_columns', $this, 'add_new_column_headers' )
		->add_action( 'manage_slider_posts_custom_column', $this, 'add_new_column_columns', 10, 2 )
		->add_filter( 'acf/load_value/name=slider_shortcode', $this, 'generate_shortcode_snippet', 10, 3 );

		add_shortcode( 'fw_slider', array( $this, 'slider_shortcode' ) );
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
			'desciption' 		 	=> 'Create slider',
			'labels'             	=> $labels,
			'public'             	=> false,
			'exclude_from_search'	=> true,
			'publicly_queryable' 	=> false,
			'show_ui'            	=> true,
			'show_in_nav_menus' 	=> false,
			'show_in_menu'       	=> true,
			'show_in_admin_bar' 	=> false,
			'menu_position'			=> 21,
			'menu_icon' 			=> 'dashicons-images-alt2',
			'query_var'          	=> false,
			'rewrite'            	=> false ,
			'capability_type'    	=> 'page',
			'has_archive'        	=> false,
			'hierarchical'       	=> false,
			'supports'           	=> array( 'title' )
		);

		register_post_type( $this->post_type, $args );

		return $this;
	}

	/**
	 * [add_new_column_headers description]
	 * @param [type] $columns [description]
	 * @link(_blank, http://www.smashingmagazine.com/2013/12/05/modifying-admin-post-lists-in-wordpress/)
	 */
	public function add_new_column_headers( $columns )
	{
	    $new_columns = array(
	    	'slider_shortcode' => 'Shortcode',
	    );

	    $first_array = array_splice( $columns, 0, 2 );
	    $columns = array_merge( $first_array, $new_columns, $columns );

	    return $columns;
	}

	/**
	 * [add_new_column_columns description]
	 * @param [type] $column_name [description]
	 * @param [type] $post_id     [description]
	 * @link(_blank, http://www.smashingmagazine.com/2013/12/05/modifying-admin-post-lists-in-wordpress/)
	 */
	public function add_new_column_columns( $column_name, $post_id )
	{
	    if ($column_name == 'slider_shortcode')
	    {
	    	$post_arr = get_post( $post_id, ARRAY_A );
	    	echo '[fw_slider slug="' . $post_arr['post_name'] . '"]';
	    }
	}

	/**
	 * [action_javascript description]
	 * @return [type] [description]
	 */
	public function action_javascript()
	{
		?>
		<script>
		jQuery( window ).load( function( $ ) {
			var $flexslider = jQuery('.flexslider');
			if( $flexslider.length > 0 ){
				jQuery('.flexslider').flexslider({
	    			animation: "slide"
	  			});
			}
		});
		</script>
		<?php
	}

	/**
	 * [slider_shortcode description]
	 * @param  [type] $atts    [description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	public function slider_shortcode( $atts, $content )
	{
		$args = array(
			'name'           	=> $atts['slug'],
			'post_type'			=> 'slider',
			'post_status'		=> 'publish',
			'posts_per_page'	=> 1,
		);
		$slider_posts = new \WP_Query( $args );

		if ( ! isset( $slider_posts ) || empty( $slider_posts ) )
			return false;

		global $post;
		$slide_arr = array();
		if ( $slider_posts->have_posts() ) :
			while ( $slider_posts->have_posts() ) : $slider_posts->the_post();
				if( have_rows('slide_item') ):
				    while ( have_rows('slide_item') ) : the_row();

						/** if not published skip to next */
						if ( get_sub_field('status') !== 'published' )
							continue;

						if ( get_sub_field('use_html_content') )
						{
							$slide_arr[] = '<li class="slidewrap">' . get_sub_field('slide_content') . '</li>';
						}
						else
						{
							$slide_img = '<img src="' . get_sub_field('slide_img') . '" />';
							$target = '';
							if ( get_sub_field('open_in_new_window') )
								$target = 'target="_blank"';
							if ( get_sub_field('target_url') )
								$slide_img = '<a href="' . get_sub_field('target_url') . '" ' . $target . '>' . $slide_img . '</a>';

							$slide_arr[] = '<li class="slidewrap">' . $slide_img . '</li>';
						}

					endwhile;
				endif;
			endwhile;
		endif;
		wp_reset_postdata();

		ob_start();
		?>
		<div id="flexslider-<?php echo $atts['slug']; ?>" class="flexslider">
			<ul class="slides">
				<?php echo implode( '', $slide_arr );  ?>
			</ul>
		</div>
		<?php
    	return ob_get_clean();
	}

	/**
	 * [register_acf_field_group description]
	 * @return [type] [description]
	 */
	public function register_acf_field_group()
	{
		if( function_exists('acf_add_local_field_group') ):

		acf_add_local_field_group(array (
			'key' => 'group_559bebb56ce51',
			'title' => 'Slides',
			'fields' => array (
				array (
					'key' => 'field_559c38eba4b9d',
					'label' => 'Slider Shortcode',
					'name' => 'slider_shortcode',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 1,
					'disabled' => 1,
				),
				array (
					'key' => 'field_559bebcb76c47',
					'label' => 'Slide Item',
					'name' => 'slide_item',
					'type' => 'repeater',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'min' => 1,
					'max' => '',
					'layout' => 'row',
					'button_label' => 'Add slide',
					'sub_fields' => array (
						array (
							'key' => 'field_559bf02ed027a',
							'label' => 'Use HTML Content',
							'name' => 'use_html_content',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => 'Advanced slide customisation with HTML content.',
							'default_value' => 0,
						),
						array (
							'key' => 'field_559bec5d76c48',
							'label' => 'Slide image',
							'name' => 'slide_img',
							'type' => 'image',
							'instructions' => 'Clickable slide image',
							'required' => 1,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_559bf02ed027a',
										'operator' => '!=',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => 'slide_img',
								'id' => '',
							),
							'return_format' => 'url',
							'preview_size' => 'thumbnail',
							'library' => 'all',
							'min_width' => '',
							'min_height' => '',
							'min_size' => '',
							'max_width' => '',
							'max_height' => '',
							'max_size' => '',
							'mime_types' => 'jpg,gif,png',
						),
						array (
							'key' => 'field_559bee722f96e',
							'label' => 'Target URL',
							'name' => 'target_url',
							'type' => 'url',
							'instructions' => 'Link to target when clicked.',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_559bf02ed027a',
										'operator' => '!=',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => 50,
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'placeholder' => 'eg. http://example.com',
						),
						array (
							'key' => 'field_559bf38209cdd',
							'label' => 'Open in new window',
							'name' => 'open_in_new_window',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_559bf02ed027a',
										'operator' => '!=',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
						),
						array (
							'key' => 'field_559bef2091fe5',
							'label' => 'Slide Content',
							'name' => 'slide_content',
							'type' => 'wysiwyg',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => array (
								array (
									array (
										'field' => 'field_559bf02ed027a',
										'operator' => '==',
										'value' => '1',
									),
								),
							),
							'wrapper' => array (
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'default_value' => '',
							'tabs' => 'all',
							'toolbar' => 'full',
							'media_upload' => 1,
						),
						array (
							'key' => 'field_559c09f6eaaf4',
							'label' => 'Status',
							'name' => 'status',
							'type' => 'select',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array (
								'width' => 50,
								'class' => '',
								'id' => '',
							),
							'choices' => array (
								'published' => 'Published',
								'draft' => 'Draft',
							),
							'default_value' => array (
								'published' => 'Published',
							),
							'allow_null' => 0,
							'multiple' => 0,
							'ui' => 0,
							'ajax' => 0,
							'placeholder' => '',
							'disabled' => 0,
							'readonly' => 0,
						),
					),
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'slider',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
		));

		endif;
	}

	/**
	 * [generate_shortcode_snippet description]
	 * @param  [type] $field [description]
	 * @return [type]        [description]
	 */
	public function generate_shortcode_snippet( $value, $post_id, $field )
	{
	    $post_arr = get_post( $post_id, ARRAY_A );

	    return '[fw_slider slug="' . $post_arr['post_name'] . '"]';
	}
}
