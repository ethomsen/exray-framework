<?php 

/*********************************************************************************/
/*	Template for Quote Post format */
/*********************************************************************************/

?>

<article <?php post_class('clearfix') ?> id="post-<?php the_ID(); ?>" role="article">

	<header>

		<?php get_entry_meta('full'); ?>
		
	</header>
	
	<div class="quote-container">

		<?php the_content(); ?>
		
	</div>

</article> 	
<!-- End article -->
<hr class="content-separator" />	