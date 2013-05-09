<?php 
	if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('secondary') ) : ?>

	<div class="sidebar-widget">
		<?php get_search_form(); ?>
		<?php the_widget('WP_Widget_Recent_Posts', '', array('before_title' => '<h4>', 'after_title' => '</h4>') ); ?> 
		<?php the_widget('WP_Widget_Meta', '', array('before_title' => '<h4>', 'after_title' => '</h4>') ); ?> 
		<?php the_widget( 'WP_Widget_Tag_Cloud', '', array('before_title' => '<h4>', 'after_title' => '</h4>')); ?> 
	</div>

<?php endif ?>	