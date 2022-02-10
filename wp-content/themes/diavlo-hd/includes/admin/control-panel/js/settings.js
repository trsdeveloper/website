	function change_selected_retina_image(option) {
		document.getElementById("selected_retina_image").src = userImages[option.value];
	}
	function change_selected_image(option) {
		if (option.value == "") {
					document.getElementById("selected_image").src = templatePath + "/includes/admin/images/no_image_selected.png";
	
		} else {
			document.getElementById("selected_image").src = userImages[option.value];
		}
	}	
	function check_status(el) {
		
		if(el.checked) {
			jQuery(".custom_logo_status_enabled").css("display", "block");
		} else {
			jQuery(".custom_logo_status_enabled").css("display", "none");
		}	
			jQuery("#tabs_container").height(jQuery("#tabs-general").height());
		
	}
	function useTextLogo(selectBox) {
		
	  if (selectBox.selectedIndex == 1) {
		  jQuery("#i3d_logo_settings_text_logo").removeClass("non-visible");
	  } else {
		  jQuery("#i3d_logo_settings_text_logo").addClass("non-visible");		  
	  }
	}	

	function setLink(selectBox) {
		
	  if (selectBox.selectedIndex == 2) {
		  jQuery("#i3d_logo_settings_link_custom").removeClass("non-visible");
	  } else {
		  jQuery("#i3d_logo_settings_link_custom").addClass("non-visible");		  
	  }
	}	


function useTagline(selectBox) {
	  if (selectBox.selectedIndex == 2) {
		  jQuery("#i3d_logo_settings_tagline").removeClass("non-visible");
	  } else {
		  jQuery("#i3d_logo_settings_tagline").addClass("non-visible");		  
	  }
	}	
	//var clickedImageUpload = null;
	function goFavIcoMediaWindow(selectedButton) {
		//clickedImageUpload = selectedButton;
		tb_show('Upload Image', 'media-upload.php?TB_iframe=true&width=220&height=250&tab=type&type=image');
	}
	

	
		  function handleThemeStyleChange(selectBox) {
			  var selectBoxID = selectBox.id;
			  var searchRootID = selectBoxID.replace("__style", "");
			  
			  var selectedIndex = selectBox.selectedIndex;
			  var selectedValue = selectBox.options[selectedIndex].value;
			  
			  jQuery(selectBox).parents("li").find("span.theme-selection").css("display", "none");
			  jQuery(selectBox).parents("li").find("#" + searchRootID + "__" + selectedValue + "_color").parents("span").css("display", "inline");
			  			  jQuery(selectBox).parents("li").find(".layer-selector").popover("hide");

		  }
		  
		  function handleThemeStyleColorChange(selectBox) {
			  jQuery(selectBox).parents("li").find(".layer-selector").popover("hide");
		  }		  
	var counter = 1;
	  
	function add_timed_theme() {
		var id = "";
		var source = "";
		source = jQuery("#temp-timed-theme-settings").html();
		//alert(source);
		source = source.replace(/newtemp/g, 'new' + counter);
		
		jQuery("#sortable-theme-settings").append(source);
		 
    jQuery('#theme_styles__new'+counter+'__start_date_block').datetimepicker({
						pickTime: false,																	
	  useSeconds: false,
	  minuteStepping: 15
    });
    jQuery('#theme_styles__new'+counter+'__end_date_block').datetimepicker({
						pickTime: false,																	
	  useSeconds: false,
	  minuteStepping: 15
    });


	jQuery('#theme_styles__new'+counter+'__start_time_block').datetimepicker({
      pickDate: false,
	  useSeconds: false,
	  minuteStepping: 15
    });
    jQuery('#theme_styles__new'+counter+'__end_time_block').datetimepicker({
      pickDate: false,
	  useSeconds: false,
	  minuteStepping: 15
    });
	
									   
																				
		prepareLayerEditor("#timed_theme__new" + counter);

		counter++;
	}
		  	
		  function setThemeFrequency(selectBox) {
			var selectedValue = selectBox.options[selectBox.selectedIndex].value;
			if (selectedValue == "daily") {
			
				jQuery("#" + selectBox.name.replace("__frequency", "").replace("setting__", "") + "__start_date_block").parents("li").find("label").removeClass("double-height");
				jQuery("#" + selectBox.name.replace("__frequency", "").replace("setting__", "") + "__start_date_block").css("display", "none");
				jQuery("#" + selectBox.name.replace("__frequency", "").replace("setting__", "") + "__end_date_block").css("display", "none");
				jQuery("#" + selectBox.name.replace("__frequency", "").replace("setting__", "") + "__date_block-separator").css("line-height", "28px");
			} else if (selectedValue == "daterange") {
				jQuery("#" + selectBox.name.replace("__frequency", "").replace("setting__", "") + "__start_date_block").parents("li").find("label").addClass("double-height");
				jQuery("#" + selectBox.name.replace("__frequency", "").replace("setting__", "") + "__start_date_block").css("display", "table");
				jQuery("#" + selectBox.name.replace("__frequency", "").replace("setting__", "") + "__end_date_block").css("display", "table");
				jQuery("#" + selectBox.name.replace("__frequency", "").replace("setting__", "") + "__date_block-separator").css("line-height", "55px");
				
			} else {
				alert(selectedValue + " not supported");
			}
		  }
		  
	jQuery(function($) {
		jQuery("#sortable-theme-settings").sortable({cancel: ".fa-icon-chooser,input,textarea,button,select,option" });
	});    
		function remove_timed_theme(id) {
		//get containing div element (container)
		var container = document.getElementById('sortable-theme-settings');

		//get div element to remove
		var olddiv = document.getElementById('timed_theme__'+id);

		//remove the div element from the container
		container.removeChild(olddiv);
	}	
			
			
 function submitCustom(theButton) {
	 theButton.form.target="_self";
	 theButton.form.action="?page=i3d-settings&upgraded=true&activated=true&reset=true&configuration=custom";
	 theButton.submit();
 }
 function openCustom() {
	jQuery("#default-setup").animate({'opacity': 0});
	jQuery("#default-setup").css("display", "none");
	jQuery("#open-custom-pages-button").animate({'opacity': 0});
	jQuery("#custom-pages").animate({'opacity': 1});
	jQuery("#custom-setup").addClass("span12").removeClass("span6");
	
 }
  
  
  function setupSlider(theSlider, selectedValues, columns) {
	  
	 
  
  //alert(columns);
  if (columns == 1) {
      jQuery(theSlider).parent().find("input.layout-holder").val("12");
	  jQuery(theSlider).parent().find(".slider-range").slider({min: 0, max: 12, values: [12], slide: function(event, ui) { return handleSlide(event, ui, this); }} );
	  jQuery(theSlider).parent().find(".slider-range").slider("disable");
  } else if (columns == 2) {
	  
	  if (selectedValues == "") {
		  var myValues = [6];
          jQuery(theSlider).parent().find("input.layout-holder").val("6|6");
	  } else {

        var myValues = getSliderValuesArray(selectedValues);
	    jQuery(theSlider).parent().find("input.layout-holder").val(selectedValues);
	  }
	 
	  jQuery(theSlider).parent().find(".slider-range").slider({min: 0, max: 12, values: myValues, slide: function(event, ui) { return handleSlide(event, ui, this); }} );
	  
  } else if (columns == 3) {
	  if (selectedValues == "") {
		var myValues = [4,8];
	//	alert("nnn");
        jQuery(theSlider).parent().find("input.layout-holder").val("4|4|4");
	  } else {
       var  myValues = getSliderValuesArray(selectedValues);;  
	    jQuery(theSlider).parent().find("input.layout-holder").val(selectedValues);

	  }	  
	  // alert(myValues);
	  jQuery(theSlider).parent().find(".slider-range").slider({min: 0, max: 12, values: myValues, slide: function(event, ui) { return handleSlide(event, ui, this); }} );
     // alert("yup");
  } else if (columns == 4) {
	  if (selectedValues == "") {
		myValues = [3,6,9];
        jQuery(theSlider).parent().find("input.layout-holder").val("3|3|3|3");
	  } else {
        myValues = getSliderValuesArray(selectedValues);;  
	    jQuery(theSlider).parent().find("input.layout-holder").val(selectedValues);
	  }	  
	  jQuery(theSlider).parent().find(".slider-range").slider({min: 0, max: 12, values: myValues, slide: function(event, ui) { return handleSlide(event, ui, this); }} );
  } else if (columns == 5) {
	  if (selectedValues == "") {
		myValues = [2,5,7,10];
        jQuery(theSlider).parent().find("input.layout-holder").val("2|3|2|3|2");
	  } else {
        myValues = getSliderValuesArray(selectedValues);
	    jQuery(theSlider).parent().find("input.layout-holder").val(selectedValues);
	  }	  	  
	  jQuery(theSlider).parent().find(".slider-range").slider({min: 0, max: 12, values: myValues, slide: function(event, ui) { return handleSlide(event, ui, this); }} );
  } else if (columns == 6) {
	  if (selectedValues == "") {
		myValues = [2,4,6,8,10];
        jQuery(theSlider).parent().find("input.layout-holder").val("2|2|2|2|2|2");
	  } else {
        myValues = getSliderValuesArray(selectedValues);  
	    jQuery(theSlider).parent().find("input.layout-holder").val(selectedValues);
	  }	  
	  jQuery(theSlider).parent().find(".slider-range").slider({min: 0, max: 12, values: myValues, slide: function(event, ui) { return handleSlide(event, ui, this); }} );
	  
	  jQuery(theSlider).parent().find(".slider-range").slider("disable");
  } 
  
	jQuery(".slider-range").tooltip({ trigger: 'hover focus click', placement : "right", title: function() { 
																		   
																		   return jQuery(this).parent().find("input.layout-holder").val();
																		   } } ); 
	
  }
function getSliderValuesArray(selectedValues) {
  var myValues = [];
 // alert(selectedValues);
  selectedValuesArray = selectedValues.split("|");
  totalSoFar = 0;
 // alert(selectedValuesArray.length);
  for (i = 0; i < selectedValuesArray.length - 1; i++) {
	  
	  thisIncrement = parseInt(selectedValuesArray[i]) + totalSoFar;
	  myValues.push(thisIncrement);
	//  alert(thisIncrement);
	  //layoutString = layoutString + (ui.values[i] - totalSoFar);
	  totalSoFar = thisIncrement;	  
  }
//  myValues.push(12 - totalSoFar);

  //alert(myValues);
  return myValues;
	
}
function handleSlide (event, ui, theSlider) {
	
	lastPosition = ui.values.length - 1;
	if (ui.values[lastPosition] > 10) {
		jQuery(theSlider).slider("values", lastPosition, 10);
		//ui.values[lastPosition] = 10;
		return false;
	} else if (ui.values[0] < 2) {
		//ui.values[0] = 2;
		jQuery(theSlider).slider("values", 0, 2);
		return false;
	}
	
	layoutString = "";
	totalSoFar = 0;
	for (i = 0; i < ui.values.length; i++) {
	  if (i > 0) {
		  layoutString = layoutString + "|";
	  }
	  thisIncrement = ui.values[i] - totalSoFar;
	  if (thisIncrement < 2) {
		  
		 
		  return false;
	  }
	  layoutString = layoutString + (ui.values[i] - totalSoFar);
	  totalSoFar = totalSoFar + (ui.values[i] - totalSoFar);
	}
	
	layoutString = layoutString + "|" + (12 - totalSoFar);
	//layoutString = layoutString + "**" + totalSoFar;
	jQuery(theSlider).parent().find("input.layout-holder").val(layoutString);
	//jQuery(this).attr("title", layoutString);
	//jQuery(this).attr("data-toggle", "tooltip");
	//alert("yay");
	jQuery(theSlider).tooltip("show");
	
}



jQuery(function() {
	jQuery("select.layout-columns-select").change(function(event) {
		mySlider = jQuery(this).parent().find(".slider-range");
		myValues = "";
		jQuery(mySlider).slider("destroy");
		setupSlider(mySlider, myValues, jQuery(this).val());
	  });			
	
	jQuery(".slider-range").each(function() {
											
		currentValues = jQuery(this).parent().find("input.layout-holder").val();
		var columns = jQuery(this).parent().find("select.layout-columns-select").val();
		setupSlider(this, currentValues, columns);
	});

//$( "#amount" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) + " - $" + $( "#slider-range" ).slider( "values", 1 ) );
});
		function goWidgets() {
		  document.location = "widgets.php";
		}
		var force_reload = false;
		function saveForm(theButton) {
			
theButton.disabled=true; 
jQuery("#saveregion div.spinnerx").html('<i class="icon-spinner icon-spin icon-large"></i>'); 
theButton.form.submit();			
		}
jQuery(function() {		
		jQuery("#saveframe").bind("load", function() {
												   jQuery("#saveregion div.spinnerx").html('');
												  
													jQuery("#savebutton").attr("disabled", false);
													
													if (force_reload) {
														window.location.href=window.location.href;
			  											//theButton.form.target = "_self";	
													}
													 });
				});

function edit_layers(region) {
	var currentStatus = jQuery(region).parent().find(".theme-layers").css("display");
	if (currentStatus == "block") {
		jQuery(region).parent().find(".theme-layers").css("display", "none");
		jQuery(region).find(".fa").removeClass("fa-caret-up");
		jQuery(region).find(".fa").addClass("fa-caret-down");
		jQuery(region).parents("li.timed-theme").find("label").css("line-height", "");
	} else {
		jQuery(region).parent().find(".theme-layers").css("display", "block");
		jQuery(region).find(".fa").removeClass("fa-caret-down");
		jQuery(region).find(".fa").addClass("fa-caret-up");
		jQuery(region).parent().children("label").css("line-height", "100px");
		
	}
}

										jQuery(document).ready(function() {
prepareLayerEditor(".timed-theme");
										});
										
										function prepareLayerEditor(selector) {
											
										//alert(selector);
											jQuery(selector + " .layer-selector").popover({html: true, 
																				  content: function() { 
																								var originalTitle = jQuery(this).attr("data-original-title");
																								var timedThemeID = jQuery(this).parents("li.timed-theme").attr("id").replace("timed_theme__", "");
																								var selectedStyle = jQuery(this).parents("li.timed-theme").find("select#theme_styles__" + timedThemeID + "__style").val();
																								if (!selectedStyle) {
																									var selectedStyle = jQuery(this).parents("li.timed-theme").find("select#__i3d_i3d_theme_styles__" + timedThemeID + "__style").val();
																								}
																								
																								var selectedType = jQuery(this).parents("li.timed-theme").find("select#theme_styles__" + timedThemeID + "__" + selectedStyle + "_color").val();
																								
																								if (!selectedType) {
																									var selectedType = jQuery(this).parents("li.timed-theme").find("select#__i3d_i3d_theme_styles__" + timedThemeID + "__" + selectedStyle + "_color").val();
																								}
																								
																								jQuery(this).parents("li.timed-theme").find("div.theme-layers").find("div.theme-layer-block").css("display", "none");
																								if (jQuery(this).parents("li.timed-theme").find("div.theme-layers").find("div.theme-layers-" + selectedStyle + "-" + selectedType).length > 0) {
																								  jQuery(this).parents("li.timed-theme").find("div.theme-layers").find("div.theme-layers-" + selectedStyle + "-" + selectedType).css("display", "block");
																								} else {
																								  jQuery(this).parents("li.timed-theme").find("div.theme-layers").find("div.theme-layers-" + selectedStyle + "-default").css("display", "block");
																									
																								}
																								html = jQuery(this).parents("li.timed-theme").find("div.theme-layers").html();
																								//alert(html);
																								return html; 
																								}});
										  
    										//jQuery("#layer-selector-<?php echo $theme_counter; ?>").on('shown.bs.popover', function() { 
    										jQuery(".layer-selector").on('shown.bs.popover', function() { 
																									  
												jQuery(this).parents("li.timed-theme").find("input[type=radio]").bind("change", function() {
													radioValue = jQuery(this).val();
																		
													if (radioValue != 0) {
														// update all active buttons with default setting
														jQuery(this).parents("div.btn-group").find("label.btn-enabled").addClass("btn-default");
														jQuery(this).parents("div.btn-group").find("label.btn-enabled").removeClass("btn-success");
														
														// set just this button to active
														jQuery(this).parents("label.btn-enabled").removeClass("btn-default");
														jQuery(this).parents("label.btn-enabled").addClass("btn-success");
														
														// set other radio buttons accordingly
														jQuery(this).parents("div.btn-group").find("input").attr("checked", false);
														jQuery(this).attr("checked", "checked");
													
													} else {
														
														jQuery(this).parents("div.btn-group").find("label.btn-enabled").removeClass("btn-success");
														jQuery(this).parents("div.btn-group").find("label.btn-enabled").addClass("btn-default");
														
														// set other radio buttons accordingly
														jQuery(this).parents("div.btn-group").find("input").attr("checked", false);
														jQuery(this).attr("checked", "checked");														
													}
												});		
											});	
	
										  
											//jQuery("#layer-selector-<?php echo $theme_counter; ?>").on('hide.bs.popover', function() { 
											jQuery(".layer-selector").on('hide.bs.popover', function() { 
												var originalTitle = jQuery(this).attr("data-original-title");
												var html = "";
												var data = jQuery(this).data("bs.popover");

												var tip = data.tip();
												
												var newHTML = tip.find(".popover-content").html();
												if (newHTML != "") {
															  
												jQuery(this).parents(".timed-theme").find("div.theme-layers").html(newHTML);
												}
  											  //data.options.content = "";
											  tip.find(".popover-content").html();
												return true; 
														   
											});		
												
										}
										
jQuery(document).ready(function() {
								if (jQuery("#new-setting-error-tgmpa").length > 0) {
								  jQuery("#new-setting-error-tgmpa").append(jQuery("#setting-error-tgmpa"));
								  jQuery("#new-setting-error-tgmpa").addClass("padding-top-20");
								}
								});