jQuery(document).ready(function() {
								jQuery(".i3d-widget-backtotop").bind('click', function() { 
									  	jQuery('html, body').animate({scrollTop: 0}, 1000);
												   
																					   });
								
								
																jQuery(".i3d-widget-fontsizer div.i3d-fontsizer-button").bind('click', function() { 
									  	if (jQuery(this).hasClass("i3d-fontsizer-small")) {
											
																   jQuery(this).parents(".container").css("font-size", "1em");
																   } else if (jQuery(this).hasClass("i3d-fontsizer-medium")) {
											
																   jQuery(this).parents(".container").css("font-size", "1.2em");
																	
																} else if (jQuery(this).hasClass("i3d-fontsizer-large")) {
																	   jQuery(this).parents(".container").css("font-size", "1.4em");

}
																		jQuery(this).parent().find(".i3d-fontsizer-selected").removeClass("i3d-fontsizer-selected");

																		jQuery(this).addClass("i3d-fontsizer-selected");

																					   });
																
																
							jQuery("span.author a").tooltip({'placement' : 'right', 'html': true});
							
							//initBoxHeight();
								});


jQuery(window).load(function() {
			initBoxHeight();
			});

jQuery(window).resize(function() {
			initBoxHeight();
			});
function initBoxHeight() {
// equalize vector icon box
var maxVectorInfoBoxHeight = 0;

jQuery(".vector-icon-info-box .box1").css('height', '');
jQuery(".snippet13").css("height", "");
jQuery("div.thumbnail").css("height", "");

jQuery(".vector-icon-info-box").each(function() {
											  if (jQuery(this).find(".box1").height() > maxVectorInfoBoxHeight) {
												  maxVectorInfoBoxHeight = jQuery(this).find(".box1").height();
											  }
											  });
jQuery(".vector-icon-info-box .box1").height(maxVectorInfoBoxHeight + "px");


// equalize wrapper box
var maxWrapperInfoBoxHeight = 0;
jQuery(".snippet13").each(function() {
											  if (jQuery(this).height() > maxWrapperInfoBoxHeight) {
												  maxWrapperInfoBoxHeight = jQuery(this).height();
											  }
											  });
jQuery(".snippet13").height(maxWrapperInfoBoxHeight + "px");


// equalize thumbnail box
var maxThumbnailInfoBoxHeight = 0;
jQuery("div.thumbnail").each(function() {
											  if (jQuery(this).height() > maxThumbnailInfoBoxHeight) {
												  maxThumbnailInfoBoxHeight = jQuery(this).height();
											  }
											  });
jQuery("div.thumbnail").height(maxThumbnailInfoBoxHeight + "px");



}

function validateSkill(theForm) {
	if (jQuery(theForm).find("input[name=skilltest]")) {
		skillValue = jQuery(theForm).find("input[name=skilltest]").val();
		skillAnswer = jQuery(theForm).find("input[name=skillanswer]").val() / 5;
		if (skillValue != skillAnswer) {
			alert("Incorrect answer to skill testing question.");
		    return false;
		}
	}
	return true;
}

jQuery(".fb-feature-box").hover( function() {
										 // jQuery(this).find(".fb-content").css("height", "auto");
										 
										  var maxHeight = jQuery(this).find(".fb-content .fb-content-inner").innerHeight();
										  //alert(maxHeight);
										  //jQuery(this).find(".fb-content").css("height", 0);

												 jQuery(this).find(".fb-content").css("height", maxHeight);
												 
												 },
								 function() {
												 jQuery(this).find(".fb-content").css("height", 0);
												 }				 
												 
												 );
function checkDateInput() {
    var input = document.createElement('input');
    input.setAttribute('type','date');

    var notADateValue = 'not-a-date';
    input.setAttribute('value', notADateValue); 

    return !(input.value === notADateValue);
}