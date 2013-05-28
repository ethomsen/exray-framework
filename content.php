<?php 

/*********************************************************************************/
/*	Template for Standard Post */
/*********************************************************************************/

?>

<article <?php post_class('clearfix') ?> id="post-<?php the_ID(); ?>" role="article">

	<header>

		<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		
		<?php get_entry_meta('full'); ?>
	
	</header>

	<?php if(has_post_thumbnail()) : ?>
	
	<aside class="post_image">
		<figure class="article-preview-image">

			<a href="<?php the_permalink(); ?>">
				<?php Exray::load_post_thumbnail();	?>
			</a>
		
		</figure>		
	</aside>
		
	<?php endif ?> 
	<!-- End post_image -->

<div class="entry-content">

	<?php the_excerpt(); ?>
	
</div>
</article> 	
<!-- End article -->
<hr class="content-separator" />	