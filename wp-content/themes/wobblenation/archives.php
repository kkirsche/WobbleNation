<?php
/*
Template Name: Archives
*/

/**
 * @package WordPress
 * @subpackage WobbleNation
 */

// Get theme Options
$max_slider_posts = cs_getoption('theme_slidermax');

get_header(); ?>

	<div id="main" class="containerblock">
		
		<div id="content_full">
		
			<?php if (have_posts()) : $postcount = 0;
					while (have_posts()) : the_post(); ?>
					
						<div <?php post_class('fullpost'); ?> id="post-<?php the_ID(); ?>">
							
							<div class="full_column">
							
								<h2 class="pagetitle">Last 20 posts:</h2>
							
								<div class="entry">
									<ul>
										<?php wp_get_archives('type=postbypost&limit=20');?>
									</ul>
								</div>
							
							</div>
							
							<div class="full_column">
							
								<h2 class="pagetitle">Last Week:</h2>
							
								<div class="entry">
									<ul>
										<?php wp_get_archives('type=daily&limit=7');?>
									</ul>
								</div>
							
							</div>
							
							<div class="full_column">
							
								<h2 class="pagetitle">Archives by Month:</h2>
								
								<div class="entry">
									<ul>
										<?php wp_get_archives('type=monthly&showcount=1'); ?>
									</ul>
								</div>
							
							</div>
							
							<div class="clearer"></div>
							
						</div>
					
					<?php endwhile; ?>
					
					<div class="clearer"></div>
					
			<?php else : ?>
		
				<div class="post">    				
		    		<div class="entry">
						<h2 class="title"><?php echo $notfound_title; ?></h2>
						<p><?php echo $notfound_text ?></p>
					</div>
				</div>
		
			<?php endif; ?>
				
		</div>
		
		<div class="clearer"></div>

	</div>
	
	<?php get_footer(); ?>