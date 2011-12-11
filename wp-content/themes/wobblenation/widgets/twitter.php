<?php

function ts_widget_twitter_init() {
	
	if (!function_exists('register_sidebar_widget'))
		return;
	
	function ts_widget_twitter($args) {
		
		extract($args);
		
		$options = get_option('widget_twitter');
		
		if (!is_array($options))
			//Default values
			$options = array('title' => 'Twitter');
		
		$title = $options['title'];
		
		echo $before_widget . $before_title . $title . $after_title;

		?>
		<div class="widget_twitter_embed">
			<?php
			$access_token = check_twitter_credentials();
			if (empty($access_token)) {
				
				echo '<p>Could not connect to twitter. PLease check that the account is properly setup in your wordpress admin panel</p>';
				var_dump($access_token);
			}
			else {
				?>
				<ul class="twitter_status"> <?php
					$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
					$user = $connection->get('account/verify_credentials');
					$tweets = $connection->get('statuses/user_timeline', array('screen_name' => $user->screen_name, 'count' => 4)); 
					foreach($tweets as $tweet) {
						if(!empty($tweet->text)):
						?>
						<li>
							<a href="http://twitter.com/<?php echo $tweet->user->screen_name; ?>/status/<?php echo $tweet->id_str; ?>"><?php echo timeago($tweet->created_at); ?></a>
							<?php echo $tweet->text; ?>
						</li>
						<?php
						endif;
					}
			}
			?>
		</div>
		<?php
		
		echo $after_widget;
	}
	
	function ts_widget_twitter_control() {
		$options = get_option('widget_twitter');
		
		if (!is_array($options))
			//Default values
			$options = array('title' => 'Twitter');
							
		//Save options
		if (isset($_POST['twitter_submit'])) {
			$options['title'] = strip_tags(stripslashes($_POST['twitter_title']));

			update_option('widget_twitter', $options);
		}
		
		//Get options
		$title = isset($options['title']) ? htmlspecialchars($options['title'], ENT_QUOTES) : '';
		//$username = htmlspecialchars($options['username'], ENT_QUOTES);
		//$password = $options['password'];
		
		?>
		
		<p>
			
			<label for="twitter_title">
				Title: <br />
				<input style="width: 300px;" id="twitter_title" name="twitter_title" type="text" value="<?php echo $title; ?>" />
			</label><br /><br /><br />
			
			<?php 
			$access_token = check_twitter_credentials();
			if (empty($access_token)) {
				?>
				<font color="red">Could not connect to a twitter account. You can set one up from the theme's options page.</font>
				<?php
			}
			?>
			
		</p>
		
		<?php
		echo '<input type="hidden" id="twitter_submit" name="twitter_submit" value="1" />';
		
	}
	
	
	wp_register_sidebar_widget('ts_twitter', '[WobbleNation] Twitter', 'ts_widget_twitter');
	wp_register_widget_control('ts_twitter', '[WobbleNation] Twitter', 'ts_widget_twitter_control', 360, 300);
}

?>