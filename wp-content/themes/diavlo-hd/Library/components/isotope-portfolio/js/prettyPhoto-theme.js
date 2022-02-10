

/***************************************************
prettyPhoto
***************************************************/

jQuery(document).ready(function () {
    jQuery("a[rel^='prettyPhoto']").prettyPhoto({ 
	animation_speed: 'normal', 
	theme: 'light_square', 
	slideshow: 3000, 
	autoplay_slideshow: false, 
	social_tools: false 
	});

});

jQuery(window).bind('resize', function(e)
{
  if (window.RT) clearTimeout(window.RT);
  window.RT = setTimeout(function()
  {
    this.location.reload(false); /* false to get page from cache */
  }, 100);
});