<?php
/*
    Template Name: Full Width Page
*/
?>
<?php get_header(); ?>

	<!-- Main Content -->
		<div class="container" id="main-container">
			
			<div class="row">
			
				<div class="span12 article-container-adaptive">
					
					<div class="content" role="main">
									
							<article class="post clearfix" id="post-1" role="article">
								
								<header>
									
									<h1 class="entry-title" id="search-title"><?php _e('404 Error - Page not Found', 'exray-framework'); ?></h1>
									
								</header>
							
								<div class="entry-content">	

									<p><?php _e('Oops! It seems what you are looking are missing, Use Search box below to find other relevant content.', 'exray-framework'); ?></p>

									<div class="search-form-404">
										<?php get_search_form(); ?>
									</div>
									
								</div>
											
							</article> 	
							<!-- End article -->	
					</div> 
					<!-- end content -->
				</div> 
				<!-- end span12 primary -->

			</div>
			<!-- ENd Row -->
		</div>
		<!-- End main-cotainer -->
<?php get_footer();?>