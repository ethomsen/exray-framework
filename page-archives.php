<?php
/*
    Template Name: Archives Page
*/
?>
<?php get_header(); ?>

	<!-- Main Content -->
		<div class="container" id="main-container">
			
			<div class="row">
			
				<div class="span6 article-container-adaptive" id="main">
					
					<?php Exray::load_breadcrumb(); ?>

					<div class="content" role="main">
										
						<article class="post clearfix" id="post-1" role="article">
							
							<header>
								
								<h1 class="entry-title"><?php the_title(); ?></h1>
								<?php get_entry_meta('half'); ?>
								
							</header>

							<div class="entry-content">	
								<h4><?php _e('Archive by Month', 'exray-framework'); ?></h4>
                                <ul>
                                    <?php wp_get_archives('type=monthly'); ?>
                                </ul>

                                <br/>

								<h4><?php _e('Archive by Categories', 'exray-framework'); ?></h4>
                                <ul>
                                    <?php wp_list_categories('title_li='); ?>
                                </ul>

							</div>									  
		
						</article> 	
							<!-- End article -->
							
					</div> 
					<!-- end content -->
				</div> 
				<!-- end span6 primary -->

				<div id="primary" class="widget-area span3 main-sidebar" role="complementary">

					<?php get_sidebar('sidebar'); ?>

				</div>  
				<!-- end span3 primary left-sidebar -->	

				<div id="secondary" class="widget-area span3 main-sidebar" role="complementary">						

					<?php get_sidebar('secondary'); ?>
							
				</div> 
				<!-- end span3 secondary right-sidebar -->

			</div>
			<!-- ENd Row -->
		</div>
		<!-- End main-cotainer -->
<?php get_footer();?>