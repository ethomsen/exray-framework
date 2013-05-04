<?php

add_action( 'admin_menu', 'exray_theme_options' );
add_action( 'admin_init', 'exray_theme_general_options_init');
add_action( 'admin_init', 'exray_theme_custom_css_init');
add_action( 'wp_head', 'exray_theme_add_to_head');
add_action( 'wp_footer', 'exray_theme_add_to_footer');

function exray_theme_options(){
	//Create Theme option page under Appearance
	add_theme_page( 'Exray Theme Options', 'Theme Options', 'administrator', 'exray_theme_options', 'exray_theme_page');
	add_theme_page('Customize', 'Customize', 'edit_theme_options', 'customize.php');
}

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
		 			echo 'You can add analytics scripts below. If you are looking to modify visual appearance, please go to <a href="customize.php">Theme Customize</a>';
		 			settings_fields( 'exray_theme_general_options_group' );
		 			do_settings_sections( 'exray_theme_general_options_page' );
		 		}
		 		else if($active_tab == 'custom_css'){
		 			settings_fields( 'exray_custom_css_options_group' ); 

		 		?>
		 			<h3><?php _e('Custom CSS', 'exray-framework'); ?></h3>
					<p><?php _e('Add your custom CSS below', 'exray-framework'); ?></p>
					<textarea id="custom_css_textarea" name="exray_custom_css" style="height:300px;" placeholder="<?php echo _e('/*** Add your custom CSS below. Do not edit style.css directly. ***/', 'exray-framework'); ?>"><?php echo $options; ?></textarea>
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

function exray_theme_general_options_init(){

	if(false == get_option('exray_theme_general_options') ){
		add_option('exray_theme_general_options');
	}

	add_settings_section( 
		'exray_theme_general_options_section', 
		'General Options', 
		'', 
		'exray_theme_general_options_page' 
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
		'exray_theme_general_options'
	);

}

function exray_theme_custom_css_init(){

	register_setting( 
		'exray_custom_css_options_group', 
		'exray_custom_css',
		'exray_theme_display_validation'
	);
}

function add_to_head_callback(){
	$options = get_option( 'exray_theme_general_options' );

	echo '<textarea name="exray_theme_general_options[add_to_head]" id="add_to_head" cols="30" rows="10">'.$options['add_to_head'].'</textarea>';
}

function add_to_footer_callback(){
	$options = get_option( 'exray_theme_general_options' );

	echo '<textarea name="exray_theme_general_options[add_to_footer]" id="add_to_footer" cols="30" rows="10">'.$options['add_to_footer'].'</textarea>';
}


function exray_theme_add_to_head(){
	$options = get_option( 'exray_theme_general_options' );

	echo $options['add_to_head'];
}

function exray_theme_add_to_footer(){
	$options = get_option( 'exray_theme_general_options' );

	echo $options['add_to_footer'];
}


function exray_theme_display_validation( $input ) {
    if ( ! empty( $input['exray_custom_css'] ) )
       $input['exray_custom_css'] = trim($input['exray_custom_css'] );

    return $input;
}

?>