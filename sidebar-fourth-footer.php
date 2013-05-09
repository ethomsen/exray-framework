<?php 
	if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('fourth-footer') ) : ?>
	
	<div class="span3">
		<aside class="footer-widget" role="complementary">
			 <?php the_widget('WP_Widget_Calendar'); ?> 
		</aside>
	</div>

<?php endif ?>	