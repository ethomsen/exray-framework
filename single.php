<?php get_header(); ?>

	<!-- Main Content -->
	<div class="container" id="main-container">
		
		<div class="row">
		
			<div class="span6 article-container-adaptive" id="main">
					<?php if ( function_exists('yoast_breadcrumb') ) {
						yoast_breadcrumb('<p id="breadcrumbs">','</p>');
					} ?>
				<div class="content" role="main">
						
					<?php if(have_posts()) : while(have_posts()) : the_post(); ?>				
					<article class="post clearfix" id="post-1" role="article">
						
						<header>
							
							<h1 class="entry-title"><?php the_title(); ?></h1>
							<div class="entry-meta">								
								<p class="article-meta-extra">
									<span class="icon left-meta-icon">P</span>
									<a href="<?php the_permalink(); ?>" title="<?php echo get_the_time(); ?>" rel="bookmark">
										<time datetime="<?php echo get_the_date('c'); ?>" pubdate><?php echo get_the_date() ?></time>
									</a> , <?php _e('by','exray-framework'); ?>
									
									<?php the_author_posts_link(); ?>	

									<ul class="categories">
					                        <li><span class="icon categories">K</span></li>
					                        <?php the_category(',&nbsp;'); ?>
					                </ul>

					                 <?php 

					                 	if(comments_open() && !post_password_required()){
					                 		echo "<span class='icon comment'>c</span> ";
					                 		comments_popup_link('No comment', '1 comment', '% comments','article-meta-comment');
					                 	}

					                 	if(current_user_can('edit_post', $post->ID)){
					                 		edit_post_link(__('Edit', 'exray-framework'), '&nbsp;<p><span class="icon">S</span>&nbsp;', '</p>', '');
					                 	}
					                 ?>
									
								</p>
							</div> 
							<!-- End entry-meta -->
						</header>

						<div class="entry-content">	

								<?php if (has_post_thumbnail()) : ?>
						
									<figure class="article-full-image">
										<?php the_post_thumbnail('custom-blog-image'); ?>
									</figure>
								
								<?php else : ?>
								
								<hr class="content-separator" />	
									
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

				

					<nav class="pagination clearfix"  id="nav-below" role="navigation">

							<p class="article-nav-prev"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'exray-framework' ) . '</span> %title' ); ?></p>
	    					<p class="article-nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'exray-framework' ) . '</span>' ); ?></p>
	
					</nav>	
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