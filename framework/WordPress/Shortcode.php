<?php namespace Framework\WordPress;

class Shortcode
{	
	/**
	 * Add shortcodes
	 */
	public function add() 
	{
		add_shortcode( 'fw-adsize', array( $this, 'adsize' ) );
	}

	/**
	 * Ad Size
	 * @param  array 	$atts [description]
	 * @return string   HTML string
	 */
	public function adsize( $atts  )
	{ 	
		/**
		 * Return documentation
		 */
		if ( $atts !== '' && in_array( '-help', $atts ) ){
			?>
			<div class="well well-sm">
				<a class="btn btn-default btn-xs pull-right" href="https://github.com/lowhow/BLECT_WP_Theme/wiki/Shortcodes#fw-adsize" target="_blank">Docs</a>
				<h4>[fw-adsize] <small>-help </small></h4 class="margin">
				<dl>
					<dt><code>size=''</code> <small><em>(recommended)</em></small></dt>
					<dd><small class="text-">Specify ad size: width by height = <samp>'300x250'</samp>. If <b>size</b> is specified, <b>name</b> will be ignored.</small></dd>

					<dt><code>name=''</code> <small><em>(optional)</em></small></dt>
					<dd><small class="text-">Use ad size name. If <b>size</b> is specified, <b>name</b> will be ignored. Accepted values:
						<ul>
							<li><samp>'medium rectangle'</samp> <small class="text-info">300x250</small></li>
							<li><samp>'large rectangle'</samp> <small class="text-info">336x280</small></li>
							<li><samp>'square'</samp> <small class="text-info">250x250</small></li>
							<li><samp>'leaderboard'</samp> <small class="text-info">728x90</small></li>
							<li><samp>'banner'</samp> <small class="text-info">468x60</small></li>
							<li><samp>'wide skyscraper'</samp> <small class="text-info">160x600</small></li>
							<li><samp>'half page'</samp> <small class="text-info">300x600</small></li>
							<li><samp>'large mobile banner'</samp> <small class="text-info">320x100</small></li>
							<li><samp>'mobile leaderboard'</samp> <small class="text-info">320x50</small></li>
						</ul>
					</small></dd>			

					<dt><code>text=''</code> <small><em>(optional)</em></small></dt>
					<dd><small class="text-">text to include in ad.</small></dd>

					<dt><code>bg_color=''</code> <small><em>(optional)</em></small></dt>
					<dd><small class="text-">Accepts hex code without '#'. Default <samp>'fce197'</samp></small></dd>

					<dt><code>text_color=''</code> <small><em>(optional)</em></small></dt>
					<dd><small class="text-">Accepts hex code without '#'. Default <samp>'ea7b82'</samp></small></dd>
				</dl>

			</div>
			<?php
			return;
		}

		$img_placeholder 	= 'http://fpoimg.com/';
		$size 			 	= '300x250';
		$text 			 	= 'Advertisement';
		$bg_color			= 'fce197';
		$text_color 		= 'ea7b82';

		if ( isset( $atts['text'] ) )
			$text = $atts['text'];

		if ( isset( $atts['bg_color'] ) )
			$bg_color = $atts['bg_color'];

		if ( isset( $atts['text_color'] ) )
			$text_color = $atts['text_color'];


		if ( isset( $atts['size'] ) )
		{
			$size = $atts['size'];
		}
		elseif ( isset( $atts['name'] ) )
		{
			$name = strtolower( $atts['name'] );

			switch( $name )
			{
				case 'medium rectangle':
					$size = '300x250';
					break;

				case 'large rectangle':
					$size = '336x280';
					break;

				case 'square':
					$size = '250x250';
					break;

				case 'leaderboard':
					$size = '728x90';
					break;

				case 'banner':
					$size = '468x60';
					break;

				case 'wide skyscraper':
					$size = '160x600';
					break;

				case 'half page':
					$size = '300x600';
					break;

				case 'large mobile banner':
					$size = '320x100';
					break;

				case 'mobile':
					$size = '320x50';
					break;
			}
		}

		$img_placeholder 	= $img_placeholder . $size . '?' . 
		'text=' . $text . '&' .
		'bg_color=' . $bg_color . '&' .
		'text_color=' . $text_color;


	    return '<img src="' . $img_placeholder . '" class="img-responsive aligncenter margin-top-0 margin-bottom-0" />';
	}
}
