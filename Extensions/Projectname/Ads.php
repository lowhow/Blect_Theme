<?php namespace Extensions\Projectname;
use \Framework\Core\Observer as Observer;
use \Framework\WordPress\Loader as Loader;

class Ads implements Observer
{	
	private $loader;

	public function __construct( Loader $loader )
	{
		$this->loader = $loader;
	}

	public function handle() 
	{
		$this->loader
		->add_action ( 'wp_head', $this, 'dfp_inline_script' );
		return $this;
	}
	
	/**
	 * [dfp_inline_script description]
	 * @param  [type] $atts    [description]
	 * @param  [type] $content [description]
	 * @return [type]          [description]
	 */
	public function dfp_inline_script()
	{ 	
	?>
	    <script type='text/javascript'>
		var googletag = googletag || {};
		googletag.cmd = googletag.cmd || [];
		(function() {
		var gads = document.createElement('script');
		gads.async = true;
		gads.type = 'text/javascript';
		var useSSL = 'https:' == document.location.protocol;
		gads.src = (useSSL ? 'https:' : 'http:') + 
		'//www.googletagservices.com/tag/js/gpt.js';
		var node = document.getElementsByTagName('script')[0];
		node.parentNode.insertBefore(gads, node);
		})();
		</script>

		<script type='text/javascript'>
		googletag.cmd.push(function() {
		googletag.defineSlot('/13429347/101-leaderboard-bottom', [728, 90], 'div-gpt-ad-1418719160721-0').addService(googletag.pubads());
		googletag.defineSlot('/13429347/101-leaderboard-top', [728, 90], 'div-gpt-ad-1418719160721-1').addService(googletag.pubads());
		googletag.defineSlot('/13429347/101-medium-rec-1', [300, 250], 'div-gpt-ad-1418719160721-2').addService(googletag.pubads());
		googletag.defineSlot('/13429347/101-medium-rec-2', [300, 250], 'div-gpt-ad-1418719160721-3').addService(googletag.pubads());
		googletag.defineSlot('/13429347/101-medium-rec-3', [300, 250], 'div-gpt-ad-1418719160721-4').addService(googletag.pubads());
		googletag.defineSlot('/13429347/101-mobile-bottom', [320, 50], 'div-gpt-ad-1418719160721-5').addService(googletag.pubads());
		googletag.defineSlot('/13429347/101-mobile-top', [320, 50], 'div-gpt-ad-1418719160721-6').addService(googletag.pubads());
		googletag.pubads().enableSingleRequest();
		googletag.enableServices();
		});
		</script>
	<?php
	}
}
