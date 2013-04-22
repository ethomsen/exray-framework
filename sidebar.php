<?php 
	if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('primary') ) : ?>

	<div class="sidebar-widget">
		<h4><?php _e('Search', 'exray-framework'); ?></h4>
		<?php get_search_form(); ?>
	</div>

<?php endif ?>