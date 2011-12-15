<?php
/**
 * @package WordPress
 * @subpackage WobbleNation
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
<link rel="icon" type="image/png" href="<?php bloginfo('template_directory'); ?>/images/favicon.png" />
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />

<style>
<?php 
	include_once('styles/options.php');
?>
</style>

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

<?php wp_head(); ?>

<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/includes/js/jquery-1.4.1.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/includes/js/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/includes/js/jquery-supersleight.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/includes/js/jquery.nivo.slider.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/fonts/cufon-yui.js"></script>
		<script src="<?php bloginfo('template_directory'); ?>/fonts/Bebas_400.font.js" type="text/javascript"></script>
		<script src="<?php bloginfo('template_directory'); ?>/fonts/League_Gothic_400.font.js" type="text/javascript"></script>
		<script type="text/javascript">
			Cufon.replace('#categories_menu ul li a, #menu ul li a, #searchsubmit, #submit, .nivo-caption, .archive_title a, .widgettitle, .widgetbtitle', {fontFamily: 'League Gothic'});
			Cufon.replace('.nivo-caption p, .nivo-caption span, .post_title, .pagetitle, .archive .post-categories a, .category_item, .singlepost .post-categories a, .comments_number, .comments_text, .entry h1, .entry h3, .entry h4, .entry h5, .entry h6, .subtitle', {fontFamily: 'Bebas'});
			
			// If you need accents, reverse accents, and other language-specific characters, comment the two lines above and uncomment the line below
			//Cufon.replace('#categories_menu ul li a, #menu ul li a, #searchsubmit, #submit, .nivo-caption, .archive_title a, .widgettitle, .widgetbtitle, .nivo-caption p, .nivo-caption span, .post_title, .pagetitle, .archive .post-categories a, .category_item, .singlepost .post-categories a, .comments_number, .comments_text, .entry h1, .entry h3, .entry h4, .entry h5, .entry h6, .subtitle', {fontFamily: 'League Gothic'});
			
</script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/includes/js/init.js"></script>

</head>

<body>

<!-- DO NOT DELETE THIS!!! -->
<div id="options">
	<!--<input type="hidden" name="option[theme_sliderspeed]" id="theme_sliderspeed" value="<?php echo cs_getoption('theme_sliderspeed'); ?>" />-->
	<input type="hidden" name="option[ts_slider_speed]" id="ts_slider_speed" value="<?php echo ts_getoption('ts_slider_speed'); ?>" />
</div>

<!-- START EDITING HERE-->

<div id="container">

	<div id="header">
			
		<a href="<?php bloginfo('url'); ?>" id="logo"><img src="<?php echo ts_getoption('ts_logo_url'); ?>" /></a>
    	
    	<div id="menu">
    		
    		<?php wp_nav_menu( array( 'theme_location' => 'top_menu', 'fallback_cb' => 'fallback_menu' ) ); ?>
    		
    	</div>
    	
    	<div class="clearer"></div>
    	
    	<div id="social_links">
    		
    		<?php 
    		$twitter_link = ts_getoption('ts_twitter_link');
    		if(!empty($twitter_link)) { ?>
	    		<a href="<?php echo $twitter_link; ?>" class="social twitter">Twitter</a>
    		<?php }
    		$facebook_link = ts_getoption('ts_facebook_link');
    		if(!empty($facebook_link)) { ?>
	    		<a href="<?php echo $facebook_link; ?>" class="social facebook">Facebook</a>
    		<?php }
    		$rss_link = ts_getoption('ts_rss_link');
    		if(!empty($rss_link)) { ?>
	    		<a href="<?php echo $rss_link; ?>" class="social rssfeed">RSS</a>
	    	<?php } ?>
    		
    	</div>
    	
    	<div class="clearer"></div>
		
	</div>

	<div class="clearer"></div>
	
	<div id="wrapper">
	
	<div id="categories_menu" class="containerblock">
	
		<?php wp_nav_menu( array( 'theme_location' => 'primary_menu', 'fallback_cb' => 'fallback_menu' ) ); ?>
		
		<?php get_search_form(); ?>
		
		<div class="clearer"></div>
	
	</div>
	
<?php 

function fallback_menu() {
	?>
	<ul>
	<li class="page_item">
		<a href="#" title="Modify">Add items to this menu in your WP admin panel</a>
	</li>
	</ul>
	<?php
}

?>
