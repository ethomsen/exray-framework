<?php get_header(); ?>

<!-- Main Content -->
		<div class="container" id="main-container">
			
			<div class="row">
			
				<div class="span6 article-container-adaptive" id="main">
					
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
				<!-- end span3 secondary right-sidebar -->
			</div> 
			<!--End row -->
			
		</div>	
		<!-- End Container  -->
		<!-- End Main Content -->

<?php get_footer(); ?>