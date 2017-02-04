<?php namespace Framework\Extensions;
use Framework\Core\CustomPostType as CustomPostType;
use Framework\Core\Observer as Observer;
use Framework\WordPress\Loader as Loader;

/**
 * Event Custom Post Type
 *
 * @depencies
 * ACF5 Plugin 
 * ACF Date and Time Picker plugin( ACF5 compatible )
 * 'Event' field group(import from data folder)
 */
class EventCustomPostType extends CustomPostType  implements Observer
{
	private $post_type; // (max. 20 characters, can not contain capital letters or spaces)
	private $plural_name;
	private $slug;
	private $loader;
	private $events_year_tag;
	private $events_month_tag;
	private $events_status;
	private $events_status_past;
	private $events_status_current;
	private $events_status_upcoming;
	private $events_start_date_pre_validate;

	public function __construct( Loader $loader, $post_type, $plural_name, $slug = null )
	{
		$this->loader = $loader;
		$this->post_type 		= $post_type;
		$this->plural_name 		= $plural_name;
		$this->slug				= $slug;
		$this->events_year_tag	= '%events_year%';
		$this->events_month_tag	= '%events_month%';
		$this->events_status	= '%events_status%';
		$this->events_status_past = 'past';
		$this->events_status_current = 'current';
		$this->events_status_upcoming = 'upcoming';
		$this->events_start_date_pre_validate = '';

	}

	public function handle() 
	{	
		$this->loader
		->add_action('init', $this, 'event_rewrite_tags')
		->add_action('init', $this, 'custom_post_type_init')
		->add_action('init', $this, 'register_acf_field_group')
		->add_action('init', $this, 'pretty_url')
		->add_filter('post_type_link', $this, 'event_permalink', 10, 4 )
		->add_action('pre_get_posts', $this, 'event_queries')
		->add_action('acf/input/admin_footer', $this, 'event_acf_input_admin_footer')
		->add_filter('acf/load_value/name=events_start_date', $this, 'events_start_date_acf_load_value', 10, 3)
		->add_filter('acf/validate_value/name=events_end_date', $this, 'events_end_date_acf_validate_value', 10, 4)
		->add_filter('acf/validate_value/name=events_start_date', $this, 'events_start_date_acf_validate_value', 10, 4)
		->add_filter('manage_event_posts_columns', $this, 'add_new_column_headers' )
		->add_action('manage_event_posts_custom_column', $this, 'add_new_column_columns', 10, 2 )
		->add_filter('manage_edit-event_sortable_columns', $this, 'add_sortable_columns')
		->add_filter('request', $this, 'add_sortable_columns_orderby_events_start_date')
		->add_filter('request', $this, 'add_sortable_columns_orderby_events_end_date')
		->add_action('restrict_manage_posts', $this, 'add_table_filtering_options' )
		->add_filter('parse_query', $this, 'alter_table_query_by_filters' );
		
		

		return $this;
	}

	/**
	 * [event_rewrite_tags description]
	 * 
	 * @link http://wordpress.stackexchange.com/questions/161119/permalinks-using-event-date-year-month-instead-of-publication-date
	 */
	public function event_rewrite_tags()
	{
		add_rewrite_tag( $this->events_year_tag, '([0-9]{4})' );
    	add_rewrite_tag( $this->events_month_tag, '([0-9]{2})' );
    	add_rewrite_tag( $this->events_status, '([^&]+)' );

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
			'desciption' 		 	=> 'Create Event',
			'labels'             	=> $labels,
			'public'             	=> true,
			'exclude_from_search'	=> false,
			'publicly_queryable' 	=> true,
			'show_ui'            	=> true,
			'show_in_nav_menus' 	=> true,
			'show_in_menu'       	=> true,
			'show_in_admin_bar' 	=> true,
			'menu_position'			=> 5,
			'menu_icon' 			=> 'dashicons-calendar',
			'query_var'          	=> true,
			'rewrite'            	=> array( 'slug' => $this->slug, 'with_front' => FALSE ),
			//'rewrite'            	=> false,
			'capability_type'    	=> 'post',
			'has_archive'        	=> true,
			'hierarchical'       	=> false,
			'supports'           	=> array( 'title', 'editor', 'thumbnail', 'custom_fields' )
		);

		register_post_type( $this->post_type, $args );

		return $this;
	}

	/**
	 * Define Permastructure
	 * @return [type] [description]
	 */
	public function pretty_url(){
		global $wp_rewrite;
		/** Year month events tags - add post_type=event to url param/substitution */
		$event_structure = '/' . $this->slug . '/' . $this->events_year_tag . '/' . $this->events_month_tag . '/%' . $this->post_type . '%';
		$wp_rewrite->add_rewrite_tag('%' . $this->post_type . '%', '([^/]+)', 'post_type=' . $this->post_type . '&' . $this->post_type.'=');
		$wp_rewrite->add_permastruct( $this->post_type, $event_structure, false);

		/** Status events tags - add post_type=event to url param/substitution */
		$event_structure = '/' . $this->slug . '/' . $this->events_status ;
		$wp_rewrite->add_rewrite_tag( $this->events_status, '([^&/]+)', 'post_type='.$this->post_type.'&events_status=');
		$wp_rewrite->add_permastruct( 'events_archive_by_status', $event_structure, false);

		/** Year month events tags - add post_type=event to url param/substitution */
		$event_structure = '/' . $this->slug . '/' . $this->events_year_tag . '/' . $this->events_month_tag;
		$wp_rewrite->add_rewrite_tag( $this->events_year_tag, '([0-9]{4})', 'post_type='.$this->post_type.'&events_year=');
		$wp_rewrite->add_rewrite_tag( $this->events_month_tag, '([0-9]{2})', 'post_type='.$this->post_type.'&events_month=');
		$wp_rewrite->add_permastruct( 'events_archive_by_year', $event_structure, false);	
 	}


	/**
	 * [event_permalink description]
	 * 
	 * @link http://wordpress.stackexchange.com/questions/161119/permalinks-using-event-date-year-month-instead-of-publication-date
	 */
	public function event_permalink( $permalink, $post, $leavename )
	{
		if ( get_post_type( $post ) === "event" ) {
	        $sd = get_post_meta( $post->ID, 'events_start_date', true);
	        $year = date('Y', $sd + get_option( 'gmt_offset' ) * 3600);
	        $month = date('m', $sd + get_option( 'gmt_offset' ) * 3600);

	        $rewritecode = array(
	            $this->events_year_tag,
	            $this->events_month_tag,
	            $leavename ? '' : '%postname%',
	        );

	        $rewritereplace = array(
	            $year,
	            $month,
	            $post->post_name
	        );

		    $permalink = str_replace($rewritecode, $rewritereplace, $permalink);
	    }
	    return $permalink;
	}

	/**
	 * Alter queries for Event's Archive.
	 * 
	 * @link http://wordpress.stackexchange.com/questions/161119/permalinks-using-event-date-year-month-instead-of-publication-date
	 */
	public function event_queries( $query ){
		if ( is_admin() || ! $query->is_main_query() || $query->is_singular() )
        	return $this;

        if ( $query->is_post_type_archive('event') )
        {

        	$query->set('meta_key', 'events_start_date');
        	$query->set('orderby', 'meta_value');
        	$query->set('order', 'DESC');
        	// echo '<pre>';
        	// var_dump($query);
        	// echo '</pre>';
        }
		
		/**
		 * Events archive by event's year and month
		 */
		if ( ! $query->is_singular() && isset( $query->query_vars['events_year'] ) )
		{
			$query->is_post_type_archive = true;
			$query->is_home = false;
			$query->query['post_type'] = 'event';
			$query->query_vars['post_type'] = 'event';

			$Y = intval( $query->query_vars['events_year'] );
			$Y_next = $Y + 1;
			$m = '01';

			$meta_query = array(
                array(
                    'key'     => 'events_start_date',
                    'value'   => strtotime( $Y . '-' . $m . '-01 00:00:00' ),
                    'compare' => '>=',
                    'type'    => 'numeric',
                ),
                array(
                    'key'     => 'events_start_date',
                    'value'   => strtotime( $Y_next . '-' . $m . '-01 00:00:00' ),
                    'compare' => '<',
                    'type'    => 'numeric',
                ),
            );

			if ( isset( $query->query_vars['events_month'] ) )
			{
				$m = intval( $query->query_vars['events_month'] );
				$m_next = $m + 1;
				
				$meta_query = array(
	                array(
	                    'key'     => 'events_start_date',
	                    'value'   => strtotime( $Y . '-' . $m . '-01 00:00:00' ),
	                    'compare' => '>=',
	                    'type'    => 'numeric',
	                ),
	                array(
	                    'key'     => 'events_start_date',
	                    'value'   => strtotime( $Y . '-' . $m_next . '-01 00:00:00' ),
	                    'compare' => '<',
	                    'type'    => 'numeric',
	                )
	            );
			}

			$query->set('meta_query', $meta_query );
			$query->set('meta_key', 'events_start_date');
        	$query->set('orderby', 'meta_value');
        	$query->set('order', 'DESC');
		}

		/**
		 * Events archive by event's status
		 */
		if ( ! $query->is_singular() && isset( $query->query_vars['events_status'] ) )
		{
			$blogtime = current_time( 'timestamp' ); 
			switch( $query->query_vars['events_status'] )
			{
				case $this->events_status_current:
					$meta_query = array(
		                array(
		                    'key'     => 'events_start_date',
		                    'value'   => $blogtime,
		                    'compare' => '<=',
		                    'type'    => 'numeric',
		                ),
		                array(
		                    'key'     => 'events_end_date',
		                    'value'   => $blogtime,
		                    'compare' => '>',
		                    'type'    => 'numeric',
		                )
		            );
		            $query->set('meta_key', 'events_end_date');
		        	$query->set('orderby', 'meta_value');
		        	$query->set('order', 'DESC');

					break;

				case $this->events_status_past:
					$meta_query = array(
		                array(
		                    'key'     => 'events_end_date',
		                    'value'   => $blogtime,
		                    'compare' => '<',
		                    'type'    => 'numeric',
		                )
		            );
		            $query->set('meta_key', 'events_end_date');
		        	$query->set('orderby', 'meta_value');
		        	$query->set('order', 'DESC');

					break;

				case $this->events_status_upcoming:
					$meta_query = array(
		                array(
		                    'key'     => 'events_start_date',
		                    'value'   => $blogtime,
		                    'compare' => '>',
		                    'type'    => 'numeric',
		                )
		            );
		            $query->set('meta_key', 'events_start_date');
		        	$query->set('orderby', 'meta_value');
		        	$query->set('order', 'DESC');

					break;				
			}

			$query->set( 'meta_query', $meta_query );
		}

	    return $this;
	}

	/**
	 * [my_acf_load_value description]
	 * @param  [type] $value   [description]
	 * @param  [type] $post_id [description]
	 * @param  [type] $field   [description]
	 * @return [type]          [description]
	 */
	public function events_start_date_acf_load_value( $value, $post_id, $field )
	{
	    $this->events_start_date_pre_validate = $value;
	    $value = $value; 

	    return $value;
	}

	/**
	 * Validate ACF5's events_start_date field value.
	 *
	 * NOTE: Somehow ACF5 runs events_start_date field before events_end_date field. Unable to control the fields order.
	 * @param  [type] $valid [description]
	 * @param  [type] $value [description]
	 * @param  [type] $field [description]
	 * @param  [type] $input [description]
	 * @return string $valid Error message.
	 *
	 * @depencies
 	 * ACF5 Plugin 
 	 * ACF Date and Time Picker plugin( ACF5 compatible )
 	 * 'Event' field group(import from data folder)
	 */
	public function events_start_date_acf_validate_value( $valid, $value, $field, $input )
	{	
		$this->events_start_date_pre_validate = $value;

		return $valid;
	}

	/**
	 * Validate ACF5's events_end_date field value.
	 * @param  [type] $valid [description]
	 * @param  [type] $value [description]
	 * @param  [type] $field [description]
	 * @param  [type] $input [description]
	 * @return string $valid Error message.
	 *
	 * @depencies
 	 * ACF5 Plugin 
 	 * ACF Date and Time Picker plugin( ACF5 compatible )
 	 * 'Event' field group(import from data folder)
	 */
	public function events_end_date_acf_validate_value( $valid, $value, $field, $input )
	{	
		$startdate = strtotime( $this->events_start_date_pre_validate );
		$enddate = strtotime( $value );

		if ( $startdate >= $enddate )
		{
			$valid = 'End date must be later than start date';
		}

		return $valid;
	}

	/**
	 * Javascript Validation on event fields.
	 * @return [type] [description]
	 * @link( _blank, http://www.advancedcustomfields.com/resources/adding-custom-javascript-fields/ )
	 */
	public function event_acf_input_admin_footer() {
	?>
		<script type="text/javascript">
		(function($) {

			var $events_start_date = jQuery('[data-name="events_start_date"] input');
			var $events_end_date = jQuery('[data-name="events_end_date"] input');

			if( $events_start_date.length > 0 ){
				validate_end_date();

				$events_start_date.on('change', function(){
					validate_end_date();
				});
				$events_end_date.on('change', function(){
					validate_end_date();
				});
			}

			function validate_end_date(){
				<?php /** When Event's end date is empty, set it to end of day by default. */ ?>
				if( $events_start_date.val() !== '' && $events_end_date.val() === '' ){
					var startdate = moment( $events_start_date.val() );
					$events_end_date.val( startdate.add( 1, 'days' ).subtract( 1, 'seconds' ).format('YYYY-MM-DD HH:mm:ss') );
				}else{
					var startdate = moment( $events_start_date.val() );
					var enddate = moment( $events_end_date.val() );
					<?php /** When Event's end date larger or equals to start date, set it to end of start day. */ ?>
					if( startdate >= enddate ){
						$events_end_date.val( startdate.add( 1, 'days' ).subtract( 1, 'seconds' ).format('YYYY-MM-DD HH:mm:ss') );
					}
				}
			}
		})(jQuery);	
		</script>
	<?php

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
	    	'events_start_date' => 'Start Date',
	    	'events_end_date' 	=> 'End Date',
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
	    if ($column_name == 'events_start_date') 
	    {
	    	$startdate = get_post_meta( $post_id, 'events_start_date', true );
	    	echo date( 'Y-m-d', $startdate ) . '<br>' . date( 'H:i:s', $startdate );
	    }
	    if ($column_name == 'events_end_date') 
	    {
	    	$enddate =  get_post_meta( $post_id, 'events_end_date', true );
	    	echo date( 'Y-m-d', $enddate ) . '<br>' . date( 'H:i:s', $enddate );
	    }
	}

	/**
	 * [add_sortable_columns description]
	 * @param [type] $columns [description]
	 * @link(_blank, http://www.smashingmagazine.com/2013/12/05/modifying-admin-post-lists-in-wordpress/)
	 */
	public function add_sortable_columns( $columns ) 
	{
		$columns['events_start_date'] = 'events_start_date';
		$columns['events_end_date'] = 'events_end_date';

		return $columns;
	}

	/**
	 * [add_sortable_columns_orderby_events_start_date description]
	 * @param [type] $vars [description]
	 * @link(_blank, http://www.smashingmagazine.com/2013/12/05/modifying-admin-post-lists-in-wordpress/)
	 */
	public function add_sortable_columns_orderby_events_start_date( $vars ) 
	{
	    if ( isset( $vars['orderby'] ) && 'events_start_date' == $vars['orderby'] ) {
	        $vars = array_merge( $vars, array(
	            'meta_key' => 'events_start_date',
	            'orderby' => 'meta_value'
	        ) );
	    }

	    return $vars;
	}

	/**
	 * [add_sortable_columns_orderby_events_end_date description]
	 * @param [type] $vars [description]
	 * @link(_blank, http://www.smashingmagazine.com/2013/12/05/modifying-admin-post-lists-in-wordpress/)
	 */
	public function add_sortable_columns_orderby_events_end_date( $vars ) 
	{
	    if ( isset( $vars['orderby'] ) && 'events_end_date' == $vars['orderby'] ) {
	        $vars = array_merge( $vars, array(
	            'meta_key' => 'events_end_date',
	            'orderby' => 'meta_value'
	        ) );
	    }

	    return $vars;
	}


	public function add_table_filtering_options() {
		global $wpdb;
		global $typenow;  
		if ( $typenow == 'event' ) 
		{
			/** @var Start Date query */
			$startdates = $wpdb->get_results( "SELECT meta_value as startdate FROM $wpdb->postmeta WHERE meta_key = 'events_start_date' AND post_id IN ( SELECT ID FROM $wpdb->posts WHERE post_type = 'event' AND post_status != 'trash' ) ORDER BY startdate DESC" ) ;

			echo '<select name="events_start_date" id="filter-by-startdate">';
			echo '<option value="0">' . __( 'All start dates', 't' ) . '</option>';
			$value = '';
			foreach( $startdates as $date ) 
			{
				if ( $value === date('Y-m', $date->startdate ) )
					continue;

				$value = date('Y-m', $date->startdate );
			  	$name = date( 'F Y', $date->startdate );
			  	$selected = ( !empty( $_GET['events_start_date'] ) AND $_GET['events_start_date'] == $value ) ? 'selected="select"' : '';
			  	echo '<option value="' . $value . '" ' . $selected . '>' . $name . '</option>';
			}
			echo '</select>';

			/** @var End Date query */
			$enddates = $wpdb->get_results( "SELECT meta_value as enddate FROM $wpdb->postmeta WHERE meta_key = 'events_end_date' AND post_id IN ( SELECT ID FROM $wpdb->posts WHERE post_type = 'event' AND post_status != 'trash' ) ORDER BY enddate DESC" ) ;

			echo '<select name="events_end_date" id="filter-by-enddate">';
			echo '<option value="0">' . __( 'All end dates', 't' ) . '</option>';
			$value = '';
			foreach( $enddates as $date ) 
			{
				if ( $value === date('Y-m', $date->enddate ) )
					continue;

				$value = date('Y-m', $date->enddate );  	
			  	$name = date( 'F Y', $date->enddate );
			  	$selected = ( !empty( $_GET['events_end_date'] ) AND $_GET['events_end_date'] == $value ) ? 'selected="select"' : '';
			  	echo '<option value="' . $value . '" ' . $selected . '>' . $name . '</option>';
			}
			echo '</select>';
		}
	}

	/**
	 * [alter_table_query_by_filters description]
	 * @param  [type] $query [description]
	 * @return [type]        [description]
	 * @link(_blank, http://www.smashingmagazine.com/2013/12/05/modifying-admin-post-lists-in-wordpress/)
	 */
	public function alter_table_query_by_filters( $query ) {
		if( is_admin() AND $query->query['post_type'] == 'event' ) 
		{
			if ( !isset( $_GET['events_start_date'] ) )
				return false;

			$qv = &$query->query_vars;
			$qv['meta_query'] = array();


			if( $_GET['events_start_date'] !== '0' && $_GET['events_end_date'] === '0' ) 
			{
			 	$start_time = strtotime( $_GET['events_start_date'] . '-01 00:00:00' );
			 	$end_time = mktime( 0, 0, 0, date( 'm', $start_time ) + 1, date( 'd', $start_time ), date( 'Y', $start_time ) );
			 	$end_date = strtotime( date( 'Y-m-d H:i:s', $end_time ) );
			 	$qv['meta_query'][] = array(
			 	  'key' => 'events_start_date',
			 	  'value' => $start_time,
			 	  'compare' => '>=',
			 	  'type' => 'numeric'
			 	);
			 	$qv['meta_query'][] = array(
			 	  'key' => 'events_start_date',
			 	  'value' => $end_date,
			 	  'compare' => '<',
			 	  'type' => 'numeric'
			 	);
			}
			elseif( $_GET['events_start_date'] === '0' && $_GET['events_end_date'] !== '0' ) 
			{
			 	$start_time = strtotime( $_GET['events_end_date'] . '-01 00:00:00' );
			 	$end_time = mktime( 0, 0, 0, date( 'm', $start_time ) + 1, date( 'd', $start_time ), date( 'Y', $start_time ) );
			 	$end_date = strtotime( date( 'Y-m-d H:i:s', $end_time ) );
			 	$qv['meta_query'][] = array(
			 	  'key' => 'events_end_date',
			 	  'value' => $start_time,
			 	  'compare' => '>=',
			 	  'type' => 'numeric'
			 	);
			 	$qv['meta_query'][] = array(
			 	  'key' => 'events_end_date',
			 	  'value' => $end_date,
			 	  'compare' => '<',
			 	  'type' => 'numeric'
			 	);
			}
			elseif( $_GET['events_start_date'] !== '0' && $_GET['events_end_date'] !== '0' ) 
			{
			 	$start_time = strtotime( $_GET['events_start_date'] . '-01 00:00:00' );
			 	$end_time = strtotime( $_GET['events_end_date'] . '-01 00:00:00' );
			 	$qv['meta_query'][] = array(
			 	  'key' => 'events_start_date',
			 	  'value' => $start_time,
			 	  'compare' => '>=',
			 	  'type' => 'numeric'
			 	);
			 	$qv['meta_query'][] = array(
			 	  'key' => 'events_end_date',
			 	  'value' => $end_time,
			 	  'compare' => '<',
			 	  'type' => 'numeric'
			 	);
			}

			if ( !empty( $_GET['orderby'] ) ) 
			{
				if ( $_GET['orderby'] == 'event_start_date' || $_GET['orderby'] == 'event_end_date' )
				$qv['orderby'] = 'meta_value';
				$qv['meta_key'] = $_GET['orderby'];
				$qv['order'] = strtoupper( $_GET['order'] );
			}

		}
	}

	/**
	 * [acf_register_field_group description]
	 * @return [type] [description]
	 */
	public function register_acf_field_group()
	{
		if( function_exists('acf_add_local_field_group') ):

		acf_add_local_field_group(array (
			'key' => 'group_559518acce78a',
			'title' => 'Event',
			'fields' => array (
				array (
					'key' => 'field_55922c1c041de',
					'label' => 'Event\'s Start date',
					'name' => 'events_start_date',
					'type' => 'date_time_picker',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'show_date' => 'true',
					'date_format' => 'yy-mm-dd',
					'time_format' => 'HH:mm:ss',
					'show_week_number' => 'false',
					'picker' => 'slider',
					'save_as_timestamp' => 'true',
					'get_as_timestamp' => 'false',
				),
				array (
					'key' => 'field_55922e2d8bd84',
					'label' => 'Event\'s End date',
					'name' => 'events_end_date',
					'type' => 'date_time_picker',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'show_date' => 'true',
					'date_format' => 'yy-mm-dd',
					'time_format' => 'HH:mm:ss',
					'show_week_number' => 'false',
					'picker' => 'slider',
					'save_as_timestamp' => 'true',
					'get_as_timestamp' => 'false',
				),
				array (
					'key' => 'field_55937c151559e',
					'label' => 'Event\'s Venue',
					'name' => 'events_venue',
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
					'placeholder' => 'Name of place',
					'prepend' => '',
					'append' => '',
					'formatting' => 'none',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_55937e9d8cf03',
					'label' => 'Event\'s Description',
					'name' => 'events_description',
					'type' => 'textarea',
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
					'maxlength' => '',
					'rows' => 2,
					'new_lines' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'event',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'side',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
		));

		endif;
	}
}