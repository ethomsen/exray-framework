<?php
add_action( 'admin_init', 'exray_theme_custom_css_init');

function get_second_tab_content(){
		// The default message that will appear if Custom CSS form empty
    $custom_css_default = __( '/*

Welcome to the Custom CSS editor!
	 
Please add all your custom CSS here and avoid modifying the core theme files, since that\'ll make upgrading the theme problematic Your custom CSS will be loaded after the theme\'s stylesheets, which means that your rules will take precedence. Just add your CSS here for what you want to change, you don\'t need to copy all the theme\'s style.css content.
	
*/', 'exray-framework' );
	
    $exray_custom_css_options = get_option( 'exray_custom_css', $custom_css_default );
	settings_fields( 'exray_custom_css_options_group' ); 
?>
	<h3><?php _e('Custom CSS', 'exray-framework'); ?></h3>
	<p><?php _e('Add your custom CSS below. For your information, Custom css below will override colors from', 'exray-framework'); ?> <a href="<?php echo admin_url('customize.php'); ?>" title="Theme Customizer">Theme Customizer</a></p>
	<textarea id="custom_css_textarea" name="exray_custom_css" style="height:300px;" placeholder="<?php echo _e('/*** Add your custom CSS here. Do not edit style.css directly. ***/', 'exray-framework'); ?>"><?php echo esc_textarea( $exray_custom_css_options ); ?></textarea>
<?php
}

// Initialize Custom css settings
function exray_theme_custom_css_init(){

	register_setting( 
		'exray_custom_css_options_group', 
		'exray_custom_css',
		'exray_theme_display_validation'
	);
}

/* Validate Custom CSS Page */
function exray_theme_display_validation( $input ) {
    if ( ! empty( $input['exray_custom_css'] ) )
       $input['exray_custom_css'] = trim($input['exray_custom_css'] );

    return $input;
}

?>