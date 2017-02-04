<?php namespace Framework\WordPress;

class StylesAndScripts
{

    /**
     * Enqueue Styles with WordPress
     * @return [type]
     */
    public function enqueue_styles()
    {

        ////////////////////
        // stylesheets //
        ////////////////////
        /**
         * Link Skin Stylesheet (compiled and minified from LESS)
         */
        wp_enqueue_style('fontawesome', trailingslashit(FW_VENDOR_URI) . 'fontawesome/css/font-awesome.min.css', array(), null);
        wp_enqueue_style('fontawesome-cdn', '//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css', array(), null);

        /**
         * MMenu Stylesheet
         */
        wp_enqueue_style('mmenu', trailingslashit(FW_VENDOR_URI) . 'jQuery.mmenu/dist/css/jquery.mmenu.all.css', array(), null);

        /**
         * Link Skin Stylesheet (compiled and minified from LESS)
         */
        wp_enqueue_style('vendor', trailingslashit(FW_THEME_ASSETS_CSS_URI) . 'vendor.css', array(), null);

        /**
         * Main Stylesheet
         */
        wp_enqueue_style('main', trailingslashit(FW_THEME_ASSETS_CSS_URI) . 'skin.css', array('vendor'), null);

        return $this;

    }


    /**
     * Enqueue Scripts with WordPress
     * @return [type]
     */
    public function enqueue_scripts()
    {

        ///////////////
        // Scripts //
        ///////////////

        /**
         * Modernizr.js
         */
        wp_enqueue_script('modenizr-js', trailingslashit(FW_VENDOR_URI) . 'modernizr/modernizr.js', array(), null, TRUE);

        /**
         * jQuery
         *
         * Replace WordPress bundled version with our own version
         */
        wp_deregister_script('jquery');
        wp_enqueue_script('jquery', trailingslashit(FW_VENDOR_URI) . 'jquery/dist/jquery.min.js', array(), null, TRUE);

        /**
         * Bootstrap Script
         */
	  	wp_enqueue_script( 'bs-js', trailingslashit( FW_VENDOR_URI ) . 'bootstrap/dist/js/bootstrap.min.js', array( 'jquery' ), null, TRUE );

        /**
         * Kwicks Script
         */
//		wp_enqueue_script( 'kwicks-js', trailingslashit( FW_VENDOR_URI ) . 'kwicks/jquery.kwicks.min.js', array( 'jquery' ), null, TRUE );

        /**
         * Owl Carousel Script
         */
//		wp_enqueue_script( 'owl-js', trailingslashit( FW_VENDOR_URI ) . 'OwlCarousel/owl-carousel/owl.carousel.min.js', array( 'jquery' ), null, TRUE );

        /**
         * MMenu Script
         */
		wp_enqueue_script( 'mmenu-js', trailingslashit( FW_VENDOR_URI ) . 'jQuery.mmenu/dist/js/jquery.mmenu.min.all.js', array( 'jquery' ), null, TRUE );

        /**
         * jQuery Easing
         */
        wp_enqueue_script('jquery-easing', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js', array('jquery'), null, TRUE);

        /**
         * Register Vendor scripts
         */
        wp_enqueue_script('vendor-js', trailingslashit(FW_THEME_ASSETS_JS_URI) . 'vendor.js', array(), null, TRUE);

        /**
         * Adding Theme's script .
         */
        wp_enqueue_script('application-js', trailingslashit(FW_THEME_ASSETS_JS_URI) . 'application.js', array('vendor-js'), null, TRUE);


        return $this;

    }


    /**
     * [admin_enqueue_scripts description]
     * @return [type] [description]
     */
    public function admin_enqueue_styles()
    {
        /**
         * Main Stylesheet
         */
        wp_enqueue_style('admin', trailingslashit(FW_THEME_ASSETS_CSS_URI) . 'admin.css', array(), null);
    }


    /**
     * [admin_enqueue_scripts description]
     * @return [type] [description]
     */
    public function admin_enqueue_scripts()
    {
        wp_enqueue_media();

        wp_enqueue_script('admin-media-in-metabox-js', trailingslashit(FW_THEME_ASSETS_JS_URI) . 'admin-media-in-metabox.js', array('media-upload'), null);
        /**
         * Boostrap3 Script
         *
         * Becareful when enable this script. Might kill plugin page.
         */
        //wp_enqueue_script('bs3-js', trailingslashit(FW_VENDOR_URI) . '/bootstrap/dist/js/bootstrap.min.js', array(), null);

        /**
         * Main Script
         */
        wp_enqueue_script('admin-js', trailingslashit(FW_THEME_ASSETS_JS_URI) . 'admin.js', array(), null);

        /**
         * Moment.js Script
         */
        wp_enqueue_script( 'bs-js', trailingslashit( FW_VENDOR_URI ) . 'moment/min/moment.min.js', array(), null );

    }

}
