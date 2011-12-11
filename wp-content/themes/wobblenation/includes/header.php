<?php 
/**
 * Header related functions
 * Exclusive to the WobbleNation theme
 * 
 * @package WordPress
 * @subpackage WobbleNation
**/

/**
 * Retrieves and displays the external suscription links.
 * The links can be set in the options page
 *
 * To do: Support this functionality in a catch-all function. Integrate with the widget as well 
*/
function get_suscription_links() {
	
	$links = array('flickr', 'facebook', 'twitter', 'last', 'youtube', 'myspace', 'email', 'rss');

    foreach($links as $link) {
    	$option = cs_getoption('suscription-' . $link);
    	
    	if(!empty($option)) {
    		echo '<li><a href="' . $option . '" id="suscription_' . $link . '">' . $link . '</a></li>';
    	}
    	
    }
	
}

?>