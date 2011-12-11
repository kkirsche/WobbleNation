<?php
/**
 * FILE INFORMATION
 * ---------------------------------------------------------------------------------
 * Theme: WobbleNation
 * Author: Kevin Kirsche
 * Website: www.razerdesign.com
 * ---------------------------------------------------------------------------------
 *
 * WIDGET FILE
 * ---------------------------------------------------------------------------------
 * Facebook Widget
 * ---------------------------------------------------------------------------------
 * 
 * @package WordPress
 * @subpackage Reaction
**/

class gosuwt_facebook extends WP_Widget {
	
	function gosuwt_facebook() {
		$widget_ops = array('description' => 'Shows the facebook box social plugin for the specified page');
		$control_ops = array('width' => 400, 'height' => 350);
        parent::WP_Widget('gosu_facebook', __('Gosu Facebook'), $widget_ops, $control_ops);
    }
    
    function widget($args, $instance) {
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        $page = isset($instance['page']) ? $instance['page'] : 'http://www.facebook.com/wordpress';
		
		echo $before_widget;
		if ($title)
			echo $before_title . $title . $after_title;
			?>
				<iframe src="http://www.facebook.com/plugins/likebox.php?href=<?php echo urlencode($page); ?>&amp;width=300&amp;colorscheme=light&amp;show_faces=true&amp;border_color=%23ffffff&amp;stream=false&amp;header=false&amp;height=180" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height: 180px" allowTransparency="true"></iframe>
			<?php
			echo $after_widget;
    }
    
    function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['page'] = $new_instance['page'];
        return $instance;
    }
    
    function form($instance) {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $page = isset($instance['page']) ? $instance['page'] : 'http://www.facebook.com/wordpress';
        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
         </p>
         
         <p>
          <label for="<?php echo $this->get_field_id('page'); ?>"><?php _e('Page URL:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('page'); ?>" name="<?php echo $this->get_field_name('page'); ?>" type="text" value="<?php echo $page; ?>" />
		</p>

        <?php 
    }

}

add_action('widgets_init', create_function('', 'return register_widget("gosuwt_facebook");'));


?>