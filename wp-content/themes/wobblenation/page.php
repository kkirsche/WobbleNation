<?php
/**
 * @package WordPress
 * @subpackage WobbleNation
 */

// Get theme Options
$max_slider_posts = cs_getoption('theme_slidermax');

get_header(); ?>

	<div id="main" class="containerblock">
		
		<div id="content">
		
			<?php if (have_posts()) : $postcount = 0;
					while (have_posts()) : the_post(); ?>
					
						<div <?php post_class('singlepost'); ?> id="post-<?php the_ID(); ?>">
		    				
		    				<?php the_category(); ?><div class="clearer"></div>
		    				
		    				<h2 class="post_title"><?php the_title(); ?></h2>
		    				
		    				<div class="clearer"></div>
		    				
		    				<div class="date">
		    					Published on <?php the_time('F S, Y'); ?>
			    			</div>
			    				
			    			<div class="entry">
			    				
				    		<?php 
				    			the_content();
			    				wp_link_pages();
			    				edit_post_link();
			    			?>
			    			
			    			</div>
		    				
		    				<div class="clearer"></div>
		    				
		    				<div class="clearer"></div>
		    				
		    			</div>
					
				
					<?php	
					endwhile; 
					?>
					
					<div class="clearer"></div>
					
			<?php else : ?>
		
				<div class="post">    				
		    		<div class="entry">
						<h2 class="title"><?php echo ts_getoption('ts_not_found_title'); ?></h2>
						<p><?php echo ts_getoption('ts_not_found_text'); ?></p>
					</div>
				</div>
		
			<?php endif; ?>
				
		</div>
		
		<?php get_sidebar(); ?>
		
		<div class="clearer"></div>

	</div>
	
	<?php get_footer(); ?>
