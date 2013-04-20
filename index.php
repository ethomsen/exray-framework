<?php get_header(); ?>

<!-- Main Content -->
		<div class="container" id="main-container">
			
			<div class="row">
			
				<div class="span6 article-container-adaptive" id="primary">
					<?php 

					$options = get_option('exray_theme_display_options');
					if($options['show_slider']): ?>
					<!-- Experimental -->
					<div class="slider">
						<div class="url-container format-link"><blockquote><h1>This is SLider content Example </h1></blockquote></div>
					</div>
					<!-- End Experimental -->
					
					<?php endif; ?>
					
					<?php 
					if(get_option('show_quiz')): ?>
					<!-- Experimental -->
					<div class="quiz">
						<div class="url-container format-link"><blockquote><h1>This is QUIZZZ! </h1></blockquote></div>
					</div>
					<!-- End Experimental -->
					
					<?php endif; ?>

					<?php 
					$options = get_option('exray_manage_coupon_options');
					if($options['show_coupon']): ?>
					<!-- Experimental -->
					<div class="quiz">
						<div class="url-container format-link"><blockquote><h1>This is COUPON! </h1></blockquote></div>
					</div>
					<!-- End Experimental -->
					
					<?php endif; ?>

					<?php 

						$options = get_option('exray_manage_history_options');			

						if($options['show_history']){
							echo '<input type="text" value="'.$options['facebook'].'"/>';
						}

						$social_options = get_option('exray_theme_social_options');
						echo '<a href="'.$social_options['exray_theme_twitter'].'">@fujianto</a>';

					?>	

					<?php 
						$options = get_option( 'exray_theme_input_options' );
						echo sanitize_text_field( $options['input_element'] );
						echo sanitize_text_field( $options['textarea_element'] );

						if($options['checkbox_element'] == '1'){
							echo '<h2>Checkbox Checked</h2>';
						}else{
							echo '<h3>NOT CHecked</h3>';
						}

						if($options['radio_element'] == '1'){
							echo '<h2>MALE</h2>';
						}else if($options['radio_element'] == '2'){
							echo '<h3>FEMALE</h3>';
						}

						if($options['select_element'] == 'never'){
							echo '<h2>never</h2>';
						} else if($options['select_element'] == 'sometimes'){
							echo '<h2>sometimes</h2>';
						} else if($options['select_element'] == 'always'){
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

							<!-- <ul>
		    					<li><a class="selected" href="#">1</a></li>
		    					<li><a href="#">2</a></li>
		    					<li><a href="#">3</a></li>
		    					<li><a href="#">4</a></li>
		    					<li><a href="#">5</a></li>
		    					<li><a href="#">6</a></li>
	    						<li><a href="#">Next Page >></a></li> 
	
	    					</ul> -->
							
						</nav>	
						<!-- End nav-below -->	
					</div> 
					<!-- end content -->
				</div> 
				<!-- end span6 primary -->	
					
				<div id="secondary" class="widget-area span3 main-sidebar" role="complementary">

					<?php get_sidebar('sidebar'); ?>

				</div>  
				<!-- end span3 secondary left-sidebar -->	

				<div id="tertiary" class="widget-area span3 main-sidebar" role="complementary">						

					<?php get_sidebar('tertiary'); ?>
							
				</div> 
				<!-- end span3 tertiary right-sidebar -->
			</div> 
			<!--End row -->
			
		</div>	
		<!-- End Container  -->
		<!-- End Main Content -->

<?php get_footer(); ?>