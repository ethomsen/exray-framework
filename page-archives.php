<?php
/*
    Template Name: Archives Page
*/
?>
<?php get_header(); ?>

	<!-- Main Content -->
		<div class="container" id="main-container">
			
			<div class="row">
			
				<div class="span6 article-container-adaptive" id="primary">
					
					<div class="content" role="main">
										
							<article class="post clearfix" id="post-1" role="article">
								
								<header>
									
										<h1 class="entry-title"><?php the_title(); ?></h1>
										<div class="entry-meta">								
											<p class="article-meta-extra">										
								                 <?php
                                                   if(current_user_can('edit_post', $post->ID)){
								                 		edit_post_link(__('Edit', 'exray-framework'), '<p><span class="icon left-meta-icon">S</span>&nbsp;', '</p>', '');
								                 	}
   
								                 ?>
												
											</p>
										</div> 
										<!-- End entry-meta -->
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
															  
								<?php if(has_tag()) : ?>

									<footer class="entry-meta cb" id="tag-container" role="contentinfo">

					                    <ul class="tags">
					                        <li><span class="icon tags">,</span></li>
					                        <?php the_tags() ?> 

				                        </ul>

									</footer> 

								<?php else: ?>

									<hr class="content-separator">	

								<?php endif; ?>
								<!-- end meta (category & tag) -->	
			
							</article> 	
							<!-- End article -->
							
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
			<!-- ENd Row -->
		</div>
		<!-- End main-cotainer -->
<?php get_footer();?>