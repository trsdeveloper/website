/*
 * jQuery Quovolver v1.0 - http://sandbox.sebnitu.com/jquery/quovolver
 *
 * By Sebastian Nitu - Copyright 2009 - All rights reserved
 * 
 */

(function(jQuery) {
	jQuery.fn.quovolver = function(speed, delay) {
		
		/* Sets default values */
		if (!speed) speed = 500;
		if (!delay) delay = 10000;
		
		// If "delay" is less than 4 times the "speed", it will break the effect 
		// If that's the case, make "delay" exactly 4 times "speed"
		var quaSpd = (speed*4);
		if (quaSpd > (delay)) delay = quaSpd;
		
		// Create the variables needed
		var	quote = jQuery(this),
			firstQuo = jQuery(this).filter(':first'),
			lastQuo = jQuery(this).filter(':last'),
			wrapElem = '<div id="quote_wrap"></div>';
		
		// Wrap the quotes
		jQuery(this).wrapAll(wrapElem);
		
		// Hide all the quotes, then show the first
		jQuery(this).hide();
		jQuery(firstQuo).show();
		
		// Set the hight of the wrapper
		jQuery(this).parent().css({height: jQuery(firstQuo).height()});		
		
		// Where the magic happens
		setInterval(function(){
			
			// Set required hight and element in variables for animation
			if(jQuery(lastQuo).is(':visible')) {
				var nextElem = jQuery(firstQuo);
				var wrapHeight = jQuery(nextElem).height();
			} else {
				var nextElem = jQuery(quote).filter(':visible').next();
				var wrapHeight = jQuery(nextElem).height();
			}
			
			// Fadeout the quote that is currently visible
			jQuery(quote).filter(':visible').fadeOut(speed);
			
			// Set the wrapper to the hight of the next element, then fade that element in
			setTimeout(function() {
				jQuery(quote).parent().animate({height: wrapHeight}, speed);
			}, speed);
			
			if(jQuery(lastQuo).is(':visible')) {
				setTimeout(function() {
					jQuery(firstQuo).fadeIn(speed*2);
				}, speed*2);
				
			} else {
				setTimeout(function() {
					jQuery(nextElem).fadeIn(speed);
				}, speed*2);
			}
			
		}, delay);
	
	};
})(jQuery);