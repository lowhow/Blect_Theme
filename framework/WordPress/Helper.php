<?php namespace Framework\WordPress;

class Helper
{
	/**
	 * Custom filter to add wp title.
	 * @param [type] $title
	 * @param [type] $sep
	 * @return $title
	 */
	public function add_wp_title( $title, $sep )
	{
		global $paged, $page;

		$sep = '-';

		if ( is_feed() ) {
			return $title;
		}

		// Add the site name.
		$title .= get_bloginfo( 'name', 'display' );

		// Add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title = "$title $sep $site_description";
		}

		// Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 ) {
			$title = "$title $sep " . sprintf( __( 'Page %s', wp_get_theme()->get( 'TextDomain' ) ), max( $paged, $page ) );
		}

		return $title;
	}

	/**
	 * Add favicon links
	 *
	 * @link https://www.favicon-generator.org/
	 */
	public function add_favicon() {
		echo '
			<link rel="apple-touch-icon" sizes="57x57" href="'. FW_THEME_ASSETS_FAVICON_URI .'apple-icon-57x57.png">
			<link rel="apple-touch-icon" sizes="60x60" href="'. FW_THEME_ASSETS_FAVICON_URI .'apple-icon-60x60.png">
			<link rel="apple-touch-icon" sizes="72x72" href="'. FW_THEME_ASSETS_FAVICON_URI .'apple-icon-72x72.png">
			<link rel="apple-touch-icon" sizes="76x76" href="'. FW_THEME_ASSETS_FAVICON_URI .'apple-icon-76x76.png">
			<link rel="apple-touch-icon" sizes="114x114" href="'. FW_THEME_ASSETS_FAVICON_URI .'apple-icon-114x114.png">
			<link rel="apple-touch-icon" sizes="120x120" href="'. FW_THEME_ASSETS_FAVICON_URI .'apple-icon-120x120.png">
			<link rel="apple-touch-icon" sizes="144x144" href="'. FW_THEME_ASSETS_FAVICON_URI .'apple-icon-144x144.png">
			<link rel="apple-touch-icon" sizes="152x152" href="'. FW_THEME_ASSETS_FAVICON_URI .'apple-icon-152x152.png">
			<link rel="apple-touch-icon" sizes="180x180" href="'. FW_THEME_ASSETS_FAVICON_URI .'apple-icon-180x180.png">
			<link rel="icon" type="image/png" sizes="192x192"  href="'. FW_THEME_ASSETS_FAVICON_URI .'android-icon-192x192.png">
			<link rel="icon" type="image/png" sizes="32x32" href="'. FW_THEME_ASSETS_FAVICON_URI .'favicon-32x32.png">
			<link rel="icon" type="image/png" sizes="96x96" href="'. FW_THEME_ASSETS_FAVICON_URI .'favicon-96x96.png">
			<link rel="icon" type="image/png" sizes="16x16" href="'. FW_THEME_ASSETS_FAVICON_URI .'favicon-16x16.png">
			<link rel="manifest" href="'. FW_THEME_ASSETS_FAVICON_URI .'manifest.json">
			<meta name="msapplication-TileColor" content="#ffffff">
			<meta name="msapplication-TileImage" content="'. FW_THEME_ASSETS_FAVICON_URI .'ms-icon-144x144.png">
			<meta name="theme-color" content="#ffffff">
		';

	  return $this;
	}



	/**
	 * Create Breadcrumbs
	 *
	 * @since Vun Hougkh 1.0
	 *
	 * @return void
	 *
	 * @todo Find out how this breadcrumbs work and document it down in evernote
	 *
	 * @link http://www.qualitytuts.com/wordpress-custom-breadcrumbs-without-plugin/
	 */
	public function fw_breadcrumbs()
	{

	  $showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
	  $delimiter = ' <span class="delimiter text-muted">/</span> '; // delimiter between crumbs
	  $home = __( 'Home', FW_TEXTDOMAIN ); // text for the 'Home' link
	  $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
	  $before = '<span class="current">'; // tag before the current crumb
	  $after = '</span>'; // tag after the current crumb

	  global $post;
	  $homeLink = get_bloginfo('url');

	  if (is_home() || is_front_page()) {

	  	if ($showOnHome == 1) echo '<div id="crumbs"><a href="' . $homeLink . '">' . $home . '</a></div>';

	  } else {

	  	echo '<div id="crumbs"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';

	  	if ( is_category() ) {
	  		$thisCat = get_category(get_query_var('cat'), false);
	  		if ($thisCat->parent != 0) echo get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ');
	  		echo $before . '"' . single_cat_title('', false) . '"' . $after;

	  	} elseif ( is_search() ) {
	  		echo $before . 'Search results for "' . get_search_query() . '"' . $after;

	  	} elseif ( is_day() ) {
	  		echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
	  		echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
	  		echo $before . get_the_time('d') . $after;

	  	} elseif ( is_month() ) {
	  		echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
	  		echo $before . get_the_time('F') . $after;

	  	} elseif ( is_year() ) {
	  		echo $before . get_the_time('Y') . $after;

	  	} elseif ( is_single() && !is_attachment() ) {
	  		if ( get_post_type() != 'post' ) {
	  			$post_type = get_post_type_object(get_post_type());
	  			$slug = $post_type->rewrite;
	  			echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->name . '</a>';
	  			if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
	  		} else {
	  			$cat = get_the_category(); $cat = $cat[0];
	  			$cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
	  			if ($showCurrent == 0) $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
	  			echo $cats;
	  			if ($showCurrent == 1) echo $before . get_the_title() . $after;
	  		}

	  	} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
	  		/** When there's a post type */
	  		if ( get_post_type() ){
		  		$post_type = get_post_type_object(get_post_type());
		  		echo $before . $post_type->labels->name . $after;
		  	}
		  	else
		  	{
		  		/** if post_type exist in global query */
		  		global $wp_query;
		  		if ( isset( $wp_query->query_vars['post_type'] ) )
		  		{
		  			$post_type = get_post_type_object( $wp_query->query_vars['post_type'] );
		  			echo $before . $post_type->labels->name . $after;
		  		}
		  	}

	  	} elseif ( is_attachment() ) {
	  		$parent = get_post($post->post_parent);
	  		$cat = get_the_category($parent->ID); $cat = $cat[0];
	  		echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
	  		echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
	  		if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;

	  	} elseif ( is_page() && !$post->post_parent ) {
	  		if ($showCurrent == 1) echo $before . get_the_title() . $after;

	  	} elseif ( is_page() && $post->post_parent ) {
	  		$parent_id  = $post->post_parent;
	  		$breadcrumbs = array();
	  		while ($parent_id) {
	  			$page = get_page($parent_id);
	  			$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
	  			$parent_id  = $page->post_parent;
	  		}
	  		$breadcrumbs = array_reverse($breadcrumbs);
	  		for ($i = 0; $i < count($breadcrumbs); $i++) {
	  			echo $breadcrumbs[$i];
	  			if ($i != count($breadcrumbs)-1) echo ' ' . $delimiter . ' ';
	  		}
	  		if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;

	  	} elseif ( is_tag() ) {
	  		echo $before . '"' . single_tag_title('', false) . '"' . $after;

	  	} elseif ( is_author() ) {
	  		global $author;
	  		$userdata = get_userdata($author);
	  		echo $before . '' . $userdata->display_name . $after;

	  	} elseif ( is_404() ) {
	  		echo $before . 'Error 404' . $after;
	  	}

	  	echo '</div>';

	  	}
	}


	/**
	 * [t_entry_date description]
	 * @param  boolean $echo [description]
	 * @return [type]        [description]
	 */
	public function t_entry_date( $echo = TRUE )
	{
		if ( has_post_format( array( 'chat', 'status' ) ) )
			$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', FW_TEXTDOMAIN );
		else
			$format_prefix = '%2$s';

			$date = sprintf( '<span class="date"><time class="entry-date" datetime="%3$s">%4$s</time></span>',
			esc_url( get_permalink() ),
			esc_attr( sprintf( __( 'Permalink to %s', FW_TEXTDOMAIN ), the_title_attribute( 'echo=0' ) ) ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
		);

		if ( $echo )
			echo $date;

		return $date;
	}


	/**
	 * [t_entry_tag description]
	 * @return [type] [description]
	 */
	public function t_entry_tag()
	{
		// Translators: used between list items, there is a space after the comma.
		$tag_list = get_the_tag_list( '<span class="tags-links"><i class="fa fa-tags fa-fw"></i> ', ', ', '</span>' );
		if ( $tag_list )
		{
			echo  $tag_list;
		}
	}

	/**
	 * [t_entry_publisher description]
	 * @return void [description]
	 */
	public function t_entry_publisher()
	{
		// Translators: used between list items, there is a space after the comma.
		if ( !taxonomy_exists('publisher') )
			return false;

		global $post;
		$publisher_list = get_the_term_list( $post->ID, 'publisher', '<span class="tags-links"><i class="fa fa-book fa-fw"></i> ', ', ', '</span>' );
		if ( $publisher_list )
		{
			echo $publisher_list;
		}
	}

	/**
	 * [t_entry_cat description]
	 * @return [type] [description]
	 */
	public function t_entry_cat()
	{
		// Translators: used between list items, there is a space after the comma.
		$categories_list = get_the_category_list( ', ' );
		if ( $categories_list ) {
			echo '<span class="categories-links"><i class="fa fa-folder fa-fw"></i> ' . $categories_list . '</span>';
		}
	}


	/**
	 *Theme's Entry's Author
	 *
	 * Prints HTML with author information for current post.
	 *
	 * @since The Starry Night 1.0 with Vun Hougkh 1.0
	 *
	 * @param boolean $echo Whether to echo the date. Default true.
	 * @return string The HTML-formatted posFt date.
	 */
	public function t_entry_author( $echo = true ) {
		if ( 'post' == get_post_type() ) {
			printf( '<span class="author vcard"><i class="fa fa-user fa-fw"></i> <a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( __( ' %s ', FW_TEXTDOMAIN ), get_the_author() ) ),
				get_the_author()
			);
		}
	}


	/**
	 * [t_pagination description]
	 * @return [type] [description]
	 */
	public function t_pagination()
	{
		if ( function_exists( 'wp_pagenavi') )
		{
			wp_pagenavi( array( 'options' => array(
				'pages_text'					=> '%CURRENT_PAGE% / %TOTAL_PAGES%',
				'pages_text'					=> '',
				'current_text'					=> '%PAGE_NUMBER%',
				'first_text'					=> '1',
				'last_text'						=> '%TOTAL_PAGES%',
				'prev_text'						=> '<i class="fa fa-angle-left fa-lg"></i>',
				'next_text'						=> '<i class="fa fa-angle-right fa-lg"></i>',
				'dotleft_text' 					=> '...',
				'dotright_text' 				=> '...',
				'num_pages'						=> 5,
				'num_larger_page_numbers'		=> 1,
				'larger_page_numbers_multiple'	=> 10,
				'always_show'					=> false,
				'use_pagenavi_css'				=> false, // not working, use admin settings to set this option.
				'style' 						=> 1, // 2 = select>option

			) ) );
		}
		// echo '<pre>';
		// var_dump(\PageNavi_Core::$options->get_defaults());
		// echo '</pre>';
	}

	/**
	 * [t_get_the_term_avatar description]
	 * @return mixed Current value for the specified option. If the specified option does not exist, returns boolean FALSE.
	 */
	public function t_get_the_term_avatar()
	{
		$queried_object = get_queried_object();
		$term_id = $queried_object->term_id;
		return get_option( 'term_' . $term_id . '_meta_avatar' );
	}

	/**
	 * disable_wp_emojicons
	 *
	 * @link http://wordpress.stackexchange.com/questions/185577/disable-emojicons-introduced-with-wp-4-2
	 */
	public function disable_wp_emojicons()
	{
		// all actions related to emojis
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

		// filter to remove TinyMCE emojis
		//add_filter( 'tiny_mce_plugins', $this, 'disable_emojicons_tinymce' );
	}

	public function disable_emojicons_tinymce( $plugins ) {
		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		} else {
			return array();
		}
	}
	
	/*
	 * custom pagination with bootstrap .pagination class
	 * source: http://www.ordinarycoder.com/paginate_links-class-ul-li-bootstrap/
	 */
	public function bootstrap_pagination( $the_query = NULL ) {
		global $wp_query;
		if ( is_null( $the_query ) ){
			$the_query = $wp_query;
		}

		$big = 999999999; // need an unlikely integer
		$pages = paginate_links( array(
				'base'              => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format'            => '?paged=%#%',
				'current'           => max( 1, get_query_var('paged') ),
				'total' 			=> $the_query->max_num_pages,
				'show_all'          => false,
				'end_size'          => 1,
				'mid_size'          => 2,
				'prev_next'         => true,
				'prev_text'         => __('<i class="fa fa-angle-left fa-lg"></i>'),
				'next_text'         => __('<i class="fa fa-angle-right fa-lg"></i>'),
				'type'              => 'array',
				'add_args'          => false,
				'add_fragment'      => '',
				'before_page_number' => '',
			)
		);

		if( is_array( $pages ) ) {
			$paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
			$pagination = '<ul class="pagination">';
			foreach ( $pages as $page ) {
				if ( strpos($page, 'current') !== false )
				{
					$pagination .= '<li class="active">'.$page.'</li>';
				}
				else
				{
					$pagination .= '<li>'.$page.'</li>';
				}
			}
			$pagination .= '</ul>';

			return '<div class="fw-paginate text-center">'.$pagination.'</div>';
		}
	}

}
