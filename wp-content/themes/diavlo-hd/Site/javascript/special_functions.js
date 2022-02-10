/* ===================================================
 * special functions
 * ========================================================== */

/* ===================================================
:: removes the designview class from the web browser view
 * ========================================================== */
	jQuery(document).ready(function() {
		jQuery("body").removeClass("designview");
	});






		jQuery(document).on("scroll",function(){
			if(jQuery(document).scrollTop()>100){
				jQuery("header").removeClass("large").addClass("small");
				}
			else{
				jQuery("header").removeClass("small").addClass("large");
				}
			});

		jQuery(document).on("scroll",function(){
			if(jQuery(document).scrollTop()>100){
				jQuery(".header2").removeClass("large2").addClass("small2");
				}
			else{
				jQuery(".header2").removeClass("small2").addClass("large2");
				}
			});

/* ===================================================
:: SCROLL-UP ( BACK TO TOP )
 * ========================================================== */
(function(jQuery, window, document) {

    // Main function
    jQuery.fn.scrollUp = function (options) {
        // Ensure that only one scrollUp exists
        if ( ! jQuery.data( document.body, 'scrollUp' ) ) {
            jQuery.data( document.body, 'scrollUp', true );
            jQuery.fn.scrollUp.init(options);
        }
    };

    // Init
    jQuery.fn.scrollUp.init = function(options) {
        // Apply any options to the settings, override the defaults
        var o = jQuery.fn.scrollUp.settings = jQuery.extend({}, jQuery.fn.scrollUp.defaults, options),

        // Set scrollTitle
        scrollTitle = (o.scrollTitle) ? o.scrollTitle : o.scrollText,

        // Create element
        jQueryself = jQuery('<a/>', {
            id: o.scrollName,
            href: '#top',
            title: scrollTitle
        }).appendTo('body');

        // If not using an image display text
        if (!o.scrollImg) {
            jQueryself.html(o.scrollText);
        }

        // Minimum CSS to make the magic happen
        jQueryself.css({
            display: 'none',
            position: 'fixed',
            zIndex: o.zIndex
        });

        // Active point overlay
        if (o.activeOverlay) {
            jQuery('<div/>', { id: o.scrollName + '-active' }).css({ position: 'absolute', 'top': o.scrollDistance + 'px', width: '100%', borderTop: '1px dotted' + o.activeOverlay, zIndex: o.zIndex }).appendTo('body');
        }

        // Scroll function
        scrollEvent = jQuery(window).scroll(function() {
            // If from top or bottom
            if (o.scrollFrom === 'top') {
                scrollDis = o.scrollDistance;
            } else {
                scrollDis = jQuery(document).height() - jQuery(window).height() - o.scrollDistance;
            }

            // Switch animation type
            switch (o.animation) {
                case 'fade':
                    jQuery( (jQuery(window).scrollTop() > scrollDis) ? jQueryself.fadeIn(o.animationInSpeed) : jQueryself.fadeOut(o.animationOutSpeed) );
                    break;
                case 'slide':
                    jQuery( (jQuery(window).scrollTop() > scrollDis) ? jQueryself.slideDown(o.animationInSpeed) : jQueryself.slideUp(o.animationOutSpeed) );
                    break;
                default:
                    jQuery( (jQuery(window).scrollTop() > scrollDis) ? jQueryself.show(0) : jQueryself.hide(0) );
            }
        });

        // To the top
        jQueryself.click(function(e) {
            e.preventDefault();
            jQuery('html, body').animate({
                scrollTop:0
            }, o.topSpeed, o.easingType);
        });
    };

    // Defaults
    jQuery.fn.scrollUp.defaults = {
        scrollName: 'scrollUp', // Element ID
        scrollDistance: 300, // Distance from top/bottom before showing element (px)
        scrollFrom: 'top', // 'top' or 'bottom'
        scrollSpeed: 300, // Speed back to top (ms)
        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
        animation: 'fade', // Fade, slide, none
        animationInSpeed: 200, // Animation in speed (ms)
        animationOutSpeed: 200, // Animation out speed (ms)
        scrollText: 'Scroll to top', // Text for element, can contain HTML
        scrollTitle: false, // Set a custom <a> title if required. Defaults to scrollText
        scrollImg: false, // Set true to use image
        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
        zIndex: 2147483647 // Z-Index for the overlay
    };

    // Destroy scrollUp plugin and clean all modifications to the DOM
    jQuery.fn.scrollUp.destroy = function (scrollEvent){
        jQuery.removeData( document.body, 'scrollUp' );
        jQuery( '#' + jQuery.fn.scrollUp.settings.scrollName ).remove();
        jQuery( '#' + jQuery.fn.scrollUp.settings.scrollName + '-active' ).remove();

        // If 1.7 or above use the new .off()
        if (jQuery.fn.jquery.split('.')[1] >= 7) {
            jQuery(window).off( 'scroll', scrollEvent );

        // Else use the old .unbind()
        } else {
            jQuery(window).unbind( 'scroll', scrollEvent );
        }
    };

    jQuery.scrollUp = jQuery.fn.scrollUp;

})(jQuery, window, document);



/*
Scroll CSS jQuery Plugin
Version 1.0.0
Jul 30th, 2013

Documentation: http://
Repository: https://github.com/drewbrolik/Scroll-CSS

Copyright 2013 Drew Thomas

Dual licensed under the MIT and GPL licenses:
https://github.com/jquery/jquery/blob/master/MIT-LICENSE.txt
http://www.gnu.org/licenses/gpl.txt

This file is part of Scroll CSS.

Scroll CSS is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Scroll CSS is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Scroll CSS.  If not, see <http://www.gnu.org/licenses/>.
*/

/*
Changelog
4/25/13 Initial plugin (1.0.0)
7/30/13 Bug fixes
*/

(function(jQuery) {

	jQuery.fn.scrollCSS = function(additionalOptions) {

		var options = { //- set default options
			cssProperty:"paddingLeft",
			cssStartVal:"0px",
			cssStopVal:"100px",
			scrollStartVal:100,
			scrollStopVal:800
		}
		options = jQuery.extend(options, additionalOptions ); //- override default options with user-supplied options

		jQuery(this).each(function() {

			var jQuerythis = jQuery(this);

			// separate css property value numbers and units
			var cssStartVal = parseInt(options.cssStartVal);
			var cssUnit = options.cssStartVal.replace(cssStartVal,""); // ends up always being pixels anyway...

			var cssStopVal = parseInt(options.cssStopVal);
			if (cssUnit == "") { cssUnit = options.cssStopVal.replace(cssStopVal,""); } // in case start value was 0 (no unit specified)...

			var scrollStartVal;
			var scrollStopVal;

			jQuery(window).on("ready load scroll resize",function() {
				if (!jQuery("html").hasClass("touch")) { // this prevents scrollCSS from running on touchscreens, but it requires Conditionizr (http://conditionizr.com). If you don't have Conditionizr, the plugin will still work.

					// convert scrollStartVal into a number (if it's not already)
					if (options.scrollStartVal != parseInt(options.scrollStartVal)) { // not a number

						if (options.scrollStartVal.indexOf("+") > -1) { // anchor plus math
							var scrollStartValArray = options.scrollStartVal.split("+");
							scrollStartValAnchorOffset = jQuery(scrollStartValArray[0]).offset().top;
							scrollStartVal = parseInt(scrollStartValAnchorOffset)+parseInt(scrollStartValArray[1]);
						} else if (options.scrollStartVal.indexOf("-") > -1) { // anchor minus math
							var scrollStartValArray = options.scrollStartVal.split("-");
							scrollStartValAnchorOffset = jQuery(scrollStartValArray[0]).offset().top;
							scrollStartVal = parseInt(scrollStartValAnchorOffset)-parseInt(scrollStartValArray[1]);
						} else { // just anchor
							scrollStartVal = jQuery(options.scrollStartVal).offset().top;
						}

					} else { // already a number

						scrollStartVal = options.scrollStartVal;

					}

					// convert scrollStopVal into a number (if it's not already)
					if (options.scrollStopVal != parseInt(options.scrollStopVal)) { // not a number

						if (options.scrollStopVal.indexOf("+") > -1) { // anchor plus math
							var scrollStopValArray = options.scrollStopVal.split("+");
							scrollStopValAnchorOffset = jQuery(scrollStopValArray[0]).offset().top;
							scrollStopVal = parseInt(scrollStopValAnchorOffset)+parseInt(scrollStopValArray[1]);
						} else if (options.scrollStopVal.indexOf("-") > -1) { // anchor minus math
							var scrollStopValArray = options.scrollStopVal.split("-");
							scrollStopValAnchorOffset = jQuery(scrollStopValArray[0]).offset().top;
							scrollStopVal = parseInt(scrollStopValAnchorOffset)-parseInt(scrollStopValArray[1]);
						} else { // just anchor
							scrollStopVal = jQuery(options.scrollStopVal).offset().top;
						}

					} else { // already a number

						scrollStopVal = options.scrollStopVal;

					}

					// scroll stuff
					var scrollVal = jQuery(window).scrollTop();
					var thisCss = {};

					if (scrollVal < scrollStartVal) {

						thisCss[options.cssProperty] = options.cssStartVal;
						jQuerythis.css(thisCss);

					} else if (scrollVal >= scrollStartVal && scrollVal <= scrollStopVal) {

						var percentageDecimal = (scrollVal-scrollStartVal)/(scrollStopVal-scrollStartVal);
						var cssVal = (cssStopVal-cssStartVal)*percentageDecimal+cssStartVal;

						thisCss[options.cssProperty] = cssVal+cssUnit;
						jQuerythis.css(thisCss);

					} else if (scrollVal > scrollStopVal) {

						thisCss[options.cssProperty] = options.cssStopVal;
						jQuerythis.css(thisCss);

					}
				} // if !.touch (to prevent touch screens, uses Conditionizr)

			});

		});

		return this;
	};

})(jQuery);



// CONTACT PANEL TOGGLE //
jQuery(document).ready(function() {
	// Expand contact-panel
// Expand contact-panel
	jQuery("#open").click(function(){
		jQuery("div#contact-panel").slideDown("slow");
		if (jQuery("div#contact-panel .googlemap-widget")) {
		  if (typeof(loadWidgetMap) != 'undefined') {
			  loadWidgetMap("div#contact-panel .googlemap-widget");
		  }
		}

	});

	// Collapse contact-panel
	jQuery("#contact-close").click(function(){
		jQuery("div#contact-panel").slideUp("slow");
	});

	// Switch buttons from "Log In | Register" to "Close contact-panel" on click
	jQuery("#toggle a").click(function () {
		jQuery("#toggle a").toggle();
	});
	
	jQuery("div#contact-panel form.form-horizontal").parent("div").addClass("form-2");
	
	jQuery("div#contact-panel form.form-horizontal div.form-group").each(function() {
		var icon = jQuery(this).find("i");
		//alert(icon.attr("class"));
		jQuery(this).parent().find(".regular-label").html("<i class='" + icon.attr("class") + "'></i> " + jQuery(this).parent().find(".regular-label").html());
		jQuery(jQuery(this).find("div").html()).insertAfter(jQuery(this).parent().find(".regular-label"));
		jQuery(this).html("");
																				  
	
	});
});


jQuery(document).ready(
  function() {
   // jQuery("html").niceScroll();
  }
);
// CONTACT PANEL TOGGLE //


// PARALLAX BACKGROUND //
/*
Plugin: jQuery Parallax
Version 1.1.3
Author: Ian Lunn
Twitter: @IanLunn
Author URL: http://www.ianlunn.co.uk/
Plugin URL: http://www.ianlunn.co.uk/plugins/jquery-parallax/

Dual licensed under the MIT and GPL licenses:
http://www.opensource.org/licenses/mit-license.php
http://www.gnu.org/licenses/gpl.html
*/

(function( $ ){
	var $window = $(window);
	var windowHeight = $window.height();

	$window.resize(function () {
		windowHeight = $window.height();
	});

	$.fn.parallax = function(xpos, speedFactor, outerHeight) {
		var $this = $(this);
		var getHeight;
		var firstTop;
		var paddingTop = 0;
		
		//get the starting position of each element to have parallax applied to it		
		$this.each(function(){
		    firstTop = $this.offset().top;
		});

		if (outerHeight) {
			getHeight = function(jqo) {
				return jqo.outerHeight(true);
			};
		} else {
			getHeight = function(jqo) {
				return jqo.height();
			};
		}
			
		// setup defaults if arguments aren't specified
		if (arguments.length < 1 || xpos === null) xpos = "50%";
		if (arguments.length < 2 || speedFactor === null) speedFactor = 0.1;
		if (arguments.length < 3 || outerHeight === null) outerHeight = true;
		
		// function to be called whenever the window is scrolled or resized
		function update(){
			var pos = $window.scrollTop();				

			$this.each(function(){
				var $element = $(this);
				var top = $element.offset().top;
				var height = getHeight($element);

				// Check if totally above or totally below viewport
				if (top + height < pos || top > pos + windowHeight) {
					return;
				}

				$this.css('backgroundPosition', xpos + " " + Math.round((firstTop - pos) * speedFactor) + "px");
			});
		}		

		$window.bind('scroll', update).resize(update);
		update();
	};
})(jQuery);



jQuery(document).ready(function(){
	
	//.parallax(xPosition, speedFactor, outerHeight) options:
	//xPosition - Horizontal position of the element
	//inertia - speed to move relative to vertical scroll. Example: 0.1 is one tenth the speed of scrolling, 2 is twice the speed of scrolling
	//outerHeight (true/false) - Whether or not jQuery should use it's outerHeight option to determine when a section is in the viewport
	
	jQuery('.parallax1').parallax("50%", 0.1);
	jQuery('.parallax2').parallax("50%", 0.3);
	jQuery('.bg').parallax("50%", 0.4);
	jQuery('.parallax3').parallax("50%", 0.3);
	jQuery('.parallax4').parallax("50%", 0.3);
	jQuery('.parallax5').parallax("50%", 0.3);
	jQuery('.bg-img').parallax("50%", 0.5);
	jQuery('.section1').parallax("50%", 0.5);
	jQuery('.footer').parallax("50%", 0.3);
	jQuery('.showcase').parallax("50%", 0.3);
	
})

// END OF PARALLAX BACKGROUND //


  // ADD SLIDEDOWN ANIMATION TO DROPDOWN //
  jQuery('.dropdown').on('show.bs.dropdown', function(e){
    jQuery(this).find('.dropdown-menu').first().stop(true, true).slideDown();
  });

  // ADD SLIDEUP ANIMATION TO DROPDOWN //
  jQuery('.dropdown').on('hide.bs.dropdown', function(e){
    jQuery(this).find('.dropdown-menu').first().stop(true, true).slideUp();
  });
  
  

		/* scrollUp Minimum setup */
		// jQuery(function () {
		// 	jQuery.scrollUp();
		// });

		// scrollUp full options
		jQuery(function () {
			jQuery.scrollUp({
		        scrollName: 'scrollUp', // Element ID
		        scrollDistance: 300, // Distance from top/bottom before showing element (px)
		        scrollFrom: 'top', // 'top' or 'bottom'
		        scrollSpeed: 300, // Speed back to top (ms)
		        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
		        animation: 'fade', // Fade, slide, none
		        animationInSpeed: 200, // Animation in speed (ms)
		        animationOutSpeed: 200, // Animation out speed (ms)
		        scrollText: '', // Text for element, can contain HTML
		        scrollTitle: false, // Set a custom <a> title if required. Defaults to scrollText
		        scrollImg: true, // Set true to use image
		        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
		        zIndex: 2147483647 // Z-Index for the overlay
			});
		});

		// Destroy example
		jQuery(function(){
			jQuery('.destroy').click(function(){
				jQuery.scrollUp.destroy();
			})
		});  

