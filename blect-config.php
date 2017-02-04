<?php 
if( !defined( 'ABSPATH' ) ) {
	die;
}

/**
 Define Framework constants
 */
define( 'FW_NAME', 'BLECT' );
define( 'FW_VER', '2.0' );
define( 'FW_DIR', trailingslashit( dirname(__FILE__) . '/framework' ) );
define( 'FW_UPLOAD_DIR', trailingslashit( dirname( dirname( dirname( __DIR__ ) ) ) ) . 'data'  );
define( 'FW_UPLOAD_URI', trailingslashit( get_bloginfo( 'url' ) ) . 'data' );
define( 'FW_VENDOR_DIR', trailingslashit( dirname( dirname( dirname( __DIR__ ) ) ) . '/vendor' ) );
define( 'FW_VENDOR_URI', trailingslashit( get_bloginfo( 'url' ) ) . 'vendor' );
define( 'FW_THEME_DIR', trailingslashit( get_template_directory() ) );
define( 'FW_THEME_URI', trailingslashit( get_template_directory_uri() ) );
define( 'FW_THEME_ADMIN_DIR', trailingslashit( FW_THEME_DIR . 'admin' ) );
define( 'FW_THEME_ADMIN_URI', trailingslashit( FW_THEME_URI . 'admin' ) );
define( 'FW_TEXTDOMAIN', wp_get_theme()->get( 'TextDomain' ) );
define( 'FW_THEME_LANG_DIR', trailingslashit( FW_THEME_DIR ) . 'languages' ); /** Note: no Trailing slash */
define( 'FW_THEME_LANG_URI', trailingslashit( FW_THEME_URI . 'languages' ) );
define( 'FW_THEME_ASSETS_DIR', trailingslashit( FW_THEME_DIR . 'assets' ) );
define( 'FW_THEME_ASSETS_URI', trailingslashit( FW_THEME_URI . 'assets' ) );
define( 'FW_THEME_ASSETS_CSS_DIR', trailingslashit( FW_THEME_ASSETS_DIR . 'css' ) );
define( 'FW_THEME_ASSETS_CSS_URI', trailingslashit( FW_THEME_ASSETS_URI . 'css' ) );
define( 'FW_THEME_ASSETS_IMG_DIR', trailingslashit( FW_THEME_ASSETS_DIR . 'img' ) );
define( 'FW_THEME_ASSETS_IMG_URI', trailingslashit( FW_THEME_ASSETS_URI . 'img' ) );
define( 'FW_THEME_ASSETS_FAVICON_DIR', trailingslashit( FW_THEME_ASSETS_DIR . 'img' ) );
define( 'FW_THEME_ASSETS_FAVICON_URI', trailingslashit( FW_THEME_ASSETS_URI . 'img' ) );
define( 'FW_THEME_ASSETS_JS_DIR', trailingslashit( FW_THEME_ASSETS_DIR . 'js' ) );
define( 'FW_THEME_ASSETS_JS_URI', trailingslashit( FW_THEME_ASSETS_URI . 'js' ) );
define( 'FW_THEME_ASSETS_FONTS_DIR', trailingslashit( FW_THEME_ASSETS_DIR . 'fonts' ) );
define( 'FW_THEME_ASSETS_FONTS_URI', trailingslashit( FW_THEME_ASSETS_URI . 'fonts' ) );
define( 'FW_THEME_FRAMEWORK_DIR', trailingslashit( FW_THEME_DIR . 'framework' ) );
define( 'FW_THEME_FRAMEWORK_INCLUDE_DIR', trailingslashit( FW_THEME_FRAMEWORK_DIR . '/include' ) );

/**
 * Bootstrapping Composer Autoloading for namespaces
 */
require trailingslashit( FW_VENDOR_DIR ) . 'autoload.php';

/** 
 Bootstrapping Framework
 */
$blect = new Framework\ThemeSetup();
$blect->run();



