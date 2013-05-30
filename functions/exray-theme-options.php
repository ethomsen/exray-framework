<?php

add_action( 'admin_menu', 'exray_theme_options' );

require('admin/first-tab.php');
require('admin/second-tab.php');

/* Register and create Theme option page under Appearance */
function exray_theme_options(){
	add_theme_page( 'Exray Theme Options', 'Theme Options', 'edit_theme_options', 'exray_theme_options', 'exray_theme_page');
}

/* Render Theme Option page */
function exray_theme_page($active_tab= ''){
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
		 			get_first_tab_content();
		 		}
		 		else if($active_tab == 'custom_css'){
		 			get_second_tab_content();
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


?>