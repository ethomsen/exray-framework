<?php 

/*********************************************************************************/
/*	Template for Standard Post */
/*********************************************************************************/

?>

<article <?php post_class('clearfix') ?> id="post-<?php the_ID(); ?>" role="article">

	<header>

		<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

		<div class="entry-meta">	

			<p class="article-meta-extra">
				<span class="icon left-meta-icon">P</span>
				<a href="#" title="<?php the_time(get_option('date_format')); ?>" rel="bookmark">
					<time datetime="<?php the_time(get_option('date_format')); ?>" pubdate><?php the_time(get_option('date_format')); ?></time>
				</a> , <?php _e("by", "exray-framework") ?>
				<?php the_author_posts_link(); ?>	

				<ul class="categories">
					<li><span class="icon categories">K</span></li>
					<?php the_category(',&nbsp;'); ?>	                     
				</ul>

				<?php 
						 // Display the comment link if comment are allowed and Post not password protected
				if (comments_open() && !post_password_required()){
					echo"<span class='icon comment'>c</span>"; 
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

	<?php if(has_post_thumbnail()) : ?>
	<aside class="post_image">
		<figure class="article-preview-image">

			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>

		</figure>		
	</aside>
	<?php endif ?> 
	<!-- End post_image -->

<div class="entry-content">

	<?php the_excerpt(); //the_content('Read more &raquo;'); ?>
	
</div>
</article> 	
<!-- End article -->
<hr class="content-separator" />	