<?php
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

/* Provides default values for Options. #neo */

function exray_theme_default_display_options() {
	
	$defaults = array(
		'show_slider' => '',
	);
	
	return apply_filters( 'exray_theme_default_display_options', $defaults );	
}

function exray_theme_default_social_options() {
	
	$defaults = array(
		'exray_theme_twitter' => '',
	);
	
	return apply_filters( 'exray_theme_default_social_options', $defaults );	
}


function exray_theme_default_input_options() {
	
	$defaults = array(
		'input_element'=> '', 
		'textarea_element'=> '',
		'checkbox_element'=> '',
		'radio_element'=> '', 
		'select_element'=> 'default'
	);
	
	return apply_filters( 'exray_theme_default_input_options', $defaults );	
}


/* Theme option Initialized*/
function exray_theme_options_init(){

	// Create theme options if not exist
	if(false == get_option('exray_theme_display_options') ){
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
		add_option('exray_theme_social_options' , apply_filters( 'exray_theme_default_social_options', exray_theme_default_social_options() ));
	}
	
	register_setting( 
		'exray_theme_social_options_group', 
		'exray_theme_social_options',
		'exray_theme_sanitize_social_options' // Sanitize data before saved to db
	 );
}

add_action( 'admin_init', 'exray_social_init');

// Initialize input Page
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
		add_option('exray_theme_input_options', apply_filters( 'exray_theme_default_input_options', exray_theme_default_input_options() ));
	}
	
	register_setting( 
		'exray_theme_input_options_group', 
		'exray_theme_input_options', 
		'exray_theme_sanitize_input_options' 
	);
}

add_action( 'admin_init', 'exray_input_init');

/*
* Callback Function
*/
function exray_general_options_callback(){
	echo '<p class="description">Select which areas of content you wish to display.</p>'; 
}

function exray_toggle_slider_callback($args){
	// call to add_settings_field
	$options = get_option('exray_theme_display_options', 'default_value');
	// #neo Check if Default Value exist
	$html = '<input type="checkbox" id="show_slider" name="exray_theme_display_options[show_slider]" value="1" ' . checked(1,  isset( $options['show_slider'] ) ? $options['show_slider'] : 0, false ) . '/>';
	
	// Here, we will take the first argument of the array and add it to a label next to the checkbox
	$html .= '<label for="show_slider">'  . $args[0] . '</label>';
	
	echo $html;
}

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

	echo '<input type="text" id="exray_theme_twitter" name="exray_theme_social_options[exray_theme_twitter]" value=" '. $url .' " />';
}


function exray_theme_input_callback(){
	$options = get_option( 'exray_theme_input_options');
	$value="";

	if(isset( $options['input_element'] )) {
		$value = $options['input_element'];
	}

	echo '<input type="text" name="exray_theme_input_options[input_element]" id="input_element" value=" '. $value .' " />';
}

function exray_theme_textarea_callback(){
	$options = get_option( 'exray_theme_input_options' );
	$value="";

	if(isset( $options['input_element'] )) {
		$value = $options['textarea_element'];
	}

	echo '<textarea name="exray_theme_input_options[textarea_element]" id="textarea_element" cols="80" rows="10">'.$value.'</textarea>';
}


function exray_theme_checkbox_callback(){
	$options = get_option( 'exray_theme_input_options' );
	$html = '<input type="checkbox" id="checkbox_element" name="exray_theme_input_options[checkbox_element]" value="1" '. checked( 1, isset( $options['checkbox_element']) ? $options['checkbox_element'] : 0 , false ) .'/>';
	$html .= '<label for="checkbox_element">Check to show something</label>';

	echo $html;
}

function exray_theme_radio_callback(){
	$options = get_option( 'exray_theme_input_options' );

	$html = '<input type="radio" id="radio_element" name="exray_theme_input_options[radio_element]" value="1" '. checked( 1, isset( $options['radio_element'] ) ? $options['radio_element'] : 0 , false ) .' />';
	$html .= '<label for="radio_element">Male</label>';

	$html .= '<input type="radio" id="radio_element_two" name="exray_theme_input_options[radio_element]" value="2" '. checked( 2, isset( $options['radio_element'] ) ? $options['radio_element'] : 0  , false ) .' />';
	$html .= '<label for="radio_element_two">Female</label>';

	echo $html;

}


function exray_theme_select_callback(){
	$options = get_option( 'exray_theme_input_options' );

	$html = '<select name="exray_theme_input_options[select_element]" id="select_element">';
		$html .= '<option value="default">Select an Option ...</option>';
		$html .= '<option value="never"' . selected( isset( $options['select_element'] ) ?  $options['select_element'] : 0, 'never', false) . '> Never </option>';
		$html .= '<option value="sometimes" '. selected( isset( $options['select_element'] ) ?  $options['select_element'] : 0 , 'sometimes', false ) .' >Sometimes</option>';
		$html .= '<option value="always" '. selected( isset( $options['select_element'] ) ?  $options['select_element'] : 0 , 'always', false ) .' >Always</option>';
	$html .= '</select>';

	echo $html;
}

/*
*  Sanitize input function 
*/

// Only URL from @param $input allowed saved to database
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




?>