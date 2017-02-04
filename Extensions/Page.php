<?php namespace Extensions;
use \Framework\Core\Observer as Observer;
use \Framework\WordPress\Loader as Loader;

class Page implements Observer
{
	private $loader;

	public function __construct( Loader $loader )
	{
		$this->loader = $loader;
	}

	public function handle()
	{
		$this->loader
		->add_action( 'init', $this, 'add_post_type_support');

		return $this;
	}

	/**
	 * [add_post_type_support description]
	 */
	public function add_post_type_support()
	{
	    add_post_type_support( 'page', 'excerpt' );
	}

}
