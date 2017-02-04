<?php namespace Framework\Extensions;
use Framework\Core\Observer as Observer;
use Framework\WordPress\Loader as Loader;

class Woocommerce implements Observer
{
	private $loader;

	public function __construct( Loader $loader )
	{
		$this->loader = $loader;
	}

	public function handle()
	{
		$this->loader
			->remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10)
			->remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10)
			->add_action('woocommerce_before_main_content', $this, 'my_theme_wrapper_start', 10)
			->add_action('woocommerce_after_main_content', $this, 'my_theme_wrapper_end', 10)
			// ->add_filter( 'woocommerce_product_single_add_to_cart_text', $this, 'wc_custom_single_addtocart_text', 10, 2 )
			->add_action('after_setup_theme', $this, 'woocommerce_support');
			
;

		return $this;
	}

	/**
	 * [my_theme_wrapper_start description]
	 * @return [type] [description]
	 */
	public function my_theme_wrapper_start()
	{
		echo '<section id="wcmain">';
	}

	/**
	 * [my_theme_wrapper_end description]
	 * @return [type] [description]
	 */
	public function my_theme_wrapper_end()
	{
		echo '</section>';
	}

	/**
	 * [woocommerce_support description]
	 * @return [type] [description]
	 */
	public function woocommerce_support() {
		add_theme_support( 'woocommerce' );
	}

	/**
	 * [wc_custom_single_addtocart_text description]
	 * @param  [type] $text    [description]
	 * @param  [type] $product [description]
	 * @return [type]          [description]
	 */
	public function wc_custom_single_addtocart_text( $text, $product ) {
	    switch ( $product->product_type ) {
	        case 'simple'  : $text = 'Simple product text'; break;
	        case 'variable': $text = 'Variable product text'; break;
	        case 'external': $text = 'External product text'; break;
	        case 'grouped' : $text = 'Grouped product text'; break;
	        default        : $text = 'Add to Cart'; break;
	    }

	    return $text;
	}

}