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
	
</div>

<div class="clearer"></div>

</div> <!-- /footer -->

</div> <!-- /main -->


</body>
</html>
