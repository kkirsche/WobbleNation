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
 * Catch-all function for displaying the thumbnail/preview image of a post
 * Must be used inside the loop
 *
 * @param meta_key: A custom field containing an image's url
 * @param get_from_content: Should the function try to grab an image from the post's content?
 * @param thumbnail_size: Predefined or custom wordpress image sizes ('post-thumbnail', 'medium', etc)
 * @param default: Default image to display if everything else fails
 *
 * Recommended: If thumbnail_size will be used, set force_resize to 0
*/
function get_preview_image( $args = '' ) {
	
	global $post;
	$imagetag = '';
	
	$defaults = array(
				'width' => 0,
				'height' => 0, 
				'meta_key' => '', 
				'get_from_content' => 1, 
				'force_resize' => 1, 
				'thumbnail_size' => '', 
				'image_attributes' => array(), 
				'default' => '');
	$a = wp_parse_args($args, $defaults);
	extract($a, EXTR_SKIP);
	
	if(!empty($meta_key)) { $imageurl = get_post_meta($post->ID, $meta_key, true); }
	
	if(empty($imageurl)) {
		
		// Try to get the official thumbnail, WP 3.0+
		if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) {
			if(empty($thumbnail_size) and $force_resize == 1) {
				// Not recommended for actual use, wordpress downsizes the images and custom values do not always work properly. 
				// It's only here as a fallback option
				$imagetag = get_the_post_thumbnail($post->ID, array($width, $height), $image_attributes);
			}
			else {
				$imagetag = get_the_post_thumbnail($post->ID, $thumbnail_size, $image_attributes);
			}
			
		}
		else {  
			
			// Try to get the first image from the post's content
			if($get_from_content == 1) {
				$post_content = get_the_content_full();
		        $imageurl = get_post_image($post_content);
			}

	        if(empty($imageurl) and !empty($default)) {
	        	$imageurl = $default;
	        	$force_resize = 0;
	        }
	    }
		
	}
	
	if(empty($imagetag) and $force_resize == 1) {
		$thumb = new thumbnail($imageurl, $width, $height);
		$thumb->make();
	    $imagetag = $thumb->get_tag($image_attributes);
	}
	
	return $imagetag;
}

/** 
 * Gets the thumbnail of the current post
 * Defaults to the custom thumbnail values set in includes/settings.php
*/
function get_preview_thumbnail() {
    	
    $args = array(
    			'thumbnail_size' => 'post-thumbnail', 
    			'force_resize' => 1, 
    			'width' => 300, 
    			'height' => 150);

	$imagetag = get_preview_image($args);
	return $imagetag;
	
}

/**
 * Tries to grab the first image from the post's content
 * regex function might need some polishing to catch specific cases
**/
function get_post_image($content) {
	
	$pattern = '/<img[^>]+src[\\s=\'"]+([^"\'>\\s]+)/is';
	preg_match($pattern, $content, $match);
	$image = $match[1];
	return $image;

}

/**
 * Tries to grab a post's thumbnail from the attachments
 * Not in current use, might need some improvement
**/
function get_post_thumbnail() { 
 
    // Get the post ID 
	$iPostID = get_the_ID(); 
 
    // Get images for this post 
    $arrImages =& get_children('post_type=attachment&post_mime_type=image&post_parent=' . $iPostID ); 
 
    // If images exist for this page 
    if($arrImages) { 
 
        $arrKeys = array_keys($arrImages); 

        $iNum = $arrKeys[0]; 
        $sThumbUrl = wp_get_attachment_thumb_url($iNum); 
        $sImgString = '<a href="' . get_permalink() . '">' . 
                            '<img src="' . $sThumbUrl . '" width="75" height="75" alt="Thumbnail Image" title="Thumbnail Image" />' . 
                        '</a>'; 
        echo $sImgString; 
    } 
}

/**
 * Validates that the user's gravatar exists
 * Not useful since gravatar was bought and integrated to WP but might be useful in the future
**/
/*function validate_gravatar($email) {
	$hash = md5($email);

	$uri = 'http://www.gravatar.com/avatar/' . $hash . '?s=40&d=identicon&r=G';

	$headers = wp_get_http_headers($uri);
	
	if(!empty($headers["content-disposition"])) {
		$has_valid_avatar = true;
	}
	else {
		$has_valid_avatar = false;
	}

	return $has_valid_avatar;
}*/

?>