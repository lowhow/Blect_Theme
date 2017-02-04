<?php namespace Framework\WordPress;

class Loader
{
	protected $actions;
	protected $filters;
	protected $actions_to_be_removed;

	public function __construct() {

	    $this->actions = array();
	    $this->filters = array();
	    $this->removable_actions = array();
	}

	/**
	 * add_action
	 * @param [type]  $hook          [description]
	 * @param [type]  $component     [description]
	 * @param [type]  $callback      [description]
	 * @param integer $priority      [description]
	 * @param integer $accepted_args [description]
	 */
	public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) 
	{
	    $this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );

	    return $this;
	}

	/**
	 * [add_filter description]
	 * @param [type]  $hook          [description]
	 * @param [type]  $component     [description]
	 * @param [type]  $callback      [description]
	 * @param integer $priority      [description]
	 * @param integer $accepted_args [description]
	 */
	public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) 
	{
	    $this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );

	    return $this;
	}

	/**
	 * [remove_action description]
	 * @param  [type]  $tag                [description]
	 * @param  [type]  $function_to_remove [description]
	 * @param  integer $priority           [description]
	 * @return [type]                      [description]
	 */
	public function remove_action( $tag, $function_to_remove, $priority = 10 )
	{
		$this->removable_actions[] = array( 'tag' => $tag, 'function_to_remove' => $function_to_remove, 'priority' => $priority );

		return $this;
	}

	/**
	 * [add description]
	 * @param [type] $hooks         [description]
	 * @param [type] $hook          [description]
	 * @param [type] $component     [description]
	 * @param [type] $callback      [description]
	 * @param [type] $priority      [description]
	 * @param [type] $accepted_args [description]
	 */
	private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ) 
	{
	    $hooks[] = array(
	        'hook'      => $hook,
	        'component' => $component,
	        'callback'  => $callback,
	        'priority'	=> $priority,
	        'accepted_args'	=> $accepted_args,
	    );

	    return $hooks;
	}

	/**
	 * [run description]
	 * @return object Return this Loader object instance itself
	 */
	public function run() 
	{
	    foreach ( $this->filters as $hook ) 
	    {
	    	if ( $hook['component'] === NULL )
	    	{
	    		add_filter( $hook['hook'], $hook['callback'] , $hook['priority'], $hook['accepted_args'] );

				continue;
	    	}

	        add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
	        //var_dump($hook);
	    }

	    foreach ( $this->actions as $hook ) 
	    {
	        add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
	        // var_dump($hook);
	    }

	    foreach ( $this->removable_actions as $hook )
	    {
	    	remove_action( $hook['tag'], $hook['function_to_remove'], $hook['priority'] );
	    }

	    return $this;
	}

	/**
	 * Include files in \include folder
	 * @return [type]
	 */
	public function load_dependancies( $filenames ) 
	{
		foreach($filenames as $file) {
			include_once( trailingslashit( FW_THEME_FRAMEWORK_INCLUDE_DIR ) . '/' . $file );
		}

		return $this;
	}

	/**
	 * [set_upload_path description]
	 */
	public function set_upload_path()
	{	
		if ( get_option( 'upload_path' ) !== FW_UPLOAD_DIR )
			update_option( 'upload_path', FW_UPLOAD_DIR );

		if ( get_option( 'upload_url_path' ) !== FW_UPLOAD_URI )
			update_option( 'upload_url_path', FW_UPLOAD_URI );

		return $this;
	}
}