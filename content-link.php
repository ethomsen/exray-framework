<?php 

/*********************************************************************************/
/*	Template for Link Post format */
/*********************************************************************************/
?>

<article <?php post_class('clearfix') ?> id="post-<?php the_ID(); ?>" role="article">

	<header>

		<div class="entry-meta">	

			<p class="article-meta-extra">
				<span class="icon left-meta-icon">P</span>
				<a href="<?php the_permalink(); ?>" title="<?php echo get_the_time(); ?>" rel="bookmark">
					<time datetime="<?php echo get_the_date('c'); ?>" pubdate><?php echo get_the_date() ?></time>
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
	
	<div class="url-container">

		<p><?php the_title(); ?></p>
		<span><?php the_content(); ?></span>
		
	</div>

</article> 	
<!-- End article -->
<hr class="content-separator" />	