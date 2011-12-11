<?php

function ts_widget_social_init() {
	
	if (!function_exists('register_sidebar_widget'))
		return;
	
	function ts_widget_social($args) {
		
		extract($args);
		
		$options = get_option('widget_social');
		
		if (!is_array($options))
			//Default values
			$options = array('title' => 'Social Media');
		
		$title = $options['title'];
		
		echo $before_widget . $before_title . $title . $after_title;

		?>
		<div class="widget_social">
			<?php 
				$sites = array('facebook', 'twitter', 'flickr', 'youtube', 'linkedin', 'myspace');
				$urls = array(	'facebook' => 'http://facebook.com/_USERNAME_', 
								'twitter' => 'http://twitter.com/_USERNAME_', 
								'flickr' => 'http://flickr.com/photos/_USERNAME_', 
								'youtube' => 'http://youtube.com/user/_USERNAME_', 
								'linkedin' => 'http://linkedin.com/in/_USERNAME_', 
								'myspace' => 'http://myspace.com/_USERNAME_'
							
				);
				
				$i = 1;
				foreach($sites as $site) {
					$value = $options[$site . '_username'];
					
					if(!empty($value)) {
						$href = str_replace('_USERNAME_', $value, $urls[$site]);
						?>
						<a href="<?php echo $href; ?>" class="social_<?php echo $site; ?>">Friend us on <?php echo $site; ?></a>
						<?php
						if($i == 3) {
							echo '<div class="clearer"></div>';
						} 
						$i++;
					}
				}

			?>
		</div>
		<?php
		
		echo $after_widget;
	}
	
	function ts_widget_social_control() {
		$options = get_option('widget_social');
		
		if (!is_array($options))
			//Default values
			$options = array('title' => 'Social Media');
							
		//Save options
		if (isset($_POST['social_submit'])) {
			$options['title'] = isset($_POST['social_title']) ? strip_tags(stripslashes($_POST['social_title'])) : '';
			$options['facebook_username'] = isset($_POST['facebook_username']) ? $_POST['facebook_username'] : '';
			$options['twitter_username'] = isset($_POST['twitter_username']) ? $_POST['facebook_username'] : '';
			$options['flickr_username'] = isset($_POST['flickr_username']) ? $_POST['flickr_username'] : '';
			$options['youtube_username'] = isset($_POST['youtube_username']) ? $_POST['youtube_username'] : '';
			$options['linkedin_username'] = isset($_POST['linkedin_username']) ? $_POST['linkedin_username'] : '';
			$options['myspace_username'] = isset($_POST['myspace_username']) ? $_POST['myspace_username'] : '';

			update_option('widget_social', $options);
		}
		
		//Get options
		$title = isset($options['title']) ? htmlspecialchars($options['title'], ENT_QUOTES) : '';
		$twitter = isset($options['twitter_username']) ? $options['twitter_username'] : '';
		$facebook = isset($options['facebook_username']) ? $options['facebook_username'] : '';
		$flickr = isset($options['flickr_username']) ? $options['flickr_username'] : '';
		$linkedin = isset($options['linkedin_username']) ? $options['linkedin_username'] : '';
		$youtube = isset($options['youtube_username']) ? $options['youtube_username'] : '';
		$myspace = isset($options['myspace_username']) ? $options['myspace_username'] : '';
		
		?>
		
		<p>
			
			<label for="social_title">
				Title: <br />
				<input style="width: 300px;" id="social_title" name="social_title" type="text" value="<?php echo $title; ?>" />
			</label><br /><br /><br />
			
			<h3>&raquo; Account settings:</h3><hr style="border: 1px Dotted" /><br />
			
			<label for="twitter_username">
				Twitter Username: <br />
				<input style="width: 300px;" id="twitter_username" name="twitter_username" type="text" value="<?php echo $twitter; ?>" />
			</label><br /><br /><br />

			<label for="facebook_username">
				Facebook ID: <br />
				<input style="width: 300px;" id="facebook_username" name="facebook_username" type="text" value="<?php echo $facebook; ?>" />
			</label><br />
			<small>The one at the end of your facebok url (i.e. http://facebook.com/<b>facebookid</b>)</small><br /><br /><br />
			
			<label for="flickr_username">
				Flickr ID: <br />
				<input style="width: 300px;" id="flickr_username" name="flickr_username" type="text" value="<?php echo $flickr; ?>" />
			</label><br />
			<small>The one at the end of your photostream address (i.e. http://flickr.com/photos/<b>flickrid</b>)</small><br /><br /><br />
			
			<label for="youtube_username">
				Youtube username: <br />
				<input style="width: 300px;" id="youtube_username" name="youtube_username" type="text" value="<?php echo $youtube; ?>" />
			</label><br /><br /><br />
			
			<label for="linkedin_username">
				LinkedIn ID: <br />
				<input style="width: 300px;" id="linkedin_username" name="linkedin_username" type="text" value="<?php echo $linkedin; ?>" />
			</label><br />
			<small>The one at the end of your LinkedIn url (i.e. http://linkedin.com/in/<b>linkeinid</b>)</small><br /><br /><br />
			
			<label for="myspace_username">
				MySpace ID: <br />
				<input style="width: 300px;" id="myspace_username" name="myspace_username" type="text" value="<?php echo $myspace; ?>" />
			</label><br />
			<small>The one at the end of your MySpace url (i.e. http://myspace.com/<b>myspaceid</b>)</small><br /><br /><br />

		</p>
		
		<?php
		echo '<input type="hidden" id="social_submit" name="social_submit" value="1" />';
		
	}
	
	
	wp_register_sidebar_widget('ts_social', '[WobbleNation] Social Media', 'ts_widget_social');
	wp_register_widget_control('ts_social', '[WobbleNation] Social Media', 'ts_widget_social_control', 360, 300);
}

?>