<?php

add_action( 'admin_menu', 'exray_theme_options' );
add_action( 'admin_init', 'exray_theme_general_options_init');
add_action( 'admin_init', 'exray_theme_custom_css_init');
add_action( 'wp_head', 'exray_theme_add_to_head');
add_action( 'wp_footer', 'exray_theme_add_to_footer');

/* Global Variable */
$exray_general_options = get_option('exray_theme_general_options');

/* Register and create Theme option page under Appearance */
function exray_theme_options(){
	add_theme_page( 'Exray Theme Options', 'Theme Options', 'edit_theme_options', 'exray_theme_options', 'exray_theme_page');
}

/* Render Theme Option page */
function exray_theme_page($active_tab= ''){
	// The default message that will appear if Custom CSS form empty
    $custom_css_default = __( '/*

Welcome to the Custom CSS editor!
	 
Please add all your custom CSS here and avoid modifying the core theme files, since that\'ll make upgrading the theme problematic Your custom CSS will be loaded after the theme\'s stylesheets, which means that your rules will take precedence. Just add your CSS here for what you want to change, you don\'t need to copy all the theme\'s style.css content.
	
*/', 'exray-framework' );
	
    $options = get_option( 'exray_custom_css', $custom_css_default );

?>
	<div class="wrap">
		<div id="icon-themes" class="icon32"></div>

		<?php settings_errors(); ?>
		
		<?php 
			if( isset( $_GET[ 'tab' ] ) ) {
				$active_tab = $_GET['tab'];  
			} 
			else if ($active_tab == 'custom_css'){
				$active_tab = 'custom_css';
			}else{
				$active_tab = 'general_options';
			}
		?>

		<h2 class="nav-tab-wrapper">
			<a href="?page=exray_theme_options&tab=general_options" class="nav-tab  <?php echo $active_tab == 'general_options' ? 'nav-tab-active' : ''; ?>"><?php _e('General Options', 'exray-framework'); ?></a>
			<a href="?page=exray_theme_options&tab=custom_css" class="nav-tab  <?php echo $active_tab == 'custom_css' ? 'nav-tab-active' : ''; ?>"><?php _e('Custom CSS', 'exray-framework'); ?></a>
		</h2>

		<form id="template" style="margin-top: 15px;" action="options.php" method="post" >

		 	<?php 
		 		if($active_tab == 'general_options'){
		 			settings_fields( 'exray_theme_general_options_group' );
		 			do_settings_sections( 'exray_theme_general_options_page' );
		 		}
		 		else if($active_tab == 'custom_css'){
		 			settings_fields( 'exray_custom_css_options_group' ); 

		 		?>
		 			<h3><?php _e('Custom CSS', 'exray-framework'); ?></h3>
					<p><?php _e('Add your custom CSS below. For your information, Custom css below will override colors from', 'exray-framework'); ?> <a href="<?php echo admin_url('customize.php'); ?>" title="Theme Customizer">Theme Customizer</a></p>

					<textarea id="custom_css_textarea" name="exray_custom_css" style="height:300px;" placeholder="<?php echo _e('/*** Add your custom CSS here. Do not edit style.css directly. ***/', 'exray-framework'); ?>"><?php echo esc_textarea( $options ); ?></textarea>
				<?php

				}

		 		else{
		 			$active_tab = 'general_options';
		 		}

		 		submit_button(); 

		 	?>

		</form>

	</div>

<?php
}

// Initialize general option page setting section, field and settings
function exray_theme_general_options_init(){
	global $exray_general_options;

	if(false == $exray_general_options ){
		add_option('exray_theme_general_options', apply_filters( 'exray_theme_default_general_options', exray_theme_default_general_options() ) );
	}

	add_settings_section( 
		'exray_theme_general_options_section', 
		'General Options', 
		'exray_theme_general_options_section_callback', 
		'exray_theme_general_options_page' 
	);

	add_settings_field( 
		'contact_form_email_receiver', 
		__('Contact form email receiver', 'exray-framework'), 
		'contact_form_email_receiver_callback', 
		'exray_theme_general_options_page', 
		'exray_theme_general_options_section'
	);

	add_settings_field( 
		'add_to_head', 
		__('Add Scripts before &lt;/head&gt;', 'exray-framework'), 
		'add_to_head_callback', 
		'exray_theme_general_options_page', 
		'exray_theme_general_options_section'
	);


	add_settings_field( 
		'add_to_footer', 
		__('Add Scripts before &lt;/body&gt;', 'exray-framework'), 
		'add_to_footer_callback', 
		'exray_theme_general_options_page', 
		'exray_theme_general_options_section'
	);

	register_setting( 
		'exray_theme_general_options_group', 
		'exray_theme_general_options',
		'exray_theme_validate_general_options'
	);

}

// Initialize Custom settings
function exray_theme_custom_css_init(){

	register_setting( 
		'exray_custom_css_options_group', 
		'exray_custom_css',
		'exray_theme_display_validation'
	);
}

/* Theme Option settings callback */
function exray_theme_general_options_section_callback(){
	_e('You can modify Theme backend feature here. Looking to modify Theme Frontend / Visual style? Please check', 'exray-framework');
?>
	<a href="<?php echo admin_url('customize.php'); ?>" title="Theme Customizer">Theme Customizer</a>.
<?php
}

function contact_form_email_receiver_callback(){
	global $exray_general_options;
	$email = '';

	if( isset($exray_general_options['contact_form_email_receiver'] ) && is_email( $exray_general_options['contact_form_email_receiver'] ) ){
		$email = $exray_general_options['contact_form_email_receiver'];
	}

	echo '<input type="text" name="exray_theme_general_options[contact_form_email_receiver]" id="contact_form_email_receiver" value="'. esc_attr( $email ) .'" style="width:300px;"/>';
	
}

function add_to_head_callback(){
	global $exray_general_options;
	$default =  exray_theme_default_general_options();
	$option_to_head = $exray_general_options['add_to_head'];

	$content_to_head = ( $option_to_head ? esc_textarea( $option_to_head ) : $default['add_to_head'] );

	echo '<textarea name="exray_theme_general_options[add_to_head]" id="add_to_head" cols="30" rows="10">'. $content_to_head .'</textarea>';
}

function add_to_footer_callback(){
	global $exray_general_options;
	$default =  exray_theme_default_general_options();
	$option_to_head = $exray_general_options['add_to_footer'];

	$content_to_footer = ( $option_to_head ? esc_textarea( $option_to_head ) : $default['add_to_footer'] );

	echo '<textarea name="exray_theme_general_options[add_to_footer]" id="add_to_footer" cols="30" rows="10">'. $content_to_footer .'</textarea>';
}

/* Hook option to wp_head and wp_footer	*/
function exray_theme_add_to_head(){
	global $exray_general_options;
	
	echo $exray_general_options['add_to_head'];
}

function exray_theme_add_to_footer(){
	global $exray_general_options;

	echo $exray_general_options['add_to_footer'];
}

/* Default values for General Options. */
function exray_theme_default_general_options() {
	
	$defaults = array(
		'contact_form_email_receiver' => '',
		'add_to_head' => '',
		'add_to_footer' => ''
	);
	
	return apply_filters( 'exray_theme_default_general_options', $defaults );	
}

/* Validate all fields on general options page */
function exray_theme_validate_general_options($input){
	$valid = array();
	$valid['contact_form_email_receiver'] = sanitize_email( $input['contact_form_email_receiver'] );
	$valid['add_to_head']  = $input['add_to_head'] ; 
	$valid['add_to_footer']  = $input['add_to_footer'] ;

	if($valid['contact_form_email_receiver'] != $input['contact_form_email_receiver'] ){

		add_settings_error(
	        'contact_form_email_receiver',           
	        'contact_form_email_receiver_error',          
	        __('Invalid email, please fix', 'exray-framework'),  	
	        'error'                       
        );     

	}

	return $valid;
}

/* Validate Custom CSS Page */
function exray_theme_display_validation( $input ) {
    if ( ! empty( $input['exray_custom_css'] ) )
       $input['exray_custom_css'] = trim($input['exray_custom_css'] );

    return $input;
}

?>