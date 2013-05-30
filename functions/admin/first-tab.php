<?php
add_action( 'admin_init', 'exray_theme_general_options_init');
add_action( 'wp_head', 'exray_theme_add_to_head');
add_action( 'wp_footer', 'exray_theme_add_to_footer');

function get_first_tab_content()
{
	settings_fields( 'exray_theme_general_options_group' );
	do_settings_sections( 'exray_theme_general_options_page' );
}

// Initialize general option page setting section, field and settings
function exray_theme_general_options_init()
{
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
		'recaptcha_public_key', 
		__('reCaptcha Public Key', 'exray-framework'), 
		'recaptcha_public_key_callback', 
		'exray_theme_general_options_page', 
		'exray_theme_general_options_section'
	);

	add_settings_field( 
		'recaptcha_private_key', 
		__('reCaptcha Private Key', 'exray-framework'), 
		'recaptcha_private_key_callback', 
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

/***************************************************************/
/* Theme general option callback 							   */
/***************************************************************/

function exray_theme_general_options_section_callback()
{
	_e('You can modify Theme backend feature here. Looking to modify Theme Frontend / Visual style? Please check', 'exray-framework');
?>
	<a href="<?php echo admin_url('customize.php'); ?>" title="Theme Customizer">Theme Customizer</a>.
<?php
}

function contact_form_email_receiver_callback()
{
	global $exray_general_options;
	$email = '';

	if( isset($exray_general_options['contact_form_email_receiver'] ) && is_email( $exray_general_options['contact_form_email_receiver'] ) ){
		$email = $exray_general_options['contact_form_email_receiver'];
	}

	echo '<input type="text" name="exray_theme_general_options[contact_form_email_receiver]" id="contact_form_email_receiver" value="'. esc_attr( $email ) .'" style="width:300px;"/>';
	_e('&nbsp; All email from contact form will be sent to this email address.', 'exray-framework');
}

function recaptcha_public_key_callback()
{
	global $exray_general_options;
	$recaptcha_public_key = '';

	if( isset($exray_general_options['recaptcha_public_key'] ) ){
		$recaptcha_public_key = $exray_general_options['recaptcha_public_key'];
	}
	
	echo '<input type="text" name="exray_theme_general_options[recaptcha_public_key]" id="recaptcha_public_key" value="'. esc_attr( $recaptcha_public_key ) .'" style="width:300px;"/>';
	_e('&nbsp; Add your reCaptcha Public and Private key to activate reCaptcha.', 'exray-framework');
	echo popuplinks('<a href="http://www.google.com/recaptcha">GET reCAPTCHA</a>.');
}

function recaptcha_private_key_callback()
{
	global $exray_general_options;
	$recaptcha_private_key = '';

	if( isset($exray_general_options['recaptcha_private_key'] ) ){
		$recaptcha_private_key = $exray_general_options['recaptcha_private_key'];
	}

	echo '<input type="text" name="exray_theme_general_options[recaptcha_private_key]" id="recaptcha_private_key" value="'. esc_attr( $recaptcha_private_key ) .'" style="width:300px;"/>';
	_e('&nbsp; Be sure to keep this private key secret.', 'exray-framework');
}


function add_to_head_callback()
{
	global $exray_general_options;
	$default =  exray_theme_default_general_options();
	$option_to_head = $exray_general_options['add_to_head'];

	$content_to_head = ( $option_to_head ? esc_textarea( $option_to_head ) : $default['add_to_head'] );

	echo '<textarea name="exray_theme_general_options[add_to_head]" id="add_to_head" cols="30" rows="10">'. $content_to_head .'</textarea>';
}

function add_to_footer_callback()
{
	global $exray_general_options;
	$default =  exray_theme_default_general_options();
	$option_to_head = $exray_general_options['add_to_footer'];

	$content_to_footer = ( $option_to_head ? esc_textarea( $option_to_head ) : $default['add_to_footer'] );

	echo '<textarea name="exray_theme_general_options[add_to_footer]" id="add_to_footer" cols="30" rows="10">'. $content_to_footer .'</textarea>';
}

/***************************************************************/
/* Hook options value to wp_head and wp_footer						   */
/***************************************************************/
function exray_theme_add_to_head()
{
	global $exray_general_options;
	
	echo $exray_general_options['add_to_head'];
}

function exray_theme_add_to_footer()
{
	global $exray_general_options;

	echo $exray_general_options['add_to_footer'];
}

/***************************************************************/
/* Set default values for General Options.						   */
/***************************************************************/
function exray_theme_default_general_options() 
{
	
	$defaults = array(
		'contact_form_email_receiver' => '',
		'add_to_head' => '',
		'add_to_footer' => '',
		'recaptcha_public_key' => '',
		'recaptcha_private_key' => ''
	);
	
	return apply_filters( 'exray_theme_default_general_options', $defaults );	
}

/***************************************************************/
/* Validate all fields on general options page.					*/
/***************************************************************/
function exray_theme_validate_general_options($input)
{
	$valid = array();
	$valid['contact_form_email_receiver'] = sanitize_email( $input['contact_form_email_receiver'] );
	$valid['add_to_head']  = $input['add_to_head'] ; 
	$valid['add_to_footer']  = $input['add_to_footer'] ;
	$valid['recaptcha_public_key']  = $input['recaptcha_public_key'] ; 
	$valid['recaptcha_private_key']  = $input['recaptcha_private_key'] ;


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

?>