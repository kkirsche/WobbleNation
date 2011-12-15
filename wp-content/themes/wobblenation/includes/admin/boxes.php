<?php 
/**
 * Handles the theme's custom functionality to the wordpress admin panel
 * Exclusive to the WobbleNation theme
 * 
 * @package WordPress
 * @subpackage WobbleNation
**/

// Hook the actions to let Wordpress know we want to add some meta boxes
add_action('save_post', 'save_metaboxes');
add_action('admin_menu', 'add_metaboxes');

/**
 * Initiates the boxes for the write/edit post page
*/
function add_metaboxes() {
	add_meta_box( 'twitterbox', __('Publish to twitter', 'twitter'), 'add_twitter_metabox', 'post', 'normal', 'high');
	add_meta_box( 'sliderbox', __('Add to the slider', 'slider'), 'add_slider_metabox', 'post', 'normal', 'high');
}

/**
 * Adds twitter settings box to the write/edit page
*/
function add_twitter_metabox() {

	global $post;
	
	$access_token = check_twitter_credentials();
	
	if (!empty($access_token)) {
		$twitterdefault = ts_getoption('ts_twitter_default_message');
		$checked = ts_getoption('ts_twitter_automatic') == 1 ? 'checked="checked"' : ''; ?>
		
		<label for="twitter_check">
			<input type="checkbox" id="twitter_check" name="twitter_check" <?php echo $checked; ?> />
			&nbsp;Send twitter notificaton
		</label><br /><br /><br />
		
		<label for="twitter_status">Twitter status:</label> <br />
			<textarea id="twitter_status" name="twitter_status" style="width: 99%" rows="3"><?php echo $twitterdefault; ?></textarea><br />
			<br /><br />
	<?php
	}
	else { ?>
		<p>You can set-up a twitter account in the theme's options page and send automatic notifications of your posts from this box.</p> 
		<?php
	}
	
	?>
	<input type="hidden" name="is_post" id="is_page" value="1" />
	<?php
	
}

/**
 * Adds the slider settings box to the write/edit page
*/
function add_slider_metabox() {

	global $post;

	$opt_slider = get_post_meta($post->ID, 'showinslider', true);
	$opt_sliderurl = get_post_meta($post->ID, 'sliderimage', true);
	
	$checked = $opt_slider == 1 ? 'checked="checked"' : ''; ?> 
	
	<label for="slider_check">
	<input type="checkbox" id="slider_check" name="slider_check" <? echo $checked; ?> />
	&nbsp;Add to the home page slider
	</label><br /><br /><br />
	
	<label for="sliderimage">Slider image:</label> <br />
	<input type="text" id="sliderimage" name="sliderimage" value="<?php echo $opt_sliderurl; ?>" style="width: 99%" /><br />
	<small>Full URL (e.g. http://www.mysite.com/images/myimage.jpg)</small><br /><br /><br /> 
	
	<input type="hidden" name="is_post" id="is_page" value="1" /><?php
	
}

/**
 * Saves the values set in the custom settings boxes.
 * Runs when the post is published or updates.
 *
 * Use $_POST['is_page'] and $_POST['is_post'] if there are different boxes for those post types
*/ 
function save_metaboxes($post_id) {
    
    global $flag; // Do not remove! this line saves you from a strange double-saving bug
    
    // Save post settings
    if(isset($_POST['is_post'])) {
    
    
    	// Slider box
    	$opt_slider = get_post_meta($post_id, 'showinslider', true);
	    
	    if(isset($_POST['slider_check'])) {
	    	if($opt_slider == '')
	    		add_post_meta($post_id, 'showinslider', 1, true);
	    	elseif($opt_slider == 0)
	    			update_post_meta($post_id, 'showinslider', 1);
	    }
	    else {
	    	if($opt_slider== '')
	    		add_post_meta($post_id, 'showinslider', 0, true);
	    	elseif($opt_slider == 1)
	    			update_post_meta($post_id, 'showinslider', 0);
	    }
	    
	    update_post_meta($post_id, 'sliderimage', $_POST['sliderimage']);
    
    
    	// Twitter box
    	if(isset($_POST['twitter_check'])) {
			
			$status = $_POST['twitter_status'];
			$access_token = check_twitter_credentials();
			
			if(!empty($access_token)) {
				$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	  
	  			if ($flag == 0) { // Fix to that goddamn double-saving bug
					$status = str_replace('%blogname%', get_bloginfo('name'), $status);
					$permalink = get_permalink($post_id);
					$status = str_replace('%permalink%', $permalink, $status);
					$status = stripslashes($status);
					$update_status = $connection->post('statuses/update', array('status' => $status));
				}
			}
	    }
    	
    }
    
    $flag = 1;
    
}



?>