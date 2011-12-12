<?php
/*
Plugin Name: Custom Meta Widget
Plugin URI: http://wikiduh.com/plugins/custom-meta-widget
Description: Clone of the standard Meta widget plus option to hide log in/out, admin, feed and WordPress links.
Version: 1.1
Author: bitacre
Author URI: http://wikiduh.com/
Acknowledgements: 
	This code is largely derived from one of the many freely available 
	and tremendously helpful tutoials on the Azulia Designs website 
	(http://azuliadesigns.com) created by the heroic Tim Trott.
	
License: GPLv2
	Copyright 2011 bitacre (plugins@wikiduh.com)
*/

class customMetaWidget extends WP_Widget {

	function customMetaWidget() { // plugin structure:
		$widget_ops = array('classname' => 'customMetaWidget', 'description' => 'Clone of the standard Meta widget PLUS options to show or hide: log in/out, admin, feed and WordPress links.'); 
		$this->WP_Widget('customMetaWidget', 'Custom Meta Widget', $widget_ops);
	}

	function form($instance) { // form print function:
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Meta', 'register'=>1, 'login'=>1,'entryrss'=>1, 'commentrss'=>1, 'wordpress'=>1 ) ); // set default values ?>
        
		<p><label for="<?php echo $this->get_field_id('title'); ?>">Display title:&nbsp;</label></p>
    	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
	    
		<p><label for="<?php echo $this->get_field_id('register'); ?>">Show 'Register/Admin' link?&nbsp;</label>
		<input id="<?php echo $this->get_field_id('register'); ?>" name="<?php echo $this->get_field_name('register'); ?>" type="checkbox" <?php if(esc_attr($instance['register'])) echo 'checked="yes"'; ?> value="1" /></p>
    
    	<p><label for="<?php echo $this->get_field_id('login'); ?>">Show 'Log in/out' link?&nbsp;</label>
        <input id="<?php echo $this->get_field_id('login'); ?>" name="<?php echo $this->get_field_name('login'); ?>" type="checkbox" <?php if(esc_attr($instance['login'])) echo 'checked="yes"'; ?> value="1" /></p>
    
		<p><label for="<?php echo $this->get_field_id('entryrss'); ?>">Show 'Entries RSS' link?&nbsp;</label>
      <input id="<?php echo $this->get_field_id('entryrss'); ?>" name="<?php echo $this->get_field_name('entryrss'); ?>" type="checkbox" <?php if(esc_attr($instance['entryrss'])) echo 'checked="yes"'; ?> value="1" /></p>
    
	    <p><label for="<?php echo $this->get_field_id('commentrss'); ?>">Show 'Comments RSS' link?&nbsp;</label>
    	<input id="<?php echo $this->get_field_id('commentrss'); ?>" name="<?php echo $this->get_field_name('commentrss'); ?>" type="checkbox" <?php if(esc_attr($instance['commentrss'])) echo 'checked="yes"'; ?> value="1" /></p>
          
	    <p><label for="<?php echo $this->get_field_id('wordpress'); ?>">Show 'Wordpress' link?&nbsp;</label>
    	<input id="<?php echo $this->get_field_id('wordpress'); ?>" name="<?php echo $this->get_field_name('wordpress'); ?>" type="checkbox" <?php if(esc_attr($instance['wordpress'])) echo 'checked="yes"'; ?> value="1" /></p>
	<?php }

	function update($new_instance, $old_instance) { // save widget options:
		$instance = $old_instance;
	    $instance['title'] = $new_instance['title'];
		$instance['register'] = $new_instance['register'];
		$instance['login'] = $new_instance['login'];
		$instance['entryrss'] = $new_instance['entryrss'];
		$instance['commentrss'] = $new_instance['commentrss'];
		$instance['wordpress'] = $new_instance['wordpress'];
    	return $instance;
	}

	function widget($args, $instance) { // widget sidebar output
    	extract($args, EXTR_SKIP); 
	    echo $before_widget; // pre-widget code from themes
		echo '<!-- Custom Meta Widget. Plugin URL: http://wikiduh.com/plugins/custom-meta-widget -->';
    	$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']); // if no title, use default
	     if (!empty($title))  echo $before_title . esc_attr($instance['title']) . $after_title; // echo title
		echo '<ul>';
			if(esc_attr($instance['register'])) wp_register('<li>', '</li>'); // 1. register link
			if(esc_attr($instance['login'])) echo '<li>' . wp_loginout(NULL,FALSE) . '</li>'; // 2. login link
			if(esc_attr($instance['entryrss'])) { // 3. entries rss link
				echo '<li><a href="';
				bloginfo('rss2_url');
				echo '" title="Syndicate this site using RSS 2.0">Entries <abbr title="Really Simple Syndication">RSS</abbr></a></li>';
			}
			if(esc_attr($instance['commentrss'])) { // 4. comments rss
				echo '<li><a href="';
				bloginfo('comments_rss2_url');
				echo '" title="Syndicate this site using RSS 2.0">Comments <abbr title="Really Simple Syndication">RSS</abbr></a></li>';
			}
			if(esc_attr($instance['wordpresslink'])) echo '<li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress.org</a></li>'; // 5. wordpress.org link
			echo '</ul>';
	    echo $after_widget; // after widget code from themes
	}
}

add_action( 'widgets_init', create_function('', 'return register_widget("customMetaWidget");') ); // register widget ?>