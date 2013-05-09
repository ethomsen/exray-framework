<?php 
	if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('primary') ) : ?>

	<div class="sidebar-widget">
		<?php the_widget('WP_Widget_Calendar'); ?> 
		<?php the_widget('WP_Widget_Recent_Comments' , '', array('before_title' => '<h4>', 'after_title' => '</h4>')); ?> 
		<?php the_widget('WP_Widget_Archives' , '', array('before_title' => '<h4>', 'after_title' => '</h4>') ); ?> 
	</div>

<?php endif ?>