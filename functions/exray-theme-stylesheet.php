<?php

add_action( 'wp_head', 'exray_theme_customize_css' );
add_action( 'wp_head', 'exray_theme_custom_css' );

function exray_theme_custom_css(){
	$options = get_option('exray_custom_css');
	if(!empty($options) ) :
?>
	<style type="text/css">
		
		<?php echo $options; ?>

	</style>

<?php
	endif;
}

function exray_theme_customize_css(){
	$options = get_option( 'exray_custom_settings' );
	$top_menu_brightness = get_brightness(isset( $options['top_menu_color'] ) ? $options['top_menu_color']  : 'f5f5f5' )  ;
	$main_menu_brightness = get_brightness(isset( $options['main_menu_color'] ) ? $options['main_menu_color'] : 'f5f5f5' );	

	if(!empty($options) ) :
?>	
	 <style type="text/css">
	 
		/*Link*/
		a, p a, h5 a { 
			color: <?php echo $options['link_color']; ?>; 
		}

		/*Top Navigation*/
		.top-menu-container, .top-menu-container .top-menu-navigation ul>li ul li{
			background: <?php echo $options['top_menu_color'];  ?>;
		}
		

		.top-menu-container .top-menu-navigation ul>li ul{
			<?php if($top_menu_brightness == true): ?>
				border: 1px solid <?php echo colourCreator($options['top_menu_color'], -10); ?> ;
			<?php else: ?>
				border: 1px solid <?php echo colourCreator($options['top_menu_color'], 10) ;?> ;
			<?php endif; ?>
		}

			.top-menu-container .top-menu-navigation ul>li ul li{
				<?php if($top_menu_brightness == true): ?>
					border-bottom: 1px solid <?php echo colourCreator($options['top_menu_color'], -10); ?> ;
				<?php else: ?>
					border-bottom: 1px solid <?php echo colourCreator($options['top_menu_color'], 10) ;?> ;
				<?php endif; ?>
			}	

				.top-menu-container .top-menu-navigation ul>li ul li a:hover{
					<?php if($top_menu_brightness == true): ?>
						background: <?php echo colourCreator($options['top_menu_color'], -10); ?> ;
					<?php else: ?>
						background: <?php echo colourCreator($options['top_menu_color'], 10) ;?> ;
					<?php endif; ?>
				}

		.top-menu-container .top-menu-navigation ul > li a, .top-menu-container .top-menu-navigation ul > li a::before, .adaptive-top-nav li a{
			color: <?php echo getContrastYIQ($options['top_menu_color']);?> ;
		}
		
		.header-container {
			background:  <?php echo $options['header_color']; ?>;
		}
		

		/*Main Navigation */
		.main-menu-container,  .main-menu-container .main-menu-navigation ul>li ul li{
			background: <?php echo $options['main_menu_color']; ?>;
		}
		
		 .main-menu-container .main-menu-navigation ul>li a:hover, .main-menu-container .current_page_item{
			<?php if($main_menu_brightness == true): ?>
				background: <?php echo colourCreator($options['main_menu_color'], -10); ?> ;
			<?php else: ?>
				background: <?php echo colourCreator($options['main_menu_color'], 10) ;?> ;
			<?php endif; ?>
		 }	

		.main-menu-container .main-menu-navigation ul>li ul{
			<?php if($main_menu_brightness == true): ?>
				border: 1px solid <?php echo colourCreator($options['main_menu_color'], -10); ?> ;
			<?php else: ?>
				border: 1px solid <?php echo colourCreator($options['main_menu_color'], 10) ;?> ;
			<?php endif; ?>
		}

			.main-menu-container .main-menu-navigation ul>li ul li{
				<?php if($main_menu_brightness == true): ?>
					border-bottom: 1px solid <?php echo colourCreator($options['main_menu_color'], -10); ?> ;
				<?php else: ?>
					border-bottom: 1px solid <?php echo colourCreator($options['main_menu_color'], 10) ;?> ;
				<?php endif; ?>
			}	

				.main-menu-container .main-menu-navigation ul>li ul li a:hover{
					<?php if($main_menu_brightness == true): ?>
						background: <?php echo colourCreator($options['main_menu_color'], -10); ?> ;
					<?php else: ?>
						background: <?php echo colourCreator($options['main_menu_color'], 10) ;?> ;
					<?php endif; ?>
				}

		.main-menu-container  .main-menu-navigation ul > li a, .adaptive-main-nav li a {
			color: <?php echo getContrastYIQ($options['main_menu_color']); ?> ;
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
	endif;
}

// Contrast color For link color on menu
function getContrastYIQ($hexcolor){

	$hexcolor= ltrim ($hexcolor,'#');
	$r = hexdec(substr($hexcolor,0,2));
	$g = hexdec(substr($hexcolor,2,2));
	$b = hexdec(substr($hexcolor,4,2));

	//take care # from color hex value

	$yiq = (($r*299)+($g*587)+($b*114))/1000;

	return ($yiq >= 128) ? '#333333' : '#fafafa';
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