<?php
$lmWidgetIdCount = 0;
$sidebarCount = array();

add_filter('dynamic_sidebar_params','i3d_modify_widget_display');
add_filter('wp_nav_menu', 'i3d_modify_wp_nav_menu');
add_filter('wp_nav_menu_args', 'i3d_modify_wp_nav_menu_args');

function i3d_modify_wp_nav_menu_args($args) {
	//$args['walker'] = new I3D_Walker_Nav_Menu;
	return $args;
}
	
	
function i3d_modify_wp_nav_menu($menu) {
	global $lmFrameworkVersion;
	global $lmCurrentSidebar;
		  $pattern = '/<ul id="(.*)" class="menu"/';
		  $replacement = '<ul class="menu" ';
	$menu = preg_replace($pattern, $replacement, $menu);
	add_action('wp_footer', 'i3d_add_bootstrap_menu_code', 100);

    return $menu;
	
}
function i3d_add_bootstrap_menu_code() {
	global $settingOptions;
	if (I3D_Framework::$navbarVersion == "2" || I3D_Framework::$navbarVersion == "2.1" || I3D_Framework::$navbarVersion == "3"  || I3D_Framework::$navbarVersion == "4" || I3D_Framework::$navbarVersion == "5") { ?>
<script type="text/javascript">
jQuery(".menu-wrap").addClass("navbar");
jQuery(".menu").addClass("nav");
jQuery(".menu ul").each(function() {
	if (jQuery(this).parents(".primary-vertical").length == 0) {
		jQuery(this).addClass("dropdown-menu");
	}
});
 
// on the first level li, make it a typical bootstrap top menu drop down
jQuery(".menu > li").each(function() {
	if (jQuery(this).parents(".primary-vertical").length == 0) {
		if (jQuery(this).children("ul").length > 0) {
			jQuery(this).addClass("dropdown");
			jQuery(this).children("a").addClass("dropdown-toggle");
			jQuery(this).children("a").attr("data-toggle", "dropdown");
			<?php if (I3D_Framework::$adjustNavbar) { ?>jQuery(this).children("a").html(jQuery(this).children("a").html() + '<strong class="caret"></strong>'); <?php } ?>
        }
 	}
});

// create sub-level drop downs
jQuery(".menu > li > ul li").each(function() {
	if (jQuery(this).parents(".primary-vertical").length == 0) {
		if (jQuery(this).children("ul").length > 0) {
			jQuery(this).addClass("dropdown-submenu");
			jQuery(this).children("a").addClass("dropdown-toggle");
			jQuery(this).children("ul").addClass("dropdown-menu");
		}
	}
});

jQuery(document).ready(function() {
	// Handles menu drop down
	jQuery('.dropdown-menu').find('form').click(function (e) {
		e.stopPropagation();
	});
	jQuery('.dropdown-submenu').click(function(e) {
		e.stopPropagation();
	});
});

jQuery(document).on("scroll",function(){
	if(jQuery(document).scrollTop()>50){ 
		jQuery("header:not(.nochange)").removeClass("large").addClass("small");
	} else {
		jQuery("header:not(.nochange)").removeClass("small").addClass("large");
	}
});

<?php if (@$settingOptions['horizontal_menu_activation'] == "1") { ?>
jQuery(document).ready(function ($) {
	$('.navbar .dropdown').hover(function() {
    		$(this).addClass('extra-nav-class').find('.dropdown-menu').first().stop(true, true).delay(250).slideDown();
    		$(this).click();
		}, function() {
    		var na = $(this)
    		na.removeClass("open");
        	na.find(".dropdown-menu").removeClass("open");
			na.find(".dropdown-menu").removeClass("open");
			na.find('.dropdown-menu').first().stop(true, true).delay(100).slideUp('fast', function(){ na.removeClass('extra-nav-class') })
			na.find("a").trigger("blur");
		});

	$('.dropdown-submenu').hover(function() {
		$(this).addClass('extra-nav-class').find('.dropdown-menu').first().stop(true, true).delay(250).slideDown();
	}, function() {
		var na = $(this)
		na.find('.dropdown-menu').first().stop(true, true).delay(100).slideUp('fast', function(){ na.removeClass('extra-nav-class') })
		na.find("a").trigger("blur");
	});
});		

jQuery('.dropdown-toggle').removeAttr("data-toggle");
jQuery('.dropdown-toggle').removeClass("dropdown-toggle");
		<?php } ?>
	</script>    
    
    <?php } else { ?>
<script type="text/javascript">
      jQuery("#menu-wrap").addClass("navbar");
      jQuery("ul.menu").addClass("nav");
      jQuery("ul.menu ul").addClass("dropdown-menu");

      // on the first level li, make it a typical bootstrap top menu drop down
      jQuery("ul.menu > li").each(function() {

        if (jQuery(this).children("ul").length > 0) {
          jQuery(this).addClass("dropdown");
          jQuery(this).children("a").addClass("dropdown-toggle");
          jQuery(this).children("a").attr("data-toggle", "dropdown");
          jQuery(this).children("a").html(jQuery(this).children("a").html() + '<strong class="caret"></strong>');

        }
         });

      // create sub-level drop downs
      jQuery("ul.menu > li > ul li").each(function() {

        if (jQuery(this).children("ul").length > 0) {
          jQuery(this).addClass("dropdown-submenu");
          jQuery(this).children("a").addClass("dropdown-toggle");
          jQuery(this).children("ul").addClass("dropdown-menu");
        }

      });

jQuery(document).ready(function() {
  // Handles menu drop down
  jQuery('.dropdown-menu').find('form').click(function (e) {
        e.stopPropagation();
        });
  });
</script>
<?php }


}

function getBootstrapSpanClass($page_id, $currentColumn, $lmCurrentSidebar) {
	global $layoutOptions;
	global $settingOptions;
	global $i3dBootstrapVersion;
	global $pageTemplate;
	global $testMode;
	global $sidebarColumnCount;
	
	$settingOptions = wp_parse_args( (array) $settingOptions, array( 'tablet_responsive' => '','mobile_responsive' => '') );

	if (I3D_Framework::use_global_layout()) {
		
		global $current_layout_row;
		global $page_id;
		global $global_span_width;
		$spanWidth = $global_span_width;
		$layout = I3D_Framework::get_page_layout_data($page_id);
		$row = i3d_get_layout_row($layout, $current_layout_row);

	
		if (@$row["presets"] == "contact-panel") {
		global $current_layout_row;
		global $page_id;
		global $global_span_width;
		  $spansWidths = explode("|",$global_span_width);
		  $spanWidth				= @$spansWidths["{$currentColumn}"];
			$spanClass = "";
		} else {
			$spansWidths 			= explode("|", $row['layout']);	
			$spanWidth				= @$spansWidths["{$currentColumn}"];
		}
		$spanClass = "";	


	} else {
		$pageRegions   = get_post_meta($page_id, "layout_regions", true);
	
		if (!is_array($pageRegions)) {
			$pageRegions = array();
		}

		$masterSpansWidths    	= explode("|", $layoutOptions["$pageTemplate"]["i3d-widget-area-{$lmCurrentSidebar}"]["layout"]);
		$pageLevelSpansWidth  	= explode("|", @$pageRegions["$pageTemplate"]["{$lmCurrentSidebar}"]["layout"]);
	 
		$spansWidths 			= @$pageRegions["{$pageTemplate}"]["{$lmCurrentSidebar}"]["layout"] == "" ? $masterSpansWidths : $pageLevelSpansWidth;	
		$spanWidth				= @$spansWidths["{$currentColumn}"];
	
		$spanClass = "";	
	}
	
	$doTabletResponsive = $settingOptions['tablet_responsive'] == 1;
	$doMobileResponsive = $settingOptions['mobile_responsive'] == 1;
	global $isColumnSidebar;
	if ($i3dBootstrapVersion == 2.3) {
	  $spanClass = "span{$spanWidth}";	
	} else if ($i3dBootstrapVersion >= 3) {
	  if (sizeof($spansWidths) > 1 && @!$isColumnSidebar) { 
		  if ($doMobileResponsive) {
			$spanClass .= "col-xs-12 col-sm-{$spanWidth}";
		  } else {
			$spanClass .= "col-xs-{$spanWidth}";
		  }
	  } else {
		  $spanClass .= "would-have-been-column-xs-12";
	  }
	  
	}	

	return $spanClass;
}

function getColumnWidgest($widgetsInSidebar, $column) {
    global $wp_registered_widgets;
    
    
    
    $widgets = array();
  $columnCount = 0;
  
   foreach ($widgetsInSidebar as  $wid) {
	if ($wp_registered_widgets["$wid"]['callback'][0]->id_base == "i3d_columnbreak") {
	  $columnCount++;  
	} else {
	  if ($columnCount == $column) {
	    $widgets[] = $wid;
	   }
	}
   }  
   return $widgets;

}

function hasVisibleSidebarWidgets($widgetsInSidebar, $widgetVisibility = array(), $type = "all") {
 
   
   if (!is_array($widgetsInSidebar)) {
	   $widgetsInSidebar = array();
   }
   
   $count = 0;
   if (!is_array($widgetVisibility)) {
	   $widgetVisibility = array();
   }
   foreach ($widgetsInSidebar as  $wid) {
	   //
		//$wid = $widget["widget_id"];
	//	print $wid."<br>";
		//print $widget;
	   if (!array_key_exists($wid, $widgetVisibility)) {
		   $widgetVisibility["$wid"] = "";
	   }
	   if (($type == "all" || $type == "mobile") && !strstr($widgetVisibility["$wid"], "hidden-xs")) {
			   $count++;
	   } else if (($type == "all" || $type == "tablet") && !strstr($widgetVisibility["$wid"], "hidden-sm")) {
			   $count++;
	   }
	   //else if ($type == "all") {
		   
		// $count++;   
	 //  }
   }
   //print $count;
   return $count > 0;
}
function i3d_modify_widget_display($args) {
	global $lmCurrentSidebar, $lmWidgetIdCount;
	global $lmWidgetWrapConfig;
	global $sidebarCount;
	global $lmFrameworkVersion;
	global $pageTemplate;
	global $layoutOptions;
	
	global $widgetCount; // used to keep track of whether we are the last widget in this sidebar, to close off the row
	global $sidebarColumnCount;
	global $post;
	global $page_id;
	global $testMode;
	global $i3dBootstrapVersion;
	global $settingOptions;
	global $global_row;
	
	
	// will need to modify widget visibility for the new layout mechanism
	if (I3D_Framework::use_global_layout()) {
	   $widgetVisibility = @$global_row['visibility'];	
	} else {
		$widgetVisibility	= get_post_meta($page_id, "widget_visibility", true);
	}
//	var_dump($widgetVisibility);
	$settingOptions = wp_parse_args( (array) $settingOptions, array( 'tablet_responsive' => '','mobile_responsive' => '') );

	$doTabletResponsive = $settingOptions['tablet_responsive'] == 1;
	$doMobileResponsive = $settingOptions['tablet_responsive'] == 1;

	$allSidebars 				= wp_get_sidebars_widgets();
	$totalWidgetsInThisSidebar 	= count($allSidebars["{$args[0]['id']}"]);

	// initialize if not yet holding a value
	if (!is_array($widgetCount) || !array_key_exists($lmCurrentSidebar, $widgetCount) || $widgetCount["$lmCurrentSidebar"] == "") {
		$widgetCount["$lmCurrentSidebar"] = 0;
	}
	
	// initialize if not yet holding a value
	if (!is_array($sidebarColumnCount) || !array_key_exists($lmCurrentSidebar, $sidebarColumnCount) || $sidebarColumnCount["$lmCurrentSidebar"] == "") {
		$sidebarColumnCount["$lmCurrentSidebar"] = 0;		
	}
	
	$currentColumn = $sidebarColumnCount["$lmCurrentSidebar"];
	$currentWidget = $widgetCount["$lmCurrentSidebar"];
	if (I3D_Framework::use_global_layout()) {
		global $current_layout_row;
		global $page_id;
		$layout = I3D_Framework::get_page_layout_data($page_id);
		$row = i3d_get_layout_row($layout, $current_layout_row);
	
		
		$spansWidths 			= explode("|", $row['layout']);	
	
	
	} else {
		$pageRegions   = get_post_meta($page_id, "layout_regions", true);
		
		if (!is_array($pageRegions)) {
			$pageRegions = array();
		}

		if (@!array_key_exists($pageTemplate, $layoutOptions) || @!array_key_exists("i3d-widget-area-{$lmCurrentSidebar}", $layoutOptions["$pageTemplate"])) {
			$layoutOptions["$pageTemplate"]["i3d-widget-area-{$lmCurrentSidebar}"]["layout"] = "";
		}

		$masterSpansWidths    = explode("|", $layoutOptions["$pageTemplate"]["i3d-widget-area-{$lmCurrentSidebar}"]["layout"]);
		$pageLevelSpansWidth  = explode("|", @$pageRegions["$pageTemplate"]["{$lmCurrentSidebar}"]["layout"]);
	
		$spansWidths = @$pageRegions["{$pageTemplate}"]["{$lmCurrentSidebar}"]["layout"] == "" ? $masterSpansWidths : $pageLevelSpansWidth;	

	}


	
    $spanClass     = getBootstrapSpanClass($page_id, $currentColumn, $lmCurrentSidebar);

	// change wrapper on heading
	if ($args[0]['before_widget'] == "" && $args[0]['before_title'] == "") {
		$args[0]['before_title'] = '<h3>';
		$args[0]['after_title'] = '</h3>';
	}
//	print $currentColumn." -- ".$currentWidget;
    if ($currentColumn == "0" && $currentWidget == "0") {
//		print "vv". $args[0]["widget_name"];
		if (I3D_Framework::use_global_layout()) {
			//print "x";
			//var_dump($allSidebars["{$args[0]['id']}"]);
			$hasSomeWidget 	 = @hasVisibleSidebarWidgets($allSidebars["{$args[0]['id']}"], $widgetVisibility, "all");
			$hasMobileWidget = @hasVisibleSidebarWidgets($allSidebars["{$args[0]['id']}"], $widgetVisibility, "mobile");
			$hasTabletWidget = @hasVisibleSidebarWidgets($allSidebars["{$args[0]['id']}"], $widgetVisibility, "tablet");
		//	print ":".$hasSomeWidget.":".$hasMobileWidget.":".$hasTabletWidget."<br>";
		} else {
			$hasSomeWidget = @hasVisibleSidebarWidgets($allSidebars["{$args[0]['id']}"], $widgetVisibility["$pageTemplate"], "all");
			$hasMobileWidget = @hasVisibleSidebarWidgets($allSidebars["{$args[0]['id']}"], $widgetVisibility["$pageTemplate"], "mobile");
			$hasTabletWidget = @hasVisibleSidebarWidgets($allSidebars["{$args[0]['id']}"], $widgetVisibility["$pageTemplate"], "tablet");
			
		}
		if (!$hasSomeWidget) {
			//print "dont have a widget";
			//return; // disabled as it doesn't really work -- ideally, we'd like to not display the row at all, but more investigation is required
		}
		if (sizeof($spansWidths) > 1 || $i3dBootstrapVersion == 2.3) { 
		  $args[0]['before_widget'] .= "<div class='row".($i3dBootstrapVersion >= 3 && !$testMode ? "" : "-fluid").(!$hasMobileWidget ? " hidden-xs" : "").(!$hasTabletWidget ? " hidden-sm" : "")."'>";
		} else {
		  if (I3D_Framework::$wrapOneColumnWithRow) {
		    $args[0]['before_widget'] .= "<div class='row".(!$hasMobileWidget ? " hidden-xs" : "").(!$hasTabletWidget ? " hidden-sm" : "")."'>";		  
		  } else {
		    $args[0]['before_widget'] .= "<div class='would-have-been-row".(!$hasMobileWidget ? " hidden-xs" : "").(!$hasTabletWidget ? " hidden-sm" : "")."'>";
		  }
		}
		
		if ($args[0]["widget_name"] == "Column Break" || $args[0]["widget_name"] == "i3d:Column Break" || $args[0]["widget_name"] == "i3d:*Column Break") {
			
			$args[0]['before_widget'] .= "<div class='{$spanClass}";
			
			if ($doMobileResponsive) {
				$args[0]['before_widget'] .= " hidden-xs ccc";
			}
			
			$args[0]['before_widget'] .= "'></div>";
			
			$currentColumn++; 
			$spanClass = getBootstrapSpanClass($page_id, $currentColumn, $lmCurrentSidebar);
		    $sidebarColumnCount["$lmCurrentSidebar"]++;
			
		} else if ($args[0]["widget_name"] == "i3d:*Row Break") {
			


		}
		$wVis = @$widgetVisibility["{$args[0]['widget_id']}"];
		//var_dump($wVis);
		$args[0]['before_widget'] .= "<div class='{$spanClass} {$wVis}'>";
	
		//print "should probably start up a row, and a span";
		//$sidebarColumnCount["$lmCurrentSidebar"]++;
	} else {
//print "greater".$args[0]["widget_name"];
		if ($args[0]["widget_name"] == "Column Break" || $args[0]["widget_name"] == "i3d:Column Break"  || $args[0]["widget_name"] == "i3d:*Column Break") {
			


			$currentColumn++;
		    $spanWidth = @$spansWidths["{$currentColumn}"];
			$spanClass = getBootstrapSpanClass($page_id, $currentColumn, $lmCurrentSidebar);
		    $sidebarColumnCount["$lmCurrentSidebar"]++;	
			
		if ($currentColumn > 0 || $currentWidget > 0) {
			
			$args[0]['before_widget'] .= "</div><div class='{$spanClass}";
			if (I3D_Framework::use_global_layout()) {
			
				$wVis = @$widgetVisibility["{$args[0]['widget_id']}"];
				$hasMobileWidget = hasVisibleSidebarWidgets(getColumnWidgest($allSidebars["{$args[0]['id']}"], $currentColumn), $widgetVisibility, "mobile");
				$hasTabletWidget = hasVisibleSidebarWidgets(getColumnWidgest($allSidebars["{$args[0]['id']}"], $currentColumn), $widgetVisibility, "tablet");
								

			} else {
				if (!is_array($widgetVisibility)) {
				  $widgetVisibility = array();
				}
				if (!array_key_exists($pageTemplate, $widgetVisibility)) {
					$widgetVisibility["$pageTemplate"] = array();
				}
				if (!array_key_exists($args[0]['widget_id'], $widgetVisibility["$pageTemplate"])) {
					$widgetVisibility["$pageTemplate"]["{$args[0]['widget_id']}"] = "";
				}
				
				$wVis = $widgetVisibility["$pageTemplate"]["{$args[0]['widget_id']}"];
				$hasMobileWidget = hasVisibleSidebarWidgets(getColumnWidgest($allSidebars["{$args[0]['id']}"], $currentColumn), $widgetVisibility["$pageTemplate"], "mobile");
				$hasTabletWidget = hasVisibleSidebarWidgets(getColumnWidgest($allSidebars["{$args[0]['id']}"], $currentColumn), $widgetVisibility["$pageTemplate"], "tablet");
			}

			if ($doMobileResponsive && !$hasMobileWidget) {
				$args[0]['before_widget'] .= " hidden-xs ";
			}
			if ($doTabletResponsive && !$hasTabletWidget) {
				$args[0]['before_widget'] .= " hidden-sm ";
			}
		    //$sidebarColumnCount["$lmCurrentSidebar"]++;
			$args[0]['before_widget'] .= "'>";
		}

		
		} else if ($args[0]["widget_name"] == "i3d:*Row Break") {

	//print "row break";
				$currentColumn = 0;
				$spanWidth = @$spansWidths["{$currentColumn}"];
				//var_dump(
				$spanClass = getBootstrapSpanClass($page_id, $currentColumn, $lmCurrentSidebar);
				$sidebarColumnCount["$lmCurrentSidebar"] = 0;	
				
			if ($currentColumn > 0 || $currentWidget > 0) {
				
				$args[0]['before_widget'] .= "</div><!-- end of column -->\n</div><!-- end of row -->\n<div class='row'><div class='{$spanClass}";
				if (I3D_Framework::use_global_layout()) {
				
					$wVis = @$widgetVisibility["{$args[0]['widget_id']}"];
					$hasMobileWidget = hasVisibleSidebarWidgets(getColumnWidgest($allSidebars["{$args[0]['id']}"], $currentColumn), $widgetVisibility, "mobile");
					$hasTabletWidget = hasVisibleSidebarWidgets(getColumnWidgest($allSidebars["{$args[0]['id']}"], $currentColumn), $widgetVisibility, "tablet");
									
	
				} else {
					if (!is_array($widgetVisibility)) {
					  $widgetVisibility = array();
					}
					if (!array_key_exists($pageTemplate, $widgetVisibility)) {
						$widgetVisibility["$pageTemplate"] = array();
					}
					if (!array_key_exists($args[0]['widget_id'], $widgetVisibility["$pageTemplate"])) {
						$widgetVisibility["$pageTemplate"]["{$args[0]['widget_id']}"] = "";
					}
					
					$wVis = $widgetVisibility["$pageTemplate"]["{$args[0]['widget_id']}"];
					$hasMobileWidget = hasVisibleSidebarWidgets(getColumnWidgest($allSidebars["{$args[0]['id']}"], $currentColumn), $widgetVisibility["$pageTemplate"], "mobile");
					$hasTabletWidget = hasVisibleSidebarWidgets(getColumnWidgest($allSidebars["{$args[0]['id']}"], $currentColumn), $widgetVisibility["$pageTemplate"], "tablet");
				}
	
				if ($doMobileResponsive && !$hasMobileWidget) {
					$args[0]['before_widget'] .= " hidden-xs ";
				}
				if ($doTabletResponsive && !$hasTabletWidget) {
					$args[0]['before_widget'] .= " hidden-sm ";
				}
				//$sidebarColumnCount["$lmCurrentSidebar"]++;
				$args[0]['before_widget'] .= "'>";
			}






		}  // end of row break
		
		
		
		if ($global_row['type'] == "preset") {
							$wVis = @$widgetVisibility["{$args[0]['widget_id']}"];

			$args[0]['before_widget'] .= "</div><div class='{$spanClass} {$wVis}'>";
		}
	}
	//print "yay";


	$widgetCount["$lmCurrentSidebar"]++;
	//print "[".$args[0]["widget_name"]."]";
	if (!isset($widgetClass)) {
		$widgetClass = "";
	}
//	print "[".$arg[0]["widget_name"]."]";
	if ($args[0]["widget_name"] == "Recent Posts" || 
		$args[0]["widget_name"] == "Categories" || 
		$args[0]["widget_name"] == "Text Box" || 
		$args[0]["widget_name"] == "Meta" || 
		$args[0]["widget_name"] == "Calendar" ||
		strstr($args[0]["widget_name"],"WooCommerce") ||
		strstr($args[0]["widget_name"],"(WPEC)")
		) {
		$widgetClass = "basic-widget-wrapper box-article";

	}
	$wid = $args[0]["widget_id"];

	if ($doMobileResponsive || $doTabletResponsive) {
	  if (is_array($widgetVisibility) && array_key_exists($pageTemplate, $widgetVisibility) && is_array($widgetVisibility["$pageTemplate"]) && array_key_exists($wid, $widgetVisibility["$pageTemplate"])) {
	  $widgetClass .= " ".$widgetVisibility["$pageTemplate"]["$wid"];	
	  }
	}
	if ($args[0]["widget_name"] == "Column Break" || $args[0]["widget_name"] == "i3d:Column Break" || $args[0]["widget_name"] == "i3d:*Column Break") {

	// $args[0]['before_widget'] .= "<!-- beginning of widget wrapper --><div class='i3d-opt-box-style {$widgetClass}'>";
	 // $args[0]['after_widget']  .= "</div><!-- end of widget wrapper -->";
	} else if ($args[0]["widget_name"] == "i3d:*Row Break") {

	} else {
	  $args[0]['before_widget'] .= "<!-- beginning of widget wrapper --><div class='i3d-opt-box-style {$widgetClass}'>";
	  $args[0]['after_widget']  .= "</div><!-- end of widget wrapper -->";
	}
	if ($widgetCount["$lmCurrentSidebar"] == $totalWidgetsInThisSidebar) {
	  $args[0]['after_widget'] .= "</div><!-- end of column --></div><!-- end of row ({$lmCurrentSidebar})-->";	
	}	
	//print "Zcurrent column ".$sidebarColumnCount["$lmCurrentSidebar"]."<br>";
		
	return $args;
}

function i3d_show_sidebar($sidebar) {
  global $supportedSidebars;
  global $myPageID;
  global $lmCurrentSidebar;
  global $layoutOptions;

  $lmCurrentSidebar = $sidebar;
  $extra = "";
  if ($sidebar != "banner-space") {
	  $extra = "-widget-area";
  }

  if ((!function_exists('dynamic_sidebar') || !dynamic_sidebar(get_post_meta($myPageID, "i3d-row-{$lmCurrentSidebar}{$extra}", true))) ) :
  endif;



}

function i3d_show_individual_widget_in_region($widget_class, $row_id, $wrapperClasses = array()) {
  global $page_id;
//  print "yup";
  $layout 	= I3D_Framework::get_page_layout_data($page_id);
  $row 		= i3d_get_layout_row($layout, $row_id);
  $settings = array();
  $configuration = array();
 // if (sizeof($wrapperClasses) 
 // $wrapperClasses = I3D_Framework::$defaultSidebarClasses;
 //var_dump($wrapperClasses);
 if (sizeof($wrapperClasses) == 0) {
	// print "not existing";
	 $wrapperClasses = I3D_Framework::$defaultSidebarClasses;
 } else {
	 $wrapperClasses[] = array("tag" => "div", "class" => "row");
 }
  
  $doNotCollapse = false;

		  $args = array("before_title" => "<h3>",
						"after_title" => "</h3>",
						"before_widget" => "<div class='i3d-opt-box-style'>",
						"afer_widget" => "</div>");

		if (@$row['styles_pad_top'] != "") {
			$row['styles'] .= " ".($row['styles_pad_top']);
		}
		
		if (@$row['styles_pad_bottom'] != "") {
			$row['styles'] .= " ".($row['styles_pad_bottom']);
		}


		if (@$row['styles'] != "") {
			if (strstr($row['styles'], "c-pad")) {
				$abstyle = explode(" c-pad", $row['styles']);
				$activeBackgroundID = $abstyle[0];
			} else {
				$activeBackgroundID = @$row['styles'];
			}
			$activeBackgrounds = get_option('i3d_active_backgrounds', true);
			if (!is_array($activeBackgrounds)) { $activeBackgrounds = array(); }
			$activeBackground  = @$activeBackgrounds["{$activeBackgroundID}"];
			if ($activeBackground['background_type'] == "map") {
				global $usesGoogleMaps;
				$usesGoogleMaps = true;
			}
			if ($activeBackground['background_visibility'] == "always") {
				$doNotCollapse = true;
				if (@$activeBackground['background_desktop_min_height'] == "") {
					$activeBackground['background_desktop_min_height'] = 300;
				}
		
				if (@$activeBackground['background_mobile_min_height'] == "") {
					$activeBackground['background_mobile_min_height'] = 150;
				}
		
				$row['styles'] .= " desktop-min-height-".$activeBackground['background_desktop_min_height'];
				$row['styles'] .= " mobile-min-height-".$activeBackground['background_mobile_min_height'];
			}
		}

	$fullscreen = @$row['width'] == "fullscreen";
		ob_start();

		if ($fullscreen) {
			if (@$row['styles'] != "") {
				print "<div class='{$row['styles']}'>";
				if (strstr($row['styles'], "wrapper-tint")) {
		  			print "<div class='wrapper tint1'>";	
				}
	 		}
		} else {
			foreach ($wrapperClasses as $wrapper) {
				$tagName = $wrapper['tag'];
				$className = $wrapper['class'];
				$tagID = str_replace("[row_id]", $row_id, @$wrapper['id']);

if (!array_key_exists('styles', $row)) {
					$row["styles"] = "";
				}
				//print $row['styles'];
	
				if (($className == "container-wrapper" || $className == "content-wrapper" || $className == "footer") && $row["styles"] != "") {
		  			$bg = $row["styles"];
		  
					// if no background is defined, then we assume it is the default (top most defined in the optional styled backgrounds array) style
					if ($bg == "") { 
						$bg = array_shift(array_keys(I3D_Framework::$optionalStyledBackgrounds));
					}
		  
		  
		  			$className .= " ".$bg;
				}

				print "<{$tagName}";
				if ($className != "") {
					
				  print " class='{$className}'";
				}
				if ($tagID != "") {
				  print " id='{$tagID}'";
					
				}
				print ">";	
	           // print "[".$className."]";
				if (strstr($className, "wrapper-tint")) {
					print "<div class='wrapper tint1 padding-top-40 padding-bottom-80'>";	
				}
	  

			} // end of foreach			
		}
	
		 // $settings['row_id'] = $row_id;
		 // $settings['widget_id'] = $widgetInfo['id'];
		  
		  $args = array("before_title" => "<h3>",
						"after_title" => "</h3>",
						"before_widget" => "<div class='i3d-opt-box-style'>",
						"afer_widget" => "</div>");
		  
		 // var_dump($widgetInfo);
		// print "yes";
		
		  if (@is_array($row["configuration"]["{$widgetInfo['id']}"])) {
			 foreach ($row["configuration"]["{$widgetInfo['id']}"] as $key => $value) {
				if ($value != "") {
					$settings["$key"] = $value; 
				}
				//print "$key = $value <br>";
			 }
		  }
	//print "v";
	//var_dump($row);
	    //  $configuration = $row['configuration']["$widget_id"];
		  if (!array_key_exists('configuration', $row) || !is_array($row['configuration'])) {
							$row['configuration'] = array();
		  } 
		  foreach ($row['configuration'] as $key => $value) {
			$configuration = $value; 
		  }
			  
		 // var_dump($configuration);
		  ob_start();
		  $configuration = wp_parse_args( (array) $configuration, array( 'row_id' => $row_id) );
		 // var_dump($configuration);
		 //if (class_exists($widget_class)) {
			 //print $widget_class;
		  @the_widget( $widget_class, $configuration, $args);  
		  $the_widget_output = ob_get_clean();
		  print $the_widget_output;
		 //}
		  /*
		  foreach ($row['configuration'] as $widget_id => $configuration) {
			//  print $widget_id;
		//$myWidget = I3D_Framework::instantiate_widget($widget_class);
		       $configuration['row_id'] = $row_id;
			   $configuration['widget_id']   = $widget_id;
			  // var_dump($configuration);,m
			  // var_dump($widget_class);
			
			   the_widget( $widget_class, $configuration, $args);  
		  	   break;
		  }
		  */
			if ($fullscreen) {
			if (@$row['styles'] != "") {
				if (strstr($row['styles'], "wrapper-tint")) {
					print "</div>";	
				}
				print "</div>";
			}  
		} else {
			if (strstr(@$row['styles'], "wrapper-tint")) {
  				print "</div>";	
			}
			//var_dump($wrapperClasses);
			$wrapperClassesReverse = array_reverse($wrapperClasses);
			foreach ($wrapperClassesReverse as $wrapper) {
								$tagName = $wrapper['tag'];
				$className = $wrapper['class'];

				print "</{$tagName}>";	
			}	  
		}
		
		if (strlen($the_widget_output) > 0 || $doNotCollapse) {
			print ob_get_clean();
		} else {
			ob_end_clean();
		}
	


}

function hasVisiblePresetWidgets($widgetsInRegion, $widgetVisibility, $type = "all") {
 
   
   if (!is_array($widgetsInRegion)) {
	   $widgetsInRegion = array();
   }
   
   $count = 0;
 //  var_dump($widgetsInRegion);
   $widgetVisibility = (array)$widgetVisibility;
   foreach ($widgetsInRegion["widgets"] as $widgetArray) {

	   if (!array_key_exists($widgetArray['id'], $widgetVisibility)) {
		   $widgetVisibility["{$widgetArray['id']}"] = "";
	   }
	   if (($type == "all" || $type == "mobile") && !strstr($widgetVisibility["{$widgetArray['id']}"], "hidden-xs")) {
			   $count++;
	   } else if (($type == "all" || $type == "tablet") && !strstr($widgetVisibility["{$widgetArray['id']}"], "hidden-sm")) {
			   $count++;
	   }

   }
   return $count > 0;
}

function i3d_show_preset_region($presets, $row_id) {
	
	global $page_id;
	global $layout_id;

	$preset_configurations = I3D_Framework::$layoutPresets["{$presets}"];
	if ($layout_id == "") {
		$layout = I3D_Framework::get_page_layout_data($page_id);
	} else {
		$layout = I3D_Framework::get_layout_data($layout_id);
	}
	$row = wp_parse_args( (array) i3d_get_layout_row($layout, $row_id), array( 'visibility' => '', 'configuration' => array()) );
	
	//var_dump($row);
	global $current_layout_row;
		$current_layout_row = $row_id; // not really a default region, however we're using this variable to pass in the row for this configuration
		if (@$row['styles_pad_top'] != "") {
			$row['styles'] .= " ".($row['styles_pad_top']);
		}
		
		if (@$row['styles_pad_bottom'] != "") {
			$row['styles'] .= " ".($row['styles_pad_bottom']);
		}

//var_dump(@$row['styles']);
		if (@$row['styles'] != "") {
			if (strstr($row['styles'], "c-pad")) {
				$abstyle = explode(" c-pad", $row['styles']);
				$activeBackgroundID = $abstyle[0];
			} else {
				$activeBackgroundID = @$row['styles'];
			}
			$activeBackgrounds = get_option('i3d_active_backgrounds', true);
			if (!is_array($activeBackgrounds)) { $activeBackgrounds = array(); }
			$activeBackground  = @$activeBackgrounds["{$activeBackgroundID}"];
			if ($activeBackground['background_type'] == "map") {
				global $usesGoogleMaps;
				$usesGoogleMaps = true;
			}
			if ($activeBackground['background_visibility'] == "always") {
				$doNotCollapse = true;
				if (@$activeBackground['background_desktop_min_height'] == "") {
					$activeBackground['background_desktop_min_height'] = 300;
				}
		
				if (@$activeBackground['background_mobile_min_height'] == "") {
					$activeBackground['background_mobile_min_height'] = 150;
				}
		
				$row['styles'] .= " desktop-min-height-".$activeBackground['background_desktop_min_height'];
				$row['styles'] .= " mobile-min-height-".$activeBackground['background_mobile_min_height'];
			}
		}
				if (!array_key_exists('styles', $row)) {
					$row["styles"] = "";
				}
				//print $row['styles'];
			$background_classes = explode(",", $row['styles']);
			$containsRow = false;
	if (!is_array($preset_configurations['container'])) {
	//	var_dump($preset_configurations);
	//	var_dump($presets);
	}
	foreach ($preset_configurations['container'] as $v => $wrapper_code) {
		
		
				$tagName = $wrapper_code['tag'];
				$className = $wrapper_code['class'];
				if (strstr($className, "row")) {
					$containsRow = true;
				} else {
					$containsRow = false;
				}
				$tagID = str_replace("[row_id]", $row_id, @$wrapper_code['id']);

				if (($className == "container-wrapper" || $className == "content-wrapper" || $className == "footer") && $row["styles"] != "") {
		  			
					$bg = $background_classes[0];
					array_shift($background_classes);
					
		  
					// if no background is defined, then we assume it is the default (top most defined in the optional styled backgrounds array) style
					if ($bg == "") { 
						$bg = array_shift(array_keys(I3D_Framework::$optionalStyledBackgrounds));
					}
		  
		  
		  			$className .= " ".$bg;
				} else {
					
					$bg = @$background_classes[0];
					if ($bg != "") {
						array_shift($background_classes);
						if ($bg == "section-inner" && strstr("container", $className)) {
							print "<div class='{$bg}'>";
						} else {
							$className .= " ".$bg;
						}
					}
				}
//print "class name: $tagName -- $className";
				print "<{$tagName}";
				if ($className != "") {
					
				  print " class='{$className}'";
				}
				if ($tagID != "") {
				  print " id='{$tagID}'";
					
				}
				print ">";	
	           // print "[".$className."]";
				if (strstr($className, "wrapper-tint")) {
					print "<div class='wrapper tint1 padding-top-40 padding-bottom-80'>";	
				}
	  		
				//print "<{$wrapper_code['tag']} class='{$wrapper_code['class']}'>";

	}
	
	$layout_configuration = explode("|", $row['layout']);
	$lostColumnWidth = 0;
	//var_dump($layout_configuration);
	
	foreach ($preset_configurations['columns'] as $i => $column) {
	  	
				$hasMobileWidget = hasVisiblePresetWidgets($column, $row['visibility'], "mobile");
				$hasTabletWidget = hasVisiblePresetWidgets($column, $row['visibility'], "tablet");
				$hasVisibleWidget = hasVisiblePresetWidgets($column, $row['visibility'], "all");
		//print ":".$hasMobileWidget.":".$hasTabletWidget.":".$hasVisibleWidget."<br>";
	  
	  if (!$hasVisibleWidget && sizeof($preset_configurations['columns']) > 1) {
		  if ($layout_configuration["{$i}"] == "") {
			  $lostColumnWidth += 12;
		  } else {
		    $lostColumnWidth += $layout_configuration["{$i}"];
		  }
		  continue;
	  }
	  
	  //if ($layout_configuration["{$i}"] != "12" && $layout_configuration["{$i}"] != "") { 
	  if (sizeof($preset_configurations['container']) > 0 && $containsRow) {
	 	 print "<div class='col-sm-".($layout_configuration["{$i}"] + $lostColumnWidth)." ";
		 if (!$hasMobileWidget) {
			 print "hidden-xs ";
		 } 
		 if (!$hasTabletWidget) {
			 print "hidden-sm ";
		 }
		 print "'>";
	  }
	  //}
	  
		  if (array_key_exists("wrappers", $column)) {
		  	foreach ($column['wrappers'] as $wrapper) {
			 	print "<{$wrapper['tag']}";
				if (@$wrapper['class'] != "") {
					print " class='{$wrapper['class']}'";
				}
				if (@$wrapper['id'] != "") {
					print " id='".str_replace("[row_id]", $row_id, $wrapper['id'])."'";
				}
				print ">";  
			
		  	}
		  }	  
	//  print "Hmm maybe";
	  foreach ($column['widgets'] as $j => $widgetInfo) {
		 // print $widgetInfo;
		  $wVis = @$row['visibility']["{$widgetInfo['id']}"];
		 // var_dump($row['visibility']);
		 // var_dump($widgetInfo);
		  $widget = I3D_Framework::instantiate_widget($widgetInfo);
		  $settings = $widgetInfo['defaults'];
		  $settings['row_id'] = $row_id;
		  $settings['widget_id'] = $widgetInfo['id'];
		  
		  $args = array("before_title" => "<h3>",
						"after_title" => "</h3>",
						"before_widget" => "<div class='i3d-opt-box-style {$wVis}'>",
						"afer_widget" => "</div>");

		 // var_dump($widgetInfo);
		  // print "yes";
		  //var_dump($row['configuration']);
		  if (@is_array($row["configuration"]["{$widgetInfo['id']}"])) {
			 foreach ($row["configuration"]["{$widgetInfo['id']}"] as $key => $value) {
				if ($value != "") {
					$settings["$key"] = $value; 
				}
			//	print "$key = $value <br>";
			 }
		  }
		  //  print get_class($widget);
		 // var_dump($settings);
		 		  global $global_row;
		  $global_row = $row;
		  
		 // var_dump($widgetInfo);

		  @the_widget( $widgetInfo['class_name'], $settings, $args);  

	  }
		  if (array_key_exists("wrappers", $column)) {
			//  var_dump($column['wrappers']);
			$wrapperClassesReverse = array_reverse($column['wrappers']);
			foreach ($wrapperClassesReverse as $wrapper) {			  
			  
		  //	foreach ($column['wrappers'] as $wrapper) {
			 	print "</{$wrapper['tag']}>";  
			
		  	}
		  }	 	  
	  // if ($layout_configuration["{$i}"] != "12" && $layout_configuration["{$i}"] != "") { 
	  if (sizeof($preset_configurations['container']) > 0 && $containsRow) {
	  print "</div>";
	  }
	  // }
	}

			$reversedWrapperClasses = array_reverse($preset_configurations['container'], true);

	foreach ($reversedWrapperClasses as $wrapper_code) {
		print "</{$wrapper_code['tag']}>";
	}

}


function i3d_show_divider_region($dividerName) {
	global $page_id;
	global $pageTemplate;
	
	if (I3D_Framework::use_global_layout()) {
		$layout = I3D_Framework::get_page_layout_data($page_id);
		$row 	= i3d_get_layout_row($layout, $dividerName);
		//var_dump($row);
		if ($row['styles'] != "") {
			$wrapperClasses = explode(",", $row['styles']);
			foreach ($wrapperClasses as $className) {
				print "<div class='{$className}'>";  
			}
			foreach ($wrapperClasses as $className) {
				print "</div>";
			}
		}
	  
	} else {
		$pageRegions = get_post_meta($page_id, "layout_regions", true);
		
		if (!is_array($pageRegions)) {
			$pageRegions = array();  
		}
		if (array_key_exists($pageTemplate, $pageRegions) && array_key_exists($dividerName, $pageRegions["$pageTemplate"]) && $pageRegions["$pageTemplate"]["$dividerName"]["bg"] != "") {
		  $wrapperClasses = explode(",", $pageRegions["$pageTemplate"]["$dividerName"]["bg"]);
		  foreach ($wrapperClasses as $className) {
			print "<div class='{$className}'>";  
		  }
		  foreach ($wrapperClasses as $className) {
			print "</div>";
		  }
		  
		}
	}
}

function i3d_get_layout_row($layout, $rowID) {
  if (is_array($layout['sections'])) {
	  foreach ($layout['sections'] as $section_id => $section) {
		  foreach ($section['rows'] as $row_id => $row) {
			  
			  if ($row_id == $rowID) {
				  return $row;
			  }
			  
		  }
	  }
   }
}



function i3d_show_widget_region($sidebar, $wrapperClasses = array(), $defaultRegion = "", $regionType = "wide") {
  global $supportedSidebars;
  global $myPageID;
  global $lmCurrentSidebar;
  global $layoutOptions;
  global $pageTemplate;
  global $page_id;
  global $wp_registered_sidebars;

 

	if (!is_array($wrapperClasses)) {
	  $wrapperClasses = array();
  }
  $doNotCollapse = false;
  

  $lmCurrentSidebar = $sidebar;
  
    /* GLOBAL LAYOUT METHOD */
	if (I3D_Framework::use_global_layout()) {
		@ob_flush(); // needed so that we don't lose any previous data if a sidebar doesn't contain any information
	//	print "Maybe";
		global $current_layout_row;
		$current_layout_row = $defaultRegion; // not really a default region, however we're using this variable to pass in the row for this configuration
		$layout = I3D_Framework::get_page_layout_data($page_id);
		$row = i3d_get_layout_row($layout, $current_layout_row);
		if (!array_key_exists($row['sidebar'], $wp_registered_sidebars)) {
			return;
  		} 

		//var_dump($row);
		global $global_row;
		$global_row = $row;
		
		if (@$row['styles_pad_top'] != "") {
			$row['styles'] .= " ".($row['styles_pad_top']);
		}
		
		if (@$row['styles_pad_bottom'] != "") {
			$row['styles'] .= " ".($row['styles_pad_bottom']);
		}
		
		if (@$row['styles'] != "") {
			if (strstr($row['styles'], "c-pad")) {
				$abstyle = explode(" c-pad", $row['styles']);
				$activeBackgroundID = $abstyle[0];
			} else {
				$activeBackgroundID = @$row['styles'];
			}
			$activeBackgrounds = get_option('i3d_active_backgrounds', true);
			if (!is_array($activeBackgrounds)) { $activeBackgrounds = array(); }
			$activeBackground  = @$activeBackgrounds["{$activeBackgroundID}"];
			if ($activeBackground['background_type'] == "map") {
				global $usesGoogleMaps;
				$usesGoogleMaps = true;
			}
			if ($activeBackground['background_visibility'] == "always") {
				$doNotCollapse = true;
				if (@$activeBackground['background_desktop_min_height'] == "") {
					$activeBackground['background_desktop_min_height'] = 300;
				}
		
				if (@$activeBackground['background_mobile_min_height'] == "") {
					$activeBackground['background_mobile_min_height'] = 150;
				}
		
				$row['styles'] .= " desktop-min-height-".$activeBackground['background_desktop_min_height'];
				$row['styles'] .= " mobile-min-height-".$activeBackground['background_mobile_min_height'];
			}
		}

		$fullscreen = @$row['width'] == "fullscreen";

		if ($fullscreen) {
			if (@$row['styles'] != "") {
				print "<div class='{$row['styles']}'>";
				if (strstr($row['styles'], "wrapper-tint")) {
		  			print "<div class='wrapper tint1'>";	
				}
	 		}
  		} else {
				if (!array_key_exists('styles', $row)) {
					$row["styles"] = "";
				}
				//print $row['styles'];
			$background_classes = explode(",", $row['styles']);
			//var_dump($background_classes);
			//	var_dump($wrapperClasses);
		//	var_dump($row);
			foreach ($wrapperClasses as $wrapper) {
				$tagName = $wrapper['tag'];
				$className = $wrapper['class'];
				$tagID = str_replace("[row_id]", $current_layout_row, @$wrapper['id']);

				if (($className == "container-wrapper" || $className == "content-wrapper" || $className == "footer") && $row["styles"] != "") {
		  			
					$bg = $background_classes[0];
					array_shift($background_classes);
					
		  
					// if no background is defined, then we assume it is the default (top most defined in the optional styled backgrounds array) style
					if ($bg == "") { 
						$bg = array_shift(array_keys(I3D_Framework::$optionalStyledBackgrounds));
					}
		  
		  
		  			$className .= " ".$bg;
					//print "yes";
				} else {
				//	print "nope";
					$bg = @$background_classes[0];
					if ($bg != "") {
						array_shift($background_classes);
						if ($bg == "section-inner" && strstr("container", $className)) {
							print "<div class='{$bg}'>";
						} else {
							$className .= " ".$bg;
						}
					}
				}
				
				print "<{$tagName}";
				if ($className != "") {
					print " class='{$className}'";
				}
				if ($tagID != "") {
					print " id='{$tagID}'";
				}
				print ">";	
	           // print "[".$className."]";
			   	  // this is Denmark specific code to insert a short code that injects  
				  if (strstr($className, "insert-side-graphic")) {
					  print '<img class="side-pic-right"
					data-bottom="opacity: 1; margin-top:0px;"
					data-bottom-top="opacity: 0; margin-top:-100px;"
					data-top="opacity: 1; margin-top:0px;"
					data-top-bottom="opacity: 0; margin-top:500px;"
			
					src="'.get_stylesheet_directory_uri().'/Site/images/side-pic.png" alt="side pic"
			
					>';
				  }
				if (strstr($className, "wrapper-tint")) {
					print "<div class='wrapper tint1 padding-top-40 padding-bottom-80'>";	
				}
	  

			} // end of foreach
		} // end of if not "fullscreen"
		ob_start();
		
		//$fullRegionName = "i3d-widget-area-{$row['sidebar']}";
		//print "x:".$fullRegionName;
		
		if ((!function_exists('dynamic_sidebar') || !dynamic_sidebar($row['sidebar'])) ) :
		endif;
		$sidebarContents = ob_get_clean();
		ob_start();	// added sept 11, 2015 as it turns out that the ob_get_clean is closing out the buffer, and taking us out of the ob level earlier than expected.  This ob_start() call balances the ob_get_clean/ob_end_clean 25 lines ahead
  		 print $sidebarContents;
 
  		

		if ($fullscreen) {
			if (@$row['styles'] != "") {
				if (strstr($row['styles'], "wrapper-tint")) {
					print "</div>";	
				}
				print "</div>";
			}  
		} else {
			
			
			if (strstr(@$row['styles'], "wrapper-tint") || strstr(@$row['styles'], ",section-inner")) {
  				print "</div>";	
			}
			$reversedWrapperClasses = array_reverse($wrapperClasses, true);
			foreach ($reversedWrapperClasses as $wrapper) {
								$tagName = $wrapper['tag'];
				$className = $wrapper['class'];

				print "</{$tagName}>";	
			}	  
		}
		if (strlen($sidebarContents) > 0 || $doNotCollapse) {
			print ob_get_clean();
		} else {
			ob_end_clean();
		}






	/* LEGACY PAGE LAYOUT METHOD */	
	} else {
		$pageRegions = get_post_meta($page_id, "layout_regions", true);
	
		if (!is_array($pageRegions)) {	  
			$pageRegions = array();
		}
	 
	 
	 
   if (@$pageRegions["$pageTemplate"]["{$lmCurrentSidebar}"]["bg"] != "") {
			if (strstr($row['styles'], "c-pad")) {
				$abstyle = explode(" c-pad", @$pageRegions["$pageTemplate"]["{$lmCurrentSidebar}"]["bg"]);
				$activeBackgroundID = $abstyle[0];
			} else {
				$activeBackgroundID = @$pageRegions["$pageTemplate"]["{$lmCurrentSidebar}"]["bg"];
			}
			$activeBackgrounds = get_option('i3d_active_backgrounds', true);
			if (!is_array($activeBackgrounds)) { $activeBackgrounds = array(); }
			$activeBackground  = @$activeBackgrounds["{$activeBackgroundID}"];
			if ($activeBackground['background_type'] == "map") {
				global $usesGoogleMaps;
				$usesGoogleMaps = true;
			}


//$activeBackgroundID = @$pageRegions["$pageTemplate"]["{$lmCurrentSidebar}"]["bg"];
		//$activeBackgrounds = (array)get_option('i3d_active_backgrounds');
		//$activeBackground  = @$activeBackgrounds["{$activeBackgroundID}"];
		if ($activeBackground['background_visibility'] == "always") {
			$doNotCollapse = true;
			if (@$activeBackground['background_desktop_min_height'] == "") {
				$activeBackground['background_desktop_min_height'] = 300;
			}
			
			if (@$activeBackground['background_mobile_min_height'] == "") {
				$activeBackground['background_mobile_min_height'] = 150;
			}
			
			$pageRegions["$pageTemplate"]["{$lmCurrentSidebar}"]["bg"] .= " desktop-min-height-".$activeBackground['background_desktop_min_height'];
			$pageRegions["$pageTemplate"]["{$lmCurrentSidebar}"]["bg"] .= " mobile-min-height-".$activeBackground['background_mobile_min_height'];
		}
   }

  $fullscreen = @$pageRegions["$pageTemplate"]["{$lmCurrentSidebar}"]["width"] == "" ? @$layoutOptions["$pageTemplate"]["i3d-widget-area-{$lmCurrentSidebar}"]["width"] == "fullscreen" : @$pageRegions["$pageTemplate"]["{$lmCurrentSidebar}"]["width"] == "fullscreen";
  $extra = "";
 
  
  if ($sidebar != "banner-space") {
	 
  }
  
  ob_start();
  
  $backupFullRegionName = "i3d-widget-area-{$sidebar}{$extra}";
 // print $fullRegionName;
  $fullRegionName = @$pageRegions["$pageTemplate"]["$sidebar"]['sidebar'];
  if ($fullRegionName == "") {
//	  $fullRegionName = $backupFullRegionName;
  }
  $templateRegions 	= @I3D_Framework::$templateRegions["{$pageTemplate}"];
  
  $possibleDefaultRegion    = @$templateRegions["$sidebar"]["configuration"]["default-sidebar"];
 // var_dump($templateRegions);
  //print $sidebar."<br>";
 // var_dump($templateRegions["$sidebar"]);
  //print "default region: ".$possibleDefaultRegion."<br>";
 // print "sidebar name: ".$pageRegions["$pageTemplate"]["$sidebar"]['sidebar'];
  $hasDefaultRegion = false;
  //print $pageTemplate;
  if (@$pageRegions["$pageTemplate"]["$sidebar"]['sidebar'] == "x") {
	  $fullRegionName = "";
	 // $hasDefaultRegion = false;
	// print "maybe";
  } else if (@$pageRegions["$pageTemplate"]["$sidebar"]['sidebar'] == "" && $possibleDefaultRegion != "") {
	  $hasDefaultRegion = true;
	 // print "yup";
	  //$fullRegionName = "i3d-widget-area-{$defaultRegion}{$extra}";
  } else {
	 // print "Nope";
  }
  
  
  //if ($layoutOptions["$pageTemplate"]["i3d-widget-area-{$lmCurrentSidebar}"]["width"] == "fullscreen") {
  if ($fullscreen) {
     if (@$pageRegions["$pageTemplate"]["{$lmCurrentSidebar}"]["bg"] != "") {
		print "<div class='".$pageRegions["$pageTemplate"]["{$lmCurrentSidebar}"]["bg"]."'>";
		if (strstr($pageRegions["$pageTemplate"]["{$lmCurrentSidebar}"]["bg"], "wrapper-tint")) {
		  print "<div class='wrapper tint1'>";	
		} 
	 }
  } else {
	foreach ($wrapperClasses as $className) {
		  if (!array_key_exists($pageTemplate, $pageRegions) || !array_key_exists($lmCurrentSidebar, $pageRegions["{$pageTemplate}"]) || !array_key_exists('bg', $pageRegions["{$pageTemplate}"]["{$lmCurrentSidebar}"])) {
			    $pageRegions["$pageTemplate"]["{$lmCurrentSidebar}"]["bg"] = "";
		  }
	
	  if (($className == "container-wrapper" || $className == "content-wrapper" || $className == "footer")  && $pageRegions["$pageTemplate"]["{$lmCurrentSidebar}"]["bg"] != "") {

		  
		  $bg = $pageRegions["$pageTemplate"]["{$lmCurrentSidebar}"]["bg"];
		  
		  // if no background is defined, then we assume it is the default (top most defined in the optional styled backgrounds array) style
		  if ($bg == "") { 
		    $bg = array_shift(array_keys(I3D_Framework::$optionalStyledBackgrounds));
		  }
		  
		  
		  $className .= " ".$bg;
		  
	  }
	  print "<div class='{$className}'>";	
	  // this is Denmark specific code to insert a short code that injects  
	  if (strstr($className, "insert-side-graphic")) {
		  print '<img class="side-pic-right"
        data-bottom="opacity: 1; margin-top:0px;"
        data-bottom-top="opacity: 0; margin-top:-100px;"
        data-top="opacity: 1; margin-top:0px;"
        data-top-bottom="opacity: 0; margin-top:500px;"

        src="'.get_stylesheet_directory_uri().'/Site/images/side-pic.png" alt="side pic"

        >';
	  }
	  
		if (strstr($className, "wrapper-tint")) {
		  print "<div class='wrapper tint1 padding-top-40 padding-bottom-80'>";	
		}
	  
	}
	//print "<div class='{$containerFluidClass}'>";
	//if ($secondLevelWrapperClass != "") {
	//	print "<div class='{$secondLevelWrapperClass}'>";
	//} 
	//print "<div class='{$secondLevelClass}'>";
  }

  ob_start();
  if ($defaultRegion != "" && $defaultRegion != "DEFAULT-CONTENT" && $defaultRegion != "DEFAULT-FOOTER") {
	// print "giving it a try {$defaultRegion}";
	 $fullRegionName = "i3d-widget-area-{$defaultRegion}{$extra}";

     if ((!function_exists('dynamic_sidebar') || !dynamic_sidebar($fullRegionName)) ) :
     endif;
	  
  } else {
	 // print "vv:".$fullRegionName;
    if (!function_exists('dynamic_sidebar') || !dynamic_sidebar($fullRegionName) ) :
	//  print "has: $hasDefaultRegion<br>";
	  if ($defaultRegion == "DEFAULT-CONTENT" && $hasDefaultRegion) {
		  if ($pageTemplate == "team-members") {
			 
		  } else if ($pageTemplate == "faqs") {
			 $auxPageID = get_option("page_for_faqs");  

		  } else if (get_post_type() == "i3d-portfolio-item") {

			} else {
			  $fullRegionName = "i3d-widget-area-{$possibleDefaultRegion}";
		  }
		  
		  if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("{$fullRegionName}") ) {}
	  
	  } else if ($defaultRegion == "DEFAULT-FOOTER" && $hasDefaultRegion) {
		  // print "yeah";
		  $fullRegionName = "i3d-widget-area-{$possibleDefaultRegion}";
		  if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("{$fullRegionName}") ) {}
		  
	  }
    endif;
  }
  $sidebarContents = ob_get_clean();
  
  print $sidebarContents;
  
  if ($fullscreen) {
     if (@$pageRegions["$pageTemplate"]["{$lmCurrentSidebar}"]["bg"] != "") {
		if (strstr($pageRegions["$pageTemplate"]["{$lmCurrentSidebar}"]["bg"], "wrapper-tint")) {
		  print "</div>";	
		}
		 
		print "</div>";
	 }  
   } else {
			if (strstr($pageRegions["$pageTemplate"]["{$lmCurrentSidebar}"]["bg"], "wrapper-tint")) {
		  print "</div>";	
		}
   
	foreach ($wrapperClasses as $className) {
	  print "</div>";	
	}	  
	//print "</div>";
	//if ($secondLevelWrapperClass != "") {
	//	print "</div>";
	// } 
		  I3D_Framework::condition($regionType);
	 // print "</div>";
  }
  if (strlen($sidebarContents) > 0 || $doNotCollapse) {
	//  print $sidebarContents;
	  print ob_get_clean();
  } else {
	  ob_end_clean();
	//  print ob_get_clean();
	  	 // print "no sidebar contents for $fullRegionName<br/>";

  }
  //print strlen($sidebarContents);
  }
}


class I3D_Walker_Nav_Menu extends Walker_Nav_Menu {
	//function I3D_Walker_Nav_Menu($menuType = "", $suppressIcons = 0, $defaultIcon = "") {
	function __construct($menuType = "", $suppressIcons = 0, $defaultIcon = "") { 
		$this->menuType = $menuType;
		//print "Menu type: $menuType";
		$this->suppressIcons = ($suppressIcons == 1);
		$this->defaultIcon = $defaultIcon;
	}
	
	
  
// add classes to ul sub-menus
function start_lvl( &$output, $depth = 0, $args = array() ) {
    // depth dependent classes
    $indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
    $display_depth = ( $depth + 1); // because it counts the first submenu as 0
    $classes = array(
        'sub-menu',
        ( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
        ( $display_depth >=2 ? 'sub-sub-menu' : '' ),
        'menu-depth-' . $display_depth
        );
    $class_names = implode( ' ', $classes );
  
    // build html
    $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
}


  
function end_el( &$output, $item, $depth = 0, $args = array() ) {
    // build html
	if ($this->menuType == "secondary-horizontal") {
		if (I3D_Framework::$navbarVersion == "5") {
			$output .= "</li>";
		} else {
	      $output .= "\n";		
		}

	} else if ($this->menuType == "tertiary-horizontal") {
	  $output .= "\n";
	} else if ($this->menuType == "primary-contact") {
	  $output .= "</li>";
		
	} else {
	
    //  $output .= apply_filters( 'walker_nav_menu_end_el', $depth, $args );
	}
	//print $output;
	return $output;
}
// add main/sub classes to li's and links
 function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
//	 var_dump($args);
    global $wp_query;
    $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
    // depth dependent classes
    $depth_classes = array(
        ( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
        ( $depth >=2 ? 'sub-sub-menu-item' : '' ),
        ( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
        'menu-item-depth-' . $depth
    );
    $depth_class_names = esc_attr( implode( ' ', $depth_classes ) );
  
    // passed classes
    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
	//var_dump($classes);
	foreach ($classes as $x =>$class) {
		if (strstr($class, "icon-") || strstr($class, "fa-")) {
			unset($classes["$x"]);
			if (strstr($class, "fa-")) {
				$class = "fa fa-fw ".$class;
			}
			
			$myIcon = I3D_Framework::conditionFontAwesomeIcon($class);
			/*
			if (I3D_Framework::$fontAwesomeVersion == "3") {
							$class = str_Replace("icon-info-sign", "icon-info-circle", $class);
							$myIcon = str_replace("icon-", "fa-", $class);
							
							$myIcon = "fa ".$myIcon;	
			} else {
							$myIcon = str_replace("fa-", "icon-", $class);

			}
			*/
		}
	}
	
	$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
    // build html
	//print "menu type".$this->menuType;
	if ($this->menuType == "secondary-horizontal") {
		if (I3D_Framework::$navbarVersion == "5") {
      $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';
			
		} else {
			$output .= $indent . '';
		}
      

	} else 	if ($this->menuType == "tertiary-horizontal") {
      $output .= $indent . '';


	} else if ($this->menuType == "primary-contact") { 
	//  print "yes";
      $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';
	
	} else if ($this->menuType == "sub-vertical") { 
	//  print "yes";
      $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '">';
	
	} else {
	//	print "nope:".$this->menuType."<br>";
      $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';
	}
	//var_dump($item);
    // link attributes
    $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
    $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
    $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
    $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
    $attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) .' '.($this->menuType == "sub-vertical" && ($item->url == '#' || $item->url == '') ? 'downarrow' : '').'"';
/*
} else if ($this->menuType == "sub-vertical") { 
      $output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . '">';
	//  print "yes";
	  if ($item->url == "#" || $item->url == "") { 
        $output .= $indent . '<li class="downarrow">';
	  
	  } else {
        $output .= $indent . '<li>';
		
	  }    
	  */
	$link_before = @$args->link_before;
	if (!isset($myIcon)) {
			   $myIcon = "";
	}

    $suppressIcons = $this->suppressIcons;
	if (($myIcon == "" || $this->suppressIcons) && $this->defaultIcon != "") {
		$class = $this->defaultIcon;
		if (strstr($class, "fa-")) {
				$class = "fa fa-fw ".$class;
			}
			
			$myIcon = I3D_Framework::conditionFontAwesomeIcon($class);	  
			$suppressIcons = false;
	}
	if ($myIcon != "" && !$suppressIcons) {
		if (I3D_Framework::$quickLinksVersion == "2" && $this->menuType == "secondary-vertical") {
			$output .= "<i class='{$myIcon}'></i> ";
		} else {
		  $link_before = "<i class='{$myIcon}'></i> ".$link_before;
		}
	}
	if (strstr($class_names, "shortcode") && $this->menuType == "primary-contact") {
		//print do_shortcode($item->description);
			$item_output = "<div class='form-menu-wrapper row-fluid'>".do_shortcode($item->description)."</div>"; 
			//print $item_output;
	} else {
		if (I3D_Framework::$primaryNavbarCanHaveSubtitle && $item->attr_title != "" && $this->menuType == "primary-horizontal") {
			 $item->title .= "<br><span>{$item->attr_title}</span>";
		} else {
		 
		}
	//	print $this->menuType;
		$item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
			@$args->before,
			$attributes,
			$link_before,
			apply_filters( 'the_title', $item->title, $item->ID ),
			@$args->link_after,
			@$args->after
		);
	}
	//print htmlspecialchars($item_output);
  
    // build html
	if ($this->menuType == "secondary-horizontal") {
      $output .= $item_output;
	} else if ($this->menuType == "tertiary-horizontal") {
      $output .= $item_output;

	} else if ($this->menuType == "primary-contact") {
	  $output .= $item_output;
	} else {
	
      $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

}
}


?>