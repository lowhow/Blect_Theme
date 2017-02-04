<?php namespace Extensions\Projectname;
use \Framework\Core\Observer as Observer;
use \Framework\WordPress\Loader as Loader;

class Quicktags implements Observer
{
	private $loader;

	public function __construct( Loader $loader )
	{
		$this->loader = $loader;
	}

	public function handle()
	{
		$this->loader
		->add_action( 'admin_print_footer_scripts', $this, 'custom_panel_quicktags' );
		return $this;
	}

	/**
	 * Ad Size
	 * @param  array 	$atts [description]
	 * @return string   HTML string
	 */
	public function custom_panel_quicktags() {
	    if (wp_script_is('quicktags')){
	    	/**
	    	 * Usage:
	    	 * QTags.addButton( id, display, arg1, arg2, access_key, title, priority, instance );
	    	 *
	    	 * id
	    	 * (string) (required) The html id for the button.
	    	 * Default: None
	    	 *
	    	 * display
	    	 * (string) (required) The html value for the button.
	    	 * Default: None
	    	 *
	    	 * arg1
	    	 * (string) (required) Either a starting tag to be inserted like "<span>" or a callback that is executed when the button is clicked.
	    	 * Default: None
	    	 *
	    	 * arg2
	    	 * (string) (optional) Ending tag like "</span>". Leave empty if tag doesn't need to be closed (i.e. "<hr />").
	    	 * Default: None
	    	 *
	    	 * access_key
	    	 * (string) (optional) Shortcut access key for the button.
	    	 * Default: None
	    	 *
	    	 * title
	    	 * (string) (optional) The html title value for the button.
	    	 * Default: None
	    	 *
	    	 * priority
	    	 * (int) (optional) A number representing the desired position of the button in the toolbar. 1 - 9 = first, 11 - 19 = second, 21 - 29 = third, etc.
	    	 * Default: None
	    	 *
	    	 * instance
	    	 * (string) (optional) Limit the button to a specific instance of Quicktags, add to all instances if not present.
	    	 * Default: None
	    	 */
		?>
		    <script type="text/javascript">
		    QTags.addButton( 'fw_h2', 'H2', '<h2>', '</h2>', '', 'Heading 2', 1 );
		    QTags.addButton( 'fw_h3', 'H3', '<h3>', '</h3>', '', 'Heading 3', 1 );
		    QTags.addButton( 'fw_h4', 'H4', '<h4>', '</h4>', '', 'Heading 4', 1 );
		    QTags.addButton( 'fw_small', 'small', '<small>', '</small>', '', 'Small text', 1 );
		    QTags.addButton( 'fw_hr', 'hr', '<hr />', null, '', 'Horizontal ruler', 100 );
		    QTags.addButton( 'fw_address', 'address', '<address>', '</address>', '', 'Address', 100 );
		    QTags.addButton( 'fw_divrow', 'div.row', '<div class="row">', '</div>', '', 'Bootstrap row', 110 );
		    QTags.addButton( 'fw_bs_collapse_sample', 'Collapse example', '[bs_collapse_sample]', null, '', 'Bootstrap row', 200 );
		    </script>
		<?php
	    }
	}
}
