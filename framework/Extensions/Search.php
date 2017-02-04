<?php namespace Framework\Extensions;
use Framework\Core\Observer as Observer;
use Framework\WordPress\Loader as Loader;

class Search implements Observer
{
	private $loader;

	public function __construct( Loader $loader )
	{
		$this->loader = $loader;
	}

	public function handle() 
	{
		$this->loader
		->add_filter( 'pre_get_posts', $this, 'SearchFilter' );

		return $this;
	}

	/**
	 * [extension_template_method description]
	 * @return [type] [description]
	 */
	public function SearchFilter( $query ) 
	{	
		// If 's' request variable is set but empty
	    if (isset($_GET['s']) && empty($_GET['s']) && $query->is_main_query()){
	        $query->is_search = true;
	        $query->is_home = false;
	    }
	    return $query;
	}

}