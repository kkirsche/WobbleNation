<?php
/**
 * @package WordPress
 * @subpackage WobbleNation
 */
?>

	<div id="sidebar">
		
		<ul>
			<?php 	
			
				if(function_exists('dynamic_sidebar')) {
					if(!dynamic_sidebar('sidebar')) {
						?>
						<li class="widget"><h2 class="widgettitle">Sidebar</h2>
							<p>This is your sidebar, you can add content here in the widgets section of admin panel</p>
						</li>
						<?php 
					}
				}
				
			?>
		</ul>
	</div>
	
	<div class="clearer"></div>

