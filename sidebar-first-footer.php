<?php 
	if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('first-footer') ) : ?>
	
	<div class="span3">
		<aside class="footer-widget" role="complementary">
			<?php the_widget( 'WP_Widget_Tag_Cloud', '', array('before_title' => '<h4>', 'after_title' => '</h4>')); ?> 
		</aside>
	</div>

<?php endif ?>	