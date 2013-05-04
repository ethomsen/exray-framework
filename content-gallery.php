<?php 

/*********************************************************************************/
/*	Template for Gallery Post format */
/*********************************************************************************/
?>

<article <?php post_class('clearfix') ?> id="post-<?php the_ID(); ?>" role="article">

	<header>
		
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

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
	
	<?php

		$gallery_atts = array(
			'post_parent' => $post->ID,
			'post_mime_type' => 'image'
		);

		$gallery_images = get_children($gallery_atts);

		if(!empty($gallery_images)){
			$gallery_count = count($gallery_images);
			$first_image = array_shift($gallery_images);
			$display_first_image = wp_get_attachment_image($first_image->ID);
	?>

		<aside class="post_image">
			<figure class="article-preview-image">

				<a href="<?php the_permalink(); ?>"><?php echo $display_first_image; ?></a>

			</figure>		
		</aside>

		<p><strong>
			<?php printf(_n('This gallery contains %s photo.', 'This gallery contains %s photos.', 
				$gallery_count, 'exray-framework'), $gallery_count); ?>
		</strong></p>

	<?php }

	?>

</article> 	
<!-- End article -->
<hr class="content-separator" />	