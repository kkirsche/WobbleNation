<?php 
/**
 * Adds the options page to the Wordpress admin sidebar
 * Exclusive to the WobbleNation theme
 * 
 * @package WordPress
 * @subpackage WobbleNation
**/

/*add_action( 'admin_menu', 'theme_add_admin_pages');

function theme_add_admin_pages() {
	add_menu_page('Theme Settings', 'Theme Settings', 'activate_plugins', 'themesettings', 'theme_colors_page');
	add_submenu_page( 'themesettings', 'Edit Colors', 'Colors', 'activate_plugins', 'themesettings', 'theme_colors_page' );
}

function theme_colors_page() {
	?>Hola Mundo<?php
}*/


add_action('admin_menu', 'theme_add_admin');

function theme_add_admin() {
 
	global $themename, $shortname, $options;
	
	if(!isset($_SESSION))
		session_start();
	 
	add_action( 'admin_init', 'register_theme_settings' );
	add_theme_page($themename." Options", "".$themename." Options", 'edit_themes', basename(__FILE__), 'theme_admin');
	
	//Add option boxes to the options page
	add_meta_box("themeadmin_general", __('General Settings', 'themeadmin'), "themeadmin_general_box", "themeadmin_general");
	add_meta_box("themeadmin_sliders", __('Slider Settings', 'themeadmin'), "themeadmin_sliders_box", "themeadmin_sliders");
	add_meta_box("themeadmin_appereance", __('Appereance Settings', 'themeadmin'), "themeadmin_appereance_box", "themeadmin_appereance");
	add_meta_box("themeadmin_colors", __('Color Settings', 'themeadmin'), "themeadmin_color_box", "themeadmin_color");
	add_meta_box("themeadmin_comments", __('Comments Settings', 'themeadmin'), "themeadmin_comments_box", "themeadmin_comments");
	add_meta_box("themeadmin_sidebar", __('Sidebar Settings', 'themeadmin'), "themeadmin_sidebar_box", "themeadmin_sidebar");
	add_meta_box("themeadmin_social", __('Social Networking Settings', 'themeadmin'), "themeadmin_social_box", "themeadmin_social");
	add_meta_box("themeadmin_menu", __('Menu Settings', 'themeadmin'), "themeadmin_menu_box", "themeadmin_menu");
	add_meta_box("themeadmin_misc", __('Miscellaneous', 'themeadmin'), "themeadmin_misc_box", "themeadmin_misc");
	
	add_action( 'admin_init', 'register_theme_scripts' );

}

function register_theme_settings() {
	global $shortname;
	register_setting( 'theme-settings', 'ts_options', 'validate_options' );
}

function validate_options($input) {
	
	if(!empty($input['ts_logo_url'])) {
		
		$type = str_replace('.', '', strstr(basename($input['ts_logo_url']), '.'));
		if($type == 'png')
			$image = @imagecreatefrompng($input['ts_logo_url']);
		elseif($type == 'jpg')
			$image = @imagecreatefromjpeg($input['ts_logo_url']);
		elseif($type == 'gif')
			$image = @imagecreatefromjpeg($input['ts_logo_url']);
		
		$input['ts_logo_width'] = @imagesx($image);
		$input['ts_logo_height'] = @imagesy($image);
		
	}
	
	return($input);
}

function theme_admin() {
?>
	
	<div class="wrap">
	
	<h2>WobbleNation Options</h2>
	
	<form method="post" action="options.php">
	
	<div id="archive_options" class="section">
	
	<div id="poststuff" class="metabox-holder">
			<?php do_meta_boxes('themeadmin_appereance','advanced',null); ?>				
	</div>
	
	<div id="poststuff" class="metabox-holder">
			<?php do_meta_boxes('themeadmin_color','advanced',null); ?>				
	</div>
	
	<div id="poststuff" class="metabox-holder">
			<?php do_meta_boxes('themeadmin_general','advanced',null); ?>				
	</div>
	
	<div id="poststuff" class="metabox-holder">
			<?php do_meta_boxes('themeadmin_sliders','advanced',null); ?>				
	</div>
	
	<div id="poststuff" class="metabox-holder">
			<?php do_meta_boxes('themeadmin_comments','advanced',null); ?>				
	</div>
	
	<div id="poststuff" class="metabox-holder">
			<?php do_meta_boxes('themeadmin_sidebar','advanced',null); ?>				
	</div>
	
	<div id="poststuff" class="metabox-holder">
			<?php do_meta_boxes('themeadmin_social','advanced',null); ?>				
	</div>
	
	<div id="poststuff" class="metabox-holder">
			<?php do_meta_boxes('themeadmin_misc','advanced',null); ?>				
	</div>
	
	<?php 
	
	wp_nonce_field('update-options'); 
	//settings_fields( 'WobbleNation-options' );
	settings_fields( 'theme-settings' );
	//$msoptions = get_option('msoptions');
	$ts_options = get_option('ts_options');
	$styledir = get_bloginfo('stylesheet_directory');
	?>
	
	<script type="text/javascript">
		//<![CDATA[
		jQuery(document).ready( function($) {
			// close postboxes that should be closed
			$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
			// postboxes setup
			postboxes.add_postbox_toggles('themeadmin_general');
		});
		//]]>
	</script>
	
	<p class="submit">
	<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	</p>
	
	</form>
	</div>
<?php 
}

function themeadmin_general_box() {
?>
	<div class="optionsblock">
	
	<?php 
	add_input_text( array('name' => 'ts_excerpt_size', 'label' => 'Excerpt Size:', 'size' => 3, 'note' => 'Number of words per post to be displayed in the main archive, manual excerpts override this option') );
	add_input_text( array('name' => 'ts_miniexcerpt_size', 'label' => 'Mini Excerpt Size:', 'size' => 3, 'note' => 'Number of words to show in the preview for widgets and other small post previews, manual excerpts override this option') );
	?>
	</div>
	<?php
}

function themeadmin_color_box() {
?>
	<br /><?php 
	// 'Menu Background Color'
	
	?>
	<div class="optionscolumn">
	
	<div class="optionsblock"><b>Menus</b><br /><?php 
		add_input_colorpicker( array('name' => "[template1][Main Menu][styles][background-color]", 'label' => 'Menu Background Color:', 'id' => 'ts_menu_bg_color') );
		add_input_colorpicker( array('name' => "[template1][Main Menu][styles][color]", 'label' => 'Menu Links Color:', 'id' => 'ts_menu_color') );
	
		add_input_colorpicker( array('name' => "[template1][Secondary Menu][styles][color]", 'label' => 'Secondary Menu Links:', 'id' => 'ts_secondary_menu_color') );
	?>
	</div>
	
	<div class="optionsblock"><b>Content</b><br /><br /><?php 
		add_input_colorpicker( array('name' => '[template1][Container Background][styles][background-color]', 'id' => 'ts_container_bg_color', 'label' => 'Content Background:') );
		
		add_input_colorpicker( array('name' => '[template1][Text][styles][color]', 'id' => 'ts_text_color', 'label' => 'Main Text:') );
		
		add_input_colorpicker( array('name' => '[template1][Links][styles][color]', 'id' => 'ts_link_color', 'label' => 'Links:') );
		
		add_input_colorpicker( array('name' => '[template1][Titles][styles][color]', 'id' => 'ts_titles_color', 'label' => 'Page and Section Titles:') );
		
		add_input_colorpicker( array('name' => '[template1][Blockquotes][styles][background-color]', 'id' => 'ts_blockquotes_bg_color', 'label' => 'Blockquotes, Comments and Code Background:') );
		
		add_input_colorpicker( array('name' => '[template1][Alternate Text][styles][color]', 'id' => 'ts_alt_text_color', 'label' => 'Alternate Text:') );
	?>
	</div>
	
	</div>

	<div class="optionscolumn">
	
	<div class="optionsblock"><b>Sidebar</b><br /><br /><?php 
		add_input_colorpicker( array('name' => '[template1][Widget Title][styles][background-color]', 'id' => 'ts_widget_title_bg_color', 'label' => 'Sidebar Widget Title Background:') );
	add_input_colorpicker( array('name' => '[template1][Widget Title][styles][color]', 'id' => 'ts_widget_title_color', 'label' => 'Sidebar Widget Title:') );
	?>
	</div>
	
	<div class="optionsblock"><b>Forms</b><br /><br /><?php 
		add_input_colorpicker( array('name' => '[template1][Form Fields][styles][background-color]', 'id' => 'ts_form_bg_color', 'label' => 'Input and Text Areas Background:') );
		add_input_colorpicker( array('name' => '[template1][Form Fields][styles][color]', 'id' => 'ts_form_color', 'label' => 'Input and Text Areas Text:') );
	
		add_input_colorpicker( array('name' => '[template1][Buttons][styles][background-color]', 'id' => 'ts_button_bg_color', 'label' => 'Button Background:') );
		add_input_colorpicker( array('name' => '[template1][Buttons][styles][color]', 'id' => 'ts_button_color', 'label' => 'Button Text:') );
	?>
	</div>
	
	<div class="optionsblock"><b>Post Previews and Slider</b><br /><br /><?php 
		add_input_colorpicker( array('name' => "[template1][Preview Title][styles][color]", 'label' => 'Post Preview Title:', 'id' => 'ts_preview_title_color') );
		
		add_input_colorpicker( array('name' => '[template1][Category Tags][styles][background-color]', 'id' => 'ts_categories_bg_color', 'label' => 'Category Tags Background:') );
		add_input_colorpicker( array('name' => '[template1][Category Tags][styles][color]', 'id' => 'ts_categories_color', 'label' => 'Category Tags Text:') );
	?>
	</div>
	
	</div>

	<div class="optionscolumn">
	
	<div class="optionsblock"><b>Sidebar</b><br /><br /><?php 
		add_input_colorpicker( array('name' => '[template1][Footer Title][styles][color]', 'id' => 'ts_footer_title_color', 'label' => 'Footer Widget Title:') );
		add_input_colorpicker( array('name' => '[template1][Footer][styles][background-color]', 'id' => 'ts_footer_bg_color', 'label' => 'Footer Background:') );
		add_input_colorpicker( array('name' => '[template1][Footer][styles][color]', 'id' => 'ts_footer_text_color', 'label' => 'Footer Text:') );
		add_input_colorpicker( array('name' => '[template1][Footer Links][styles][color]', 'id' => 'ts_footer_links_color', 'label' => 'Footer Links:') );
		add_input_colorpicker( array('name' => '[template1][Footer Boxes][styles][background-color]', 'id' => 'ts_footer_boxes_bg_color', 'label' => 'Footer Boxes Background:') );
	?></div>
	
	<div class="optionsblock"><b>Navigation</b><br /><br /><?php 
		add_input_colorpicker( array('name' => '[template1][Navigation][styles][background-color]', 'id' => 'ts_nav_bg_color', 'label' => 'Navigation Background:') );
		add_input_colorpicker( array('name' => '[template1][Navigation][styles][color]', 'id' => 'ts_nav_color', 'label' => 'Navigation Links:') );
	?>
	</div>
	
	</div>
	
	<div class="clearer"></div>
<?php
}

function themeadmin_appereance_box() {
?>
	<div class="optionsblock">
	<img src="<?php echo ts_getoption('ts_logo_url'); ?>" alt="Current logo" /><br /><br /><?php  
	add_input_text( array('name' => 'ts_logo_url', 'label' => 'Logo:', 'note' => 'Full address (i.e: http://www.mysite.com/images/logo.png)') ); 			
    ?>
    </div>
<?php
}

function themeadmin_sliders_box() {
?>
	<div class="optionsblock">
	<?php 
	$options = array(	array('value' => 1, 'text' => 'Yes'), 
						array('value' => 2, 'text' => 'No'));
	add_input_select( array('name' => 'ts_show_slider', 'label' => 'Show Javascript Slider: ', 'options' => $options, 'note' => 'Front Page Only') );
	add_input_text( array('name' => 'ts_slider_speed', 'label' => 'Slider Speed:', 'size' => 2, 'note' => 'Number of seconds between slides') );  ?>
	</div>
<?php 
}

function themeadmin_comments_box() {
?>
	<div class="optionsblock">
	<?php 
	add_input_text( array('name' => 'ts_comments_title', 'label' => 'Comments List Title:' ) );
	add_input_text( array('name' => 'ts_reply_message', 'label' => 'Reply To Post Message:' ) );
	add_input_text( array('name' => 'ts_response_message', 'label' => 'Reply To Comment Message:' ) );
	add_input_textarea( array('name' => 'ts_comment_instructions', 'label' => 'Comment Instructions:' ) );
	?>
	</div>
<?php
}

function themeadmin_sidebar_box() {
?>
		
		<div class="optionsblock">
		<img src="<?php echo get_bloginfo('stylesheet_directory'); ?>/images/admin_left.jpg" />&nbsp;&nbsp;
		<img src="<?php echo get_bloginfo('stylesheet_directory'); ?>/images/admin_right.jpg" /><br />
		
		<?php  
		
		$options = array(	array('value' => '1', 'text' => 'To the Left'), 
							array('value' => '2', 'text' => 'To the Right') );
							
        add_input_select( array('name' => 'ts_index_sidebar_position', 'label' => 'Front Page Sidebar Location: ', 'options' => $options) );
        add_input_select( array('name' => 'ts_post_sidebar_position', 'label' => 'Single Post Sidebar Location: ', 'options' => $options) );
        add_input_select( array('name' => 'ts_page_sidebar_position', 'label' => 'Static Page Sidebar Location: ', 'options' => $options) );
        add_input_select( array('name' => 'ts_archive_sidebar_position', 'label' => 'Archive Sidebar Location: ', 'options' => $options) );
        add_input_select( array('name' => 'ts_search_sidebar_position', 'label' => 'Search Page Sidebar Location: ', 'options' => $options) );
		
		?>
		</div>
<?php
}

function themeadmin_menu_box() {

	//$msoptions = get_option('msoptions');
?>
	<br />

<?php
}

function themeadmin_social_box() {
?>

	<div class="optionsblock">
		<?php 
		add_input_text( array('name' => 'ts_twitter_link', 'label' => 'Twitter Profile Link:' ) );
		add_input_text( array('name' => 'ts_facebook_link', 'label' => 'Facebook Profile Link:' ) );
		add_input_text( array('name' => 'ts_rss_link', 'label' => 'RSS Feed Link:' ) );
		?>
	</div>

	<div class="optionsblock">
	
	<?php
		
		if(isset($_GET['delete_twitter_credentials']) && $_GET['delete_twitter_credentials'] == 1) {
			$options = get_option('ts_options');
			$options['twitter-accesstoken-oauthtoken'] = '';
			$options['twitter-accesstoken-oauthtokensecret'] = '';
			update_option('ts_options', $options);
			update_option('ts_options', $options);
		}
		
		$access_token = check_twitter_credentials();
		//If user is not logged in, show the connect button
		if (!$access_token && (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret']))) {
			?>
			<p>Click on the following link to connect to your twitter account. You will be asked to login and authorize this application. Any unsaved changes to the other settings will be lost when you are redirected.</p>			

			<a href="<?php bloginfo('stylesheet_directory'); ?>/includes/twitteroauth/redirect.php?callback=<?php echo get_bloginfo('stylesheet_directory'); ?>"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/twitter_lighter.png" alt="Sign in with Twitter"/></a>
			<?php
		}
		else { //Show account details
			if(!$access_token) {
				$access_token = $_SESSION['access_token'];
				?><font color="red"><b>Important: </b>You are logged in to twitter but the session has not been saved yet, please click the "Save changes" button at the bottom of the page.</font><br /><br /><?php
			}
			$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
			$user = $connection->get('account/verify_credentials');
			?>
			<img src="<?php echo $user->profile_image_url; ?>" /><br />
			Logged-in as: <b><?php echo $user->screen_name; ?></b><br />
			<a href="<?php bloginfo('stylesheet_directory'); ?>/includes/twitteroauth/clearsessions.php">Log out</a>
			
			<input type="hidden" name="ts_options[twitter-accesstoken-oauthtoken]" value="<?php echo $access_token['oauth_token']; ?>" />
			<input type="hidden" name="ts_options[twitter-accesstoken-oauthtokensecret]" value="<?php echo $access_token['oauth_token_secret']; ?>" />
			
			<?php 
		}
		
	?>
	
	<br /><br /><br />
	
	</div>
	
	<div class="optionsblock">
		
		<b>Twitter posting</b><br /><br />
		
		<?php  
			$options = array(array('value' => '0', 'text' => 'Off'), 
							array('value' => '1', 'text' => 'On') );
							
	        add_input_select( array('name' => 'ts_twitter_automatic', 'label' => 'Automatic posting checkbox default value: ', 'options' => $options) );
			add_input_text( array('name' => 'ts_twitter_default_message', 'label' => 'Default message for posts:' ) );
		?>
		
	</div>

<?php
}

function themeadmin_misc_box() {
?>
	
	<div class="optionsblock">
	
	<b>Search Results Page</b><br /><br />
	
	<?php 
	add_input_text( array('name' => 'ts_search_title', 'label' => 'Page Title:' ) );
	add_input_textarea( array('name' => 'ts_search_fail', 'label' => 'Results Not Found Text:' ) );
	?>
	</div>
	
	<div class="optionsblock">
	
	<b>404 Page</b><br /><br />
	
	<?php 
	add_input_text( array('name' => 'ts_404_title', 'label' => 'Page Title:' ) );
	add_input_textarea( array('name' => 'ts_404_text', 'label' => 'Text:' ) );
	?>
	</div>
	
	<div class="optionsblock">
	<b>"Page not found"</b><br /><br />
	
	<?php 
	add_input_text( array('name' => 'ts_not_found_title', 'label' => 'Page Title:' ) );
	add_input_textarea( array('name' => 'ts_not_found_text', 'label' => 'Text:' ) );
	?>
	</div>
<?php 
}

function add_input_text( $args = '' ) {
	
	$defaults = array(
					'label' => '', 
					'name' => '', 
					'value' => '', 
					'size' => 60, 
					'attributes' => array());
	$a = wp_parse_args($args, $defaults);
	extract($a, EXTR_SKIP);
	
	$attr = '';
	foreach($attributes as $attribute => $attr_value) {
		$attr .= $attribute . '="' . $attr_value . '" '; 
	}
	
	$value = empty($value) ? ts_getoption($name) : $value;
	
	?>
	<label for="ts_options[<?php echo $name; ?>]"><?php echo $label; ?></label>
	<input type="text" name="ts_options[<?php echo $name; ?>]" size="<?php echo $size; ?>" value="<?php echo $value; ?>" <?php echo $attr; ?> /> <?php 
	if(!empty($note)) { ?>
		<br /><small><?php echo $note; ?></small>
	<?php } ?>
	<br /><br /><br />
<?php	
}

function add_input_textarea( $args = '' ) {
	
	$defaults = array(
					'label' => '', 
					'name' => '', 
					'value' => '', 
					'rows' => 5, 
					'cols' => 70, 
					'attributes' => array());
	$a = wp_parse_args($args, $defaults);
	extract($a, EXTR_SKIP);
	
	$attr = '';
	foreach($attributes as $attribute => $attr_value) {
		$attr .= $attribute . '="' . $attr_value . '" '; 
	}
	
	$value = empty($value) ? ts_getoption($name) : $value;
	
	?>
	<label for="ts_options[<?php echo $name; ?>]"><?php echo $label; ?></label><br />
	<textarea name="ts_options[<?php echo $name; ?>]" cols="<?php echo $cols; ?>" rows="<?php echo $rows; ?>" <?php echo $attr; ?>><?php echo $value; ?></textarea>
	<?php 
	if(!empty($note)) { ?>
		<br /><small><?php echo $note; ?></small>
	<?php
	}
	?>
	<br /><br /><br />
	<?php
}

function add_input_select( $args = '' ) {
	
	$defaults = array(
					'name' => '', 
					'label' => '', 
					'options' => array(), 
					'attributes' => array());
	$a = wp_parse_args($args, $defaults);
	extract($a, EXTR_SKIP);
	
	$attr = '';
	foreach($attributes as $attribute => $attr_value) {
		$attr .= $attribute . '="' . $attr_value . '" '; 
	}
	
	$current = ts_getoption($name);
	
	?>
	<label for="ts_options[<?php echo $name; ?>]"><?php echo $label; ?></label>
	<select name="ts_options[<?php echo $name; ?>]" <?php echo $attr; ?>><?php  
	
		foreach($options as $option) {
			$selected = $current == $option['value'] ? 'selected="selected"' : ''; ?>
			<option value="<?php echo $option['value'] ?>" <?php echo $selected ?>><?php echo $option['text'] ?></option> <?php
		}
		
	?>
	</select>
	<?php
	
	if(!empty($note)) { ?>
		<br /><small><?php echo $note; ?></small>
	<?php } ?>
	<br /><br /><br />
	<?php
}

function add_input_checkbox( $args = '' ) {
	
	$defaults = array(
					'label' => '', 
					'name' => '', 
					'checked' => 0, 
					'attributes' => array());
	$a = wp_parse_args($args, $defaults);
	extract($a, EXTR_SKIP);
	
	$attr = '';
	foreach($attributes as $attribute => $attr_value) {
		$attr .= $attribute . '="' . $attr_value . '" '; 
	}
	$is_checked = ts_getoption($name);
	
	if($is_checked == 1 and ts_getoption('has_been_saved') != 1)
		$is_checked = 'on';
	
	$checked_attribute = $is_checked == 'on' ? 'checked="checked"' : '';
	//$checked = empty($checked) ? ts_getoption($name) : $value;
	
	?>
	<input type="checkbox" name="ts_options<?php echo $name; ?>" <?php echo $checked_attribute; ?> <?php echo $attr; ?> />
	<label for="ts_options<?php echo $name; ?>"><?php echo $label; ?></label> <?php 
	if(!empty($note)) { ?>
		<br /><small><?php echo $note; ?></small><?php
	} ?>
	<br /><br /><br /><?php
}

function add_input_colorpicker( $args = '' ) {
	
	$defaults = array(
					'name' => '', 
					'label' => '', 
					'id' => '', 
					'default_color' => '', 
					'size' => 7,
					'attributes' => array());
	$a = wp_parse_args($args, $defaults);
	extract($a, EXTR_SKIP);
	
	$color = ts_getoption($name);
	//echo '--'.$color;
	$color = empty($color) ? $default_color : $color;
	
	$styledir = get_bloginfo('stylesheet_directory');
	
	$ts_option = get_option('ts_options');
	//print_r($ts_option);
	
	?>
	<div id="customWidget">
		<div id="colorSelector_<?php echo $id; ?>"><div style="background-color: <?php echo $color; ?>"></div></div>	    
		<div id="colorpickerHolder2"></div>
	</div>
	<div class="colorpickerholder">
		<label for="ts_options<?php echo $name; ?>"><?php echo $label; ?></label>
		<input type="text" name="ts_options<?php echo $name; ?>" id="<?php echo $id; ?>" size="<?php echo $size; ?>" value="<?php echo $color; ?>" />
	</div>
	<br /><br />
	
	<style>
	
		#customWidget {
			display: block;
			float: left;
		}
	
		#colorSelector_<?php echo $id; ?> {
			position: absolute;
			top: 0;
			left: 0;
			float: left;
			width: 36px;
			height: 36px;
			background: url(<?php echo $styledir; ?>/includes/js/colorpicker/images/select2.png);
		}
		
		#colorSelector_<?php echo $id; ?> div {
			position: absolute;
			top: 4px;
			left: 4px;
			width: 28px;
			height: 28px;
			background: url(<?php echo $styledir; ?>/includes/js/colorpicker/images/select2.png) center;
		}
		
		.colorpickerholder {
			display: block;
			float: left;
			position: relative;
			left: 36px;
			top: 4px;
		}
	
	</style>
	
	<script type="text/javascript">
	
	jQuery(document).ready(function($) {
		$('#colorSelector_<?php echo $id; ?>').ColorPicker({
			livepreview: true, 
			onShow: function (colpkr) {
				newColor = $('#<?php echo $id; ?>').val().replace('#', '');
				$(this).ColorPickerSetColor(newColor);
				$(colpkr).fadeIn(500);
				return false;
			}, 
			onBeforeShow: function () {
				$('#colorSelector_<?php echo $id; ?>').ColorPickerSetColor('<?php echo str_replace('#', '', $color); ?>');
			}, 
			onHide: function (colpkr) {
				$(colpkr).fadeOut(500);
				return false;
			},
			onChange: function (hsb, hex, rgb) {
				$('#colorSelector_<?php echo $id; ?> div').css('backgroundColor', '#' + hex);
				$('#<?php echo $id; ?>').val('#' + hex);
			}
		});
		
		$('#<?php echo $id; ?>').keyup(function() {
			newColor = $(this).val().replace('#', '');
			$('#colorSelector_<?php echo $id; ?> div').css('backgroundColor', '#' + newColor);
		});
	});
	
	</script>
	
	<?php 
	if(!empty($note)) { ?>
		<br /><small><?php echo $note; ?></small><?php
	} ?>
	<br /><br /><br /><?php
}
?>