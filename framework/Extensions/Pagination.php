<?php namespace Framework\Extensions;
use Framework\Core\Observer as Observer;
use Framework\WordPress\Loader as Loader;

class Pagination implements Observer
{
	private $loader;

	public function __construct( Loader $loader )
	{
		$this->loader = $loader;
	}

	public function handle() 
	{
		$this->loader
		->add_filter( 'wp_pagenavi', $this, 'wp_pagenavi_to_bootstrap', 10, 2 );

		return $this;
	}

	/**
	 * [wp_pagenavi_to_bootstrap description]
	 * @param  [type] $html [description]
	 * @return [type]       [description]
	 */
	public function wp_pagenavi_to_bootstrap($html) 
	{	
	    $out = '';
	  	
	    //wrap a's and span's in li's
	    $out = str_replace("<div","",$html);
	    $out = str_replace("class='wp-pagenavi'>","",$out);
	    $out = str_replace("<a","<li><a",$out);
	    $out = str_replace("</a>","</a></li>",$out);
	    $out = str_replace("<span","<li><span",$out);  
	    $out = str_replace("</span>","</span></li>",$out);
	    $out = str_replace("</div>","",$out);
	    $out = str_replace("<li><span class='current'>","<li class=\"active\"><span class=\"current\">",$out);
	  
	    return '<div class="wp-pagenavi text-center">
	            <ul class="pagination">'.$out.'</ul>
	        </div>';
	}

}