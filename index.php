<?php get_header(); ?>

<!-- Main Content -->
		<div class="container" id="main-container">
			
			<div class="row">
			
				<div class="span6 article-container-adaptive" id="main">
					<?php 

					$options = get_option('exray_theme_display_options');

					if(isset($options['show_slider']) && $options['show_slider']): ?>
					<!-- Experimental -->
					<div class="slider">
						<div class="url-container format-link"><blockquote><h1>This is SLider content Example </h1></blockquote></div>
					</div>
					
					<?php endif; ?>
					
					<?php 
					if( get_option('show_quiz')): ?>
					<!-- Experimental -->
					<div class="quiz">
						<div class="url-container format-link"><blockquote><h1>This is QUIZZZ! </h1></blockquote></div>
					</div>
					<!-- End Experimental -->
					
					<?php endif; ?>

					<?php 
					$options = get_option('exray_manage_coupon_options');
					if(isset($options['show_coupon']) && $options['show_coupon']): ?>
					<!-- Experimental -->
					<div class="quiz">
						<div class="url-container format-link"><blockquote><h1>This is COUPON! </h1></blockquote></div>
					</div>
					<!-- End Experimental -->
					
					<?php endif; ?>

					<?php 

						$social_options = get_option('exray_theme_social_options');

						if(isset($options['checkbox_element']) && $social_options['exray_theme_twitter'] ){
							echo '<a href="'.$social_options['exray_theme_twitter'].'">@fujianto</a>';
						}

					?>	

					<?php 
						$options = get_option( 'exray_theme_input_options' );
					

						if(isset($options['checkbox_element']) && $options['checkbox_element'] == '1'){
							echo '<h2>Checkbox Checked</h2>';
						}else{
							echo '<h3>NOT CHecked</h3>';
						}

						if(isset($options['radio_element']) && $options['radio_element'] == '1'){
							echo '<h2>MALE</h2>';
						}else if(isset($options['radio_element']) && $options['radio_element'] == '2'){
							echo '<h3>FEMALE</h3>';
						}

						if(isset($options['select_element']) &&  $options['select_element'] == 'never'){
							echo '<h2>never</h2>';
						} else if(isset($options['select_element']) &&  $options['select_element'] == 'sometimes'){
							echo '<h2>sometimes</h2>';
						} else if(isset($options['select_element']) &&  $options['select_element'] == 'always'){
							echo '<h2>always</h2>';
						} else{
							echo '<h2>Default</h2>';
						}
					?>

					<div class="content" role="main">
							<?php if(have_posts()) : while (have_posts()): the_post(); ?>		
								<!-- The Loop of Post -->
								<?php get_template_part('content', get_post_format()); ?>
								
								<!-- If post format content, show post format content items -->
								
							<?php endwhile; else :  ?>
								<!-- If no Post Found -->
								<h1><?php _e("No post were Found", "exray-framework") ?></h1>

							<?php endif; ?>

						<nav class="pagination clearfix"  id="nav-below" role="navigation">

							<p class="article-nav-prev"><?php next_posts_link(__('&larr; Older Post', 'exray-framework')); ?></p>
	    					<p class="article-nav-next"><?php previous_posts_link(__('Newer Post &rarr; ', 'exray-framework')); ?></p>
	
						</nav>	
						<!-- End nav-below -->	
					</div> 
					<!-- end content -->
				</div> 
				<!-- end span6 main -->	
					
				<div id="primary" class="widget-area span3 main-sidebar" role="complementary">

					<?php get_sidebar('sidebar'); ?>

				</div>  
				<!-- end span3 secondary left-sidebar -->	

				<div id="secondary" class="widget-area span3 main-sidebar" role="complementary">						

					<?php get_sidebar('secondary'); ?>
							
				</div> 
				<!-- end span3 tertiary right-sidebar -->
			</div> 
			<!--End row -->
			
		</div>	
		<!-- End Container  -->
		<!-- End Main Content -->

<?php get_footer(); ?>