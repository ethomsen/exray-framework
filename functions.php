<?php 
/***************************************************************/
/* Define Constant */
/***************************************************************/
define( 'HOME_URI', home_url() );
define( 'THEME_URI', get_template_directory_uri() );
define( 'THEME_IMAGES', THEME_URI . '/images' );
define( 'THEME_CSS', THEME_URI . '/css' );
define( 'THEME_JS', THEME_URI . '/js' );

/***************************************************************/
/* Exray class */
/***************************************************************/
require 'classes/exray.php';

/***************************************************************/
/* Theme template / parts */
/***************************************************************/
require 'functions/exray-theme-template.php';

/***************************************************************/
/* Load Custom Widget */
/***************************************************************/
require ('functions/widget-ad-260.php');

/***************************************************************/
/* Register/ Create Theme Customizer Option Field*/
/***************************************************************/
require ('functions/exray-theme-customizer.php');

/***************************************************************/
/* Theme default css ,custom css from Theme Customizer and Custom css*/
/***************************************************************/
require ('functions/exray-theme-stylesheet.php');

/***************************************************************/
/* Register/ Create Theme Option Page*/
/***************************************************************/
require ('functions/exray-theme-options.php');

$exray->set_max_content_width(542);
$exray->get_max_content_width();
$exray->load_custom_scripts(array(
	array(
		'handle' => 'custom_scripts', 
		'src' =>THEME_JS . '/scripts.js', 
		'deps' => array('jquery'), 
		'ver' => false, 
		'in_footer' => true 
	)
));

/***************************************************************/
/* Add Post Thumbnail and Post Format Theme Support*/
/***************************************************************/

if(function_exists('add_theme_support')){
	add_theme_support('post-formats', array('link', 'quote', 'gallery', 'aside'));
	add_theme_support('post-thumbnails', array('post'));
	add_theme_support('automatic-feed-links');
	set_post_thumbnail_size( 150, 150, true);	// Post Thumbnail default size
	add_image_size('custom-blog-image', 542, 342, false); 	
	
}

/***************************************************************/
/* Add infinity symbol on Post Format Aside */
/***************************************************************/
$exray->set_aside_symbol(true, '&#8734;');


/***************************************************************/
/* Localization*/
/***************************************************************/
$exray->load_theme_localization(THEME_URI. '/lang', 'exray-framework');

?>