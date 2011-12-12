<?php
/**
 * @package WordPress
 * @subpackage WobbleNation
**/

//ini_set('display_errors','1');
//ini_set('display_startup_errors','1');
error_reporting(E_ALL ^ E_NOTICE);

if(!isset($_SESSION))
	session_start();

// Define constants
$themename = "WobbleNation";
$shortname = "WobbleNation";

/**
 * Include all the necessary files 
**/

// Theme API
include_once('includes/API/media.php');
include_once('includes/API/posts.php');

// Custom theme functions
include_once('includes/general.php');
include_once('includes/content.php');
include_once('includes/header.php');
include_once('includes/thumbnails.php');

// Third party APIs
include_once('includes/twitter.php');



/**
 * Register Scripts
**/
wp_register_script('cpicker', get_bloginfo('stylesheet_directory') . '/includes/js/colorpicker/js/colorpicker.js', 'jquery', '1.0');
wp_register_script('adminpanel', get_bloginfo('stylesheet_directory') . '/includes/js/adminpanel.js', 'jquery, colorpicker', '1.0');



/**
 * Add Support for Wordpress updated features
**/

// Custom Backgrounds (3.0+)
if (function_exists('add_custom_background')) {
	add_custom_background();
}

// Custom Menus (3.0+)
add_action( 'init', 'register_menus' );
function register_menus() {
	register_nav_menu( 'primary_menu', __( 'Main Menu' ) );
	register_nav_menu( 'top_menu', __( 'Top Menu' ) );
}

// Post Thumbnails (2.9+)
if (function_exists('add_theme_support')) {
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size(300, 150, true);
	add_image_size('theme-slidersize', 328, 212, true);
	add_image_size('theme-gallerysize', 120, 100, true);
}


/**
 * Register Widgetized areas (sidebars, footers, etc)
**/

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Sidebar', 
		'id' => 'sidebar', 
        'before_widget' => '<li id="%1$s" class="widget %2$s"><div class="widget_container">',
        'after_widget' => '</div><div class="clearer"></div></li>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2><div class="ruler"></div>',
    ));
        
}

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Footer', 
		'id' => 'bottom', 
        'before_widget' => '<li id="%1$s" class="widgetb %2$s">',
        'after_widget' => '</div><div class="clearer"></div></li>',
        'before_title' => '<h2 class="widgetbtitle">',
        'after_title' => '</h2><div class="ruler"></div><div class="widgetb_container">',
    ));
        
}



/**
 * Add features to the admin panel
**/
include_once('includes/admin/boxes.php'); // Add the write/edit page boxes
include('includes/admin/options.php'); //Add the theme's options page

// Add css files for the admin panel
add_action('admin_head', 'admin_styles');
function admin_styles() {
	?>
	<link rel="stylesheet" media="screen" type="text/css" href="<?php echo get_bloginfo('stylesheet_directory') . '/styles/admin.css'; ?>" />
	<link rel="stylesheet" media="screen" type="text/css" href="<?php echo get_bloginfo('stylesheet_directory') . '/styles/common.css'; ?>" />
	<link rel="stylesheet" media="screen" type="text/css" href="<?php echo get_bloginfo('stylesheet_directory') . '/includes/js/colorpicker/css/colorpicker.css'; ?>" />
	<link rel="stylesheet" media="screen" type="text/css" href="<?php echo get_bloginfo('stylesheet_directory') . '/includes/js/colorpicker/css/layout.css'; ?>" />
	<?php
}



/**
 * Register Widgets
**/

//Custom Recent posts
include_once('widgets/recent.php');
add_action('widgets_init', 'ts_widget_recent_init');

// Video
include_once('widgets/video.php');
add_action('widgets_init', 'ts_widget_video_init');

// Twitter
include_once('widgets/twitter.php');
add_action('widgets_init', 'ts_widget_twitter_init');

// Social
include_once('widgets/social.php');
add_action('widgets_init', 'ts_widget_social_init');

include_once('widgets/facebook.php');

// Add the twitter wrapper
include_once('includes/twitteroauth/twitteroauth.php');
include_once('includes/twitteroauth/config.php');



/**
 * Enque scripts for the admin panel
**/

function register_theme_scripts() {
	wp_enqueue_script('cpicker');
	wp_enqueue_script('adminpanel');
}


/**
 * Exclude pages from search results
**/
function exclude_pages_from_search($query) {
	if ($query->is_search) {
		$query->set('post_type', 'post');
	}
	return $query;
}
add_filter('pre_get_posts','exclude_pages_from_search');



/**
 * Get a default theme value from the setting page
**/
function get_default_setting($option) {
	
	$styledir = get_bloginfo('stylesheet_directory');
	
	include('includes/settings.php');
	
	if(array_key_exists($option, $defaults)) {
		return $defaults[$option];
	}
	else {
		return array_deep_exists($defaults, $option);
	}
}


// DEPRECTATED, DO NOT USE, WILL BE REMOVED SOON
function NPgetoption($option) {
	$value = get_option($option);
	if(!empty($value))
		return $value;
	else
		return get_default_setting($option);
}



// DEPRECATED, SOON TO BE REMOVED, SUBSTITUTED BY ts_getoption()
function cs_getoption($option, $holders = '') {
	$msoptions = get_option('msoptions');
	$value = $msoptions[$option];
	/*$value = replace_holders($msoptions[$option], $holders);*/
	if($value == '')
		$value = get_default_setting($option);

	$value = replace_holders($value, $holders);
	return $value;
	
}


/**
 * Custom function to get an option from the database
 * Allows for filters and returns the default values from the settings 
 * if the option hasn't been saved to the database
 * Replaces the now deprecated cs_getoption
*/ 
function ts_getoption($option, $holders = '') {
	$ts_option = get_option('ts_options');
	
	if(!empty($ts_option)) {
		if(array_key_exists($option, $ts_option))
			$value = $ts_option[$option];
		else
			$value = array_deep_exists($ts_option, $option);
	}
		
	if(empty($value))
		$value = get_default_setting($option);

	$value = replace_holders($value, $holders);
	return $value;
	
}

/**
 * Get the theme's default settings
**/
function ts_get_defaults() {
	$styledir = get_bloginfo('stylesheet_directory');
	include('includes/settings.php');
	return $defaults;
}


/**
 * Catch the posts content before it is displayed and manage it
**/
function theme_filters($content) {
	
	echo $content;
	
}

/*------------------------------Admin / Login Customization-------------------*/
//Remove Default Dashboard Widgets
add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');

function my_custom_dashboard_widgets() {
   global $wp_meta_boxes;

   unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
   unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
   unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);

   wp_add_dashboard_widget('custom_help_widget', 'Welcome!', 'custom_dashboard_help');
}

//Custom Dashboard Help Widget
function custom_dashboard_help() {
	echo '<p>Welcome to WobbleNation! We hope you enjoy your stay. Here, we share the dirtiest, and best of dubstep from around the world!</p>';
}

//Change Login Page URL
function change_wp_login_url() {
echo bloginfo('url');
}
add_filter('login_headerurl', 'change_wp_login_url');

//Change Logo Title
function change_wp_login_title() {
echo 'Powered by ' . get_option('blogname');
}
add_filter('login_headertitle', 'change_wp_login_title');

//Custom Login CSS
function custom_login() {
 echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('template_directory') . '/styles/custom-login.css" />';
}
add_action('login_head', 'custom_login');

//Change Admin footer text
function modify_footer_admin () {
  echo 'Created by <a href="http://razerdesign.com">Kevin Kirsche</a>. ';
  echo '| The drop was so dirty that when my mom walked in, I switched to porn.</span> | <a href="http://codex.wordpress.org/" target="blank">Documentation</a>';
}

add_filter('admin_footer_text', 'modify_footer_admin');
?>
