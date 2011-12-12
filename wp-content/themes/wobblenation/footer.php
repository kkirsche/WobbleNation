<?php
/**
 * @package WordPress
 * @subpackage WobbleNation
 */
?>
<div id="footer">

	<ul id="footerwidgets">
		<?php 	
			
			if(function_exists('dynamic_sidebar')) {
				if(!dynamic_sidebar('bottom')) {
					?>
					<li id="ts_recent" class="widgetb ts_recent_widget">
						<h2 class="widgetbtitle">Footer</h2>
						<div class="ruler"></div>
						<div class="widgetb_container">
							This is your footer, you can add content here by going to the widgets section of your wordpress admin panel
						</div>
					</li>
					<?php
				}
			}
			
		?>
	</ul>
	<?php wp_footer(); ?>
	<div class="clearer"></div>
	<p>© WobbleNation 2011 All Rights Reserved</p>
</div>

<div class="clearer"></div>

</div> <!-- /footer -->

</div> <!-- /main -->

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-27635668-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>
