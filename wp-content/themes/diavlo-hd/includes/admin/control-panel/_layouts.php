<?php 
function i3d_render_mobile_tablet_visibility_options($row, $row_id, $wid) {
	$generalSettings = get_option("i3d_general_settings");	  
	?>
	<span rel='<?php echo $wid; ?>'>
	<input rel='visibility' type='hidden' id="<?php echo $row_id; ?>__visibility__<?php echo $wid; ?>" name="<?php echo $row_id; ?>__visibility__<?php echo $wid; ?>" value='<?php echo @$row['visibility']["$wid"]; ?>' class='<?php echo @$row['visibility']["$wid"]; ?>' />
    </span>
<?php				
if (@$generalSettings['mobile_responsive'] == "1") { ?>
						<div title='Mobile Visibility' class="toggle-group btn-group tt2">
    						<button id="<?php echo $row_id; ?>__visibility__<?php echo $wid; ?>__mobile"  class="btn <?php if (strstr(@$row['visibility']["$wid"], "hidden-xs")) { print "btn-danger"; } else { print "btn-success"; } ?>" onclick='toggleWidgetVisibility("mobile", "<?php echo $wid; ?>", "<?php echo $row_id; ?>"); return false;'><i class='fa fa-fw fa-mobile'></i></button>
    						<button class="btn dropdown-toggle <?php if (strstr(@$row['visibility']["$wid"], "hidden-xs")) { print "btn-danger"; } else { print "btn-success"; } ?>" data-toggle="dropdown">
    							<span class='<?php if (strstr(@$row['visibility']["$wid"], "hidden-xs")) { print "icon-remove"; } else { print "icon-ok"; } ?>'></span>
    						</button>
    						<ul class="dropdown-menu widget-visibility-dropdown">
                                <!-- dropdown menu links -->
                                <li><a href="javascript:setWidgetVisibility('mobile', '<?php echo $wid; ?>', '<?php echo $row_id; ?>', true)">On</a></li>
                                <li><a href="javascript:setWidgetVisibility('mobile', '<?php echo $wid; ?>', '<?php echo $row_id; ?>', false)">Off</a></li>
                            </ul>
    					</div>
<?php 					} 
                 
						if (@$generalSettings['tablet_responsive'] == "1") {  ?>
						<div title='Tablet Visibility' class="toggle-group btn-group tt2">
    						<button id="<?php echo $row_id; ?>__visibility__<?php echo $wid; ?>__tablet"  class="btn <?php if (strstr(@$row['visibility']["$wid"], "hidden-sm")) { print "btn-danger"; } else { print "btn-success"; } ?>" onclick='toggleWidgetVisibility("tablet", "<?php echo $wid; ?>", "<?php echo $row_id; ?>"); return false;'><i class='fa fa-fw fa-tablet'></i></button>
                            <button class="btn dropdown-toggle  <?php if (strstr(@$row['visibility']["$wid"], "hidden-sm")) { print "btn-danger"; } else { print "btn-success"; } ?>" data-toggle="dropdown">
                            	<span class='<?php if (strstr(@$row['visibility']["$wid"], "hidden-sm")) { print "icon-remove"; } else { print "icon-ok"; } ?>'></span>
                            </button>
                            <ul class="dropdown-menu widget-visibility-dropdown">
                                <!-- dropdown menu links -->
                                <li><a href="javascript:setWidgetVisibility('tablet', '<?php echo $wid; ?>', '<?php echo $row_id; ?>', true)">On</a></li>
                                <li><a href="javascript:setWidgetVisibility('tablet', '<?php echo $wid; ?>', '<?php echo $row_id; ?>', false)">Off</a></li>
                            </ul>
                        </div>
<?php 					} ?>
<?php } // end of function ?>
<?php
function i3d_layouts() { 

	if (@$_GET['cmd'] == "revert" && @$_GET['layout'] != "") {
		I3D_Framework::revert_layout(@$_GET['layout']);
		wp_redirect(admin_url("admin.php?page=i3d_layouts&action=edit&layout={$_GET['layout']}"));
	}
	
	if (@$_GET['cmd'] == "reset") {
		update_option('i3d_layouts', array());
		I3D_Framework::init_layouts(true);
		wp_redirect(admin_url("admin.php?page=i3d_layouts"));
	
   } else if (@$_GET['cmd'] == "init") {
		I3D_Framework::init_layouts(true);
		wp_redirect(admin_url("admin.php?page=i3d_layouts"));
 
	} else if (@$_GET['cmd'] == "new" && @$_POST['cmd2'] != __('Cancel', "i3d-framework")) {
		i3d_create_layout();
		return;
	} else if (@$_GET['action'] == "copy") {
		$layouts = get_option('i3d_layouts');
		$layout = @$_GET['layout'];
		$id = I3D_Framework::get_unique_id("i3d_layout");
		if (!array_key_exists($id, $layouts)) {
		  	$layouts["$id"] = $layouts["$layout"];
			$layouts["$id"]["title"] = $layouts["$id"]["title"]." (Copy)";	
			$layouts["$id"]["id"] = $id;	
			$layouts["$id"]["is_default"] = false;	
			update_option('i3d_layouts', $layouts);
			wp_redirect(admin_url("admin.php?page=i3d_layouts"));

		} else {
			wp_redirect(admin_url("admin.php?page=i3d_layouts&error=Could not copy layout.  Please try again."));
		}	
	} else if (@$_GET['action'] == "set_as_default") { 
		$layouts = get_option('i3d_layouts');
		$layout = @$_GET['layout'];
		if (is_array($layouts)) {
			foreach ($layouts as $lid => $lay) {
			  $layouts["$lid"]["is_default"] = false;	
			}
			//print "[$layout]";
			$layouts["$layout"]["is_default"] = true;
		  	//var_dump($layouts);
			update_option('i3d_layouts', $layouts);
		} 
			wp_redirect(admin_url("admin.php?page=i3d_layouts"));
	   
	
	} else if (@$_POST['cmd2'] == __('Cancel', "i3d-framework")) {
	
		wp_redirect(admin_url("admin.php?page=i3d_layouts"));
	
	} else if (@$_GET['layout'] != "") {
		if (@$_GET['action'] == "trash") {
			$layouts = get_option('i3d_layouts');
			if ($layouts["{$_GET['layout']}"]["is_default"]) {
				wp_redirect(admin_url("admin.php?page=i3d_layouts&msg=You%20cannot%20delete%20the%20default%20layout!%20%20Please%20set%20another%20layout%20as%20default%20first."));
			//  $error = "";	
			} else {
			unset($layouts[$_GET['layout']]);
			update_option('i3d_layouts', $layouts);
			wp_redirect(admin_url("admin.php?page=i3d_layouts"));
			}
	
		} else {
			i3d_layout_editor($_GET['layout']);
			return;
		}

	} else if (@$_POST['layout'] != "") {
		i3d_layout_editor(@$_POST['layout']); 
		return;
	}
  
	$layouts = get_option('i3d_layouts');
	if (!is_array($layouts)) {
		$layouts = array();
	}
  //  unset($layouts['']);
	//		update_option('i3d_layouts', $layouts);
	
    uasort($layouts, 'i3d_sort_layouts');
//var_dump($layouts);
    $pages = get_pages();
	
	foreach ($pages as $page) {
	   	$selected_layout =  get_post_meta($page->ID, "selected_layout", true);
		if ($selected_layout == "" || !array_key_exists($selected_layout, $layouts)) {
	  		$selected_layout = I3D_Framework::get_default_layout_id($page->ID);	
		}
	    if (array_key_exists($selected_layout, $layouts)) {
			$layouts["$selected_layout"]["pages"][] = $page;
		}
	}
?>
<script>
jQuery(document).ready( function () {
jQuery('.i3d-layout-infographic').slimScroll({
        height: 'auto',
		size: '3px',
		color: '#aaaaaa'
		
	/*	alwaysVisible: true */
    });
								  });
</script>
  <div class='wrap'>
  <h2>Layout Editor <a class="add-new-h2" href="admin.php?page=i3d_layouts&cmd=new">Add New</a></h2>
    <p>With the Layout Editor, you can change how different groups of pages are displayed, globally.</p>
   
<?php if (sizeof($layouts) == 0) { ?>
  				<div class='alert alert-info text-center'>There are currently no Layouts created.  Click "add new" at the top of the page to create a Layout.</div>
<?php } else if (@$_GET['msg'] != "") { ?>
  				<div class='alert alert-danger text-center'><?php echo $_GET['msg']; ?></div>

<?php }
$groups = array();
foreach ($layouts as $id => $layout) {
	  // var_dump($layouts);
	   if (@$layout['group'] == "") {
		   $idInfo = explode("-", $id);
		   if ($id == "under-construction") {
			  $layout['group'] = "under-construction";
			  $layout['group-name'] = "Under Construction";
		   } else if ($idInfo[0] == "default") {
			  $layout['group'] = 'minimized';
			  $layout['group-name'] = "Minimized";
		   } else {
		   		$layout['group'] = $idInfo['0'];
		   
		  	 	$layout['group-name'] = ucwords($idInfo['0']);
		   }
		   
		   $layouts["$id"] = $layout;
	   }
	   $groupID = $layout['group'];
	   $groups["{$groupID}"] = $layout['group-name'];
}

		  wp_enqueue_script( 'jquery-isotope-portfolio', 		get_stylesheet_directory_uri()."/includes/admin/control-panel/js/jquery.isotope.min.js", array('jquery'), '1.0' );
		  wp_enqueue_script( 'jquery-easing', 		 get_stylesheet_directory_uri()."/includes/admin/control-panel/js/jquery.easing.min.js", array('jquery'), '1.0' );
		 // wp_enqueue_script( 'jquery-waitforimages', get_stylesheet_directory_uri()."/Site/javascript/jquery/jquery.waitforimages.min.js", array('jquery'), '1.0' );

?>

	<div id="isotope-buttons">
		<a href="#" data-filter="*" class="active">Show All</a>
        <?php foreach ($groups as $index => $group) { 
		
		?>
		<a href="#" data-filter=".group-<?php echo $index; ?>" class=""><?php echo $group; ?></a>
		<?php } ?>
	</div>
<div id="isotope-container" class="ufilter">
	<div class="">
		<div id="isotope-portfolio">

<?php foreach ($layouts as $id => $layout) {

	    
	?>
    <div class='col-xs-6 col-md-4 col-lg-3 isotope-item group-<?php echo $layout['group']; ?>'>
     <div class='panel panel-default'>
	   <div class='panel-heading'><strong><?php echo $layout['title']; ?></strong>
	   <?php if (@$layout['is_default']) { print "<span data-placement='bottom' class='label label-primary label-default-layout tt' title=\"When a layout is set as DEFAULT, any page that is not explcitly defined as having had a layout assigned, uses this layout.  This is often the case for third-party plugins which have 'views', such as a calendar, or events plugin.  Note: you cannot delete a layout if it is set as default.\">Default</span>"; } ?>
	   
	   <span class='badge badge-info pull-right'><?php echo @count(@$layout['pages']) ?> page<?php if (@count(@$layout['pages']) != 1) { print "s"; } ?></span>
	   </div>
	   <div class='panel-body' style='min-height: 175px;'>
	   <?php I3D_Framework::render_layout_infographic($layout['id']); ?>
	 
	   </div>
	   <div class='panel-footer'><a class='btn btn-success btn-xs' title="Edit this item" href="?page=i3d_layouts&layout=<?php echo $layout['id']; ?>&amp;action=edit">Edit</a> 
	   <a class='btn btn-default btn-xs' title="Copy this layout" href="?page=i3d_layouts&layout=<?php echo $layout['id']; ?>&amp;action=copy">Copy</a> 
	   <?php if (!@$layout['is_default']) { 
	   ?><a class='btn btn-primary btn-xs tt' title="When a layout is set as DEFAULT, any page that is not explcitly defined as having had a layout assigned, uses this layout.  This is often the case for third-party plugins which have 'views', such as a calendar, or events plugin." href="?page=i3d_layouts&layout=<?php echo $layout['id']; ?>&amp;action=set_as_default">Set As Default</a> 
	   
	   <a class='btn btn-danger btn-xs pull-right' href="?page=i3d_layouts&layout=<?php echo $layout['id']; ?>&amp;action=trash" title="Delete this Layout" class="submitdelete" onclick='return confirm("This is not a reversable operation.  Are you sure you wish to delete this layout?")'><i class='fa fa-trash'></i></a>
	   <?php 
	   } 
	   ?>
	   </div>
	 </div>
	 </div>
	 <?php /*
				<tr valign="top" class="slider-<?php echo $layout['id']; ?> hentry alternate" id="slider-<?php echo $layout['id']; ?>">
				<th class="display-none check-column" scope="row">
					<label for="cb-select-<?php echo $layout['id']; ?>" class="screen-reader-text">Select <?php echo $layout['title']; ?></label>
				<input type="checkbox" value="<?php echo $layout['id']; ?>" name="slider[]" id="cb-select-<?php echo $layout['id']; ?>">
							</th>
							<td>
							  
							</td>
						<td class="post-title page-title column-title"><strong><a title="Edit '<?php echo $layout['title']; ?>'" href="?page=i3d_layouts&layout=<?php echo $layout['id']; ?>&amp;action=edit" class="row-title"><?php echo $layout['title']; ?></a> <?php if ($layout['is_default']) { print "(Default)"; } ?></strong>
<div class="row-actions"><span class="edit"><a title="Edit this item" href="?page=i3d_layouts&layout=<?php echo $layout['id']; ?>&amp;action=edit">Edit</a> | </span><span class="trash"><a href="?page=i3d_layouts&layout=<?php echo $layout['id']; ?>&amp;action=trash" title="Delete this Layout" class="submitdelete">Delete</a></span></div>
</td>
		</tr>
		*/
		?>
<?php } ?>        

    </div>
    </div>
    </div>
    </div>
	<script>
	jQuery(document).ready(function() {
	jQuery(".tt").tooltip();
	
	
	
	
								


	

			var $container = jQuery('#isotope-container');

			if($container.length) {
				

					// initialize isotope
					$container.isotope({
					  itemSelector : '.isotope-item',
					  layoutMode : 'fitRows'
					});

					// filter items when filter link is clicked
					jQuery('#isotope-buttons a').click(function(){
					  var selector = jQuery(this).attr('data-filter');
					  $container.isotope({ filter: selector });
					  jQuery(this).removeClass('active').addClass('active').siblings().removeClass('active all');

					  return false;
					});

			
			}
				});

</script>
		
	
    <?php
}


function i3d_create_layout() {
	$layouts = get_option('i3d_layouts');
	$id = "pl_".I3D_Framework::get_unique_id("i3d_layout");
	$default_row = array("title"   => "",
						 "status" 	=> "enabled", 	// enabled, disabled (presets cannot be deleted, only disabled or enabled)
						 "type" 	=> "sidebar", 	// sidebar, widget, preset, divider
						 "columns" => 0,			// 0 1,2,3,4,5,6  -- only configurable if is a sidebar, otherwise it is set to 1 for widget, or whatever the preset is is -- 0 is "auto"
						 "sidebar" => "",
						 "widget"  => "",
						 "presets" => "",
						 "configuration" => array(),
						 "layout"  => "", // a pipe dilimited acccumulation totalling 12, blank is "auto equalized"
						 "styles"   => "", // css style
						 "width" => "contained", // contained/fullscreen
						 "orderable" => true, // true/false
						 "stylable" => true, // true/false
						 
						 );
	
	$header_row = $default_row;
	$content_row = $default_row;
	$divider_row = $default_row;
	$footer_row = $default_row;
	
	$header_row["title"] = "Top";
	$header_row["type"] = "preset";
	$header_row["presets"] = "logo-menu";
	$header_row["columns"] = sizeof(I3D_Framework::$layoutPresets["logo-menu"]["columns"]);
	$header_row["orderable"] = false;
	$header_row["stylable"] = false;
	$header_row["layout"] = I3D_Framework::$layoutPresets["logo-menu"]["layout"];
	
	$content_row["title"] = "Main Content";
	$content_row["type"] 	= "preset";
	$content_row["presets"] = "content-sidebar";
	$content_row["sidebar"] = "i3d-widget-area-right";
	$content_row["columns"] = sizeof(I3D_Framework::$layoutPresets["content-sidebar"]["columns"]);;
	$content_row["layout"] 	= I3D_Framework::$layoutPresets["content-sidebar"]["layout"];

	$divider_row["title"] = "Divider";
	$divider_row["type"]	 = "divider";
	$divider_row["style"] = "divider-1";
	$divider_row["columns"] = 0;
	$divider_row["layout"]  = ""; 


	$footer_row["title"] = "Footer";
	$footer_row["sidebar"] = "i3d-widget-area-footer";
	$footer_row["columns"] = 0;
	$footer_row["orderable"] = false;
	$footer_row["layout"]  = ""; 

						 
	$layouts["{$id}"] = array('id' => $id,
							 'title' => "New Layout",
							 "is_default" => false,
							 'sections' => array("header" => array("rows" => array("header" => $header_row)),
												"main" => array("rows" => array("main" => $content_row)),
												"footer" => array("rows" => array("footer" => $footer_row)))
							 
							 );
	
	//var_dump($layouts["$id"]);
	update_option('i3d_layouts', $layouts);
	wp_redirect(admin_url("admin.php?page=i3d_layouts&layout={$id}&action=edit"));
	
	return;
}

function i3d_layout_editor($layoutID) {
	global $wpdb;
	$generalSettings = get_option("i3d_general_settings");
	//var_dump($generalSettings);
	$layouts = get_option('i3d_layouts');
	$layout  = $layouts["{$layoutID}"];
	 //var_dump($_POST);
	if(array_key_exists("cmd", $_POST) && $_POST['cmd'] == "save") {
		$layouts["{$layoutID}"]["title"]          = stripslashes($_POST['title']);
		$layouts["{$layoutID}"]['default_for_type'] = array();
		
		  														  
																  
		$sections = array();
//var_dump($_POST);
		if(array_key_exists("rows", $_POST) && is_array($_POST['rows'])) {
		  foreach($_POST['rows'] as $id) {
			  $section_id = $_POST["{$id}__section"];
			  if ($section_id == "") {
				  $section_id = "main";
			  }
			  

			  $sections["$section_id"]["rows"]["$id"] = array('title' => @$_POST["{$id}__title"],
							  'type' => @$_POST["{$id}__type"],
							  'status' => @$_POST["{$id}__status"],
							  'columns' => @$_POST["{$id}__columns"],
							  'sidebar' => @$_POST["{$id}__sidebar"],
							  'widget' => @$_POST["{$id}__widget"],
							  'presets' => @$_POST["{$id}__presets"],
							  'configuration' => array(),
							  'visibility' => array(),
							  'layout' => @$_POST["{$id}__layout"],
							  'styles' => @$_POST["{$id}__styles"],
							  'styles_pad_top' => @$_POST["{$id}__styles_pad_top"],
							  'styles_pad_bottom' => @$_POST["{$id}__styles_pad_bottom"],
							  'width' => @$_POST["{$id}__width"],
							  'orderable' => (@$_POST["{$id}__orderable"] != "" ? ($_POST["{$id}__orderable"] == 1 ? true : false) : @$layout["rows"]["$id"]["orderable"]),
							  'stylable' => (@$_POST["{$id}__stylable"] != "" ? ($_POST["{$id}__stylable"] == 1 ? true : false) : @$layout["rows"]["$id"]["stylable"]),
								
								);
             if ($id == "portfolio") {
				// var_dump($sections["$section_id"]["rows"]["$id"]);
			 }
			 foreach ($_POST as $key => $value) {
				 if (!is_array($value)) {
					 $value = @stripslashes($value);
				 }
				 
				 if (strpos($key, "pages__") !== false) {
					$page_id = str_replace("pages__", "", $key);
					if ($value == "1") {
						update_post_meta($page_id, "selected_layout", $layoutID);
					}
				 } else if (strpos($key, "post_types__") !== false) {
					$post_type = str_replace("post_types__", "", $key);
					if ($value == "1") {
						$layouts["{$layoutID}"]["default_for_type"]["$post_type"] = true;
						
						//update_post_meta($page_id, "selected_layout", $layoutID);
					}
				 }
				 if (strpos($key, "{$id}__visibility__") !== false) {
						$visibility_key = str_replace("{$id}__visibility__", "", $key);
						$sections["$section_id"]["rows"]["$id"]["visibility"]["{$visibility_key}"] = $value;
				 
					 
				 }
				 if (strpos($key, "{$id}__configuration__") !== false) {
					$configuration_key = explode("__", str_replace("{$id}__configuration__", "", $key));
					//var_dump($configuration_key);
					$widget_id = $configuration_key[0];
					$field_id =  $configuration_key[1];
					$field_sub = @$configuration_key[2];
					if ($field_id == "actual_graphic_logo" && $_POST["{$id}__configuration__{$widget_id}__graphic_logo"] == "custom") {
						$sections["$section_id"]["rows"]["$id"]["configuration"]["{$widget_id}"]["graphic_logo"] = $value;
					} else if ($field_id == "font_awesome_icon" && $_POST["{$id}__configuration__{$widget_id}__vector_icon"] == "custom") {
						$sections["$section_id"]["rows"]["$id"]["configuration"]["{$widget_id}"]["vector_icon"] = $value;
					
					} else if ($field_id == "vector_icon" && $value == "custom") {
			// do nothing

					} else if ($field_id == "graphic_logo" && $value == "custom") {
						// do nothing
					} else {
						if ($field_id == "categories" && $field_sub != "") {
							$sections["$section_id"]["rows"]["$id"]["configuration"]["{$widget_id}"]["{$field_id}__{$field_sub}"] = $value;
						} else if ($field_id == "social_media_icon" && $field_sub != "") {
							$sections["$section_id"]["rows"]["$id"]["configuration"]["{$widget_id}"]["social_icon__{$field_sub}"] = $value;
						} else if ($field_sub != "") {
							$sections["$section_id"]["rows"]["$id"]["configuration"]["{$widget_id}"]["{$field_id}"]["{$field_sub}"] = $value;
							
						} else {
							$sections["$section_id"]["rows"]["$id"]["configuration"]["{$widget_id}"]["{$field_id}"] = $value;
						}
						
					}
				 }
			 }
			 //var_dump($sections["$section_id"]["rows"]["$id"]);
		}
	  }	
	  		//var_dump($_POST);

	  		//var_dump($sections);

		 $layouts["{$layoutID}"]["sections"] = $sections;
		//var_dump($layout);
		$layout = $layouts["{$layoutID}"];
		update_option("i3d_layouts", $layouts);
	}

//var_dump($activeBackground);
function display_sidebar_options2($currentValue, $defaultSidebar = "") {
	if ($defaultSidebar != "") {
	  echo "<option value=\"\">-- Use Default Sidebar (".ucwords(str_replace("-", " ", $defaultSidebar)).") --</option>";
	  echo "<option ".($currentValue == "x" ? 'selected' : '')." value=\"x\">-- No Sidebar Selected --</option>";
		
	} else {
	  echo "<option value=\"\">-- No Sidebar Selected --</option>";
	}
	
	$sidebars = get_option('i3d_sidebar_options');
	//print "current: $currentValue<br>";
	if(is_array($sidebars) && !empty($sidebars)){
		foreach($sidebars as $sidebarID => $sidebarName){
		//	print "sid: $sidebarID<br>";
			if($currentValue == $sidebarID){
				echo "<option value=\"$sidebarID\" selected>$sidebarName</option>";
			}else{
				echo "<option value=\"$sidebarID\">$sidebarName</option>";
			}
		}
	}
}


?>

	<style>

		#sortable label {width: 100px; display: inline-block; font-weight: bold;}
		#sortable input.text_input {width: 200px;}
		table.form_field { background-color: #ffffff;  }

		div.loading {
			background-image: url(<?php echo I3D_Framework::getAuxIconSrc('loading-bg'); ?>) !important;
			background-repeat: no-repeat !important;
			background-position: center center !important;
			height: 40px;
		}

		div.image-choice-featured { font-weight: bold; line-height: 17px; width: 217px !important; height: 148px; float: left; margin: 2px; padding: 2px; border: 1px solid #cccccc; border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px; }
		div.image-choice { width: 69px !important; height: 69px; float: left; margin: 2px; padding: 2px; border: 1px solid #cccccc; border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px; }
    div.image-selected {
			background-color: #ffcc00;
		}

		div.change-image-link {
			display: block; padding: 2px; border-radius: 2px; -moz-border-radius: 2px; -webkit-border-radius: 2px; border: 1px solid #cccccc !important;
		}
		
		
		div.change-image-link img { margin-bottom: -5px; cursor: pointer; }



th.header h3{
  font-family: sans-serif;
  margin: 0px;
  padding: 0px;
  float: left;
  margin-right: 10px;
  line-height: 25px;
}

th.header input, th.header select {
  font-family: sans-serif;
}

th.header select { font-size: 9pt; }
.remove { font-size: 10px !important; 
float: right;

}
.form-options label, label.shortcode {
	font-weight: bold;
	display: block;
}
.mce-i3d_cpg { display: none; } 
a#form_description_i3d_contact_form { display: none; }
.input-prepend select {
    -moz-box-sizing: content-box;
    font-size: 14px;
    height: 20px;
    padding-bottom: 4px;
    padding-top: 4px;
}
tbody.show { 
display: table-row-group !important;
}
#wp-form_description-wrap { margin-top: -30px; padding-left: 10px;}
#shortcode input[readonly] { cursor: pointer !important; background-color: #ffffff !important;}
div.fa-wrapper ul { margin-bottom: 0px; }
div.fa-wrapper { vertical-align: top; margin-left: -4px; }
div.wp-editor-wrap  { margin-top: -0px; padding-left: 0px;}
#shortcode input[readonly] { cursor: pointer !important; background-color: #ffffff !important;}
.mceResize { display: none !important; }
.mceIframeContainer iframe { height: 130px !important; }
div.input-group-indented .input-group-addon { width: 200px; }
</style>

	<script type="text/javascript">


	jQuery(function($) {
// Return a helper with preserved width of cells
var fixHelper = function(e, ui) {
	//alert();
	ui.children().each(function() {
		$(this).width($(this).width());
		
	});
	
	return ui;
};


/*
$("#sort tbody").sortable({
	helper: fixHelper
}).disableSelection();
*/

		//jQuery(".sortable tbody").sortable({items: "tr:not(.not-sortable)", forcePlaceholderSize: true, placeholder: "sortable-placeholder", containment: "parent", helper: fixHelper, handle: ".fa-reorder", cancel: ".not-sortable,.fa-icon-chooser,input,textarea,button,option,select" }).disableSelection();
		jQuery(".sortable tbody").sortable({items: "tr:not(.not-sortable)", forcePlaceholderSize: true, placeholder: "sortable-placeholder", containment: "parent", helper: fixHelper, handle: ".fa-reorder", cancel: ".not-sortable,.fa-icon-chooser,input,textarea,button,option,select" });
		jQuery(".sortable tbody").bind('mousedown.ui-disableSelection selectstart.ui-disableSelection', function(event) {
      event.stopImmediatePropagation();
});
		/*
		jQuery(".sortable tbody").on("sort", function(event, ui) {
													  
													  });
		*/
		//jQuery("#sortable .fa-icon-chooser").disableSelection();
		
	    //jQuery("#sortable li").resizable({grid: 50});
		
		//jQuery("select").on("click", function(e) { return e; 
											 //  });
	});
	
function addToggleFunctionality() {
	//alert("adding functionliaty");
jQuery(".fa-status-toggle").not(".bound").bind("click", function() {
												 if (jQuery(this).hasClass("fa-toggle-on")) {
													jQuery(this).removeClass("fa-toggle-on");
													jQuery(this).addClass("fa-toggle-off");
													 jQuery(this).parents("tr").addClass("disabled");
													 jQuery(this).parent().find("input[type=hidden].status-input").val("disabled");
												 } else {
													jQuery(this).removeClass("fa-toggle-off");
													jQuery(this).addClass("fa-toggle-on");
													 jQuery(this).parents("tr").removeClass("disabled");
													 jQuery(this).parent().find("input[type=hidden].status-input").val("enabled");
												 }
												 });	
	jQuery(".fa-status-toggle").addClass("bound");

}

function i3d_change_background_type(selectBox) {
  jQuery(".resource-type").css("display", "none");
  
  if (jQuery(selectBox).val() == "image") {
		jQuery("#resource__image").css("display", "block");
		jQuery("#resource__parallaxing").css("display", "block");
	  
  } else if (jQuery(selectBox).val() == "video") {
		jQuery("#resource__video").css("display", "block");
		jQuery("#resource__parallaxing").css("display", "none");
	  
  } else if (jQuery(selectBox).val() == "map") {
		jQuery("#resource__map").css("display", "block");
		jQuery("#resource__parallaxing").css("display", "none");
	  
  }

}

function i3d_change_background_visibility(selectBox) {
  
  if (jQuery(selectBox).val() == "always") {
		jQuery("#background_visibility_options").css("display", "block");
	  
  } else {
		jQuery("#background_visibility_options").css("display", "none");
	  
  }
}

</script>
	<div class="wrap">
	

		<h2>Manage Layout <a class="add-new-h2" href="admin.php?page=i3d_layouts">Cancel</a></h2>

   <form method="post">
  <ul style='margin-bottom: 20px;' class='form-options'>
          <li style='padding-top: 10px;'>


      <div class="input-group" >
            <span class="input-group-addon"><i class='fa fa-fw fa-quote-left'></i> <?php _e("Name","i3d-framework"); ?></span>
          
          <input  class='form-control' style='max-width: 200px' type='text' name='title' value="<?php echo $layout['title']; ?>" />
           </div>
          </li>
</ul>   
   
   <input type='hidden' name="cmd" value="save" />
<input style='float: right; padding: 0px 0px !important; width: 150px; margin-right: 10px;' type="submit" name="nocmd" class="button button-primary" value="<?php _e("Save Changes", "i3d-framework"); ?>" />
<ul class="nav nav-tabs">
  <li class="active"><a href="#layouts" data-toggle="tab">Layout</a></li>
  <li><a href="#pages" data-toggle="tab">Pages</a></li>
  <li><a href="#post-types" data-toggle="tab">Post Types</a></li>
  
  <?php /* <li <?php if (@$_POST['cmd'] == "save") { ?>class="active"<?php } ?>><a href="#panels" data-toggle="tab">Content Panels</a></li> 
  <li><a href="#shortcode" data-toggle="tab">Shortcode</a></li> */ ?>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active" id="layouts">
		<?php
		
	$activeBackgrounds = get_option('i3d_active_backgrounds');
	if (!is_array($activeBackgrounds)) {
	  $activeBackgrounds = array();	
	}
	$optionalActiveBackgrounds = array();
	foreach ($activeBackgrounds as $key => $data) {
	  $optionalActiveBackgrounds["$key"] = $data['title'];
	}
		
		
						if (!is_array($optionalActiveBackgrounds)) {
						  $optionalActiveBackgrounds = array();	
						}		
						//var_dump($layout);
			$sections = @$layout['sections'];
			$sidebarWidgets 	= wp_get_sidebars_widgets();
			$widgetVisibility	= @$layout['widget_visibility'];
			global $wp_registered_widgets;
			//global $generalSettings;
			
			if (!is_array($widgetVisibility)) {
				$widgetVisibility = array();
			}

			
			
			$counter = 0;
			if (!is_array($sections)) {
				$sections = array();
			}
			//var_dump($sections);
			$widgetCount = 0;
			$visibilitySettings = array();
			$firstSection = true;
			foreach ($sections as $section_id => $section) {
//var_dump($section);
?>
		<table class='table table-bordered layout-table sortable <?php if ($firstSection) { print "section-opened"; } ?>' id="sortable-<?php echo $section_id; ?>">
  			<thead>
			<tr class='active-dark'>
			    <td colspan='3'><?php echo ucwords(str_replace("-", " ", $section_id)); ?> <i class='fa fa-angle-<?php if ($firstSection) { print "up"; } else { print "down"; } ?> fa-toggle-section'></i>
    <?php if ($section_id != "primary-slider") { ?>
				<div class="btn-group btn-group-xs pull-right" role="group" aria-label="Add Row">
				  <button class='btn btn-xs btn-default' disabled><i class="fa fa-plus-circle fa-fw"></i></button>
				  <button type='button' rel='<?php echo $section_id; ?>' class='btn btn-xs btn-default btn-add-preset' data-toggle="modal" data-target="#presets-modal-<?php echo $section_id; ?>">Preset</button>
				  <button type='button' rel='<?php echo $section_id; ?>' class='btn btn-xs btn-default btn-add-sidebar'>Sidebar</button>
				  <button type='button' rel='<?php echo $section_id; ?>' class='btn btn-xs btn-default btn-add-widget' data-toggle="modal" data-target="#widgets-modal">Widget</button>
				  <?php if ($section_id == "main") { ?><button type='button'  rel='<?php echo $section_id; ?>' class='btn btn-xs btn-default btn-add-divider'>Divider</button><?php } ?>
	</div>
	<?php } ?>
				
			  
				</td>
  			</tr>
			</thead>
			<tbody class='toggle-section <?php if ($firstSection) { print "show"; } ?>'>
<?php
		
			$firstSection = false;
			foreach($section['rows'] as $row_id => $row) {
				
					//var_dump($row);

				if (!array_key_exists("visibility", $row)) {
					$row['visibility'] = array();
				}
				foreach ($row['visibility'] as $widget_id => $visibility) {
					$visibilitySettings["{$row_id}__visibility__{$widget_id}"] = $visibility;
				}
				//var_dump($row);
				$row = wp_parse_args( (array) $row, array(	"title"     => "Row",
															"status" 	=> "enabled", 	// enabled, disabled (presets cannot be deleted, only disabled or enabled)
															 "type" 	=> "sidebar", 	// sidebar, widget, preset
															 "columns" => 3,			// 0 1,2,3,4,5,6  -- only configurable if is a sidebar, otherwise it is set to 1 for widget, or whatever the preset is is -- 0 is "auto"
															 "sidebar" => "",
															 "widget"  => "",
															 "presets" => array(),
															 "layout"  => "3|6|3", // a pipe dilimited acccumulation totalling 12, blank is "auto equalized"
															 "styles"   => "", // css style
															 "width" => "contained", 
															 "orderable" => true,
															 "stylable" => true,
						 ) );



	$rowStatus 	= '<option '.($row['status'] == "enabled" ? "selected='selected'" : "").' value="enabled">Enabled</option>';
	$rowStatus .= '<option '.($row['status'] == "disabled" ? "selected='selected'" : "").' value="disabled">Disabled</option>';

	
	$rowTypes = '<option '.($row['type'] == "sidebar" ? "selected='selected'" : "").' value="sidebar">Sidebar</option>';
	$rowTypes .= '<option '.($row['type'] == "widget" ? "selected='selected'" : "").' value="widget">Widget</option>';
	$rowTypes .= '<option '.($row['type'] == "preset" ? "selected='selected'" : "").' value="preset">Preset</option>';

					

?>
		<!-- <li id="row__<?php echo $counter; ?>" > 
		 <table id="row__<?php echo $counter; ?>" <?php /* id="<?php echo $counter; ?>__table" */ ?> class="layout_row" cellspacing="0" width="100%" height="100%">-->
		 <?php 
		 //$regionStylable = $row['stylable'];
		$regionStylable = false;
		//var_dump($row);
		if ($row['type'] == "sidebar") { 
			//if (!is_array(I3D_Framework::$optionalStyledBackgrounds) || !$row['stylable'])) {
							
			//} else {
				// the footer is only stylable if there are optional footer backgrounds, and the footer is set to allow styling
				if ($row_id == "footer" && 
					$row['stylable'] === true && 
					is_array(I3D_Framework::$optionalStyledFooterBackgrounds) && 
					sizeof(I3D_Framework::$optionalStyledFooterBackgrounds) > 0) {
					
					$regionStylable = true;
				
				// all other regions are stylable if there are optional styled backgrounds, and region is set to allow styling
				} else {
					$regionStylable = $row['stylable'] === true && 
										is_array(I3D_Framework::$optionalStyledBackgrounds) && 
										sizeof(I3D_Framework::$optionalStyledBackgrounds) > 0;
				}
			//}
		} else if ($row['type'] == "preset" || $row['type'] == "widget") {
					$regionStylable = $row['stylable'] === true && 
										is_array(I3D_Framework::$optionalStyledBackgrounds) && 
										sizeof(I3D_Framework::$optionalStyledBackgrounds) > 0;
			
		}
					
	
?>
           
		   
		    <tr id='row__<?php echo $row_id; ?>' class='row__<?php echo $row_id; ?> <?php if (!$row['orderable']) { ?>not-sortable<?php } ?> <?php echo $row['status']; ?>'>
			    <td class='column-0'>
				  <i class='fa fa-fw fa-status-toggle fa-toggle-<?php echo $row['status'] == "enabled" ? "on" : "off"; ?>'></i>
				  <input type="hidden" name="<?php echo $row_id; ?>__status" class='status-input' value="<?php echo $row['status']; ?>" />
				  <input type="hidden" name="<?php echo $row_id; ?>__section" value="<?php echo $section_id; ?>" />
				  <input type="hidden" name="<?php echo $row_id; ?>__orderable" value="<?php echo $row['orderable']; ?>" />
				  <input type="hidden" name="<?php echo $row_id; ?>__stylable" value="<?php echo $row['stylable']; ?>" />
				</td>
                <td class='column-1' >
				  <?php if ($row['orderable']) { ?><i class='fa fa-fw fa-reorder'></i><?php } else { ?><i class='fa fa-fw fa-none'></i><?php } ?>
                  <input type="text" class='form-control' name="<?php echo $row_id; ?>__title" value="<?php echo $row['title']; ?>" /> 
				  <input type="hidden" name="<?php echo $row_id; ?>__type" value="<?php echo $row['type']; ?>" />
				  <div class='text-vertical'><?php echo $row['type']; ?></div>
				</td>
				
				<td id="row-configurable-items-<?php echo $row_id; ?>"  class="make-it-wide">
				<div class='delete-button'>Delete</div>
				
<?php 	if ($row['type'] == "divider") { ?>
					<div class='text-center'>
                		<div class="input-group tt input-group-collapsed" title="Divider Style">
        					<span class="input-group-addon"><i class='icon-minus'></i></span>
							<select class='form-control layout-bg-select' id="__layout_row__<?php echo $row_id; ?>__styles" name="<?php echo $row_id; ?>__styles">
							<?php  echo i3d_renderSelectOptions(I3D_Framework::$globalPageDividers, $row['styles']); ?>
                    		</select>
                    	</div>
                    </div>                     
<?php	}  else { 
			if ($row['type'] == "sidebar") { 
		//	var_dump($row);
			?>
  					<div class='row clearfix'>
                		<div class='col-sm-<?php if ($regionStylable) { print "2"; } else { print "4"; } ?>'>
                    		<div class="input-group pull-left tt" title="Sidebar associated with this Region">
        						<span class="input-group-addon"><i class='fa fa-fw fa-file-text'></i></span>
								<select class="__layout_regions__<?php echo $row_id; ?>__sidebar layout-sidebar-select form-control" name="<?php echo $row_id; ?>__sidebar" onchange='handleSidebarChange(this)'><?php display_sidebar_options2($row['sidebar']); ?></select>
                    		</div>     
                    	</div>
<?php 			if ($regionStylable) { ?>
						<div class='text-center col-sm-2 visible-when-sidebar-exists <?php if ($row["sidebar"] == "") { print "non-visible"; } ?>'>
                			<div class="input-group tt" title="Background Style">
        						<span class="input-group-addon"><i class='icon-tint'></i></span>
								<select class='layout-bg-select form-control' id="<?php echo $row_id; ?>__styles" name="<?php echo $row_id; ?>__styles">
<?php 				if ($row_id == "footer" && 
						@$row['stylable'] === true && 
						is_array(I3D_Framework::$optionalStyledFooterBackgrounds) && 
						sizeof(I3D_Framework::$optionalStyledFooterBackgrounds) > 0) {
						
						echo i3d_renderSelectOptions(I3D_Framework::$optionalStyledFooterBackgrounds, $row['styles']); 
					
					} else {
						if (!is_array($optionalActiveBackgrounds)) {
						  $optionalActiveBackgrounds = array();	
						}
						echo i3d_renderSelectOptions(array_merge(I3D_Framework::$optionalStyledBackgrounds, $optionalActiveBackgrounds), $row['styles']); 
					} ?>
                    			</select>
                    		</div>
                    	</div>
						
						
						<div class='text-center col-sm-2 visible-when-sidebar-exists <?php if ($row["sidebar"] == "") { print "non-visible"; } ?>'>
                			<div class="input-group tt" title="Top Padding">
        						<span class="input-group-addon"><i class='fa  fa-arrows-v fa-pad-top'></i></span>
								<select class='layout-pad-select form-control' id="<?php echo $row_id; ?>__styles_pad_top" name="<?php echo $row_id; ?>__styles_pad_top">
                     			<?php echo i3d_renderSelectOptions(array("" => "Default", 
																		 "c-pad-top-0" => "0px",
																		 "c-pad-top-10" => "10px",
																		 "c-pad-top-20" => "20px",
																		 "c-pad-top-30" => "30px",
																		 "c-pad-top-40" => "40px",
																		 "c-pad-top-50" => "50px",
																		 "c-pad-top-75" => "75px",
																		 "c-pad-top-100" => "100px",
																		 "c-pad-top-150" => "150px",
																		 "c-pad-top-200" => "200px"), @$row['styles_pad_top']); ?>
								</select>
                    		</div>
                    	</div>	
						
						<div class='text-center col-sm-2 visible-when-sidebar-exists <?php if ($row["sidebar"] == "") { print "non-visible"; } ?>'>
                			<div class="input-group tt" title="Bottom Padding">
        						<span class="input-group-addon"><i class='fa  fa-arrows-v fa-pad-bottom'></i></span>
								<select class='layout-pad-select form-control' id="<?php echo $row_id; ?>__styles_pad_top" name="<?php echo $row_id; ?>__styles_pad_bottom">
                     			<?php echo i3d_renderSelectOptions(array("" => "Default", 
																		 "c-pad-bottom-0" => "0px",
																		 "c-pad-bottom-10" => "10px",
																		 "c-pad-bottom-20" => "20px",
																		 "c-pad-bottom-30" => "30px",
																		 "c-pad-bottom-40" => "40px",
																		 "c-pad-bottom-50" => "50px",
																		 "c-pad-bottom-75" => "75px",
																		 "c-pad-bottom-100" => "100px",
																		 "c-pad-bottom-150" => "150px",
																		 "c-pad-bottom-200" => "200px"), @$row['styles_pad_bottom']); ?>
								</select>
                    		</div>
                    	</div>						
											
<?php 			} ?> 

				<div class='text-center col-sm-<?php if ($regionStylable) { print "2"; } else { print "4"; } ?> visible-when-sidebar-exists <?php if ($row['sidebar']=="") { print "non-visible"; } ?>'>
                	<div class="input-group tt" title="Number of Columns">
        				<span class="input-group-addon"><i class='icon-columns'></i></span>
						<select class='layout-columns-select form-control' id="<?php echo $row_id; ?>__columns" name="<?php echo $row_id; ?>__columns">
                    	<?php echo i3d_renderSelectOptions(array("0" => "Auto", "1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5", "6" => "6"), $row['columns']); ?>
                    	</select>
                    </div>
                </div>
                <div class='col-sm-<?php if ($regionStylable) { print "2"; } else { print "4"; } ?> visible-when-sidebar-exists <?php if ($row['sidebar'] == "") { print "non-visible"; } ?>'>
                    <div class="pull-right input-group tt" title="Region Width: Either Full-Screen, or Contained">
						<span class="input-group-addon"><i class='icon-resize-horizontal'></i></span>
                        <select class='layout-width-select form-control' id="<?php echo $row_id; ?>__width" name="<?php echo $row_id; ?>__width">
                        <?php echo i3d_renderSelectOptions(array("contained" => "Contained", "fullscreen" => "Full Screen"), $row['width']); ?>
                        </select>  
                    </div>     
                </div>
            </div> 
<?php }  else if ($row['type'] == "widget" || $row['type'] == "preset") { ?>
  					<div class='row clearfix'>

<?php if ($regionStylable) { ?>
						<div class='text-center col-sm-2 visible-when-sidebar-exists'>
                			<div class="input-group tt" title="Background Style">
        						<span class="input-group-addon"><i class='icon-tint'></i></span>
								<select class='layout-bg-select form-control' id="<?php echo $row_id; ?>__styles" name="<?php echo $row_id; ?>__styles">
<?php 				if ($row_id == "footer" && 
						@$row['stylable'] === true && 
						is_array(I3D_Framework::$optionalStyledFooterBackgrounds) && 
						sizeof(I3D_Framework::$optionalStyledFooterBackgrounds) > 0) {
						
						echo i3d_renderSelectOptions(I3D_Framework::$optionalStyledFooterBackgrounds, $row['styles']); 
					
					} else {
						if (!is_array($optionalActiveBackgrounds)) {
						  $optionalActiveBackgrounds = array();	
						}
						echo i3d_renderSelectOptions(array_merge(I3D_Framework::$optionalStyledBackgrounds, $optionalActiveBackgrounds), $row['styles']); 
					} ?>
                    			</select>
                    		</div>
                    	</div>
						
						<div class='text-center col-sm-2'>
                			<div class="input-group tt" title="Top Padding">
        						<span class="input-group-addon"><i class='fa fa-arrows-v fa-pad-top'></i></span>
								<select class='layout-pad-select form-control' id="<?php echo $row_id; ?>__styles_pad_top" name="<?php echo $row_id; ?>__styles_pad_top">
                     			<?php echo i3d_renderSelectOptions(array("" => "Default", 
																		 "c-pad-top-0" => "0px",
																		 "c-pad-top-10" => "10px",
																		 "c-pad-top-20" => "20px",
																		 "c-pad-top-30" => "30px",
																		 "c-pad-top-40" => "40px",
																		 "c-pad-top-50" => "50px",
																		 "c-pad-top-75" => "75px",
																		 "c-pad-top-100" => "100px",
																		 "c-pad-top-150" => "150px",
																		 "c-pad-top-200" => "200px"), @$row['styles_pad_top']); ?>
								</select>
                    		</div>
                    	</div>	
						
						<div class='text-center col-sm-2'>
                			<div class="input-group tt" title="Bottom Padding">
        						<span class="input-group-addon"><i class='fa fa-arrows-v fa-pad-bottom'></i></span>
								<select class='layout-pad-select form-control' id="<?php echo $row_id; ?>__styles_pad_top" name="<?php echo $row_id; ?>__styles_pad_bottom">
                     			<?php echo i3d_renderSelectOptions(array("" => "Default", 
																		 "c-pad-bottom-0" => "0px",
																		 "c-pad-bottom-10" => "10px",
																		 "c-pad-bottom-20" => "20px",
																		 "c-pad-bottom-30" => "30px",
																		 "c-pad-bottom-40" => "40px",
																		 "c-pad-bottom-50" => "50px",
																		 "c-pad-bottom-75" => "75px",
																		 "c-pad-bottom-100" => "100px",
																		 "c-pad-bottom-150" => "150px",
																		 "c-pad-bottom-200" => "200px"), @$row['styles_pad_bottom']); ?>
								</select>
                    		</div>
                    	</div>						
														
<?php 			} ?> 


                <div class='col-sm-<?php if ($regionStylable) { print "6"; } else { print "12"; } ?> visible-when-sidebar-exists'>
                    <div class="pull-right input-group tt" title="Region Width: Either Full-Screen, or Contained">
						<span class="input-group-addon"><i class='icon-resize-horizontal'></i></span>
                        <select class='layout-width-select form-control' id="<?php echo $row_id; ?>__width" name="<?php echo $row_id; ?>__width">
                        <?php echo i3d_renderSelectOptions(array("contained" => "Contained", "fullscreen" => "Full Screen"), $row['width']); ?>
                        </select>  
                    </div>     
                </div>
            </div> 

<?php } ?>                     
            <div class='row-fluid visible-when-sidebar-exists <?php if ((@$row["sidebar"] == "") && $row['type'] == "sidebar") { print "non-visible"; } ?>'>
<?php if ($row['type'] == "preset") { ?>
 <input type="hidden" name="<?php echo $row_id; ?>__presets" value="<?php echo $row['presets']; ?>" />
<!-- <input type="hidden" name="<?php echo $row_id; ?>__width" value="<?php echo $row['width']; ?>" />-->
 <input type="hidden" name="<?php echo $row_id; ?>__columns" value="<?php echo $row['columns']; ?>" />

			<input class="input-mini layout-holder" type="hidden"  id="<?php echo $row_id; ?>__layout" name="<?php echo $row_id; ?>__layout" value="<?php echo $row['layout']; ?>" />
			<div data-toggle="tooltip" class="slider-range"></div>
			<div class='row region-widgets'>

<?php 
$preset = I3D_Framework::get_preset_items($row['presets']);
//var_dump($preset);
//$preset = $presetItems["{$row['presets']}"];
				foreach ($preset['columns'] as $column) { 
					
					if (!array_key_exists('widgets', $column)) {
						//$regionInfo['configuration']['widgets'] = array();
						$column['widgets'] 						= array();
					}
					//$columnWidth = $column['default-width'];
					?>
					
             
                <div class='example-span text-center widget<?php echo $widgetCount; ?>'>
<?php				//  var_dump($column['widgets']); ?>
<?php 				foreach ($column['widgets'] as $widget) { 
						$widgetID = $row_id."__".$widget['class_name'];
						$myWidget = I3D_Framework::instantiate_widget($widget);

$wid = $widgetID;
						?>
						<div class='alert alert-<?php if (@$widget['class_name']  == "I3D_Widget_SidebarRegion") { print "sidebar"; } else { print "widget"; }?> <?php echo "preset-".$widget['class_name']; ?>'>
					
						
						
						
													<i class='pull-right fa fa-fw fa-angle-down fa-toggle-settings'></i>

						<?php
						$widgetName = str_replace("i3d:", "", @$myWidget->name);
						//echo " <i class='fa fa-info-circle tt' title='".@$myWidget->widget_options['description']."'></i>";
						if (@$widget['class_name']  == "I3D_Widget_SidebarRegion") { 
						  //  $sidebar_id  = $myWidget->get_property("sidebar", @$row['configuration']["{$widget['id']}"], $widget['defaults'],  $row_id, $widget['id']);
							$sidebarName = $myWidget->get_sidebar_name(@$row['configuration']["{$widget['id']}"], $widget['defaults'],  $row_id, $widget['id'], $layoutID);
							echo "<h5><span>{$sidebarName}</span> Sidebar</h5>";
						} else { 
							echo "<h5>{$widgetName} Widget</h5>";
						}
						//var_dump($myWidget);
						//print $myWidget->description;
						if (method_exists($myWidget, "layout_configuration_form")) {
							
							
							?>
						<!--	<button data-title="<?php echo $widgetName; ?> Settings" class='btn btn-default btn-sm pull-right btn-configure-widget' type='button' 
							data-container="td#row-configurable-items-<?php echo $row_id; ?> div.example-span.widget<?php echo $widgetCount++; ?>" data-toggle="popover" data-placement="bottom"><i class='fa fa-pencil'></i></button>
							-->
							<div class='popover-configurations-container'>
							  <div class='popover-configurations'>
							  <?php if (@$widget['class_name']  != "I3D_Widget_SidebarRegion") { ?>

							  <?php i3d_render_mobile_tablet_visibility_options($row, $row_id, $widget['id']);	?>
								<?php } ?>
							  <?php 
							  	//var_dump($widget['id']);
							  	echo $myWidget->layout_configuration_form(@$row['configuration']["{$widget['id']}"], $widget['defaults'],  $row_id, $widget['id'], $layoutID); ?>
								</div>
							</div>
							<div class='region-widgets'></div>
							<?php
						}
					?></div><?php
					} ?>
					
                </div>
<?php 			} ?>
			</div>
			</div>
<?php 		
} else if ($row['type'] == "widget") {
	//var_dump($row['configuration']);
	//var_dump($row['style']);
	?>
 <input type="hidden" name="<?php echo $row_id; ?>__widget" value="<?php echo $row['widget']; ?>" />
<!-- disabled 9/12/2016 as it shold already be a part of the widget configuration  <input type="hidden" name="<?php echo $row_id; ?>__width" value="<?php echo $row['width']; ?>" />-->
 <input type="hidden" name="<?php echo $row_id; ?>__columns" value="<?php echo $row['columns']; ?>" />

			<input class="input-mini layout-holder" type="hidden"  id="<?php echo $row_id; ?>__layout" name="<?php echo $row_id; ?>__layout" value="<?php echo $row['layout']; ?>" />
			<div class='row region-widgets'>
					
             
                <div class='example-span col-sm-12 text-center widget<?php echo $widgetCount; ?>'>
				  
<?php 				

						$widget = array("class_name" => $row['widget']);
						$myWidget = I3D_Framework::instantiate_widget($widget);
						$wid = @$myWidget->id_base;
						?>
						<div class='alert alert-<?php if (@$widget['class_name']  == "I3D_Widget_SidebarRegion") { print "sidebar"; } else { print "widget"; }?>'>
													<i class='pull-right fa fa-fw fa-angle-down fa-toggle-settings'></i>

						<?php
						$widgetName = str_replace("i3d:", "", @$myWidget->name);
						
						$widget['id'] = @$myWidget->id_base;
						//echo " <i class='fa fa-info-circle tt' title='".@$myWidget->widget_options['description']."'></i>";
						if (@$widget['class_name']  == "I3D_Widget_SidebarRegion") { 
						  //  $sidebar_id  = $myWidget->get_property("sidebar", @$row['configuration']["{$widget['id']}"], $widget['defaults'],  $row_id, $widget['id']);
							$sidebarName = $myWidget->get_sidebar_name(@$row['configuration']["{$widget['id']}"], $widget['defaults'],  $row_id, $widget['id'], $layoutID);
							echo "<h5><span>{$sidebarName}</span> Sidebar</h5>";
						} else { 
							echo "<h5>{$widgetName} Widget</h5>";
						}
						$wid = $widget['id'];
?>

<?php	

						if (method_exists($myWidget, "layout_configuration_form")) {
						//	print $row_id;
							
							?>
						<!--	<button data-title="<?php echo $widgetName; ?> Settings" class='btn btn-default btn-sm pull-right btn-configure-widget' type='button' 
							data-container="td#row-configurable-items-<?php echo $row_id; ?> div.example-span.widget<?php echo $widgetCount++; ?>" data-toggle="popover" data-placement="bottom"><i class='fa fa-pencil'></i></button>
							-->
							<div class='popover-configurations-container'>
							  <div class='popover-configurations'>
							  <?php i3d_render_mobile_tablet_visibility_options($row, $row_id, $wid);	?>

							  <?php echo $myWidget->layout_configuration_form(@$row['configuration']["{$widget['id']}"], array(),  $row_id, $widget['id'], $layoutID); ?>
								</div>
							</div>
							<div class='region-widgets'></div>
							<?php
						}
					?></div><?php
					 ?>
					
                </div>
<?php 		 ?>
			</div>
			</div>
<?php 		
} else { 
//print "sidebar configuration elements";

?>
			<input class="input-mini layout-holder" type="hidden"  id="<?php echo $row_id; ?>__layout" name="<?php echo $row_id; ?>__layout" value="<?php echo $row['layout']; ?>" />
			<div data-toggle="tooltip" data-placement="left" class="slider-range"></div>
			<div class='row region-widgets'>
<?php 		 
//var_dump($row['visibility']);
				$spanCount = 0;
				$mySidebar = @$row["sidebar"];
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
						} 
						?>
					<div class='alert alert-widget text-center <?php echo @$wp_registered_widgets["$wid"]['callback'][0]->id_base; ?>'>
											  <i class='pull-right fa fa-fw fa-angle-down fa-toggle-settings'></i>

						<h5><?php echo str_replace("i3d:", "", @$wp_registered_widgets["$wid"]['callback'][0]->name); ?> Widget</h5>
										<div class='popover-configurations-container'>
							  <div class='popover-configurations'>	
<?php i3d_render_mobile_tablet_visibility_options($row, $row_id, $wid);	?>
								<p class='small'>To edit the configurations for this widget, please go to the <b>Appearance</b> &gt; <b>Widgets</b> panel.</p>
</div>
</div>
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
         <input type="hidden" name="rows[]" value="<?php echo $row_id; ?>" />

                </td>
				
            </tr>                                  




	<!--</table>
     
         
         </li> -->

<?php

					$counter++;
			//	}
			}
		?>
		</tbody>
			</table>
<div class="modal fade" id="presets-modal-main-menu">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Preset Configurations</h4>
      </div>
      <div class="modal-body">
	  
        <?php foreach (I3D_Framework::get_all_preset_configurations() as $short_code => $configuration) { 
		  if (in_array("main-menu", $configuration['section'])) { ?>
		<div class='panel panel-default'>
		  <div class='panel-body'>
		    <button type='button'  rel='main-menu' class='pull-right btn btn-primary btn-insert-preset' value="<?php echo $short_code; ?>" data-dismiss="modal">
			+ Add
			</button>

		  <p class='lead'><?php echo $configuration['name']; ?></p>
		  <p><?php echo $configuration['description']; ?>
		</div>
		</div>
				<?php 
		  			}
				} ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->     
			<?php } ?>


<div class="modal fade" id="presets-modal-header">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Preset Configurations</h4>
      </div>
      <div class="modal-body">
	  
        <?php foreach (I3D_Framework::get_all_preset_configurations() as $short_code => $configuration) { 
		  if (in_array("header", $configuration['section'])){ ?>
		<div class='panel panel-default'>
		  <div class='panel-body'>
		    <button type='button'  rel='header' class='pull-right btn btn-primary btn-insert-preset' value="<?php echo $short_code; ?>" data-dismiss="modal">
			+ Add
			</button>

		  <p class='lead'><?php echo $configuration['name']; ?></p>
		  <p><?php echo $configuration['description']; ?>
		</div>
		</div>
				<?php 
		  			}
				} ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->     


<div class="modal fade" id="presets-modal-main">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Preset Configurations</h4>
      </div>
      <div class="modal-body">
	  
        <?php foreach (I3D_Framework::get_all_preset_configurations() as $short_code => $configuration) { 
		if (in_array("main", $configuration['section'])) { ?>
		<div class='panel panel-default'>
		  <div class='panel-body'>
		    <button type='button'  rel='main' class='pull-right btn btn-primary btn-insert-preset' value="<?php echo $short_code; ?>" data-dismiss="modal">
			+ Add
			</button>

		  <p class='lead'><?php echo $configuration['name']; ?></p>
		  <p><?php echo $configuration['description']; ?></p>
		</div>
		</div>
				<?php } ?>
				<?php } ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->     



<div class="modal fade" id="presets-modal-footer">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Preset Configurations</h4>
      </div>
      <div class="modal-body">
	  
        <?php foreach (I3D_Framework::get_all_preset_configurations() as $short_code => $configuration) { 
				if (in_array("footer", $configuration['section'])) { ?>

		<div class='panel panel-default'>
		  <div class='panel-body'>
		    <button type='button'  rel='footer' class='pull-right btn btn-primary btn-insert-preset' value="<?php echo $short_code; ?>" data-dismiss="modal">
			+ Add
			</button>

		  <p class='lead'><?php echo $configuration['name']; ?></p>
		  <p><?php echo $configuration['description']; ?>
		</div>
		</div>
				<?php } ?>
				<?php } ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->     


<div class="modal fade" id="presets-modal-copyright">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Preset Configurations</h4>
      </div>
      <div class="modal-body">
	  
        <?php foreach (I3D_Framework::get_all_preset_configurations() as $short_code => $configuration) { 
				if (in_array("copyright", $configuration['section'])) { ?>

		<div class='panel panel-default'>
		  <div class='panel-body'>
		    <button type='button'  rel='copyright' class='pull-right btn btn-primary btn-insert-preset' value="<?php echo $short_code; ?>" data-dismiss="modal">
			+ Add
			</button>

		  <p class='lead'><?php echo $configuration['name']; ?></p>
		  <p><?php echo $configuration['description']; ?>
		</div>
		</div>
				<?php } ?>
				<?php } ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->   

<div class="modal fade" id="widgets-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Available Widgets</h4>
      </div>
      <div class="modal-body">
	    <p>If you need to use a widget not available in this list, create a new widget container, add the widget to it, then return to this page and instead insert a "sidebar" region, and then specify the new sidebar you just created.</p>
	  
        <?php foreach (I3D_Framework::get_all_widget_configurations() as $short_code => $configuration) { 
		 ?>
		<div class='panel panel-default'>
		  <div class='panel-body'>
		    <button type='button'  rel='main' class='pull-right btn btn-primary btn-insert-widget' value="<?php echo $short_code; ?>" data-dismiss="modal">
			+ Add
			</button>

		  <p class='lead'><?php echo $configuration['name']; ?></p>
		  <p><?php echo $configuration['description']; ?>
		  <div class='non-visible'>
		    <div id="widget__<?php echo $short_code; ?>">
			  <div class='example-span col-sm-12'>
				<div class='alert alert-success text-center <?php echo $short_code; ?>'>
				  <i class='pull-right fa fa-fw fa-angle-down fa-toggle-settings'></i>
				  <h5><?php echo $configuration['name']; ?> Widget</h5>
				  
						<div class='popover-configurations-container'>
							  <div class='popover-configurations'>
							  
							  <?php 
							  $myWidget = I3D_Framework::instantiate_widget(array("class_name" => $short_code));
							  //var_dump($myWidget);
							  echo $myWidget->layout_configuration_form(array(), array(),  "new_row", @$myWidget->id_base, $layoutID); ?>
								</div>
							</div>
							<div class='region-widgets'></div>				  
				  </div>
              </div>
			</div>
		  </div>
		</div>
		</div>
				<?php ?>
				<?php } ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->     

       
  </div>

  <div class="tab-pane" id="pages" style='padding: 10px 10px;'>
  <p>Quickly assign this layout to one or more pages below.</p>
    
  <?php
  $pages = get_pages();
   foreach ($pages as $page) {
	   	$selected_layout =  get_post_meta($page->ID, "selected_layout", true);
		if ($selected_layout == "") {
	  		$selected_layout = I3D_Framework::get_default_layout_id($page->ID);	
		}
	   ?>
	   <div class='checkbox'>
	     <label for='pages__<?php echo $page->ID; ?>'> <input id="pages__<?php echo $page->ID; ?>" type='checkbox' name="pages__<?php echo $page->ID; ?>" value="1" <?php if ($selected_layout == $layoutID) { ?>checked readonly onclick='return false;'<?php } ?> /> <?php echo $page->post_title; ?></label>
	    </div>
	 <?php }
	 ?>
  

</div>


  <div class="tab-pane" id="post-types" style='padding: 10px 10px;'>
  <p>Quickly assign this layout to one or more post types below.</p>
    
  <?php
  $args = array(
   'public'   => true,
   '_builtin' => false
	);
  
  $post_types = get_post_types($args, "outputs", "and");
 // var_dump($layout);
   foreach ($post_types as $type) {
	//   var_dump($type);
	  // continue;
	  // 	$selected_layout =  get_post_meta($page->ID, "selected_layout", true);
	  $selected_layout = I3D_Framework::get_post_type_layout($type->name);	
	 // var_dump($selected_layout);
		//$selected_layout = "";
		if ($selected_layout == "") {
	  		$selected_layout = I3D_Framework::get_default_layout_id($page->ID);	
		}
		//print $selected_layout;
		
	   ?>
	   <div class='checkbox'>
	     <label for='post_types__<?php echo $type->name; 
		 ?>'> <input id="post_types__<?php echo $type->name; 
		 ?>" type='checkbox' name="post_types__<?php echo $type->name;
		 ?>" value="1" <?php if ($selected_layout == $layoutID) { ?>checked readonly onclick='return false;'<?php } ?> /> <?php echo $type->labels->name ?></label>
	    </div>
	 <?php }
	 ?>
  

</div>

</div>
       
     

	</form>
	</div>

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
				print "<div class='alert alert-widget text-center {$wp_registered_widgets["$wid"]['callback'][0]->id_base}'>";
				?>
						  <i class='pull-right fa fa-fw fa-angle-down fa-toggle-settings'></i>
				  <h5><?php echo str_replace("i3d:", "", $wp_registered_widgets["$wid"]['callback'][0]->name); ?> Widget</h5>
				  
						<div class='popover-configurations-container'>
							  <div class='popover-configurations'>
<?php 


i3d_render_mobile_tablet_visibility_options(array(), "[temp_row]", $wid);	?>
					  
							  <?php 
							 // $myWidget = I3D_Framework::instantiate_widget(array("class_name" => $short_code));
							  $myWidget = $wp_registered_widgets["$wid"]['callback'][0];
							  //var_dump($myWidget);
							  if (method_exists($myWidget, "layout_configuration_form")) {
							  //echo $myWidget->layout_configuration_form(array(), array(),  "new_row", @$myWidget->id_base, $layoutID); 
							  }
							  ?>
								<p class='small'>To edit the configurations for this widget, please go to the <b>Appearance</b> &gt; <b>Widgets</b> panel.</p>
								</div>
							</div>
							<div class='region-widgets'></div>				  

				
				<?php
				//print "<h5>".str_replace("i3d:", "", $wp_registered_widgets["$wid"]['callback'][0]->name)."<h5>";
				print "</div>";
			
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

<div id="preset-regions" class="hidden-block">
<?php foreach (I3D_Framework::get_all_preset_configurations() as $short_code => $preset) { 
?>
  <div id="preset__<?php echo $short_code; ?>"><?php 
				foreach ($preset['columns'] as $column) { 
					
					if (!array_key_exists('widgets', $column)) {
						//$regionInfo['configuration']['widgets'] = array();
						$column['widgets'] 						= array();
					}
					//$columnWidth = $column['default-width'];
					?>
					
                <div class='example-span text-center'>
<?php 				foreach ($column['widgets'] as $widget) { 
						$widgetID = $row_id."__".$widget['class_name'];
												$myWidget = I3D_Framework::instantiate_widget($widget);
						?>
				<div class='alert alert-<?php if (@$widget['class_name']  == "I3D_Widget_SidebarRegion") { print "sidebar"; } else { print "widget"; }?> <?php echo "preset-".$widget['class_name']; ?>'>

						 <i class='pull-right fa fa-fw fa-angle-down fa-toggle-settings'></i>
						<h5><?php echo str_replace("i3d:", "", @$myWidget->name); ?></h5>
						<div class='popover-configurations-container'>
							  <div class='popover-configurations'>
							<?php
							if (@$widget['class_name']  != "I3D_Widget_SidebarRegion") {
							i3d_render_mobile_tablet_visibility_options(array(), "new_row", @$myWidget->id_base);	
					  }
							
							 // $myWidget = I3D_Framework::instantiate_widget(array("class_name" => $short_code));
							//  $myWidget = $wp_registered_widgets["$wid"]['callback'][0];
							  //var_dump($myWidget);
							  if (method_exists($myWidget, "layout_configuration_form")) {
							  	echo $myWidget->layout_configuration_form(array(), array(),  "new_row", @$myWidget->id_base, $layoutID); 
							  }
							  ?>
								
								</div>
							</div>
							<div class='region-widgets'></div>				  
						
						</div><!-- end alert alert-success -->
						<?php
					} ?>
					
                </div><!-- end example-span -->
<?php } // end of foreach column?>
</div>


<?php } ?>

</div>
	<script>
	
	var stored_visibility_settings = new Array();
	<?php foreach ($visibilitySettings as $id => $setting) { ?>
	stored_visibility_settings["<?php echo $id; ?>"] = "<?php echo $setting; ?>";
	<?php } ?>
	
jQuery.noConflict();

	jQuery(document).ready(function() {
									
		jQuery(".fa-toggle-section").bind("click", function() {
 			if (jQuery(this).hasClass("fa-angle-down")) {
				jQuery(this).removeClass("fa-angle-down");
				jQuery(this).addClass("fa-angle-up");
				
				jQuery(this).parents("table").find(".toggle-section").addClass("show");
				jQuery(this).parents("table").addClass("section-opened");
				/*
				jQuery(this).parents("table").find(".toggle-section").each(function() {
					 var newHeight = jQuery(this).innerHeight();
					 jQuery(this).height(newHeight);
				});
				*/
																																										
			} else {
				jQuery(this).removeClass("fa-angle-up");
				jQuery(this).addClass("fa-angle-down");
				//jQuery(this).parent().find(".toggle-section").removeClass("shown");
				jQuery(this).parents("table").removeClass("section-opened");
				
				jQuery(this).parents("table").find(".toggle-section").removeClass("show");
				//jQuery(this).parent().find(".toggle-section").height("0");
			}
		});
		
									jQuery(".fa-toggle-settings").bind("click", function() {
																						 if (jQuery(this).hasClass("fa-angle-down")) {
																							jQuery(this).removeClass("fa-angle-down");
																							jQuery(this).addClass("fa-angle-up");
																							
																							jQuery(this).parent().find(".popover-configurations-container").addClass("show");
																							
																							jQuery(this).parent().find(".popover-configurations-container").each(function() {
																																										  var newHeight = jQuery(this).find(".popover-configurations").innerHeight();
																																										  //alert(newHeight);
																																										  jQuery(this).height(newHeight);
																																										  });
																																										
																							
																							//jQuery(this).parent().find(".popover-configurations-container").height(jQuery(this).parent().find(".popover-configurations-container .popover-configurations").innerHeight());
																							//alert(jQuery(this).parent().find(".popover-configurations-container .popover-configurations").html());
																							//jQuery(this).parent().find(".popover-configurations-container").css("height", "auto");
																						 } else {
																							 jQuery(this).removeClass("fa-angle-up");
																							 jQuery(this).addClass("fa-angle-down");
																							 jQuery(this).parent().find(".popover-configurations-container").removeClass("shown");
																							 
																							 jQuery(this).parent().find(".popover-configurations-container").removeClass("show");
																							jQuery(this).parent().find(".popover-configurations-container").height("0");
																							// jQuery(this).parent().find(".popover-configurations-container").height(jQuery(this).parent().find(".popover-configurations-container .popover-configurations").innerHeight());
																						 }
																						 
																						 });
									
									jQuery("select.sidebar-select").bind("change", function() {
																							
																							var new_sidebar_name = "Undefined";
																							new_sidebar_name = jQuery(this).find(":selected").attr("rel");
																							//alert(new_sidebar_name);
																							new_sidebar_name = new_sidebar_name.replace(/\(.*\)/, '');
																							jQuery(this).parents(".alert-sidebar").find("h5 span").html(new_sidebar_name);
																							
																							var selectedSidebar = jQuery(this).val();
																							//alert(selectedSidebar);
																							if (selectedSidebar == "") {
																								selectedSidebar = jQuery(this).attr("rel");
																							}
																							var targetRegion = jQuery(this).parents(".alert-sidebar").find(".region-widgets");
																							//alert(targetRegion.length);

																							//alert(row_id);
																							var sourceRegion = jQuery(".sidebar-widgets").find(".__" + selectedSidebar);
																							//alert(sourceRegion.length);
																							targetRegion.html("There are no widgets in this sidebar.");
																							targetRegion.html(sourceRegion.html().replace(/alert-info/gi, "alert-widget"));	
																							var row_id = jQuery(targetRegion).parents("tr").attr("id").replace(/row__/, '');
																							targetRegion.html(sourceRegion.html().replace(/\[temp_row\]/gi, row_id));
																							
																							jQuery(targetRegion).find(".popover-configurations-container").bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function(){
																															  
																															  if (jQuery(this).hasClass("show")) {
																																jQuery(this).addClass("shown");  
																															  }
																															  });
																							targetRegion.find(".example-span").addClass("static");
																										jQuery(targetRegion).find(".popover-configurations-container").each(function() {
																						  var newHeight = jQuery(this).find(".popover-configurations").innerHeight();
																						  //alert(newHeight);
																						  jQuery(this).height(newHeight);
																						  
																						  });
																										


																							});

									jQuery("select.menu-select").bind("change", function() {
																							/*
																							special_target = jQuery(this).find(":selected").attr("rel");
																							if (special_target != "") {
																								alert(special_target);
																							}
																							
																							jQuery(this).parents(".alert-sidebar").find("h5 span").html(new_sidebar_name);
																							
																							var selectedSidebar = jQuery(this).val();
																							//alert(selectedSidebar);
																							if (selectedSidebar == "") {
																								selectedSidebar = jQuery(this).attr("rel");
																							}
																							var targetRegion = jQuery(this).parents(".alert-sidebar").find(".region-widgets");
																							//alert(targetRegion.length);

																							var sourceRegion = jQuery(".sidebar-widgets").find(".__" + selectedSidebar);
																							//alert(sourceRegion.length);
																							targetRegion.html("There are no widgets in this sidebar.");
																							targetRegion.html(sourceRegion.html().replace(/alert-info/gi, "alert-widget"));																				  
																							*/
																							});

									jQuery(".tt").tooltip();
									jQuery(".tt2").tooltip();
									jQuery(".btn-configure-widget").popover({'html' : true, 'content' : function() { return loadPopoverConfigurations(this); } });
									
									activateDeleteButtons();
									addToggleFunctionality();
									jQuery(".btn-add-divider").bind("click", function() {
																					  addRow("divider", jQuery(this).attr("rel"), "");
																					  });


									jQuery(".btn-add-widget").bind("click", function() {
																					 jQuery("#widgets-modal").find(".btn-insert-widget").attr("rel", jQuery(this).attr("rel"));
																					 // addRow("divider", jQuery(this).attr("rel"), "");
																					  });

									jQuery(".btn-add-sidebar").bind("click", function() {
																					  addRow("sidebar", jQuery(this).attr("rel"), "");
																					  });
									jQuery(".btn-insert-preset").bind("click", function() {
																						addRow("preset", jQuery(this).attr("rel"), jQuery(this).val());
																						
																						});
									jQuery(".btn-insert-widget").bind("click", function() {
																						addRow("widget", jQuery(this).attr("rel"), jQuery(this).val());
																						
																						});									
									/*
									jQuery(".btn-configure-widget").on('hidden.bs.popover', function () {
								 		var data = jQuery(this).data("bs.popover");
										var tip = data.tip();
															  
										jQuery(tip).find("input").each(function(){
											jQuery(this).attr("value", jQuery(this).val());
										});
										
										jQuery(tip).find("input[type=checkbox]").each(function(){
											jQuery(this).attr("checked", jQuery(this).is(":checked"));
										});															  
															  
										jQuery(tip).find("select").each(function(){
											var value = jQuery(this).val();
											jQuery(this).find("option").removeAttr("selected");
											jQuery(this).find("option[value='" + value + "']").attr("selected", "selected");
										});
															  
										var newHTML = tip.find(".popover-content").html();	
										jQuery(this).parent().find(".popover-configurations-container").html(newHTML);
										tip.find(".popover-content").html("");
															  
								
								
								});
									
									 jQuery(".btn-configure-widget").on('show.bs.popover', function() { 
										jQuery(this).parent().find(".popover-configurations-container").find("input").each(function(){
											jQuery(this).attr("value", jQuery(this).val());
										});
										
										jQuery(this).parent().find(".popover-configurations-container").find("input[type=checkbox]").each(function(){
											jQuery(this).attr("checked", jQuery(this).is(":checked"));
										});															  
															  
										jQuery(this).parent().find(".popover-configurations-container").find("select").each(function(){
											var value = jQuery(this).val();
											jQuery(this).find("option").removeAttr("selected");
											jQuery(this).find("option[value='" + value + "']").attr("selected", "selected");
										});
									 });
	
*/
jQuery(".popover-configurations-container").bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function(){
																															  
																															  if (jQuery(this).hasClass("show")) {
																																jQuery(this).addClass("shown");  
																															  }
																															  });

});
function loadPopoverConfigurations(element) {
	var html = jQuery(element).parent().find(".popover-configurations-container").html();
	jQuery(element).parent().find(".popover-configurations-container").html("");
	return html;
	
}
	
function activateDeleteButtons() {
	jQuery(".delete-button").not(".bound").on("click", function() {
		jQuery(this).parents("tr").remove();
	});
	jQuery(".delete-button").addClass("bound");
}

function getNewRowID() {
	var new_id = "";
	for (var i = 0; i < 99; i++) {
	  	new_id = "user-row-"  + i;
		if (jQuery("#row__" + new_id).length == 0 ) {
			return new_id;
		}
	}
	//alert(i);
	return "x";
}

function addRow(rowType, section, configuration) {
  
  
  var new_id = getNewRowID();
  if (new_id == "x") {
	  alert("Could not add row.  No rows available.");
      return;
  }
  
  var newRow = "";
  if (rowType == "divider") {
  	newRow = getNewDivider(new_id, section);
  } else if (rowType == "sidebar") {
	newRow = getNewSidebar(new_id, section);  
  } else if (rowType == "preset") {
	newRow = getNewPreset(new_id, section, configuration);
	//alert(configuration);
  } else if (rowType == "widget") {
	newRow = getNewWidget(new_id, section, configuration); 
  } 
  if (newRow != "") {
	if (jQuery("table#sortable-" + section + " tbody tr.not-sortable").length == 1) {
		jQuery("table#sortable-" + section + " tbody tr.not-sortable:first-of-type").after(newRow);
	} else if (jQuery("table#sortable-" + section + " tbody tr.not-sortable").length > 0) {
		jQuery("table#sortable-" + section + " tbody tr.not-sortable:nth-of-type(" + jQuery("table#sortable-" + section + " tbody tr.not-sortable").length + ")").after(newRow);
	
	} else {
		jQuery("table#sortable-" + section + " tbody tr:first-of-type").before(newRow);
		
	}
	
	setTimeout("switch_alert_class('"+section + "')", 1000);
	
	//alert(jQuery("#sortable-" + section + "").length);
	if (rowType == "preset") {
		setupSlider(jQuery("#row__" + new_id).find(".slider-range"), "", 0);	

		jQuery("#row__" + new_id + " .fa-toggle-settings").bind("click", function() {
																						 if (jQuery(this).hasClass("fa-angle-down")) {
																							jQuery(this).removeClass("fa-angle-down");
																							jQuery(this).addClass("fa-angle-up");
																							
																							jQuery(this).parent().find(".popover-configurations-container").addClass("show");
																																														
																							jQuery(this).parent().find(".popover-configurations-container").each(function() {
																																										  var newHeight = jQuery(this).find(".popover-configurations").innerHeight();
																																										  //alert(newHeight);
																																										  jQuery(this).height(newHeight);
																																										  });

																							
																						//	jQuery(this).parent().find(".popover-configurations-container").height(jQuery(this).parent().find(".popover-configurations-container .popover-configurations").innerHeight());
																							
																							//jQuery(this).parent().find(".popover-configurations-container").css("height", "auto");
																						 } else {
																							 jQuery(this).removeClass("fa-angle-up");
																							 jQuery(this).addClass("fa-angle-down");
																							 jQuery(this).parent().find(".popover-configurations-container").removeClass("shown");
																							 
																							 jQuery(this).parent().find(".popover-configurations-container").removeClass("show");
																							jQuery(this).parent().find(".popover-configurations-container").height("0");
																							// jQuery(this).parent().find(".popover-configurations-container").height(jQuery(this).parent().find(".popover-configurations-container .popover-configurations").innerHeight());
																						 }
																						 
																						 });	
		
									
										jQuery("#row__" + new_id + " select.sidebar-select").bind("change", function() {
																													
																							var new_sidebar_name = "Undefined";
																							new_sidebar_name = jQuery(this).find(":selected").attr("rel");
																							//alert(new_sidebar_name);
																							new_sidebar_name = new_sidebar_name.replace(/\(.*\)/, '');
																							jQuery(this).parents(".alert-sidebar").find("h5 span").html(new_sidebar_name);
																							
																							var selectedSidebar = jQuery(this).val();
																							//alert(selectedSidebar);
																							if (selectedSidebar == "") {
																								selectedSidebar = jQuery(this).attr("rel");
																							}
																						//	alert(selectedSidebar);
																							var targetRegion = jQuery(this).parents(".alert-sidebar").find(".region-widgets");
																							//alert(targetRegion.length);

																							var sourceRegion = jQuery(".sidebar-widgets").find(".__" + selectedSidebar);
																							//alert(sourceRegion.length);
																							//alert(sourceRegion.html());
																							
																							targetRegion.html("There are no widgets in this sidebar.");
																							targetRegion.html(sourceRegion.html().replace(/alert-info/gi, "alert-widget"));		
																							var row_id = jQuery(targetRegion).parents("tr").attr("id").replace(/row__/, '');
																							targetRegion.html(sourceRegion.html().replace(/\[temp_row\]/gi, row_id));																							
																							
																							targetRegion.find(".example-span").addClass("static");
																										jQuery(targetRegion).find(".popover-configurations-container").each(function() {
																						  var newHeight = jQuery(this).find(".popover-configurations").innerHeight();
																						  //alert(newHeight);
																						  jQuery(this).height(newHeight);
																						  });
																							});	
	} else if (rowType == "widget") {
		//alert(new_id);
jQuery("#row__" + new_id + " .fa-toggle-settings").bind("click", function() {
																						 if (jQuery(this).hasClass("fa-angle-down")) {
																							jQuery(this).removeClass("fa-angle-down");
																							jQuery(this).addClass("fa-angle-up");
																							
																							jQuery(this).parent().find(".popover-configurations-container").addClass("show");
																							
																																														
																							jQuery(this).parent().find(".popover-configurations-container").each(function() {
																																										  var newHeight = jQuery(this).find(".popover-configurations").innerHeight();
																																										  //alert(newHeight);
																																										  jQuery(this).height(newHeight);
																																										  });

																							//jQuery(this).parent().find(".popover-configurations-container").height(jQuery(this).parent().find(".popover-configurations-container .popover-configurations").innerHeight());
																							
																							//jQuery(this).parent().find(".popover-configurations-container").css("height", "auto");
																						 } else {
																							 jQuery(this).removeClass("fa-angle-up");
																							 jQuery(this).addClass("fa-angle-down");
																							 jQuery(this).parent().find(".popover-configurations-container").removeClass("shown");
																							 
																							 jQuery(this).parent().find(".popover-configurations-container").removeClass("show");
																							jQuery(this).parent().find(".popover-configurations-container").height("0");
																							// jQuery(this).parent().find(".popover-configurations-container").height(jQuery(this).parent().find(".popover-configurations-container .popover-configurations").innerHeight());
																						 }
																						 
																						 });		
		
	}
  //	jQuery("table.layout-table tbody").append(newRow);
	activateDeleteButtons();
	addToggleFunctionality();
  }
}

function switch_alert_class(section) {
	jQuery("#sortable-" + section).find(".alert-success").addClass("alert-widget").removeClass("alert-success");
}

function getNewDivider(new_id, section) {
	  var newRow = '<tr class="row__' + new_id + '" id="row__' + new_id + '">' +
			   '<td class="column-0">' +
				  '<i class="fa fa-fw fa-status-toggle fa-toggle-on"></i>' +
				  '<input type="hidden" name="' + new_id + '__status" value="enabled">' + 
				  '<input type="hidden" name="' + new_id + '__orderable" value="1">' + 
				  '<input type="hidden" name="' + new_id + '__section" value="' + section + '">' + 
				'</td>' +
                '<td class="column-1">' + 
				  '<i class="fa fa-fw fa-reorder ui-sortable-handle"></i>' + 
				  '<input type="text" class="form-control" name="' + new_id + '__title" value="Divider">' + 
				  '<input type="hidden" name="' + new_id + '__type" value="divider">' + 
				'</td>' + 
				'<td>' + 
				'<div class="delete-button">Delete</div>' +
					'<div class="text-center">' + 
                		'<div class="input-group tt input-group-collapsed" title="" data-original-title="Divider Style">' + 
        					'<span class="input-group-addon"><i class="icon-minus"></i></span>' + 
							'<select class="form-control layout-bg-select" id="__layout_row__' + new_id + '_styles" name="' + new_id + '__styles">' + 
							'<?php echo i3d_renderSelectOptions(I3D_Framework::$globalPageDividers, $row['styles']); ?>' + 
							'</select>' + 
                    	'</div>' + 
                    '</div>' +                      
         			'<input type="hidden" name="rows[]" value="' + new_id + '">' + 
                '</td>' + 
			'</tr>';
	return newRow;
}

function getNewSidebar(new_id, section) {
  var newRow = '<tr id="row__' + new_id + '" class="row__' + new_id + ' enabled">' +
			     '<td class="column-0">' + 
				   '<i class="fa fa-fw fa-status-toggle fa-toggle-on"></i>' + 
				   '<input type="hidden" name="' + new_id + '__status" value="enabled">' +
				  '<input type="hidden" name="' + new_id + '__stylable" value="1">' + 
				  '<input type="hidden" name="' + new_id + '__orderable" value="1">' + 
				  '<input type="hidden" name="' + new_id + '__section" value="' + section + '">' + 
				'</td>' + 
                '<td class="column-1">' + 
				   '<i class="fa fa-fw fa-reorder ui-sortable-handle"></i>' + 
                   '<input type="text" class="form-control" name="' + new_id + '__title" value="Sidebar Region">' + 
				   '<input type="hidden" name="' + new_id + '__type" value="sidebar">' + 
				'</td>' + 
				'<td>' + 
				  '<div class="delete-button">Delete</div>' + 
  					 '<div class="row clearfix">' + 
                		'<div class="col-sm-3">' + 
                    		'<div class="input-group pull-left tt" title="" data-original-title="Sidebar associated with this Region">' +
        						'<span class="input-group-addon"><i class="fa fa-fw fa-file-text"></i></span>' +
								'<select class="__layout_regions__' + new_id + '__sidebar layout-sidebar-select form-control" name="' + new_id + '__sidebar" onchange="handleSidebarChange(this)">' +
								'<?php display_sidebar_options2(""); ?>' + 
								'</select>' +
                    		'</div>' +      
                    	'</div>' + 
						'<div class="text-center col-sm-3 visible-when-sidebar-exists non-visible">' + 
                			'<div class="input-group tt" title="" data-original-title="Background Style">' +
        						'<span class="input-group-addon"><i class="icon-tint"></i></span>' + 
								'<select class="layout-bg-select form-control" id="' + new_id + '__styles" name="' + new_id + '__styles">' + 
								'<?php echo i3d_renderSelectOptions(array_merge(I3D_Framework::$optionalStyledBackgrounds, $optionalActiveBackgrounds), $row['styles']); ?>' +          			
								'</select>' + 
                    		'</div>' +
                    	'</div>' +
						'<div class="text-center col-sm-3 visible-when-sidebar-exists non-visible">' + 
                		  '<div class="input-group tt" title="" data-original-title="Number of Columns">' + 
        				    '<span class="input-group-addon"><i class="icon-columns"></i></span>' + 
						    '<select class="layout-columns-select form-control" id="' + new_id + '__columns" name="' + new_id + '__columns">' + 
                    	      '<option value="0" selected="selected">Auto&nbsp;</option><option value="1">1&nbsp;</option><option value="2">2&nbsp;</option><option value="3">3&nbsp;</option><option value="4">4&nbsp;</option><option value="5">5&nbsp;</option><option value="6">6&nbsp;</option>' +
						    '</select>' + 
                    	  '</div>' + 
                		'</div>' + 
                		'<div class="col-sm-3 visible-when-sidebar-exists non-visible">' + 
                    	  '<div class="pull-right input-group tt" title="" data-original-title="Region Width: Either Full-Screen, or Contained">' + 
							'<span class="input-group-addon"><i class="icon-resize-horizontal"></i></span>' +
                        	'<select class="layout-width-select form-control" id="' + new_id + '__width" name="' + new_id + '__width">' + 
                        	  '<option value="contained" selected="selected">Contained&nbsp;</option><option value="fullscreen">Full Screen&nbsp;</option>' +
							'</select>' +   
                    	  '</div>' +      
                	    '</div>' + 
            		  '</div>' +  
            		  '<div class="row-fluid visible-when-sidebar-exists non-visible">' + 
						'<input class="input-mini layout-holder" type="hidden" id="' + new_id + '__layout" name="' + new_id + '__layout" value="4|4|4">' + 
						'<div data-toggle="tooltip" class="slider-range"></div>' +
						'<div class="row region-widgets"></div>' +                  
         				'<input type="hidden" name="rows[]" value="' + new_id + '">' + 
                	  '</div>' +
					'</td>' + 
                  '</tr>';
	return newRow;
}

function getNewPreset(new_id, section, configuration) {

	var newRow = '<tr id="row__' + new_id + '" class="row__' + new_id + ' enabled">' +
			     '<td class="column-0">' + 
				   '<i class="fa fa-fw fa-status-toggle fa-toggle-on"></i>' + 
				   '<input type="hidden" name="' + new_id + '__status" value="enabled">' +
				  '<input type="hidden" name="' + new_id + '__stylable" value="1">' + 
				  '<input type="hidden" name="' + new_id + '__orderable" value="1">' + 
				  '<input type="hidden" name="' + new_id + '__width" value="">' + 
				  '<input type="hidden" name="' + new_id + '__columns" value="0">' + 
				  '<input type="hidden" name="' + new_id + '__section" value="' + section + '">' + 
				'</td>' + 
                '<td class="column-1">' + 
				   '<i class="fa fa-fw fa-reorder ui-sortable-handle"></i>' + 
                   '<input type="text" class="form-control" name="' + new_id + '__title" value="Special Region">' + 
				   '<input type="hidden" name="' + new_id + '__type" value="preset">' + 
				   '<input type="hidden" name="' + new_id + '__presets" value="' + configuration + '">' + 
				'</td>' + 
				'<td>' + 
				  '<div class="delete-button">Delete</div>' + 
            		  '<div class="row-fluid visible-when-sidebar-exists">' + 
						'<input class="input-mini layout-holder" type="hidden" id="' + new_id + '__layout" name="' + new_id + '__layout" value="4|4|4">' + 
						'<div data-toggle="tooltip" class="slider-range"></div>' +
						'<div class="row region-widgets">' + jQuery("#preset__" + configuration).html() + '</div>' +                  
         				'<input type="hidden" name="rows[]" value="' + new_id + '">' + 
                	  '</div>' +
					'</td>' + 
                  '</tr>';
	return newRow;
}

function getNewWidget(new_id, section, configuration) {

	var newRow = '<tr id="row__' + new_id + '" class="row__' + new_id + ' enabled">' +
			     '<td class="column-0">' + 
				   '<i class="fa fa-fw fa-status-toggle fa-toggle-on"></i>' + 
				   '<input type="hidden" name="' + new_id + '__status" value="enabled">' +
				  '<input type="hidden" name="' + new_id + '__stylable" value="1">' + 
				  '<input type="hidden" name="' + new_id + '__orderable" value="1">' + 
				  '<input type="hidden" name="' + new_id + '__width" value="">' + 
				  '<input type="hidden" name="' + new_id + '__columns" value="1">' + 
				  '<input type="hidden" name="' + new_id + '__section" value="' + section + '">' + 
				'</td>' + 
                '<td class="column-1">' + 
				   '<i class="fa fa-fw fa-reorder ui-sortable-handle"></i>' + 
                   '<input type="text" class="form-control" name="' + new_id + '__title" value="Single Widget">' + 
				   '<input type="hidden" name="' + new_id + '__type" value="widget">' + 
				   '<input type="hidden" name="' + new_id + '__widget" value="' + configuration + '">' + 
				'</td>' + 
				'<td class="make-it-wide">' + 
				  '<div class="delete-button">Delete</div>' + 
				  
  					 '<div class="row clearfix">' + 

						'<div class="text-center col-sm-6 visible-when-sidebar-exists">' + 
                			'<div class="input-group tt" title="" data-original-title="Background Style">' +
        						'<span class="input-group-addon"><i class="icon-tint"></i></span>' + 
								'<select class="layout-bg-select form-control" id="' + new_id + '__styles" name="' + new_id + '__styles">' + 
								'<?php echo i3d_renderSelectOptions(array_merge(I3D_Framework::$optionalStyledBackgrounds, $optionalActiveBackgrounds), $row['styles']); ?>' +          			
								'</select>' + 
                    		'</div>' +
                    	'</div>' +

                		'<div class="col-sm-6 visible-when-sidebar-exists">' + 
                    	  '<div class="pull-right input-group tt" title="" data-original-title="Region Width: Either Full-Screen, or Contained">' + 
							'<span class="input-group-addon"><i class="icon-resize-horizontal"></i></span>' +
                        	'<select class="layout-width-select form-control" id="' + new_id + '__width" name="' + new_id + '__width">' + 
                        	  '<option value="contained" selected="selected">Contained&nbsp;</option><option value="fullscreen">Full Screen&nbsp;</option>' +
							'</select>' +   
                    	  '</div>' +      
                	    '</div>' + 
            		  '</div>' +  
				  
				  
            		  '<div class="row-fluid visible-when-sidebar-exists">' + 
						'<input class="input-mini layout-holder" type="hidden" id="' + new_id + '__layout" name="' + new_id + '__layout" value="12">' + 
						
						'<div class="row region-widgets">' + jQuery("#widget__" + configuration).html().replace(/new_row/gi, new_id) + '</div>' +                  
         				'<input type="hidden" name="rows[]" value="' + new_id + '">' + 
                	  '</div>' +
					'</td>' + 
                  '</tr>';
	return newRow;
}


function handleSidebarChange(selectBox) {
	var selectedSidebar = selectBox.options[selectBox.selectedIndex].value;
	var selectBoxName = jQuery(selectBox).attr("class").replace(" layout-sidebar-select form-control", "");
	//alert(selectBoxName);
	var sourceRegion = jQuery(".sidebar-widgets").find(".__" + selectedSidebar);
	if (selectedSidebar == "" || selectedSidebar == "x") {
		jQuery("select." + selectBoxName).each(function() {
			jQuery(this).parents("td").find(".visible-when-sidebar-exists").addClass("non-visible");
			var targetRegion = jQuery(this).parents("td").find(".region-widgets");
			jQuery(targetRegion).html("");
			conditionRegionWidgets(this);
		jQuery(targetRegion).find(".popover-configurations-container").bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function(){
																															
																															  if (jQuery(this).hasClass("show")) {
																																jQuery(this).addClass("shown");  
																															  }
																															  });			
		});
		
	} else {
		jQuery("select." + selectBoxName).each(function() {
			jQuery(this).parents("td").find(".visible-when-sidebar-exists").removeClass("non-visible");
			var targetRegion = jQuery(this).parents("td").find(".region-widgets");
			jQuery(targetRegion).html(jQuery(sourceRegion).html());
			conditionRegionWidgets(this);
			
			jQuery(targetRegion).find(".popover-configurations-container").bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function(){
																															 
																															  if (jQuery(this).hasClass("show")) {
																																jQuery(this).addClass("shown");  
																															  }
																															  });			
		});
	}	
	

	
		var columns = jQuery(selectBox).parents("tr").find("select.layout-columns-select").val();
		//alert(columns);
		if (columns == 0) {
			mySlider = jQuery(selectBox).parents("tr").find(".slider-range");
			myValues = "";
			var attr = jQuery(mySlider).attr("data-original-title");
			if (typeof attr !== typeof undefined) {
				
				jQuery(mySlider).slider("destroy");
			}
			setupSlider(mySlider, myValues, columns);
		}
}

function conditionRegionWidgets(selectBox) {
	var theSlider = jQuery(selectBox).parents("td").find(".slider-range");
	jQuery(theSlider).parent().find(".example-span").find(".fa-toggle-settings").bind("click", function() {
																										
																						 if (jQuery(this).hasClass("fa-angle-down")) {
																							jQuery(this).removeClass("fa-angle-down");
																							jQuery(this).addClass("fa-angle-up");
																							
																							jQuery(this).parent().find(".popover-configurations-container").addClass("show");
																							jQuery(this).parent().find(".popover-configurations-container").height(jQuery(this).parent().find(".popover-configurations-container .popover-configurations").innerHeight());
																							
																							//jQuery(this).parent().find(".popover-configurations-container").css("height", "auto");
																						 } else {
																							 jQuery(this).removeClass("fa-angle-up");
																							 jQuery(this).addClass("fa-angle-down");
																							 jQuery(this).parent().find(".popover-configurations-container").removeClass("shown");
																							 
																							 jQuery(this).parent().find(".popover-configurations-container").removeClass("show");
																							jQuery(this).parent().find(".popover-configurations-container").height("0");
																							// jQuery(this).parent().find(".popover-configurations-container").height(jQuery(this).parent().find(".popover-configurations-container .popover-configurations").innerHeight());
																						 }
																										});
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
	//setSpecialCTAFields(layout);
}
		
function setupSlider(theSlider, selectedValues, columns) {
	//alert(columns);
	if (columns == 0 || columns == "" || columns == undefined ) { 
	//alert("yup");
	    columns = jQuery(theSlider).parent().find(".example-span").not(".static").length;
		//jQuery(theSlider).parent().find("input.layout-holder").val("12");
		//jQuery(theSlider).parent().find(".slider-range").slider({min: 0, max: 12, values: [12], slide: function(event, ui) { return handleSlide(event, ui, this); }} );
		//jQuery(theSlider).parent().find(".slider-range").slider("disable");
	
	} 
	if (columns == "") {
		columns = 1;
	}
	//alert(columns);
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
		  //alert(myValues);
		  jQuery(theSlider).parent().find(".slider-range").slider({min: 0, max: 12, values: myValues, slide: function(event, ui) { return handleSlide(event, ui, this); }} );
		  
		  //jQuery(theSlider).parent().find(".slider-range").slider("disable");
	} 
  	jQuery(theSlider).parent().find(".example-span").not(".static").each(function(index) {
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
  
	jQuery(".slider-range").tooltip({ trigger: 'hover focus click', placement : "top", title: function() { 
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
	jQuery(theSlider).parent().find(".example-span").not(".static").each(function(index) {															 
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
		//alert(jQuery(mySlider).data("slider"));
			var attr = jQuery(mySlider).attr("data-original-title");
						

			if (typeof attr !== typeof undefined ) {
				jQuery(mySlider).slider("destroy");
			}
		setupSlider(mySlider, myValues, jQuery(this).val());
	});			
	
	jQuery(".slider-range").each(function() {
		currentValues = jQuery(this).parents("tr").find("input.layout-holder").val();
		
		var columns = jQuery(this).parents("tr").find("select.layout-columns-select").val();
		
		setupSlider(this, currentValues, columns);
	});
	
	jQuery("#page_template").bind("change", function() {
		var selectedLayout = jQuery(this).val();
		setSidebars(selectedLayout);
		setSpecialRegions(selectedLayout);
	});
	
	setSidebars(jQuery("#page_template").val());
	//setSpecialRegions(jQuery("#page_template").val());
  	
	jQuery(".tt").tooltip();
	jQuery(".icon-tooltip").tooltip();
	

									jQuery("select.sidebar-select").each(function() {
																				
																							//new_sidebar_name = jQuery(this).find(":selected").attr("rel");
																							//alert(new_sidebar_name);
																							//new_sidebar_name = new_sidebar_name.replace(/\(.*\)/, '');
																							//jQuery(this).parents(".alert-sidebar").find("h5 span").html(new_sidebar_name);
																							
																							var selectedSidebar = jQuery(this).val();
																							if (selectedSidebar == "") {
																								selectedSidebar = jQuery(this).attr("rel");
																							}
																							if (selectedSidebar != "") {
																							var targetRegion = jQuery(this).parents(".alert-sidebar").find(".region-widgets");
																							//alert(targetRegion.length);

																							var sourceRegion = jQuery(".sidebar-widgets").find(".__" + selectedSidebar);
																							targetRegion.html("There are no widgets in this sidebar.");

//alert(selectedSidebar);
																							if (!sourceRegion.html()) {
																								//alert('yup');
																								return;
																							}		
																							targetRegion.html(sourceRegion.html().replace(/alert-info/gi, "alert-widget"));	
																							//alert(jQuery(targetRegion).html());
																							if (!targetRegion.html()) {
																								//alert('yup');
																								return;
																							}																							//alert(targetRegion.html());
																							
																							var row_id = jQuery(targetRegion).parents("tr").attr("id").replace(/row__/, '');
																							targetRegion.html(sourceRegion.html().replace(/\[temp_row\]/gi, row_id));																							
																							
																							targetRegion.find(".example-span").addClass("static");
																							
																							jQuery(targetRegion).find(".popover-configurations-container").each(function() {
																						  		if (jQuery(this).parents('.region-widgets').length == 0) {
																									var newHeight = jQuery(this).find(".popover-configurations").innerHeight();
																								
																						  //alert(newHeight);
																						  			jQuery(this).height(newHeight);
																								} else {
																								jQuery(this).bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function(){
																															  
																															  if (jQuery(this).hasClass("show")) {
																																jQuery(this).addClass("shown");  
																															  }
																															  });
	
																								}
																								
																								jQuery(this).find("[rel='visibility']").each(function() {
																																					  var visibility_id = jQuery(this).attr("id");
																																					  var widget_id = jQuery(this).parent("span").attr("rel");
																																					  
																																					  jQuery(this).val(stored_visibility_settings[visibility_id]);
																																					  jQuery(this).addClass(stored_visibility_settings[visibility_id]);
																																					  conditionWidgetVisibilityButtons(row_id, widget_id, stored_visibility_settings[visibility_id]);
																																					jQuery(this).find('.dropdown-toggle').dropdown();
																																					//  alert();
																																					  });
																								
																						  		});																								
																							}
																				  });		
});


function setSidebars(layout) {
	//var layout = layout.replace(/.php/, '');
	jQuery(".optional-sidebars tr.configurable").addClass("non-editable");
	jQuery(".optional-sidebars tr." + layout).removeClass("non-editable");

}
function setSpecialRegions(layout) {
	//var layout = layout.replace(/.php/, '');
	//layout = layout.replace(/template-/, '');
	jQuery(".special-region").addClass("non-visible");
	var count = jQuery("." + layout).removeClass("non-visible");
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


function toggleWidgetVisibility(scope, widgetID, row) {
	if (scope == "mobile") {
		if (jQuery("#" + row + "__visibility__" + widgetID).hasClass("hidden-xs")) {
			setWidgetVisibility(scope, widgetID, row, true);  
		} else {
			setWidgetVisibility(scope, widgetID, row, false);  
		}
	} else {
		if (jQuery("#" + row + "__visibility__" + widgetID).hasClass("hidden-sm")) {
			setWidgetVisibility(scope, widgetID, row, true);  
		} else {
			setWidgetVisibility(scope, widgetID, row, false);  
		}
		
	}
}

function conditionWidgetVisibilityButtons(row, widgetID, visibility) {
//	alert(visibility);
  if (typeof(visibility) != 'undefined' && visibility.search("hidden-xs") != -1) {
	  
			jQuery("#" + row + "__visibility__" + widgetID + "__mobile").parent().find(".btn").addClass("btn-danger");
			jQuery("#" + row + "__visibility__" + widgetID + "__mobile").parent().find(".btn").removeClass("btn-success");
			jQuery("#" + row + "__visibility__" + widgetID + "__mobile").parent().find(".btn span").removeClass("icon-ok");
			jQuery("#" + row + "__visibility__" + widgetID + "__mobile").parent().find(".btn span").addClass("icon-remove");
	  
  } else {

			jQuery("#" + row + "__visibility__" + widgetID + "__mobile").parent().find(".btn").addClass("btn-success");
			jQuery("#" + row + "__visibility__" + widgetID + "__mobile").parent().find(".btn").removeClass("btn-danger");
			jQuery("#" + row + "__visibility__" + widgetID + "__mobile").parent().find(".btn span").removeClass("icon-remove");
			jQuery("#" + row + "__visibility__" + widgetID + "__mobile").parent().find(".btn span").addClass("icon-ok");

  }

  if (typeof(visibility) != 'undefined' && visibility.search("hidden-sm") != -1) {
			jQuery("#" + row + "__visibility__" + widgetID + "__tablet").parent().find(".btn").addClass("btn-danger");
			jQuery("#" + row + "__visibility__" + widgetID + "__tablet").parent().find(".btn").removeClass("btn-success");
			jQuery("#" + row + "__visibility__" + widgetID + "__tablet").parent().find(".btn span").removeClass("icon-ok");
			jQuery("#" + row + "__visibility__" + widgetID + "__tablet").parent().find(".btn span").addClass("icon-remove");
	  
  } else {
			jQuery("#" + row + "__visibility__" + widgetID + "__tablet").parent().find(".btn").addClass("btn-success");
			jQuery("#" + row + "__visibility__" + widgetID + "__tablet").parent().find(".btn").removeClass("btn-danger");
			jQuery("#" + row + "__visibility__" + widgetID + "__tablet").parent().find(".btn span").removeClass("icon-remove");
			jQuery("#" + row + "__visibility__" + widgetID + "__tablet").parent().find(".btn span").addClass("icon-ok");
	  
  }

}

function setWidgetVisibility(scope, widgetID, row, value) {
	if (value) {
		if (scope == "mobile") {
			jQuery("#" + row + "__visibility__" + widgetID).removeClass("hidden-xs");
			jQuery("#" + row + "__visibility__" + widgetID + "__mobile").parent().find(".btn").addClass("btn-success");
			jQuery("#" + row + "__visibility__" + widgetID + "__mobile").parent().find(".btn").removeClass("btn-danger");
			jQuery("#" + row + "__visibility__" + widgetID + "__mobile").parent().find(".btn span").removeClass("icon-remove");
			jQuery("#" + row + "__visibility__" + widgetID + "__mobile").parent().find(".btn span").addClass("icon-ok");
		} else if (scope == "tablet") {
			jQuery("#" + row + "__visibility__" + widgetID).removeClass("hidden-sm");		
			jQuery("#" + row + "__visibility__" + widgetID + "__tablet").parent().find(".btn").addClass("btn-success");
			jQuery("#" + row + "__visibility__" + widgetID + "__tablet").parent().find(".btn").removeClass("btn-danger");
			jQuery("#" + row + "__visibility__" + widgetID + "__tablet").parent().find(".btn span").removeClass("icon-remove");
			jQuery("#" + row + "__visibility__" + widgetID + "__tablet").parent().find(".btn span").addClass("icon-ok");
		}
	} else {
		if (scope == "mobile") {
			jQuery("#" + row + "__visibility__" + widgetID).addClass("hidden-xs");
			jQuery("#" + row + "__visibility__" + widgetID + "__mobile").parent().find(".btn").addClass("btn-danger");
			jQuery("#" + row + "__visibility__" + widgetID + "__mobile").parent().find(".btn").removeClass("btn-success");
			jQuery("#" + row + "__visibility__" + widgetID + "__mobile").parent().find(".btn span").removeClass("icon-ok");
			jQuery("#" + row + "__visibility__" + widgetID + "__mobile").parent().find(".btn span").addClass("icon-remove");
		} else if (scope == "tablet") {
			jQuery("#" + row + "__visibility__" + widgetID).addClass("hidden-sm");		
			jQuery("#" + row + "__visibility__" + widgetID + "__tablet").parent().find(".btn").addClass("btn-danger");
			jQuery("#" + row + "__visibility__" + widgetID + "__tablet").parent().find(".btn").removeClass("btn-success");
			jQuery("#" + row + "__visibility__" + widgetID + "__tablet").parent().find(".btn span").removeClass("icon-ok");
			jQuery("#" + row + "__visibility__" + widgetID + "__tablet").parent().find(".btn span").addClass("icon-remove");
		}
		  
	}
  	
	var className = jQuery("#" + row + "__visibility__" + widgetID).attr("class");
	jQuery("#" + row + "__visibility__" + widgetID).val(className);
  
}
	
	</script>
	<?php

}
function i3d_layouts_contextual_help( $contextual_help, $screen_id, $screen ) { 
		if (I3D_Framework::$supportType == "i3d" || true) { 

	if (strstr($screen->id, '_page_i3d_layouts')) {
		ob_start();
		if (@$_GET['layout'] != "" && @$_GET['action'] == "edit") { ?>
        <h3>Layout Editor</h3>
        <p>You can add as many rows to your page layout as you wish.  Just click the "Preset/Sidebar/Widget" button to insert a new row to a section of your page.</p>
        <?php if (@I3D_Framework::$defaultLayouts["{$_GET['layout']}"]) { ?>
        <p><strong>Special Operations</strong></p>
        <ul>
        	<li><a href="?page=i3d_layouts&cmd=revert&layout=<?php echo $_GET['layout']; ?>">Revert this layout original default version included with this theme (this cannot be undone, so think before you click!)</a></li>
        </ul>
			<?php
		}
		} else {
		?>
        <h3>Layout Editor</h3>
        <p>You can create as many layouts as you need for your website.  Click on the "<strong>Add New</strong>" button below to create a new form.</p>
        
        <p><strong>Special Operations</strong></p>
        <ul>
        	<!--<li><a onclick='return confirm("Are you certain you wish to delete all of your layouts? This cannot be undone.")' href="?page=i3d_layouts&cmd=reset">Delete All Layouts</a> <span class='label label-danger'>Warning -- this cannot be undone!</span></li>-->
        	<li><a href="?page=i3d_layouts&cmd=init">Install/Revert Default Layouts</a></li>
        </ul>
        <?php
		
		}
		$contextual_help = ob_get_clean();

	} 
		}
	return $contextual_help;
}
add_action( 'contextual_help', 'i3d_layouts_contextual_help', 10, 3 );

function i3d_sort_layouts($a, $b) {
  return @$a['title'] < @$b['title'] ? -1 : 1;	
}
?>