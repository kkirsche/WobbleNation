<?php 

/**
 * Functions to handle and manipulate post's behaviour and display
 * Exclusive to the WobbleNation theme
 * 
 * @package WordPress
 * @subpackage WobbleNation
**/

/**
 * Get the posts to be featured on the javascript slider
 *
 * @param maxposts: WobbleNation allowed number of posts to get
 *
 * To do: Make $maxposts value to default in settings.php 
*/
function get_slider_posts($maxposts = 5) {
	global $post;
    
    $posts = get_posts_by_meta('showinslider', 1, $maxposts);
    
    if(!empty($posts->posts)) {
	    while ($posts->have_posts()) : $posts->the_post();
	    	
	    	$title = the_title_attribute('echo=0');
	    	$category = get_the_category();
	    	
	    	$image_attributes = array('title' => $title, 'rel' => $category[0]->name);
	    	$args = array(
	    			'width' => 920, 
	    			'height' => 239, 
	    			'meta_key' => 'sliderimage', 
	    			'image_attributes' => $image_attributes);
		    $imagetag = get_preview_image($args); 
	?>
			<a href="<?php the_permalink(); ?>"><?php echo $imagetag; ?></a>
	<?php 
	    endwhile;
    }
    else {
    	echo "Your slider goes here, you can set up the posts in the write/edit page of your admin panel. You can find more information in the included theme help file";
    }
}

/**
 * Gets the thumbnails that serve as controls for the javascript slider
 *
 * @param maxposts: Maximum allowed number of posts to get
 *
 * To do: Make $maxposts value to default in settings.php 
 * To do: Integrate this function with get_slider_posts to improve performance
*/
function get_slider_thumbnails($maxposts = 5) {
	global $post;
    
    $posts = get_posts_by_meta('showinslider', 1, $maxposts);
    
    $count = 0;
    while ($posts->have_posts()) : $posts->the_post();
    
    	$title = the_title_attribute('echo=0');
    	$category = get_the_category();
    	
    	$image_attributes = array('title' => $title);
    	
    	$args = array(
    			'width' => 180, 
    			'height' => 75, 
    			'meta_key' => 'sliderimage', 
    			'image_attributes' => $image_attributes);
    	
    	$imagetag = get_preview_image($args);
    	
    	$extraclass = $count == 0 ? 'current_slide' : '';
    	
    	?>
    	
    	<a href="#" class="slider_thumbnail nivo-control <?php echo $extraclass; ?>" rel="<?php echo $count; ?>"> <?php 
			echo $imagetag;  ?>
		</a> 
		<?php 	    		 
	    $count++;
	    
    endwhile;
}

/**
 * Generates and displays the pagination links
 *
 * @param range: The max number of pages to show before and after the current link
*/
function get_pagination($range = 2) {
	
	global $wp_query;
	global $max_pages;
	global $paged;
	
	if ( !$max_pages ) { $max_pages = $wp_query->max_num_pages; }
	if ( !$paged ) { $paged = 1; }

	if($max_pages > 1) {

		if($paged > 1):
		?>
			<li class="navigation_item"><a href="<?php echo get_pagenum_link($paged - 1); ?>">&laquo; Last</a></li>
		<?php
		endif;

		// Show the first link
		$class = $paged == 1 ? 'class="current_page"' : '';
		if($paged <= $paged - $range or $paged - $range <= 1) { 
		?>
			<li class="navigation_item"><a href="<?php echo get_pagenum_link(1); ?>" <?php echo $class; ?>>1</a></li>
		<?php 
		}
		else { 
		?>
			<li class="navigation_item"><a href="<?php echo get_pagenum_link(1); ?>">&laquo;</a></li>
		<?php 
		}
		
		$i = $maxed = 0;
		for($i = $paged - $range; $i <= $paged + $range; $i++) {
			
			$class = $paged == $i ? 'class="current_page"' : '';
			
			if($i > 1 and $i < $max_pages) { 
			?>
				<li class="navigation_item"><a href="<?php echo get_pagenum_link($i); ?>" <?php echo $class; ?>><?php echo $i; ?></a></li>
			<?php 
			}
		
		}
	
		// Show the last link
		$class = $paged == $max_pages ? 'class="current_page"' : '';
		if($paged + $range >= $max_pages) { 
		?>
			<li class="navigation_item current_page"><a href="<?php echo get_pagenum_link($max_pages); ?>" <?php echo $class; ?>><?php echo $max_pages; ?></a></li>
		<?php 
		}
		else { 
		?>
			<li class="navigation_item current_page"><a href="<?php echo get_pagenum_link($max_pages); ?>">&raquo;</a></li>
		<?php 
		}
		
		if($paged < $max_pages):
		?>
			<li class="navigation_item"><a href="<?php echo get_pagenum_link($paged + 1); ?>">Next &raquo;</a></li>
		<?php
		endif;
	
	}
	
}

?>