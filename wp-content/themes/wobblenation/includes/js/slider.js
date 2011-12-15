/**
 * Creates the javascript slider
 * Not used when running Nivo Slider or another slider script
 * For exclusive use with the Magizmus theme
 *
 * Author: Oscar Alcala
 * Website: http://www.themeforest.net?ref=BioXD
**/

jQuery(document).ready(function($) {

	// Initialize variables
	count = $('.sliderPostWrapper').size();
	sliderWidth = parseInt($('#slider').css('width'));
	sliderHeight = parseInt($('#slider').css('height'));
	
	sliderSpeed = $('#theme_sliderspeed').attr('value') * 1000;
	
	current = 1;
	timeron = 1;
	moving = 0;
	
	motion = 0;
	
	$('.sliderControl:eq(' + (current-1) + ')').toggleClass('sliderActive');
	$('.sliderKeepReading').attr('href', $('.sliderActive').attr('rel'));
	function sliderMoveForward() {
	
		moving = 1;
		if(jQuery.support.opacity) {
			
			$('#sliderWrapper').fadeTo(sliderSpeed/10, 0, function() {
				$('#sliderWrapper').animate({ 'top':'-=' + sliderHeight }, 1, function() {
				current++;
					$('#sliderWrapper').fadeTo(sliderSpeed/10, 1, function() {
						moving = 0;
					});
				});
			});
			$('.sliderControl').removeClass('sliderActive');
			$('.sliderControl:eq(' + (current) + ')').toggleClass('sliderActive');
			$('.sliderKeepReading').attr('href', $('.sliderActive').attr('rel'));
		
		}
		else {

			$('#sliderWrapper').animate({ 'top':'-=' + sliderHeight }, sliderSpeed/10, function() {
				current++;
				moving = 0;
				$('.sliderControl').removeClass('sliderActive');
				$('.sliderControl:eq(' + (current-1) + ')').toggleClass('sliderActive');
				$('.sliderKeepReading').attr('href', $('.sliderActive').attr('rel'));
			});
		
		}
		
	}
	
	function sliderMoveToItem(item) {
		
		if(item != 0 && item <= count) {
			
			moving = 1;
			targetY = (sliderHeight * (item - 1));
			currentY = sliderHeight * (current - 1);
			
			movement = currentY < targetY ? '-=' + (targetY - currentY) : '+=' + (currentY - targetY);
			movement += 'px';
			
			if(jQuery.support.opacity) {
			
				$('#sliderWrapper').fadeTo(sliderSpeed/10, 0, function() {
					$('#sliderWrapper').animate({ 'top': movement }, 1, function() {	
						$('#sliderWrapper').fadeTo(sliderSpeed/10, 1, function() {
							moving = 0;
						});
					});
				});
				current = item;
				$('.sliderControl').removeClass('sliderActive');
				$('.sliderControl:eq(' + (current-1) + ')').toggleClass('sliderActive');
				$('.sliderKeepReading').attr('href', $('.sliderActive').attr('rel'));
			
			}
			else {
			
				$('#sliderWrapper').animate({ 'top': movement }, sliderSpeed/10, function() {
						current = item;
						moving = 0;
						$('.sliderControl').removeClass('sliderActive');
						$('.sliderControl:eq(' + (current-1) + ')').toggleClass('sliderActive');
						$('.sliderKeepReading').attr('href', $('.sliderActive').attr('rel'));
				});
			
			}
			
		}
		
	}
	
	$('.sliderControl').click(function(event) {
		
		event.preventDefault();
		
		if(moving == 0) {
		
			itemnumber = parseInt($('.sliderControl').index(this)) + 1;

			if(itemnumber != current) {
				sliderMoveToItem(itemnumber);
			}
			if(timeron == 1) { timeron = 0; }
		}
		
	});
	
	$('.slideritem').click(function(event) {
		
		event.preventDefault();
		
		if(moving == 0) {
		
			itemnumber = parseInt($('.slideritem').index(this)) + 1;

			if(itemnumber != current) {
				sliderMoveToItem(itemnumber);
			}
			if(timeron == 1) { timeron = 0; }
		}
		
	});
	
	sliderinterval = window.setInterval(function () {
		
		if(timeron == 0) { clearInterval(sliderinterval) }
		
		if(current < count && timeron == 1) {
			sliderMoveForward();
		}
		
		if(current == count && timeron == 1) {
			sliderMoveToItem(1);
		}
		
	}, sliderSpeed);
	
	$('#slider_next').click(function(event) {
		event.preventDefault();
		if(timeron == 1) { clearInterval(sliderinterval) }
		
		if(current < count && moving == 0) {
			sliderMoveForward();
		}
	});
	
	$('#slider_last').click(function(event) {
		event.preventDefault();
		if(timeron == 1) { clearInterval(sliderinterval) }
		
		if(current > 1 && moving == 0) {
			sliderMoveBackward();
		}
	});
	
	current_features = 1;
	features_size = $('.features_item').size() / 3;
	features_moving = 0;
	
	$('#features_next').click(function(event) {
		event.preventDefault();
		
		if(current_features < features_size && features_moving == 0) {
			features_moving = 1;
			$('#featureswrapper').animate({'left' : '-=518px'}, 400, function() {
				features_moving = 0;
				current_features++;
			});
		}
	});
	
	$('#features_last').click(function(event) {
		event.preventDefault();
		
		if(current_features > 1 && features_moving == 0) {
			features_moving = 1;
			$('#featureswrapper').animate({'left' : '+=518px'}, 400, function() {
				features_moving = 0;
				current_features--;
			});
		}
	});

});