/*!
 * strength.js
 * Original author: @aaronlumsden
 * Further changes, comments: @aaronlumsden
 * Licensed under the MIT license
 */
;(function ( $, window, document, undefined ) {

    var pluginName = "tabulous",
        defaults = {
            effect: 'scale'
        };

       // $('<style>body { background-color: red; color: white; }</style>').appendTo('head');

    function Plugin( element, options ) {
        this.element = element;
        this.$elem = jQuery(this.element);
        this.options = jQuery.extend( {}, defaults, options );
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    Plugin.prototype = {

        init: function() {

            var links = this.$elem.find('ul.settings-tabs a');
            var firstchild = this.$elem.find('ul.settings-tabs li:first-child').find('a');
			
            var lastchild = this.$elem.find('li:last-child').after('<span class="tabulousclear"></span>');
            var firstdiv = this.$elem.find('div#tabs_container');
            var firstdivheight = firstdiv.find('div:first').height();
		//	alert(firstdiv.find('div:first').html());
			//alert(firstdiv.find('div:first').height());
		//	alert(firstdiv.find("div:first").attr("id"));

            if (this.options.effect == 'scale') {
             tab_content = this.$elem.find('div').find("div.tabulous-pane").not(':first').not(':nth-child(1)').addClass('hidescale');
					setTimeout(finalHide, 500);
            } else if (this.options.effect == 'slideLeft') {
                 tab_content = this.$elem.find('div').not(':first').not(':nth-child(1)').addClass('hideleft');
            } else if (this.options.effect == 'scaleUp') {
                 tab_content = this.$elem.find('div').not(':first').not(':nth-child(1)').addClass('hidescaleup');
            } else if (this.options.effect == 'flip') {
                 tab_content = this.$elem.find('div').not(':first').not(':nth-child(1)').addClass('hideflip');
            }

		//	alert(firstdivheight);

            var alldivs = this.$elem.find('div').find("div.tabulous-pane");

         
			if (firstdivheight > 0) {
				//alert("yup");
              firstdiv.css('height',firstdivheight+'px');
			} else {
			  firstdiv.css("height", "400px");
			}
			
			//alldivs.css({'position': 'absolute','top':'10px'});
            firstchild.addClass('tabulous_active');

            links.bind('click', {myOptions: this.options}, function(e) {
                e.preventDefault();

                var $options = e.data.myOptions;
                var effect = $options.effect;

                var mythis = $(this);
                var thisform = mythis.parent().parent().parent();
                var thislink = mythis.attr('href');


                firstdiv.addClass('transition');

                links.removeClass('tabulous_active');
                mythis.addClass('tabulous_active');
                thisdivwidth = thisform.find('div'+thislink).height();
			//	alert(alldivs.length);
                if (effect == 'scale') {
					alldivs.css("display", "block");
                    alldivs.removeClass('showscale').addClass('make_transist').addClass('hidescale');
					setTimeout(finalHide, 500);
                    thisform.find('div'+thislink).addClass('make_transist').addClass('showscale');
                } else if (effect == 'slideLeft') {
                    alldivs.removeClass('showleft').addClass('make_transist').addClass('hideleft');
                    thisform.find('div'+thislink).addClass('make_transist').addClass('showleft');
                } else if (effect == 'scaleUp') {
                    alldivs.removeClass('showscaleup').addClass('make_transist').addClass('hidescaleup');
                    thisform.find('div'+thislink).addClass('make_transist').addClass('showscaleup');
                } else if (effect == 'flip') {
                    alldivs.removeClass('showflip').addClass('make_transist').addClass('hideflip');
                    thisform.find('div'+thislink).addClass('make_transist').addClass('showflip');
                }


                firstdiv.css('height',thisdivwidth+'px');

                


            });

           


         
            
        },

        yourOtherFunction: function(el, options) {
            // some logic
        }
    };

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            new Plugin( this, options );
        });
    };
function finalHide() {
             jQuery("div.hidescale:not(.showscale)").css("display", "none");
	
}
})( jQuery, window, document );


