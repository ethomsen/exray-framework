<?php 
	if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('second-footer') ) : ?>

	<div class="span3">
		<aside class="footer-widget" role="complementary">
			<?php _e('No widget found, please add widget here from Dashboard', 'exray-framework'); ?>
		</aside>
	</div>

<?php endif ?>	