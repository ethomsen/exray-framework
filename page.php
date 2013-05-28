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
						<?php get_entry_meta('half'); ?>
					</header>

					<div class="entry-content">	

						<?php the_content(); ?>

					</div>
												  							
					<!-- Pagination For Multipaged Post -->
					<?php get_post_pagination(); ?>
								
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