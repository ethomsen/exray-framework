<?php 
/***************************************************************/
/* Define Constant */
/***************************************************************/
define( 'HOME_URI', home_url() );
define( 'THEME_URI', get_stylesheet_directory_uri() );
define( 'THEME_IMAGES', THEME_URI . '/images' );
define( 'THEME_CSS', THEME_URI . '/css' );
define( 'THEME_JS', THEME_URI . '/js' );

/***************************************************************/
/* Custom Menu */
/***************************************************************/
function register_exray_menu(){
	register_nav_menus(array(
			'top-menu' => __('Top menu', 'exray-framework'),
			'main-menu' => __('Main menu', 'exray-framework')
		));
}

add_action('init', 'register_exray_menu');



/***************************************************************/
/* Load Javascript file*/
/***************************************************************/
function load_custom_scripts(){
	wp_enqueue_script( 'custom_scripts', THEME_JS . '/scripts.js',  array('jquery'), false, true);
}

add_action( 'wp_enqueue_scripts', 'load_custom_scripts');


/***************************************************************/
/* Set Maximum width of the uploaded Media*/
/***************************************************************/
if (!isset($content_width)) $content_width = 542;

/***************************************************************/
/* Register Sidebars*/
/***************************************************************/

if(function_exists('register_sidebar')){

	register_sidebar(
		array(
			'name' => __( 'Primary', 'exray-framework' ),
			'id' => 'primary',
			'description' => __('The left sidebar area', 'exray-framework'),
			'before_widget' => '<aside class="sidebar-widget clearfix">',
			'after_widget' => '</aside> <!--end sidebar-widget-->',
			'before_title' => '<h4>',
			'after_title' => '</h4>',
		)
	);

	register_sidebar(array(
			'name' => __( 'Secondary', 'exray-framework' ),
			'id' => 'secondary',
			'description' => __('The right sidebar area', 'exray-framework'),
			'before_widget' => '<aside class="sidebar-widget">',
			'after_widget' => '</aside> <!--end sidebar-widget-->',
			'before_title' => '<h4>',
			'after_title' => '</h4>',
	));

	register_sidebar(array(
			'name' => __('First Footer','exray-framework'),
			'id' => 'first-footer',
			'description' => __('The first footer from left','exray-framework'),
			'before_widget' => '<div class="span3"> <aside class="footer-widget" role="complementary">',
			'after_widget' => '</aside> </div> <!-- End span 3 Footer -->',
			'before_title' => '<h4 class="widget-title" role="heading">',
			'after_title' => '</h4>',

	));

	register_sidebar(array(
			'name' => __('Second Footer','exray-framework'),
			'id' => 'second-footer',
			'description' => __('The second footer from left','exray-framework'),
			'before_widget' => '<div class="span3"> <aside class="footer-widget" role="complementary">',
			'after_widget' => '</aside> </div> <!-- End span 3 Footer -->',
			'before_title' => '<h4 class="widget-title" role="heading">',
			'after_title' => '</h4>',

	));

	register_sidebar(array(
			'name' => __('Third Footer','exray-framework'),
			'id' => 'third-footer',
			'description' => __('The third footer from left','exray-framework'),
			'before_widget' => '<div class="span3"> <aside class="footer-widget" role="complementary">',
			'after_widget' => '</aside> </div> <!-- End span 3 Footer -->',
			'before_title' => '<h4 class="widget-title" role="heading">',
			'after_title' => '</h4>',

	));

	register_sidebar(array(
			'name' => __('Fourth Footer','exray-framework'),
			'id' => 'fourth-footer',
			'description' => __('The fourth footer from left','exray-framework'),
			'before_widget' => '<div class="span3"> <aside class="footer-widget" role="complementary">',
			'after_widget' => '</aside> </div> <!-- End span 3 Footer -->',
			'before_title' => '<h4 class="widget-title" role="heading">',
			'after_title' => '</h4>',

	));

}

/***************************************************************/
/* Add Post Thumbnail and Post Format Theme Support*/
/***************************************************************/

if(function_exists('add_theme_support')){
	add_theme_support('post-formats', array('link', 'quote', 'gallery', 'aside'));
	add_theme_support('post-thumbnails', array('post'));
	set_post_thumbnail_size( 150, 150, true);
}

if ( function_exists( 'add_image_size' ) ) {
	add_image_size('custom-blog-image', 542, 342); 
	add_image_size( 'category-thumb', 300, 9999 ); //300 pixels wide (and unlimited height)
	add_image_size( 'homepage-thumb', 220, 180, true ); //(cropped)
}

/***************************************************************/
/* Add infinity symbol on Post Format Aside */
/***************************************************************/
add_filter( 'the_content', 'exray_theme_aside_infinity', 9 ); // run before wpautop

function exray_theme_aside_infinity( $content ) {

	if ( has_post_format( 'aside' ) && !is_singular() )
		$content .= ' <a href="' . get_permalink() . '">&#8734;</a>';

	return $content;
}


/***************************************************************/
/* Localization*/
/***************************************************************/
function exray_theme_localization(){
	$lang_dir = THEME_URI. '/lang';
	
	load_theme_textdomain('exray-framework', $lang_dir);
}

add_action('after_theme_setup', 'exray_theme_localization');

/***************************************************************/
/* Display Comments*/
/***************************************************************/

function exray_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;

	if (get_comment_type() == 'pingback' || get_comment_type() == 'trackback' ) : ?>
	
			<li class="pingback" id="<?php comment_ID(); ?>">
				<article <?php comment_class('clearfix'); ?>>
					<header>
						 <h5><?php _e('Pingback:', 'exray-framework'); ?></h5>
						<p><?php edit_comment_link(); ?></p>
					</header>
					<p><?php comment_author_link(); ?></p>
				</article>
			</li>
			
    <?php endif; ?>

	<?php if (get_comment_type() == 'comment') : ?>

		<li id="comment-<?php comment_ID(); ?>">

			<article <?php comment_class('clearfix'); ?>>

				<header>
					 <h5><?php comment_author_link(); ?></h5>
					<p><span>on <?php comment_date();?> at <?php comment_time(); ?> - </span><?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?></p>

				</header>
				
				<figure class="comment-avatar">
					<?php 
					// Make Avatar size on Threaded comment children smaller than it's parent.
					$avatar_size= 64; 
					if($comment->comment_parent != 0){
						$avatar_size = 50;
					}

					echo get_avatar($comment, $avatar_size);

					?>
				</figure>
				
				<?php if($comment->comment_approved == '0'): ?>

					<p class="awaiting-moderation"><?php _e('Your comment is awaiting moderation','exray-framework'); ?></p>

				<?php endif; ?>

				<?php comment_text(); ?>
			
			</article>

	<?php endif; 

}

/***************************************************************/
/* Custom comment Form */
/***************************************************************/

function exray_custom_comment_form($defaults){

	$defaults['comment_notes_before'] = ''; 
    $defaults['id_form'] = 'comment_form';
    $defaults['comment_field'] = '<p>
        <textarea name="comment" id="comment" cols="30" rows="10"> </textarea></p> ';
  
	return $defaults;
}

add_filter('comment_form_defaults', 'exray_custom_comment_form');


function exray_custom_comment_fields(){
    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');
    $aria_req = ($req ? "aria-required='true'": ' ' );

    $fields = array(
        'author' => '<p>' .
                    '<label for="author">'.__('Name', 'exray-framework') . ' ' . ($req ? '*' : '').'</label>' .
                    '<input type="text"  id="author" name="author" value="' . esc_attr($commenter['comment_author']) . '" '. $aria_req .' />'.
                    '</p>',
        'Email' => '<p>' .
                    '<label for="email">'.__('Email', 'exray-framework') . ' ' . ($req ? '*' : '').'</label>' .
                    '<input type="text"  id="email" name="email" value="' . esc_attr($commenter['comment_author_email']) . '" '. $aria_req .' />'.
                    '</p>',
        'url' => '<p>' .
                    '<label for="website">'.__('Website', 'exray-framework') . ' </label>' .
                    '<input type="text"  id="website" name="website" value="' . esc_attr($commenter['comment_author_url']) . '" />'.
                    '</p>',
        
    );
  
    return $fields;
}

add_filter('comment_form_default_fields', 'exray_custom_comment_fields');


/***************************************************************/
/* Load Custom Widget */
/***************************************************************/
require_once ('functions/widget-ad-260.php');

/***************************************************************/
/* Register/ Create Theme Customizer Option Field*/
/***************************************************************/
require_once ('functions/exray-customizer.php');


/***************************************************************/
/* Register/ Create Theme Option Page*/
/***************************************************************/
//require_once ('functions/exray-theme-options.php');

/***************************************************************/
/* Theme Color */
/***************************************************************/
add_action('wp_head', 'exray_theme_customize_css');

function exray_theme_customize_css(){
	$options = get_option( 'exray_custom_settings' );
	$top_menu_brightness = get_brightness($options['top_menu_color']);
	$main_menu_brightness = get_brightness($options['main_menu_color']);
	
?>	
	 <style type="text/css">
	 
		/*Link*/
		a, p a, h5 a { 
			color: <?php echo $options['link_color']; ?>; 
		}

		/*Top Navigation*/
		.top-menu-container, .top-menu-container .top-menu-navigation ul>li ul li{
			background: <?php echo $options['top_menu_color']; ?>;
		}
		

		.top-menu-container .top-menu-navigation ul>li ul{
			<?php if($top_menu_brightness == true): ?>
				border: 1px solid <?php echo colourCreator($options['top_menu_color'], -10); ?> !important;
			<?php else: ?>
				border: 1px solid <?php echo colourCreator($options['top_menu_color'], 10) ;?> !important;
			<?php endif; ?>
		}

			.top-menu-container .top-menu-navigation ul>li ul li{
				<?php if($top_menu_brightness == true): ?>
					border-bottom: 1px solid <?php echo colourCreator($options['top_menu_color'], -10); ?> !important;
				<?php else: ?>
					border-bottom: 1px solid <?php echo colourCreator($options['top_menu_color'], 10) ;?> !important;
				<?php endif; ?>
			}	

				.top-menu-container .top-menu-navigation ul>li ul li a:hover{
					<?php if($top_menu_brightness == true): ?>
						background: <?php echo colourCreator($options['top_menu_color'], -10); ?> !important;
					<?php else: ?>
						background: <?php echo colourCreator($options['top_menu_color'], 10) ;?> !important;
					<?php endif; ?>
				}

		.top-menu-navigation ul > li a{
			color: <?php echo getContrastYIQ($options['top_menu_color']); ?> !important;
		}
		
			.top-menu-navigation ul > li a::before{
				color: <?php echo getContrastYIQ($options['top_menu_color']); ?> !important;
			 }


		.header-container {
			background:  <?php echo $options['header_color']; ?>;
		}
		

		/*Main Navigation */
		.main-menu-container,  .main-menu-container .main-menu-navigation ul>li ul li{
			background: <?php echo $options['main_menu_color']; ?>;
		}
		
		 .main-menu-navigation ul>li a:hover{
			<?php if($main_menu_brightness == true): ?>
				background: <?php echo colourCreator($options['main_menu_color'], -10); ?> !important;
			<?php else: ?>
				background: <?php echo colourCreator($options['main_menu_color'], 10) ;?> !important;
			<?php endif; ?>
		 }	

		.main-menu-container .main-menu-navigation ul>li ul{
			<?php if($main_menu_brightness == true): ?>
				border: 1px solid <?php echo colourCreator($options['main_menu_color'], -10); ?> !important;
			<?php else: ?>
				border: 1px solid <?php echo colourCreator($options['main_menu_color'], 10) ;?> !important;
			<?php endif; ?>
		}

			.main-menu-container .main-menu-navigation ul>li ul li{
				<?php if($main_menu_brightness == true): ?>
					border-bottom: 1px solid <?php echo colourCreator($options['main_menu_color'], -10); ?> !important;
				<?php else: ?>
					border-bottom: 1px solid <?php echo colourCreator($options['main_menu_color'], 10) ;?> !important;
				<?php endif; ?>
			}	

				.main-menu-container .main-menu-navigation ul>li ul li a:hover{
					<?php if($main_menu_brightness == true): ?>
						background: <?php echo colourCreator($options['main_menu_color'], -10); ?> !important;
					<?php else: ?>
						background: <?php echo colourCreator($options['main_menu_color'], 10) ;?> !important;
					<?php endif; ?>
				}

		.main-menu-navigation ul > li a{
			color: <?php echo getContrastYIQ($options['main_menu_color']); ?> !important;
		}
		
			.main-menu-navigation ul > li a::before{
				color: <?php echo getContrastYIQ($options['main_menu_color']); ?> !important;
			 }
		
		/*Background color*/
		.wrap{
			background: <?php echo $options['bg_color']; ?> ; 
		}

		.footer-widget-area{
			background: <?php echo $options['footer_color']; ?>;
		}

		.copyright-container{
			background: <?php echo $options['copyright_container_color']; ?>;
		}	
	   
	 </style>
<?php
}

// Contrast For link color on menu
function getContrastYIQ($hexcolor){
	$hexcolor= ltrim ($hexcolor,'#');
	$r = hexdec(substr($hexcolor,0,2));
	$g = hexdec(substr($hexcolor,2,2));
	$b = hexdec(substr($hexcolor,4,2));

	//take care # from color hex value

	$yiq = (($r*299)+($g*587)+($b*114))/1000;

	return ($yiq >= 128) ? 'black' : 'white';
}

// Check if color is dark or light color
function get_brightness($hexcolor){
	// strip off any leading #
	$hexcolor = str_replace('#', '', $hexcolor);
	
	$r = hexdec(substr($hexcolor,0,2));
	$g = hexdec(substr($hexcolor,2,2));
	$b = hexdec(substr($hexcolor,4,2));
	$result = '';
	
	if($r + $g + $b > 382){
		
		 $result = true;	//bright color
	}
	else{
		 $result = false; //dark color	
	}
	
	return $result;
}

//Make input color Darker or Lighter
function colourCreator($colour, $per) 
{  
	$colour = substr( $colour, 1 ); // Removes first character of hex string (#)
	$rgb = ''; // Empty variable 
	$per = $per/100*255; // Creates a percentage to work with. Change the middle figure to control colour temperature
	 
	if  ($per < 0 ) // Check to see if the percentage is a negative number
	{ 
		// DARKER 
		$per =  abs($per); // Turns Neg Number to Pos Number 
		for ($x=0;$x<3;$x++) 
		{ 
			$c = hexdec(substr($colour,(2*$x),2)) - $per; 
			$c = ($c < 0) ? 0 : dechex($c); 
			$rgb .= (strlen($c) < 2) ? '0'.$c : $c; 
		}   
	}  
	else 
	{ 
		// LIGHTER         
		for ($x=0;$x<3;$x++) 
		{             
			$c = hexdec(substr($colour,(2*$x),2)) + $per; 
			$c = ($c > 255) ? 'ff' : dechex($c); 
			$rgb .= (strlen($c) < 2) ? '0'.$c : $c; 
		}    
	} 
	return '#'.$rgb; 
} 

?>


