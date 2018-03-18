<?php
/**
 * The theme default functions file.
 *
 * @package WordPress
 * @subpackage Vun_Hougkh
 * @since The Starry Night 1.0 with Vun Hougkh 1.0
 */

/**
 * Bootstrapping framework to WordPress theme and initialise.
 */
require get_template_directory() . '/blect-config.php';

function prevd($object){
	echo '<pre>';
	var_dump($object);
	echo '</pre>';
}

function current_url(){
	return $current_url =  trailingslashit('http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
}
