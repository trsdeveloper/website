<?php function luckymarble_custom_components() { 
 global $lmUsesCustomComponentRegions;
 global $customComponentSidebars;
 global $myPageID;
 
 if ($lmUsesCustomComponentRegions) { 
   foreach ($customComponentSidebars as $sidebarID => $sidebarName) { 
     $widgetSidebar = get_post_meta($myPageID, $sidebarID, true);
	 
	 if ($widgetSidebar != "") {
		$positionTop = get_post_meta($myPageID, $sidebarID."_top", true);
		$positionHPositioning = get_post_meta($myPageID, $sidebarID."_hpositioning", true);
		$positionHPosition = get_post_meta($myPageID, $sidebarID."_hposition", true);
		if ($positionTop != "" && $positionHPosition != "") {
			$divID = "custom_component".str_replace("luckymarble-custom-component-", "", str_replace("-widget-area", "", $sidebarID));
			print "\n<!-- {$divID} -->\n";
			print "<div style='z-index: 1000; position: absolute; right:auto; left:auto; top: {$positionTop}px; {$positionHPositioning}: {$positionHPosition}px;' id='{$divID}'>\n";
			  dynamic_sidebar($widgetSidebar);
			print "\n</div>\n";
		} else {
						$divID = "custom_component".str_replace("luckymarble-custom-component-", "", str_replace("-widget-area", "", $sidebarID));
			print "\n<!-- {$divID} -->\n";
			print "<div style='position: absolute;' id='{$divID}'>\n";
			  dynamic_sidebar($widgetSidebar);
			print "\n</div>\n";
			print "<!-- /custom_component -->\n";
		}
	 }
   }
 } 
}?>