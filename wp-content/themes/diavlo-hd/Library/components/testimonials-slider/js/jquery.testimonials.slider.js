(function( jQuery, undefined ) {

	/*
	 * Slider object.
	 */
	jQuery.Slider2 				= function( options, element ) {

		this.jQueryel	= jQuery( element );

		this._init( options );

	};

	jQuery.Slider2.defaults 		= {
		current		: 0, 	// index of current slide
		bgincrement	: 50,	// increment the bg position (parallax effect) when sliding
		autoplay	: false,// slideshow on / off
		interval	: 8000  // time between transitions
    };

	jQuery.Slider2.prototype 	= {
		_init 				: function( options ) {

			this.options 		= jQuery.extend( true, {}, jQuery.Slider2.defaults, options );

			this.jQueryslides		= this.jQueryel.children('div.testimonials-slide');
			this.slidesCount	= this.jQueryslides.length;

			this.current		= this.options.current;

			if( this.current < 0 || this.current >= this.slidesCount ) {

				this.current	= 0;

			}

			this.jQueryslides.eq( this.current ).addClass( 'testimonials-slide-current' );

			var jQuerynavigation		= jQuery( '<nav class="da-dots"/>' );
			for( var i = 0; i < this.slidesCount; ++i ) {

				jQuerynavigation.append( '<span/>' );

			}
			jQuerynavigation.appendTo( this.jQueryel );

			this.jQuerypages			= this.jQueryel.find('nav.da-dots > span');
			this.jQuerynavNext		= this.jQueryel.find('span.testimonials-arrows-next');
			this.jQuerynavPrev		= this.jQueryel.find('span.testimonials-arrows-prev');

			this.isAnimating	= false;

			this.bgpositer		= 0;

			this.cssAnimations	= Modernizr.cssanimations;
			this.cssTransitions	= Modernizr.csstransitions;

			if( !this.cssAnimations || !this.cssAnimations ) {

				this.jQueryel.addClass( 'testimonials-slider-fb' );

			}

			this._updatePage();

			// load the events
			this._loadEvents();

			// slideshow
			if( this.options.autoplay ) {

				this._startSlideshow();

			}

		},
		_navigate			: function( page, dir ) {

			var jQuerycurrent	= this.jQueryslides.eq( this.current ), jQuerynext, _self = this;

			if( this.current === page || this.isAnimating ) return false;

			this.isAnimating	= true;

			// check dir
			var classTo, classFrom, d;

			if( !dir ) {

				( page > this.current ) ? d = 'next' : d = 'prev';

			}
			else {

				d = dir;

			}

			if( this.cssAnimations && this.cssAnimations ) {

				if( d === 'next' ) {

					classTo		= 'testimonials-slide-toleft';
					classFrom	= 'testimonials-slide-fromright';
					++this.bgpositer;

				}
				else {

					classTo		= 'testimonials-slide-toright';
					classFrom	= 'testimonials-slide-fromleft';
					--this.bgpositer;

				}

				this.jQueryel.css( 'background-position' , this.bgpositer * this.options.bgincrement + '% 0%' );

			}

			this.current	= page;

			jQuerynext			= this.jQueryslides.eq( this.current );

			if( this.cssAnimations && this.cssAnimations ) {

				var rmClasses	= 'testimonials-slide-toleft testimonials-slide-toright testimonials-slide-fromleft testimonials-slide-fromright';
				jQuerycurrent.removeClass( rmClasses );
				jQuerynext.removeClass( rmClasses );

				jQuerycurrent.addClass( classTo );
				jQuerynext.addClass( classFrom );

				jQuerycurrent.removeClass( 'testimonials-slide-current' );
				jQuerynext.addClass( 'testimonials-slide-current' );

			}

			// fallback
			if( !this.cssAnimations || !this.cssAnimations ) {

				jQuerynext.css( 'left', ( d === 'next' ) ? '100%' : '-100%' ).stop().animate( {
					left : '0%'
				}, 1000, function() {
					_self.isAnimating = false;
				});

				jQuerycurrent.stop().animate( {
					left : ( d === 'next' ) ? '-100%' : '100%'
				}, 1000, function() {
					jQuerycurrent.removeClass( 'testimonials-slide-current' );
				});

			}

			this._updatePage();

		},
		_updatePage			: function() {

			this.jQuerypages.removeClass( 'da-dots-current' );
			this.jQuerypages.eq( this.current ).addClass( 'da-dots-current' );

		},
		_startSlideshow		: function() {

			var _self	= this;

			this.slideshow	= setTimeout( function() {

				var page = ( _self.current < _self.slidesCount - 1 ) ? page = _self.current + 1 : page = 0;
				_self._navigate( page, 'next' );

				if( _self.options.autoplay ) {

					_self._startSlideshow();

				}

			}, this.options.interval );

		},
		page				: function( idx ) {

			if( idx >= this.slidesCount || idx < 0 ) {

				return false;

			}

			if( this.options.autoplay ) {

				clearTimeout( this.slideshow );
				this.options.autoplay	= false;

			}

			this._navigate( idx );

		},
		_loadEvents			: function() {

			var _self = this;

			this.jQuerypages.on( 'click.testimonialsslider', function( event ) {

				_self.page( jQuery(this).index() );
				return false;

			});

			this.jQuerynavNext.on( 'click.testimonialsslider', function( event ) {

				if( _self.options.autoplay ) {

					clearTimeout( _self.slideshow );
					_self.options.autoplay	= false;

				}

				var page = ( _self.current < _self.slidesCount - 1 ) ? page = _self.current + 1 : page = 0;
				_self._navigate( page, 'next' );
				return false;

			});

			this.jQuerynavPrev.on( 'click.testimonialsslider', function( event ) {

				if( _self.options.autoplay ) {

					clearTimeout( _self.slideshow );
					_self.options.autoplay	= false;

				}

				var page = ( _self.current > 0 ) ? page = _self.current - 1 : page = _self.slidesCount - 1;
				_self._navigate( page, 'prev' );
				return false;

			});

			if( this.cssTransitions ) {

				if( !this.options.bgincrement ) {

					this.jQueryel.on( 'webkitAnimationEnd.testimonialsslider animationend.testimonialsslider OAnimationEnd.testimonialsslider', function( event ) {

						if( event.originalEvent.animationName === 'toRightAnim4' || event.originalEvent.animationName === 'toLeftAnim4' ) {

							_self.isAnimating	= false;

						}

					});

				}
				else {

					this.jQueryel.on( 'webkitTransitionEnd.testimonialsslider transitionend.testimonialsslider OTransitionEnd.testimonialsslider', function( event ) {

						if( event.target.id === _self.jQueryel.attr( 'id' ) )
							_self.isAnimating	= false;

					});

				}

			}

		}
	};

	var logError 			= function( message ) {
		if ( this.console ) {
			console.error( message );
		}
	};

	jQuery.fn.testimonialsslider			= function( options ) {

		if ( typeof options === 'string' ) {

			var args = Array.prototype.slice.call( arguments, 1 );

			this.each(function() {

				var instance = jQuery.data( this, 'testimonialsslider' );

				if ( !instance ) {
					logError( "cannot call methods on testimonialsslider prior to initialization; " +
					"attempted to call method '" + options + "'" );
					return;
				}

				if ( !jQuery.isFunction( instance[options] ) || options.charAt(0) === "_" ) {
					logError( "no such method '" + options + "' for testimonialsslider instance" );
					return;
				}

				instance[ options ].apply( instance, args );

			});

		}
		else {

			this.each(function() {

				var instance = jQuery.data( this, 'testimonialsslider' );
				if ( !instance ) {
					jQuery.data( this, 'testimonialsslider', new jQuery.Slider2( options, this ) );
				}
			});

		}

		return this;

	};

})( jQuery );