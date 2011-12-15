<?php

function ts_widget_recent_init() {
	
	if (!function_exists('register_sidebar_widget'))
		return;
	
	function ts_recent_widget($args) {
		
		global $wpdb;
		
		extract($args);
		
		$options = get_option('ts_widget_recent');
		if (!is_array($options))
			$options = array('title' => 'Recent Posts', 
							'maxposts' => 3);
		
		$title = htmlspecialchars($options['title'], ENT_QUOTES);
		$maxposts = $options['maxposts'];

		echo $before_widget . $before_title . $title . $after_title;
		
		//$all = new WP_Query('category_name=-portfolio');
		?>
		<div id="recentposts-list">
		<?php
			ts_recent_request($maxposts);
		?>
		</div>
		<?php
		echo $after_widget;
		
	}
	
	function ts_widget_recent_control() {
		
		$options = get_option('ts_widget_recent');
		if (!is_array($options))
			//Default values
			$options = array('title' => 'Recent Posts', 
							'maxposts' => 3);
							
		if (isset($_POST['ts_recent_submit'])) {
			$options['title'] = isset($_POST['ts_recent_title']) ? strip_tags(stripslashes($_POST['ts_recent_title'])) : '';
			$options['maxposts'] = isset($_POST['ts_recent_title']) ? strip_tags(stripslashes($_POST['ts_recent_maxposts'])) : 3;
			
			update_option('ts_widget_recent', $options);
		}

		$title = isset($options['title']) ? htmlspecialchars($options['title'], ENT_QUOTES) : '';
		$maxposts = isset($options['maxposts']) ? htmlspecialchars($options['maxposts'], ENT_QUOTES) : '';
		
		?>
		
		<p>
			
			<h3>&raquo; General Options:</h3><hr style="border: 1px Dotted" /><br />
			
			<label for="ts_recent_title">
				Title: 
				<input style="width: 200px;" id="ts_recent_title" name="ts_recent_title" type="text" value="<?php echo $title; ?>" />
			</label><br /><br />
			
			<label for="ts_recent_maxposts">
				Show 
				<input style="width: 20px;" id="ts_recent_maxposts" name="ts_recent_maxposts" type="text" value="<?php echo $maxposts; ?>" /> 
				posts
			</label><br /><br />
			
		</p>
		
		<?php
		
		echo '<input type="hidden" id="ts_recent_submit" name="ts_recent_submit" value="1" />';
		
	}
	
	function ts_recent_request($maxposts = 3, $offset = 0) {
		
		echo '<ul class="widgetpostlist">';
		
		$query = new WP_Query('cat=-45&showposts=' . $maxposts);
		while ($query->have_posts()) : $query->the_post(); ?>
		
			<li class="widgetpost">
			
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(array(67, 67)); ?></a>
				<p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><?php echo split_by_words(ts_getoption('ts_miniexcerpt_size'), get_the_excerpt()) . ' &raquo;';  ?></p>
				<div class="clearer"></div>
				
			</li>
		<?php
		endwhile;
		echo '<div class="clearer"></div></ul>';
	}
	
	wp_register_sidebar_widget('ts_recent', '[WobbleNation] Recent Posts', 'ts_recent_widget');
	wp_register_widget_control('ts_recent', '[WobbleNation] Recent Posts', 'ts_widget_recent_control', 360, 100);
	
}

?>