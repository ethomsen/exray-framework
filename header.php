<!DOCTYPE html>
<html <?php language_attributes(); ?> >
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?> </title>
	<meta name="author" content="" >
	
	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" />
	
	<!-- Stylesheets -->
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url') ?>" media="all" /> 
	
	<!--[if lt IE 9]>a
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif] -->

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<!-- Script required for extra functionality on the comment form -->
	<?php if (is_singular()) wp_enqueue_script( 'comment-reply' ); ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class() ?> >

<?php $options = get_option( 'exray_custom_settings' ); ?>

	<!--[if lte IE 8 ]>
	<noscript>
		<strong>JavaScript is required for this website to be displayed correctly. Please enable JavaScript before continuing...</strong>
	</noscript>
	<![endif]-->
	
	<div id="page" class="wrap">
		
		<div class="header-container">
			
		<header class="top-header" id="top" role="banner">
			
			<div class="top-menu-container">
				<div class="container">
									
					<nav class="top-menu-navigation clearfix" role="navigation">

					<?php 
						wp_nav_menu( array( 
							'theme_location' => 'top-menu', 
							'container' => false, 
							'container_class' => false,
							'menu_class' => false,
							'fallback_cb' => 'exray_default_menu_fallback'
						) ); 
					?>

					</nav>
					
					<a href="" class="small-button menus" id="adaptive-top-nav-btn"><?php _e('Menu','exray-framework'); ?></a>
					<div class="adaptive-top-nav"></div> <!-- End adaptive-top-nav -->
				<!-- End top-menu-navigation -->
				</div>
				<!-- End container -->
			</div> 
			<!-- End top-menu-container -->
			<div class="container" id="header-wrap">

				<div class="row">
					<div class="span6 logo-container"> 
	
						<?php if($options['display_logo'] != 0) : ?>

							<?php if(is_home()) : ?>

								<!-- Display logo Image -->
								<h1 class="logo"> 
									<a href="<?php echo home_url(); ?>">
										<img src="<?php echo $options['exray_theme_logo']; ?>" alt="<?php bloginfo('name')?> | <?php bloginfo('description')?>" />
									</a>
								</h1>

							<?php else: ?>

								<p class="logo"> 
									<a href="<?php echo home_url(); ?>">
										<img src="<?php echo $options['exray_theme_logo']; ?>" alt="<?php bloginfo('name')?> | <?php bloginfo('description')?>" />
									</a>
								</p>

							<?php endif; ?>

						<?php else: ?>	

							<?php if(is_home()) : ?>

								<!-- Display text logo and tagline	 -->
								<hgroup>
									<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
									<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
								</hgroup>

							<?php else: ?>
								
								<!-- Display text logo and tagline	 -->
								<hgroup>
									<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
									<p class="site-description"><?php bloginfo( 'description' ); ?></p>
								</hgroup>

							<?php endif; ?>
									
						<?php endif; ?>					
						
					</div>	
					<!-- End span3 --> 	
					<div class="span6 clearfix">

						<?php if($options['display_top_ad'] && $options['top_ad'] !='') : ?>

						<aside id="header-widget" class="right-header-widget fr top-widget" role="complementary">

							<figure class="banner">
								<a href="<?php echo $options['top_ad_link']; ?>"><img src="<?php echo $options['top_ad']; ?>" class="centered" alt="Ad"></a>
							</figure>

						</aside>		
						<!-- End Header Widget	 -->
					<?php endif; ?>

					</div>	
					<!-- End Span9 -->						
				</div> 	
				<!-- End row -->
			</div>	
			<!-- End container -->
			<div class="main-menu-container">
				<div class="container">

					<nav class="main-menu-navigation clearfix" role="navigation">
						
					<?php 
						wp_nav_menu( array( 
							'theme_location' => 'main-menu', 
							'container' => false, 
							'container_class' => false,
							'menu_class' => false,
							'fallback_cb' => 'exray_default_menu_fallback'
						) ); 
				
					?>

					</nav>
                    
					<a href="" class="small-button menus" id="adaptive-main-nav-btn"><?php _e('Menu','exray-framework'); ?></a>
					<div class="adaptive-main-nav"></div> <!-- End adaptive-main-nav -->
				</div>
				<!-- End container -->
			</div> 
			<!-- End main-menu-container -->
		</header>	
		<!-- End top-main-header -->
		</div> 
			<!-- End header-container -->	
