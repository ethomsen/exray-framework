<?php

/***************************************************************/
/* Display a single 260 x 120 px ad block */
/***************************************************************/

class Exray_Ad_260_Widget extends WP_Widget{
    //Init Widget
    public function __construct(){
        parent::__construct(
            'exray_ad_260_widget',
            'Custom Widget: 260x120 Ad',
            array('description' => __(' Display a single 260 x 120 ad block','exray-framework'))
        );
    }

    // Out put Widget Option to the Back-end
    public function  form($instance) {
        $defautls = array(
            'title' => __('Ad 260x128', 'exray-framework'),
            'ad_img' => THEME_IMAGES . '/Mail.png',
            'ad_link' => 'http://seotemplates.net'
        );

        $instance = wp_parse_args((array) $instance, $defautls);
        ?>
			
			<!-- Ad Title  -->
            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'exray-framework'); ?></label>
				<input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" class="widefat" value="<?php echo esc_attr($instance['title']); ?>" />
            </p>
			
			<!-- Ad Image -->
            <p>
                <label for="<?php echo $this->get_field_id('ad_img'); ?>"><?php _e('Ad Image', 'exray-framework'); ?></label>
				<input type="text" id="<?php echo $this->get_field_id('ad_img'); ?>" name="<?php echo $this->get_field_name('ad_img'); ?>" class="widefat" value="<?php echo esc_attr($instance['ad_img']); ?>" />
            </p>

			<!-- Ad Link -->
            <p>
                <label for="<?php echo $this->get_field_id('ad_link'); ?>"><?php _e('Ad Link', 'exray-framework'); ?></label>
				<input type="text" id="<?php echo $this->get_field_id('ad_link'); ?>" name="<?php echo $this->get_field_name('ad_link'); ?>" class="widefat" value="<?php echo esc_attr($instance['ad_link']); ?>" />
            </p>

        <?php
    }

    //Process widget options for saving
    public function  update($new_instance, $old_instance) {
    	$instance = $old_instance;

        //Title
        $instance['title'] = strip_tags($new_instance['title']);

        //Ad
        $instance['ad_img'] =strip_tags($new_instance['ad_img']);

        //Link
        $instance['ad_link'] =strip_tags($new_instance['ad_link']);

        return $instance;
    }

    // Displays widget on the Front-end
    public function  widget($args, $instance) {
        extract($args);

        $title = apply_filters('widget-title', $instance['title']);

        $ad_img = $instance['ad_img'];
        $ad_link = $instance['ad_link'];

        echo $before_widget;

        if($title){
            echo $before_title . $title . $after_title;
        }

       echo ' <ul class="ads-block">';

       if($ad_img): ?>
            <li>
            <figure><a href="<?php echo $ad_link; ?>"><img src="<?php echo $ad_img; ?>" alt="" /></a></figure>
           </li>

       <?php endif;
       echo '</ul>';

       echo $after_widget;
    }
}

register_widget('Exray_Ad_260_Widget');

?>