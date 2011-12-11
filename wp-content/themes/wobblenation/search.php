<?php
/**
 * @package WordPress
 * @subpackage WobbleNation
 */

global $query_string;

$query_args = explode("&", $query_string);
$search_query = array('post_type' => 'post');

foreach($query_args as $key => $string) {
	$query_split = explode("=", $string);
	$search_query[$query_split[0]] = $query_split[1];
} // foreach

$search = new WP_Query($search_query);

//print_r($search);

$temp_query = $query_string;
$query_string = $search;

get_header(); ?>

	<div id="main" class="containerblock">
		
		<div id="content">
		
			<h2 class="pagetitle"><?php echo ts_getoption('ts_search_title', array('searchterm' => get_search_query())); ?></h2>
		
			<?php if (have_posts()) : $postcount = 0;
					while (have_posts()) : the_post(); 
						
						//if($post->post_type != 'page'):
					?>
					
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
					//endif;
					endwhile; 
					?>
					
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
						<h2 class="title"><?php echo ts_getoption('ts_search_title'); ?></h2>
						<p><?php echo ts_getoption('ts_search_fail'); ?></p>
					</div>
				</div>
		
			<?php endif; ?>
				
		</div>
		
		<?php get_sidebar(); ?>
		
		<div class="clearer"></div>

	</div>
	
	<?php get_footer(); ?>