<?php 
/**
 * Set the default theme settings
 * These are overriden by the database options once the user saves the options page
 * Exclusive to the WobbleNation theme
 * 
 * @package WordPress
 * @subpackage WobbleNation
**/

$defaults = array( 

	// POST OPTIONS
	'ts_excerpt_size' => 20, // Number of words used in the post previews
    'ts_miniexcerpt_size' => 15, // Number of word used in the widget's post previews
    
    // SLIDER OPTIONS
    'ts_slider_speed' => 6, // Seconds between slider transitions 
    'ts_show_slider' => 1, // Show slider in the front page?
    
    // COMMENT OPTIONS
    'ts_reply_message' => 'Reply', // Message to be displayed for replies
    'ts_response_message' => 'Reply to %s', // Message to be displayed for threaded responses
    'ts_comments_title' => 'Comments', // Comments section title
    'ts_comment_instructions' => 'Comment guidelines, edit this message in your Wordpress admin panel', // Comment instructions

	// PAGE TITLES
	'ts_showindex_title' => 0, // Display page title on the front page?
    'ts_index_title' => 'Latest Articles', // Front page title 
    'ts_paged_title' => 'Blog Archive, Page %page%', // Archive page title
    
    // SIDEBAR OPTIONS
    'ts_index_sidebar_position' => 2, // Sidebar position in the front page (1: Left 2: Right) 
    'ts_page_sidebar_position' => 1, // Sidebar position in the single pages (1: Left 2: Right)  
    'ts_post_sidebar_position' => 1,  // Sidebar position in the single posts page (1: Left 2: Right)
    'ts_archive_sidebar_position' => 2, // Sidebar position in the archive (1: Left 2: Right)
    'ts_search_sidebar_position' => 2,  // Sidebar position in the search page (1: Left 2: Right)
    
    // SOCIAL OPTIONS
    'ts_twitter_link' => '', // Twitter profile link
    'ts_facebook_link' => '', // Facebook profile link
    'ts_rss_link' => get_bloginfo('rss2_url'), // RSS Link
    
    // TWITTER OPTIONS
    'ts_twitter_automatic' => 0, 
    'ts_twitter_default_message' => 'New post on %blogname%: %permalink%', // Default message for twitter notifications
    
    // LOGO OPTIONS
    'ts_logo_url' => $styledir . '/images/logo.png', // Logo default location
    'ts_logo_width' => '198',  // Logo default width
    'ts_logo_height' => '59', // Logo default height
    
    // THEME MESSAGES
    'ts_404_title' => 'Page not found', // 404 page title 
    'ts_404_text' => 'The page you are looking for does not exist', // 404 page message 
    'ts_not_found_title' => 'Not found', // Not found page title
    'ts_not_found_text' => 'Sorry, the page you are looking for has been deleted or moved', // Nota found page message
    'ts_search_title' => 'Search results for %searchterm%', // Search page title
    'ts_search_fail' => 'No results found please try a different search term or check your spelling', // Search: Not results found message 

    'ts_bg_color' => '#000000',  // Default background color
    'ts_bg_image' => $styledir . '/images/bg_stars.jpg', // Default background image
    
    //COLORS
    'ts_menu_bg_color' => '#4c5559', // Background color for the menu items
    'ts_container_bg_color' => '#ffffff', // Main containers Background
    'ts_categories_color' => '#a90404', // Category tags
    'ts_widget_title_bg_color' => '#94908a', // Widget title background
    'ts_widget_title_color' => '#ffffff', // Widget title text
    'ts_footer_title_color' => '#827f7c', // Footer title text
    'ts_text_color' => '#4f4f4f', // Main text
    'ts_alt_text_color' => '#aeaeae', // Alternate text
    'ts_link_color' => '#9c9995', // Links
    'ts_text_bg_color' => '#f2eee9', // Taxt background
    
    //TEMPLATE DEFAULTS
    
    'template1' => array(
    	'Main Menu' => array(	'selectors' => '#categories_menu ul li, #categories_menu ul li a', 
    										'styles' => array(	'background-color' => '#4c5559', 
    															'color' => '#ffffff')
    						), 
    	'Secondary Menu' => array(	'selectors' => '#menu ul li a', 
    								'styles' => array('color' => '#ffffff')
    							), 
    	'Preview Title' => array(	'selectors' => '.archive_title a, .nivo-caption', 
    								'styles' => array('color' => '#ffffff')
    							), 
    	'Container Background' => array(	'selectors' => '#content, #content_full, .widget, #slider-container, .post, .page', 
				    						'styles' => array('background-color' => '#ffffff')
    									), 
    	'Blockquotes' => array(	'selectors' => '.entry blockquote, .entry pre, .entry code, .comment', 
    							'styles' => array('background-color' => '#fafafa')
    						), 
    	'Category Tags' => array(	'selectors' => '.post-categories a, .nivo-caption span, .category_item', 
				    				'styles' => array(	'background-color' => '#a90404', 
				    									'color' => '#ffffff')
    							), 
    	'Widget Title' => array(	'selectors' => '.widgettitle', 
				    				'styles' => array(	'background-color' => '#94908a', 
				    									'color' => '#ffffff')
    							),  
    	'Navigation' => array(	'selectors' => ' #sidebar .widget_container li a, .navigation_item a, .widget_container th, .widget_container td', 
    								'styles' => array('background-color' => '#f2f2f2', 
    								'color' => '#949494')
    	
    					), 
    	'Text' => array(	'selectors' => 'body', 
				    		'styles' => array('color' => '#4f4f4f')
    					), 
    	'Titles' => array(	'selectors' => '.post_title, .post_title a, .subtitle, .subtitle a', 
    						'styles' => array('color' => '#3a3a3a'), 
    					), 
    	'Alternate Text' => array(	'selectors' => '.date, .comments_number, .comments_text', 
				    				'styles' => array('color' => '#aeaeae')
    					), 
    	'Links' => array(	'selectors' => '.entry a, #comments a, #reply a, #sidebar p a', 
				    		'styles' => array('color' => '#9c9995')
    					), 
    	'Form Fields' => array(	'selectors' => '.inputtext, .inputarea, #s', 
    							'styles' => array(	'background-color' => '#eaeaea', 
    												'color' => '#111111')
    							), 
    	'Buttons' => array(	'selectors' => '#submit, #searchsubmit, .inputbutton', 
    						'styles' => array(	'background-color' => '#898989', 
    											'color' => '#ffffff')
    						), 
    	'Footer' => array(	'selectors' => '#footer', 
    						'styles' => array(	'background-color' => '#111111', 
    											'color' => '#dddddd')
    						), 
    	'Footer Title' => array(	'selectors' => '.widgetbtitle', 
				    				'styles' => array('color' => '#b1aaa6')
    							),
    	'Footer Links' => array('selectors' => '.widgetb a, .widgetb_container li a ', 
    							'styles' => array('color' => '#88827f')
    						), 
    	'Footer Boxes' => array('selectors' => '.twitter_status li', 
    							'styles' => array('background-color' => '#000000')
    						), 
    	
    ), 
    
);


?>