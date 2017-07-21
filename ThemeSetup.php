<?php use Framework as F;
use Extensions as Ext;
class ThemeSetup
{
	private $helper;
	private $themeSupport;
	private $navMenu;
	private $stylesAndScripts;
	private $extensionLoader;
	private $sustomPostTypeLoader;
	private $loader;
	private $textDomain;
	private $oEmbed;

	public function __construct()
	{
		$this->loader = new F\WordPress\Loader;
		$this->helper = new F\WordPress\Helper;
		$this->stylesAndScripts = new F\WordPress\StylesAndScripts;
		$this->themeSupport = new F\WordPress\ThemeSupport;
		$this->navMenu = new F\WordPress\NavMenu;
		$this->widget = new F\WordPress\Widget;
		$this->shortcode = new F\WordPress\Shortcode;
		$this->extensionLoader = new F\Core\ExtensionLoader;
		$this->textDomain = new F\WordPress\TextDomain;
		$this->oEmbed = new F\WordPress\OEmbed;

		global $helper;
		$helper = $this->helper;
	}

	/**
	 * Boot up and RUN!
	 * @return object
	 */
	public function run()
	{
		$this->loader
		->set_upload_path()
		->load_dependancies( array( 'wp_bootstrap_navwalker.php', 'simple_html_dom.php') )
		->add_action( 'after_setup_theme', $this->textDomain, 'load_theme_textdomain' )
		->add_action( 'after_setup_theme', $this->themeSupport, 'add_theme_support' )
		->add_action( 'after_setup_theme', $this->navMenu, 'register' )
		->add_action( 'widgets_init', $this->widget, 'register_sidebars' )
		->add_action( 'wp_enqueue_scripts', $this->stylesAndScripts, 'enqueue_styles' )
		->add_action( 'wp_enqueue_scripts', $this->stylesAndScripts, 'enqueue_scripts' )
		->add_action( 'admin_enqueue_scripts', $this->stylesAndScripts, 'admin_enqueue_styles' )
		->add_action( 'admin_enqueue_scripts', $this->stylesAndScripts, 'admin_enqueue_scripts' )
		->add_filter( 'wp_title', $this->helper, 'add_wp_title', 10, 2 )
		->add_filter( 'nav_menu_css_class', $this->navMenu, 'add_class_to_current_menu_item', 10, 2 )
		->add_filter( 'widget_text', NULL, 'shortcode_unautop' )
		->add_filter( 'widget_text', NULL, 'do_shortcode' )
		->add_filter( 'embed_oembed_html', $this->oEmbed, 'add_oembed_responsive_wrapper', 10, 4 )
		->remove_action( 'wp_head', 'wp_generator' )
		->remove_action( 'wp_head', 'wlwmanifest_link' )
		//->remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0)
		//->remove_action('wp_head', 'feed_links', 2)
		//->remove_action('wp_head', 'feed_links_extra', 3)
		//->remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 )
		->remove_action( 'wp_head', 'rsd_link' )
		->add_action( 'wp_head', $this->helper, 'add_favicon' )
		->add_action( 'init', $this->helper, 'disable_wp_emojicons' );

		$this->shortcode->add();

		$this->extensionLoader
		//->attach( new Extensions\PrettyPhoto )
		->attach( new Ext\Pagination( $this->loader ) )
		->attach( new Ext\Page( $this->loader ) )
		// ->attach( new Ext\SliderCustomPostType( $this->loader, 'slider', 'sliders') )
		// ->attach( new Extensions\EventCustomPostType( $this->loader, 'event', 'events', 'events') )
		// ->attach( new Extensions\Woocommerce( $this->loader ) )
		// ->attach( new Extensions\Search( $this->loader ) )
		// ->attach( new Extensions\JQueryAjaxify( $this->loader ) )
		->attach( new Ext\Projectname\Quicktags( $this->loader ) )
		// ->attach( new Extensions\Projectname\Shortcode( $this->loader ) )
		// ->attach( new Extensions\Projectname\Router( $this->loader ) )
		// ->attach( new Extensions\Projectname\Ajax( $this->loader ) )
		->load();

		$this->loader->run();

		return $this;
	}
}

