/*
* Curtain.js - Create an unique page transitioning system
* ---
* Version: 2
* Copyright 2011, Victor Coulon (http://victorcoulon.fr)
* Released under the MIT Licence
*/

touched = false;

jQuery(function(){	
	//Section Height
	sectionHeight();

	if (jQuery(window).width() > 766) {
		jQuery('.landing-menu li a, a.down_btn').on('click', function(e){
			e.preventDefault();

			var slide = jQuery(jQuery(this).attr('href'));
			if (slide.length) {
				var scrollNav = 0;
				var wrap = slide.data('kg-curtain-parent');
				if (wrap) {
					scrollNav = wrap.offset().top;
				} else {
					scrollNav = slide.offset().top;
				}
				jQuery('html,body').animate({'scrollTop': scrollNav});
			}
		});
	} else {
		jQuery('.mobile_menu li a').on('click', function(e){
			e.preventDefault();

			var slide = jQuery(jQuery(this).attr('href'));
			if (slide.length) {
				var scrollNav = 0;
				var wrap = slide.data('kg-curtain-parent');
				if (wrap) {
					scrollNav = wrap.offset().top;
				} else {
					scrollNav = slide.offset().top;
				}
				jQuery('html,body').animate({'scrollTop': scrollNav});
			}
		});
	}

	jQuery(window).on('scroll', menuAct);
	menuAct();
});

jQuery(window).load(function(){
	//Curtain Function
	curtainFunction();
	
});


jQuery(window).resize(function(){
	//Section Height
	sectionHeight();
	
	//Curtain Function
	curtainFunction();
	
	
});

function menuAct()
{
	jQuery('#wrapper section').each(function(e){
		var slide = jQuery(this);

		var scrollNav = 0;
		var wrap = slide.data('kg-curtain-parent');
		if (wrap) {
			scrollNav = wrap.offset().top;
		} else {
			scrollNav = slide.offset().top;
		}

		if (jQuery(window).scrollTop() >= scrollNav) {
			jQuery('.landing-menu li a').removeClass('active');
			jQuery('.wrapper-'+slide.attr('id')).addClass('active');
		}
	});
}

//Curtain Function
function curtainFunction()
{
	if (jQuery(window).width() > 1024) {
		jQuery('#wrapper section').curtainCustom();
	} else {
		jQuery('#wrapper section').curtainCustom('destroy');
	}
	
}

//Section Height
function sectionHeight()
{
	if (jQuery(window).width() > 1024) {
		jQuery('section').css({'min-height': jQuery(window).height() + 'px'});
	} else {
		jQuery('section').css({'min-height': jQuery(window).height() + 'px'});
	}
	
}



/* Curtain Script */
(function ($) {
	var init = false;
	var totalSlides = 0;

	var slides = [];
	var slidePos = [];

	var $this = undefined;

	var options = {};

    var methods = {
        init: function (args) {
			$this = this;

			if (touched == false && init == false) {
				options = jQuery.extend({
					deadZone: 0
				}, args);

				init = true;
				totalSlides = this.length;

				this.each(function(i){
					var slide = jQuery(this);

					slide.wrap('<div class="curtain_block"></div>');
					var wrap = slide.parent();
					slide.data('kg-curtain-parent', wrap);
					wrap.data('kg-curtain-child', slide);

					if (totalSlides == (i+1)) {
						wrap.height(slide.height());
					} else {
						wrap.height(slide.height() + options.deadZone);
					}
					
					

					slides.push(slide);
					slidePos.push(wrap.offset().top);

					slide.css({
						'z-index': totalSlides - i
					});
				});

				this.css({
					'position': 'fixed',
					'left': '0',
					'top': '0',
					'right': '0'
				});

				$this.curtainCustom('setScroll');
			}

			jQuery(window).on('kg-resize.kg-curtain', function(){
				$this.curtainCustom('reinit');
			});

			jQuery(window).on('scroll.kg-curtain', function(){
				$this.curtainCustom('setScroll');
			});

			jQuery(window).on('touchstart', function(e){
				if ( ! touched) {
					touched = true;
					$this.curtainCustom('destroy');
				}
			});
			

			return this;
        },
		reinit: function(){
			if (init) {
				$this.curtainCustom('destroy');
				$this.curtainCustom();
			}
		},
		setScroll: function(){
			if (init) {
				for (var i in slides) {
					var slide = slides[i];
					var wrap = slide.data('kg-curtain-parent');
					if (jQuery(window).scrollTop() >= slidePos[i]) {
						slide.css({
							'position': '',
							'left': '',
							'top': '',
							'right': ''
						});
					} else {
						slide.css({
							'position': 'fixed',
							'left': '0',
							'top': '0',
							'right': '0',
							'background-position': '0 0'
						});
					}
				}
			}
		},
        destroy: function (options) {
			if (init) {
				init = false;

				for (i in slides) {
					var slide = slides[i];

					slide.css({
						'position': '',
						'left': '',
						'top': '',
						'right': '',
						'z-index': ''
					});

					var wrap = slide.data('kg-curtain-parent');
					slide.data('kg-curtain-parent', null);
					wrap.data('kg-curtain-child', null);
					wrap.replaceWith(slide);
				}

				slides = [];
				totalslides = 0;
				slidePos = [];

				jQuery(window).off('.kg-curtain');
			}
        }
    }

    jQuery.fn.curtainCustom = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            jQuery.error('Method ' + method + ' does not exist on jQuery.curtainCustom');
        }
    };
   // alert(jQuery.fn.curtainCustom);
    
})(jQuery);
