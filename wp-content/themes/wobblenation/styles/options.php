<?php
/**
 * This file sets the variable styles that can be selected by the user via the options page.
 * Exclusive to the WobbleNation theme
 * 
 * @package WordPress
 * @subpackage WobbleNation
**/

// Get dynamic layout options

$sidebarright = '
#sidebar {
	float: left;
	margin: 0 0 0 5px;
}

#content {
	float: left;
}
';

$sidebarleft = '
#sidebar {
	float: left;
	margin: 0;
}

#content {
	float: right;
}
';

if(is_front_page()){
	$css = ts_getoption('ts_index_sidebar_position') == 1 ? $sidebarleft : $sidebarright;
}
elseif(is_single()) {
	$css = ts_getoption('ts_post_sidebar_position') == 1 ? $sidebarleft : $sidebarright;
}
elseif(is_page()) {
	$css = ts_getoption('ts_page_sidebar_position') == 1 ? $sidebarleft : $sidebarright;
}
elseif(is_archive()) {
	$css = ts_getoption('ts_archive_sidebar_position') == 1 ? $sidebarleft : $sidebarright;
}
elseif(is_search()) {
	$css = ts_getoption('ts_search_sidebar_position') == 1 ? $sidebarleft : $sidebarright;
}
else {
	$css = $sidebarleft;
}
	
echo $css;


// Get dynamic template options

$defaults = ts_get_defaults();
$template = ts_getoption('template1');

foreach($defaults['template1'] as $style_key => $style) {
	
	//var_dump($style);
	//var_dump($defaults);
	echo $defaults['template1'][$style_key]['selectors'] . " {\n";
	
	foreach($template[$style_key]['styles'] as $key => $value) {
		$val = empty($value) ? $defaults['template1'][$style_key]['styles'][$key] : $value;
		echo $key . ": $value;\n";
	}
	
	echo "}\n\n";
	
}

?>