<?php namespace Framework\WordPress;

class OEmbed {
	/**
	 * Add a Bootstrap 3 responsive embed wrapper around YouTube url picked up in content.
	 * @param string 	$html    	HTML output.
	 * @param string 	$url     	url picked up from content.
	 * @param array 	$attr     	[width], [height].
	 * @param int 		$post_ID 	current post ID.
	 */
	public function add_oembed_responsive_wrapper($html, $url, $attr, $post_ID) {
    	$return = '<div class="embed-responsive embed-responsive-16by9">'.$html.'</div>';
	    return $return;
	}
}