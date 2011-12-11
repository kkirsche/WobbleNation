/**
 * Start all the scripts that require initializing when jQuery is ready
 * For exclusive use with the Magzimus theme
 *
 * Author: Oscar Alcala
 * Website: http://www.themeforest.net?ref=BioXD
**/

jQuery(document).ready(function($) {
	
	// This allows the sidebar widgets to display properly, do not remove or the layout will break!
	$('.widget_title').each(function(){ $(this).prependTo(this.parentNode.parentNode); });
	
	// Start the sliders
	var slides = $('.slider_thumbnail').size() - 1;
	var ts_slider_speed = $('#ts_slider_speed').attr('value') * 1000;
	
	
		$('.slider_thumbnail[rel=0]').animate({
			opacity: 0.8 
		}, 600);
	
	
	$('#slider').nivoSlider({
		effect: 'fold, fade, sliceUpDownLeft, sliceUpDown',  
		animSpeed: 1200,
		pauseTime: ts_slider_speed,
		pauseOnHover: false, 
		controlNav: false, 
		directionNav: false, 
		beforeChange: function() {
			$('.current_slide').animate({
				opacity: 1 
			}, 1000);
		}, 
		afterChange: function() {
			$('.slider_thumbnail[rel=' + currentSlide + ']').animate({
				opacity: 0.8 
			}, 600);
			$('.current_slide').removeClass('current_slide');
			$('.slider_thumbnail[rel=' + currentSlide + ']').addClass('current_slide');
		}
	});
	
	// Start Cufon
	Cufon.now();
	Cufon.refresh();
	
	$("#categories_menu li").hover(function(event) {
		$('.sub-menu', this).slideToggle(300);
	});
	
	// Start the gallery 
	$(".gallery a").attr('rel', 'gallery');
	$("a[rel^='gallery']").prettyPhoto({
				animationSpeed: 'normal', 
				opacity: 0.75, 
				showTitle: false, 
				allowresize: true, 
				counter_separator_label: '/', 
				theme: 'dark_rounded', 
				hideflash: false, 
				modal: false, 
				changepicturecallback: function(){}, 
				callback: function(){} 
			});	

});