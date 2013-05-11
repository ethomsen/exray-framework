<?php 
	if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('third-footer') ) : ?>

	<div class="span3">
		<aside class="footer-widget" role="complementary">
			<?php the_widget('WP_Widget_Recent_Posts', '', array('before_title' => '<h4>', 'after_title' => '</h4>') ); ?>  
		</aside>
	</div>

<?php endif ?>	