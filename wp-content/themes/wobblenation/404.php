<?php
/**
 * @package WordPress
 * @subpackage WobbleNation
 */

get_header(); ?>

	<div id="main" class="containerblock">
		
		<div id="content">
		    				
			<h2 class="post_title"><?php echo ts_getoption('ts_not_found_title'); ?></h2>
		    				
		    <div class="clearer"></div>
			    				
			<div class="entry">
				<?php echo ts_getoption('ts_not_found_text'); ?>
			</div>
		    				
		    <div class="clearer"></div>
		    			    				
		</div>
		
		<?php get_sidebar(); ?>
		
		<div class="clearer"></div>

	</div>
	
	<?php get_footer(); ?>