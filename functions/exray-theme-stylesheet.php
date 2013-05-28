<?php
/* Hook to WordPress*/
add_action( 'wp_head', 'exray_theme_customize_css' );
add_action( 'wp_head', 'exray_theme_custom_css' );

/*	Hook custom css value from Theme Options to wp_head  */
function exray_theme_custom_css(){
	$custom_css_options = get_option('exray_custom_css');

	if(!empty( $custom_css_options ) ) :
?>
	<style type="text/css">
		
		<?php echo esc_textarea( $custom_css_options ) ; ?>

	</style>

<?php
	endif;
}

/*	Hook css value from Theme Customizer to wp_head */
function exray_theme_customize_css(){ 
	// Color local variable
	$customizer_options = get_option( 'exray_custom_settings' ); 
	$top_menu_color = isset( $customizer_options['top_menu_color'] ) ? $customizer_options['top_menu_color'] : '#f5f5f5';
	$main_menu_color = isset( $customizer_options['main_menu_color'] ) ? $customizer_options['main_menu_color'] : '#f5f5f5';
	$link_color = isset ( $customizer_options['link_color'] ) ? $customizer_options['link_color'] : '#0d72c7';
	$header_color = isset( $customizer_options['header_color'] ) ? $customizer_options['header_color'] : '#ffffff';
	$bg_color = isset( $customizer_options['bg_color'] ) ? $customizer_options['bg_color'] : '#ffffff';
	$footer_color = isset( $customizer_options['footer_color']  ) ? $customizer_options['footer_color'] : '#f7f7f7';
	$copyright_container_color = isset( $customizer_options['copyright_container_color'] ) ? $customizer_options['copyright_container_color'] : '#ededed';

	// Check brightness
	$top_menu_brightness = get_brightness( $top_menu_color );
	$main_menu_brightness = get_brightness( $main_menu_color );	

	if(!empty($customizer_options) ) :
?>	
	 <style type="text/css">
	 
		/*Link*/
		a, p a, h5 a { 
			color: <?php echo ( $link_color ); ?>; 
		}

		/*Top Navigation*/
		.top-menu-container, .top-menu-container .top-menu-navigation ul>li ul li{
			background: <?php echo $top_menu_color;  ?>;
		}
		

		.top-menu-container .top-menu-navigation ul>li ul{
			/* 	Check if input color light or dark color, if it's light color, return darker color of input color 	*/

			<?php if($top_menu_brightness == true): ?>
				border: 1px solid <?php echo colourCreator($top_menu_color, -10); ?> ;
			<?php else: ?>
				border: 1px solid <?php echo colourCreator($top_menu_color, 10) ;?> ;
			<?php endif; ?>
		}

			.top-menu-container .top-menu-navigation ul>li ul li{
				<?php if($top_menu_brightness == true): ?>
					border-bottom: 1px solid <?php echo colourCreator($top_menu_color, -10); ?> ;
				<?php else: ?>
					border-bottom: 1px solid <?php echo colourCreator($top_menu_color, 10) ;?> ;
				<?php endif; ?>
			}	

				.top-menu-container .top-menu-navigation ul>li ul li a:hover{
					<?php if($top_menu_brightness == true): ?>
						background: <?php echo colourCreator($top_menu_color, -10); ?> ;
					<?php else: ?>
						background: <?php echo colourCreator($top_menu_color, 10) ;?> ;
					<?php endif; ?>
				}

		.top-menu-container .top-menu-navigation ul > li a, .top-menu-container .top-menu-navigation ul > li a::before, .adaptive-top-nav li a{
			/*	Create contrast color from menu backround color	*/

			color: <?php echo getContrastYIQ($top_menu_color);?> ;
		}
		
		.header-container {
			background:  <?php echo $header_color; ?>;
		}
		

		/*Main Navigation */
		.main-menu-container,  .main-menu-container .main-menu-navigation ul>li ul li{
			background: <?php echo $main_menu_color; ?>;
		}
		
		 .main-menu-container .main-menu-navigation ul>li a:hover, .main-menu-container .current_page_item{
			<?php if($main_menu_brightness == true): ?>
				background: <?php echo colourCreator($main_menu_color, -10); ?> ;
			<?php else: ?>
				background: <?php echo colourCreator($main_menu_color, 10) ;?> ;
			<?php endif; ?>
		 }	

		.main-menu-container .main-menu-navigation ul>li ul{
			<?php if($main_menu_brightness == true): ?>
				border: 1px solid <?php echo colourCreator($main_menu_color, -10); ?> ;
			<?php else: ?>
				border: 1px solid <?php echo colourCreator($main_menu_color, 10) ;?> ;
			<?php endif; ?>
		}

			.main-menu-container .main-menu-navigation ul>li ul li{
				<?php if($main_menu_brightness == true): ?>
					border-bottom: 1px solid <?php echo colourCreator($main_menu_color, -10); ?> ;
				<?php else: ?>
					border-bottom: 1px solid <?php echo colourCreator($main_menu_color, 10) ;?> ;
				<?php endif; ?>
			}	

				.main-menu-container .main-menu-navigation ul>li ul li a:hover{
					<?php if($main_menu_brightness == true): ?>
						background: <?php echo colourCreator($main_menu_color, -10); ?> ;
					<?php else: ?>
						background: <?php echo colourCreator($main_menu_color, 10) ;?> ;
					<?php endif; ?>
				}

		.main-menu-container  .main-menu-navigation ul > li a, .adaptive-main-nav li a {
			color: <?php echo getContrastYIQ($main_menu_color); ?> ;
		}

		/*isset( r*/
		.wrap{
			background: <?php echo $bg_color; ?> ; 
		}

		.footer-widget-area{
			background: <?php echo $footer_color; ?>;
		}

		.copyright-container{
			background: <?php echo $copyright_container_color ; ?>;
		}	
	   
	 </style>
<?php
	endif;
}

// Create Contrast color For link color on menu
function getContrastYIQ($hexcolor){

	//take care # from color hex value
	$hexcolor= ltrim ($hexcolor,'#');
	$r = hexdec(substr($hexcolor,0,2));
	$g = hexdec(substr($hexcolor,2,2));
	$b = hexdec(substr($hexcolor,4,2));

	$yiq = (($r*299)+($g*587)+($b*114))/1000;

	return ($yiq >= 128) ? '#333333' : '#fafafa';
}

// Check if color is dark or light 
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
		 $result = false; 	//dark color	
	}
	
	return $result;
}

//Make input color Darker or Lighter
function colourCreator($colour, $per){
  
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