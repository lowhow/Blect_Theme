<?php namespace Framework\WordPress;

class Widget {

	public function register_sidebars() {

		/**
		 * Primary Sidebar
		 */
		register_sidebar( array(
			'name'          => __( 'Primary Sidebar', wp_get_theme()->get( 'TextDomain' ) ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Main sidebar that appears on the left.', wp_get_theme()->get( 'TextDomain' ) ),
			'class'         => 'mod-wrap',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
			'before_widget' => '<div id="%1$s" class="widget %2$s mod">',
			'after_widget'  => '</div>',
		) );

		/**
		 * Additional Sidebar
		 */
		// register_sidebar( array(
		// 	'name'          => __( 'Content Sidebar', 'twentyfourteen' ),
		// 	'id'            => 'sidebar-2',
		// 	'description'   => __( 'Additional sidebar that appears on the right.', 'twentyfourteen' ),
		// 	'class'         => 'mod-wrap',
		// 	'before_title'  => '<h3 class="widget-title">',
		// 	'after_title'   => '</h3>',
		// 	'before_widget' => '<div id="%1$s" class="widget %2$s mod">',
		// 	'after_widget'  => '</div>',
		// ) );

		return $this;

	}

}