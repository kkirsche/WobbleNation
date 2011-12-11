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
		
			<?php if (is_category()) { ?>
			<h2 class="pagetitle">Archive for the &#8216;<?php single_cat_title(); ?>&#8217; Category</h2>
		 	<?php } elseif( is_tag() ) { ?>
			<h2 class="pagetitle">Posts Tagged as &#8216;<?php single_tag_title(); ?>&#8217;</h2>
			<?php } elseif (is_day()) { ?>
			<h2 class="pagetitle">Archive for <?php the_time('F jS, Y'); ?></h2>
		 	<?php } elseif (is_month()) { ?>
			<h2 class="pagetitle">Archive for <?php the_time('F, Y'); ?></h2>
		 	<?php } elseif (is_year()) { ?>
			<h2 class="pagetitle">Archive for <?php the_time('Y'); ?></h2>
			<?php } elseif (is_author()) { ?>
			<h2 class="pagetitle">Author Archive</h2>
			<?php } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
			<h2 class="pagetitle">Blog Archives</h2>
		 	<?php } ?>
		
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