<script>
function handleSidebarChange(selectBox) {
	var selectedSidebar = selectBox.options[selectBox.selectedIndex].value;
	var selectBoxName = jQuery(selectBox).attr("class").replace(" layout-sidebar-select form-control", "");
	
	var sourceRegion = jQuery(".sidebar-widgets").find(".__" + selectedSidebar);
	if (selectedSidebar == "" || selectedSidebar == "x") {
		jQuery("select." + selectBoxName).each(function() {
			jQuery(this).parents("td").find(".visible-when-sidebar-exists").addClass("non-visible");
			var targetRegion = jQuery(this).parents("td").find(".region-widgets");
			jQuery(targetRegion).html("");
			conditionRegionWidgets(this);
		});
		
	} else {
		jQuery("select." + selectBoxName).each(function() {
			jQuery(this).parents("td").find(".visible-when-sidebar-exists").removeClass("non-visible");
			var targetRegion = jQuery(this).parents("td").find(".region-widgets");
			jQuery(targetRegion).html(jQuery(sourceRegion).html());
			conditionRegionWidgets(this);
		});
	}	
}
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
    }
    return "";
} 
jQuery(document).ready(function() {
jQuery('#page-options-tabs ul.setting-tabs a').click(function (e) {
  var tab = jQuery(this).attr("id");
  document.cookie = "tab="+tab;
});
});


jQuery(window).bind('load', function() {
//jQuery(document).ready(function() {
	// attempt to select the selected tab
	var mySelectedTab = getCookie("tab");
	//alert(mySelectedTab);
	if (mySelectedTab != "") {
		
		if (!jQuery("#" + mySelectedTab + "").parent().hasClass("non-visible")) {
		  //jQuery("#" + mySelectedTab).tab("show");	
		 jQuery("#" + mySelectedTab).click();
		 //alert(mySelectedTab);
		 // jQuery('html, body').animate({scrollTop: jQuery("#" + mySelectedTab).offset().top}, 1000);
		} else {
			//alert("hidden" + mySelectedTab);
			jQuery("#page-options-tabs ul.setting-tabs li:first-child a").not(".non-visible").click();
		}
	} else {
		//alert("yup");
	  if (jQuery("#tab-editor").length > 0) {
		jQuery("#tab-editor").click();  
	  }
	}
								});
</script>
<div class='sidebar-widgets'>
<?php 
	$sidebarWidgets = wp_get_sidebars_widgets();
	global $wp_registered_widgets;
	$sidebars = get_option('i3d_sidebar_options');
	if (!is_array($sidebars)) {
		$sidebars = array();
	}
	foreach ($sidebars as $regionID => $regionInfo) { 
		$spanCount = 0;
		print "<div class='__{$regionID}' style='display: none;'>";
		if (is_array($sidebarWidgets["{$regionID}"])) {
			foreach ($sidebarWidgets["{$regionID}"] as $wid) { 
				if ($spanCount == 0) {
					$spanCount++;   
					print "<div class='example-span'>";
					if ($wp_registered_widgets["$wid"]['callback'][0]->id_base == "i3d_columnbreak") {
						print "<div class='alert alert-warning text-center'>Empty Column</div></div><div class='example-span'>";
					}
				} else if ($wp_registered_widgets["$wid"]['callback'][0]->id_base == "i3d_columnbreak") {
					$spanCount++;   
			   		print "</div><div class='example-span'>";
				}
			
				if ($wp_registered_widgets["$wid"]['callback'][0]->id_base == "i3d_columnbreak") {
			   		continue;
				}
				
				print "<div class='alert alert-info text-center {$wp_registered_widgets["$wid"]['callback'][0]->id_base}'>".str_replace("i3d:", "", $wp_registered_widgets["$wid"]['callback'][0]->name)."</div>";
			
			}
			if ($spanCount > 0) {
				print "</div><!-- closing example-span-->";
			}
		} else {
	  		print "<div class='alert alert-error text-center'>This sidebar does not yet have any widgets in it.</div>";
		}		
				  
		print "</div><!-- end of __region-->";
	} 
?>
</div><!-- closing sidebar-widgets-->
<script>
function conditionRegionWidgets(selectBox) {
	var theSlider = jQuery(selectBox).parents("td").find(".slider-range");
			
	jQuery(theSlider).parent().find(".example-span").each(function(index) {														 	
		allValues = jQuery(theSlider).parent().find("input.layout-holder").val();
		allValuesArray = allValues.split("|");
		
		jQuery(this).removeClass("col-sm-1");
		jQuery(this).removeClass("col-sm-2");
		jQuery(this).removeClass("col-sm-3");
		jQuery(this).removeClass("col-sm-4");
		jQuery(this).removeClass("col-sm-5");
		jQuery(this).removeClass("col-sm-6");
		jQuery(this).removeClass("col-sm-7");
		jQuery(this).removeClass("col-sm-8");
		jQuery(this).removeClass("col-sm-9");
		jQuery(this).removeClass("col-sm-10");
		jQuery(this).removeClass("col-sm-11");
		jQuery(this).removeClass("col-sm-12");																	   
		jQuery(this).removeClass("marginleftzero");
		
		if (allValuesArray[index]) {
			jQuery(this).addClass("col-sm-" + allValuesArray[index]);
		} else {
		   jQuery(this).addClass("col-sm-12");
		   jQuery(this).addClass("marginleftzero");
		}
	});					
	
	var layout = jQuery(selectBox).parents("div.tab-pane").attr("id").replace("tabs-", "").replace("-layout", "");
	setSpecialCTAFields(layout);
}
		
function setupSlider(theSlider, selectedValues, columns) {
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
			jQuery(theSlider).parent().find("input.layout-holder").val("4|4|4");
		} else {
			var  myValues = getSliderValuesArray(selectedValues);;  
			jQuery(theSlider).parent().find("input.layout-holder").val(selectedValues);	
		}	  
		jQuery(theSlider).parent().find(".slider-range").slider({min: 0, max: 12, values: myValues, slide: function(event, ui) { return handleSlide(event, ui, this); }} );
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
  	jQuery(theSlider).parent().find(".example-span").each(function(index) {
		allValues = jQuery(theSlider).parent().find("input.layout-holder").val();
		allValuesArray = allValues.split("|");
		
		jQuery(this).removeClass("col-sm-1");
		jQuery(this).removeClass("col-sm-2");
		jQuery(this).removeClass("col-sm-3");
		jQuery(this).removeClass("col-sm-4");
		jQuery(this).removeClass("col-sm-5");
		jQuery(this).removeClass("col-sm-6");
		jQuery(this).removeClass("col-sm-7");
		jQuery(this).removeClass("col-sm-8");
		jQuery(this).removeClass("col-sm-9");
		jQuery(this).removeClass("col-sm-10");
		jQuery(this).removeClass("col-sm-11");
		jQuery(this).removeClass("col-sm-12");																		   
		jQuery(this).removeClass("marginleftzero");
		
		if (allValuesArray[index]) {
		 jQuery(this).addClass("col-sm-" + allValuesArray[index]);
		} else {
		   jQuery(this).addClass("col-sm-12");
		   jQuery(this).addClass("marginleftzero");
		}
	});
  
	jQuery(".slider-range").tooltip({ trigger: 'hover focus click', placement : "right", title: function() { 
		return jQuery(this).parent().find("input.layout-holder").val();
	} } ); 
	
}

function getSliderValuesArray(selectedValues) {
	var myValues = [];
	var selectedValuesArray = selectedValues.split("|");
	var totalSoFar = 0;
	for (i = 0; i < selectedValuesArray.length - 1; i++) {
		thisIncrement = parseInt(selectedValuesArray[i]) + totalSoFar;
		myValues.push(thisIncrement);
		totalSoFar = thisIncrement;	  
	}
	return myValues;
}

function handleSlide(event, ui, theSlider) {
	lastPosition = ui.values.length - 1;
	if (ui.values[lastPosition] > 10) {
		jQuery(theSlider).slider("values", lastPosition, 10);
		return false;
	} else if (ui.values[0] < 2) {
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
	jQuery(theSlider).parent().find("input.layout-holder").val(layoutString);
	jQuery(theSlider).parent().find(".example-span").each(function(index) {															 
		allValues = jQuery(theSlider).parent().find("input.layout-holder").val();
		allValuesArray = allValues.split("|");

		jQuery(this).removeClass("col-sm-1");
		jQuery(this).removeClass("col-sm-2");
		jQuery(this).removeClass("col-sm-3");
		jQuery(this).removeClass("col-sm-4");
		jQuery(this).removeClass("col-sm-5");
		jQuery(this).removeClass("col-sm-6");
		jQuery(this).removeClass("col-sm-7");
		jQuery(this).removeClass("col-sm-8");
		jQuery(this).removeClass("col-sm-9");
		jQuery(this).removeClass("col-sm-10");
		jQuery(this).removeClass("col-sm-11");
		jQuery(this).removeClass("col-sm-12");																		   
		jQuery(this).removeClass("marginleftzero");
		
		if (allValuesArray[index]) {
			jQuery(this).addClass("col-sm-" + allValuesArray[index]);
		} else {
		   jQuery(this).addClass("col-sm-12");
		   jQuery(this).addClass("marginleftzero");
		}
	});
	
	jQuery(theSlider).tooltip("show");
}

jQuery(document).ready(function(jQuery) {
	jQuery("select.layout-columns-select").change(function(event) {
		mySlider = jQuery(this).parents("tr").find(".slider-range");
		myValues = "";
		jQuery(mySlider).slider("destroy");
		setupSlider(mySlider, myValues, jQuery(this).val());
	});			
	
	jQuery(".slider-range").each(function() {
		currentValues = jQuery(this).parents("tr").find("input.layout-holder").val();
		var columns = jQuery(this).parents("tr").find("select.layout-columns-select").val();
		setupSlider(this, currentValues, columns);
	});
	
	<?php if (!I3D_Framework::use_global_layout()) { ?>

	jQuery("#page_template").bind("change", function() {
		var selectedLayout = jQuery(this).val();
		setSidebars(selectedLayout);
		setSpecialRegions(selectedLayout);
	});
	
		setSidebars(jQuery("#page_template").val());

	setSpecialRegions(jQuery("#page_template").val());
  	<?php } ?>

	jQuery(".tt").tooltip();
	jQuery(".icon-tooltip").tooltip();
});


function setSidebars(layout) {
	var layout = layout.replace(/.php/, '');
	jQuery(".optional-sidebars tr.configurable").addClass("non-editable");
	jQuery(".optional-sidebars tr." + layout).removeClass("non-editable");

}
function setSpecialRegions(layout) {
	
	var layout = layout.replace(/.php/, '');
	//alert(layout);
	layout = layout.replace(/template-/, '');
	jQuery(".special-region").addClass("non-visible");
	var count = jQuery("." + layout).removeClass("non-visible");
	//alert("setSpecialRegions");
	if (layout == "business") {
		jQuery('#page-options-tabs').tabs("option", "active", 0); 	
	} else if (layout == "photo-slideshow") {
		jQuery('#page-options-tabs').tabs("option", "active", 1); 
	} else if (layout == "contact") {
		jQuery('#page-options-tabs').tabs("option", "active", 2); 	
	} else  if (layout == "sitemap") {
		jQuery('#page-options-tabs').tabs("option", "active", 3); 	
	} else if (layout == "blog") {
		jQuery('#page-options-tabs').tabs("option", "active", 4); 	
	} else {
	
 	    jQuery('#page-options-tabs').tabs("option", "active", 5); 	
	}
	
}


function toggleWidgetVisibility(scope, widgetID, template) {
	if (scope == "mobile") {
		if (jQuery("#__i3d_widget_visibility__" + template + "__" + widgetID).hasClass("hidden-xs")) {
			setWidgetVisibility(scope, widgetID, template, true);  
		} else {
			setWidgetVisibility(scope, widgetID, template, false);  
		}
	} else {
		if (jQuery("#__i3d_widget_visibility__" + template + "__" + widgetID).hasClass("hidden-sm")) {
			setWidgetVisibility(scope, widgetID, template, true);  
		} else {
			setWidgetVisibility(scope, widgetID, template, false);  
		}
		
	}
}

function setWidgetVisibility(scope, widgetID, template, value) {
	if (value) {
		if (scope == "mobile") {
			jQuery("#__i3d_widget_visibility__" + template + "__" + widgetID).removeClass("hidden-xs");
			jQuery("#__i3d_widget_visibility__" + template + "__" + widgetID + "__mobile").parent().find(".btn").addClass("btn-success");
			jQuery("#__i3d_widget_visibility__" + template + "__" + widgetID + "__mobile").parent().find(".btn").removeClass("btn-danger");
			jQuery("#__i3d_widget_visibility__" + template + "__" + widgetID + "__mobile").parent().find(".btn span").removeClass("icon-remove");
			jQuery("#__i3d_widget_visibility__" + template + "__" + widgetID + "__mobile").parent().find(".btn span").addClass("icon-ok");
		} else if (scope == "tablet") {
			jQuery("#__i3d_widget_visibility__" + template + "__" + widgetID).removeClass("hidden-sm");		
			jQuery("#__i3d_widget_visibility__" + template + "__" + widgetID + "__tablet").parent().find(".btn").addClass("btn-success");
			jQuery("#__i3d_widget_visibility__" + template + "__" + widgetID + "__tablet").parent().find(".btn").removeClass("btn-danger");
			jQuery("#__i3d_widget_visibility__" + template + "__" + widgetID + "__tablet").parent().find(".btn span").removeClass("icon-remove");
			jQuery("#__i3d_widget_visibility__" + template + "__" + widgetID + "__tablet").parent().find(".btn span").addClass("icon-ok");
		}
	} else {
		if (scope == "mobile") {
			jQuery("#__i3d_widget_visibility__" + template + "__" + widgetID).addClass("hidden-xs");
			jQuery("#__i3d_widget_visibility__" + template + "__" + widgetID + "__mobile").parent().find(".btn").addClass("btn-danger");
			jQuery("#__i3d_widget_visibility__" + template + "__" + widgetID + "__mobile").parent().find(".btn").removeClass("btn-success");
			jQuery("#__i3d_widget_visibility__" + template + "__" + widgetID + "__mobile").parent().find(".btn span").removeClass("icon-ok");
			jQuery("#__i3d_widget_visibility__" + template + "__" + widgetID + "__mobile").parent().find(".btn span").addClass("icon-remove");
		} else if (scope == "tablet") {
			jQuery("#__i3d_widget_visibility__" + template + "__" + widgetID).addClass("hidden-sm");		
			jQuery("#__i3d_widget_visibility__" + template + "__" + widgetID + "__tablet").parent().find(".btn").addClass("btn-danger");
			jQuery("#__i3d_widget_visibility__" + template + "__" + widgetID + "__tablet").parent().find(".btn").removeClass("btn-success");
			jQuery("#__i3d_widget_visibility__" + template + "__" + widgetID + "__tablet").parent().find(".btn span").removeClass("icon-ok");
			jQuery("#__i3d_widget_visibility__" + template + "__" + widgetID + "__tablet").parent().find(".btn span").addClass("icon-remove");
		}
		  
	}
  	
	var className = jQuery("#__i3d_widget_visibility__" + template + "__" + widgetID).attr("class");
	jQuery("#__i3d_widget_visibility__" + template + "__" + widgetID).val(className);
  
}

</script>
<?php

function display_sidebar_options2($currentValue, $defaultSidebar = "") {
	if ($defaultSidebar != "") {
	  echo "<option value=''>-- Use Default Sidebar (".ucwords(str_replace("-", " ", $defaultSidebar)).") --</option>\n";
	  echo "<option ".($currentValue == "x" ? 'selected' : '')." value='x'>-- No Sidebar Selected --</option>\n";
		
	} else {
	  echo "<option value=''>-- No Sidebar Selected --</option>\n";
	}
	
	$sidebars = get_option('i3d_sidebar_options');
	//print "current: $currentValue<br>";
	if(is_array($sidebars) && !empty($sidebars)){
		foreach($sidebars as $sidebarID => $sidebarName){
		//	print "sid: $sidebarID<br>";
			if($currentValue == $sidebarID){
				echo "<option value='$sidebarID' selected>$sidebarName</option>\n";
			}else{
				echo "<option value='$sidebarID'>$sidebarName</option>\n";
			}
		}
	}
}

function display_menu_options2($currentValue) {
	
	$menusOptions = get_option('luckymarble_menu_options');
	
	if(is_array($menusOptions) && !empty($menusOptions)){
		foreach($menusOptions as $menuID => $menuName){
			if($currentValue == $menuID){
				echo "<option value='$menuID' selected>$menuName</option>\n";
			}else{
				echo "<option value='$menuID'>$menuName</option>\n";
			}
		}
	}
}

  function getSeoProgressData($post, $type = "percent") {
	 $percent = 0;
	 $tip = "You should update your";
	 $h1 			= get_post_meta($post->ID, 'i3d_page_title', true);
	 $h2 			= get_post_meta($post->ID, 'i3d_page_description', true);
	 $keywords 		= get_post_meta($post->ID, 'i3d_page_meta_keywords', true);
	 $description 	= get_post_meta($post->ID, 'i3d_page_meta_description', true);
	 
	 if ($h1 == "" || $h1 == "Your Home Page" || $h1 == "Your Page Title") {
		 $tip .= " page title (H1),";
	 } else {
		 $percent += 25;		 
	 }

	 if ($h2 == "" || $h2 == "This is an example Business home page.") {
		 $tip .= " page description (H2),";
	 } else {
		 $percent += 25;
		 
	 }
	 
	 if ($keywords == "") {
		 $tip .= " page meta keywords,";
	 } else {
		 $percent += 25;		 
		 
	 }
     if ($description == "") {
		 
		 $tip .= " page meta description,";
	 } else {
		 $percent += 25;
		 
	 }
	 $tip = rtrim($tip, ",");
	 $tip .= ".";
	 if ($percent == 100) {
		 $tip = "Great job -- your SEO Meta data is all set up!";
	 }
	 if ($type == "percent") {
		 return $percent;
	 } else if ($type == "tip") {
		 return $tip;
	 }

  }
  function getLayoutProgressData($post, $type = "percent") {
	 $percent = 0;
	 $sidebarCount = 0;
	 $totalAvailableSidebars = 0;
	 $pageRegions = get_post_meta($post->ID, "layout_regions", true);
	 if (!is_array($pageRegions)) {
		$pageRegions = array();
	 }
	 $template =   str_replace("template-", "", str_replace(".php", "", get_post_meta($post->ID, "_wp_page_template", true)));
	 if ($template == "") {
		 $template = "default";
	 }
	 $templateRegions = I3D_Framework::$templateRegions["{$template}"];

	// var_dump($pageRegions);

	foreach ($templateRegions as $regionID => $regionInfo) { 
		if (!isset($pageRegions["{$template}"]["{$regionID}"]["sidebar"]) && $regionInfo['type'] == "user-defined") {	
		//print "not set $regionID<br>";
			$pageRegions["{$template}"]["{$regionID}"]["sidebar"] = get_post_meta($post->ID, "i3d-widget-area-".$regionID, true);
		} else {
			//print "<b>yup<b> $regionID<br>";
		}
		if (!array_key_exists($template, $pageRegions) || !array_key_exists($regionID, $pageRegions["$template"] )|| !array_key_exists("sidebar", $pageRegions["$template"]["$regionID"])) {
			$pageRegions["{$template}"]["{$regionID}"]["sidebar"] = "";
		}
		 if ($pageRegions["{$template}"]["{$regionID}"]["sidebar"] != "" || $regionInfo['type'] == "pre-defined") {
			$sidebarCount++; 
			//print "<u>yes</u><br>";
		 }
		 $totalAvailableSidebars++;
	 }
	 //print $totalAvailableSidebars;
	 //print $sidebarCount;
	 if ($type == "percent") {
		 return number_format(( $sidebarCount / $totalAvailableSidebars ) * 100, 0, '', '');
	 } else if ($type == "tip") {
		 if (($sidebarCount / $totalAvailableSidebars)*100 < 40) {
			return "You may wish to enable some sidebars in your Layout panel to add some widgets to your page"; 
		 } else {
			return "Looks like your page is shaping up.  You may wish to add more sidebars to your page to add more flare.";
		 }
		 //return $tip;
	 }

  }  
  function getProgressStyle($percent) {
	  if ($percent >= 85) return "progress-bar-success";
	  if ($percent >= 65) return "progress-bar-info";
	  if ($percent >= 45) return "progress-bar-warning";
	  return "progress-bar-danger";

	  
  }
 
   function getPostProgressData( $type = "percent") {
	   $posts = get_posts(array("posts_per_page" => 25));
	   
	if (sizeof($posts) < 7) {
		$tip = "You need to add more blog posts, and on a regular basis.";
	} else {
		$tip = "Looking good!  Make sure to keep adding blog posts on a regular basis.";
	}
	
	$percent = number_format(sizeof($posts) / 10 * 100, 0, '.', ',');
	$percent > 100 ? 100 : $percent; 
	
    
	if ($type == "percent") { return $percent; }
	if ($type == "tip") { return $tip; }
  }
 
  function getMenuProgressData($post, $type = "percent") {
	$i3dMenus 	= get_option('i3d_menu_options');
	$menuId 	= get_post_meta($post->ID, 'i3d_page_menu_id', true);
	
	if ($menuId == "" || $i3dMenus["{$menuId}"] == "") {
		$percent = 0;
		$tip = "You need to make sure you have a drop down menu selected";
	} else {
		$tip = "Perfect, you have a menu selected!";
		$percent = 100;
	}
    
	if ($type == "percent") { return $percent; }
	if ($type == "tip") { return $tip; }
  }
  
function getSliderProgressData($post, $type = "percent") {
	$sliders 				= get_option('i3d_sliders');
	$i3dAvailableSliders 	= I3D_Framework::getSliders();
	$sliderID 				= get_post_meta($post->ID, "i3d_page_slider", true);
	$slider 				= @$sliders["$sliderID"];
	
	
	if (@$sliderID == "" || @$i3dAvailableSliders[@$slider['slider_type']] == "") {
		$percent = 0;
		$tip = "You have not selected an available slider.";
	} else {
		$tip = "Perfect, you have a slider selected!";
		$percent = 100;
	}
    
	if ($type == "percent") { return $percent; }
	if ($type == "tip") { return $tip; }
  }
  
?>
