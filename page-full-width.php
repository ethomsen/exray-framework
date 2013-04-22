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
							
							<?php if(have_posts()) : while(have_posts()) : the_post(); ?>				
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
									<!-- Experimental -->
									<?php if(has_post_thumbnail()) : ?>

										<aside class="post_image">
											<figure class="article-preview-image">

												<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>

											</figure>		
										</aside>

									<?php else: ?>
										<!-- <hr class="content-separator"> -->
									<?php endif ?> 
									<!-- End post_image Experimental -->

									<?php the_content(); ?>
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
								
								<div class="post-pagination">
									<!-- Pagination For Multipaged Post -->
									<?php $args = array(
										'before'=>'<p class="post-pagination">Page',
										'after'=>'</p>',
										'pagelink'=>'%'  
									);?>

									<?php wp_link_pages($args); ?>
								</div>
											
							</article> 	
							<!-- End article -->
							
						<?php endwhile; else : ?>
						<!-- If no post found -->
						<article>
							<h1><?php _e('No post were found!', 'exray-framework'); ?></h1>
						</article>

						<?php endif ?>

							<!-- End article-author -->
							<div class="comment-area" id="comments">
								
								<?php comments_template('', true); ?>

							</div>
							<!-- End comment-area -->
					</div> 
					<!-- end content -->
				</div> 
				<!-- end span12 primary -->

			</div>
			<!-- ENd Row -->
		</div>
		<!-- End main-cotainer -->
<?php get_footer();?>