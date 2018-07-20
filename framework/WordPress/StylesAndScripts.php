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
         * MMenu Stylesheet
         */
        wp_enqueue_style('mmenu', trailingslashit(FW_NPM_URI) . 'jQuery.mmenu/dist/jquery.mmenu.all.css', array(), null);

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
         * jQuery
         *
         * Replace WordPress bundled version with our own version
         */
        wp_deregister_script('jquery');
        wp_enqueue_script('jquery', trailingslashit(FW_NPM_URI) . 'jquery/dist/jquery.min.js', array(), null, TRUE);

        /**
         * Popper.js
         */
        wp_enqueue_script( 'popper-js', trailingslashit( FW_NPM_URI ) . 'popper.js/dist/umd/popper.min.js', array( 'jquery' ), null, TRUE );

        /**
         * Bootstrap Script
         */
	  	wp_enqueue_script( 'bs-js', trailingslashit( FW_NPM_URI ) . 'bootstrap/dist/js/bootstrap.min.js', array( 'popper-js','jquery' ), null, TRUE );

        /**
         * MMENU
         */
        wp_enqueue_script('mmenu', trailingslashit( FW_NPM_URI ) . 'jquery.mmenu/dist/jquery.mmenu.all.js', array('jquery'), null, TRUE);
        wp_enqueue_script('mmenuwrapper', trailingslashit( FW_NPM_URI ) . 'jquery.mmenu/dist/wrappers/bootstrap/jquery.mmenu.bootstrap4.js', array('mmenu'), null, TRUE);

        /**
         * GSAP
         */
        wp_enqueue_script('gsap', trailingslashit( FW_NPM_URI ) . 'gsap/src/minified/TweenMax.min.js', array('jquery'), null, TRUE);

        /**
         * Adding Theme's script .
         */
        wp_enqueue_script('application-js', trailingslashit(FW_THEME_ASSETS_JS_URI) . 'application.js', array('gsap','bs-js'), null, TRUE);

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
    }

}
