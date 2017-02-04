<?php namespace Framework\WordPress;

class NavMenu 
{
	/**
	 * Register Navigation Menu
	 * @return [type]
	 */
	public function register() 
	{
		register_nav_menu( 'main', __( 'Main', FW_TEXTDOMAIN ) );
		register_nav_menu( 'mobile', __( 'Mobile', FW_TEXTDOMAIN ) );
		register_nav_menu( 'top', __( 'Top', FW_TEXTDOMAIN ) );
		register_nav_menu( 'footer1', __( 'Footer1', FW_TEXTDOMAIN ) );
		register_nav_menu( 'footer2', __( 'Footer2', FW_TEXTDOMAIN ) );
		register_nav_menu( 'footer3', __( 'Footer3', FW_TEXTDOMAIN ) );
		return $this;
	}

	/**
	 * Custom filter to add 'active' & 'current' class to current menu item.
	 * @param [type] $classes
	 * @param [type] $item
	 */
	public function add_class_to_current_menu_item( $classes, $item )
	{
		if(in_array('current-menu-item', $classes)){
			$classes[] = "active";
	    $classes[] = "current";
		}

		return $classes;
	}
}