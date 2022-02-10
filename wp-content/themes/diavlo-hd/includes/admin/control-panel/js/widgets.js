jQuery(document).ready(function() {
	jQuery("#widget-list .widget .widget-top").each(function() {
															 setBarBackground(this);

															 
															 });
	jQuery("#widgets-right .widget .widget-top").each(function() {
															 setBarBackground(this);

															 
															 });
	
	
	jQuery("[rel='tooltip']").tooltip();
	//var c = document.getElements('#widget-list .widget .widget-top, #wp_inactive_widgets .widget .widget-top, ');

});

function setBarBackground(element) {
	if (jQuery(element).parent().attr("id").indexOf("i3d_menu") >= 0 ||

		jQuery(element).parent().attr("id").indexOf("i3d_htmlbox") >= 0 ||
		jQuery(element).parent().attr("id").indexOf("i3d_logo") >= 0 ||
		jQuery(element).parent().attr("id").indexOf("i3d_phonenumber") >= 0 ||
		jQuery(element).parent().attr("id").indexOf("i3d_seo") >= 0 ||
		jQuery(element).parent().attr("id").indexOf("i3d_infobox") >= 0 ||
		jQuery(element).parent().attr("id").indexOf("i3d_image") >= 0 ||
		jQuery(element).parent().attr("id").indexOf("i3d_twitterfeed") >= 0 ||
		jQuery(element).parent().attr("id").indexOf("i3d_contentregion") >= 0 ||
		jQuery(element).parent().attr("id").indexOf("i3d_footer_contact_box") >= 0 ||
		jQuery(element).parent().attr("id").indexOf("i3d_search_form") >= 0 ||
		jQuery(element).parent().attr("id").indexOf("i3d_testimonial_rotator") >= 0 ||
		jQuery(element).parent().attr("id").indexOf("i3d_slider_region") >= 0 ||
		jQuery(element).parent().attr("id").indexOf("i3d_backtotop") >= 0 ||
		jQuery(element).parent().attr("id").indexOf("i3d_fontsizer") >= 0 ||
		jQuery(element).parent().attr("id").indexOf("i3d_recent_posts") >= 0 ||
		jQuery(element).parent().attr("id").indexOf("i3d_contact_form") >= 0 ||
		jQuery(element).parent().attr("id").indexOf("i3d_breadcrumb") >= 0 ||
		jQuery(element).parent().attr("id").indexOf("i3d_cta") >= 0 ||
		jQuery(element).parent().attr("id").indexOf("i3d_cpg") >= 0 ||
		jQuery(element).parent().attr("id").indexOf("i3d_fb") >= 0 ||
		jQuery(element).parent().attr("id").indexOf("i3d_googlemap") >= 0 ||
		jQuery(element).parent().attr("id").indexOf("i3d_flickr") >= 0 ||
		jQuery(element).parent().attr("id").indexOf("i3d_portfolio") >= 0 ||
		jQuery(element).parent().attr("id").indexOf("i3d_animatedlogo") >= 0 ||
		jQuery(element).parent().attr("id").indexOf("i3d_progress_bar") >= 0 ||
		jQuery(element).parent().attr("id").indexOf("i3d_counterbox") >= 0 ||
		jQuery(element).parent().attr("id").indexOf("i3d_social_icon_shortcuts") >= 0 
											  ) {
		jQuery(element).parent().addClass("i3d_aquila");
		jQuery(element).find("h4").text(jQuery(element).find("h4").text().replace(/i3d:/gi, ""));
	}

	if (jQuery(element).parent().attr("id").indexOf("i3d_rowbreak") >= 0 ||
		jQuery(element).parent().attr("id").indexOf("i3d_columnbreak") >= 0
											  ) {
		jQuery(element).parent().addClass("i3d_aquila_sp");
		jQuery(element).find("h4").text(jQuery(element).find("h4").text().replace(/i3d:\*/gi, ""));
	}
	if (jQuery(element).parent().attr("id").indexOf("i3d_breadcrumb") >= 0) {
		//jQuery(element).find("h4").prepend("<i class='icon-pushpin pull-right'></i> ");
		jQuery(element).find("h4").prepend("<i rel='tooltip' class='fa fa-asterisk pull-right'></i> ");
	}

if (jQuery(element).parent().attr("id").indexOf("i3d_cta") >= 0) {
		//jQuery(element).find("h4").prepend("<i class='icon-bullhorn pull-right'></i> ");
	}
	if (jQuery(element).parent().attr("id").indexOf("i3d_flickr") >= 0) {
		//jQuery(element).find("h4").prepend("<i class='fa fa-flickr pull-right'></i> ");
	}
	if (jQuery(element).parent().attr("id").indexOf("i3d_googlemap") >= 0) {
		//jQuery(element).find("h4").prepend("<i class='fa fa-map-marker pull-right'></i> ");

	}
if (jQuery(element).parent().attr("id").indexOf("i3d_contact_form") >= 0) {
		//jQuery(element).find("h4").prepend("<i class='icon-envelope-alt pull-right'></i> ");
			jQuery(element).find("h4").prepend("<i rel='tooltip' class='fa fa-asterisk pull-right'></i> ");
	}
	if (jQuery(element).parent().attr("id").indexOf("i3d_footer_contact_box") >= 0) {
		
		//jQuery(element).find("h4").prepend("<i class='icon-envelope-alt pull-right'></i> ");
	
	}	

	if (jQuery(element).parent().attr("id").indexOf("i3d_columnbreak") >= 0) {
	//	jQuery(element).find("h4").prepend("<i class='icon-columns pull-right'></i> ");

	}
	if (jQuery(element).parent().attr("id").indexOf("i3d_backtotop") >= 0) {
		//jQuery(element).find("h4").prepend("<i class='icon-chevron-sign-up pull-right'></i> ");
	
	}
	if (jQuery(element).parent().attr("id").indexOf("i3d_contentregion") >= 0) {
		//jQuery(element).find("h4").prepend("<i class='icon-pencil pull-right'></i> ");
			jQuery(element).find("h4").prepend("<i rel='tooltip' class='fa fa-asterisk pull-right'></i> ");

	}
	if (jQuery(element).parent().attr("id").indexOf("i3d_social_icon_shortcuts") >= 0) {
		//jQuery(element).find("h4").prepend("<i class='icon-thumbs-up-alt pull-right'></i> ");
	
	}
	if (jQuery(element).parent().attr("id").indexOf("i3d_htmlbox") >= 0) {
		jQuery(element).find("h4").prepend("<i class='icon-code pull-right'></i> ");

	}
	
	if (jQuery(element).parent().attr("id").indexOf("i3d_fontsizer") >= 0) {
		//jQuery(element).find("h4").prepend("<i class='icon-text-height pull-right'></i> ");
	
	}
	if (jQuery(element).parent().attr("id").indexOf("i3d_image") >= 0) {
		//jQuery(element).find("h4").prepend("<i class='icon-picture pull-right'></i> ");

	
	}
	if (jQuery(element).parent().attr("id").indexOf("i3d_infobox") >= 0) {
		//jQuery(element).find("h4").prepend("<i class='icon-star-empty pull-right'></i> ");
	
	
	}
	
	if (jQuery(element).parent().attr("id").indexOf("i3d_fb") >= 0) {
	//	jQuery(element).find("h4").prepend("<i class='icon-star-empty pull-right'></i> ");
				jQuery(element).find("h4").prepend("<i rel='tooltip' class='fa fa-asterisk pull-right' title='This widget also available in the Layout Editor'></i> ");

	}
	
	if (jQuery(element).parent().attr("id").indexOf("i3d_logo") >= 0) {
	//	jQuery(element).find("h4").prepend("<i class='icon-coffee pull-right'></i> ");
				jQuery(element).find("h4").prepend("<i rel='tooltip' class='fa fa-asterisk pull-right' title='This widget also available in the Layout Editor'></i> ");

}
	if (jQuery(element).parent().attr("id").indexOf("i3d_portfolio") >= 0) {
	//	jQuery(element).find("h4").prepend("<i class='icon-picture pull-right'></i> ");
				jQuery(element).find("h4").prepend("<i rel='tooltip' class='fa fa-asterisk pull-right' title='This widget also available in the Layout Editor'></i> ");
	}

	if (jQuery(element).parent().attr("id").indexOf("i3d_animatedlogo") >= 0) {
		//jQuery(element).find("h4").prepend("<i class='icon-coffee icon-spin pull-right'></i> ");
	}

	if (jQuery(element).parent().attr("id").indexOf("i3d_menu") >= 0) {
		//jQuery(element).find("h4").prepend("<i class='icon-sitemap pull-right'></i> ");
				jQuery(element).find("h4").prepend("<i rel='tooltip'  class='fa fa-asterisk pull-right' title='This widget also available in the Layout Editor'></i> ");
	}

	if (jQuery(element).parent().attr("id").indexOf("i3d_cpg") >= 0) {
		//jQuery(element).find("h4").prepend("<i class='fa fa-bars pull-right'></i> ");
				jQuery(element).find("h4").prepend("<i rel='tooltip' class='fa fa-asterisk pull-right' title='This widget also available in the Layout Editor'></i> ");
	}

	if (jQuery(element).parent().attr("id").indexOf("i3d_phonenumber") >= 0) {
//		jQuery(element).find("h4").prepend("<i class='icon-phone pull-right'></i> ");
	}
	
	if (jQuery(element).parent().attr("id").indexOf("i3d_search_form") >= 0) {
		//jQuery(element).find("h4").prepend("<i class='icon-search pull-right'></i> ");
					jQuery(element).find("h4").prepend("<i rel='tooltip' class='fa fa-asterisk pull-right' title='This widget also available in the Layout Editor'></i> ");

	}
	if (jQuery(element).parent().attr("id").indexOf("i3d_seo") >= 0) {
		//jQuery(element).find("h4").prepend("<i class='icon-ok-sign pull-right'></i> ");
	
					jQuery(element).find("h4").prepend("<i rel='tooltip' class='fa fa-asterisk pull-right' title='This widget also available in the Layout Editor'></i> ");

	}
	if (jQuery(element).parent().attr("id").indexOf("i3d_slider_region") >= 0) {
		//jQuery(element).find("h4").prepend("<i class='icon-ellipsis-horizontal pull-right'></i> ");
					jQuery(element).find("h4").prepend("<i rel='tooltip' class='fa fa-asterisk pull-right' title='This widget also available in the Layout Editor'></i> ");

	}

	if (jQuery(element).parent().attr("id").indexOf("i3d_recent_posts") >= 0) {
	//	jQuery(element).find("h4").prepend("<i class='icon-rss pull-right'></i> ");
	
	}
	if (jQuery(element).parent().attr("id").indexOf("i3d_testimonial_rotator") >= 0) {
		//jQuery(element).find("h4").prepend("<i class='icon-quote-right pull-right'></i> ");
	
	}
	if (jQuery(element).parent().attr("id").indexOf("i3d_twitterfeed") >= 0) {
		//jQuery(element).find("h4").prepend("<i class='icon-twitter pull-right'></i> ");
	}
}



function shrinkVideoRegion(region) {
		jQuery("#adminmenu .wp-has-current-submenu .wp-submenu").addClass("i3d-lower-submenu");
		jQuery(region).parents(".widget").removeClass("i3d-expanded");
		jQuery(region).parents(".widget").removeClass("i3d-expanded-basic");
		jQuery(region).parents(".widget").removeClass("i3d-expanded-large");
		
		jQuery(region).parents(".widget").find(".i3d-help-region").removeClass("i3d-help-widget-region-opened");

		jQuery(region).parents(".widget").find('.i3d-help-region-closed').removeClass("i3d-help-region-hidden");
		jQuery(region).parents(".widget").find('.i3d-help-region-opened').addClass("i3d-help-region-hidden");

}
function toggleHelpRegion(helpRegion) {
	
	if (jQuery(helpRegion).find('.i3d-help-region-closed').hasClass("i3d-help-region-hidden")) {
		jQuery(helpRegion).find('.i3d-help-region-closed').removeClass("i3d-help-region-hidden");
		jQuery(helpRegion).find('.i3d-help-region-opened').addClass("i3d-help-region-hidden");
		jQuery(helpRegion).removeClass("i3d-help-widget-region-opened");
		jQuery(helpRegion).parents(".widget").removeClass("i3d-expanded");
		jQuery("#adminmenu .wp-has-current-submenu .wp-submenu").removeClass("i3d-lower-submenu");
	} else {
		jQuery(helpRegion).addClass("i3d-help-widget-region-opened");
		jQuery(helpRegion).parents(".widget").addClass("i3d-expanded");
		jQuery(helpRegion).find('.i3d-help-region-closed').addClass("i3d-help-region-hidden");
		jQuery(helpRegion).find('.i3d-help-region-opened').removeClass("i3d-help-region-hidden");
		jQuery("#adminmenu .wp-has-current-submenu .wp-submenu").addClass("i3d-lower-submenu");
		
	}
}

function toggleHelpRegionBasic(helpRegion) {
	
	if (jQuery(helpRegion).find('.i3d-help-region-closed').hasClass("i3d-help-region-hidden")) {
		jQuery(helpRegion).find('.i3d-help-region-closed').removeClass("i3d-help-region-hidden");
		jQuery(helpRegion).find('.i3d-help-region-opened').addClass("i3d-help-region-hidden");
		jQuery(helpRegion).removeClass("i3d-help-widget-region-opened");
		jQuery(helpRegion).parents(".widget").removeClass("i3d-expanded-basic");
		jQuery("#adminmenu .wp-has-current-submenu .wp-submenu").removeClass("i3d-lower-submenu");
	} else {
		jQuery(helpRegion).addClass("i3d-help-widget-region-opened");
		jQuery(helpRegion).parents(".widget").addClass("i3d-expanded-basic");
		jQuery(helpRegion).find('.i3d-help-region-closed').addClass("i3d-help-region-hidden");
		jQuery(helpRegion).find('.i3d-help-region-opened').removeClass("i3d-help-region-hidden");
		jQuery("#adminmenu .wp-has-current-submenu .wp-submenu").addClass("i3d-lower-submenu");
		
	}
}

function toggleHelpRegionLarge(helpRegion) {
	
	if (jQuery(helpRegion).find('.i3d-help-region-closed').hasClass("i3d-help-region-hidden")) {
		jQuery(helpRegion).find('.i3d-help-region-closed').removeClass("i3d-help-region-hidden");
		jQuery(helpRegion).find('.i3d-help-region-opened').addClass("i3d-help-region-hidden");
		jQuery(helpRegion).removeClass("i3d-help-widget-region-opened");
		jQuery(helpRegion).parents(".widget").removeClass("i3d-expanded-large");
		jQuery("#adminmenu .wp-has-current-submenu .wp-submenu").removeClass("i3d-lower-submenu");
	} else {
		jQuery(helpRegion).addClass("i3d-help-widget-region-opened");
		jQuery(helpRegion).parents(".widget").addClass("i3d-expanded-large");
		jQuery(helpRegion).find('.i3d-help-region-closed').addClass("i3d-help-region-hidden");
		jQuery(helpRegion).find('.i3d-help-region-opened').removeClass("i3d-help-region-hidden");
		jQuery("#adminmenu .wp-has-current-submenu .wp-submenu").addClass("i3d-lower-submenu");
		
	}
}


/* 
	function of_image_upload() {
	jQuery('.image_upload_button').each(function(){
			
	var clickedObject = $(this);
	var clickedID = $(this).attr('id');	
			
	var nonce = $('#security').val();
			
	new AjaxUpload(clickedID, {
		action: ajaxurl,
		name: clickedID, // File upload name
		data: { // Additional data to send
			action: 'of_ajax_post_action',
			type: 'upload',
			security: nonce,
			data: clickedID },
		autoSubmit: true, // Submit file after selection
		responseType: false,
		onChange: function(file, extension){},
		onSubmit: function(file, extension){
			clickedObject.text('Uploading'); // change button text, when user selects file	
			this.disable(); // If you want to allow uploading only 1 file at time, you can disable upload button
			interval = window.setInterval(function(){
				var text = clickedObject.text();
				if (text.length < 13){	clickedObject.text(text + '.'); }
				else { clickedObject.text('Uploading'); } 
				}, 200);
		},
		onComplete: function(file, response) {
			window.clearInterval(interval);
			clickedObject.text('Upload Image');	
			this.enable(); // enable upload button
				
	
			// If nonce fails
			if(response==-1){
				var fail_popup = jQuery('#of-popup-fail');
				fail_popup.fadeIn();
				window.setTimeout(function(){
				fail_popup.fadeOut();                        
				}, 2000);
			}				
					
			// If there was an error
			else if(response.search('Upload Error') > -1){
				var buildReturn = '<span class="upload-error">' + response + '</span>';
				jQuery(".upload-error").remove();
				clickedObject.parent().after(buildReturn);
				
				}
			else{
				var buildReturn = '<img class="hide of-option-image" id="image_'+clickedID+'" src="'+response+'" alt="" />';

				jQuery(".upload-error").remove();
				jQuery("#image_" + clickedID).remove();	
				clickedObject.parent().after(buildReturn);
				jQuery('img#image_'+clickedID).fadeIn();
				clickedObject.next('span').fadeIn();
				clickedObject.parent().prev('input').val(response);
			}
		}
	});
			
	});
	
	}
	
	of_image_upload();
	*/