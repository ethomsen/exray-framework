<?php 
	if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('header-widget') ) : ?>
	
	<aside id="header-widget" class="right-header-widget fr top-widget" role="complementary">					
		<?php get_search_form(); ?>
	</aside>	
	<!-- End header-widget -->

<?php endif ?>