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

/* Add new Option menu/ page to WordPress admin*/
function exray_theme_menu(){
	
	// Add theme page, Under 'Appearance' menu.
	add_theme_page(
		'Exray Theme', 
		'Exray Theme', 
		'administrator', 
		'exray_theme_options',
		'exray_theme_page'
	);
	// Xperiment
	add_menu_page( 
		'Exray Theme', 
		'Exray Theme', 
		'administrator', 
		'exray_theme_menu',
		'exray_theme_page'
	);

	add_submenu_page( 
		'exray_theme_menu', 
		'Display Options', 
		'Display Options', 
		'administrator',
		'exray_theme_display_options',
		'exray_theme_page'
	);

	add_submenu_page( 
		'exray_theme_menu', 
		'Social Options', 
		'Social Options', 
		'administrator',
		'exray_theme_social_options',
		create_function(null, 'exray_theme_page("social_options"); ')  // Pass Tab parameter to exray_theme_page function, If social options selected, show Content from social Tab.
	);

	add_submenu_page( 
		'exray_theme_menu', 
		'Input Examples', 
		'Input Examples', 
		'administrator',
		'exray_theme_input',
		create_function(null, 'exray_theme_page("input_options"); ')  
	);
}

add_action('admin_menu', 'exray_theme_menu');

/* Render Admin Page */

function exray_theme_page($active_tab = ''){
?>
	<!-- Standard admin wrapper -->
	<div class="wrap">
	<!-- Add icon on custom page -->
	<div id="icon-themes" class="icon32"></div>

		<h2>Exray Theme Options</h2>

		<!-- Display Setting Errors -->
		<?php settings_errors(); ?>
		
		<!-- Create tabbed menu on Option page -->

		<?php	
			if( isset( $_GET[ 'tab' ] ) ) {
				$active_tab = $_GET['tab'];  
			} 
			else if ($active_tab == 'social_options'){
				$active_tab = 'social_options';
			}
			else if ($active_tab == 'input_options'){
				$active_tab = 'input_options';
			}
			else{
				$active_tab = 'display_options';	
			}

		?>
		
		<h2 class="nav-tab-wrapper">
			<!-- List of Tab, Apply css active effect on selected active tab -->
			<a href="?page=exray_theme_options&tab=display_options" class="nav-tab <?php echo $active_tab == 'display_options' ? 'nav-tab-active' : ''; ?>">Display Options</a>
			<a href="?page=exray_theme_options&tab=social_options" class="nav-tab <?php echo $active_tab == 'social_options' ? 'nav-tab-active' : ''; ?>">Social Options</a>
			<a href="?page=exray_theme_options&tab=input_options" class="nav-tab <?php echo $active_tab == 'input_options' ? 'nav-tab-active' : ''; ?>">Input Options</a>
		</h2>

		<form action="options.php" method="post">
	
			<?php 
			// Show Page depend of which Tab selected
			if($active_tab == 'display_options'){
				//Section Slider
				settings_fields('exray_theme_options_page');
				do_settings_sections('exray_theme_options_page');
			}
			else if($active_tab == 'social_options'){
				// Section Social
				settings_fields('exray_theme_social_options_group');
				do_settings_sections( 'exray_theme_social_page' );
				
			}
			else if($active_tab == 'input_options'){
				settings_fields('exray_theme_input_options_group');
				do_settings_sections( 'exray_theme_input_page' );
				
			}
			else {
				$active_tab = 'display_options';
			}

			submit_button();
			?>
	
		</form>

	</div>
<?php	
}

/* Provides default values for the Display Options. #neo */

function exray_theme_default_display_options() {
	
	$defaults = array(
		'show_slider'		=>	'',
	);
	
	return apply_filters( 'exray_theme_default_display_options', $defaults );
	
}

/* Theme option Initialized*/
function exray_theme_options_init(){

	// Create theme options if not exist
	if(false == get_option('exray_theme_display_options', '') ){
		// #neo
		add_option( 'exray_theme_display_options', apply_filters( 'exray_theme_default_display_options', exray_theme_default_display_options() ) );
	}

	add_settings_section( 
		'general_settings_section', 
		'Display Options', 
		'exray_general_options_callback', 
		'exray_theme_options_page' 
	);

	add_settings_field(	
		'show_slider',						// ID used to identify the field throughout the theme
		'Slider',							// The label to the left of the option interface element
		'exray_toggle_slider_callback',	// The name of the function responsible for rendering the option interface
		'exray_theme_options_page',							// The page on which this option will be displayed
		'general_settings_section',			// The name of the section to which this field belongs
		array(								// The array of arguments to pass to the callback. In this case, just a description.
			'Activate this setting to display the slider.'
		)
	);

	register_setting( 
		'exray_theme_options_page', 						// option_group
		'exray_theme_display_options' 				//option_name
	);
}

add_action('admin_init', 'exray_theme_options_init');


// Callback function

function exray_general_options_callback(){
	echo '<p class="description">Select which areas of content you wish to display.</p>'; 
}


function exray_toggle_slider_callback($args){
	// call to add_settings_field
	$options = get_option('exray_theme_display_options', 'default_value');
	// #neo Check if Default Value exist
	$html = '<input type="checkbox" id="show_slider" name="exray_theme_display_options[show_slider]" value="1" ' . checked(1,  isset( $options['show_slider'] ) ? $options['show_header'] : 0, false ) . '/>';
	
	// Here, we will take the first argument of the array and add it to a label next to the checkbox
	$html .= '<label for="show_slider">'  . $args[0] . '</label>';
	
	echo $html;
}


// Initialize social options
function exray_social_init(){

	add_settings_section( 
		'exray_theme_social_section', 
		'Manage Social', 
		'exray_theme_social_section_callback', 
		'exray_theme_social_page' 
	);

	add_settings_field( 
		'exray_theme_twitter', 
		'Twitter', 
		'exray_theme_twitter_callback', 
		'exray_theme_social_page', 
		'exray_theme_social_section'
	);

	if(false == get_option('exray_theme_social_options')){
		add_option('exray_theme_social_options');
	}
	
	register_setting( 
		'exray_theme_social_options_group', 
		'exray_theme_social_options',
		'exray_theme_sanitize_social_options' // Sanitize data before saved to db
	 );
}

add_action( 'admin_init', 'exray_social_init');

function exray_theme_social_section_callback(){
	?>	
		<p class="description">Provide the URL to the social network you'd want to display</p>			
 <?php
}

function exray_theme_twitter_callback(){
	$options = get_option('exray_theme_social_options');
	$url = "";

	if(isset($options['exray_theme_twitter']) ){
		$url = $options['exray_theme_twitter'];
	}

	echo '<input type="text" id="exray_theme_twitter" name="exray_theme_social_options[exray_theme_twitter]" value=" '.$options['exray_theme_twitter'].' " />';
}

/*
* Only URL from @param $input allowed saved to database 
*/
function exray_theme_sanitize_social_options($input){
	 // Define the array for the updated options
	$output = array();

    // Loop through each of the options sanitizing the data  
	foreach($input as $key=> $val){

		if( isset( $input[$key] ) ){
			$output[$key] = esc_url_raw(strip_tags(stripslashes($input[$key])));
		}
	}

	return apply_filters('exray_theme_sanitize_social_options', $output, $input );
}

function exray_input_init(){
	add_settings_section( 
		'exray_theme_input_section', 
		'Manage Input', 
		'', 
		'exray_theme_input_page'
	);

	add_settings_field( 
		'input_element', 
		'Input Element', 
		'exray_theme_input_callback', 
		'exray_theme_input_page', 
		'exray_theme_input_section'
	);

	add_settings_field( 
		'textarea_element', 
		'Textarea Element', 
		'exray_theme_textarea_callback', 
		'exray_theme_input_page', 
		'exray_theme_input_section'
	);

	add_settings_field( 
		'checkbox_element', 
		'Checkbox Element', 
		'exray_theme_checkbox_callback', 
		'exray_theme_input_page', 
		'exray_theme_input_section'
	);

	add_settings_field( 
		'radio_element', 
		'Radio Element', 
		'exray_theme_radio_callback', 
		'exray_theme_input_page', 
		'exray_theme_input_section'
	);

	add_settings_field( 
		'select_element', 
		'Select Element', 
		'exray_theme_select_callback', 
		'exray_theme_input_page', 
		'exray_theme_input_section'
	);

	if(false == get_option('exray_theme_input_options')){
		add_option('exray_theme_input_options');
	}
	
	register_setting( 
		'exray_theme_input_options_group', 
		'exray_theme_input_options', 
		'exray_theme_sanitize_input_options' 
	);
}

add_action( 'admin_init', 'exray_input_init');

function exray_theme_input_callback(){
	$options = get_option( 'exray_theme_input_options');

	echo '<input type="text" name="exray_theme_input_options[input_element]" id="input_element" value=" '. $options['input_element'] .' " />';
}

function exray_theme_sanitize_input_options($input){
	// Create our array for storing the validated options  
	$output = array();

	// Loop through each of the incoming options  
	foreach ($input as $key => $value) {
		 // Check to see if the current option has a value. If so, process it. 
		if(isset($input[$key]) ){
			// Strip all HTML and PHP tags and properly handle quoted strings  
            $output[$key] = strip_tags( stripslashes( $input[ $key ] ) );  
		}
	}

	// Return the array processing any additional functions filtered by this action  
	return apply_filters( 'exray_theme_sanitize_input_options', $output, $input );
}


function exray_theme_textarea_callback(){
	$options = get_option( 'exray_theme_input_options' );

	echo '<textarea name="exray_theme_input_options[textarea_element]" id="textarea_element" cols="80" rows="10">'.$options['textarea_element'].'</textarea>';
}


function exray_theme_checkbox_callback(){
	$options = get_option( 'exray_theme_input_options' );
	$html = '<input type="checkbox" id="checkbox_element" name="exray_theme_input_options[checkbox_element]" value="1" '. checked( 1, $options['checkbox_element'], false ) .'/>';
	$html .= '<label for="checkbox_element">Check to show something</label>';

	echo $html;
}

function exray_theme_radio_callback(){
	$options = get_option( 'exray_theme_input_options' );

	$html = '<input type="radio" id="radio_element" name="exray_theme_input_options[radio_element]" value="1" '. checked( 1, $options['radio_element'], false ) .' />';
	$html .= '<label for="radio_element">Male</label>';

	$html .= '<input type="radio" id="radio_element_two" name="exray_theme_input_options[radio_element]" value="2" '. checked( 2, $options['radio_element'], false ) .' />';
	$html .= '<label for="radio_element_two">Female</label>';

	echo $html;

}

function exray_theme_select_callback(){
	$options = get_option( 'exray_theme_input_options' );

	$html = '<select name="exray_theme_input_options[select_element]" id="select_element">';
		$html .= '<option value="default">Select an Option ...</option>';
		$html .= '<option value="never" '. selected( $options['time_options'], 'never', false).' >Never</option>';
		$html .= '<option value="sometimes" '. selected( $options['select_element'], 'sometimes', false ) .' >Sometimes</option>';
		$html .= '<option value="always" '. selected( $options['select_element'], 'always', false ) .' >Always</option>';
	$html .= '</select>';

	echo $html;
}

?>


