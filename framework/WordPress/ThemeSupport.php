<?php namespace Framework\WordPress;

class ThemeSupport 
{

	/**
	 * [add description]
	 */
	public function add_theme_support() 
	{

		/**
		 * Switches default core markup for search form, comment form, and comments to output valid HTML5.
		 */
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );

		/** 
		 * This theme uses a custom image size for featured images, displayed on "standard" posts and pages.
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * This theme supports all available post formats by default.
		 */
		add_theme_support( 'post-formats', array( 
			'aside', 		// - Typically styled without a title. Similar to a Facebook note update.
			'gallery',  // - A gallery of images. Post will likely contain a gallery shortcode and will have image attachments.
			'link',  		// - A link to another site. Themes may wish to use the first <a href=””> tag in the post content as the external link for that post. An alternative approach could be if the post consists only of a URL, then that will be the URL and the title (post_title) will be the name attached to the anchor for it.
			'image', 		// - A single image. The first <img /> tag in the post could be considered the image. Alternatively, if the post consists only of a URL, that will be the image URL and the title of the post (post_title) will be the title attribute for the image.
			'quote', 		// - A quotation. Probably will contain a blockquote holding the quote content. Alternatively, the quote may be just the content, with the source/author being the title.
			'status', 	// - A short status update, similar to a Twitter status update.
			'video', 		// - A single video or video playlist. The first <video /> tag or object/embed in the post content could be considered the video. Alternatively, if the post consists only of a URL, that will be the video URL. May also contain the video as an attachment to the post, if video support is enabled on the blog (like via a plugin).
			'audio', 		// - An audio file or playlist. Could be used for Podcasting.
			'chat', 		// - A chat transcript
		) );
		
		$args = array(
			'flex-width'    => true,
			'width'         => 1200,
			'flex-height'    => true,
			'height'        => 800,
			'default-image' => get_template_directory_uri() . '/assets/img/pinstriped_suit.jpg',
		);
		add_theme_support( 'custom-header', $args );

		/**
		 * Adds RSS feed links to <head> for posts and comments.
		 */
		//add_theme_support( 'automatic-feed-links' );


		return $this;

	}

}