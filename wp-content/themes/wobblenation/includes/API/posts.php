<?php 
/**
 * Theme API
 * Post related functions for the theme
 * For use only with the purchased theme
 *
 * Since: Wordpress 3.0
 * Author: Oscar Alcala
 * Website: http://www.oscaralcala.com
 * 
 * @package WordPress
**/

/**
 * Gets the custom excerpt size in number of words
 * The default is set in the settings page, it can be changed by the user via the options page
*/
add_filter('excerpt_length', 'my_excerpt_length');
function my_excerpt_length($length) {
	return ts_getoption('ts_excerpt_size');
}

/**
 * Selects a set of posts or pages that contain the specified meta key (custom field)
 *
 * @param key: Name of the custom field to select.
 * @param value: Value the meta key must be set to in order to be valid/active. Usually 1.
 * @param post_type: 'post' or 'page'.
 *
 * To do: Check if custom types work
*/
function get_posts_by_meta($key, $value, $max = 5, $post_type = '') {

	$query_args = array(
		'meta_key' => $key, 
		'meta_value' => $value, 
		'posts_per_page' => $max, 
		'post__not_in' => get_option( 'sticky_posts' )
	);
		
	$posts = new WP_Query($query_args);
	return $posts;
}

/**
 * Substitute for the default get_the_content() function
 * Gets the post content, and allows the theme to apply filters to it before it is shown to the user
*/
function get_the_content_formated ($more_link_text = '', $stripteaser = 0, $more_file = '') {
	$content = get_the_content($more_link_text, $stripteaser, $more_file);
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	return $content;
}

/**
 * This does the exact same thing as get_the_content_formated(), why the fuck am i still using it?
*/
function get_the_content_full ($more_link_text = '', $stripteaser = 0, $more_file = '') {
	global $more;
	$more = 1;
	$content = get_the_content($more_link_text, $stripteaser, $more_file);
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	$more = 0;
	return $content;
}

/**
 * Substitute for the default get_the_excerpt() function
 * Gets the post excerpt, and allows the theme to apply filters to it before it is shown to the user
*/
function get_the_excerpt_formated ($more_link_text = '', $stripteaser = 0, $more_file = '') {
	$content = get_the_excerpt($more_link_text, $stripteaser, $more_file);
	$content = str_replace('[...]', '', $content);
	$excerpt_size = ts_getoption('ts_excerpt_size');
	$content = split_by_words($excerpt_size, $content);
	$content = apply_filters('the_content', $content);
	$content = str_replace('</p>', ' &raquo;</p>', $content);
	
	return $content;
}

/**
 * Replace custom keywords with a variable value
 * It can be called before the posts are displayed or as a filter for other actions
 *
 * @var string value: Haystack
 * @var array holders: Array containg the values to be replaced  
**/
function replace_holders($value, $holders = '') {
	global $paged;
	
	if(!is_admin()):
		
		$value = str_replace('%blogname%', get_bloginfo('name'), $value);
		$value = str_replace('%page%', $paged, $value);
		$value = str_replace('%searchterm%', get_search_query(), $value);
		
	endif;

	if(!empty($holders)) {
		foreach($holders as $holder => $holdervalue) {
			$value = str_replace('%' . $holder . '%', $holdervalue, $value);
		}
	}
	
	return $value;
}



/*function print_content_formated($content, $max_chars, $allowed_tags = '') {

	$newcontent = strip_tags($content, $allowed_tags);
	$newcontent = substr($newcontent, 0, $max_chars);

	while(substr($newcontent, -1) != ' ' and strlen($newcontent) > 0) {
		$newcontent = substr($newcontent, 0, -1);
	}
	
	echo $newcontent . '..';

}*/

?>