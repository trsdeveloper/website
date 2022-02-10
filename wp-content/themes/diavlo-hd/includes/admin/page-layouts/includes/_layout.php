<?php
	global $i3dSupportedSidebars, $pagenow;
	
	$templateRegions 	= @I3D_Framework::$templateRegions["{$template}"];
	
	$pageRegions 		= get_post_meta($post->ID, "layout_regions", true);
	$widgetVisibility	= get_post_meta($post->ID, "widget_visibility", true);
	$layoutRegions 		= get_option("i3d_layout_regions");
	$sidebarWidgets 	= wp_get_sidebars_widgets();
	$regions 			= $i3dSupportedSidebars;
	
	if (!is_array($widgetVisibility)) {
		$widgetVisibility = array();
	}
	if (!is_array($pageRegions)) {
		$pageRegions = array();
	}
	if (!is_array($templateRegions)) {
		$templateRegions = array();
	}
	$generalSettings = wp_parse_args( (array) $generalSettings, array( 'mobile_responsive' => '',
																		  'tablet_responsive' => '') );
	$activeBackgrounds = (array)get_option('i3d_active_backgrounds');
	$optionalActiveBackgrounds = array();
	foreach ($activeBackgrounds as $key => $data) {
	  $optionalActiveBackgrounds["$key"] = $data['title'];
	}
	
?>
<p>While some regions are <span class='label label-warning'><i class='icon-lock'></i> locked</span> as per the design of the page, other areas are <span class='label label-success'><i class='icon-unlock'></i> unlocked</span> and may be configured with whatever sidebar and column layout you wish.</p>
<?php if ($generalSettings['mobile_responsive'] == "1" || $generalSettings['tablet_responsive'] == "1") { ?>
<p>In mobile view, "Empty Columns" will be hidden <span class='label label-danger'><i class='icon-remove'></i></span> by default.  You may choose to hide <span class='label label-danger'><i class='icon-remove'></i></span> or show <span class='label label-success'><i class='icon-ok'></i></span> any other unlocked region for mobile as you see fit.</p>
<?php } ?>
<div class='layout-table'>
	<div class='layout-table-inner'>
		<table class='table table-bordered layout-table'>
  			<tr class='info bolded'>
    			<td>Region</td>
    			<td>Configuration</td>
  			</tr>
<?php

	foreach ($templateRegions as $regionID => $regionInfo) { 
	//print $regionID;
		if ($regionInfo['type'] == "user-defined") { 
			if (!is_array($regionInfo['configuration']) || !array_key_exists('can-style-background', $regionInfo['configuration'])) {
								  
			} else {
				// the footer is only stylable if there are optional footer backgrounds, and the footer is set to allow styling
				if ($regionID == "footer" && 
					$regionInfo['configuration']['can-style-background'] === true && 
					is_array(I3D_Framework::$optionalStyledFooterBackgrounds) && 
					sizeof(I3D_Framework::$optionalStyledFooterBackgrounds) > 0) {
					
					$regionStylable = true;
				
				// all other regions are stylable if there are optional styled backgrounds, and region is set to allow styling
				} else {
					$regionStylable = $regionInfo['configuration']['can-style-background'] === true && 
										is_array(I3D_Framework::$optionalStyledBackgrounds) && 
										sizeof(I3D_Framework::$optionalStyledBackgrounds) > 0;
				}
			}
		}
								
		if (!isset($pageRegions["{$template}"]["{$regionID}"]["sidebar"])) {
			$pageRegions["{$template}"]["{$regionID}"]["sidebar"] = get_post_meta($post->ID, "i3d-widget-area-".$regionID, true);
			//$pageRegions["{$template}"]["{$regionID}"]["bg"] = "";
			if ($pageRegions["{$template}"]["{$regionID}"]["sidebar"] == "" && $pagenow == "post-new.php") {
				$pageRegions["{$template}"]["{$regionID}"]["sidebar"] = @$regionInfo['configuration']["default-sidebar"];
			} 
		} 
		if (!isset($pageRegions["{$template}"]["{$regionID}"]["bg"])) {
			
			$pageRegions["{$template}"]["{$regionID}"]["bg"] = "";
			
		}
		if (!isset($layoutRegions["{$template}"]["i3d-widget-area-{$regionID}"]["bg"])) {
		  $layoutRegions["{$template}"]["i3d-widget-area-{$regionID}"]["bg"] = "";	
		}
		if (!isset($regions["i3d-widget-area-{$regionID}"])) {
			$regions["i3d-widget-area-{$regionID}"] = array();
			$regions["i3d-widget-area-{$regionID}"]['name'] = "";
		}
		//print "x:".$pageRegions["{$template}"]["{$regionID}"]["bg"];
		//	var_dump($pageRegions["{$template}"]); 

?>
            <tr class='row__<?php echo "{$regionID}"; ?>'>
                <td style='width: 145px; padding-top: 13px;'>
                	<span class='tt' data-toggle="tootip" title="<?php echo $regionInfo['description']; ?>"><?php if ($regions["i3d-widget-area-{$regionID}"]['name'] == "" && $regionInfo['type'] != "user-defined-divider") { echo ucwords(str_replace("-" , " ", $regionID)).""; } else { echo $regions["i3d-widget-area-{$regionID}"]['name'].""; }  if ($regionInfo['type'] == "user-defined-divider") { echo "<span class='divider-region'>"; _e("Divider","i3d-framework"); print "</span>"; } ?> </span>
<?php 	if ($regionInfo['type'] == "pre-defined") { ?>
                    <span class='label label-warning tt pull-right text-center'   data-toggle='tooltip' title='Locked: This region is pre-defined.  You can configure the settings for the elements within, but you may not change what those elements are.'><i class='icon-lock'></i></span>
<?php 	} else if ($regionInfo['type'] == "user-defined-divider") { ?>
					<!-- <span class='label label-success tt pull-right text-center' style='width: 13px;' data-toggle='tooltip' title='Divider: This region is user-defined.  You can specify an optional divider for this region.'><i class='icon-unlock'></i></span>-->
<?php 	} else { ?>
					<span class='label label-success tt pull-right text-center' data-toggle='tooltip' title='Unlocked: This region is user-defined.  You can specify the sidebar as we well as the column layout for this region.'><i class='icon-unlock'></i></span>
<?php 	} ?>
				</td>
				<td>
<?php 	if ($regionInfo['type'] == "user-defined-divider") { ?>
					<div class='text-center'>
                		<div class="input-group tt input-group-collapsed" title="Divider Style">
        					<span class="input-group-addon"><i class='icon-minus'></i></span>
							<select class='form-control layout-bg-select' id="__i3d_layout_regions__<?php echo $template; ?>__<?php echo $regionID; ?>__bg" name="__i3d_layout_regions__<?php echo $template; ?>__<?php echo $regionID; ?>__bg">
							<?php echo i3d_renderSelectOptions($regionInfo['configuration'], ($pageRegions["{$template}"]["{$regionID}"]["bg"] == "" ? $layoutRegions["{$template}"]["i3d-widget-area-{$regionID}"]["bg"] : $pageRegions["{$template}"]["{$regionID}"]["bg"])); ?>
                    		</select>
                    	</div>
                    </div>                     
<?php	} else { 
			if ($regionInfo['type'] == "user-defined") { ?>
  					<div class='row clearfix'>
                		<div class='col-sm-<?php if ($regionStylable) { print "3"; } else { print "4"; } ?>'>
                    		<div class="input-group pull-left tt" title="Sidebar associated with this Region">
        						<span class="input-group-addon"><i class='icon-link'></i></span>
								<select class="__i3d_layout_regions__<?php echo $template; ?>__<?php echo $regionID; ?>__sidebar layout-sidebar-select form-control" name="__i3d_layout_regions__<?php echo $template; ?>__<?php echo $regionID; ?>__sidebar" onchange='handleSidebarChange(this)'><?php display_sidebar_options2($pageRegions["{$template}"]["{$regionID}"]["sidebar"], @$regionInfo['configuration']["default-sidebar"]); ?></select>
                    		</div>     
                    	</div>
<?php 			if ($regionStylable) { ?>
						<div class='text-center col-sm-3 visible-when-sidebar-exists <?php if ($pageRegions["{$template}"]["{$regionID}"]["sidebar"] == "" || $pageRegions["{$template}"]["{$regionID}"]["sidebar"] == "x") { print "non-visible"; } ?>'>
                			<div class="input-group tt" title="Background Style">
        						<span class="input-group-addon"><i class='icon-tint'></i></span>
								<?php
								//var_dump(I3D_Framework::$optionalStyledBackgrounds);
							
								?>
								<select class='layout-bg-select form-control' id="__i3d_layout_regions__<?php echo $template; ?>__<?php echo $regionID; ?>__bg" name="__i3d_layout_regions__<?php echo $template; ?>__<?php echo $regionID; ?>__bg">
<?php 				if ($regionID == "footer" && 
						@$regionInfo['configuration']['can-style-background'] === true && 
						is_array(I3D_Framework::$optionalStyledFooterBackgrounds) && 
						sizeof(I3D_Framework::$optionalStyledFooterBackgrounds) > 0) {
						
						echo i3d_renderSelectOptions(I3D_Framework::$optionalStyledFooterBackgrounds, ($pageRegions["{$template}"]["{$regionID}"]["bg"] == "" ? $layoutRegions["{$template}"]["i3d-widget-area-{$regionID}"]["bg"] : $pageRegions["{$template}"]["{$regionID}"]["bg"])); 
					
					} else {
						
						echo i3d_renderSelectOptions(array_merge(I3D_Framework::$optionalStyledBackgrounds, (array)$optionalActiveBackgrounds), ($pageRegions["{$template}"]["{$regionID}"]["bg"] == "" ? $layoutRegions["{$template}"]["i3d-widget-area-{$regionID}"]["bg"] : $pageRegions["{$template}"]["{$regionID}"]["bg"])); 
					} ?>
                    			</select>
                    		</div>
                    	</div>
<?php 			} ?> 
				<div class='text-center col-sm-<?php if ($regionStylable) { print "3"; } else { print "4"; } ?> visible-when-sidebar-exists <?php if ($pageRegions["{$template}"]["{$regionID}"]["sidebar"] == "" || $pageRegions["{$template}"]["{$regionID}"]["sidebar"] == "x") { print "non-visible"; } ?>'>
                	<div class="input-group tt" title="Number of Columns">
        				<span class="input-group-addon"><i class='icon-columns'></i></span>
						<select class='layout-columns-select form-control' id="__i3d_layout_regions__<?php echo $template; ?>__<?php echo $regionID; ?>__columns" name="__i3d_layout_regions__<?php echo $template; ?>__<?php echo $regionID; ?>__columns">
                    	<?php echo i3d_renderSelectOptions(array("1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5", "6" => "6"), (@$pageRegions["{$template}"]["{$regionID}"]["columns"] == "" ? @$layoutRegions["{$template}"]["i3d-widget-area-{$regionID}"]["columns"] : @$pageRegions["{$template}"]["{$regionID}"]["columns"])); ?>
                    	</select>
                    </div>
                </div>
                <div class='col-sm-<?php if ($regionStylable) { print "3"; } else { print "4"; } ?> visible-when-sidebar-exists <?php if ($pageRegions["{$template}"]["{$regionID}"]["sidebar"] == "" || $pageRegions["{$template}"]["{$regionID}"]["sidebar"] == "x") { print "non-visible"; } ?>'>
                    <div class="pull-right input-group tt" title="Region Width: Either Full-Screen, or Contained">
						<span class="input-group-addon"><i class='icon-resize-horizontal'></i></span>
                        <select class='layout-width-select form-control' id="__i3d_layout_regions__<?php echo $template; ?>__<?php echo $regionID; ?>__width" name="__i3d_layout_regions__<?php echo $template; ?>__<?php echo $regionID; ?>__width">
                        <?php echo i3d_renderSelectOptions(array("contained" => "Contained", "fullscreen" => "Full Screen"), (@$pageRegions["{$template}"]["{$regionID}"]["width"] == "" ? @$layoutRegions["{$template}"]["i3d-widget-area-{$regionID}"]["width"] : $pageRegions["{$template}"]["{$regionID}"]["width"])); ?>
                        </select>  
                    </div>     
                </div>
            </div> 
<?php 		} ?>                     
            <div class='row-fluid visible-when-sidebar-exists <?php if ((@$pageRegions["{$template}"]["{$regionID}"]["sidebar"] == ""  || $pageRegions["{$template}"]["{$regionID}"]["sidebar"] == "x") && $regionInfo['type'] == "user-defined") { print "non-visible"; } ?>'>
<?php 		if ($regionInfo['type'] == "pre-defined") { 
				foreach ($regionInfo['configuration'] as $column) { 
					if (!is_array($column)) {
						$column = array();
					}
					if (!array_key_exists('widgets', $column)) {
						$regionInfo['configuration']['widgets'] = array();
						$column['widgets'] 						= array();
					} ?>
                <div class='col-sm-<?php echo $column['span']; ?> text-center'>
				  <div class='alert alert-success alert-margined'>
<?php 				foreach ($column['widgets'] as $widget) { 
						$widgetID = $regionID."__".$widget['class_name'];
						if ($widget['class_name'] == "I3D_Widget_Menu") {
							$myWidget = new I3D_Widget_Menu();
						  
						} else if ($widget['class_name'] == "I3D_Widget_ContactFormMenu") {
							$myWidget = new I3D_Widget_ContactFormMenu();
						  
						} else if ($widget['class_name'] == "I3D_Widget_Logo") {
							$myWidget = new I3D_Widget_Logo();
						  
						} else if ($widget['class_name'] == "I3D_Widget_SocialMediaIconShortcuts") {
							$myWidget = new I3D_Widget_SocialMediaIconShortcuts();
						  
						} else if ($widget['class_name'] == "I3D_Widget_SearchForm") {
							$myWidget = new I3D_Widget_SearchForm();
						
						} else if ($widget['class_name'] == "I3D_Widget_SliderRegion") {
							$myWidget = new I3D_Widget_SliderRegion();
						  
						} else if ($widget['class_name'] == "I3D_Widget_ContentRegion") {
							$myWidget = new I3D_Widget_ContentRegion();
							
						} else if ($widget['class_name'] == "I3D_Widget_SEOTags") {
							$myWidget = new I3D_Widget_SEOTags();
							
						} else if ($widget['class_name'] == "I3D_Widget_GoogleMap") {
							$myWidget = new I3D_Widget_GoogleMap();
						  
						} else {
							$myWidget = new stdClass();
						}
						echo str_replace("i3d:", "", $myWidget->name);
					} ?>
					</div>
                </div>
<?php 			} ?>
			</div>
<?php 		} else { ?>
			<input class="input-mini layout-holder" type="hidden"  id="__i3d__layout_regions__<?php echo $template; ?>__<?php echo $regionID; ?>__layout" name="__i3d_layout_regions__<?php echo $template; ?>__<?php echo $regionID; ?>__layout" value="<?php echo @$pageRegions["{$template}"]["{$regionID}"]["layout"] == "" ? @$layoutRegions["{$template}"]["i3d-widget-area-{$regionID}"]["layout"] : @$pageRegions["{$template}"]["{$regionID}"]["layout"] ; ?>" />
			<div data-toggle="tooltip" class="slider-range"></div>
			<div class='row region-widgets'>
<?php 		 
				$spanCount = 0;
				$mySidebar = $pageRegions["{$template}"]["{$regionID}"]["sidebar"];
				if (is_array(@$sidebarWidgets["{$mySidebar}"])) {
					foreach ($sidebarWidgets["{$mySidebar}"] as $wid) { 
						if ($spanCount == 0) {
							$spanCount++; ?>  
				<div class='example-span'> 
<?php						if (@$wp_registered_widgets["$wid"]['callback'][0]->id_base == "i3d_columnbreak") { ?>
					<div class='alert alert-warning text-center'>Empty Column
<?php 						if ($generalSettings['mobile_responsive'] == "1") { ?>
						<div title='Default Mobile Visibility' class="toggle-group btn-group pull-right tt">
							<button disabled onclick='alert("This setting may not be changed"); return false' class="btn btn-danger"><i class='icon-mobile-phone'></i> &nbsp; <i class="icon-remove"></i></button>
						</div>
<?php 							} ?>
					</div>
				</div>
				<div class='example-span'>
<?php 						}
						} else if ($wp_registered_widgets["$wid"]['callback'][0]->id_base == "i3d_columnbreak") {
						$spanCount++; ?>
				</div>
                <div class='example-span'> 
<?php					}
				   
						if (@$wp_registered_widgets["$wid"]['callback'][0]->id_base == "i3d_columnbreak") {
							continue;
						} ?>
					<div class='alert alert-info text-center <?php echo @$wp_registered_widgets["$wid"]['callback'][0]->id_base; ?>'><?php echo str_replace("i3d:", "", @$wp_registered_widgets["$wid"]['callback'][0]->name); ?>
						<input type='hidden' id="__i3d_widget_visibility__<?php echo $template; ?>__<?php echo $wid; ?>" name="__i3d_widget_visibility__<?php echo $template; ?>__<?php echo $wid; ?>" value='<?php echo @$widgetVisibility["$template"]["$wid"]; ?>' class='<?php echo @$widgetVisibility["$template"]["$wid"]; ?>' />
<?php					if ($generalSettings['mobile_responsive'] == "1") { ?>
						<div title='Mobile Visibility' class="toggle-group btn-group pull-right tt">
    						<button id="__i3d_widget_visibility__<?php echo $template; ?>__<?php echo $wid; ?>__mobile"  class="btn <?php if (strstr(@$widgetVisibility["$template"]["$wid"], "hidden-xs")) { print "btn-danger"; } else { print "btn-success"; } ?>" onclick='toggleWidgetVisibility("mobile", "<?php echo $wid; ?>", "<?php echo $template; ?>"); return false;'><i class='icon-mobile-phone'></i></button>
    						<button class="btn dropdown-toggle <?php if (strstr(@$widgetVisibility["$template"]["$wid"], "hidden-xs")) { print "btn-danger"; } else { print "btn-success"; } ?>" data-toggle="dropdown">
    							<span class='<?php if (strstr(@$widgetVisibility["$template"]["$wid"], "hidden-xs")) { print "icon-remove"; } else { print "icon-ok"; } ?>'></span>
    						</button>
    						<ul class="dropdown-menu">
                                <!-- dropdown menu links -->
                                <li><a href="javascript:setWidgetVisibility('mobile', '<?php echo $wid; ?>', '<?php echo $template; ?>', true)">On</a></li>
                                <li><a href="javascript:setWidgetVisibility('mobile', '<?php echo $wid; ?>', '<?php echo $template; ?>', false)">Off</a></li>
                            </ul>
    					</div>
<?php 					} 
                 
						if ($generalSettings['tablet_responsive'] == "1") {  ?>
						<div title='Tablet Visibility' class="toggle-group btn-group pull-right tt" style='margin-right: 5px;'>
    						<button id="__i3d_widget_visibility__<?php echo $template; ?>__<?php echo $wid; ?>__tablet"  class="btn <?php if (strstr($widgetVisibility["$template"]["$wid"], "hidden-sm")) { print "btn-danger"; } else { print "btn-success"; } ?>" onclick='toggleWidgetVisibility("tablet", "<?php echo $wid; ?>", "<?php echo $template; ?>"); return false;'><i class='icon-tablet'></i></button>
                            <button class="btn dropdown-toggle  <?php if (strstr($widgetVisibility["$template"]["$wid"], "hidden-sm")) { print "btn-danger"; } else { print "btn-success"; } ?>" data-toggle="dropdown">
                            	<span class='<?php if (strstr($widgetVisibility["$template"]["$wid"], "hidden-sm")) { print "icon-remove"; } else { print "icon-ok"; } ?>'></span>
                            </button>
                            <ul class="dropdown-menu">
                                <!-- dropdown menu links -->
                                <li><a href="javascript:setWidgetVisibility('tablet', '<?php echo $wid; ?>', '<?php echo $template; ?>', true)">On</a></li>
                                <li><a href="javascript:setWidgetVisibility('tablet', '<?php echo $wid; ?>', '<?php echo $template; ?>', false)">Off</a></li>
                            </ul>
                        </div>
						<div style='clear: both;'></div> 	   
<?php 					} ?>
                    </div>
				   
<?php 				} 
				
					if ($spanCount > 0) { ?>
					</div>
<?php 				}
				} else { ?>
						<div class='alert alert-error text-center'>This sidebar does not yet have any widgets in it.</div>
<?php 			} 
			} ?>
					</div>                   
<?php 	} ?>
                </td>
            </tr>                                  
<?php } ?>
        </table>
        <div class='clearfix'></div>
	</div>

</div>