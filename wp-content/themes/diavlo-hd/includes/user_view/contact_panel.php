<?php
function i3d_render_contact_panel($instance = array()) {
	global $settingOptions;
	global $page_id;
	
	if (I3D_Framework::use_global_layout()) {
	
		$contactPanelPageSettings = array();
		$sidebar = "";

		$page_layouts 		= (array)get_post_meta($page_id, "layouts", true);
		$page_layout_id 	= get_post_meta($page_id, "selected_layout", true);
		$row_id = @$instance['row_id'];
		$widget_id = @$instance['widget_id'];
		
		$page_level_sidebar = @$page_layouts["$page_layout_id"]["$row_id"]["configuration"]["$widget_id"]["sidebar"];
		global $wp_registered_sidebars;
		
		if (array_key_exists($page_level_sidebar, $wp_registered_sidebars)) {
		  $sidebar = $page_level_sidebar;	
		} else {
		  $sidebar = $instance['sidebar'];
		}
		
	$sidebarWidgets 	= wp_get_sidebars_widgets();
	$spanCount = 0;
	global $wp_registered_widgets;
				if (is_array(@$sidebarWidgets["{$sidebar}"])) {
					
					foreach ($sidebarWidgets["{$sidebar}"] as $wid) { 
						if ($spanCount == 0) {
							$spanCount++;
						} else if ($wp_registered_widgets["$wid"]['callback'][0]->id_base == "i3d_columnbreak") {
						  $spanCount++;
						}
					}
				}
				global $global_span_width;
				$global_span_width = I3D_Framework::$default_contact_panel_width["$spanCount"];
				
		//print $spanCount;
		//var_dump($page_layouts);
		//print "page_level_sidebar: {$page_level_sidebar}<br>";
		//print "box_style: ".$instance['box_style']."<br>";
		//print htmlentities($before_widget);
		//$before_widget = str_replace("i3d-opt-box-style", $instance['box_style'], $before_widget);
		
		//echo $before_widget;
		/*
		  $lmCurrentSidebar = $page_level_sidebar;
		  if ($page_level_sidebar == "" || !dynamic_sidebar($page_level_sidebar)) {
			$lmCurrentSidebar = $instance['sidebar'];
			if (!dynamic_sidebar($instance['sidebar'])) {
			  print "No Sidebar Selected";	
			}
		  }
		}*/
		//if ($possible_page_level_sidebar != "" && 
		//if (!function_exists('dynamic_sidebar') || !dynamic_sidebar(array_shift(get_post_meta($myPageID, 'luckymarble-left-widget-area')))) :
		//endif;

		//print "sidebar should go here: {$instance['sidebar']}";
		//i3d_post_content($instance['page']);
		//print "-- dynamic sidebar before after widget --";
		//echo $after_widget;
		//print "-- dynamic sidebar after after widget --";		
		
		
	} else {
		$sidebar = "header-top";
		$contactPanelPageSettings = get_post_meta($page_id, "contact_panel", true);
	}
	
	$settingOptions = wp_parse_args( (array) $settingOptions, array( 'contact_panel_enabled' => '','contact_panel_icon' => '', 'contact_panel_icon_set' => '', 'contact_panel_icon_close' => '', 'contact_panel_icon_close_set' => '') );
	$panelOn = false;

	if (!is_array($contactPanelPageSettings)) {
	  $contactPanelPageSettings = array();	
	}
	
	if (!array_key_exists("show", $contactPanelPageSettings)) {
		$contactPanelPageSettings['show'] 					= "";
		$contactPanelPageSettings['icon'] 		= "";
		$contactPanelPageSettings['icon_close'] = "";
	}

	if ($settingOptions['contact_panel_enabled'] == "x") {
		$panelOn = false;
	} else if (($settingOptions['contact_panel_enabled'] == "globally" || $settingOptions['contact_panel_enabled'] == "") && $contactPanelPageSettings['show'] == "") {
		$panelOn = true;
	} else if ($contactPanelPageSettings['show'] == "always") {
		$panelOn = true;
	}


	if ($panelOn) { 
  		// blank is default
		if (@$contactPanelPageSettings['icon'] == "") { 
			$contactPanelIcon = $settingOptions['contact_panel_icon'];
			if ($contactPanelIcon == "" && $settingOptions['contact_panel_icon_set'] == "") {
				$contactPanelIcon = "fa fa-envelope-o";
			} else if ($contactPanelIcon == "") {
				$contactPanelIcon = "";
			} else {
			}

		} else if ($contactPanelPageSettings['icon'] == "x") {
			$contactPanelIcon = "";	  
		} else {
			$contactPanelIcon = $contactPanelPageSettings['icon'];
		}
  
  		if (@$contactPanelPageSettings['icon_close'] == "") { 
			$contactPanelIconClose = $settingOptions['contact_panel_icon_close'];
			if ($contactPanelIconClose == "" && $settingOptions['contact_panel_icon_set'] == "") {
				$contactPanelIconClose = "fa fa-envelope";
			} else if ($contactPanelIcon == "") {
				$contactPanelIconClose = "";
			} else {
			  // just use whatever is stored in the variable
			}
		} else if ($contactPanelPageSettings['icon_close'] == "x") {
			$contactPanelIconClose = "";
		} else {
			$contactPanelIconClose = $contactPanelPageSettings['icon_close'];
		}  
	
		ob_start();
?>
<div class="contact-panel-wrapper">
<!-- contact-panel -->
<div id="topcontact-panel">
	<div id="contact-panel">
	<?php 
		ob_start();
		if (I3D_Framework::use_global_layout()) {
			echo "<div class='container'>";
		  	dynamic_sidebar($sidebar);
			echo "</div>";
		} else {
			i3d_show_widget_region($sidebar, array("container")); 
		}
		$output = ob_get_clean();
		echo $output;
	?>	
    <div style='clear: both;'>&nbsp;</div>
	</div>

	<!-- open/contact-close open-contact-close-tab -->
	<div class="open-contact-close-tab">
		<ul class="login">
			<li id="toggle">
				<a id="open" class="open" href="#"><?php if (I3D_Framework::$contactPanelVersion == 1) { ?><i class="fa <?php echo $contactPanelIcon; ?>"></i><?php } ?></a>
				<a id="contact-close" style="display: none;" class="contact-close" href="#"><?php if (I3D_Framework::$contactPanelVersion == 1) { ?><i class="fa <?php echo $contactPanelIconClose; ?>"></i><?php } ?></a>
			</li>
		</ul>
	</div>
	<!-- open/contact-close open-contact-close-tab -->
</div>

</div>
<?php
		if ($output == "") {
			ob_end_clean();
		} else {
			echo ob_get_clean();
		}
	} 
	//print "end";
}
?>