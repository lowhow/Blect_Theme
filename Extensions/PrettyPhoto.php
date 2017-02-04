<?php namespace Framework\Extensions;
use Framework\Core\Observer as Observer;

class PrettyPhoto implements Observer
{

	public function handle() 
	{
		if ( is_admin() ) {
			add_filter( 'image_send_to_editor', array( $this, 'filter_hooks_add_prettyPhoto_rel_in_editor' ), 10, 7 );
			add_filter( 'wp_get_attachment_link', array( $this, 'filter_hooks_add_prettyPhoto_rel_in_gallery' ), 10, 4 );
		}

		return $this;
	}


	/** 
	 * Hook into 'image_send_to_editor' and place rel="prettyPhoto" 
	 *
	 * @todo Fix this, prettyPhoto will not always be around
	 */
	public function filter_hooks_add_prettyPhoto_rel_in_editor($html, $id, $alt, $title, $align, $url, $size ) {
	  global $post;
	  global $permalink;

	  $hook = "rel";
	  $selector = 'prettyPhoto';
	  
	  if ( ! $permalink )
	    $html = preg_match( '/' . $hook . '="/', $html ) ? str_replace( $hook . '="', $hook . '="' . $selector. '" ' , $html ) : str_replace( '<a ', '<a ' . $hook . '="' . $selector . '" ', $html );

	  return $html;
	}


	/** 
	 * Hook into 'wp_get_attachment_link' and place rel="prettyPhoto" 
	 *
	 * @todo Fix this, prettyPhoto will not always be around
	 */
	public function filter_hooks_add_prettyPhoto_rel_in_gallery($html, $id, $size, $permalink) 
	{
		global $post;
		global $permalink;

		$pid = $post->ID;

	  $hook = "rel";
	  $selector = 'prettyPhoto';

		if ( ! $permalink )
			$html = preg_match( '/' . $hook . '="/', $html ) ? str_replace( $hook . '="', $hook . '="' . $selector . '[gallery-' . $pid . '] ', $html ) : str_replace( '<a ', '<a ' . $hook . '="' . $selector . '[gallery-' . $pid . ']" ', $html );
		
		return $html;
	}

}