<?php 
	if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('third-footer') ) : ?>

	<div class="span3">
		<aside class="footer-widget" role="complementary">
			<?php the_widget('WP_Widget_Recent_Posts'); ?>  
		</aside>
	</div>

<?php endif ?>	