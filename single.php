<?php get_header(); ?>

	<!-- Main Content -->
	<div class="container" id="main-container">
		
		<div class="row">
		
			<div class="span6 article-container-adaptive" id="main">
					<?php Exray::load_breadcrumb(); ?>
					
				<div class="content" role="main">
						
					<?php if(have_posts()) : while(have_posts()) : the_post(); ?>				
					<article class="post clearfix" id="post-1" role="article">
						
						<header>
							
							<h1 class="entry-title"><?php the_title(); ?></h1>
							<?php get_entry_meta('full'); ?>
						</header>

						<div class="entry-content">	

							<?php if (has_post_thumbnail()) : ?>
					
								<figure class="article-full-image">
									<?php the_post_thumbnail('custom-blog-image'); ?>
								</figure>
								
							<?php endif; ?>
					
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
							
							<!-- Pagination For Multipaged Post -->
							<?php get_post_pagination(); ?>
										
						</article> 	
						<!-- End article -->
						<div class="article-author clearfix">

							<figure class="clearfix">
								<?php echo get_avatar(get_the_author_meta('email'), '64', get_the_author_meta('display_name')); ?> 
							</figure>
							
							<div class="author-detail clearfix">
								<h5>Posted by <?php the_author_posts_link(); ?></h5>
								 <?php the_author_meta('description'); ?>
							</div> 
					
						</div>
						<!-- End article-author -->

					<?php endwhile; else : ?>
					<!-- If no post found -->
					<article>
						<h1><?php _e('No post were found!', 'exray-framework'); ?></h1>
					</article>

					<?php endif ?>
					<!-- Pagination for older / newer post -->
					<?php get_pagination(); ?>

					<!-- End nav-below -->	
						
						<div class="comment-area" id="comments">
							
							<?php comments_template('', true); ?>

						</div>
						<!-- End comment-area -->
				</div> 
				<!-- end content -->
			</div> 
			<!-- end span6 main -->

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