<?php namespace Extensions;
use \Framework\Core\Observer as Observer;
use \Framework\WordPress\Loader as Loader;

class GravityForm implements Observer
{
	private $loader;

	public function __construct( Loader $loader )
	{
		$this->loader = $loader;
	}

	public function handle()
	{
		$this->loader
		->add_filter( 'gform_field_content', $this, 'bootstrap_styles_for_gravityforms', 10, 2 )
		->add_filter( 'gform_field_content', $this, 'bootstrap_styles_for_gravityforms_fields', 10, 5 );
		add_filter( 'gform_init_scripts_footer', '__return_true' );

		return $this;
	}

	public function bootstrap_styles_for_gravityforms( $form_string, $form )
	{
		// Currently only applies to most common field types, but could be expanded.
	    // $pre_content = str_replace( '<', '&lt;', $form_string);
	    // $pre_content = str_replace( '>', '&gt;', $pre_content);
	    // echo '<pre>';
	    // print_r($pre_content);
	    // echo '</pre>';

		return $form_string;
	}



	/**
	 * [bootstrap_styles_for_gravityforms_fields description]
	 * @param  [type] $content [description]
	 * @param  [type] $field   [description]
	 * @param  [type] $value   [description]
	 * @param  [type] $lead_id [description]
	 * @param  [type] $form_id [description]
	 * @return [type]          [description]
	 */
	public function bootstrap_styles_for_gravityforms_fields($content, $field, $value, $lead_id, $form_id)
	{
	    // $pre_content = str_replace( '<', '&lt;', $content);
	    // $pre_content = str_replace( '>', '&gt;', $pre_content);
	    // echo '<pre>';
	    // print_r($pre_content);
	    // echo '</pre>';
		
	    if($field["type"] != 'hidden' && $field["type"] != 'list' && $field["type"] != 'multiselect' && $field["type"] != 'checkbox' && $field["type"] != 'fileupload' && $field["type"] != 'date' && $field["type"] != 'html' && $field["type"] != 'address') {
	        //$content = str_replace('class=\'medium', 'class=\'form-control medium', $content);
	        if ( strpos( $content, 'medium' ) )
	        	$content = str_replace('class=\'medium', 'class=\'form-control medium', $content);
	        elseif ( strpos( $content, 'small' ) )
	        	$content = str_replace('class=\'small', 'class=\'form-control small', $content);
	        elseif ( strpos( $content, 'large' ) )
	        	$content = str_replace('class=\'large', 'class=\'form-control large', $content);


	    }
		
	    if($field["type"] == 'name' || $field["type"] == 'address') {
	        $content = str_replace('<input ', '<input class=\'form-control\' ', $content);
	    }
		
	    if($field["type"] == 'textarea') {
	        $content = str_replace('class=\'textarea', 'class=\'form-control textarea', $content);
	    }
		
	    if($field["type"] == 'checkbox') {
	        $content = str_replace('li class=\'', 'li class=\'checkbox ', $content);
	        $content = str_replace('<input ', '<input style=\'margin-left:1px;\' ', $content);
	    }
		
	    if($field["type"] == 'radio') {
	        $content = str_replace('li class=\'', 'li class=\'radio ', $content);
	        $content = str_replace('<input ', '<input style=\'margin-left:1px;\' ', $content);
	    }
		
		return $content;
		
	} // End bootstrap_styles_for_gravityforms_fields()

}
