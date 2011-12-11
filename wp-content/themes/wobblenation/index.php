<?php
/**
 * @package WordPress
 * @subpackage WobbleNation
 */

get_header(); ?>
    
    <?php if(ts_getoption('ts_show_slider') == 1): ?>
    
    <div id="slider-container">

    	<div id="slider-window">
			
			<div id="slider">
			
	    		<?php get_slider_posts(5); ?>
    		
    		</div>

    		<div class="clearer"></div>
    			
    	</div>
    	
    	<div class="nivo-controlNav">
	    	<?php get_slider_thumbnails(5); ?>
    	</div>
    		
    </div>

    <div class="clearer"></div>
    
    <?php endif; ?>

	<div id="main" class="containerblock">
		
		<div id="content">
		
			<?php if (have_posts()) : $postcount = 0;
					while (have_posts()) : the_post(); ?>
					
						<div <?php post_class('archive'); ?> id="post-<?php the_ID(); ?>">
		    				
		    				<div class="preview_image">
		    					
		    					<div class="preview_data">
		    						<?php $category = get_the_category(); ?>
		    						<div class="post-categories"><a href="<?php echo get_category_link($category[0]->cat_ID); ?>"><?php echo $category[0]->cat_name; ?></a></div>
		    						<p class="archive_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
		    						
		    						<div class="clearer"></div>
		    					</div>
		    					
		    					<a href="<?php the_permalink(); ?>" />
				    				<?php echo get_preview_thumbnail(); ?>
				    			</a>
		    					
		    				</div>
		    				
		    				<div class="preview_text">
		    				
		    					<div class="date">
		    						Published on <?php the_time('F jS, Y'); ?>
			    				</div>
			    				
			    				<?php echo str_replace('[...]', '&raquo;', str_replace('<p></p>', '', strip_tags(theme_filters(get_the_excerpt_formated(''), '<p><a>')))); ?>
		    				
		    				</div>
		    				
		    				<div class="preview_comments">
		    					
		    					<span class="comments_number"><?php comments_number('0', '1', '%'); ?></span>
		    					<span class="comments_text">Comments</span>
		    					
		    				</div>
		    				
		    				<div class="clearer"></div>
		    				
		    			</div>
					
				
					<?php
		
					endwhile; ?>
					
					<div class="clearer"></div>
					
					<div id="navigation">
						<ul>
							<?php get_pagination(); ?>
							<div class="clearer"></div>
						</ul>
						<div class="clearer"></div>
					</div>
					
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
