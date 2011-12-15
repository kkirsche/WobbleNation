/**
 * Add custom javascript functionality to the wordpress admin panel
 * For exclusive use with the Magizmus theme
 *
 * Author: Oscar Alcala
 * Website: http://www.themeforest.net?ref=BioXD
**/

jQuery(document).ready(function($) {
	
	$('.optiontab').click(function(event) {
	
		event.preventDefault();
		target = $(this).attr('rel');
		
		$('.section').each(function() {
			$(this).hide();
		});
		
		$('#' + target).show();
	
	});

});