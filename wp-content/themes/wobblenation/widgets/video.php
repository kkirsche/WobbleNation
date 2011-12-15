<?php

function ts_widget_video_init() {
	
	if (!function_exists('register_sidebar_widget'))
		return;
	
	function ts_widget_video($args) {
		
		extract($args);
		
		$options = get_option('widget_video');
		
		if (!is_array($options))
			//Default values
			$options = array('title' => 'Video', 
							'embed' => '');
		
		$title = $options['title'];
		$embed = $options['embed'];
		
		echo $before_widget . $before_title . $title . $after_title;

		?>
		<div class="widget_video_embed">
			<?php echo $embed; ?>
		</div>
		<?php
		
		echo $after_widget;
	}
	
	function ts_widget_video_control() {
		$options = get_option('widget_video');
		
		if (!is_array($options))
			//Default values
			$options = array('title' => 'Video', 
							'embed' => '');
							
		//Save options
		if ($_POST['video_submit']) {
			$options['title'] = strip_tags(stripslashes($_POST['video_title']));
			$options['embed'] = stripslashes($_POST['video_embed']);

			update_option('widget_video', $options);
		}
		
		//Get options
		$title = htmlspecialchars($options['title'], ENT_QUOTES);
		$embed = htmlspecialchars($options['embed'], ENT_QUOTES);
		
		?>
		
		<p>
			
			<b>Instructions:</b> Insert the video code on the 'embed' box below.The recommended maximum width for the videos is 300 pixels. <br /><br />
			
			
			<h3>&raquo; General Options:</h3><hr style="border: 1px Dotted" /><br />
			
			<label for="video_title">
				Title: <br />
				<input style="width: 300px;" id="video_title" name="video_title" type="text" value="<?php echo $title; ?>" />
			</label><br /><br /><br />
			
			<label for="video_embed">
				Embed code: <br />
				<textarea style="width: 300px; height: 250px;" id="video_embed" name="video_embed"><?php echo $embed; ?></textarea>
			</label><br /><br /><br />

		</p>
		
		<?php
		echo '<input type="hidden" id="video_submit" name="video_submit" value="1" />';
		
	}
	
	
	wp_register_sidebar_widget('ts_video', '[WobbleNation] Video', 'ts_widget_video');
	wp_register_widget_control('ts_video', '[WobbleNation] Video', 'ts_widget_video_control', 360, 300);
}

?>