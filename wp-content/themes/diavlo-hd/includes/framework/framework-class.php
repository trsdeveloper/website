<?php
global $pagenow;

// the updater is only available in non-ThemeForest themes
if (is_admin() && $pagenow != "update-core.php"  && file_exists(get_template_directory()."/includes/framework/classes/updater-class.php")) {
  	include("classes/updater-class.php");
  	$aquilaUpdater = new Aquila_Updater();
  	$aquilaUpdater->__init();
}

if (file_exists(get_template_directory()."/includes/framework/framework-extensions.php")) {
	include("framework-extensions.php");
} 


class I3D_Framework {
	var $pages = array();
	var $allPages = array();
	var $doFullInstall;
	public static $defaultWidgets;
	public static $debugOn;
	public static $lastDebugTime;
	public static $startTime;
	public static $doWidgetInstall;
	public static $version		= '4.4.6';
	public static $versionName 	= 'Aquila';
	public static $configurationName = 'All-Purpose';
	public static $conditionPeriod;
	public static $embedded_style_css = true;
	public static $conditionOffset;
	public static $socialMediaIconVersion;
	public static $owlCarouselSocialMediaVersion = 0;
	public static $navbarVersion;
	public static $logoStyles = array();
	public static $adjustNavbar = true;
	public static $primaryNavbarCanHaveSubtitle = false;
	public static $quickLinksVersion;
	public static $textLinksVersion = 1;
	public static $searchBoxVersion;
	public static $logoVersion;
	public static $bootstrapVersion;
	public static $parallaxSliderVersion;
	public static $breadcrumbVersion = 1;
	public static $fontAwesomeVersionDefinable = false;
	public static $fontAwesomeVersion;
	public static $fontAwesomeVersion_4x = "4.5.0";
	public static $fontAwesomeVersion_latest = "4.5.0";
	public static $optionalStyledBackgrounds = array();
	public static $optionalStyledFooterBackgrounds = array();
	public static $optionalPageStyledEdges     = array();
	public static $optionalPageInnerBackground = array();
	public static $optionalPageOuterBackground = array();
	public static $defaultVectorIcon = 'icon-leaf';
	public static $infoBoxVersion;
	public static $default_contact_panel_width = array(0 => "", 1 => "12", 2 => "6|6", 3 => "4|4|4", 4 => "3|3|3|3", 5 => "3|3|2|2|2", 6 => "2|2|2|2|2|2");
	
	public static $numTopMenuItems = 6;
	public static $layoutVersion;
	public static $renamedSidebars;
	public static $contactPanelVersion = 0;
	public static $fullScreenSliderVersion = 0;
	public static $callToActionVersion = 1;	
	public static $isotopePortfolioVersion = 0;	
	public static $quotatorVersion = 1;	
	public static $infoBoxSliderVersion = 0;
	public static $animatedLogoVersion = 0;
	public static $contentPanelGroupVersion = 1;	
	public static $fullscreenCarouselVersion = 1;
	public static $jumbotronCarouselVersion  = 1;
	public static $focalBoxVersion = 0;
	public static $formDescriptionWrapperTag  = "p";
	public static $wrapOneColumnWithRow  = false; // added in Portico
	public static $useContactPanelForm 	 = false;
	public static $initForm = array('standard-contact-page' => true, 'standard-contact-box' => true);
	public static $initMenusWithIcons  = true;
	public static $boxStyles  = array();
	public static $boxStylesTitleWrap = array();
	public static $boxMargins = array();
	public static $portfolioStyles  = array();
	public static $initSubVerticalMenu = false;
	protected static $sliders;
	public static $templateRegions;
	public static $teamMemberPhotos = "holder";
	private static $userViewFilePath = '/includes/user_view';
	private static $updateURL = "http://wordpress.server-apps.com/update/";
	public static $eventsCalendarSupport = false;
	public static $updateLog = array();
	public static $supportType = "i3d";
	public static $useTimThumb = true;
	public static $themeStyleOptions = array();
	public static $init_push_time = 0;
	public static $animationClasses = array();
	public static $htmlBoxWidgetLayouts = array();
	public static $callToActionStyles = array();
	public static $globalSearchVersion = 1;
	public static $reorderedSidebars = array();
	public static $removedSidebars = array();
	public static $additionalSidebars = array();
	public static $headerClasses = array();
	public static $paragraphClasses = array();
	public static $teamMemberContactIconColors = array();
	public static $globalPageDividers = array();
	public static $registerWidgets = array();
	public static $defaultTestimonials = array();
	public static $defaultFAQs = array();
	public static $logoOverrideLocation = "";
	public static $defaultMenus = array();
	protected static $maxExecutionTime = "";
	public static $enableDropDownContactBox = true;
	public static $themeDefaultStyle = "default";
	public static $themeDefaultColor = "default";
	public static $sectionListVersion = 1;
	public static $layoutEditorAvailable = 0;
	public static $layoutPresets = array();
	public static $defaultLayouts = array();
	public static $defaultSidebarClasses = array(array("tag" => "div", "class" => "content-wrapper"), array("tag" => "div", "class" => "container"));
	public static $layout_section_wrapper_settings = array();
	public static $recommendedLogoDimensions = "";
	public static $recommendedRetinaLogoDimensions = "";
	public static $menuClasses = "cl-effect-1";
	public static $counterBoxVersion = 0;
	public static $default_welcome_video_id = "yLozSwgu05w";
	public static $defaultActiveBackgrounds = array();
	public static $headerBGSupport = false;
	public static $headerBGLocation = "";
	public static $headerBGClassName = ".header-bg";
	public static $headerBGStyles = "";
	public static $fullscreenSlideImageTemplate = "";
	public static $showQuotatorIndicators = false;
	public static $fullScreenSliderButtonEnabled = false;
	
	/*
	function I3D_Framework() {
     return void;
	}
	*/
	/************************************************
	 * VIEW
	 ************************************************/
	public static function template_header() {
	  require_once(get_template_directory().self::$userViewFilePath."/template-header.php");
	}
	
	public static function get_unique_id($action, $destroy_nonce = true, $count = 0) {
	  $nonce = wp_create_nonce($action.$count.time());
	  $firstChar = $nonce[0];
	  
	  if (is_numeric($firstChar)) {
		wp_verify_nonce($nonce, $action);
		$nonce = I3D_Framework::get_unique_id($action, $destroy_nonce, $count+1);
	  }
	  
	  if ($destroy_nonce) {
		wp_verify_nonce($nonce, $action.$count);  
	  }
	  return $nonce;
	  
	}
	
	
	/***********************************************
	 * CONTROLLER
	 ***********************************************/
    public static function setDebug($debugOn) {

	  self::$debugOn = $debugOn;	
	  self::$lastDebugTime =  array_sum(explode(' ', microtime()));
	  self::$startTime = self::$lastDebugTime;
	}
	public static function debug($output, $useBreak = false) {
	  $currentTime =  array_sum(explode(' ', microtime()));
	  if (self::$debugOn) {
	    if ($useBreak ) { 
	  	  print "<br><br>";
	    }
	    print number_format(($currentTime - self::$lastDebugTime), 4, '.', '')." (".number_format(($currentTime - self::$startTime), 2, '.', '').")::".$output."<br>\n";
	    self::$lastDebugTime = $currentTime;
	  }
	}
	
	public static function get_init_args() {
	  $query = "";
	  foreach ($_POST as $key => $value) {
		  if (strpos($key, "init_") !== false) {
			  $query .= "&{$key}={$value}";
		  }
	  }
	  foreach ($_GET as $key => $value) {
		  if (strpos($key, "init_") !== false) {
			  $query .= "&{$key}={$value}";
		  }
	  }
	  return $query;

	}
	
	public static function set_layout_section_wrapper_code($section_id, $code_start, $code_end, $section_wrapper_classes, $sidebar_wrapper_classes = array()) {
		self::$layout_section_wrapper_settings["{$section_id}"] = array("code_start" => $code_start,
																		"code_end"   => $code_end,
																		"section_wrapper_classes" => $section_wrapper_classes,
																		"sidebar_wrapper_classes" => $sidebar_wrapper_classes);
		
	  	
	}


	public static function get_layout_section_wrapper_code($section_id) {
		return self::$layout_section_wrapper_settings["{$section_id}"];
	}

	public static function render_layout_infographic($layout) {
	  $layouts = get_option("i3d_layouts");
	  
	  /*if ($layout == "default") {*/
	    $layout  = $layouts["$layout"];
		$sidebarWidgets = wp_get_sidebars_widgets();
		global $wp_registered_widgets;
		$special_components = array();
	  ob_start();
	  print "<div class='i3d-layout-infographic' rel='i3d-special-components'>";
	  foreach ($layout['sections'] as $section_id => $section) {
		  foreach ($section['rows'] as $row_id => $row) {
		  if (!isset($row['sidebar'])) {
			  $row['sidebar'] = "";
		  }
		  if ($row['status'] == "enabled") { 
			  print "<div class='row-fluid'>";
				if ($row['type'] == "divider") {
					print "<div class='divider-placeholder col-xs-12'></div>";
				} else {
				  $layout = $row['layout'];
				  $columnSizes = explode("|", $layout);
				  $columns = $row['columns'];
				  if ($columns == 0) {
					  $columns = sizeof($columnSizes);
				  }
				  $column_number = 0;
				  foreach ($columnSizes as $columnSize) {
					 // var_dump($row);
					//  print $row['type'];
					  if ($row['type'] == "preset") {
						  $widgets = array();
						  //print $row['presets'];
						  //var_dump(self::$layoutPresets["{$row['presets']}"]["columns"]["$column_number"]["widgets"]);
						 // exit;
						 
						  foreach (self::$layoutPresets["{$row['presets']}"]["columns"]["$column_number"]["widgets"] as $widgetData) {
							  $widgets[] = $widgetData['class_name'];
						  }
					    
					  } else if ($row['type'] == "sidebar") {
						  $widgets = array();
						   if ($row['sidebar'] != "") {
							   if (is_array(@$sidebarWidgets["{$row['sidebar']}"])) {
							foreach ($sidebarWidgets["{$row['sidebar']}"] as $wid) { 
						//	var_dump($wp_registered_widgets["$wid"]['callback'][0]);
										$widgets[] =  get_class($wp_registered_widgets["$wid"]['callback'][0]);
									
									}
							   }
						   }

					  } else if ($row['type'] == "widget") {
						  $widgets = array();
						  $widgets = array($row['widget']);
						  
					  }
					  //var_dump($widgets);
					  print "<div class='column-placeholder col-xs-{$columnSize} column-type-{$row['type']} text-center'>";
					  if (in_array("I3D_Widget_ContentRegion", $widgets)) {
						  $special_components[] = "content";
						  
						print "<i class='fa fa-fw fa-align-left tt' title='Content Region'></i>";  
					  
					  } else  if (in_array("I3D_Widget_Menu", $widgets)) {
					    print "<i class='fa fa-fw fa-compass tt' title='Menu'></i>";

					  } else  if (in_array("I3D_Widget_ContactPanel", $widgets)) {
					    print "<i class='fa fa-fw fa-ellipsis-h tt' title='Sidebar Region'></i>";

					  } else  if (in_array("I3D_Widget_Logo", $widgets)) {
					    print "<i class='fa fa-fw fa-certificate tt' title='Logo'></i>";
					  
					  } else  if (in_array("I3D_Widget_AnimatedLogo", $widgets)) {
					    print "<i class='fa fa-fw fa-certificate tt' title='Animated'></i>";
					  
					  } else  if (in_array("I3D_Widget_SEOTags", $widgets)) {
					    print "<i class='fa fa-fw fa-header tt' title='Page Header Title'></i>";
					  } else  if (in_array("I3D_Widget_SliderRegion", $widgets)) {
					    print "<i class='fa fa-fw fa-image tt' title='Slider Region'></i>";
						
					  } else  if (in_array("I3D_Widget_MapBanner", $widgets)) {
					    print "<i class='fa fa-fw fa-map-marker tt' title='Map Banner'></i>";
						$special_components[] = "map-banner";
					  
					  } else  if (in_array("I3D_Widget_SidebarRegion", $widgets)) {
					    print "<i class='fa fa-fw fa-ellipsis-v tt' title='Sidebar Region'></i>";

					  } else  if (in_array("I3D_Widget_TestimonialRotator", $widgets)) {
					    print "<i class='fa fa-fw fa-quote-left tt' title='Quotator'></i>";
					  
					  } else  if (in_array("I3D_Widget_FocalBox", $widgets)) {
					    print "<i class='fa fa-fw fa-bullhorn tt' title='Focal Box'></i>";
					  
					  } else  if (in_array("I3D_Widget_ContactForm", $widgets)) {
					    print "<i class='fa fa-fw fa-envelope tt' title='Contact Form'></i>";

					  } else  if (in_array("I3D_Widget_PhotoSlideshow", $widgets)) {
					    print "<i class='fa fa-fw fa-image fa-mega-v-spacing tt' title='Sidbar Region'></i>";
						$special_components[] = "photo-slideshow";
						  

					  } else  if (in_array("I3D_Widget_ImageCarousel", $widgets)) {
					    print "<i class='fa fa-fw fa-image tt' title='Isotope Portfolio'></i>";

						} else  if (in_array("I3D_Widget_Portfolio", $widgets)) {
					    print "<i class='fa fa-fw fa-image tt' title='Isotope Portfolio'></i>";

					  } else  if (in_array("I3D_Widget_SearchForm", $widgets)) {
					    print "<i class='fa fa-fw fa-search tt' title='Search Form'></i>";
					  
					  } else  if (in_array("I3D_Widget_SocialMediaIconShortcuts", $widgets)) {
					    print "<i class='fa fa-fw fa-share-alt tt' title='Social Media Shortcuts'></i>";


						} else  if (in_array("I3D_Widget_HTMLBox", $widgets)) {
					    print "<i class='fa fa-fw fa-align-justify tt' title='HTML Box'></i>";
					  }
					  print "</div>";
					  $column_number++;
				  }
				}
			  print "</div>";
		  }
		  }
	  }
	  print "<div class='clearfix'></div>";
	  print "</div>";
	  $output = ob_get_clean();
	  print str_replace("i3d-special-components", implode(" ", $special_components), $output);
		
	}
	
	public static function get_image_upload_path($base) {
	  	//$blog_id =  get_current_blog_id(); 
		$upload_dir = wp_upload_dir();
		//var_dump($upload_dir);
		return $upload_dir['baseurl']."/".$base;
		/*
								  http://localhost/wordpress-onyx/mytestsite/wp-content/uploads/2015/06/1DmHmsx.jpg
				   http://localhost/wordpress-onyx/mytestsite/wp-content/uploads/sites/2/2015/06/1DmHmsx.jpg
				site_url().'/wp-content/uploads/'.
		if ($blog_id > 1) {
		    return site_url()."/wp-content/uploads'
		} else {
			return $base;
		}
*/
	}
	
	public static function render_page_level_layout_manager($layout, $page_id) {
		global $wp_registered_sidebars;
		global $wp_registered_widgets;
		
	  $layouts = get_option("i3d_layouts");
	  /*if ($layout == "default") {*/
	    $layout  = $layouts["$layout"];
	//  var_dump($layout);
		$sidebarWidgets = wp_get_sidebars_widgets();
		$widgetCount = 0;
	  print "<div id='layout_{$layout['id']}' class='i3d-layout-manager-infographic'>";
	  foreach ($layout['sections'] as $section_id => $section) {
		  foreach ($section['rows'] as $row_id => $row) {
		  if (!isset($row['sidebar'])) {
			  $row['sidebar'] = "";
		  }
		  if ($row['status'] == "enabled") { 
			  print "<div class='row-fluid row-configurable-items-{$row_id} row-type-{$row['type']}'>";
				if ($row['type'] == "divider") {
					print "<div class='divider-placeholder col-xs-12'></div>";
				} else {
				  $row_layout = $row['layout'];
				 // print $row['layout'];
				  $columnSizes = explode("|", $row_layout);
				  
				  $columns = $row['columns'];
				  if ($columns == 0) {
					  $columns = sizeof($columnSizes);
				  }
				  $column_number = 0;
				 // foreach ($columnSizes as $columnSize) {
					  if ($row['type'] == "preset") {
						$preset = I3D_Framework::get_preset_items($row['presets']);

						foreach ($preset['columns'] as $column) { 
						
						$columnSize = $columnSizes["$column_number"];
						
						$column_number++;
					
						if (!array_key_exists('widgets', $column)) {
							$column['widgets'] 						= array();
						}
?>
					
             
                <div class='column-placeholder col-xs-<?php echo $columnSize; ?> text-center'>
<?php 				foreach ($column['widgets'] as $widget) { 
						$widgetID = $row_id."__".$widget['class_name'];
						$myWidget = self::instantiate_widget($widget);
					//	print "<div class='widget-container'>";
					$widgetName = str_replace("i3d:", "", @$myWidget->name);
					?>
				  <div class='alert  alert-<?php if (@$widget['class_name']  == "I3D_Widget_SidebarRegion") { print "sidebar"; } else { print "widget"; }?> widget<?php echo $widgetCount; ?>'>
						<?php if (@$widget['class_name'] != "I3D_Widget_SidebarRegion") { ?>
						<i class='pull-right fa fa-fw fa-angle-down fa-toggle-settings'></i>
						<?php } ?>
						<?php
						if (@$widget['class_name']  == "I3D_Widget_SidebarRegion") { 
						 //print $widget['defaults'];
						  //  $sidebar_id  = $myWidget->get_property("sidebar", @$row['configuration']["{$widget['id']}"], $widget['defaults'],  $row_id, $widget['id']);
							$sidebarName = $myWidget->get_sidebar_name(@$row['configuration']["{$widget['id']}"], $widget['defaults'],  $row_id, $widget['id'], $layout['id'], true);
							echo "<h5><span>{$sidebarName}</span> Sidebar</h5>";
						} else { 
							echo "<h5>{$widgetName} Widget</h5>";
						}
						
						
						if (method_exists($myWidget, "layout_configuration_form")) {
							
							
							?>
							<!--<button data-title="Settings" class='btn btn-default pull-right btn-configure-widget' type='button' 
							data-container="div.row-configurable-items-<?php echo $row_id; ?> div.widget-container.widget<?php echo $widgetCount++; ?>" 
							data-toggle="popover" data-placement="bottom"><i class='fa fa-pencil'></i></button>-->

							
							
							
							<div class='popover-configurations-container'>
							  <div class='popover-configurations'>
							
							  <?php echo $myWidget->layout_configuration_form(@$row['configuration']["{$widget['id']}"], $widget['defaults'], $row_id, $widget['id'], $layout['id'], true); ?>

							</div>
							</div>
							<div class='region-widgets'></div>
							<?php
						} ?>
							</div>
				
						<?php
					} ?>
                </div>		
				<?php
						}
					  } else if ($row['type'] == "sidebar") {
							$widgets = array();
							if ($row['sidebar'] != "") {
						  		$sidebar_name 	= @$wp_registered_sidebars["{$row['sidebar']}"]["name"];
							  	$columnCount 	= 0;

						  		print "<div class='sidebar-label tt' rel='tooltip' title='To modify/re-arrange/change/remove the widgets in this sidebar, go to the Appearance &gt; Widgets panel'>\"{$sidebar_name}\" Sidebar</div><div style='clear:both;'></div>";
								
								if (is_array(@$sidebarWidgets["{$row['sidebar']}"])) {
									foreach ($sidebarWidgets["{$row['sidebar']}"] as $wid) { 						
										$className 	= get_class($wp_registered_widgets["$wid"]['callback'][0]);
										$myWidget 	= self::instantiate_widget(array("class_name" => $className));
										$widgetName = str_replace("i3d:", "", $myWidget->name);
										$columnSize = $columnSizes["$column_number"];
										
										if ($columnCount == 0 || $widgetName == "Column Break") {
											if ($columnCount > 0) {
												print "</div>";
											}
											print "<div class='column-placeholder col-xs-{$columnSize} text-center'>";
											$columnCount++;
										}
										
										if ($widgetName != "Column Break") { 
											?><div class='alert alert-widget widget<?php echo $widgetCount; ?>'><?php
									
									
											print "<h5>{$widgetName} Widget</h5>";
											print "</div>";
										}
									
									}
								}
								// end last column only if there is at least one column
								if ($columnCount > 0) {
							  		print "</div>"; // end of last column
								}
						   }

					  } else if ($row['type'] == "widget") {
						  
						 
						 
						$widget = array("class_name" => $row['widget']);
						$myWidget = I3D_Framework::instantiate_widget($widget);
						$wid = @$myWidget->id_base;
						?>
						<div class='column-placeholder col-xs-12 text-center'>
						<div class='alert alert-<?php if (@$widget['class_name']  == "I3D_Widget_SidebarRegion") { print "sidebar"; } else { print "widget"; }?>'>
													<i class='pull-right fa fa-fw fa-angle-down fa-toggle-settings'></i>

						<?php
						$widgetName = str_replace("i3d:", "", @$myWidget->name);
						
						$widget['id'] = @$myWidget->id_base;
						//echo " <i class='fa fa-info-circle tt' title='".@$myWidget->widget_options['description']."'></i>";
						if (@$widget['class_name']  == "I3D_Widget_SidebarRegion") { 
						  //  $sidebar_id  = $myWidget->get_property("sidebar", @$row['configuration']["{$widget['id']}"], $widget['defaults'],  $row_id, $widget['id']);
							$sidebarName = $myWidget->get_sidebar_name(@$row['configuration']["{$widget['id']}"], $widget['defaults'],  $row_id, $widget['id'], $layout['id']);
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
							  <?php // i3d_render_mobile_tablet_visibility_options($row, $row_id, $wid);	?>

							  <?php echo $myWidget->layout_configuration_form(@$row['configuration']["{$widget['id']}"], array(),  $row_id, $widget['id'],  $layout['id'], true); ?>
								</div>
							</div>
							<div class='region-widgets'></div>
							<?php
						}
					?></div></div><?php
						 
						 
					  }  // end of if row-type is a widget
					  
					 
					   
					 // if (in_array("I3D_Widget_ContentRegion", $widgets)) {
						
					//	print "<i class='fa fa-fw fa-align-left'></i>";  
					  //} else  if (in_array("I3D_Widget_Logo", $widgets)) {
					   // print "<i class='fa fa-fw fa-smile-o'></i>";
					  //}

					//  print "</div>";
					//  $column_number++;
				 // }
				}
				print "<div class='clearfix'></div>";
			  print "</div>";
			  
		  }
		  }
	  }
	  print "<div class='clearfix'></div>";
	  print "</div>";
	  ?>
	  	<script>
//jQuery.noConflict();

	jQuery(document).ready(function() {
jQuery("#layout_<?php echo $layout['id']; ?> .popover-configurations-container").bind("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function(){
																															  
																															  if (jQuery(this).hasClass("show")) {
																																jQuery(this).addClass("shown");  
																															  }
																															  });									
									jQuery("#layout_<?php echo $layout['id']; ?> .fa-toggle-settings").bind("click", function() {
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
			
									
									//jQuery(".tt").tooltip();
									//jQuery(".btn-configure-widget").popover({'html' : true, 'content' : function() { return loadPopoverConfigurations(this); } });
									
									//activateDeleteButtons();
									//addToggleFunctionality();
									/*
									jQuery(".btn-add-divider").bind("click", function() {
																					  addRow("divider", jQuery(this).attr("rel"), "");
																					  });
									jQuery(".btn-add-sidebar").bind("click", function() {
																					  addRow("sidebar", jQuery(this).attr("rel"), "");
																					  });
									jQuery(".btn-insert-preset").bind("click", function() {
																						addRow("preset", jQuery(this).attr("rel"), jQuery(this).val());
																						
																						});
									*/
									/*
									jQuery(".btn-configure-widget").on('hide.bs.popover', function () {
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
										if (newHTML != "") {
										//alert(jQuery(this).parent().find(".popover-configurations-container").length);
										jQuery(this).parent().find(".popover-configurations-container").html(newHTML);
										tip.find(".popover-content").html("");
										}
															  
								
								
								});
									
									 jQuery(".btn-configure-widget").on('show.bs.popover', function() { 
																							//		alert("*");
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
									jQuery("#layout_<?php echo $layout['id']; ?> select.sidebar-select").each(function() {
																				 
																							//new_sidebar_name = jQuery(this).find(":selected").attr("rel");
																							//alert(new_sidebar_name);
																							//new_sidebar_name = new_sidebar_name.replace(/\(.*\)/, '');
																							//jQuery(this).parents(".alert-sidebar").find("h5 span").html(new_sidebar_name);
																							
																							var selectedSidebar = jQuery(this).val();
																						//	alert(selectedSidebar);
																							if (selectedSidebar == "") {
																								selectedSidebar = jQuery(this).attr("rel");
																							}
																							
																							var targetRegion = jQuery(this).parents(".alert-sidebar").find(".region-widgets");
																							//alert(targetRegion.length);

																							var sourceRegion = jQuery(".sidebar-widgets").find(".__" + selectedSidebar);
																							targetRegion.html("There are no widgets in this sidebar.");
																							if (sourceRegion.html()) {
																								targetRegion.html(sourceRegion.html().replace(/alert-info/gi, "alert-widget"));		
																							}
																							targetRegion.find(".example-span").addClass("static");

																				  });		
									jQuery("#layout_<?php echo $layout['id']; ?> select.sidebar-select").bind("change", function() {
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

																							var sourceRegion = jQuery(".sidebar-widgets").find(".__" + selectedSidebar);
																							//alert(sourceRegion.length);
																							targetRegion.html("There are no widgets in this sidebar.");
																							targetRegion.html(sourceRegion.html().replace(/alert-info/gi, "alert-widget"));			
																							targetRegion.find(".example-span").addClass("static");
																							
																							});									 
									
});
function loadPopoverConfigurations(element) {
//	alert("Y");
	var html = jQuery(element).parent().find(".popover-configurations-container").html();
	//alert(html);
	jQuery(element).parent().find(".popover-configurations-container").html("");
	//alert(jQuery(element).parent().find(".popover-configurations-container").length);
	return html;
	
}
</script>
<?php
		
	}	
public static function instantiate_widget($widget) {
	$myWidget = new stdClass();
	//print "widget_name: ".$widget['widget_name']."<br>";
	if ($widget['class_name'] == "I3D_Widget_Menu") {
		$myWidget = new I3D_Widget_Menu();
	  
	} else if ($widget['class_name'] == "I3D_Widget_ContactFormMenu") {
		$myWidget = new I3D_Widget_ContactFormMenu();

	} else if ($widget['class_name'] == "I3D_Widget_FocalBox") {
		$myWidget = new I3D_Widget_FocalBox();

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
		
	} else if ($widget['class_name'] == "I3D_Widget_SidebarRegion") {
		$myWidget = new I3D_Widget_SidebarRegion();

	} else if ($widget['class_name'] == "I3D_Widget_PhotoSlideshow") {
		$myWidget = new I3D_Widget_PhotoSlideshow();

	} else if ($widget['class_name'] == "I3D_Widget_SEOTags") {
		$myWidget = new I3D_Widget_SEOTags();
		
	} else if ($widget['class_name'] == "I3D_Widget_GoogleMap") {
		$myWidget = new I3D_Widget_GoogleMap();
	} else if ($widget['class_name'] == "I3D_Widget_HTMLBox") {
		$myWidget = new I3D_Widget_HTMLBox();
	} else if ($widget['class_name'] == "I3D_Widget_ImageCarousel") {
		$myWidget = new I3D_Widget_ImageCarousel();
	  
	  
	} else {
		$myWidget->name = "Unknown";
	}
	
	//$tempWidget = new WP_Widget;
	if ($widget['class_name'] == "LayerSlider_Widget") {
		$myWidget = new I3D_Widget_LayerSlider();
		
	} else {
		if (class_exists($widget['class_name'])) {
			$myWidget = new $widget['class_name']();
		}
	}
	//var_dump($myWidget);
						return $myWidget;
}
	
	public static function use_global_layout() {
		$settingOptions = get_option("i3d_general_settings", array());
		
		// I3D_Framework::$layoutEditorAvailable
		// 0 == not available (themes not yet converted)
		// 1 == optionally available (themes converted)
		// 2 == only available (new themes)
		
		if ( I3D_Framework::$layoutEditorAvailable == 1 && @$settingOptions['layout_editor'] > 0 ) {
			return true;
		} else if ( I3D_Framework::$layoutEditorAvailable == 2 ) {
			return true;
		} else {
			return false;
		}
		
	}
	
	public static function get_page_layout_data($page_id) {
		$selected_layout =  get_post_meta($page_id, "selected_layout", true);
		
		$layouts = get_option('i3d_layouts', array());

		if ($selected_layout == "" || !array_key_exists($selected_layout, $layouts)) {
			
			
		  $selected_layout = I3D_Framework::get_default_layout_id($page_id);	
		}
		if (!is_array($layouts)) {
			$layouts = self::$defaultLayouts;
		}
		if (!array_key_exists($selected_layout, $layouts)) {
			return array();
		} 
		return $layouts["$selected_layout"];		
	}

	public static function get_layout_data($selected_layout) {
		
		$layouts = get_option('i3d_layouts', array());

		if ($selected_layout == "" || !array_key_exists($selected_layout, $layouts)) {
			
			
		  $selected_layout = I3D_Framework::get_default_layout_id($page_id);	
		}
		if (!is_array($layouts)) {
			$layouts = self::$defaultLayouts;
		}
		if (!array_key_exists($selected_layout, $layouts)) {
			return array();
		} 
		return $layouts["$selected_layout"];		
	}


	private static function get_first_row_name($rows) {
	  $row_name = "";
	  
	  foreach ($rows as $row_id => $row) {
		 if ($row_name == "" && $row['title'] != "") {
			 return $row['title'];
		 }
	  }
	}
	
	
	public static function get_post_type_layout($post_type_name) {		
		$layouts = get_option('i3d_layouts', array());
		$selected_layout = "";
		
		//print "looking for $post_type_name";
		  foreach ($layouts as $id => $layout) {
			  		//var_dump($layout['default_form_type']);
			
			  if (@$layout['default_for_type']["{$post_type_name}"] == true) {
				  $selected_layout = $layout;
				  //print "have $post_type_name in $id <br>";
			  }
		  }

		return @$selected_layout['id'];
	}
	
	
	public static function render_page_in_layout($page_id, $lid = "") {	
	
		if (get_option('i3d_layouts', array()) == 0) {
			I3D_Framework::init_layouts(true);
			//$layouts = get_option('i3d_layouts', array());
		}
		//print "layout = $layout";
		if ($lid == "") {
			$layout = self::get_page_layout_data($page_id);
		} else {
		global $layout_id;
		$layout_id = $lid;
			$layout = self::get_layout_data($lid);
		}
		
		if (!array_key_exists('sections', $layout)) {
		  print "<div class='alert alert-danger text-center'><h4>Page layout not initialized for this page.</h4><p>Please be sure to select an appropriate layout from the <a href='".admin_url("post.php?post={$page_id}&action=edit")."'>Page Editor</a> page.</p></div>";	
		  return;
		}
		//print "layout: {$layout['id']} <br>";
		//exit;
		$count = 0;
		
		foreach ($layout['sections'] as $section_id => $section) {
			$first_row_name = "";
			
			
			$section_configuration = self::get_layout_section_wrapper_code($section_id);
			// output section start code
			
			$code_start =  do_shortcode(@$section_configuration["code_start"]);
			print str_replace("[Row Name]", I3D_Framework::get_first_row_name($section['rows']), $code_start);
	  		if (!is_array(@$section_configuration['section_wrapper_classes'])) {
				$section_configuration['section_wrapper_classes'] = array();
			}
			
			//var_dump($section_configuration);
			// output wrapper open code
			foreach ($section_configuration['section_wrapper_classes'] as $section_wrapper_tag) {
				print "<{$section_wrapper_tag['tag']}";
				if (@$section_wrapper_tag['class'] != "") {
					print " class='{$section_wrapper_tag['class']}";
				}
				if (@$section_wrapper_tag['id'] != "") {
					print " id='{$section_wrapper_tag['id']}'";
				}
				print "'>";
	  		}
			
			foreach ($section['rows'] as $row_id => $row) {
				if ($first_row_name == "") {
					$first_row_name = $row['title'];
				}
				
				if ($row['status'] == "enabled") {
					if ($row['type'] == "sidebar") {
						if (!is_array(@$section_configuration['sidebar_wrapper_classes'])) {
							$section_configuration['sidebar_wrapper_classes'] = array();
						}
						
						//var_dump($section_configuration);
						i3d_show_widget_region(str_replace("i3d-widget-area-", "", $row['sidebar']), $section_configuration['sidebar_wrapper_classes'], $row_id);
					
					} else if ($row['type'] == "divider") {
						i3d_show_divider_region($row_id, $section_id);
					
					} else if ($row['type'] == "preset") {
						
						//print "preset region $row_id";
						i3d_show_preset_region($row['presets'], $row_id);
					//exit;
					} else if ($row['type'] == "widget") {
						i3d_show_individual_widget_in_region($row['widget'], $row_id, $section_configuration['sidebar_wrapper_classes']);
						//print "<div class='container text-center'>Not Yet Implemented</div>";
					}
				} // end of if
			} // end of foreach
			
			// output wrapper close code
			foreach ($section_configuration['section_wrapper_classes'] as $section_wrapper_tag) {
				print "</{$section_wrapper_tag['tag']}>";
			}

			// output section close code
			print @$section_configuration["code_end"];
			//if ($count++ == 2) { exit; }
		
		
	
			
		}
		
		get_footer();
	}
	
	
	public static function check_init_push_time($force_push = 5) {
		if (self::$maxExecutionTime == "") {
			self::$maxExecutionTime = ini_get("max_execution_time");
		}
		if (self::$maxExecutionTime == 0) {
			self::$maxExecutionTime = 9999;
		}
	 	$current_time =  array_sum(explode(' ', microtime()));
		$seconds_running = number_format(($current_time - self::$startTime), 2, '.', '');
		
		
	  	if ($seconds_running + $force_push > self::$maxExecutionTime) {
			 //update_option("installation_status", "Doing Redirect: ".admin_url("admin.php?activated=true&configuration=default&init_pushed=true"));
			$initArgs = self::get_init_args();
			 wp_redirect(admin_url("admin.php?activated=true&configuration=default&init_pushed=".get_option("installation_status_percent").$initArgs));
			// exit;
		} else {
			$seconds_remaining = self::$maxExecutionTime - ($seconds_running + $force_push);
			 self::debug("Init Push Check PASSED with $seconds_remaining to spare.  Max execution time of ".self::$maxExecutionTime);

			
		}
	 
	}
	
	public static function get_all_preset_configurations() {
	  return self::$layoutPresets;	
	}
	
	
	public static function get_all_widget_configurations() {
		global $wp_registered_widgets;
		$widgets = array();
		
		foreach ($wp_registered_widgets as $wid => $data) {
			$widget_object = $data['callback'][0];
		//	$id = $widget_object->id_base;
			$id = get_class($widget_object);
			if (!array_key_exists($id, $widget_object) && method_exists($widget_object, "layout_configuration_form")) {
				$widgets["{$id}"]["name"] = str_replace("i3d:", "", $widget_object->name);
				$widgets["{$id}"]["description"] = $widget_object->widget_options['description'];
			//	var_dump($widget_object);
			}
		}
		
		uasort($widgets, array('I3D_Framework', 'sort_widget_array'));
		
		//$wp_registered_widgets["$wid"]['callback'][0]->id_base == "i3d_columnbreak")
		return $widgets;
	}
	
	public static function sort_widget_array($a, $b) {
	  return ($a['name'] < $b['name']) ? -1 : 1;  
	
	}
	
	public static function get_preset_items($presets) {
	  $presetData = self::$layoutPresets["$presets"];
	  
	  if (!is_array($presetData)) {
		  $presetData = array();
	  }
	  
	  return $presetData;
	}
	
	public static function add_layout_preset($preset) {
	  self::$layoutPresets = array_merge(self::$layoutPresets, $preset);
	}
	
	public static function set_config_status($percentage, $message) {
		if (!isset($_GET['init_pushed']) || ($_GET['init_pushed'] < $percentage)) {
			update_option("installation_status", $message);
			update_option("installation_status_percent", $percentage);
		}
	}
	
	public static function init() {	
		ini_set("max_execution_time", 0); 

		global $defaultConfiguration;
		global $_GET;
		if (!array_key_exists("configuration", $_GET)) {
			
			$configuration = "default";
		} else {
			$configuration = $_GET['configuration'];
		} 


        self::debug("In init(): with configuration {$configuration}", true);

		// forms need to initialize before the widgets are configured via the config file (below)
		if (@$_GET['init_forms'] == "1" || @$_POST['init_forms'] == "1") {
		    self::set_config_status(3, "Initializing Forms");
 			I3D_Framework::init_forms();
		}
		
        if (!isset($_GET['configuration'])) {
			$_GET['configuration'] = "";
		}
		if (!isset($_GET['activated'])) {
			$_GET['activated'] = "";
		}
		if (!isset($_GET['config'])) {
			$_GET['config'] = "";
		}

	
		if (($_GET['activated'] && $_GET['configuration'] != "") || !$_GET['configuration'] != ""  && $_GET['config'] != "requested") {
		  include("config-default.php");
		
		} else if ($_GET['sidebar-fix'] != "") {
		  include("config-default.php");
			
		}
		
		if (@$_GET['init_faqs'] == "1" || @$_POST['init_faqs'] == "1") {
			self::check_init_push_time(10);			
			self::set_config_status(4, "Initializing FAQs");
			I3D_Framework::init_faqs();
		}

		if (@$_GET['init_team_members'] == "1" || @$_POST['init_team_members'] == "1") {
			self::check_init_push_time(10);	
			self::set_config_status(5, "Initializing Team Members");
			I3D_Framework::init_team_members();
		}

		if (@$_GET['init_testimonials'] == "1" || @$_POST['init_testimonials'] == "1") {
			self::check_init_push_time();
			self::set_config_status(6, "Initializing Testimonials");		
			I3D_Framework::init_testimonials();
		}

		if (@$_GET['init_portfolio_items'] == "1" || @$_POST['init_portfolio_items'] == "1") {
			self::check_init_push_time(10);
			self::set_config_status(7, "Initializing Portfolio Items");				
			I3D_Framework::init_portfolio_items();
		}

		if (@$_GET['init_calls_to_action'] == "1" || @$_POST['init_calls_to_action'] == "1") {
			self::check_init_push_time();
			self::set_config_status(8, "Initializing CTAs");				
			I3D_Framework::init_calls_to_action();
		}

		if (@$_GET['init_content_panel_groups'] == "1" || @$_POST['init_content_panel_groups'] == "1") {
			self::check_init_push_time();
			self::set_config_status(9, "Initializing CPGs");						
			I3D_Framework::init_content_panel_groups();
		}

		if (@$_GET['init_focal_boxes'] == "1" || @$_POST['init_focal_boxes'] == "1") {
			self::check_init_push_time();
			self::set_config_status(10, "Initializing FBs");				
			I3D_Framework::init_focal_boxes();
		}

		if (@$_GET['init_active_backgrounds'] == "1" || @$_POST['init_active_backgrounds'] == "1") {
			self::check_init_push_time();
			self::set_config_status(10, "Initializing ABs");				
			I3D_Framework::init_active_backgrounds();
		}
	}
	
	public static function get_update_log() {
	  $updateLog = array();
		 $updateLog[] = array("version" => "4.4.6", 
								 "date" => "2019-02-08", 
								 "summary" => "Google Recaptcha V2 Invisible / V3 Support",
								 "items" => array(
												array("label_class" => "label label-success", "label" => "NEW", "description" => "Now support for Google Recaptcha V3 and V2 Invisible, in the Contact Forms.")
																							
												)
								);
		
		
  $updateLog[] = array("version" => "4.4.4", 
								 "date" => "2017-09-18", 
								 "summary" => "Google Fonts Fix",
								 "items" => array(
												array("label_class" => "label label-success", "label" => "UPDATE", "description" => "Fixed bug that was introduced with latest version of Google Fonts.")
																							
												)
								);

	  $updateLog[] = array("version" => "4.4.3", 
								 "date" => "2017-01-18", 
								 "summary" => "Framework Tweaks",
								 "items" => array(
												array("label_class" => "label label-success", "label" => "UPDATE", "description" => "Support for SoundCloud has been removed from the framework as SoundCloud no longer offers an open API, nor easy access to their approval only API.")
																							
												)
								);
	  
	  $updateLog[] = array("version" => "4.4.2", 
								 "date" => "2015-09-13", 
								 "summary" => "Framework Improvements to allow for the Denmark theme.",
								 "items" => array(
												array("label_class" => "label label-success", "label" => "FIX", "description" => "Updates to the HTML Box Widget"),
												array("label_class" => "label label-success", "label" => "FIX", "description" => "Fixed issue in the Layout Manager which did not allow for the definition of width on Widgets and Presets."),
												array("label_class" => "label label-success", "label" => "UPDATE", "description" => "Updated Testimonial Rotator widget for the Bootstrap Quotes slider in Denmark."),
												array("label_class" => "label label-success", "label" => "UPDATE", "description" => "Updated Info Box widget for styling that matched the Denmark theme."),
																							
												)
								);

	  $updateLog[] = array("version" => "4.4.11", 
								 "date" => "2016-09-01", 
								 "summary" => "Bug Fixes",
								 "items" => array(
												array("label_class" => "label label-success", "label" => "FIX", "description" => "Updates to the TinyMCE Plugins to allow for compatibility with WordPress v4.6"),
												array("label_class" => "label label-success", "label" => "FIX", "description" => "Updates to the SEOTags Widget to resolve a rare server conflict."),
												array("label_class" => "label label-success", "label" => "FIX", "description" => "Updates to the Sliders interface to resolve issue in the Bootstrap Slider"),
																							
												)
								);



	  $updateLog[] = array("version" => "4.3.10", 
								 "date" => "2015-07-20", 
								 "summary" => "Framework Improvements",
								 "items" => array(
												array("label_class" => "label label-success", "label" => "NEW", "description" => "You may now define a custom search page."),
												array("label_class" => "label label-success", "label" => "NEW", "description" => "The updater will now optionally download just the framework and theme core files."),
												array("label_class" => "label label-success", "label" => "NEW", "description" => "Developer and Multi-Site licenses will now show a message on the support page to contact the developer directly."),
																							
												)
								);
	  
	  $updateLog[] = array("version" => "4.3.9", 
								 "date" => "2015-07-17", 
								 "summary" => "Updates to allow for the upgrade of the Fortis theme to the 4.3.x framework",
								 "items" => array(
												array("label_class" => "label label-info", "label" => "UPDATE", "description" => "Fortis config files updated to allow for the new layout editor."),
																							
												)
								);
	  
	  $updateLog[] = array("version" => "4.3.8", 
								 "date" => "2015-07-14", 
								 "summary" => "Updates to allow for the upgrade of the Champion theme to the 4.3.x framework",
								 "items" => array(
												array("label_class" => "label label-info", "label" => "UPDATE", "description" => "Champion config files updated to allow for the new layout editor."),
																							
												)
								);
	  
	  $updateLog[] = array("version" => "4.3.7", 
								 "date" => "2015-07-10", 
								 "summary" => "Updates to allow for the upgrade of the Myriad theme to the 4.3.x framework",
								 "items" => array(
												array("label_class" => "label label-info", "label" => "UPDATE", "description" => "Myriad config files updated to allow for the new layout editor."),
																							
												)
								);
	  $updateLog[] = array("version" => "4.3.6", 
								 "date" => "2015-07-09", 
								 "summary" => "Updates to allow for the upgrade of the Kino theme to the 4.3.x framework",
								 "items" => array(
												array("label_class" => "label label-info", "label" => "UPDATE", "description" => "Avante config files updated to allow for the new layout editor."),
																							
												)
								);

	  $updateLog[] = array("version" => "4.3.5", 
								 "date" => "2015-07-07", 
								 "summary" => "Updates to allow for the upgrade of the Tempus theme to the 4.3.x framework",
								 "items" => array(
												array("label_class" => "label label-info", "label" => "UPDATE", "description" => "Tempus config files updated to allow for the new layout editor."),
																							
												)
								);


	  $updateLog[] = array("version" => "4.3.4", 
								 "date" => "2015-06-26", 
								 "summary" => "Updates to allow for the upgrade of the Kino theme to the 4.3.x framework",
								 "items" => array(
												array("label_class" => "label label-info", "label" => "UPDATE", "description" => "Kino config files updated to allow for the new layout editor."),
																							
												)
								);


	  $updateLog[] = array("version" => "4.3.3", 
								 "date" => "2015-06-26", 
								 "summary" => "Updates to allow for the upgrade of the Portico theme to the 4.3.x framework",
								 "items" => array(
												array("label_class" => "label label-info", "label" => "UPDATE", "description" => "Updater page improved."),
												array("label_class" => "label label-info", "label" => "UPDATE", "description" => "New video explaining how to use the Intro layout for Portico."),
												array("label_class" => "label label-info", "label" => "UPDATE", "description" => "Portico config files updated to allow for the new layout editor."),
																							
												)
								);

	  $updateLog[] = array("version" => "4.3.2", 
								 "date" => "2015-06-19", 
								 "summary" => "Updates to allow for the upgrade of the Diavlo theme to the 4.3.x framework",
								 "items" => array(
												array("label_class" => "label label-info", "label" => "UPDATE", "description" => "Contact Panel support added for v4.3"),
												array("label_class" => "label label-info", "label" => "UPDATE", "description" => "Updated Onyx config file to allow for wrapper code around preset widgets"),
												array("label_class" => "label label-info", "label" => "UPDATE", "description" => "Diavlo config files updated to allow for the new layout editor."),
																							
												)
								);


	  $updateLog[] = array("version" => "4.3.1", 
								 "date" => "2015-06-12", 
								 "summary" => "Small patch to allow the auto setup of pre-configured layouts for those upgrading to Onyx from pre 4.3 version theme framework.",
								 "items" => array(
												array("label_class" => "label label-danger", "label" => "FIX", "description" => "Layouts now auto-create if zero are present, and the Global Layout Manager is turned to on from off."),
																							
												)
								);

	  $updateLog[] = array("version" => "4.3.0", 
								 "date" => "2015-06-11", 
								 "summary" => "In addition to a host of bug fixes, his version includes a brand new layout editor which is available to the Onyx theme only at this time. Wwe will be adding support to the other
								 Aquila framework themes over the following months.",
								 "items" => array(
												array("label_class" => "label label-success", "label" => "NEW", "description" => "New Layout Editor available for Onyx -- includes a number of new alternate layouts."),
												array("label_class" => "label label-success", "label" => "NEW", "description" => "Website Name/Logo can now link to a page other than the home page of the site."),
												array("label_class" => "label label-success", "label" => "NEW", "description" => "WordPress Admin bar can now be enabled/disabled through the control panel.  Previously, it was arbitrarily disabled."),
												array("label_class" => "label label-success", "label" => "NEW", "description" => "The drop down menu can now be set to 'auto-open', those menu items with sub menus, on-hover."),
												array("label_class" => "label label-success", "label" => "NEW", "description" => "The 'Look and Feel' configuration page for the Onyx theme has been greatly improved to allow for colorization of most elements."),
												array("label_class" => "label label-success", "label" => "NEW", "description" => "There is now a 'clear' button available for the bitmapped graphic logo if you decide you do not want to use a graphic logo after one is uploaded."),
												array("label_class" => "label label-success", "label" => "NEW", "description" => "The Font Awesome vector icon system may now be loaded externally or locally, via the Control Panel -> External Assets panel."),
												array("label_class" => "label label-success", "label" => "NEW", "description" => "The name of the 'Slider' in the 'Sliders Manager' can now be renamed."),
												array("label_class" => "label label-success", "label" => "NEW", "description" => "The 'Carousel Slider' (Onyx only) can now have the sidebar and/or background overlay disabled."),
												array("label_class" => "label label-danger", "label" => "FIX", "description" => "Made the Font Awesome icon picker loaded through ajax, as it was causing too much load on the widget panel when loaded conventionally."),
												array("label_class" => "label label-danger", "label" => "FIX", "description" => "Resolved a bug that caused conflicts beween the Contact Page map and the Active Backgrounds map feature."),
												array("label_class" => "label label-danger", "label" => "FIX", "description" => "An issue with Contact Form icons, if you changed the icon from the default it broke the icon, is now resolved."),
												array("label_class" => "label label-danger", "label" => "FIX", "description" => "A recent update to wordpress broke the ability to use a page template for the blog page.  This is resolved for the new Layout Editor."),
												array("label_class" => "label label-danger", "label" => "FIX", "description" => "Resolved an issue with some Active Backgrounds not rendering due to their unique ids starting with an integer.  All new Special Components (Contact Forms, Focal Boxes, Active Backgrounds, Content Panels, Calls To Action) now use a new 'unique id' system."),
																							
												)
								);

	  $updateLog[] = array("version" => "4.2.4", 
								 "date" => "2015-05-10", 
								 "summary" => "A number of bug fixes are included.",
								 "items" => array(
												array("label_class" => "label label-danger", "label" => "FIX", "description" => "Resolved a bug with Google Maps that caused an alert box to pop up."),
																							
												)
								);

	  $updateLog[] = array("version" => "4.2.2", 
								 "date" => "2015-01-02", 
								 "summary" => "This release includes improvements to the installer, as well as updates to the widgets to allow box styling for many components.",
								 "items" => array(
																							
												)
								);


	  $updateLog[] = array("version" => "4.2.1", 
								 "date" => "2014-11-07", 
								 "summary" => "This release includes new features for the contact forms, team members, and general sidebar display",
								 "items" => array(
												array("label_class" => "label label-success", "label" => "NEW", "description" => "Google ReCAPTCHA now available as a field time for the contact forms."),
												array("label_class" => "label label-success", "label" => "NEW", "description" => "Team Members can now be ordered, much like the FAQs and Quotations, via drag and drop."),
																							
												)
								);


	  $updateLog[] = array("version" => "4.2.0", 
								 "date" => "2014-10-01", 
								 "summary" => "Much of the UX/UI has been updated, in conjunction with the development of a new theme being released.",
								 "items" => array(
												array("label_class" => "label label-success", "label" => "UPDATE", "description" => "Widgets now updated so that you may pick the size of the 'Title' (H1,H2,H3,H4,H5): HTML Box, Custom Menu, Social Media Icons, Contact Details Box, and Quotator"),
												array("label_class" => "label label-success", "label" => "UPDATE", "description" => "New selectable Custom Menu 'default icon' for menu items, if no custom icon defined."),
												array("label_class" => "label label-success", "label" => "NEW", "description" => "New FAQ display option: Accordion Panel"),
												array("label_class" => "label label-success", "label" => "NEW", "description" => "Framework built to handle primary/timed themes, for future new product types."),
												array("label_class" => "label label-success", "label" => "NEW", "description" => "Technical Support now available directly from a new 'Support' tab."),
												array("label_class" => "label label-success", "label" => "NEW", "description" => "Handling for default regions (main content, and footer) in default layouts added"),
												array("label_class" => "label label-success", "label" => "NEW", "description" => "Slide interval and dimensions for native sliders now configurable."),
												array("label_class" => "label label-success", "label" => "NEW", "description" => "Support for Retina resolution bitmapped logo."),
												array("label_class" => "label label-success", "label" => "NEW", "description" => "Customizable FavIcon, iPhone, iPad, and iPhone/iPad Retina Icon feature."),
												array("label_class" => "label label-success", "label" => "NEW", "description" => "Now choose from ALL 630+ Google Fonts on the Typography page."),
												array("label_class" => "label label-info", "label" => "UPDATE", "description" => "The theme settings area has been completely revamped -- now supports bootstrap 3.x"),
												array("label_class" => "label label-info", "label" => "UPDATE", "description" => "Contact Forms special component type has been completely revamped, with much better form builder design view editing."),
												array("label_class" => "label label-info", "label" => "UPDATE", "description" => "FAQs can now be reorganized."),
												array("label_class" => "label label-success", "label" => "NEW", "description" => "Theme Framework will now come with a list of suggested (and possibly required) plugins."),
												array("label_class" => "label label-success", "label" => "NEW", "description" => "Special MASKS are now supported for the InfoBox, Image, and new Flickr Gallery widgets."),
												array("label_class" => "label label-success", "label" => "NEW", "description" => "New Flickr Gallery widget."),
												array("label_class" => "label label-danger", "label" => "FIX", "description" => "Resolved issue with Google Fonts not loading through import statement. "),
																							
												)
								);


		$updateLog[] = array("version" => "4.1.7", 
								 "date" => "2014-06-13", 
								 "summary" => "A number of bug fixes are included, as well as a few updates to widgets.",
								 "items" => array(
												array("label_class" => "label label-danger", "label" => "FIX", "description" => "Resolved issue with bootstrap columns not setting the final column class properly."),
												array("label_class" => "label label-danger", "label" => "FIX", "description" => "Resolved issue with 'info box' heights not being adjusted when the page is resized."),
												array("label_class" => "label label-success", "label" => "NEW", "qualifier" => array("Portico"), "description" => "Support for a new custom post type called 'Portfolio' is now included."),
												array("label_class" => "label label-info", "label" => "UPDATE", "description" => "Content Region widget updated to allow for you to call upon content from another page."),
												array("label_class" => "label label-info", "label" => "UPDATE", "description" => "SEO Tags widget now has an alignment/justification property, so that you acn align your SEO left/center/right."),
																								
												)
								);

	  $updateLog[] = array("version" => "4.1.6", 
							"date" => "2014-05-01", 
							"summary" => "This release adds support for an upgraded 'pro' verison which includes support for two popular ecommerce solutions.",
							"items" => array(
								array("label_class" => "label label-success", "label" => "NEW", "description" => "A 'PRO' version of the theme is now available, which allows support for WooCommerce and WP eCommerce shopping cart solutions."),
												)
								);


	  $updateLog[] = array("version" => "4.1.5", 
						   "date" => "2014-04-23", 
						   "summary" => "A maintenance release which addresses updates for the WordPress 3.9 update that caused included TinyMCE plugins to conflict with the new TinyMCE 4.0 system.",
						   "items" => array(
								array("label_class" => "label label-danger", "label" => "FIX", "description" => "Resolved issue with the Page/Post Visual/HTML not working."),
										)
								);


	  $updateLog[] = array("version" => "4.1.4", 
						   "date" => "2014-04-02", 
						   "summary" => "A number of new features have been built into the framework in support of one of our newer themes.",
						   "items" => array(
								array("label_class" => "label label-success", "label" => "NEW", "description" => "A new special component type, the 'Content Panel Group', which leverages the tab/pill/accordion menu of the bootstrap framework."),
								array("label_class" => "label label-info", "label" => "UPDATE", "description" => "Testimonials have been renamed to 'Quotations' and the 'Testimonial Rotator' is now called the 'Quotator' as it is often used for more than just testimonials."),
								array("label_class" => "label label-success", "label" => "NEW", "description" => "Category custom post taxonomy now available for 'Quotations'."),
								array("label_class" => "label label-success", "label" => "NEW", "qualifier" => array("Tempus"), "description" => "Support for stylized backgrounds on HTML, Vertical Menus, Content Region and SEO Tags widgets."),
								array("label_class" => "label label-success", "label" => "NEW", "qualifier" => array("Tempus"), "description" => "Support for Slider in Quotator widget."),
								array("label_class" => "label label-success", "label" => "NEW", "qualifier" => array("Tempus"), "description" => "Support for Small Rotator in Quotator widget."),
								array("label_class" => "label label-success", "label" => "NEW", "qualifier" => array("Tempus"), "description" => "Support for Content Panel (slide in panel at top of page)"),
								array("label_class" => "label label-success", "label" => "NEW", "qualifier" => array("Tempus"), "description" => "New animated vertical menu that supports one level of sub-menu items."),
										)
								);

	  $updateLog[] = array("version" => "4.1.3", 
						   "date" => "2013-12-31", 
						   "summary" => "This is a maintenance update with a number of bug fixes.  There should be no noticeable change to any features apart from some reorganization of information the Framework landing page.",
						   "items" => array()
								);

	  $updateLog[] = array("version" => "4.1.2", 
						   "date" => "2014-04-02", 
						   "summary" => "With the release of one of our newest themes, we had to build out a few new theme specific features.  You may or may not see any new features, depending upon which theme you have.",
						   "items" => array(
								array("label_class" => "label label-success", "label" => "NEW", "qualifier" => array("Tempus", "Avante"), "description" => "A new slider caleld the 'Fullscreen Slider'."),
								array("label_class" => "label label-success", "label" => "NEW", "qualifier" => array("Tempus", "Avante"), "description" => "Stylable ediges, inner, and outer page regions."),
								array("label_class" => "label label-success", "label" => "NEW", "qualifier" => array("Tempus", "Avante"), "description" => "Support for dividers between content widget regions."),
										)
								);

	  $updateLog[] = array("version" => "4.1.1", 
						   "date" => "2014-12-16", 
						   "summary" => "A number of new features have been built into the framework in support of one of our newer themes.",
						   "items" => array(
								array("label_class" => "label label-success", "label" => "NEW", "description" => "A new special component type, the 'Call To Action'', which leverages the transitions (animations) available in CSS3.  This new component allows you animated text and buttons into a region."),
								array("label_class" => "label label-info", "label" => "UPDATE", "description" => "The search results page now displays results as exceprts."),
								array("label_class" => "label label-success", "label" => "NEW", "description" => "Another very special feature, the 'SoundCloud MP3 Player', which leverages the SoundCloud service, is now included.  You can now providce background music via a music bar at the bottom of your pages."),
								array("label_class" => "label label-success", "label" => "NEW", "qualifier" => array("Tempus", "Myriad", "Avante"), "description" => "Support for a new Info Box called the Hover Icon Box."),
								array("label_class" => "label label-success", "label" => "NEW", "qualifier" => array("Tempus", "Myriad", "Avante"), "description" => "Support for differently styled content regions."),
										)
								);

	  $updateLog[] = array("version" => "4.1.0", 
						   "date" => "2013-12-05", 
						   "summary" => "We've been working ahrd on thsi update which include a number of awesome new features.",
						   "items" => array(
								array("label_class" => "label label-success", "label" => "NEW", "description" => "You can now specify the column widths for your layout on a page-by-page basis."),
								array("label_class" => "label label-success", "label" => "NEW", "description" => "You may also now enable Mobile and Tablet responsive modes where you can 'hide' or 'show' specific widgets to those two media types."),
								array("label_class" => "label label-success", "label" => "NEW", "description" => "We've inclueded a new, easier to use, 'default' minimized layout, and renamed the previous 'default' layout to 'advanced'."),
								array("label_class" => "label label-success", "label" => "NEW", "description" => "New to the page properties control panel, when editing a page, is a new helpful guide that shows how complete your page is, with regard to Content, SEO, and Layout."),
								array("label_class" => "label label-success", "label" => "NEW", "qualifier" => array("Tempus", "Champion", "Myriad"), "description" => "New info box called the Animated Image Box, which transitions 'into' the page."),
										)
								);

		return $updateLog;
	}
	
	public static function page_metadata($pageKeywords, $pageDescription) { 
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if (!is_plugin_active("wordpress-seo/wp-seo.php")) { 
	    	if ($pageKeywords != "") { 
				echo '<meta name="keywords" content="'.addslashes($pageKeywords).'" />'."\n"; 
			} 
			
			if ($pageDescription != "") { 
			  	echo '<meta name="description" content="'.addslashes($pageDescription).'" />'."\n";
			} 
		}
    
    } 
	
	public static function refreshGoogleFonts($reload = true) {
		//print "x:".ini_get("allow_url_fopen");
		if (ini_get("allow_url_fopen") == 1) {
			ob_start();
			readfile("http://wordpress.server-apps.com/google-fonts/?v=json");
			$fonts = trim(ob_get_clean());
		} else {
			$ch = curl_init();
			//print $ch;
			curl_setopt($ch, CURLOPT_URL, 'http://wordpress.server-apps.com/google-fonts/?v=json');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // return the response
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			$response = curl_exec($ch);
			
			//print curl_error($ch);
			curl_close($ch);
			$fonts = trim($response);

		}
		//var_dump($fonts);
		//exit;
		//$fonts = explode("\n", $fonts);
		
		update_option('google-fonts-json', $fonts);
		if ($reload) {
			wp_redirect(get_home_url().'/wp-admin/admin.php?page=i3d-settings&tab=tabs-configure&subtab=style&google-fonts=refreshed');
		}
	}

public static function hex2RGB($hexStr, $returnAsString = false, $seperator = ',') {
    $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
    $rgbArray = array();
    if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
        $colorVal = hexdec($hexStr);
        $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
        $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
        $rgbArray['blue'] = 0xFF & $colorVal;
    } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
        $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
        $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
        $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
    } else {
        return false; //Invalid hex color code
    }
    return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
} 

	public static function renderFontAwesomeSelect($inputName, $inputValue, $default = false, $defaultSelector = "-- Choose Icon -- ", $noIcon = "-- No Icon --", $onChangeJS = "", $groups = array(), $displayStep = 1) {
		$availableIcons = array();
		if ($displayStep == 2) { 
		  $id = $_POST['id'];
		} else {
			$id = rand();
		}
		if (self::$fontAwesomeVersion == "3" || self::$fontAwesomeVersion == "") {
			$availableIcons['Web Application Icons'] = array("icon-adjust", "icon-anchor", "icon-archive", "icon-asterisk",
															 "icon-ban-circle", "icon-bar-chart", "icon-barcode", "icon-beaker", "icon-beer",
															 "icon-bell", "icon-bell-alt", "icon-bolt", "icon-book",
															 "icon-bookmark", "icon-bookmark-empty", "icon-briefcase", "icon-bug",
															 "icon-building", "icon-bullhorn", "icon-bullseye", "icon-calendar",
															 "icon-calendar-empty", "icon-camera", "icon-camera-retro", "icon-certificate",
															 "icon-check", "icon-check-empty", "icon-check-square", "icon-check-sign",
															 "icon-circle", "icon-circle-blank", 
															 "icon-cloud", "icon-cloud-download", "icon-cloud-upload", "icon-code",
															 "icon-code-fork", "icon-coffee", "icon-cog", "icon-cogs",
															 "icon-collapse", "icon-collapse-alt", "icon-collapse-top",
															 "icon-comment", "icon-comment-alt", "icons-comments", "icons-comments-alt",
															 "icon-compass", "icon-credit-card", "icon-crop", "icon-dashboard", "icon-desktop",
															 "icon-download", "icon-download-alt", "icon-edit", "icon-edit-sign", 
															 "icon-ellipsis-horizontal", "icon-ellipsis-vertical",
															 "icon-envelope", "icon-envelope-alt", "icon-eraser", "icon-exchange",
															 "icon-exclamation", "icon-exclamation-sign", "icon-expand", "icon-expand-alt", 
															 "icon-external-link", "icon-extneral-link-sign",
															 "icon-eye-close", "icon-eye-open", "icon-facetime-video", "icon-female",
															 "icon-fighter-jet", "icon-film", "icon-filter", "icon-fire",
															 "icon-fire-extinguisher", "icon-flag", "icon-flag-checkered", "icon-folder-close",
															 "icon-folder-close-alt", "icon-folder-open", "icon-folder-open-alt",
															 "icon-food", "icon-frown", "icon-gamepad", "icon-gear", "icon-gears",
															 "icon-gift",
															 "icon-glass", "icon-globe", "icon-group", "icon-hdd",
															 "icon-headphones", "icon-heart", "icon-heart-empty", "icon-home",
															 "icon-inbox", "icon-info", "icon-info-sign", "icon-key",
															 "icon-keyboard", "icon-laptop", "icon-leaf", "icon-legal",
															 "icon-lemon", "icon-level-down", "icon-level-up", "icon-lightbulb",
															 "icon-location-arrow", "icon-lock", "icon-magic", "icon-magnet",
															 "icon-mail-foward", "icon-mail-reply", "icon-mail-reply-all", "icon-male",
															 "icon-map-marker", "icon-meh", "icon-microphone", "icon-microphone-off",
															 "icon-minus", "icon-minus-sign", "icon-minus-sign-alt", 
															 "icon-mobile-phone", "icon-money", "icon-moon",
															 "icon-music", "icon-off", "icon-ok", "icon-ok-circle",
															 "icon-ok-sign", "icon-pencil", "icon-phone", "icon-phone-sign",
															 "icon-picture", "icon-plane", "icon-plus", "icon-plus-sign", 
															 "icon-plus-sign-alt", "icon-print", "icon-pushpin", "icon-puzzle-piece", "icon-qrcode",
															 "icon-question", "icon-question-sign", "icon-quote-left", "icon-quote-right",
															 "icon-random", "icon-refresh", "icon-remove", "icon-remove-circle", "icon-remove-sign",
															 "icon-reorder", "icon-reply", "icon-reply-all",
															 "icon-resize-horizontal", "icon-resize-vertical",
															 "icon-retweet", "icon-road", "icon-rocket", "icon-rss",
															 "icon-rss-sign", "icon-screenshot", "icon-search",
															 "icon-share", "icon-share-alt", "icon-share-sign", "icon-shield",
															 "icon-shopping-cart", "icon-sign-blank", "icon-signal", "icon-signin",
															 "icon-signout", 
															 "icon-sitemap", "icon-smile", "icon-sort", "icon-sort-by-alphabet",
															 "icon-sort-by-alphabet-alt", "icon-sort-by-attributes", "icon-sort-by-attributes-alt", "icon-sort-by-order",
															 "icon-sort-by-order-alt", "icon-sort-down",
															 "icon-sort-up", "icon-spinner",
															 "icon-star", "icon-star-half", "icon-star-half-empty", 
															 "icon-star-half-empty", "icon-star-empty", "icon-subscript", "icon-suitcase",
															 "icon-sun", "icon-superscript", "icon-tablet",
															 "icon-tag", "icon-tags", "icon-tasks", "icon-terminal",
															 "icon-thumbs-down", "icon-thumbs-down-alt", "icon-thumbs-up-alt",
															 "icon-thumbs-up", "icon-ticket", "icon-time",
															 "icon-tint", "icon-trash", "icon-trophy",
															 "icon-truck", "icon-umbrella", "icon-unchecked", "icon-unlock", "icon-unlock-alt",
															 "icon-upload", "icon-upload-alt", "icon-user", "icon-volume-down", "icon-volume-off", "icon-volume-up",
															 "icon-warning-sign", "fa-wrench", "icon-zoom-in", "icon-zoom-out");

		$availableIcons['Currency Icons'] = array(
															 "icon-bitcoin",  "icon-cny", "icon-dollar",
															 "icon-euro", "icon-gdp", "icon-inr",
															  "icon-won",
															  "icon-yen");
			$availableIcons['Text Editor Icons'] = array("icon-align-center", "icon-align-justify", "icon-align-left", "fa-align-right",
															 "icon-bold",
															 "icon-columns", "icon-copy", "icon-cut", 
															 "icon-eraser", "icon-file", "icon-file-alt", "icon-file-text",
															 "icon-file-text-alt", "icon-font",
															 "icon-indent-left", "icon-indent-right", "icon-italic", "icon-link", "icon-list",
															 "icon-list-alt", "icon-list-ol", "icon-list-ul",
															 "icon-paperclip", "icon-paste", "icon-repeat",
															 "icon-save",  "icon-strikethrough",
															 "icon-table", "icon-text-height", "icon-text-width", "icon-th",
															 "icon-th-large", "icon-th-list", "icon-underline", "icon-undo",
															 "icon-unlink");
			
			$availableIcons['Directional Icons'] = array("icon-double-angle-down", "icon-double-angle-left", "icon-double-angle-right", "icon-double-angle-up",
															 "icon-angle-down", "icon-angle-left", "icon-angle-right", "icon-angle-up",
															 "icon-arrow-down", "icon-arrow-left", "icon-arrow-right", "icon-arrow-up",
															 "icon-caret-down", "icon-caret-left", "icon-caret-right", "icon-caret-up",
															 "icon-chevron-sign-down", "icon-chevron-sign-left", "icon-chevron-sign-right", "icon-chevron-sign-up",
															 "icon-chevron-down", "icon-chevron-left", "icon-chevron-right", "icon-chevron-up",
															 "icon-hand-down", "icon-hand-left", "icon-hand-right", "icon-hand-up",
															 "icon-long-arrow-down", "icon-long-arrow-left", "icon-long-arrow-right", "icon-long-arrow-up",
															 "icon-circle-arrow-down", "icon-circle-arrow-left", "Icon-circle-arrow-right", "icon-circle-arrow-up");
			$availableIcons['Video Player Icons'] = array(
															 "icon-backward", "icon-eject",
															  "icon-fast-backward", "icon-fast-foward", "icon-foward",
															  "icon-fullscreen",
															 "icon-pause", "icon-play", "icon-play-sign", "icon-play-circle",
															 "icon-step-backward", "icon-step-forward", "icon-stop", "icon-youtube-play",
														  );
			
			$availableIcons['Brand Icons'] = array( "icon-adn", "icon-android", "icon-apple", "icon-bitbucket",
															 "icon-bitbucket-square", "icon-bitcoin", "icon-css3",
															 "icon-dribble", "icon-dropbox", "icon-facebook", "icon-facebook-sign",
															 "icon-flickr", "icon-foursquare", "icon-github", "icon-github-alt",
															 "icon-github-sign", "icon-gittip", "icon-google-plus", "icon-google-plus-sign",
															 "icon-html5", "icon-instagram", "icon-linkedin", "icon-linkedin-sign",
															 "icon-linux", "icon-maxcdn", "icon-pinterest",
															 "icon-pinterest-sign", "icon-renren", "icon-skype", "icon-stack-exchange",
															  "icon-trello", "icon-tumblr", "icon-tumblr-sign",
															 "icon-twitter", "icon-twiter-sign",  "icon-vk",
															 "icon-weibo", "icon-windows", "icon-xing", "icon-xing-sign",
															 "icon-youtube", "icon-youtube-play", "icon-youtube-sign");
			
			$availableIcons['Medical Icons'] = array("icon-ambulance", "icon-h-sign", "icon-hospital", "icon-medkit",
													 "icon-plus-sign-alt", "icon-stethoscope", "icon-user-md");

			
			


		} else if (self::$fontAwesomeVersion == "4") {
			$availableIcons['Web Application Icons'] = array("fa-adjust", "fa-anchor", "fa-archive", "fa-arrows",
															 "fa-arrows-h", "fa-arrows-v", "fa-asterisk", "fa-ban",
															 "fa-bar-chart-o", "fa-barcode", "fa-bars", "fa-beer",
															 "fa-bell", "fa-bell-o", "fa-bolt", "fa-book",
															 "fa-bookmark", "fa-bookmark-o", "fa-briefcase", "fa-bug",
															 "fa-building-o", "fa-bullhorn", "fa-bullseye", "fa-calendar",
															 "fa-calendar-o", "fa-camera", "fa-camera-retro", "fa-caret-square-o-down",
															 "fa-caret-square-o-left", "fa-caret-square-o-right", "fa-caret-square-o-up", "fa-certificate",
															 "fa-check", "fa-check-circle", "fa-check-circle-o", "fa-check-square",
															 "fa-check-square", "fa-circle", "fa-circle-o", "fa-clock-o",
															 "fa-cloud", "fa-cloud-download", "fa-cloud-upload", "fa-code",
															 "fa-code-fork", "fa-coffee", "fa-cog", "fa-cogs",
															 "fa-comment", "fa-comment-o", "fa-comments","fa-comments-o",
															 "fa-compass", "fa-credit-card", "fa-crop", "fa-crosshairs",
															 "fa-cutlery", "fa-dashboard", "fa-desktop", "fa-dot-circle-o",
															 "fa-download", "fa-edit", "fa-ellipsis-h", "fa-ellipsis-v",
															 "fa-envelope", "fa-envelope-o", "fa-eraser", "fa-exchange",
															 "fa-exclamation", "fa-exclamation-circle", "fa-exclamation-triangle", "fa-external-link",
															 "fa-external-link-square", "fa-eye", "fa-eye-slash", "fa-female",
															 "fa-fighter-jet", "fa-film", "fa-filter", "fa-fire",
															 "fa-fire-extinguisher", "fa-flag", "fa-flag-checkered", "fa-flag-o",
															 "fa-flash", "fa-flask", "fa-folder", "fa-folder-o",
															 "fa-folder-open", "fa-folder-open-o", "fa-frown-o", "fa-gamepad",
															 "fa-gavel", "fa-gear", "fa-gears", "fa-gift",
															 "fa-glass", "fa-globe", "fa-group", "fa-hdd-o",
															 "fa-headphones", "fa-heart", "fa-heart-o", "fa-home",
															 "fa-inbox", "fa-info", "fa-info-circle", "fa-key",
															 "fa-keyboard-o", "fa-laptop", "fa-leaf", "fa-legal",
															 "fa-lemon-o", "fa-level-down", "fa-level-up", "fa-lightbulb-o",
															 "fa-location-arrow", "fa-lock", "fa-magic", "fa-magnet",
															 "fa-mail-forward", "fa-mail-reply", "fa-mail-reply-all", "fa-male",
															 "fa-map-marker", "fa-meh-o", "fa-microphone", "fa-microphone-slash",
															 "fa-minus", "fa-minus-circle", "fa-minus-square", "fa-minus-square-o",
															 "fa-mobile", "fa-mobile-phone", "fa-money", "fa-moon-o",
															 "fa-music", 
															 "fa-paw", "fa-pencil", "fa-pencil-square", "fa-pencil-square-o",
															 "fa-phone", "fa-phone-square", "fa-picture-o", "fa-plane", 
															 "fa-power-off", "fa-print", "fa-puzzle-piece", "fa-qrcode",
															 "fa-question", "fa-question-circle", "fa-quote-left", "fa-quote-right",
															 "fa-random", "fa-refresh", "fa-reply", "fa-reply-all",
															 "fa-retweet", "fa-road", "fa-rocket", "fa-rss",
															 "fa-rss-square", "fa-search", "fa-search-minus", "fa-search-plus",
															 "fa-share", "fa-share-square", "fa-share-square-o", "fa-shield",
															 "fa-shopping-cart", "fa-sign-in", "fa-sign-out", "fa-signal",
															 "fa-sitemap", "fa-smile-o", "fa-sort", "fa-sort-alpha-asc",
															 "fa-sort-desc", "fa-sort-down", "fa-sort-numeric-asc", "fa-sort-numeric-desc",
															 "fa-sort-up", "fa-spinner", "fa-square", "fa-square-o",
															 "fa-star", "fa-star-half", "fa-star-half-empty", "fa-star-half-full",
															 "fa-star-half-o", "fa-star-o", "fa-subscript", "fa-suitcase",
															 "fa-sun-o", "fa-superscript", "fa-tablet", "fa-tachometer",
															 "fa-tag", "fa-tags", "fa-tasks", "fa-terminal",
															 "fa-thumb-tack", "fa-thumbs-down", "fa-thumbs-o-down", "fa-thumbs-o-up",
															 "fa-thumbs-up", "fa-ticket", "fa-times", "fa-times-circle",
															 "fa-times-circle-o", "fa-tint", "fa-toggle-down", "fa-toggle-left",
															 "fa-toggle-right", "fa-toggle-up", "fa-trash-o", "fa-trophy",
															 "fa-truck", "fa-umbrella", "fa-unlock", "fa-unlock-alt",
															 "fa-unsorted", "fa-upload", "fa-user", "fa-users",
															 "fa-video-camera", "fa-volume-down", "fa-volume-off", "fa-volume-up",
															 "fa-warning", "fa-wheelchair", "fa-wrench");
			$availableIcons['Form Control Icons'] = array("fa-check-square", "fa-check-square-o", "fa-circle", "fa-circle-o",
															 "fa-dot-circle-o", "fa-minus-square", "fa-minus-square-o", "fa-plus-square",
															 "fa-plus-square-o", "fa-square", "fa-square-o");
			$availableIcons['Currency Icons'] = array(
															 "fa-bitcoin", "fa-cny", "fa-dollar",
															 "fa-euro", "fa-gdp", "fa-inr",
															  "fa-money", "fa-rmb",
															 "fa-rouble", "fa-ruble", "fa-rupee",
															 "fa-try", "fa-turkish-lira", "fa-usd", "fa-won",
															 "fa-yen");
			$availableIcons['Text Editor Icons'] = array("fa-align-center", "fa-align-justify", "fa-align-left", "fa-align-right",
															 "fa-bold", "fa-chain", "fa-chain-broken", "fa-clipboard",
															 "fa-columns", "fa-copy", "fa-cut", "fa-dedent",
															 "fa-eraser", "fa-file", "fa-file-o", "fa-file-text",
															 "fa-file-text-o", "fa-files-o", "fa-floppy-o", "fa-font",
															 "fa-indent", "fa-italic", "fa-link", "fa-list",
															 "fa-list-alt", "fa-list-ol", "fa-list-ul", "fa-outdent",
															 "fa-paperclip", "fa-paste", "fa-repeat", "fa-rotate-left",
															 "fa-rotate-right", "fa-save", "fa-scissors", "fa-strikethrough",
															 "fa-table", "fa-text-height", "fa-text-width", "fa-th",
															 "fa-th-large", "fa-th-list", "fa-underline", "fa-undo",
															 "fa-unlink");
			$availableIcons['Directional Icons'] = array("fa-angle-double-down", "fa-angle-double-left", "fa-angle-double-right", "fa-angle-double-up",
															 "fa-angle-down", "fa-angle-left", "fa-angle-right", "fa-angle-up",
															 "fa-arrow-circle-down", "fa-arrow-circle-left", "fa-arrow-circle-o-down", "fa-arrow-circle-o-left",
															 "fa-arrow-circle-o-right", "fa-arrow-circle-o-up", "fa-arrow-circle-right", "fa-circle-up",
															 "fa-arrow-down", "fa-arrow-left", "fa-arrow-right", "fa-arrow-up",
															 "fa-arrows", "fa-arrows-alt", "fa-arrows-h", "fa-arrows-v",
															 "fa-caret-down", "fa-caret-left", "fa-caret-right", "fa-caret-square-o-down",
															 "fa-caret-square-o-left", "fa-caret-square-o-right", "fa-caret-square-o-up", "fa-caret-up",
															 "fa-chevron-circle-down", "fa-chevron-circle-left", "fa-chevron-circle-right", "fa-chevron-circle-up",
															 "fa-chevron-down", "fa-chevron-left", "fa-chevron-right", "fa-chevron-up",
															 "fa-hand-o-down", "fa-hand-o-left", "fa-hand-o-right", "fa-hand-o-up",
															 "fa-long-arrow-down", "fa-long-arrow-left", "fa-long-arrow-right", "fa-long-arrow-up",
															 "fa-toggle-down", "fa-toggle-left", "fa-toggle-right", "fa-toggle-up");
			$availableIcons['Video Player Icons'] = array(
															 "fa-arrows-alt", "fa-backward", "fa-compress", "fa-eject",
															 "fa-expand", "fa-fast-backward", "fa-fast-foward", "fa-foward",
															 "fa-pause", "fa-play", "fa-play-circle", "fa-play-circle-o",
															 "fa-step-backward", "fa-step-forward", "fa-stop", "fa-youtube-play",
														  );
			
			$availableIcons['Brand Icons'] = array( "fa-adn", "fa-android", "fa-apple", "fa-bitbucket",
															 "fa-bitbucket-square", "fa-bitcoin", "fa-btc", "fa-css3",
															 "fa-dribble", "fa-dropbox", "fa-facebook", "fa-facebook-square",
															 "fa-flickr", "fa-foursquare", "fa-github", "fa-github-alt",
															 "fa-github-square", "fa-gittip", "fa-google-plus", "fa-google-plus-square",
															 "fa-html5", "fa-instagram", "fa-linkedin", "fa-linkedin-square",
															 "fa-linux", "fa-maxcdn", "fa-pagelines", "fa-pinterest",
															 "fa-pinterest-square", "fa-renren", "fa-skype", "fa-stack-exchange",
															 "fa-stack-overflow", "fa-trello", "fa-tumblr", "fa-tumblr-square",
															 "fa-twitter", "fa-twiter-square", "fa-vimeo-square", "fa-vk",
															 "fa-weibo", "fa-windows", "fa-xing", "fa-xing-square",
															 "fa-youtube", "fa-youtube-play", "fa-youtube-square");
			$availableIcons['Medical Icons'] = array("fa-ambulance", "fa-h-square", "fa-hospital-o", "fa-medkit",
													 "fa-plus-square", "fa-stethoscope", "fa-user-md", "fa-wheelchair");

			
			
	
	}
	//return "";
	if ($displayStep == "1") { 
		?>
        <script>
		function setFontAwesomeSelect<?php echo $id; ?>(inputName, value) {
			//alert(inputName + " -- " + value);
			
		  var selectedOption = jQuery("#link_<?php echo $id; ?>__" + value);
		  jQuery("input[name='" + inputName + "']").val(value);
		  		  		  jQuery("input[name='" + inputName + "']").trigger('change');

		 // alert(value);
		  var iconHTML = jQuery(selectedOption).html();
		  if (iconHTML == undefined ) {
			  iconHTML = "<i class='fa fa-fw " + value + "'></i>";
		  }
		  
		  jQuery("#fa-chooser-display-<?php echo $id; ?>").html(iconHTML + " <b class='caret'></b>");
		  <?php if ($onChangeJS != "") { ?><?php echo $onChangeJS; ?>;<?php } ?>
		}
		jQuery(document).ready(function() {
										
										<?php if ($inputValue != "" || $default) { ?>
										setFontAwesomeSelect<?php echo $id; ?>('<?php echo $inputName; ?>', '<?php echo $inputValue; ?>'); 
										<?php } ?>
										
					var data = {
								'action': 'i3d_get_font_awesome_picker',
								'id': '<?php echo $id; ?>',
								'inputName': '<?php echo $inputName; ?>',
								'inputValue': '<?php echo $inputValue; ?>',
								'default': <?php if ($default) { print "true"; } else { print "false"; } ?>,
								'defaultSelector': '<?php echo $defaultSelector; ?>',
								'noIcon': '<?php echo $defaultSelector; ?>',
								'groups': '<?php echo implode(",", $groups); ?>'
							};

		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		jQuery.post(ajaxurl, data, function(response) {
											//alert(response);
			jQuery("#fa-picker-<?php echo $id; ?>").append(response);
		});										
										
										});
		</script>
    <input  value="<?php echo $inputValue; ?>" type="hidden" name="<?php echo $inputName; ?>" id="hidden__<?php echo $inputName; ?>" />
	<ul class="nav nav-pills fa-icon-chooser">
		<li class="dropdown" id="fa-picker-<?php echo $id; ?>">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#" id="fa-chooser-display-<?php echo $id; ?>"><?php if ($inputValue != "") { print $inputValue; } else { print $defaultSelector; } ?> <b class="caret"></b></a>
    		<?php } ?>
			<?php if ($displayStep == "2") { ?>
			<ul  class="dropdown-menu" role="menu" aria-labelledby="dLabel">
    			<li class="fa-no-icon fa-icon-chooser-li"><a id="link_<?php echo $id; ?>__<?php if ($default) { print 'x'; } else { print ''; } ?>" href="javascript:setFontAwesomeSelect<?php echo $id; ?>('<?php echo $inputName; ?>', '<?php if ($default) { print 'x'; } else { print ''; } ?>', this);"><?php echo $noIcon; ?></a></li>
   				<?php if ($default) { ?>
     			<li  class="fa-default-icon  fa-icon-chooser-li"><a id="link_<?php echo $id; ?>__" href="javascript:setFontAwesomeSelect<?php echo $id; ?>('<?php echo $inputName; ?>', '', this);">-- Site Default --</a></li>
				<?php } ?>
				<?php 
				//var_dump($groups);
				foreach ($availableIcons as $section => $icons) {  
	  				if (sizeof($groups) == 0 || in_array($section, $groups)) { 
						?>
    				<li class="fa-section-break  fa-icon-chooser-li"><?php echo $section; ?></li>
    				<?php
	        			foreach ($icons as $icon) { ?>
    				<li class="fa-icon-chooser-li"><a id="link_<?php echo $id; ?>__<?php echo $icon; ?>" href="javascript:setFontAwesomeSelect<?php echo $id; ?>('<?php echo $inputName; ?>', '<?php echo $icon; ?>', this);"><i class="<?php if (strstr($icon, "fa-")) { echo "fa fa-fw "; } echo $icon; ?>"></i></a></li>
    				<?php 
						}
	  				}
				} ?>
    		</ul>
			<?php } ?>
    	</li>
    </ul>
        
		<?php
	}
	
	public static function conditionFontAwesomeIcon($text, $convertNonVersionedIcon = false) {
	  if (self::$fontAwesomeVersion >= 4) {
		  if (strstr($text, "icon-")) {
			  $text = str_replace("icon-picture", "icon-picture-o", $text);
			  $text = str_replace("icon-", "fa fa-", $text);
			  $text = str_replace("fa-phone-sign", "fa-phone", $text);
			  $text = str_replace("fa-info-sign", "fa-info-circle", $text);
		  } else if (!strstr($text, "fa") && $convertNonVersionedIcon) {
			$text = "fa-".$text;  
		  }
	  } else {
		  if (strstr($text, "fa fa-")) {
			  $text = str_replace("fa fa-", "icon-", $text);
		  } else if (!strstr($text, "icon") && $convertNonVersionedIcon) {
			$text = "icon-".$text;  
		  }
	  }
	  
	  if (strstr($text, "fa-") && strstr($text, "fa ") === false) {
		$text = "fa ".$text;  
	  }
	  
	  if ($text == "fa fa-") {
		  $text = "";
	  }
	  return $text;
	}

	public static function conditionBootstrapSpan($text) {
	  if (self::$bootstrapVersion >= 3) {
		  if (strstr($text, "span")) {
			  $text = str_replace("span", "col-xs-12 col-md-", $text);
		  }
	  } else {
		  if (strstr($text, "col-lg-")) {
			  $text = str_replace("col-lg-", "span", $text);
		  }
	  }
	  return $text;
	}

	public static function getDropDownsMenuID($pageID) {
		$dropDownMenuID = get_post_meta($pageID, 'i3d_drop_menu_id', true);

		if ($dropDownMenuID == "") {
		  return false;	
		} else if ($dropDownMenuID == "*") {
		  // need to get the system default	
		} else {
		  return $dropDownMenuID;
		}
			
	//I3D_Framework::getMenuID("I3D*Top")	
	}
	
	public static function getPageContactFormID($pageID) {
		$contactFormID = get_post_meta($pageID, 'i3d_contact_menu_id', true);
		//print "oh, have $contactFormID";
		if ($contactFormID == "") {
		  return false;	
		} else if ($contactFormID == "*") {
		  // need to get the system default	
		} else {
		  return $contactFormID;
		}
			
	//I3D_Framework::getMenuID("I3D*Top")	
	}	
	public static function getTemplatesForSpecialWidget($widgetClassName) {
		$pageLayouts = "";
	  foreach (self::$templateRegions as $layout => $layoutData) {
		foreach ($layoutData as $regionID => $regionData) {
			if (is_array($regionData['configuration']) ) {
				foreach ($regionData['configuration'] as $columnData) {
				   if (is_array($columnData) && is_array($columnData['widgets'])) {
					   foreach ($columnData['widgets'] as $widgetData) {
						   if ($widgetData['class_name'] == $widgetClassName) {
							   $pageLayouts .= $layout." ";
						   }
						 
					   }
				   }
				}
			}
		}
	  }
		  
	  return $pageLayouts;
		  
	}
   // configurationType == "user-defined" || "pre-defined"
   // configuration == array of columns of widgets and widget parameters
   public static function defineTemplateRegion($layout, $region, $description, $configurationType, $configuration = array()) {
	  if (!is_array(self::$templateRegions)) {
		  self::$templateRegions = array();
	  }
	  self::$templateRegions["{$layout}"]["{$region}"]["type"]          = $configurationType;
	  self::$templateRegions["{$layout}"]["{$region}"]["description"]   = $description;
	  self::$templateRegions["{$layout}"]["{$region}"]["configuration"] = $configuration;
	  
   }

	public static function addSlider($id, $title, $dimensions, $setImages = -1, $isSignature = false) {
		if (!is_array(self::$sliders)) {
			self::$sliders = array();
		}
		self::$sliders["$id"] = array("title" => $title, "dimensions" => $dimensions, "set_images" => $setImages, "is_signature" => $isSignature);
		
		
	}

	public static function sliderDimensionConfigurable($sliderType, $dimension) {
	  if ($dimension == "width") {
		  if ($sliderType == "fullscreen-slider" ||
			  $sliderType == "fullscreen-carousel" ||
			  $sliderType == "video-slider" ||
			  $sliderType == "parallax-slider" ||
			  $sliderType == "jumbotron-carousel") {
			  return false;
		  }
	  } 
	  if ($dimension == "height") {
		  if ($sliderType == "jumbotron-carousel" ||
			  $sliderType == "parallax-slider" ||
			  $sliderType == "video-slider") {
			  return false;
		  }
	  }
	  
	  return true;
	
	}
	public static function getSignatureSliderID() {
	  foreach (self::$sliders as $id => $slider) {
		if ($slider['is_signature']) {
			return $id;
		}
	  }
	  return $id;
	}
	public static function getSliders() {
	  return self::$sliders;	
	}
	
	public static function getSlider($id) {
		if (array_key_exists($id, self::$sliders)) {
		return self::$sliders["{$id}"];
		} else {
			return array();
		}
	}
	
	public static function whenLastUpdated() {
		$whenUpdated = get_option("i3d_when_last_updated");
		
		if ($whenUpdated == "") {
		  return "Never";	
		} else {
			$date = date_i18n(get_option('date_format')." (".get_option("time_format").")",$whenUpdated, true);
		  return $date;
		}
		
	}

	public static function whenLastChecked() {
		$whenChecked = get_option("i3d_when_last_checked_for_update");
		
		if ($whenChecked == "") {
		  return "Never";	
		} else {
			//print get_option("date_format");
			//print "<br>".date("Y-m-d H:i", $whenChecked);
			//print "<br>".date("Y-m-d H:i T");
			//print "<br>v".the_date()."a<br>";
			//print date_i18n(get_option('date_format')." (".get_option("time_format").")");
			$date = date_i18n(get_option('date_format')." (".get_option("time_format").")",$whenChecked);
		  return $date;
		}
		
	}

	public static function newerVersion($version1, $version2) {
	  $version1Data = explode(".", $version1);
	  $version2Data = explode(".", $version2);
	  
	  if (!isset($version1Data[1])) {
		  $version1Data[1] = 0;
	  }
	  if (!isset($version2Data[1])) {
		  $version2Data[1] = 0;
	  }
	  if (!isset($version1Data[2])) {
		  $version1Data[2] = 0;
	  }
	  if (!isset($version2Data[2])) {
		  $version2Data[2] = 0;
	  }

	  if (!isset($version1Data[3])) {
		  $version1Data[3] = 0;
	  }
	  if (!isset($version2Data[3])) {
		  $version2Data[3] = 0;
	  }
	  
	if ($version1Data[0] < $version2Data[0]) {
				return false;
	} else if ($version1Data[0] > $version2Data[0]) {
		  return true;
	  } else {
		  if ($version1Data[1] < $version2Data[1]) {
				return false;
		  } else if ($version1Data[1] > $version2Data[1]) {
			  return true;
		  } else {
			if ($version1Data[2] < $version2Data[2]) {
				return false;
			} else if ($version1Data[2] > $version2Data[2]) {
			 
			  return true;
		  	} else {
			  	if ($version1Data[3] > $version2Data[3]) {
				
					return true;  
			  
			  	}
		  	}
		  }
	  }
	  return false;
	}
	public static function updateIsCurrent() {
		$updateVersionTemplate  = get_option("i3d_theme_update_version");
		$updateVersionFramework = get_option("i3d_framework_update_version");
		$theme = wp_get_theme();
		
		if (self::newerVersion($updateVersionTemplate, $theme->Version)) {
			return false;
		} 
		if (self::newerVersion($updateVersionFramework, I3D_Framework::$version)) {
		  return false;	
		}
		
		return true;
	}
	
	public static function getFrameworkUpdateVersion() {
	  $updateVersionFramework = get_option("i3d_framework_update_version");
	  if ($updateVersionFramework == "") {
		  return "Unknown";
	  } else {
	    return $updateVersionFramework;	
	  }
	}

	public static function getThemeUpdateVersion() {
	  $updateVersionTheme = get_option("i3d_theme_update_version");
	  if ($updateVersionTheme == "") {
		  return "Unknown";
	  } else {
	    return $updateVersionTheme;	
	  }	}

	public static function getFrameworkVersion() { 
	  return self::$version;	 
	}
	public static function getFrameworkVersionName() { 
	  return self::$versionName;	 
	}	
	public static function getFrameworkConfigurationName() { 
	  return self::$configurationName;	 
	}	
	public static function getThemeVersion() {
		$theme = wp_get_theme();
		return $theme->Version;
	}
	public static function getAvailableContactForms() {
	  $forms = get_option("i3d_contact_forms");
	  if (!is_array($forms)) {
		  $forms = array();
	  }
	  $formArray = array();
	  foreach ($forms as $formID => $formData) {
		$formArray["$formID"] = $formData['form_title'];  
	  }
	  
	  return $formArray;
	}

	public static function getAvailableMenus() {

		$i3dMenus = get_option('i3d_menu_options');


	  if (!is_array($i3dMenus)) {
		  $i3dMenus = array();
	  }
	  $menusArray = array();
	  foreach ($i3dMenus as $menuID => $menuName) {
		$menusArray["$menuID"] = $menuName;  
	  }
	  		
	  return $menusArray;
	}


	public static function getAvailableFrameworkVersion() {
		return get_option("i3d_framework_update_version");
	}

	public static function getAvailableThemeVersion() {
		return get_option("i3d_theme_update_version");
	}

	public static function download_and_update() {
		global $aquilaUpdater;

	    $aquilaUpdater->bulk_upgrade();	
	}
	public static function check_update_version() {
		global $aquilaUpdater;

	    $aquilaUpdater->update_check(true);	
	}
	
	public static function pre_activate() {
		global $templateName;
		$templateName2 = str_replace(' ', '_', ucwords($templateName));
		if ($pagenow == "users.php") {
			return;
		}	
		update_option("installation_status", "Commencing Pre-Activation Routine");
		update_option("installation_status_percent", 5);

		
		
		self::check_init_push_time();
		I3D_Framework::init_menus();
		
		$existingPages = get_pages();

		if (count($existingPages) <=1) {
			if (!self::$debugOn) {
			  wp_redirect(admin_url("admin.php?page=i3d-settings&configuration=default&activated=true"));
			} else {
				exit;
			}
		} else {
			if (!self::$debugOn) {
			  wp_redirect(admin_url("admin.php?page=i3d-settings&config=requested"));
			} else {
				exit;
			}
		}
		//}		
		//exit;
	}

	public static function init_license() {
	   self::debug("In init_license()");
	   @include(get_template_directory().'/includes/framework/init-license.php');
	   self::debug("Finished init_license()");
	}
	
	public static function activate() {
		self::debug("In activate()");
		
		self::check_init_push_time();
		self::set_config_status(10, "Commencing Activation Routine");								
		global $lmUpdaterAvailable;
		if ($lmUpdaterAvailable) {
			I3D_Framework::init_license();
		}

		self::check_init_push_time();
		self::set_config_status(11, "Initializing General Settings");								
		I3D_Framework::init_generalSettings();
		
		self::check_init_push_time();
		self::set_config_status(12, "Initializing Layout Settings");								
		I3D_Framework::init_layoutSettings();
		I3D_Framework::init_layouts(true);		
		
		self::check_init_push_time();
		self::set_config_status(15, "Initializing Sidebars");								
		I3D_Framework::init_sideBars();
		
		if (@$_GET['init_pages'] == "1" || @$_POST['init_pages'] == "1") {
			self::check_init_push_time(25); // tell the system that we need 25 seconds to perform this procedure
			self::set_config_status(25, "Initializing Pages");								
			I3D_Framework::init_pages();
		}
		
		self::check_init_push_time(25); // tell the system that we need 25 seconds to perform this procedure
		self::set_config_status(40, "Initializing Navigation");								
		I3D_Framework::init_navigation();
	 
	 	
	 	self::check_init_push_time();
		self::set_config_status(65, "Initializing Sliders");								
		I3D_Framework::init_sliders();

	    if (@$_GET['init_pages'] == "1" || @$_POST['init_pages'] == "1") {
			self::check_init_push_time();
			self::set_config_status(70, "Initializing Photo Slider");		
			I3D_Framework::init_photo_slideshow();
		}
		
		if (@$_GET['init_posts'] == "1" || @$_POST['init_posts'] == "1") {
			self::check_init_push_time();
			self::set_config_status(75, "Initializing Posts");										
			I3D_Framework::init_posts();
		}
		
		if (@$_GET['init_widgets'] == "1" || @$_POST['init_widgets'] == "1") {

			if (get_option('luckymarble_create_widgets', true)) {
				self::check_init_push_time(15);
				self::set_config_status(85, "Initializing Widgets");										
				self::debug("About To call ::install_widgets()");
				I3D_Framework::install_widgets();
				update_option('luckymarble_create_widgets', false);
			}
		}
		if ($lmUpdaterAvailable) {
			self::check_init_push_time();
			self::set_config_status(95, "Fetching Extensions");										
			self::debug("About To FetchExtensions ::install_widgets()");
			self::fetchExtensions();
		}

		self::set_config_status(100, "Installation Complete!");										
		self::debug("Done Activation");
	}
	
	public static function init_forms($keepExisting = false) {
		self::debug("In init_forms()");
		
		$contactForms = get_option("i3d_contact_forms");
		if (!is_array($contactForms)) {
			$contactForms = array();
		}
		
		self::debug("Have ".sizeof($contactForms)." forms existing");
	  
		if ($contactForms && count($contactForms) > 0 && !$keepExisting) {
			self::debug("Exiting Early -- No new forms created");
		} else {
			$pages 	= get_pages();
			$fields = array();
			//print self::$initForm['standard-contact-panel'];
			//exit;
			if (self::$useContactPanelForm || (@self::$initForm['standard-contact-panel'])) {
			//	$id = wp_create_nonce("i3d_contact_form".(mktime()+1));
				$id = "cf_default_cpanel";

				$fields[] = array('fieldtype' => "text",  	 'fieldwidth' => "span3",  'label' => "Your Name",    'required' => "1", 'placeholder' => "Your Name",    'visible' => 1, 'options' => array(), 'multiple' => 0, 'prepend_icon' => "icon-user",      'checked_value' => "");	
				$fields[] = array('fieldtype' => "email", 	 'fieldwidth' => "span3",  'label' => "Your Email",   'required' => "1", 'placeholder' => "Your Email",   'visible' => 1, 'options' => array(), 'multiple' => 0, 'prepend_icon' => "icon-envelope",  'checked_value' => "");
				$fields[] = array('fieldtype' => "skill", 	 'fieldwidth' => "span6",  'label' => "Skill Test",   'required' => "1", 'placeholder' => "", 		  	  'visible' => 1, 'options' => array(), 'multiple' => 0, 'prepend_icon' => "icon-info-sign", 'checked_value' => "");
				$fields[] = array('fieldtype' => "textarea", 'fieldwidth' => "span12", 'label' => "Your Message", 'required' => "1", 'placeholder' => "Your Message", 'visible' => 1, 'options' => array(), 'multiple' => 0, 'prepend_icon' => "icon-envelope",  'checked_value' => "");
				$contactForms["{$id}"] = array(	'id' => $id,
												'form_title' => "Contact Panel",
												'form_title_wrap' => 'x',
												'submit_button_label' => "Submit",
												'form_email' => get_site_option('admin_email'),
												'show_reset_button' => 1,
												'form_description' => '<h1><span class="sign-up">Message</span> or <span class="contact-call">Call: <a href="tel://5555551234">555.555.1234</a></span></h1>',
												'fields' => $fields
												);
			} 
			
			// use the standard contact box			
			if (array_key_exists("standard-contact-box", self::$initForm) && self::$initForm['standard-contact-box']) {	
				//$id = wp_create_nonce("i3d_contact_form".(mktime()+2));
				$id = "cf_default_cb";

				$fields[] = array('fieldtype' => "text",  	 'fieldwidth' => "span12", 'label' => "Your Name",    'required' => "1", 'placeholder' => "Your Name", 	'visible' => 1, 'options' => array(), 'multiple' => 0, 'prepend_icon' => "icon-user", 'checked_value' => "");
				$fields[] = array('fieldtype' => "email", 	 'fieldwidth' => "span12", 'label' => "Your Email",   'required' => "1", 'placeholder' => "Your Email", 	'visible' => 1, 'options' => array(), 'multiple' => 0, 'prepend_icon' => "icon-envelope", 'checked_value' => "");
				$fields[] = array('fieldtype' => "skill", 	 'fieldwidth' => "span12", 'label' => "Skill Test",   'required' => "1", 'placeholder' => "", 			'visible' => 1, 'options' => array(), 'multiple' => 0, 'prepend_icon' => "icon-info-sign", 'checked_value' => "");	
				$fields[] = array('fieldtype' => "textarea", 'fieldwidth' => "span12", 'label' => "Your Message", 'required' => "1", 'placeholder' => "Your Message", 'visible' => 1, 'options' => array(), 'multiple' => 0, 'prepend_icon' => "icon-envelope", 'checked_value' => "");		
				$contactForms["{$id}"] = array(	'id' => $id,
												'form_title' => "Contact Box",
												'submit_button_label' => "Submit",
												'form_email' => get_site_option('admin_email'),
												'fields' => $fields
												);
			}
		
			// standard contact form for contact page
			if (array_key_exists("standard-contact-page", self::$initForm) && self::$initForm['standard-contact-page']) {
				$fields = array();
				//$id2 = wp_create_nonce("i3d_contact_form".(mktime()+3));
				$id2 = "cf_default_cp";
				
				$fields[] = array('fieldtype' => "text",     'fieldwidth' => "span6",  'label' => "First Name", 			'required' => "1", 'placeholder' => "First Name", 	'visible' => 1, 'options' => "", 'multiple' => 0, 'prepend_icon' => "", 'checked_value' => "");
				$fields[] = array('fieldtype' => "text",     'fieldwidth' => "span6",  'label' => "Last Name", 				'required' => "1", 'placeholder' => "Last Name", 	'visible' => 1, 'options' => "", 'multiple' => 0, 'prepend_icon' => "", 'checked_value' => "");	
				$fields[] = array('fieldtype' => "email",    'fieldwidth' => "span12", 'label' => "Your Email", 			'required' => "1", 'placeholder' => "Your Email", 	'visible' => 1, 'options' => "", 'multiple' => 0, 'prepend_icon' => "", 'checked_value' => "");
				$fields[] = array('fieldtype' => "skill",    'fieldwidth' => "span12", 'label' => "Skill Testing Question", 'required' => "1", 'placeholder' => "", 			'visible' => 1, 'options' => "", 'multiple' => 0, 'prepend_icon' => "", 'checked_value' => "");
				$fields[] = array('fieldtype' => "textarea", 'fieldwidth' => "span12", 'label' => "Your Message", 			'required' => "1", 'placeholder' => "Your Message", 'visible' => 1, 'options' => "", 'multiple' => 0, 'prepend_icon' => "", 'checked_value' => "");
			
				$contactForms["{$id2}"] = array('id' => $id2,
												'form_title' => "We'd Love To Hear From You!",
												'form_title_tag' => "h2",
												'form_description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum eleifend augue quis nibh facilisis semper. Vivamus non pulvinar magna. Praesent massa orci, dapibus non vehicula in, luctus ut sem. Nunc tellus lacus, mollis eu justo vitae, varius rutrum libero. Aenean porttitor elementum nulla, quis mollis magna mollis quis. Aenean eleifend mollis metus in tristique. Sed vehicula mauris at lacus condimentum tempor. ",
												'submit_button_label' => "Submit",
												'form_email' => get_site_option('admin_email'),
												'redirect_page' => self::getPageID("Contact Confirmation"),
												'fields' => $fields
												);

				$pageToChange = get_post(self::getPageID("Contact"));
				if ($pageToChange != "") {
					$pageToChange->post_content = str_replace("[[contactpageform]]", '[i3d_contact_form id="'.$id2.'"]', $pageToChange->post_content);
					wp_update_post(array('ID' => $pageToChange->ID, 'post_content' => $pageToChange->post_content));
				}				
			}

			// preschool "child absence notification"
			if (array_key_exists("preschool-child-absence", self::$initForm) && self::$initForm['preschool-child-absence']) {
				$fields = array();
				//$id = wp_create_nonce("i3d_contact_form".(mktime()+4));
				$id = "cf_default_ps1";
				$fields[] = array('fieldtype' => "text",     'fieldwidth' => "span6",  'label' => "Child Name", 			 'required' => "1", 'placeholder' => "Child Name", 	'visible' => 1, 'options' => "", 'multiple' => 0, 'prepend_icon' => "", 'checked_value' => "");
				$fields[] = array('fieldtype' => "select",   'fieldwidth' => "span6",  'label' => "Program", 				 'required' => "1", 'placeholder' => "", 			'visible' => 1, 'options' => "Infant\nToddler\nPreschool", 'multiple' => 0, 'prepend_icon' => "", 'checked_value' => "");	
				$fields[] = array('fieldtype' => "text",     'fieldwidth' => "span6",  'label' => "Parent Name", 			 'required' => "1", 'placeholder' => "Parent Name", 'visible' => 1, 'options' => "", 'multiple' => 0, 'prepend_icon' => "", 'checked_value' => "");	
				$fields[] = array('fieldtype' => "text",     'fieldwidth' => "span6", 'label' => "Phone Number", 			 'required' => "1", 'placeholder' => "555-555-1234",'visible' => 1, 'options' => "", 'multiple' => 0, 'prepend_icon' => "", 'checked_value' => "");
				$fields[] = array('fieldtype' => "textarea", 'fieldwidth' => "span6", 'label' => "Reason Away", 			 'required' => "1", 'placeholder' => "Reason Away", 'visible' => 1, 'options' => "", 'multiple' => 0, 'prepend_icon' => "", 'checked_value' => "");
				$fields[] = array('fieldtype' => "date",     'fieldwidth' => "span6", 'label' => "Expected Date Of Return", 'required' => "1", 'placeholder' => "", 			'visible' => 1, 'options' => "", 'multiple' => 0, 'prepend_icon' => "", 'checked_value' => "", 'date_format' => 'mm/dd/yyy');
			
				$contactForms["{$id}"] = array('id' => $id,
												'form_title' => "Child Absence Notification",
												'form_description' => "Submit or Call: <a title='Call' href='tel:555-555-1234'>555-555-1234</a>\n\nUse this form to notify us that your child will be absent from their program.",
												'submit_button_label' => "Submit",
												'form_email' => get_site_option('admin_email'),
												'redirect_page' => self::getPageID("Absence Report Confirmation"),
												'fields' => $fields
												);
				$pageToChange = get_post(self::getPageID("Report Child Away"));
				if ($pageToChange != "") {
					$pageToChange->post_content = str_replace("[[absence-form]]", '[i3d_contact_form id="'.$id.'"]', $pageToChange->post_content);
					wp_update_post(array('ID' => $pageToChange->ID, 'post_content' => $pageToChange->post_content));
				}
			}

			// preschool "employment application"
			if (array_key_exists("preschool-employment-application", self::$initForm) && self::$initForm['preschool-employment-application']) {
				$fields = array();
				//$id = wp_create_nonce("i3d_contact_form".(mktime()+5));
				$id = "cf_default_ps2";
				$fields[] = array('fieldtype' => "text",     'fieldwidth' => "span6",  'label' => "Your Name", 			  'required' => "1", 'placeholder' => "Your Name", 		'visible' => 1, 'options' => array(), 'multiple' => 0, 'prepend_icon' => "", 'checked_value' => "");
				$fields[] = array('fieldtype' => "email",    'fieldwidth' => "span6",  'label' => "Email Address", 		  'required' => "1", 'placeholder' => "Email Address", 	'visible' => 1, 'options' => array(), 'multiple' => 0, 'prepend_icon' => "", 'checked_value' => "");
				$fields[] = array('fieldtype' => "text",     'fieldwidth' => "span6",  'label' => "Phone Number", 		  'required' => "1", 'placeholder' => "555-555-1234", 	'visible' => 1, 'options' => array(), 'multiple' => 0, 'prepend_icon' => "", 'checked_value' => "");
				$fields[] = array('fieldtype' => "select",   'fieldwidth' => "span6",  'label' => "Program Applying For", 'required' => "1", 'placeholder' => "", 				'visible' => 1, 'options' => "Infant\nToddler\nPreschool", 'multiple' => 1, 'prepend_icon' => "", 'checked_value' => "");	
				$fields[] = array('fieldtype' => "textarea", 'fieldwidth' => "span6",  'label' => "Education", 			  'required' => "1", 'placeholder' => "Education", 		'visible' => 1, 'options' => array(), 'multiple' => 0, 'prepend_icon' => "", 'checked_value' => "");	
				$fields[] = array('fieldtype' => "textarea", 'fieldwidth' => "span6",  'label' => "Experience", 		  'required' => "1", 'placeholder' => "Experience",		'visible' => 1, 'options' => array(), 'multiple' => 0, 'prepend_icon' => "", 'checked_value' => "");
				$fields[] = array('fieldtype' => "textarea", 'fieldwidth' => "span12", 'label' => "Comments", 			  'required' => "0", 'placeholder' => "Comments", 		'visible' => 1, 'options' => array(), 'multiple' => 0, 'prepend_icon' => "", 'checked_value' => "");
			
				$contactForms["{$id}"] = array('id' => $id,
												'form_title' => "Employment Application",
												'form_description' => "Apply online to join our team.",
												'submit_button_label' => "Submit",
												'form_email' => get_site_option('admin_email'),
												'redirect_page' => self::getPageID("Contact Confirmation"),
												'fields' => $fields
												);
				$pageToChange = get_post(self::getPageID("Careers"));
				if ($pageToChange != "") {
					$pageToChange->post_content = str_replace("[[employment-application-page-form]]", '[i3d_contact_form id="'.$id.'"]', $pageToChange->post_content);
					wp_update_post(array('ID' => $pageToChange->ID, 'post_content' => $pageToChange->post_content));
				}
			}

			// preschool "program enrollment application"
			if (array_key_exists("preschool-enrollment-application", self::$initForm) && self::$initForm['preschool-enrollment-application']) {
				$fields = array();
				//$id = wp_create_nonce("i3d_contact_form".(mktime()+6));
				$id = "cf_default_ps3";
				$fields[] = array('fieldtype' => "text",     'fieldwidth' => "span6",  'label' => "Your Name", 			  'required' => "1", 'placeholder' => "Your Name", 		'visible' => 1, 'options' => array(), 'multiple' => 0, 'prepend_icon' => "", 'checked_value' => "");
				$fields[] = array('fieldtype' => "text",     'fieldwidth' => "span6",  'label' => "Daytime Phone Number", 'required' => "1", 'placeholder' => "555-555-1234", 	'visible' => 1, 'options' => array(), 'multiple' => 0, 'prepend_icon' => "", 'checked_value' => "");
				$fields[] = array('fieldtype' => "text",     'fieldwidth' => "span6",  'label' => "Evening Phone Number", 'required' => "1", 'placeholder' => "555-555-1234", 	'visible' => 1, 'options' => array(), 'multiple' => 0, 'prepend_icon' => "", 'checked_value' => "");
				$fields[] = array('fieldtype' => "email",    'fieldwidth' => "span6",  'label' => "Email Address", 		  'required' => "1", 'placeholder' => "Email Address", 	'visible' => 1, 'options' => array(), 'multiple' => 0, 'prepend_icon' => "", 'checked_value' => "");
				$fields[] = array('fieldtype' => "textarea", 'fieldwidth' => "span6",  'label' => "How Did You Hear About Us", 'required' => "0", 'placeholder' => "How Did You Hear About Us", 'visible' => 1, 'options' => array(), 'multiple' => 0, 'prepend_icon' => "", 'checked_value' => "");	
				$fields[] = array('fieldtype' => "heading",  'fieldwidth' => "span12",  'label' => "Child Information", 			  'required' => "0", 'placeholder' => "", 		'visible' => 1, 'options' => array(), 'multiple' => 0, 'prepend_icon' => "", 'checked_value' => "");
				$fields[] = array('fieldtype' => "text",     'fieldwidth' => "span6",  'label' => "Child's Name", 			  'required' => "1", 'placeholder' => "Child's Name", 	'visible' => 1, 'options' => array(), 'multiple' => 0, 'prepend_icon' => "", 'checked_value' => "");
				$fields[] = array('fieldtype' => "date",     'fieldwidth' => "span6",  'label' => "Birthdate", 			  'required' => "1", 'placeholder' => "", 					'visible' => 1, 'options' => array(), 'multiple' => 0, 'prepend_icon' => "", 'checked_value' => "", 'date_format' => 'mm/dd/yyy');
				$fields[] = array('fieldtype' => "select",   'fieldwidth' => "span6",  'label' => "Program Applying For", 'required' => "1", 'placeholder' => "", 					'visible' => 1, 'options' => "Infant Program (1-2 year olds)\nToddler Program (2-3 year olds)\nPreschool (3-5 year olds)", 'multiple' => 0, 'prepend_icon' => "", 'checked_value' => "");	
				$fields[] = array('fieldtype' => "date",     'fieldwidth' => "span6",  'label' => "Desired Start Date",   'required' => "1", 'placeholder' => "", 					'visible' => 1, 'options' => array(), 'multiple' => 0, 'prepend_icon' => "", 'checked_value' => "", 'date_format' => 'mm/dd/yyy');
				$fields[] = array('fieldtype' => "textarea", 'fieldwidth' => "span12", 'label' => "Comments", 			  'required' => "1", 'placeholder' => "Tell Us A Bit About Your Child", 		'visible' => 1, 'options' => array(), 'multiple' => 0, 'prepend_icon' => "", 'checked_value' => "");
			
				$contactForms["{$id}"] = array('id' => $id,
												'form_title' => "Program Enrollment Application",
												'form_description' => "Apply online for a position in one of our programs.",
												'submit_button_label' => "Submit",
												'form_email' => get_site_option('admin_email'),
												'redirect_page' => self::getPageID("Contact Confirmation"),
												'fields' => $fields
												);
				
				$pageToChange = get_post(self::getPageID("Program Enrollment Application"));
				if ($pageToChange != "") {
					$pageToChange->post_content = str_replace("[[enrollment-application-page-form]]", '[i3d_contact_form id="'.$id.'"]', $pageToChange->post_content);
					wp_update_post(array('ID' => $pageToChange->ID, 'post_content' => $pageToChange->post_content));
				}
			}
			
			// save forms
		  	update_option("i3d_contact_forms", $contactForms);
		}
	}


	public static function init_layouts($keepExisting = false) {
		self::debug("In init_layouts()");
		
		$layouts = get_option("i3d_layouts");
		if (!is_array($layouts)) {
			$layouts = array();
		}
		
		self::debug("Have ".sizeof($layouts)." layouts existing");
	  
		if ($layouts && count($layouts) > 0 && !$keepExisting) {
			self::debug("Exiting Early -- No new layouts created");
		} else {
			$layouts = I3D_Framework::$defaultLayouts;
			
			// save forms
		  	update_option("i3d_layouts", $layouts);
		}
	}

	public static function revert_layout($layout_id) {
		self::debug("In init_layouts()");
		
		$layouts = get_option("i3d_layouts");
		if (!is_array($layouts)) {
			$layouts = array();
		}
		
		self::debug("Have ".sizeof($layouts)." layouts existing");
	  
		$layouts["$layout_id"] = I3D_Framework::$defaultLayouts["$layout_id"];
	//		$layouts = I3D_Framework::$defaultLayouts;
			
			// save forms
		  	update_option("i3d_layouts", $layouts);
		
	}

	public static function add_default_layout($id, $title, $isDefault, $sections) {
	  self::$defaultLayouts["{$id}"] = array("id" => $id, "title" => $title, "is_default" => $isDefault, "sections" => $sections);	
	}
	
	public static function get_default_layout_id($page_id = "") {
	  $layouts = get_option("i3d_layouts", array());

	
	 $page_content_type 	= get_post_meta($page_id, "selected_page_type", true);	
	 $old_layout_template = "";
	 if ($page_content_type == "") {
		$pageMeta = get_post_meta($page_id);
		if (@$pageMeta['_wp_page_template'][0] != "") {
		  $old_layout_template = str_replace("template-", "", str_replace(".php", "", $pageMeta['_wp_page_template'][0]));
		}
	 }
	if ($old_layout_template == "home") {
		  foreach ($layouts as $id => $layout) {
			  if ($id == "primary") {
				  return $id;
			  }
		  }
		
	} else if ($old_layout_template == "photo-slideshow") {
		  foreach ($layouts as $id => $layout) {
			  if ($id == "photo-slideshow") {
				  return $id;
			  }
		  }
		
	} else if ($old_layout_template == "contact") {
		  foreach ($layouts as $id => $layout) {
			  if ($id == "contact") {
				  return $id;
			  }
		  }
		
	}


	  
		  foreach ($layouts as $id => $layout) {
			  if ($layout['is_default']) {
				  return $id;
			  }
		  }
		
	}

	public static function init_calls_to_action($keepExisting = false) {
	  self::debug("In init_calls_to_action()");

	  $ctas = get_option("i3d_calls_to_action");
	  
	  self::debug("Have ".sizeof($ctas)." ctas existing");
      if ($ctas && count($ctas) > 0 && !$keepExisting) {
		  //var_dump($contactForms);
	  	self::debug("Exiting Early -- No new ctas created");
	  } else {
		// contact form box
		$objects = array();
		//$id = wp_create_nonce("i3d_calls_to_action".(mktime()+1));
		$id = "i3d_cta_general";
		if (self::$callToActionVersion >= 2) {
			$objects[] = array('type' => "text",
							'width' => "span12",
							'size' => "h3",
							'align' => "text-center",
							'text' => 'Grab your visitors attention with a',
							'text_2' => 'Call to Action',
							'style_2' => 'cta-1',
							'animate_action' => "slideInDown");
						
			$objects[] = array('type' => "button",
							'width' => "span12",
							'link' => "",
							'align' => "text-center",
							'text' => "<i class='fa fa-phone icon-phone'></i> Click here to learn more!",
							'animate_action' => "fadeInUpBig");			
		} else {
			$objects[] = array('type' => "text",
							'width' => "span12",
							'size' => "h3",
							'align' => "text-center",
							'text' => 'Grab your visitors attention with a "Call to Action"',
							'animate_action' => "slideInLeft");
			
			$objects[] = array('type' => "text",
							'width' => "span12",
							'size' => "h4",
							'align' => "text-center",
							'text' => 'Even add a second line!',
							'animate_action' => "slideInRight");
			
			$objects[] = array('type' => "button",
							'width' => "span12",
							'link' => "",
							'align' => "text-center",
							'text' => "<i class='fa fa-phone icon-phone'></i> Click here to learn more!",
							'animate_action' => "fadeInUpBig");
		}
			$ctas["{$id}"] = array('id' => $id,
							 'title' => "General Call To Action",
							 'objects' => $objects
							 );
		
		if (self::$callToActionVersion >= 2) {
					//$id = wp_create_nonce("i3d_calls_to_action".(mktime()+1));
					$id = "i3d_cta_recipe";
			$objects = array();

			$objects[] = array('type' => "text",
							'width' => "span12",
							'size' => "h1",
							'align' => "text-center",
							'text' => 'Recipe for',
							'text_2' => 'Success',
							'style_2' => 'highlight',
							'animate_action' => "fadeIn");
			
			$objects[] = array('type' => "text",
							'width' => "span12",
							'size' => "p.lead",
							'align' => "text-center",
							'text' => 'Coming together is a beginning; keeping together is progress; working together is success.',
							'text_2' => '',
							'style_2' => '',
							'animate_action' => "fadeIn");
						
			$objects[] = array('type' => "text",
							'width' => "span12",
							'size' => "p",
							'align' => "text-center",
							'text' => 'Henry Ford',
							'animate_action' => "fadeInUp");			

			$ctas["{$id}"] = array('id' => $id,
								 'title' => "Recipe for success!",
								 'objects' => $objects
								 );
		}
		
		   

		
		
		
		  update_option("i3d_calls_to_action", $ctas);
		
		
		
	  }
	}

	public static function init_focal_boxes($keepExisting = false) {
	require_once(ABSPATH . 'wp-admin/includes/media.php');
	require_once(ABSPATH . 'wp-admin/includes/file.php');
	require_once(ABSPATH . 'wp-admin/includes/image.php');

	self::debug("In init_focal_boxes()");
	  $fbs = get_option("i3d_focal_boxes");
	  global $wpdb;
	  
	  self::debug("Have ".sizeof($fbs)." fbs existing");
      if ($fbs && count($fbs) > 0 && !$keepExisting) {
		  //var_dump($contactForms);
	  	self::debug("Exiting Early -- No new fbs created");
	  } else {
		// contact form box
		$objects = array();
		$id = "fb_default_1";
			$objects[] = array('type' => "text",
							'width' => "span12",
							'size' => "title1",
							'align' => "center",
							'text' => 'A [highlight]Complete[/highlight] WordPress Theme for Your Website');
						
			$objects[] = array('type' => "text",
							'width' => "span12",
							'size' => 'title2',
							'align' => "center",
							'text' => "--- including Parallax Sections ---");		
			
			$objects[] = array('type' => "text",
							'width' => "span12",
							'size' => 'description',
							'align' => "center",
							'text' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s,");			


			$objects[] = array('type' => "button",
							'width' => "span6",
							'link' => "",
							'align' => "right",
							'text' => "Learn More");

			$objects[] = array('type' => "button",
							'width' => "span6",
							'link' => "",
							'align' => "left",
							'text' => "See Features");


		$images = array();

		// contact form box
		for ($i = 1; $i <= 3; $i++) {
			$filename = get_template_directory_uri() ."/Library/components/parallax-section/images/parallax-section{$i}.png";
			//$post_id = self::getPageID("Photo Gallery");
			$post_id = 0;
			$description = "Parallax Image {$i}";
			
			# upload / resize / crop image (to WP images folder)
			$returnVar =  media_sideload_image($filename, $post_id, $description);
			if (is_wp_error($returnVar)) {
					self::debug("Error Uploading Image: ".$returnVar->get_error_message());

				//print "error: ".$returnVar->get_error_message();
			} else {
			
			$last_attachment = $wpdb->get_row($query = "SELECT * FROM {$wpdb->prefix}posts ORDER BY ID DESC LIMIT 1", ARRAY_A);
			$attachment_id = $last_attachment['ID'];
			$images[] = $attachment_id;
			//$imageIds .= "{$attachment_id},";
			}
			# set featured image
			//add_post_meta($post_id, '_thumbnail_id', $attachment_id);			
		}


			$fbs["{$id}"] = array('id' => $id,
							 'title' => "Feature Focal Box",
							 'layout' => 'image-left',
							 'objects' => $objects,
							 'images' => $images
							 );
		//var_dump($fbs);

		
		
		
		  update_option("i3d_focal_boxes", $fbs);
		
		
		
	  }
	}

	public static function init_active_backgrounds($keepExisting = false) {
	  self::debug("In init_active_backgrounds()");
	  $abs = get_option("i3d_active_backgrounds");
	  global $wpdb;
	  
	  self::debug("Have ".sizeof($abs)." abs existing");
      if ($abs && count($abs) > 0 && !$keepExisting) {
		  //var_dump($contactForms);
	  	self::debug("Exiting Early -- No new abs created");
	  } else {
		// contact form box
		$objects = array();
		//$id = wp_create_nonce("i3d_active_backgrounds".(mktime()+1));
	    if (sizeof(I3D_Framework::$defaultActiveBackgrounds) > 0) {
			$abs = I3D_Framework::$defaultActiveBackgrounds;
		} else {
			$id = "section_ab_1";
			

			$abs["{$id}"] = array('id' => $id,
							 'title' => "Example Map Background",
							 'background_visibility' => 'only-when-content-exists',
							 'background_type' => 'map',
							 'bordered' => '1',
							 
							 'resources' => array('map' => array('address' => "New York City, NY",
																 'lat' => '40.7127837',
																 'lng' => '-74.0059413',
																 'zoom' => '12',
																 'poi' => array("visibility" => "off"),
																 'water' => array("visibility" => "colored", "color" => "#00b6f1"),
																 'landscape' => array("visibility" => "colored", "color" => "#e6f8ff"),
																 'road-highway' => array("visibility" => "simplified", "lightness" => "50", "saturation" => "-100"),
																 'road-arterial' => array("visibility" => "off", "color" => "#03d0fc"),
																 'road-local' => array("visibility" => "off")))
							 );
		//var_dump($fbs);

		}
		
		
		  update_option("i3d_active_backgrounds", $abs);
		
		
		
	  }
	}

public static function getThemeStyle() {
	global $settingOptions;
	global $page_id;
	//print ini_get("date.timezone");
//	date_default_timezone_set("America/Vancouver");
    $currentTime = current_time('timestamp');
	//$timezone = date_default_timezone_get();
	//	print $timezone."<br>";


			$pageLevelThemeStyles = get_post_meta($page_id, "i3d_theme_styles", true);
			if (is_array($pageLevelThemeStyles) && $pageLevelThemeStyles[0]['style'] != "") {
				$style = $pageLevelThemeStyles[0]['style'];
				//$color = $pageLevelThemeStyles[0]["{$style}_color"];
				return $style;
				//var_dump($pageLevelThemeStyles);
				//print "got one".$pageLevelThemeStyles[0]['style']['color'];
			}
	if (!isset($settingOptions['theme_styles'])) {
		$settingOptions['theme_styles'] = array();
	}
	//var_dump($settingOptions['theme_styles']);
	$selectedThemeStyle = array();
	foreach ($settingOptions['theme_styles'] as $index => $themeStyle) {
	  	if ($index == 0) {
			$selectedThemeStyle = $themeStyle;
		} else if (@$themeStyle['frequency'] == "daily") {
			$startTime = date("Y-m-d {$themeStyle['start_time']}");
			$endTime = date("Y-m-d {$themeStyle['end_time']}");
			//print strtotime($startTime)." ? ".time()."<br>";
			if (strtotime($startTime) < $currentTime && strtotime($endTime) > $currentTime) {
				$selectedThemeStyle = $themeStyle;
				
			}
		} else if (@$themeStyle['frequency'] == "daterange") {
			//var_dump($themeStyle);
			$startTime = strtotime("{$themeStyle['start_date']} {$themeStyle['start_time']}");
			$endTime = strtotime("{$themeStyle['end_date']} {$themeStyle['end_time']}");
			//print "maybe {$themeStyle['start_date']} {$themeStyle['start_time']}";
			//print strtotime($startTime)." < ".$currentTime."<br>";
			//print strtotime($startTime)." > ".$currentTime."<br>";
			
			if ($startTime < $currentTime && $endTime > $currentTime) {
				$selectedThemeStyle = $themeStyle;
			//	print "yeah";
			}
			
		}
	}
	$selectedStyle = @$selectedThemeStyle['style'];
	if ($selectedStyle == "") {
	  $selectedStyle = self::$themeDefaultStyle;	
	}
	return $selectedStyle;
	/*
	$themeStyle = $settingOptions['theme_styles'][0]['style'];
	if ($themeStyle == "") {
		$themeStyle = "default";
	}
	return $themeStyle;
	*/

	
}



public static function renderImageChooser($id, $value, $fileTypes = array("jpg"), $class = "", $minDimensions = array(0, 0), $maxDimensions = array(2000,2000)) {
	global $wpdb;
	$queryTypes = "";
	$haveSelected = false;
	
	if (!is_array($fileTypes)) {
		$fileTypes = explode(",", $fileTypes);  
	}
	
	foreach ($fileTypes as $type) {
		if ($queryTypes != "") {
			$queryTypes .= " OR ";
		}
		$queryTypes .= "post_mime_type='image/{$type}'";
	}
  
  
  	$results = $wpdb->get_results("SELECT * FROM {$wpdb->posts} WHERE post_type='attachment' AND ({$queryTypes}) ORDER BY post_title");
	$imagesDisplayed = 0;
	//print sizeof($results);
				

	foreach($results as $image) {
		if ($image->guid != "" && strpos($image->guid, "/uploads/")) {
			
			
			$imageURL = site_url()."/wp-content/".substr($image->guid,(strpos($image->guid,"/uploads/") +1));
			$imageDimensions = @getimagesize("../wp-content/".substr($image->guid,(strpos($image->guid,"/uploads/") +1)));
			
			if (is_array($minDimensions)) {
				if ($minDimensions[0] > $imageDimensions[0] || $minDimensions[1] > $imageDimensions[1]) {
					continue;
				}
				if ($maxDimensions[0] < $imageDimensions[0] || $maxDimensions[1] < $imageDimensions[1]) {
					continue;
				}				
			}
			
			if ($imagesDisplayed == 0) {
				print '<div class="btn-group" data-toggle="buttons">';
			}
			echo '<label class="btn btn-default ';
			if ($value == $image->ID) { echo " active"; $haveSelected = true; } 
			
			echo	'">
    <input value="'.$image->ID.'" type="radio" name="setting__'.$id.'" id="'.$id.'-'.$imagesDisplayed.'"';
			if ($value == $image->ID) { echo " checked";  } 
	
	        echo '>';
			echo "<img src='".$imageURL."' class='{$class}' title='{$image->post_title}: {$imageDimensions[0]}x{$imageDimensions[1]}' /> ";
			echo '</label>';
			$imagesDisplayed++;
			/*
			if ($generalSettings['custom_logo_filename'] == $image->ID) {
					echo '<option value="'.$image->ID.'" selected="selected">'.$image->post_title.'</option>';
				} else {
					echo '<option value="'.$image->ID.'">'.$image->post_title.'</option>';
				}
				
				$imageOptions .= 'userImages['.$image->ID.'] = "'.site_url()."/wp-content/".substr($image->guid,(strpos($image->guid,"/uploads/") +1)).'";'."\n";
		
*/
}
			}
			
				if ($imagesDisplayed == 0) {
					//echo "<a href='javascript:;' onclick='goFavIcoMediaWindow()' class='btn btn-default'><i class='fa fa-upload'></i></a>";
					
		?>
        <div class='alert alert-info no-image-placeholder '>
        <?php
		print "No appropriately sized '<b>".implode(", ", $fileTypes)."</b>' file types found.  Please upload appropriate files to via the Media Library";
		?>
        </div>
        <?php
		return false;
	} else {
		
		echo '<label class="btn btn-default '.(!$haveSelected ? "active" : "").'">
          <input value="" type="radio" name="setting__'.$id.'" id="'.$id.'-default" '.(!$haveSelected ? "active" : "").'>';
	    _e("Disabled", "i3d-framework");
		echo "</div>";
		return true;
	}
	

			
/*
if(wp_attachment_is_image($generalSettings['custom_logo_filename'])) {
				$metaData = get_post_meta($generalSettings['custom_logo_filename'], '_wp_attachment_metadata', true);
				$fileName = site_url().'/wp-content/uploads/'.$metaData['file'];			
			    
				echo '<img style="height: 80px" src="'.$fileName.'" class="selected_image" id="selected_image" alt="selected image preview" />';				
			} else {
			?>
				<img style="height: 80px" src="<?php echo get_template_directory_uri() ; ?>/images/no_image_selected.png" class="selected_image" id="selected_image" alt="selected image preview" />
			<?php			
			}
			*/
 // print "file types ".implode(",", $fileTypes);
}

public static function getThemeStyleColor() {
	global $settingOptions;
	global $page_id;
	
			$pageLevelThemeStyles = get_post_meta($page_id, "i3d_theme_styles", true);
			if (is_array($pageLevelThemeStyles) && $pageLevelThemeStyles[0]['style'] != "") {
				$style = $pageLevelThemeStyles[0]['style'];
				$color = $pageLevelThemeStyles[0]["{$style}_color"];
				
				return $color;
				//var_dump($pageLevelThemeStyles);
				//print "got one".$pageLevelThemeStyles[0]['style']['color'];
			}
	if (!isset($settingOptions['theme_styles'])) {
		$settingOptions['theme_styles'] = array();
	}
	
	
		$currentTime = current_time('timestamp');

	$selectedThemeStyle = array();
	foreach ($settingOptions['theme_styles'] as $index => $themeStyle) {
	  	if ($index == 0) {
			$selectedThemeStyle = $themeStyle;
		} else if (@$themeStyle['frequency'] == "daily") {
			$startTime = date("Y-m-d {$themeStyle['start_time']}");
			$endTime = date("Y-m-d {$themeStyle['end_time']}");
			//print strtotime($startTime)." ? ".time()."<br>";
			if (strtotime($startTime) < $currentTime && strtotime($endTime) > $currentTime) {
				$selectedThemeStyle = $themeStyle;
				
			}
		} else if (@$themeStyle['frequency'] == "daterange") {
			$startTime = strtotime("{$themeStyle['start_date']} {$themeStyle['start_time']}");
			$endTime = strtotime("{$themeStyle['end_date']} {$themeStyle['end_time']}");
			if ($startTime < $currentTime && $endTime > $currentTime) {
				$selectedThemeStyle = $themeStyle;
			}
			
		}
	}
	$selectedStyle = @$selectedThemeStyle['style'];
	if ($selectedStyle == "") {
	  $selectedStyle = self::$themeDefaultStyle;	
	}

	$selectedStyleColor = @$selectedThemeStyle["{$selectedStyle}_color"];
	if ($selectedStyleColor == "" ) {
		$availableColors = self::$themeStyleOptions["$selectedStyle"]["colors"];
		if (sizeof($availableColors) > 0) {
			$selectedStyleColor = array_shift($availableColors);
			$selectedStyleColor = strtolower($selectedStyleColor);
		}
	}
	
	//print "(".$selectedStyleColor.")";
	return $selectedStyleColor;
	/*
	if (!isset($settingOptions['theme_styles'][0]["{$themeStyle}_color"])) {
		$settingOptions['theme_styles'][0]["{$themeStyle}_color"] = "";
	}	
	$themeStyleColor = $settingOptions['theme_styles'][0]["{$themeStyle}_color"];
	//print $themeStyle;
	if ($themeStyleColor == "") {
		$availableStyles = I3D_Framework::$themeStyleOptions;
		$colorKeys = array_keys($availableStyles["$themeStyle"]['colors']);
		$themeStyleColor = $colorKeys[0];
	}
	return $themeStyleColor;
	*/
	
}


public static function getThemeStyleLayers() {
	global $settingOptions;


	global $page_id;
	
			$pageLevelThemeStyles = get_post_meta($page_id, "i3d_theme_styles", true);
			if (is_array($pageLevelThemeStyles) && $pageLevelThemeStyles[0]['style'] != "") {
				$style = $pageLevelThemeStyles[0]['style'];
				$color = $pageLevelThemeStyles[0]["{$style}_color"];
				//var_dump();
				$layers =  $pageLevelThemeStyles[0]["{$style}"]["layers"]["$color"];
				return $layers;
				//var_dump($pageLevelThemeStyles);
				//print "got one".$pageLevelThemeStyles[0]['style']['color'];
			}


	if (!isset($settingOptions['theme_styles'])) {
		$settingOptions['theme_styles'] = array();
	}
	
	$currentTime = current_time('timestamp');

	$selectedThemeStyle = array();
	foreach ($settingOptions['theme_styles'] as $index => $themeStyle) {
	  	if ($index == 0) {
			$selectedThemeStyle = $themeStyle;
		} else if (@$themeStyle['frequency'] == "daily") {
			$startTime = date("Y-m-d {$themeStyle['start_time']}");
			$endTime = date("Y-m-d {$themeStyle['end_time']}");

			if (strtotime($startTime) < $currentTime && strtotime($endTime) > $currentTime) {
				$selectedThemeStyle = $themeStyle;
				
			}
		} else if (@$themeStyle['frequency'] == "daterange") {
			$startTime = strtotime("{$themeStyle['start_date']} {$themeStyle['start_time']}");
			$endTime = strtotime("{$themeStyle['end_date']} {$themeStyle['end_time']}");
			if ($startTime < $currentTime && $endTime > $currentTime) {
				$selectedThemeStyle = $themeStyle;
			}
			
		}
	}

	$selectedStyle = @$selectedThemeStyle['style'];
	if ($selectedStyle == "") {
	  $selectedStyle = I3D_Framework::$themeDefaultStyle;	
	}

	$selectedStyleColor = @$selectedThemeStyle["{$selectedStyle}_color"];
	if ($selectedStyleColor == "") {
		$availableColors = self::$themeStyleOptions["$selectedStyle"]["colors"];
		
		$selectedStyleColor = array_shift($availableColors);
	}
	$default = self::$themeDefaultColor;
	if (is_array(@$selectedThemeStyle["$selectedStyle"]["layers"]["$selectedStyleColor"])) {
		$layers =  $selectedThemeStyle["$selectedStyle"]["layers"]["$selectedStyleColor"];
	} else {
		$layers =  $selectedThemeStyle["$selectedStyle"]["layers"]["$default"];	
	}
	
	// then init the layers as per the default settings
	if (!$layers) {
		$defaultLayers = self::$themeStyleOptions["$selectedStyle"]["layers"]["$default"];
		foreach ($defaultLayers as $index => $layerData) {
		  $layers["{$index}"] = $layerData['default_state'];	
		}
	}
	
	return $layers;
}
public static function isThemeLayerDisabled($layerID) {
	$themeStyleLayers = I3D_Framework::getThemeStyleLayers();
	
	if (@$themeStyleLayers["$layerID"] == "0") {
		return true;
	} else {
		return false;
	}	
}

public static function isThemeLayerAnimated($layerID) {
	$themeStyleLayers = I3D_Framework::getThemeStyleLayers();
		
	if (@$themeStyleLayers["$layerID"] == "2") {
		return true;
	} else {
		return false;
	}	
}
public static function init_content_panel_groups($keepExisting = false) {
	  self::debug("In init_content_panel_groups()");

	  $cpgs = get_option("i3d_content_panel_groups");
	  
	  self::debug("Have ".sizeof($cpgs)." cpgs existing");
      if ($cpgs && count($cpgs) > 0 && !$keepExisting) {
		  //var_dump($contactForms);
	  	self::debug("Exiting Early -- No new cpgs created");
	  } else {
		// contact form box
		$panels = array();
		$id = wp_create_nonce("i3d_content_panel_groups".(mktime()+1));
		$panels[] = array('icon' => "",
						'label' => "Example Label 1",
						'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in auctor elit. In est felis, cursus nec urna quis, rhoncus gravida odio. Duis nibh lorem, lobortis vitae eros ac, fermentum fringilla augue. Duis vitae auctor neque, ac rhoncus odio. Aenean quis dignissim mauris. Praesent auctor porta orci, ac accumsan eros sagittis ac. Sed in ornare quam, a vulputate dolor. Donec egestas luctus ipsum eu pharetra. Maecenas lobortis sapien lorem, ut aliquam eros bibendum et. Donec tortor dolor, pulvinar ut eros id, malesuada ornare augue. Maecenas hendrerit et dolor ac dictum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vestibulum elementum ornare neque, et congue enim consequat sed. 
						Praesent a eros eu diam vulputate bibendum. Nullam ante velit, ultricies nec erat at, pretium suscipit felis. ");
		
		$panels[] = array('icon' => "",
						'label' => "Example Label 2",
						'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in auctor elit. In est felis, cursus nec urna quis, rhoncus gravida odio. Duis nibh lorem, lobortis vitae eros ac, fermentum fringilla augue. Duis vitae auctor neque, ac rhoncus odio. Aenean quis dignissim mauris. Praesent auctor porta orci, ac accumsan eros sagittis ac. Sed in ornare quam, a vulputate dolor. Donec egestas luctus ipsum eu pharetra. Maecenas lobortis sapien lorem, ut aliquam eros bibendum et. Donec tortor dolor, pulvinar ut eros id, malesuada ornare augue. Maecenas hendrerit et dolor ac dictum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vestibulum elementum ornare neque, et congue enim consequat sed. 
						Praesent a eros eu diam vulputate bibendum. Nullam ante velit, ultricies nec erat at, pretium suscipit felis. ");

		$panels[] = array('icon' => "",
						'label' => "Example Label 3",
						'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in auctor elit. In est felis, cursus nec urna quis, rhoncus gravida odio. Duis nibh lorem, lobortis vitae eros ac, fermentum fringilla augue. Duis vitae auctor neque, ac rhoncus odio. Aenean quis dignissim mauris. Praesent auctor porta orci, ac accumsan eros sagittis ac. Sed in ornare quam, a vulputate dolor. Donec egestas luctus ipsum eu pharetra. Maecenas lobortis sapien lorem, ut aliquam eros bibendum et. Donec tortor dolor, pulvinar ut eros id, malesuada ornare augue. Maecenas hendrerit et dolor ac dictum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vestibulum elementum ornare neque, et congue enim consequat sed. 
						Praesent a eros eu diam vulputate bibendum. Nullam ante velit, ultricies nec erat at, pretium suscipit felis. ");

		$panels[] = array('icon' => "",
						'label' => "Example Label 4",
						'content' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in auctor elit. In est felis, cursus nec urna quis, rhoncus gravida odio. Duis nibh lorem, lobortis vitae eros ac, fermentum fringilla augue. Duis vitae auctor neque, ac rhoncus odio. Aenean quis dignissim mauris. Praesent auctor porta orci, ac accumsan eros sagittis ac. Sed in ornare quam, a vulputate dolor. Donec egestas luctus ipsum eu pharetra. Maecenas lobortis sapien lorem, ut aliquam eros bibendum et. Donec tortor dolor, pulvinar ut eros id, malesuada ornare augue. Maecenas hendrerit et dolor ac dictum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Vestibulum elementum ornare neque, et congue enim consequat sed. 
						Praesent a eros eu diam vulputate bibendum. Nullam ante velit, ultricies nec erat at, pretium suscipit felis. ");

		$cpgs["{$id}"] = array('id' => $id,
							   'title' => "Example Accordion Content Panel Group",
							   'title_wrap' => "h2",
							   'description' => 'Also available as a tab or pill button content group.', 
							   'content_type' => "accordion",
							   'panels' => $panels
							 );
		   

		
		
		
		  update_option("i3d_content_panel_groups", $cpgs);
		
		
		
	  }
	}
	
    public static function hasExtension($extension) {
	  
	  $extensions = get_option("i3d_theme_extensions");

		if (!is_array($extensions)) {
		  $extensions = array();
	  }
	  if (in_array($extension, $extensions)) {
		  return true;
	  }
	  
	}
	
	public static function fetchExtensions() {
		global $lmUpdaterAvailable;
		if (!$lmUpdaterAvailable) { return; }
    	$url               = self::$updateURL;
		self::debug("In fetchExtensions()");
        global $wp_version, $wpdb, $i3dParameterSettings;
		$theme = wp_get_theme();
	  	$previousExtensions = get_option("i3d_theme_extensions");
		
        $params = array(
            'updater_version'   => '0.1',
			'theme_name'        => $theme->Name,
            'framework_version' => I3D_Framework::$version,
            'theme_version'     => $theme->Version,
            'theme_license'     => get_option("i3d_license_key__".get_stylesheet()),
            'wp_version'        => $wp_version,
            'php_version'       => phpversion(),
            'mysql_version'     => $wpdb->db_version(),
            'uri'               => network_home_url(),
            'locale'            => get_locale()       
			);

//var_dump($params);
        $options           = array(
            'body'  => $params
        );

        $request    = wp_remote_post($url, $options);
        $response   = wp_remote_retrieve_body($request);	
        $update     = new stdClass();
        $update->timeLastChecked = time();
        $update->response = maybe_unserialize($response);
		$extensions = $update->response['extensions'];
		//var_dump($update->response);
		if (!is_array($extensions)) {
			$extensions = array();
		}
		
		if ($update->response['license_type'] != "") {
			update_option("i3d_license_type", $update->response['license_type']);
			//print $update->license_type;
		}
		update_option("i3d_theme_extensions", $extensions);		 
		self::debug("About to init in Fetch Extensions");

		if (function_exists("is_woocommerce") && in_array("woocommerce", $extensions) && !in_array("woocommerce", $previousExtensions)) {
		  self::init_woocommerce();
		}
		if (function_exists("wpsc_core_constants") && in_array("wpecommerce", $extensions)
															   /* && !in_array("wpecommerce", $previousExtensions) */) {
		  self::init_wpecommerce();
		}

		self::debug("Done fetchExtensions");
		
	}
	public static function init_woocommerce() {
		$widgets = array();
				self::debug("In init_woocommerce()");

	  	$lmSidebars = get_option("i3d_sidebar_options");
		
		
		$widgets["i3d-woocommerce-shop"] = array(
				 array('class_name' => 'I3D_Widget_ContentRegion', 'default_settings' => array('box_style' => "")),	 		
				 array('class_name' => 'I3D_Widget_ColumnBreak', 'default_settings' => array()),
				 array('class_name' => 'WC_Widget_Cart'),
				 array('class_name' => 'WC_Widget_Product_Categories'));
																			 
		
		if (!array_key_exists("i3d-woocommerce-shop", $lmSidebars)) {
		    $lmSidebars['i3d-woocommerce-shop'] = "WooCommerce Shop Content";
		    update_option("i3d_sidebar_options", $lmSidebars);
			
			$sidebarWidgets = wp_get_sidebars_widgets(false);
			//print "initializing i3d-woocommerce-shop sidebar<br>";
			$sidebarWidgets = self::init_sidebar_widgets($widgets["i3d-woocommerce-shop"], "i3d-woocommerce-shop", $sidebarWidgets);
			wp_set_sidebars_widgets($sidebarWidgets);

		}

		
		$widgets["i3d-woocommerce-myaccount"] = array(
				 array('class_name' => 'I3D_Widget_ContentRegion', 'default_settings' => array('box_style' => "")),	 		
				 array('class_name' => 'I3D_Widget_ColumnBreak', 'default_settings' => array()),
				 array('class_name' => 'WP_Widget_Shopping_Cart'));
																			 
	   
	   if (!array_key_exists("i3d-woocommerce-myaccount", $lmSidebars)) {
		   $lmSidebars['i3d-woocommerce-myaccount'] = "WooCommerce My Account Content";
		    update_option("i3d_sidebar_options", $lmSidebars);

			$sidebarWidgets = wp_get_sidebars_widgets(false);
		   
			//print "initializing i3d-woocommerce-myaccount sidebar<br>";
			$sidebarWidgets = self::init_sidebar_widgets($widgets["i3d-woocommerce-myaccount"], "i3d-woocommerce-myaccount", $sidebarWidgets);
			wp_set_sidebars_widgets($sidebarWidgets);

		}

		
		$widgets["i3d-woocommerce-cart"] = array(
				 array('class_name' => 'I3D_Widget_ContentRegion', 'default_settings' => array('box_style' => "")));
																			 
		
		if (!array_key_exists("i3d-woocommerce-cart", $lmSidebars)) {	
		    $lmSidebars['i3d-woocommerce-cart'] = "WooCommerce Cart Content";
		    update_option("i3d_sidebar_options", $lmSidebars);
		   
		   $sidebarWidgets = wp_get_sidebars_widgets(false);
		//	print "initializing i3d-woocommerce-cart sidebar<br>";
			$sidebarWidgets = self::init_sidebar_widgets($widgets["i3d-woocommerce-cart"], "i3d-woocommerce-cart", $sidebarWidgets);
			wp_set_sidebars_widgets($sidebarWidgets);
		}

			
			$widgets["i3d-woocommerce-checkout"] = array(
					 array('class_name' => 'I3D_Widget_ContentRegion', 'default_settings' => array('box_style' => "")));
		
		if (!array_key_exists("i3d-woocommerce-checkout", $lmSidebars)) {
			$lmSidebars['i3d-woocommerce-checkout'] = "WooCommerce Checkout Content";
		    update_option("i3d_sidebar_options", $lmSidebars);
																				 
			$sidebarWidgets = wp_get_sidebars_widgets(false);
		//	print "initializing i3d-woocommerce-checkout sidebar<br>";
			$sidebarWidgets = self::init_sidebar_widgets($widgets["i3d-woocommerce-checkout"], "i3d-woocommerce-checkout", $sidebarWidgets);
			wp_set_sidebars_widgets($sidebarWidgets);
		}
		


		if (function_exists("is_woocommerce")) {
			$defaultPages = array();
			$defaultPages["Shop"] 		= woocommerce_settings_get_option("woocommerce_shop_page_id");
			$defaultPages["Checkout"] 	= woocommerce_settings_get_option("woocommerce_checkout_page_id");
			$defaultPages["Cart"] 		= woocommerce_settings_get_option("woocommerce_cart_page_id");
			$defaultPages["My Account"] = woocommerce_settings_get_option("woocommerce_myaccount_page_id");
			foreach ($defaultPages as $pageName => $pageID) {
				if (!self::page_has_content_region($pageID)) {
				  $sidebarID = "i3d-woocommerce-".strtolower(str_replace(" ", "", $pageName));
				  self::init_page_sidebars($pageID, $sidebarID, sizeof($widgets["{$sidebarID}"]));
				}
			}
		}
		self::debug("Done init_woocommerce()");

	}


	public static function init_wpecommerce() {
		self::debug("In init_wpecommerce()");

		$widgets = array();
	  	$lmSidebars = get_option("i3d_sidebar_options");
		
		
		$widgets["i3d-wpecommerce-productspage"] = array(
				 array('class_name' => 'I3D_Widget_ContentRegion', 'default_settings' => array('box_style' => "")),	 		
				 array('class_name' => 'I3D_Widget_ColumnBreak', 'default_settings' => array()),
				 array('class_name' => 'WP_Widget_Shopping_Cart'),
				 array('class_name' => 'WP_Widget_Product_Categories'));
																			 
		
		if (!array_key_exists("i3d-wpecommerce-productspage", $lmSidebars)) {
		    $lmSidebars['i3d-wpecommerce-products'] = "WPEC Store Content";
		    update_option("i3d_sidebar_options", $lmSidebars);
			
			$sidebarWidgets = wp_get_sidebars_widgets(false);
			$sidebarWidgets = self::init_sidebar_widgets($widgets["i3d-wpecommerce-productspage"], "i3d-wpecommerce-productspage", $sidebarWidgets);
			wp_set_sidebars_widgets($sidebarWidgets);

		}
		//var_dump($sidebarWidgets);
		//return;

		
		$widgets["i3d-wpecommerce-youraccount"] = array(
				 array('class_name' => 'I3D_Widget_ContentRegion', 'default_settings' => array('box_style' => "")),	 		
				 array('class_name' => 'I3D_Widget_ColumnBreak', 'default_settings' => array()),
				 array('class_name' => 'WP_Widget_Shopping_Cart'));
																			 
	   
	   if (!array_key_exists("i3d-wpecommerce-youraccount", $lmSidebars)) {
		   $lmSidebars['i3d-wpecommerce-youraccount'] = "WPEC Account Page Content";
		    update_option("i3d_sidebar_options", $lmSidebars);

			$sidebarWidgets = wp_get_sidebars_widgets(false);		   
			$sidebarWidgets = self::init_sidebar_widgets($widgets["i3d-wpecommerce-youraccount"], "i3d-wpecommerce-youraccount", $sidebarWidgets);
			wp_set_sidebars_widgets($sidebarWidgets);

		}

		
		$widgets["i3d-wpecommerce-transactionresults"] = array(
				 array('class_name' => 'I3D_Widget_ContentRegion', 'default_settings' => array('box_style' => "")));
																			 
		
		if (!array_key_exists("i3d-wpecommerce-transactionresults", $lmSidebars)) {	
		    $lmSidebars['i3d-wpecommerce-transactionresults'] = "WPEC Transactions Page Content";
		    update_option("i3d_sidebar_options", $lmSidebars);
		   
		    $sidebarWidgets = wp_get_sidebars_widgets(false);
			$sidebarWidgets = self::init_sidebar_widgets($widgets["i3d-wpecommerce-transactionresults"], "i3d-wpecommerce-transactionresults", $sidebarWidgets);
			wp_set_sidebars_widgets($sidebarWidgets);
		}

			
			$widgets["i3d-wpecommerce-checkout"] = array(
					 array('class_name' => 'I3D_Widget_ContentRegion', 'default_settings' => array('box_style' => "")));
		
		if (!array_key_exists("i3d-wpecommerce-checkout", $lmSidebars)) {
			$lmSidebars['i3d-wpecommerce-checkout'] = "WPEC Checkout Page Content";
		    update_option("i3d_sidebar_options", $lmSidebars);
																				 
			$sidebarWidgets = wp_get_sidebars_widgets(false);
			$sidebarWidgets = self::init_sidebar_widgets($widgets["i3d-wpecommerce-checkout"], "i3d-wpecommerce-checkout", $sidebarWidgets);
			wp_set_sidebars_widgets($sidebarWidgets);
		}
		


		if (function_exists("wpsc_core_constants")) {
			$defaultPages = array();
			$defaultPages["Products Page"] 		= I3D_Framework::getPageID("Products Page");
			$defaultPages["Checkout"] 		= I3D_Framework::getPageID("Checkout");
			$defaultPages["Transaction Results"] 	= I3D_Framework::getPageID("Transaction Results");
			$defaultPages["Your Account"] 	= I3D_Framework::getPageID("Your Account");
			foreach ($defaultPages as $pageName => $pageID) {
				if (!self::page_has_content_region($pageID)) {
				  $sidebarID = "i3d-wpecommerce-".strtolower(str_replace(" ", "", $pageName));
				  //print $pageName."<br>";
				  self::init_page_sidebars($pageID, $sidebarID, sizeof($widgets["{$sidebarID}"]));
				}
			}
		}
				self::debug("Done init_wpecommerce()");

	}

	public static function init_page_sidebars($page_id, $sidebar_id, $num_widgets) {
		//print $page_id."<br>";
		
	 	$template =   str_replace("template-", "", str_replace(".php", "", get_post_meta($page_id, "_wp_page_template", true)));		
		$templateRegions = I3D_Framework::$templateRegions["{$template}"];
		$pageRegions = get_post_meta($page_id, "layout_regions", true);

		foreach ($templateRegions as $regionID => $regionInfo) { 
		  if ($regionInfo['type'] == "user-defined") {
			  $pageRegions["{$template}"]["{$regionID}"]["sidebar"] = $regionInfo['configuration']['default-sidebar'];
			  if ($regionID == "main") {
			    $pageRegions["{$template}"]["{$regionID}"]["sidebar"] = $sidebar_id;  
			    $pageRegions["{$template}"]["{$regionID}"]["bg"]      = "padding-top-40 padding-bottom-40";  
			    $pageRegions["{$template}"]["{$regionID}"]["columns"] = ($num_widgets == 1 ? 1 : 2);  
			  }
		  }
		}
		update_post_meta($page_id, "layout_regions", $pageRegions);

	}
	
	public static function page_has_content_region($page_id) {
		global $wp_registered_widgets;
	 	$template =   str_replace("template-", "", str_replace(".php", "", get_post_meta($page_id, "_wp_page_template", true)));

		if ($template == "") {
			update_post_meta($page_id, "_wp_page_template", "default");
			$template = "default";
		}
		$templateRegions = I3D_Framework::$templateRegions["{$template}"];
		
		$pageRegions = get_post_meta($page_id, "layout_regions", true);
		$sidebarWidgets = wp_get_sidebars_widgets();

		if (!is_array($pageRegions)) {
			$pageRegions = array();
		}		

		foreach ($templateRegions as $regionID => $regionInfo) { 
			

			 $mySidebar = $pageRegions["{$template}"]["{$regionID}"]["sidebar"];
			 if (is_array($sidebarWidgets["{$mySidebar}"])) {
				  foreach ($sidebarWidgets["{$mySidebar}"] as $wid) { 
					   if ($wp_registered_widgets["$wid"]['callback'][0]->id_base == "i3d_contentregion") {
					     return true;
					   }
				  }
			} 
			 
		}
	   return false;
	}
	
	public static function condition($region) {
	  global $widgetRegionCount;
	  $licenseKey = get_option("i3d_license_key__".get_stylesheet());
	  //print "test";
	  if ($licenseKey != "" || true) {
		  return;
	  } 	 
	  if (I3D_Framework::$conditionPeriod == "") {
		  I3D_Framework::$conditionPeriod = 3;
	  }
	  if (I3D_Framework::$conditionOffset == "") {
		  I3D_Framework::$conditionOffset = 0;
	  }
	  
	  if ($widgetRegionCount % I3D_Framework::$conditionPeriod == I3D_Framework::$conditionOffset) {

	    /*
		// this is disabled for the time being as we are not yet offering adsupported themes
	  if ($region == "wide") {
		
		  echo "<div class='text-center'>";
		  echo '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- WordPress Themes - Wide Region -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-2351888889825153"
     data-ad-slot="7338948419"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>';
	  echo "</div>";
	  } else if ($region == "tall") {
		  echo '<script type="text/javascript"><!--
google_ad_client = "ca-pub-2351888889825153";
// WordPress Themes -- Tall 
google_ad_slot = "8815681612";
google_ad_width = 160;
google_ad_height = 600;

//-->

</script>
<script type="text/javascript"
src="//pagead2.googlesyndication.com/pagead/show_ads.js">
</script>';
	  }
	    */
	  }
	  $widgetRegionCount++;
	  
	}

public static function getCallToActionID($ctaTitle) {
	  $ctas = get_option("i3d_calls_to_action");
	  if (!is_array($ctas)) {
		  $ctas = array();
	  }	  
	  
	  self::debug("In getCallToActionID() and looking for {$ctaTitle}");

	  foreach ($ctas as $ctaID => $ctaData) {
		  self::debug("comparing against {$ctaData['title']}");

		  if ($ctaData['title'] == $ctaTitle) {
			  	  self::debug("got it! {$ctaData['id']}");

			  return $ctaData['id'];
		  }
	  }
	  		  self::debug("did not find it");

	  return false;
	}


public static function getFocalBoxID($fbTitle) {
	  $fbs = get_option("i3d_focal_boxes");
	  if (!is_array($fbs)) {
		  $fbs = array();
	  }	  
	  
	  self::debug("In getFocalBoxID() and looking for {$fbTitle}");

	  foreach ($fbs as $fbID => $data) {
		  self::debug("comparing against {$data['title']}");

		  if ($data['title'] == $fbTitle) {
			  	  self::debug("got it! {$data['id']}");

			  return $data['id'];
		  }
	  }
	 self::debug("did not find it");
	  return false;
	}


public static function getContentPanelGroupID($cpgTitle) {
	  $cpgs = get_option("i3d_content_panel_groups");
	  if (!is_array($cpgs)) {
		  $cpgs = array();
	  }	  
	  
	  self::debug("In getContentPanelID() and looking for {$cpgTitle}");

	  foreach ($cpgs as $cpgID => $cpgData) {
		  self::debug("comparing against {$cpgData['title']}");

		  if ($cpgData['title'] == $cpgTitle) {
			  	  self::debug("got it! {$cpgData['id']}");

			  return $cpgData['id'];
		  }
	  }
	  		  self::debug("did not find it");

	  return false;
	}
	
	public static function getContactFormID($contactFormName) {
	  $forms = get_option("i3d_contact_forms");
	  if (!is_array($forms)) {
		  $forms = array();
	  }	  
	  
	  self::debug("In getContactFormID() and looking for {$contactFormName}");

	  foreach ($forms as $formID => $formData) {
		  self::debug("comparing against {$formData['form_title']}");

		  if ($formData['form_title'] == $contactFormName) {
			  	  self::debug("got it! {$formData['id']}");

			  return $formData['id'];
		  }
	  }
	  		  self::debug("did not find it");

	  return false;
	}

	public static function init_sliders($keepExisting = false) {
	  
	  self::debug("In init_sliders()");
	  if (sizeof(self::$sliders) == 0) { 
	    return;
	  }
	  $sliders = get_option("i3d_sliders");
	  
	  self::debug("Have ".sizeof($sliders)." sliders existing");
      if ($sliders && count($sliders) > 0 && !$keepExisting) {
		//  var_dump($sliders);
	  	self::debug("Exiting Early -- No new sliders created");
	  } else {
		
		
		
		$slides = array();
		$slides[] = array('id' => 'default', 
						  'link_type' => 'page', 
								 'image' => '/Site/themed-images/portfolio-very-large-1.jpg',
								 'title' => 'Example Title', 
								 'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ornare adipiscing scelerisque. Nulla elementum commodo orci eget rutrum. Pellentesque a mollis lectus.",
								 'link' => get_option("page_on_front"),
								 'link_label' => "Learn More",
								 'link_target' => "_self");

		$slides[] = array('id' => 'default', 
						  'link_type' => 'page', 
								 'image' => '/Site/themed-images/portfolio-very-large-2.jpg',
								 'title' => 'Example Title 2', 
								 'description' => "Aenean ultrices luctus est, sed luctus nisl gravida in. Aenean sit amet ante ultrices, dictum mauris ac, varius nisl.",
								 'link' => get_option("page_on_front"),
								 'link_label' => "Learn More",
								 'link_target' => "_self");
		
		$slides[] = array('id' => 'default', 
						  'link_type' => 'page', 
								 'image' => '/Site/themed-images/portfolio-very-large-3.jpg',
								 'title' => 'Example Title 3', 
								 'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ornare adipiscing scelerisque. Nulla elementum commodo orci eget rutrum. Pellentesque a mollis lectus.",
								 'link' => get_option("page_on_front"),
								 'link_label' => "Learn More",
								 'link_target' => "_self");

		$slides[] = array('id' => 'default', 
						  'link_type' => 'page', 
								 'image' => '/Site/themed-images/portfolio-very-large-4.jpg',
								 'title' => 'Example Title 4', 
								 'description' => "Aenean ultrices luctus est, sed luctus nisl gravida in. Aenean sit amet ante ultrices, dictum mauris ac, varius nisl.",
								 'link' => get_option("page_on_front"),
								 'link_label' => "Learn More",
								 'link_target' => "_self");
        $fullscreenCarousels = array();
		$fullscreenCarousels = $slides;
		$fullscreenCarousels = array_slice($fullscreenCarousels, 0, 3);
		$count = 1;
		foreach ($fullscreenCarousels as $x => $slide) {
		  $fullscreenCarousels["$x"]["image"] = 	"/Library/sliders/fullscreen-carousel/images/slide-0{$count}.jpg";
		  $count++;
		}


        $jumbotronCarousels = array();
		$jumbotronCarousels = $slides;
		$jumbotronCarousels = array_slice($fullscreenCarousels, 0, 3);
		$count = 1;
		foreach ($jumbotronCarousels as $x => $slide) {
		  $jumbotronCarousels["$x"]["image"] = 	"/Library/sliders/fullscreen-carousel/images/slide-0{$count}.jpg";
		  $count++;
		}

		$amazingSlides = array();
		$amazingSlides = $slides;
		$count = 1;
		foreach ($amazingSlides as $x => $slide) {
		  $amazingSlides["$x"]["image"] = 	"/Library/sliders/default-slider/images/portfolio-very-large-{$count}.jpg";
		  $count++;
		}

		$nivoSlides = array();
		$nivoSlides = $slides;
		$count = 1;
		foreach ($nivoSlides as $x => $slide) {
		  $nivoSlides["$x"]["image"] = 	"/Library/sliders/nivo-slider/images/portfolio-very-large-{$count}.jpg";
		  $count++;
		}

        $parallaxSlides = array();
		$parallaxSlides = $slides;
		$count = 1;
		$filename = get_template_directory() ."/Library/sliders/parallax-slider/images/portfolio-large-1.jpg";
		//print $filename;
		$parallaxLarge = false;
		if (file_exists($filename)) {
		  $parallaxLarge = true;
		//  print "exists";
		
		}
		//exit;
		foreach ($parallaxSlides as $x => $slide) {
		  if ($parallaxLarge) {
		    $parallaxSlides["$x"]["image"] = 	"/Library/sliders/parallax-slider/images/portfolio-large-{$count}.jpg";
			  
		  } else {
		    $parallaxSlides["$x"]["image"] = 	"/Library/sliders/parallax-slider/images/portfolio-very-large-{$count}.jpg";
		  }
		  $count++;
		}


		$fullscreenSlides = array();
		$fullscreenSlides[] = array('id' => 'default', 
						  		 'link_type' => 'page', 
								 'image' => '/Library/sliders/fullscreen-slider/images/'.I3D_Framework::$fullscreenSlideImageTemplate.'1.jpg',
								 'title' => 'Example Title', 
								 'slide_cover' => 'vertical-line', 
								 'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ornare adipiscing scelerisque. Nulla elementum commodo orci eget rutrum. Pellentesque a mollis lectus.",
								 'citation' => 'Example Citation: Using Vertical Lines Slide Cover', 
								 'link' => get_option("page_on_front"),
								 'link_label' => "",
								 'link_target' => "_self");

		$fullscreenSlides[] = array('id' => 'default', 
						  		'link_type' => 'page', 
								 'image' => '/Library/sliders/fullscreen-slider/images/'.I3D_Framework::$fullscreenSlideImageTemplate.'2.jpg',
								 'title' => 'Example Title 2', 
								 'slide_cover' => 'dot-light', 
								 'description' => "Aenean ultrices luctus est, sed luctus nisl gravida in. Aenean sit amet ante ultrices, dictum mauris ac, varius nisl.",
								 'citation' => 'Example Citation: Using Light Dots Slide Cover', 
								 'link' => get_option("page_on_front"),
								 'link_label' => "",
								 'link_target' => "_self");
		
		$fullscreenSlides[] = array('id' => 'default', 
						  		'link_type' => 'page', 
								 'image' => '/Library/sliders/fullscreen-slider/images/'.I3D_Framework::$fullscreenSlideImageTemplate.'3.jpg',
								 'title' => 'Example Title 3', 
								 'slide_cover' => 'horizontal-line', 
								 'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ornare adipiscing scelerisque. Nulla elementum commodo orci eget rutrum. Pellentesque a mollis lectus.",
								 'citation' => 'Example Citation: Using Horizontal Lines Slide Cover', 
								 'link' => get_option("page_on_front"),
								 'link_label' => "",
								 'link_target' => "_self");

		$fullscreenSlides[] = array('id' => 'default', 
						  		'link_type' => 'page', 
								 'image' => '/Library/sliders/fullscreen-slider/images/'.I3D_Framework::$fullscreenSlideImageTemplate.'4.jpg',
								 'title' => 'Example Title 4', 
								 'slide_cover' => 'dot-dark', 
								 'description' => "Aenean ultrices luctus est, sed luctus nisl gravida in. Aenean sit amet ante ultrices, dictum mauris ac, varius nisl.",
								 'citation' => 'Example Citation: Dark Dots Slide Cover', 
								 'link' => get_option("page_on_front"),
								 'link_label' => "",
								 'link_target' => "_self");

		$fullscreenSlides[] = array('id' => 'default', 
						 	 	'link_type' => 'page', 
								 'image' => '/Library/sliders/fullscreen-slider/images/'.I3D_Framework::$fullscreenSlideImageTemplate.'5.jpg',
								 'title' => 'Example Title 5', 
								 'slide_cover' => 'diagonal-right', 
								 'description' => "Aenean ultrices luctus est, sed luctus nisl gravida in. Aenean sit amet ante ultrices, dictum mauris ac, varius nisl.",
								 'citation' => 'Example Citation: Using Diagonal Lines Slide Cover', 
								 'link' => get_option("page_on_front"),
								 'link_label' => "",
								 'link_target' => "_self");


		$carouselSlides = array();
		$carouselSlides[] = array('id' => 'default', 
						  		 'link_type' => 'page', 
								 'image' => '/Library/sliders/carousel-slider/images/carousel-slider1.jpg',
								 'title' => 'Example Title', 
								 'slide_label' => "Slide 1",								 
								 'subtitle' => 'Example Sub-Title', 
								 'slide_cover' => 'vertical-line', 
								 'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ornare adipiscing scelerisque. Nulla elementum commodo orci eget rutrum. Pellentesque a mollis lectus.",
								 'citation' => 'Example Citation: Using Vertical Lines Slide Cover', 
								 'link' => get_option("page_on_front"),
								 'link_label' => "",
								 'link_target' => "_self");

		$carouselSlides[] = array('id' => 'default', 
						  		'link_type' => 'page', 
								 'image' => '/Library/sliders/carousel-slider/images/carousel-slider2.jpg',
								 'title' => 'Example Title 2', 
								 'slide_label' => "Slide 2",							 
								 'subtitle' => 'Example Sub-Title', 
								 'slide_cover' => 'dot-light', 
								 'description' => "Aenean ultrices luctus est, sed luctus nisl gravida in. Aenean sit amet ante ultrices, dictum mauris ac, varius nisl.",
								 'citation' => 'Example Citation: Using Light Dots Slide Cover', 
								 'link' => get_option("page_on_front"),
								 'link_label' => "",
								 'link_target' => "_self");
		
		$carouselSlides[] = array('id' => 'default', 
						  		'link_type' => 'page', 
								 'image' => '/Library/sliders/carousel-slider/images/carousel-slider3.jpg',
								 'title' => 'Example Title 3', 
								 'slide_label' => "Slide 3",
								 'subtitle' => 'Example Sub-Title', 
								 'slide_cover' => 'horizontal-line', 
								 'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ornare adipiscing scelerisque. Nulla elementum commodo orci eget rutrum. Pellentesque a mollis lectus.",
								 'citation' => 'Example Citation: Using Horizontal Lines Slide Cover', 
								 'link' => get_option("page_on_front"),
								 'link_label' => "",
								 'link_target' => "_self");

		$carouselSlides[] = array('id' => 'default', 
						  		'link_type' => 'page', 
								 'image' => '/Library/sliders/carousel-slider/images/carousel-slider4.jpg',
								 'title' => 'Example Title 4', 
								 'slide_label' => "Slide 4",							 
								 'subtitle' => 'Example Sub-Title', 
								 'slide_cover' => 'dot-dark', 
								 'description' => "Aenean ultrices luctus est, sed luctus nisl gravida in. Aenean sit amet ante ultrices, dictum mauris ac, varius nisl.",
								 'citation' => 'Example Citation: Dark Dots Slide Cover', 
								 'link' => get_option("page_on_front"),
								 'link_label' => "",
								 'link_target' => "_self");


		$welcomeSlides = array();
		$welcomeSlides[] = array('id' => 'x', 
						  		 'link_type' => 'page', 
								 'title' => 'Example Title', 
								 'subtitle' => 'Example Sub Title', 
								  'link' => get_option("page_on_front"),
								  'link_label' => '',
								  
								 'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ornare adipiscing scelerisque. Nulla elementum commodo orci eget rutrum. Pellentesque a mollis lectus.");

		$welcomeSlides[] = array('id' => 'x', 
						  		 'link_type' => 'page', 
								 'title' => 'Example Title 2', 
								 'subtitle' => 'Example Sub Title 3', 
								 'link' => get_option("page_on_front"),
								  'link_label' => '',
								 
								 'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ornare adipiscing scelerisque. Nulla elementum commodo orci eget rutrum. Pellentesque a mollis lectus.");

		$welcomeSlides[] = array('id' => 'x', 
						  		 'link_type' => 'page', 
								 'title' => 'Example Title 3', 
								 'subtitle' => 'Example Sub Title 3', 
								  'link' => get_option("page_on_front"),
								  'link_label' => '',
								 'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ornare adipiscing scelerisque. Nulla elementum commodo orci eget rutrum. Pellentesque a mollis lectus.");

		$bootstrapSlides = array();
		$bootstrapSlides[] = array('id' => 'default', 
						  		 'link_type' => 'page', 
								 'image' => '/Library/sliders/bootstrap-slider/images/fullscreen-slider1.jpg',
								 'title' => 'Welcome to', 
								 'subtitle' => 'Our New Website', 
								 'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ornare adipiscing scelerisque. Nulla elementum commodo orci eget rutrum. Pellentesque a mollis lectus.",
								 'link' => get_option("page_on_front"),
								 'link_label' => "Click to learn more",
								 'link_target' => "_self");

		$bootstrapSlides[] = array('id' => 'default', 
						  		'link_type' => 'page', 
								 'image' => '/Library/sliders/bootstrap-slider/images/fullscreen-slider2.jpg',
								 'title' => 'Mobile and Responsive', 
								 'subtitle' => 'Our New Website', 
								 'description' => "Aenean ultrices luctus est, sed luctus nisl gravida in. Aenean sit amet ante ultrices, dictum mauris ac, varius nisl.",
								 'link' => get_option("page_on_front"),
								 'link_label' => "Click to learn more",
								 'link_target' => "_self");
		
		$bootstrapSlides[] = array('id' => 'default', 
						  		'link_type' => 'page', 
								 'image' => '/Library/sliders/bootstrap-slider/images/fullscreen-slider3.jpg',
								 'title' => 'Be Creative', 
								 'subtitle' => 'Our New Website', 
								 'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ornare adipiscing scelerisque. Nulla elementum commodo orci eget rutrum. Pellentesque a mollis lectus.",
								 'link' => get_option("page_on_front"),
								 'link_label' => "Click to learn more",
								 'link_target' => "_self");

		$bootstrapSlides[] = array('id' => 'default', 
						  		'link_type' => 'page', 
								 'image' => '/Library/sliders/bootstrap-slider/images/fullscreen-slider4.jpg',
								 'title' => 'Welcome to our Website', 
								 'subtitle' => 'Our New Website', 
								 'description' => "Aenean ultrices luctus est, sed luctus nisl gravida in. Aenean sit amet ante ultrices, dictum mauris ac, varius nisl.",
								 'link' => get_option("page_on_front"),
								 'link_label' => "Click to learn more",
								 'link_target' => "_self");
		$transparentSlides = array();
	    
		$filename = get_template_directory() ."/Library/sliders/parallax-slider/images/portfolio-large-1.jpg";
		//print $filename;
		
		if (file_exists($filename)) {
		//	print "file exists";
			$fileName1 = "/Library/sliders/parallax-slider/images/portfolio-large-1.jpg";
			$fileName2 = "/Library/sliders/parallax-slider/images/portfolio-large-2.jpg";
			$fileName3 = "/Library/sliders/parallax-slider/images/portfolio-large-3.jpg";
		} else {
		//	print "file does not exist";
			$fileName1 = "/Library/sliders/parallax-slider/images/ipad-med.png";
			$fileName2 = "/Library/sliders/parallax-slider/images/iphone-med.png";
			$fileName3 = "/Library/sliders/parallax-slider/images/macbook-med.png";
			
		}
	//	exit;
		
		$transparentSlides[] = array('id' => 'default', 
						  'link_type' => 'page', 
								 'image' => $fileName1,
								 'title' => 'Example Title', 
								 'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ornare adipiscing scelerisque. Nulla elementum commodo orci eget rutrum. Pellentesque a mollis lectus.",
								 'link' => get_option("page_on_front"),
								 'link_label' => "Learn More",
								 'link_target' => "_self");

		$transparentSlides[] = array('id' => 'default', 
						  'link_type' => 'page', 
								 'image' => $fileName2,
								 'title' => 'Example Title 2', 
								 'description' => "Aenean ultrices luctus est, sed luctus nisl gravida in. Aenean sit amet ante ultrices, dictum mauris ac, varius nisl.",
								 'link' => get_option("page_on_front"),
								 'link_label' => "Learn More",
								 'link_target' => "_self");
		
		$transparentSlides[] = array('id' => 'default', 
						  'link_type' => 'page', 
								 'image' => $fileName3,
								 'title' => 'Example Title 3', 
								 'description' => "Suspendisse ante enim, luctus et dictum et, molestie id est. In hac habitasse platea dictumst. Curabitur sagittis lacus turpis, eu interdum nulla tristique eget. ",
								 'link' => get_option("page_on_front"),
								 'link_label' => "Learn More",
								 'link_target' => "_self");

		$availableSliders = I3D_Framework::getSliders();
		$count = 0;
		foreach ($availableSliders as $slider_id => $slider) {
		  $id = wp_create_nonce("i3d_slider".(mktime()+$count++));

		 // print "slider id -- $slider_id <br>";
		  
		  if ($slider_id == "parallax-slider" || $slider_id == "jumbotron-carousel") {
			if ($slider_id == "parallax-slider") {
			  $id = "default-parallax-slider";	
			} else {
				$id = "default-jumbotron-carousel";
			}
	  	    $sliders["{$id}"] = array('id' => $id,
							 'slider_title' => "Example {$slider['title']}",
							 'slides' => $transparentSlides,
							 'slider_type'  => $slider_id
							 );
		  } else   if ($slider_id == "fullscreen-slider") {
			  $id = "default-fullscreen-slider";
	  	    $sliders["default-fullscreen-slider"] = array('id' => "default-fullscreen-slider",
							 'slider_title' => "Example {$slider['title']}",
							 'slides' => $fullscreenSlides,
							 'slider_type'  => $slider_id
							 );
		  } else   if ($slider_id == "carousel-slider") {
			  $id = "default-carousel-slider";
	  	    $sliders["default-carousel-slider"] = array('id' => "default-carousel-slider",
							 'slider_title' => "Example {$slider['title']}",
							 'social-media-title' => "Get In Touch!",
							 'social-media-icons' => array("social_media_icon__facebook" => 1, "social_media_icon__twitter" => 1, "social_media_icon__tumblr" => "1", "social_media_icon__youtube" => 1),
							 'primary-logo' => "default-text-logo",
							 'secondary-logo' => "default-text-logo",
							 "primary-tagline" => "default-tagline", 
							 'slides' => $carouselSlides,
							 'slider_type'  => $slider_id
							 );

		  } else   if ($slider_id == "default-slider" || $slider_id == "amazing-slider") {
			  $id = "default-amazing-slider";
	  	    $sliders["default-amazing-slider"] = array('id' => "default-amazing-slider",
							 'slider_title' => "Example {$slider['title']}",
							 'slides' => $amazingSlides,
							 'slider_type'  => $slider_id
							 );

		  } else   if ($slider_id == "welcome-slider") {
			  $id = "default-welcome-slider";
	  	    $sliders["default-welcome-slider"] = array('id' => "default-welcome-slider",
							 'slider_title' => "Example {$slider['title']}",
							 'slides' => $welcomeSlides,
							 'slider_type'  => $slider_id,
							 'background-type'  => "video",
							 'background-video-id' => I3D_Framework::$default_welcome_video_id
							 );
		  } else   if ($slider_id == "bootstrap-slider") {
			  $id = "default-bootstrap-slider";
	  	    $sliders["default-bootstrap-slider"] = array('id' => "default-bootstrap-slider",
							 'slider_title' => "Example {$slider['title']}",
							 'slides' => $bootstrapSlides,
							 'slider_type'  => $slider_id,
							 );

		  } else   if ($slider_id == "nivo-slider") {
	  	    $sliders["default-nivo-slider"] = array('id' => "default-nivo-slider",
							 'slider_title' => "Example {$slider['title']}",
							 'slides' => $nivoSlides,
							 'slider_type'  => $slider_id
							 );


			} else {

	  	    $sliders["sl_{$id}"] = array('id' => "sl_".$id,
							 'slider_title' => "Example {$slider['title']}",
							 'slides' => $slides,
							 'slider_type'  => $slider_id
							 );
		  }
		  
		   if ($slider['is_signature']) {
			  $signatureSliderID = $id;
			  $general = get_option("i3d_general_settings");
			  if ($general['default_slider'] == "") {
				  $general['default_slider'] = $id;
			  }
			  update_option("i3d_general_settings", $general);
			//  print "updated signature to $id  $slider_id<br>";
		  }

			//print $slider_id."<br>";
		}
		//exit;
		update_option("i3d_sliders", $sliders);
		

		
	     // update pages with sliders
		 
		  $pages = get_pages();
		  foreach ($pages as $page) {
			if ($page->post_title == "Home") {
				update_post_meta($page->ID, "i3d_page_slider", $signatureSliderID);
				self::debug("Updating page {$page->ID}  with default slider {$signatureSliderID}");
			} else if ($page->post_title == "Blog") {
				update_post_meta($page->ID, "i3d_page_slider", $signatureSliderID);
				self::debug("Updating page {$page->ID} with default slider {$signatureSliderID}");
			}
		  }
		  
		
		
	  }
	  
	 // exit;
	
	}

	public static function getAdminButtons() {
		global $templateName;
		global $lmFrameworkVersion;
		
		$helpLocation = strtolower(str_replace(" ", "_", $templateName))."-wp2";

		$buttons = array(); 
		$buttons['aquila']                = array('option_target' => '_self', 'option_link' => 'admin.php?page='.get_option("current_theme").'-settings-top-level', 'img_src' => 'aquila.png', 'title' => 'Theme Settings', 'description' => 'Update settings such as your website name, copyright, and social networking account info.');
		$buttons['settings']                = array('option_target' => '_self', 'option_link' => 'admin.php?page='.get_option("current_theme").'-settings-top-level', 'img_src' => 'settings.png', 'title' => 'Theme Settings', 'description' => 'Update settings such as your website name, copyright, and social networking account info.');
		if ($lmFrameworkVersion >= 2.4) { 
			$buttons['styling']				 = array('option_target' => '_self', 'option_link' => 'admin.php?page='.get_option("current_theme").'-styling-top-level', 		'img_src' => 'styling.png', 'title' => 'Styling', 'description' => 'Manage the font styling of many of the components for this theme.');
		}
		$buttons['custom_logo']             = array('option_target' => '_self', 'option_link' => 'admin.php?page='.get_option("current_theme").'-logo-settings-top-level', 'img_src' => 'custom-logo.png', 'title' => 'Custom Logo', 'description' => 'Specify and position a graphic logo to replace, or go beside the existing "Website Name" text.');
		$buttons['catalog']                 = array('option_target' => '_self', 'option_link' => 'admin.php?page='.get_option("current_theme").'-product-catalog-settings-top-level', 'img_src' => 'catalog.png', 'title' => 'Product Catalog', 'description' => 'List items for sale or show in this simple lister.  Provide "Buy Now" button code for your favorite pay source.');
		$buttons['faqs']                    = array('option_target' => '_self', 'option_link' => 'admin.php?page='.get_option("current_theme").'-faqs-catalog-settings-top-level', 'img_src' => 'faqs.png', 'title' => 'FAQs', 'description' => 'Add/remove/modify FAQs for the FAQs component.  FAQ component is rendered in page via the [faqs] short-tag.');
		$buttons['mp3_music_player']        = array('option_target' => '_self', 'option_link' => 'admin.php?page='.get_option("current_theme").'-mp3-flash-top-level', 'img_src' => 'mp3-player.png', 'title' => 'MP3 Audio Player', 'description' => 'Upload new MP3 tracks, or specify whether the player auto-starts for new visitors.');
		$buttons['themed_image']            = array('option_target' => '_self', 'option_link' => 'admin.php?page='.get_option("current_theme").'-themed-image-settings-top-level', 'img_src' => 'themed-image.png', 'title' => 'Themed Image Object', 'description' => 'Configure and position the "Themed Image Object".');
		$buttons['zoom_menu']               = array('option_target' => '_self', 'option_link' => 'admin.php?page='.get_option("current_theme").'-zoom-menu-top-level', 'img_src' => 'zoom-menu.png', 'title' => 'Zoom Menu', 'description' => 'Configure the "Zoom" menu icons and links.');
		if ($lmFrameworkVersion >= 2.4) { 
			$buttons['nivo_slider']				 = array('option_target' => '_self', 'option_link' => 'admin.php?page='.get_option("current_theme").'-nivo-top-level', 		'img_src' => 'primary-non-flash-image-portfolio.png', 'title' => 'Nivo Slider Images', 'description' => 'Manage the images, buttons &amp; taglines for the primary layout Nivo image portfolio.');
			$buttons['mini_nivo_slider']		 = array('option_target' => '_self', 'option_link' => 'admin.php?page='.get_option("current_theme").'-mini-nivo-top-level', 'img_src' => 'primary-non-flash-image-portfolio.png', 'title' => 'Mini Nivo Slider', 'description' => 'Manage the images, buttons &amp; taglines for the secondary layout Nivo image portfolio.');
		} else { 
		  $buttons['primary_flash_image_portfolio'] = array('option_target' => '_self', 'option_link' => 'admin.php?page='.get_option("current_theme").'-flash-top-level', 'img_src' => 'primary-flash-image-portfolio.png', 'title' => 'Primary Layout Flash Portfolio', 'description' => 'Manage the images, buttons &amp; taglines for the primary page flash image portfolio.');
		  $buttons['primary_non_flash_image_portfolio'] = array('option_target' => '_self', 'option_link' => 'admin.php?page='.get_option("current_theme").'-components-top-level', 'img_src' => 'primary-non-flash-image-portfolio.png', 'title' => 'Primary Layout NON-Flash Images', 'description' => 'Manage the images, buttons &amp; taglines for the primary page non-flash image portfolio.');
		  $buttons['primary_image_rotator']   = array('option_target' => '_self', 'option_link' => 'admin.php?page='.get_option("current_theme").'-p_ir-flash-top-level', 'img_src' => 'primary-image-rotator.png', 'title' => 'Primary Layout Image Rotator',  'description' => 'Manage the images &amp; descriptions for the primary page non-flash image split-rotator.');
		  $buttons['secondary_image_rotator'] = array('option_target' => '_self', 'option_link' => 'admin.php?page='.get_option("current_theme").'-s_ir-flash-top-level', 'img_src' => 'secondary-image-rotator.png', 'title' => 'Secondary Layout Image Rotator', 'description' => 'Manage the images &amp; descriptions for the smaller non-flash image split-rotator.');
		
		}
		$buttons['parallax_slider']		 = array('option_target' => '_self', 'option_link' => 'admin.php?page='.get_option("current_theme").'-parallax-slider-top-level', 'img_src' => 'parallax-slider.png', 'title' => 'Parallax Slider', 'description' => 'Manage the images for the Parallax Image Slider');
		$buttons['accordion_menu']		 = array('option_target' => '_self', 'option_link' => 'admin.php?page='.get_option("current_theme").'-accordion-menu-top-level',  'img_src' => 'accordion-menu.png', 'title' => 'Accordion Menu', 'description' => 'Manage the images and links for the Accordion Menu');
		$buttons['image_menu']		 	 = array('option_target' => '_self', 'option_link' => 'admin.php?page='.get_option("current_theme").'-image-menu-top-level', 	  'img_src' => 'image-menu.png', 'title' => 'Image Menu', 'description' => 'Manage the images and links for the Image Menu');
		
		
		$buttons['news_ticker']             = array('option_target' => '_self', 'option_link' => 'admin.php?page='.get_option("current_theme").'-news-ticker-top-level', 'img_src' => 'news-ticker.png', 'title' => 'News Ticker', 'description' => 'Manage the news ticker text and link.');
		$buttons['get_in_touch']             = array('option_target' => '_self', 'option_link' => 'admin.php?page='.get_option("current_theme").'-get-in-touch-top-level', 'img_src' => 'get-in-touch.png', 'title' => 'Get In Touch Button', 'description' => 'Manage the get-in-touch button.');

		if (!function_exists('register_nav_menus')) {
		  $buttons['side_menu']          = array('option_target' => '_blank', 'option_link' => 'admin.php?page='.get_option("current_theme").'-navigation-top-level', 'img_src' => 'menus.png', 'title' => 'Side Menu', 'description' => 'Configure which pages show up in your your side menu.');
		  $buttons['drop_down_menu']     = array('option_target' => '_blank', 'option_link' => 'admin.php?page='.get_option("current_theme").'-dropdown-navigation-top-level', 'img_src' => 'menus-drop-down.png', 'title' => 'Drop Down Menu', 'description' => 'Configure which pages show up in your your drop-down menu.');
		} else {
		  $buttons['menus']              = array('option_target' => '_blank', 'option_link' => 'nav-menus.php', 'img_src' => 'menus.png', 'title' => 'Side/Top Menu', 'description' => 'Manage your side and top menus using the WordPress 3.0 Navigation Center');
		}


		$buttons['help'] = array('option_target' => '_blank', 'option_link' => 'http://www.luckymarble.com/members/product/helpsys/wordpress/all/'.$helpLocation.'/', 'img_src' => 'instructions.png', 'title' => 'Instructions', 'description' => 'For help with this theme, please proceed to the Instruction Center');

      return $buttons;

	}

	public static function getAuxIcons() {
		$icons = array();
		$icons['featured-post']                = array('img_src' => 'featured.png', 'title' => 'Theme Settings', 'description' => 'Update general settings, such as your website name, copyright line, and social networking accountinfo.');
		$icons['featured-post-lg']                = array('img_src' => 'featured-lg.png', 'title' => 'Theme Settings', 'description' => 'Update general settings, such as your website name, copyright line, and social networking accountinfo.');
		$icons['no-image']                = array('img_src' => 'no-image.png', 'title' => 'Theme Settings', 'description' => 'Update general settings, such as your website name, copyright line, and social networking accountinfo.');
		$icons['loading-bg']                = array('img_src' => 'loading.gif', 'title' => 'Theme Settings', 'description' => 'Update general settings, such as your website name, copyright line, and social networking accountinfo.');
		$icons['config-business']                = array('img_src' => 'config_business.png', 'title' => 'Business Configuration', 'description' => '');
		$icons['config-magazine']                = array('img_src' => 'config_magazine.png', 'title' => 'Magazine Configuration', 'description' => '');
		return $icons;
	}

	public static function getAuxIconSrc($iconName) {
		$buttons = array_merge(I3D_Framework::getAdminButtons(),I3D_Framework::getAuxIcons());

		$button = $buttons["$iconName"];
		return "../wp-content/themes/".get_template()."/includes/admin/images/{$button['img_src']}";
	}

	public static function i3d_screen_icon($iconName, $styles = " padding-top: 15px;float: left; padding-right: 5px; width: 30px", $id = "") {
		$buttons = array_merge(I3D_Framework::getAdminButtons(),I3D_Framework::getAuxIcons());

		$button = $buttons["$iconName"];
		
    	echo "<img src=\"".get_template_directory_uri()."/includes/admin/images/{$button['img_src']}\" style=\"{$styles}\" id=\"{$id}\" />";
	}
	
	public static function getLMPlugins() {
	  $plugins = array();
	  $wpPlugins = get_plugins();
	  foreach ($wpPlugins as $pluginLocation => $pluginData) {
		  if (strstr($pluginLocation, "womo-") && $pluginData['Author'] == "i3dTHEMES") {
			$plugin = array_shift(explode("/", $pluginLocation));  
			$pluginOnline = is_plugin_active($pluginLocation);
			if ($pluginOnline) {
				$pluginConfigPage = "admin.php?page={$pluginLocation}";
			} else {
				$pluginConfigPage = "plugins.php?action=activate&plugin=".$pluginLocation."&plugin_status=all&paged=1&s&_wpnonce=c264c43426";
			}
	  		$plugins["{$plugin}"]        = array('option_target' => '_self', 'option_link' => $pluginConfigPage, 'img_src' => 'icon-50x50.png', 'title' => $pluginData['Name'], 'description' => $pluginData['Description']);
		    
		  }

	  }
	  return $plugins;
	}

	public static function render_dashboardManager($size = "default", $selected = "") {
		global $lmIncludedComponents;

		$buttons = I3D_Framework::getAdminButtons();
		$plugins = I3D_Framework::getLMPlugins();

 ?>
<style>

#i3d_theme_manager_widget h4 { 
font-weight: bold; 
font-size: 12pt;
font-family: "HelveticaNeue-Light","Helvetica Neue Light","Helvetica Neue",sans-serif;
}	


#i3d_theme_manager_widget p { 
 font-size: 10pt;
}
#i3d_theme_manager_widget i.icon-youtube-play { color: #990000; float: right; margin-top: 3px; margin-left: 3px; }
#i3d_theme_manager_widget i.icon-star-empty { color:#F60; }
#i3d_theme_manager_widget a i.icon-star-empty { float: left; margin-top: 3px;  }
#i3d_theme_manager_widget a { margin-bottom: 2px; }
#i3d_theme_manager_widget a span { font-size: 8pt; }
#i3d_theme_manager_widget div.section-divider { clear: both; margin-top: 30px; }
#i3d_theme_manager_widget .span3 { margin-left: 0px !important; margin-right: 2px; }
</style>
<span class="icon-stack pull-left icon-2x">
  <i class="icon-circle icon-stack-base"></i>
  <i class="icon-flag icon-light"></i>
</span>

<h4 class='nomargin'>Getting Started</h4>
<p>Over 40 minutes of introduction of the basics of our Aquila framework.  These videos include a tour of the framework dashboard as well as the basics of working with widgets.  We've marked videos
of significant importance with a <i class='icon-star-empty'></i>.</p>
<div class='row' style='margin-left: 0px;'>
<a href='http://youtu.be/_-I38mdoZcc' class='btn span3' target="_blank"><i class='icon-star-empty'></i> "Introduction" <i class='icon-youtube-play'></i> <span class='pull-right'>(22:12)</span></a>
<a href='http://youtu.be/GETTbapAEDE' class='btn span3' target="_blank">"Working With Widgets" <i class='icon-youtube-play'></i> <span class='pull-right'>(18:32)</span></a>
<a href='http://youtu.be/iUrzT01SmTk' class='btn span3' target="_blank"><i class='icon-star-empty'></i> "Updating Your Theme" <i class='icon-youtube-play'></i> <span class='pull-right'>(2:46)</span></a>
</div>

<div class='section-divider'></div>

<span class="icon-stack pull-left">
  <i class="icon-circle icon-stack-base"></i>
  <i class="icon-sitemap icon-light"></i>
</span>
<h4>Working With Pages</h4>
<p>Become familiar with all of the available features of over ten different page layouts.</p>
<div class='row' style='margin-left: 0px;'>
<a href='http://youtu.be/XhDU9teg8PM' class='btn span3' target="_blank"><i class='icon-star-empty'></i>"Home" <i class='icon-youtube-play'></i> <span class='pull-right'>(6:01)</span></a>
<a href='http://youtu.be/87V6yEON_BM' class='btn span3' target="_blank"><i class='icon-star-empty'></i>"Blog" <i class='icon-youtube-play'></i> <span class='pull-right'>(6:42)</span></a>
<a href='http://youtu.be/rIvDCctQGsA' class='btn span3' target="_blank"><i class='icon-star-empty'></i>"Contact" <i class='icon-youtube-play'></i> <span class='pull-right'>(4:28)</span></a>
<a href='http://youtu.be/2fWUSe6h-Eo' class='btn span3' target="_blank"><i class='icon-star-empty'></i>"Team Members" <i class='icon-youtube-play'></i> <span class='pull-right'>(3:45)</span></a>
<a href='http://youtu.be/uu1dDor1LVI' class='btn span3' target="_blank"><i class='icon-star-empty'></i>"FAQs" <i class='icon-youtube-play'></i> <span class='pull-right'>(6:33)</span></a>
<a href='http://youtu.be/od9RZMOPbWU' class='btn span3' target="_blank">"Photo Slideshow" <i class='icon-youtube-play'></i> <span class='pull-right'>(4:49)</span></a>
<a href='http://youtu.be/DlRXvWUoNFw' class='btn span3' target="_blank">"Sitemap" <i class='icon-youtube-play'></i> <span class='pull-right'>(2:52)</span></a>
<a href='http://youtu.be/dS0CV5zCka8' class='btn span3' target="_blank">"Under Construction" <i class='icon-youtube-play'></i> <span class='pull-right'>(4:35)</span></a>
<a href='http://youtu.be/Ua4caIztS90' class='btn span3' target="_blank">"404 (Page Not Found)" <i class='icon-youtube-play'></i> <span class='pull-right'>(1:38)</span></a>
<a href='http://youtu.be/d3-Zg8JVPQI' class='btn span3' target="_blank"><i class='icon-star-empty'></i>"Minimized" <i class='icon-youtube-play'></i> <span class='pull-right'>(5:22)</span></a>
<a href='http://youtu.be/0JOBL0iYBag' class='btn span3' target="_blank">"Advanced" <i class='icon-youtube-play'></i> <span class='pull-right'>(8:11)</span></a></div>

<div class='section-divider'></div>

<span class="icon-stack pull-left">
  <i class="icon-circle icon-stack-base"></i>
  <i class="icon-cogs icon-light"></i>
</span>
<h4>Working With Widgets</h4>
<p>We've developed 20 specialized widgets to add more function and form to your website.  Learn about each of them here.</p>
<div class='row' style='margin-left: 0px;'>
<a href='http://youtu.be/GETTbapAEDE' class='btn span3' target="_blank"><i class='icon-star-empty'></i>"Working With Widgets" <i class='icon-youtube-play'></i><span class='pull-right'>(18:33)</span></a>
<a href='http://youtu.be/le4IRokbFiQ' class='btn span3' target="_blank">"Breadcrumb Links" <i class='icon-youtube-play'></i> <span class='pull-right'>(5:59)</span></a>
<a href='http://www.youtube.com/watch?v=B_iWyMGvUv8' class='btn span3' target="_blank"><i class='icon-star-empty'></i>"Column Break" <i class='icon-youtube-play'></i> <span class='pull-right'>(4:53)</span></a>
<a href='http://www.youtube.com/watch?v=t56xRHF5Mxc' class='btn span3' target="_blank">"Contact Form" <i class='icon-youtube-play'></i> <span class='pull-right'>(3:24)</span></a>
<a href='http://www.youtube.com/watch?v=62RXnLGcOC8' class='btn span3' target="_blank">"Contact Form Menu" <i class='icon-youtube-play'></i> <span class='pull-right'>(1:21)</span></a>
<a href='http://www.youtube.com/watch?v=kOeBvTKIMQA' class='btn span3' target="_blank"><i class='icon-star-empty'></i>"Content Region" <i class='icon-youtube-play'></i> <span class='pull-right'>(4:23)</span></a>
<a href='http://www.youtube.com/watch?v=gxNEJqLBfII' class='btn span3' target="_blank">"Font Sizer" <i class='icon-youtube-play'></i> <span class='pull-right'>(0:55)</span></a>
<a href='http://www.youtube.com/watch?v=meGDMofqpGQ' class='btn span3' target="_blank">"Contact Details" <i class='icon-youtube-play'></i> <span class='pull-right'>(0:55)</span></a>
<a href='http://www.youtube.com/watch?v=PbIcN7UeQ4s' class='btn span3' target="_blank">"HTML Box" <i class='icon-youtube-play'></i> <span class='pull-right'>(1:24)</span></a>
<a href='http://www.youtube.com/watch?v=XcJnY-NYx3Q' class='btn span3' target="_blank">"Image/Banner" <i class='icon-youtube-play'></i> <span class='pull-right'>(2:47)</span></a>
<a href='http://www.youtube.com/watch?v=dNuDaqijf_s' class='btn span3' target="_blank">"Info Box" <i class='icon-youtube-play'></i> <span class='pull-right'>(3:10)</span></a>
<a href='http://www.youtube.com/watch?v=Oow6R0eWd3M' class='btn span3' target="_blank">"Website Title/Logo" <i class='icon-youtube-play'></i> <span class='pull-right'>(5:11)</span></a>
<a href='http://www.youtube.com/watch?v=NkZI5tbnh7E' class='btn span3' target="_blank">"Custom Menu" <i class='icon-youtube-play'></i> <span class='pull-right'>(1:27)</span></a>
<a href='http://www.youtube.com/watch?v=DGn5bE7vcY4' class='btn span3' target="_blank">"Phone Number" <i class='icon-youtube-play'></i> <span class='pull-right'>(1:47)</span></a>
<!--<a href='http://www.youtube.com/watch?v=mc-xDoC2nb4' class='btn span3' target="_blank">"Search Form" <i class='icon-youtube-play'></i> <span class='pull-right'>(9:31)</span></a>-->
<a href='http://www.youtube.com/watch?v=l_SX5F1WSno' class='btn span3' target="_blank">"SEO Tags" <i class='icon-youtube-play'></i> <span class='pull-right'>(4:03)</span></a>
<a href='http://www.youtube.com/watch?v=PNa5Ixc7RII' class='btn span3' target="_blank">"Slider Region" <i class='icon-youtube-play'></i> <span class='pull-right'>(6:17)</span></a>
<a href='http://www.youtube.com/watch?v=iVpQLb4gO10' class='btn span3' target="_blank">"Social Media Icons" <i class='icon-youtube-play'></i> <span class='pull-right'>(2:15)</span></a>
<a href='http://youtu.be/nHkNTpl91hs' class='btn span3' target="_blank">"Blog Super Summary" <i class='icon-youtube-play'></i> <span class='pull-right'>(1:27)</span></a>
<a href='http://www.youtube.com/watch?v=YgiJJNuv3jM' class='btn span3' target="_blank">"Testimonial Rotator" <i class='icon-youtube-play'></i> <span class='pull-right'>(3:02)</span></a>
<a href='http://www.youtube.com/watch?v=LxMalGndGIE' class='btn span3' target="_blank">"Twitter Feed" <i class='icon-youtube-play'></i> <span class='pull-right'>(1:50)</span></a>
<a href='http://youtu.be/8YEIT1koYLs' class='btn span3' target="_blank">"Calls To Action" <i class='icon-youtube-play'></i> <span class='pull-right'>(10:18)</span></a>
</div>

<div class='section-divider'></div>

<span class="icon-stack pull-left">
  <i class="icon-circle icon-stack-base"></i>
  <i class="icon-magic icon-light"></i>
</span>
<h4>Working With Custom Post Types and Special Components</h4>
<p>Learn about the different post types and special components that we've included with this theme here.</p>
<div class='row' style='margin-left: 0px;'>

<a href='http://youtu.be/YgiJJNuv3jM' class='btn span3' target="_blank"><i class='icon-star-empty'></i>"Testimonials" <i class='icon-youtube-play'></i> <span class='pull-right'>(11:14)</span></a>
<a href='http://youtu.be/VVGhWN6diEo' class='btn span3' target="_blank"><i class='icon-star-empty'></i>"Team Members" <i class='icon-youtube-play'></i> <span class='pull-right'>(11:14)</span></a>
<a href='http://youtu.be/PNa5Ixc7RII' class='btn span3' target="_blank"><i class='icon-star-empty'></i>"Sliders" <i class='icon-youtube-play'></i> <span class='pull-right'>(11:14)</span></a>
<a href='http://youtu.be/ProIrVGePk4' class='btn span3' target="_blank"><i class='icon-star-empty'></i>"Contact Forms" <i class='icon-youtube-play'></i> <span class='pull-right'>(11:14)</span></a>
</div>
    <?php
	/*
      echo "<ul id='lm_dashboard_manager'>";
      foreach ($buttons as $buttonID => $button) {
        if (!isset($lmIncludedComponents["{$buttonID}"]) || (isset($lmIncludedComponents["{$buttonID}"]) && $lmIncludedComponents["{$buttonID}"] !== false)) {
		  echo "<li ";
		  if ($buttonID == $selected) {
			print "class='selected'";
		  }
		  echo "><a target='{$button['option_target']}' href='{$button['option_link']}'><img title='{$button['title']}' src='../wp-content/themes/".get_template()."/includes/admin/images/{$button['img_src']}' border='0' /><h5>{$button['title']}</h5><p>{$button['description']}</p></a></li>";
		}
	  }
	  if ($size != "small") {
	    echo "</ul>";

        echo "<ul id='lm_dashboard_manager'>";
	  }
      foreach ($plugins as $pluginID => $plugin) {
       // if (!isset($lmIncludedComponents["{$buttonID}"]) || (isset($lmIncludedComponents["{$buttonID}"]) && $lmIncludedComponents["{$buttonID}"])) {
		  echo "<li ";
		  if ($pluginID == $selected) {
			print "class='selected'";
		  }
		  echo "><a target='{$plugin['option_target']}' href='{$plugin['option_link']}'><img title='{$plugin['title']}' src='../wp-content/plugins/{$pluginID}/admin/images/icon-45x45.png' border='0' /><h5>{$plugin['title']}</h5><p>{$plugin['description']}</p></a></li>";
		}
	 // }
	  echo "</ul>";
	  
	echo "<div style='clear: both;'></div>";
	*/
	}

	public static function init_posts() {
       self::debug("In init_posts()");
	require_once(ABSPATH . 'wp-admin/includes/media.php');
	require_once(ABSPATH . 'wp-admin/includes/file.php');
	require_once(ABSPATH . 'wp-admin/includes/image.php');
		
		global $defaultPosts;
		if (!is_array($defaultPosts)) {
					  include("config-default.php");

		}
		global $wpdb;
		
		$count_posts = wp_count_posts();
		$published_posts = $count_posts->publish;
		$postCount = 0;
		if ($published_posts <= 1) {
			foreach ($defaultPosts as $newPost) {
				$postCount++;
				$postData = array('post_title' => $newPost['title'],
										 'post_content' => $newPost['content'],
										 'post_status' => 'publish',
										 'post_type' => 'post',
										 'comment_status' => 'closed',
										 'ping_status' => 'closed');

				$post_id = wp_insert_post($postData);
				
				if (I3D_Framework::$teamMemberPhotos == "kindercare") {
											$i = $postCount;
					
					$filename = get_template_directory_uri() ."/Site/themed-images/blog/blog{$i}.jpg";							
					$error = media_sideload_image($filename,0,$description);
					$last_attachment = $wpdb->get_row($query = "SELECT * FROM {$wpdb->prefix}posts ORDER BY ID DESC LIMIT 1", ARRAY_A);
					$attachment_id = $last_attachment['ID'];
				
				} else {
					$imageName = "image-{$postCount}-description";
				
					$last_attachment = $wpdb->get_row($query = "SELECT * FROM {$wpdb->prefix}posts WHERE post_name='{$imageName}' ORDER BY ID DESC LIMIT 1", ARRAY_A);
					$attachment_id = $last_attachment['ID'];
				}
				add_post_meta($post_id, '_thumbnail_id', $attachment_id);
			}
		}
       self::debug("Done init_posts()");
		
	}





public static function init_faqs() {
	  self::debug("In init_faqs()");


	$wpq = array("post_type" => "i3d-faq");
	
	$count_posts = wp_count_posts("i3d-faq");
	$published_posts = $count_posts->publish;
	
	$text = I3D_Framework::$defaultFAQs;
    if (sizeof($text) == 0) {
		$text[1] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sed elementum elit. Fusce eu ipsum nec ligula vehicula fringilla in nec nisl. Sed non ornare elit. Mauris ut leo ipsum. Aenean odio lacus, gravida vitae elementum ac, interdum vel nulla. Maecenas in urna a arcu hendrerit consectetur.";
		$text[2] = "Ut non elementum lectus. Mauris quis ipsum ac nibh tempor consectetur. Morbi eu massa in purus cursus tempus sit amet sed felis. Praesent iaculis nunc leo, nec dignissim metus luctus vitae. Donec venenatis justo at orci sodales semper. Vestibulum vitae accumsan nunc.";
		$text[3] = "Duis quis ipsum vitae dolor ornare faucibus et at magna.";
		$text[4] = "Ut porta porta sapien, in rutrum lectus viverra et. Donec a purus nec ligula mattis accumsan eget eget purus. Cras euismod sapien ut lectus bibendum, ut accumsan elit interdum. Nam eget erat nulla. Nullam viverra libero at molestie eleifend. Nullam a mauris sit amet augue bibendum egestas.";
		$text[5] = "Cras pulvinar orci quis purus dapibus iaculis. Phasellus rutrum erat nisl, a venenatis nunc gravida luctus. Duis ac dolor vel velit pellentesque consectetur non egestas sem. Nulla placerat euismod leo a venenatis. Curabitur imperdiet est ut elit pulvinar, eget scelerisque diam vehicula. ";
		$text[6] = "Fusce tempor ligula in nulla convallis, ut interdum tellus consequat. Proin cursus enim at neque placerat, at molestie tellus auctor. Nam aliquam tortor a quam pulvinar fermentum. ";
		$text[7] = "Aenean ac quam pulvinar, eleifend lacus quis, volutpat augue. Ut auctor, urna interdum vestibulum condimentum, arcu eros porta metus, vel aliquam erat augue vitae velit. Ut quis arcu commodo, viverra erat quis, aliquam ante. Nullam tincidunt justo vitae justo semper luctus. ";
		$text[8] = "Sed et nunc bibendum, suscipit lacus vitae, feugiat sapien. Donec vel suscipit velit. Praesent non lorem orci. Sed venenatis et dolor ultrices ullamcorper. Nam vitae luctus massa. Maecenas commodo rhoncus tellus, eget malesuada nisi faucibus et. ";
		$text[9] = "Sed accumsan tortor felis, ac vulputate odio vehicula a. Cras cursus aliquam tellus sit amet laoreet. Vestibulum eget consequat nunc.";
		$text[10] = "Nunc lacus massa, porta at tempus sit amet, tincidunt a nunc. Mauris suscipit purus eu sem sagittis, et iaculis erat sollicitudin. ";
	}
	 self::debug("Have ".$published_posts." FAQs existing");
      if ($published_posts > 0) {

	  	self::debug("Exiting Early -- No new FAQs created");
	  } else {
		// contact form box
		for ($i = 1; $i <= sizeof($text); $i++) {
			if (is_array($text["$i"])) {
			//	var_dump($text["$i"]);
				$question = $text["$i"]["question"];
				$answer = $text["$i"]["answer"];
			} else {
				$question = "Example FAQ {$i}";
			    $answer = $text["$i"];
			}
			global $user_ID;
			$new_post = array(
			'post_title' => $question,
			'post_content' => $answer,
			'post_status' => 'publish',
			'post_date' => date('Y-m-d H:i:s'),
			'post_author' => $user_ID,
			'post_type' => 'i3d-faq',
			'comment_status' => 'closed',
			'ping_status' => 'closed',			
			'post_category' => array(0)
			);
			
			$post_id = wp_insert_post($new_post);
		}
		
		
	  }

	  	  self::debug("Done init_faqs()");

	
	}


public static function init_photo_slideshow() {
	require_once(ABSPATH . 'wp-admin/includes/media.php');
	require_once(ABSPATH . 'wp-admin/includes/file.php');
	require_once(ABSPATH . 'wp-admin/includes/image.php');
	self::debug("In init_photo_slideshow()");

    global $wpdb;
	$imageIds = "";
	$post_id = self::getPageID("Photo Gallery");
	$post = get_post($post_id);
	//print "post_id = {$post_id}";
	//print "<br>postcontent = [{$post->post_content}]<br>";
	if (@$post->post_content == '[gallery ids=""]') {
			  	  self::debug("uploading images and attemptint to attach");

		// contact form box
		for ($i = 1; $i <= 6; $i++) {
			global $user_ID;
			
			
			
			$filename = get_template_directory_uri() ."/Library/sliders/supersized-slideshow/images/supersized{$i}.jpg";
			$description = "Image {$i} Description";
			
			# upload / resize / crop image (to WP images folder)
			$returnVar =  media_sideload_image($filename, $post_id, $description);
			if (is_wp_error($returnVar)) {
					self::debug("Error Uploading Image: ".$returnVar->get_error_message());

				
			} else {
			
			  $last_attachment = $wpdb->get_row($query = "SELECT * FROM {$wpdb->prefix}posts ORDER BY ID DESC LIMIT 1", ARRAY_A);
			  $attachment_id = $last_attachment['ID'];
			  $imageIds .= "{$attachment_id},";
			}
			# set featured image
			//add_post_meta($post_id, '_thumbnail_id', $attachment_id);			
		}
		
		wp_update_post(array('ID' => $post_id, 'post_content' => '[gallery ids="'.trim($imageIds, ",").'"]'));

		
		
	  }
	  
	  self::debug("Done init_photo_slideshow()");

	
	}


public static function init_team_members() {
	require_once(ABSPATH . 'wp-admin/includes/media.php');
	require_once(ABSPATH . 'wp-admin/includes/file.php');
	require_once(ABSPATH . 'wp-admin/includes/image.php');
	  self::debug("In init_team_members()");

    global $wpdb;
	
	$wpq = array("post_type" => "i3d-team-member");
	
	$count_posts = wp_count_posts("i3d-team-member");
	$published_posts = $count_posts->publish;
	
	$person = array();
	
	$person[1]['name'] = "Jenny Smith";
	$person[1]['bio'] = "Ut non elementum lectus. Mauris quis ipsum ac nibh tempor consectetur. Morbi eu massa in purus cursus tempus sit amet sed felis. Praesent iaculis nunc leo, nec dignissim metus luctus vitae. Donec venenatis justo at orci sodales semper. Vestibulum vitae accumsan nunc.";
	$person[1]['excerpt'] = "Ut non elementum lectus. Mauris quis ipsum ac nibh tempor consectetur.";
	$person[1]['title'] = "Toddler/Infant Program";
	
	if (I3D_Framework::$teamMemberPhotos == "kindercare") {
		$person[1]['taxonomy'] = "Toddler/Infant";
	} 
	$person[2]['name'] = "Jane Michaels";
	$person[2]['bio'] = "Ut porta porta sapien, in rutrum lectus viverra et. Donec a purus nec ligula mattis accumsan eget eget purus. Cras euismod sapien ut lectus bibendum, ut accumsan elit interdum. Nam eget erat nulla. Nullam viverra libero at molestie eleifend. Nullam a mauris sit amet augue bibendum egestas.";
	$person[2]['excerpt'] = "Ut porta porta sapien, in rutrum lectus viverra et.";
	$person[2]['title'] = "Toddler/Infant Program";
	if (I3D_Framework::$teamMemberPhotos == "kindercare") {
		$person[2]['taxonomy'] = "Toddler/Infant";
	} 


	$person[3]['name'] = "Sandy Taylor";
	$person[3]['bio'] = "Duis quis ipsum vitae dolor ornare faucibus et at magna.";
	$person[3]['excerpt'] = "Duis quis ipsum vitae dolor ornare faucibus et at magna.";
	$person[3]['title'] = "Toddler/Infant Program";
	if (I3D_Framework::$teamMemberPhotos == "kindercare") {
		$person[3]['taxonomy'] = array("i3d-team-member-department" => "Toddler/Infant");
		$person[3]['taxonomy'] = "Toddler/Infant";
	} 


	$person[4]['name'] = "Beverly Fraser";
	$person[4]['bio'] = "Aenean ac quam pulvinar, eleifend lacus quis, volutpat augue. Ut auctor, urna interdum vestibulum condimentum, arcu eros porta metus, vel aliquam erat augue vitae velit. Ut quis arcu commodo, viverra erat quis, aliquam ante. Nullam tincidunt justo vitae justo semper luctus. ";
	$person[4]['excerpt'] = "Aenean ac quam pulvinar, eleifend lacus quis, volutpat augue. ";
	$person[4]['title'] = "Toddler/Infant Program";
	if (I3D_Framework::$teamMemberPhotos == "kindercare") {
		$person[4]['taxonomy'] = "Toddler/Infant";
	} 


	$person[5]['name'] = "Michael Best";
	$person[5]['bio'] = "Cras pulvinar orci quis purus dapibus iaculis. Phasellus rutrum erat nisl, a venenatis nunc gravida luctus. Duis ac dolor vel velit pellentesque consectetur non egestas sem. Nulla placerat euismod leo a venenatis. Curabitur imperdiet est ut elit pulvinar, eget scelerisque diam vehicula. ";
	$person[5]['excerpt'] = "Cras pulvinar orci quis purus dapibus iaculis.";
	$person[5]['title'] = "Pre-School";
	if (I3D_Framework::$teamMemberPhotos == "kindercare") {
		$person[5]['taxonomy'] = "Pre-School";
	} 


	$person[6]['name'] = "Sarah Butterfield";
	$person[6]['bio'] = "Aenean ac quam pulvinar, eleifend lacus quis, volutpat augue. Ut auctor, urna interdum vestibulum condimentum, arcu eros porta metus, vel aliquam erat augue vitae velit. Ut quis arcu commodo, viverra erat quis, aliquam ante. Nullam tincidunt justo vitae justo semper luctus. ";
	$person[6]['excerpt'] = "Aenean ac quam pulvinar, eleifend lacus quis, volutpat augue. Ut auctor, ";
	$person[6]['title'] = "Pre-School";
	if (I3D_Framework::$teamMemberPhotos == "kindercare") {
		$person[6]['taxonomy'] = "Pre-School";
	} 


	$person[7]['name'] = "James Johnson";
	$person[7]['bio'] = "Fusce tempor ligula in nulla convallis, ut interdum tellus consequat. Proin cursus enim at neque placerat, at molestie tellus auctor. Nam aliquam tortor a quam pulvinar fermentum. ";
	$person[7]['excerpt'] = "Fusce tempor ligula in nulla convallis, ut interdum tellus consequat.";
	$person[7]['title'] = "Pre-School";
	if (I3D_Framework::$teamMemberPhotos == "kindercare") {
		$person[7]['taxonomy'] = "Pre-School";
	} 


	$person[8]['name'] = "Cindy Lovely";
	$person[8]['bio'] 	= "Aenean ac quam pulvinar, eleifend lacus quis, volutpat augue. Ut auctor, urna interdum vestibulum condimentum, arcu eros porta metus, vel aliquam erat augue vitae velit. Ut quis arcu commodo, viverra erat quis, aliquam ante. Nullam tincidunt justo vitae justo semper luctus. ";
	$person[8]['excerpt'] = "Aenean ac quam pulvinar, eleifend lacus quis, volutpat augue.";
	$person[8]['title'] = "Manager";
	if (I3D_Framework::$teamMemberPhotos == "kindercare") {
		$person[8]['taxonomy'] = "Administration";
	}
	

	 self::debug("Have ".$published_posts." Team Members existing");
      if ($published_posts > 0) {
	  	self::debug("Exiting Early -- No new Team Members created");
	  } else {
		// contact form box
		
		if (I3D_Framework::$teamMemberPhotos == "holder") {
			$start = 6;
		} else {
			$start = 8;
		}
		for ($i = $start; $i > 0; $i--) {
			global $user_ID;
			$new_post = array(
			'post_title' => $person["$i"]["name"],
			'post_content' => $person["$i"]["bio"],
			'post_status' => 'publish',
			'post_date' => date('Y-m-d H:i:s'),
			'post_author' => $user_ID,
			'post_excerpt' => $person["$i"]["excerpt"],
			'post_type' => 'i3d-team-member',
			'comment_status' => 'closed',
			'ping_status' => 'closed',
			'post_category' => array(0)
			);
			$post_id = wp_insert_post($new_post);
			
			if (I3D_Framework::$teamMemberPhotos == "holder") {
				$filename = get_template_directory_uri() ."/Site/themed-images/placeholders/640x480/holder{$i}-640x480.jpg";
			} else if (I3D_Framework::$teamMemberPhotos == "kindercare") {
				$filename = get_template_directory_uri() ."/Library/components/isotope-portfolio/images/teacher".(9-$i).".jpg";				
			    update_post_meta( $post_id, 'team_member_data', 	array(array("label" => "Title",
																				"value" => $person["$i"]["title"])) );
			    update_post_meta( $post_id, 'team_member_contact_points', 	array(array("type" => "twitter",
																						"color" => "blue",
																						"value" => "http://twitter.com/somename"),
																				  array("type" => "facebook",
																						"color" => "green",
																						"value" => "http://facebook.com/somename"),
																				  array("type" => "google",
																						"color" => "purple",
																						"value" => "http://plus.google.com/somename"),
																				  array("type" => "blog",
																						"color" => "orange",
																						"value" => "http://somesite.com/someblog"),
 																				  array("type" => "email",
																						"color" => "white",
																						"value" => "mailto:someone@somesite.com"),																				  
																				  ));
				wp_set_object_terms($post_id, $person["$i"]["taxonomy"], "i3d-team-member-department");
			} else {
				$filename = get_template_directory_uri() ."/Site/themed-images/placeholders/240x180/holder{$i}-240x180.jpg";	
			}
			$description = $person["$i"]["name"];
						
			# upload / resize / crop image (to WP images folder)
			media_sideload_image($filename,$post_id,$description);
			
			$last_attachment = $wpdb->get_row($query = "SELECT * FROM {$wpdb->prefix}posts ORDER BY ID DESC LIMIT 1", ARRAY_A);
			$attachment_id = $last_attachment['ID'];
			
			# set featured image
			add_post_meta($post_id, '_thumbnail_id', $attachment_id);		
						
		}
		
		
	  }
	  
	  	  self::debug("Done init_team_members()");

	
	}



public static function init_testimonials() {
	require_once(ABSPATH . 'wp-admin/includes/media.php');
	require_once(ABSPATH . 'wp-admin/includes/file.php');
	require_once(ABSPATH . 'wp-admin/includes/image.php');

self::debug("In init_testimonials()");
	  global $wpdb;

	
	$wpq = array("post_type" => "i3d-testimonial");
	
	$count_posts = wp_count_posts("i3d-testimonial");
	$published_posts = $count_posts->publish;
	
	
	$person = I3D_Framework::$defaultTestimonials;
	if (sizeof($person) == 0) {
	
		$person[1]['name'] = "Mae West";
		$person[1]['bio'] = "You only live once, but if you do it right, once is enough!";
	
		$person[2]['name'] = "Elbert Hubbard";
		$person[2]['bio'] = "A friend is someone who knows all about you and still loves you.";
	
		$person[3]['name'] = "Maya Angelou";
		$person[3]['bio'] = "I've learned that people will forget what you said, people will forget what you did, but people will never forget how you made them feel.";
		
		$person[4]['name'] = "Ralph Waldo Emerson";
		$person[4]['bio'] = "To be yourself in a world that is constantly trying to make you something else is the greatest accomplishment.";
	}
	 
	 self::debug("Have ".$published_posts." testimonials existing");
      if ($published_posts > 0) {
	  	self::debug("Exiting Early -- No new testimonials created");
	  } else {
		// contact form box
		for ($i = 4; $i > 0; $i--) {
			global $user_ID;
			$new_post = array(
			'post_title' => $person["$i"]["name"],
			'post_content' => $person["$i"]["bio"],
			'post_status' => 'publish',
			'post_date' => date('Y-m-d H:i:s'),
			'post_author' => $user_ID,
			'post_type' => 'i3d-testimonial',
			'comment_status' => 'closed',
			'ping_status' => 'closed',
			'post_category' => array(0)
			);
			$post_id = wp_insert_post($new_post);
		
		    if (@$person["$i"]['title'] != "") {
				update_post_meta( $post_id, 'quote_title', $person["$i"]['title'] );
				update_post_meta( $post_id, 'author_name', $person["$i"]['author'] );
				update_post_meta( $post_id, 'author_title', $person["$i"]['author_title'] );
			}
		    if (@$person["$i"]['image'] != "") {
				@media_sideload_image($person["$i"]['image'],	$post_id, $person['author']);
			
				$last_attachment = $wpdb->get_row($query = "SELECT * FROM {$wpdb->prefix}posts ORDER BY ID DESC LIMIT 1", ARRAY_A);
				$attachment_id = $last_attachment['ID'];
			
				# set featured image
				add_post_meta($post_id, '_thumbnail_id', $attachment_id);		
				
			}
				
		}
		
		
		
	  }
	  
	  	  self::debug("Done init_testimonials()");

	
	}	
	
public static function init_portfolio_items() {
	require_once(ABSPATH . 'wp-admin/includes/media.php');
	require_once(ABSPATH . 'wp-admin/includes/file.php');
	require_once(ABSPATH . 'wp-admin/includes/image.php');
	global $wpdb;
	  self::debug("In init_portfolio_items()");
	  if (I3D_Framework::$isotopePortfolioVersion == 0) {
		self::debug("Existing as this theme does not support portfolio");
		return;
		//print "x";
	  }

	
	$wpq = array("post_type" => "i3d-portfolio");
	
	$count_posts     = wp_count_posts("i3d-portfolio-item");
	$published_posts = @$count_posts->publish;
	
	$item = array();
	$item[1]['name'] 		= "Cave Lake";
	$item[1]['contents'] 	= "This is the Example Portfolio (Cave Lake) long description line.  This description shows up on the portfolio item details page.";
	$item[1]['excerpt'] 	= "This is the Example Portfolio (Cave Lake) excerpt.";
	$item[1]['terms'] 		= "water,lake";

	$item[2]['name'] 		= "Oceanside";
	$item[2]['contents'] 	= "This is the Example Portfolio Item (Oceanside) long description line.  This description shows up on the portfolio item details page.";
	$item[2]['excerpt'] 	= "This is the Example Portfolio Item (Oceanside) excerpt.";
	$item[2]['terms'] 		= "water,ocean";

	$item[3]['name'] 		= "Canyon 1";
	$item[3]['contents'] 	= "This is the Example Portfolio Item (Canyon 1) long description line.  This description shows up on the portfolio item details page.";
	$item[3]['excerpt'] 	= "This is the Example Portfolio Item (Canyon 1) excerpt.";
	$item[3]['terms'] 		= "scenic";

	$item[4]['name'] 		= "Lakeside";
	$item[4]['contents'] 	= "This is the Example Portfolio Item (Lakeside) long description line.  This description shows up on the portfolio item details page.";
	$item[4]['excerpt'] 	= "This is the Example Portfolio Item (Lakeside) excerpt.";
	$item[4]['terms'] 		= "water,lake";

	$item[5]['name'] 		= "Foggy Shore";
	$item[5]['contents'] 	= "This is the Example Portfolio Item (Foggy Shore) long description line.  This description shows up on the portfolio item details page.";
	$item[5]['excerpt'] 	= "This is the Example Portfolio Item (Foggy Shore) excerpt.";
	$item[5]['terms'] 		= "water,ocean";

	$item[6]['name'] 		= "Waterfall 1";
	$item[6]['contents'] 	= "This is the Example Portfolio Item (Waterfall 1) long description line.  This description shows up on the portfolio item details page.";
	$item[6]['excerpt'] 	= "This is the Example Portfolio Item (Waterfall 1) excerpt.";
	$item[6]['terms'] 		= "water,river";

	$item[7]['name'] 		= "Waterfall 2";
	$item[7]['contents'] 	= "This is the Example Portfolio Item (Watefall 2) long description line.  This description shows up on the portfolio item details page.";
	$item[7]['excerpt'] 	= "This is the Example Portfolio Item (Watefall 2) excerpt.";
	$item[7]['terms'] 		= "water,river";

	$item[8]['name'] 		= "Canyon 2";
	$item[8]['contents'] 	= "This is the Example Portfolio Item (Canyon 2) long description line.  This description shows up on the portfolio item details page.";
	$item[8]['excerpt'] 	= "This is the Example Portfolio Item (Canyon 2) excerpt.";
	$item[8]['terms'] 		= "scenic";

	$item[9]['name'] 		= "The Shallows";
	$item[9]['contents'] 	= "This is the Example Portfolio Item (The Shallows) long description line.  This description shows up on the portfolio item details page.";
	$item[9]['excerpt'] 	= "This is the Example Portfolio Item (The Shallows) excerpt.";
	$item[9]['terms'] 		= array("water","ocean");

	$item[10]['name'] 		= "River Water";
	$item[10]['contents'] 	= "This is the Example Portfolio Item (River Water) long description line.  This description shows up on the portfolio item details page.";
	$item[10]['excerpt'] 	= "This is the Example Portfolio Item (River Water) excerpt.";
	$item[10]['terms'] 		= "water, river";



	 self::debug("Have ".$published_posts." portfolio items existing");
      if ($published_posts > 0 ) {
	  	self::debug("Exiting Early -- No new portfolio items created");
	  } else {
	$water_term = term_exists( 'water', 'i3d-portfolio' ); // array is returned if taxonomy term exists
	//var_dump($water_term);
	
	if (!is_array($water_term)) {		
		$water_term = wp_insert_term(
		  'Water', // the term 
		  'i3d-portfolio', // the taxonomy
		  array(
			'description'=> 'Water Images',
			'slug' => 'water',
			'parent'=> 0
		  )
		);
		//var_dump($water_terms);
	}
	//exit;
	$river_term = term_exists( 'river', 'i3d-portfolio' ); // array is returned if taxonomy term exists
	if (!is_array($river_term)) {
		$river_term = wp_insert_term(
		  'River', // the term 
		  'i3d-portfolio', // the taxonomy
		  array(
			'description'=> 'River Images',
			'slug' => 'river',
			'parent'=> 0
		  )
		);
	}


	$scenic_term = term_exists( 'scenic', 'i3d-portfolio' ); // array is returned if taxonomy term exists
	if (!is_array($scenic_term)) {
		$river_term = wp_insert_term(
		  'Scenic', // the term 
		  'i3d-portfolio', // the taxonomy
		  array(
			'description'=> 'Scenic Images',
			'slug' => 'scenic',
			'parent'=> 0
		  )
		);
	}

	$ocean_term = term_exists( 'ocean', 'i3d-portfolio' ); // array is returned if taxonomy term exists
	if (!is_array($ocean_term)) {
		$ocean_term = wp_insert_term(
		  'Ocean', // the term 
		  'i3d-portfolio', // the taxonomy
		  array(
			'description'=> 'Ocean Images',
			'slug' => 'ocean',
			'parent'=> 0
		  )
		);		
	}

	$lake_term = term_exists( 'lake', 'i3d-portfolio' ); // array is returned if taxonomy term exists
	if (!is_array($lake_term)) {
		$lake_term = wp_insert_term(
		  'Lake', // the term 
		  'i3d-portfolio', // the taxonomy
		  array(
			'description'=> 'Lake Images',
			'slug' => 'lake',
			'parent'=> 0
		  )
		);			

	}


		// contact form box
		for ($i = 10; $i > 0; $i--) {
			global $user_ID;
			$new_post = array(
			'post_title' => $item["$i"]["name"],
			'post_content' => $item["$i"]["contents"],
			'post_excerpt' => $item["$i"]["excerpt"],
			'post_status' => 'publish',
			'post_date' => date('Y-m-d H:i:s'),
			'post_author' => $user_ID,
			'post_type' => 'i3d-portfolio-item',
			'comment_status' => 'closed',
			'ping_status' => 'closed',
			'post_category' => array(0)
			);
			$post_id = wp_insert_post($new_post);
			wp_set_post_terms( $post_id, $item["$i"]['terms'], "i3d-portfolio");
			$filename = get_template_directory_uri() ."/Library/sliders/supersized-slideshow/images/supersized{$i}.jpg";
			$description = $item["$i"]["name"];
						
			# upload / resize / crop image (to WP images folder)
			media_sideload_image($filename, $post_id, $description);
			
			$last_attachment = $wpdb->get_row($query = "SELECT * FROM {$wpdb->prefix}posts ORDER BY ID DESC LIMIT 1", ARRAY_A);
			$attachment_id = $last_attachment['ID'];
			
			# set featured image
			add_post_meta($post_id, '_thumbnail_id', $attachment_id);					
		}
		
		
	  }
	  
	  	  self::debug("Done init_portfolio_items()");

	
	}		
	/*
	function init_faqs() {
		$faqOptions = get_option('luckymarble_faqs');
		if (!is_array($faqOptions[1]) || sizeof ($faqOptions[1]) == 0) {
			$faqOptions = array();

			$faqOptions[] = array('question' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.','answer' => 'Sed est lorem, ullamcorper sit amet, fringilla porttitor, convallis eget, dolor. Nulla enim enim, fringilla eget, semper eget, pulvinar ut, libero.');
			$faqOptions[] = array('question' => 'Suspendisse id velit.','answer' => 'Morbi sit amet tortor. Vivamus pharetra sollicitudin enim.');
			$faqOptions[] = array('question' => 'Donec eget urna sit amet metus dapibus placerat.','answer' => 'Cras luctus lorem in diam. Praesent urna diam, condimentum quis, interdum a, posuere at, lectus. Maecenas nec nisl.');

		  update_option('luckymarble_faqs', array(1 => $faqOptions));
		}

	}
	*/

	public static function init_catalog() {
		$productCatalog = get_option('luckymarble_product_catalog');

		if (!is_array($productCatalog[1]) || sizeof ($productCatalog[1]) == 0) {
			$productCatalog = array();
			$productCatalog[] = array('id' => 'default', 'image' => '','name' => 'Example Product','price' => '$49.99','description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.','button_code' => '<input type="button" value="Buy Now" />');
			$productCatalog[] = array('id' => 'default', 'image' => '','name' => 'Example Product','price' => '$49.99','description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.','button_code' => '<input type="button" value="Buy Now" />');
			$productCatalog[] = array('id' => 'default', 'image' => '','name' => 'Example Product','price' => '$49.99','description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.','button_code' => '<input type="button" value="Buy Now" />');
			$productCatalog[] = array('id' => 'default', 'image' => '','name' => 'Example Product','price' => '$49.99','description' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.','button_code' => '<input type="button" value="Buy Now" />');

		}

		update_option('luckymarble_product_catalog', array(1 => $productCatalog));
	}

	public static function register() {
		I3D_Framework::init_sideBars();
		I3D_Framework::register_sidebars();
		I3D_Framework::init_menus();
		
		if (function_exists('register_nav_menus')) {
			I3D_Framework::register_menus();
			add_filter('wp_nav_menu',array('I3D_Framework', 'correct_nav_menu'));
		}
		$woocommerce = true;
		if (self::hasExtension("woocommerce")) {
			if ($_GET['wc-installed'] == 'true') {
				self::init_woocommerce();
			}
			//add_action( array('WC_Install', 'creat_pages'), array('I3D_Framework', 'init_woocommerce'), 10);	
			//add_action('woocommerce_loaded', array('I3D_Framework', 'init_woocommerce'), 10);
			add_action('woocommerce_init', array('I3D_Framework', 'init_woocommerce'), 10);
			add_theme_support( 'woocommerce' );		
		}
		if (self::hasExtension("wpecommerce")) {
			add_action('wpsc_loaded', array('I3D_Framework', 'init_wpecommerce'), 10);
			add_action('wpsc_init', array('I3D_Framework', 'init_wpecommerce'), 10);
			
		}
	}
	
	public static function assert_extensions() {
		global $page_id;
		if (function_exists('is_woocommerce')) {
	  		if (is_woocommerce()) {
		  		if (I3D_Framework::hasExtension("woocommerce")) {
					$page_id = wc_get_page_id("shop");
		  		} else { 
		    		I3D_Framework::woocommerce_not_supported();
		  		}
	 		 }	  
		} 	
		if (function_exists('wpsc_core_constants')) {
			
	  		
		  		if (!I3D_Framework::hasExtension("wpecommerce")) {
					$products_page_id = wpsc_get_the_post_id_by_shortcode( '[productspage]' );
					if ($page_id == $products_page_id) {
		    		  I3D_Framework::wpecommerce_not_supported();
						
					}
					remove_filter( "the_content", "wpsc_products_page", 1 );

					
					//add_ shortcode("productspage", array('I3D_Framework', 'wpecommerce_not_supported2'));
				}
		} 			
	}
	
	public static function woocommerce_not_supported() {
	  ob_end_flush();
	  $themeInfo = wp_get_theme();
	  get_header();
	  print "<div class='alert alert-info container text-center' style='margin-top: 20%;'>The WooCommerce plugin is not supported in this version of {$themeInfo['Name']}. Please <a href='http://my.luckymarble.com/'>upgrade to the pro version</a> via your i3dTHEMES account to enable this extension for {$themeInfo['Name']}.</div>";
	  get_footer();
	  exit;
	}
	
	public static function wpecommerce_not_supported() {
	  ob_end_flush();
	  $themeInfo = wp_get_theme();
	  get_header();
	  print "<div class='alert alert-info container text-center' style='margin-top: 20%;'>The WP eCommerce plugin is not supported in this version of {$themeInfo['Name']}. Please <a href='http://my.luckymarble.com/'>upgrade to the pro version</a> via your i3dTHEMES account to enable this extension for {$themeInfo['Name']}.</div>";
	  get_footer();
	  exit;
	}

	public static function wpecommerce_not_supported2() {
	  $themeInfo = wp_get_theme();

	  return "<div class='alert alert-info text-center' >The WP eCommerce plugin is not supported in this version of {$themeInfo['Name']}. Please <a href='http://my.luckymarble.com/'>upgrade to the pro version</a> via your i3dTHEMES account to enable this extension for {$themeInfo['Name']}.</div>";
	}


	public static function register_menus() {
	   $lmMenus = get_option('i3d_menu_options');

	   if (is_array($lmMenus)) { 
		//print "regiser_menus";
		//var_dump($lmMenus);
		register_nav_menus($lmMenus);
	   }
	}

	public static function correct_nav_menu($content) {
		//remove surrounding div from nav menu component
		return preg_replace('/<div class=".*?">(.*?)<\/div>/si', '$1', $content);
	}


	public static function register_sidebars() {
		
	  global $lmWidgetWrapConfig;
	  global $sideBoxContent_before, $sideBoxContent_after, $infoBoxContent_before, $infoBoxContent_after; // used for framework >=2.6
	  $sidebars = get_option('i3d_sidebar_options');
	  
	  // used to determine which wrappers to use for each sidebar
	  $sidebarsStyles = get_option('i3d_sidebar_options_styles');
      $_before = "";
	  $_after = "";
		if (sizeof($sidebars) > 0 && is_array($sidebars)) {
			foreach ($sidebars as $sidebarID => $sidebarName) {
				$sidebarName = str_replace("Sidebar", "Widget Area", $sidebarName);
				
				// as of framework 2.5 Orion, we can now define custom wrap styles for different sidebars, so that the end user
				// can create their own sidebars and also associate a wrapping style.
				if (is_array($sidebarsStyles) && sizeof ($sidebarsStyles) > 0) {
					if (!array_key_exists($sidebarID, $sidebarsStyles)) {
						$sidebarsStyles["{$sidebarID}"] = "";
					}
					$bwc = $sidebarsStyles["{$sidebarID}"].'_before';

					$lmWidgetWrapConfig["{$sidebarID}"]['before_widget'] = ${$bwc};
					$awc = $sidebarsStyles["$sidebarID"].'_after';
		
					$lmWidgetWrapConfig["{$sidebarID}"]['after_widget'] = ${$awc};
					
					$lmWidgetWrapConfig["{$sidebarID}"]['before_title'] = "<h3>";
					$lmWidgetWrapConfig["{$sidebarID}"]['after_title'] = "</h3>";
				} else {
					if (@!array_key_exists($sidebarID, $lmWidgetWrapConfig)) {
					  $lmWidgetWrapConfig["{$sidebarID}"]['before_widget'] = "";
					  $lmWidgetWrapConfig["{$sidebarID}"]['after_widget'] = "";
					  $lmWidgetWrapConfig["{$sidebarID}"]['before_title'] = "";
					  $lmWidgetWrapConfig["{$sidebarID}"]['after_title'] = "";
					}
				}
				register_sidebar( array(
					'name' => $sidebarName,
					'id' => $sidebarID,
					'before_widget' => $lmWidgetWrapConfig["{$sidebarID}"]['before_widget'],
					'after_widget'  => $lmWidgetWrapConfig["{$sidebarID}"]['after_widget'],
					'before_title'  => $lmWidgetWrapConfig["{$sidebarID}"]['before_title'],
					'after_title'   => $lmWidgetWrapConfig["{$sidebarID}"]['after_title'],
				) );
			}
		}
		
		// get widgets for the unused widgets sidebar
		$sidebarWidgets = wp_get_sidebars_widgets();
		//print "<pre>";
		//var_dump($sidebarWidgets);
		////print "</pre>";
		//exit;
		// programmatically remove them
		if (array_key_exists("i3d-unused", $sidebarWidgets) && is_array($sidebarWidgets['i3d-unused'])) {
			foreach ($sidebarWidgets['i3d-unused'] as $widget) {
				wp_unregister_sidebar_widget($widget);
			}
			unregister_sidebar("i3d-unused");
		}
	}


	public static function init_widgets() {
       self::debug("In init_widgets()", true);
		
	  global $lmFrameworkVersion;
	  
	  // if the blog is not yet installed, we should not continue
	  
	  if (!is_blog_installed()) return;


      // default widgets
	  //register_widget('Luckymarble_Widget_FeaturePage');
	//  register_widget('Luckymarble_Widget_I3DAffiliate');
		
		
		register_widget('I3D_Widget_ColumnBreak');
		//register_widget('I3D_Widget_RowBreak');
		register_widget('I3D_Widget_Logo');
		register_widget('I3D_Widget_PhoneNumber');
		register_widget('I3D_Widget_SEOTags');
		register_widget('I3D_Widget_Image');
	 	register_widget('I3D_Widget_HTMLBox'); // a refactored version of the earlier version HTMLBox
	 	register_widget('I3D_Widget_Menu');
	 	register_widget('I3D_Widget_ContentRegion');
		if (!is_admin()) {
	 		register_widget('I3D_Widget_SidebarRegion');
	 		register_widget('I3D_Widget_PhotoSlideshow');
	 		register_widget('I3D_Widget_MapBanner');
			if (I3D_Framework::$contactPanelVersion > 0) { 		
	 			register_widget('I3D_Widget_ContactPanel');
			}
		}
	 	register_widget('I3D_Widget_InfoBox');
	  	register_widget('I3D_Widget_TwitterFeed');
	  	register_widget('I3D_Widget_SocialMediaIconShortcuts');
		register_widget('I3D_Widget_FooterContactBox');
		//register_widget('I3D_Widget_FooterSocialBox');
		register_widget('I3D_Widget_SearchForm');
		register_widget('I3D_Widget_TestimonialRotator');
		if (sizeof(self::$registerWidgets) == 0 || (sizeof(self::$registerWidgets) > 0 && in_array('I3D_Widget_SliderRegion', self::$registerWidgets))) {
			register_widget('I3D_Widget_SliderRegion');
		}
		if (sizeof(self::$registerWidgets) == 0 || (sizeof(self::$registerWidgets) > 0 &&  in_array('I3D_Widget_BackToTop', self::$registerWidgets))) {
		  register_widget('I3D_Widget_BackToTop');
		}
		if (sizeof(self::$registerWidgets) == 0 || (sizeof(self::$registerWidgets) > 0 &&  in_array('I3D_Widget_FontSizer', self::$registerWidgets))) {
			register_widget('I3D_Widget_FontSizer');
		}
	    register_widget('I3D_Widget_SuperSummary');
	    
		register_widget('I3D_Widget_ContactForm');
		if (sizeof(self::$registerWidgets) == 0 || (sizeof(self::$registerWidgets) > 0 &&  in_array('I3D_Widget_ContactFormMenu', self::$registerWidgets))) {
	   	 register_widget('I3D_Widget_ContactFormMenu');
		}
	    register_widget('I3D_Widget_Breadcrumb');
		if (I3D_Framework::$callToActionVersion > 0) { 
		  register_widget('I3D_Widget_CallToAction');
		}
		if (sizeof(self::$registerWidgets) == 0 || (sizeof(self::$registerWidgets) > 0 &&  in_array('I3D_Widget_GoogleMap', self::$registerWidgets))) {
			register_widget('I3D_Widget_GoogleMap');
		}

		if (sizeof(self::$registerWidgets) == 0 || (sizeof(self::$registerWidgets) > 0 &&  in_array('I3D_Widget_ImageCarousel', self::$registerWidgets))) {
			register_widget('I3D_Widget_ImageCarousel');
		}

		if (I3D_Framework::$infoBoxSliderVersion > 0) { 
		  register_widget('I3D_Widget_InfoBoxSlider');
		}
		register_widget('I3D_Widget_ContentPanelGroup');
		
		if (I3D_Framework::$animatedLogoVersion > 0) { 
		  register_widget('I3D_Widget_AnimatedLogo');
		}
		if (I3D_Framework::$isotopePortfolioVersion > 0) {
		  register_widget('I3D_Widget_Portfolio');
		}
		
		if (I3D_Framework::$focalBoxVersion > 0) {
		  register_widget('I3D_Widget_FocalBox');
		}
		register_widget('I3D_Widget_Flickr');
		register_widget('I3D_Widget_ProgressBar');
		if (I3D_Framework::$counterBoxVersion > 0) {
			register_widget('I3D_Widget_CounterBox');
		
		}
		
	self::debug("Done init_widgets()");

	}

    public static function get_image_masks() {
		$masks = array();
		$masks['circle']['name'] 		= __('Circle', "i3d-framework");	
		$masks['circle-blur']['name'] 	= __('Circle (Blurred)', "i3d-framework");	
		
		$masks['diamond']['name'] 		= __('Diamond', "i3d-framework");	
		
		$masks['pentagon']['name'] 		= __('Pentagon', "i3d-framework");	
		$masks['hexagon']['name'] 		= __('Hexagon', "i3d-framework");	
		$masks['octagon']['name'] 		= __('Octagon', "i3d-framework");	
		
		$masks['star']['name'] 			= __('Star', "i3d-framework");	
		$masks['star-5']['name'] 		= __('Star (5 Points)', "i3d-framework");	
		$masks['star-6']['name'] 		= __('Star (6 Points)', "i3d-framework");	
		$masks['star-8']['name'] 		= __('Star (8 Points)', "i3d-framework");	

		$masks['heart']['name'] 		= __('Heart', "i3d-framework");	
		$masks['heart-2']['name'] 		= __('Heart (Styled)', "i3d-framework");	

		$masks['flower']['name'] 		= __('Flower', "i3d-framework");	

		$masks['sun']['name'] 			= __('Sun', "i3d-framework");	



		return $masks;
	}
	
	public static function render_active_background_styles() {
		$activeBackgrounds = (array)get_option('i3d_active_backgrounds');
		global $pageTemplate;
		$js = "";

		foreach ($activeBackgrounds as $id => $activeBackground) {
			echo ".{$id} {";
			if ($activeBackground['background_type'] == "image") {
				$currentImage = @$activeBackground['resources']["image"];
				if ($currentImage != "" && is_numeric($currentImage)) {
					$metaData = get_post_meta($currentImage, '_wp_attachment_metadata', true); 
					$fileName = site_url().'/wp-content/uploads/'.$metaData['file']; 
				} else {
					$fileName = "";
				}
				
			  	echo " background: url({$fileName}); background-repeat: no-repeat; background-position: center center;  ";	
				if (@$activeBackground['parallaxing'] == "vertical-same-direction" || @$activeBackground['parallaxing'] == "vertical-opposite-direction") {
				  echo "background-size: cover;";	
				} else {
				  echo "background-size: 150% auto;";	
					
				}
			  	echo " padding-top: 40px; padding-bottom: 0px; ";	
				
				
			} else if ($activeBackground['background_type'] == "video") {
				echo "position: relative;  } \n";
							echo ".{$id} > .container { margin-top: 40px; ";

			} else if ($activeBackground['background_type'] == "map"  && $pageTemplate != "contact") {
				//$page_content = ob_get_contents();
				
				if (strstr($page_contents, $id) !== false) {
					//echo " have: it; \n";
				} else {
				//	echo "dont have: it; \n";
				}
				echo "position: relative;  } \n";
				echo ".{$id} > .container { padding-top: 40px; ";
			//	wp_enqueue_script( 'aquila-google-maps-alt', "https://maps.googleapis.com/maps/api/js?key=AIzaSyASm3CwaK9qtcZEWYa-iQwHaGi3gcosAJc&sensor=false", array('jquery'), '1.0', true);
				//wp_enqueue_script( 'aquila-google-maps-alt', "https://maps.googleapis.com/maps/api/js?sensor=false", array('jquery'), '1.0', true);
		  	// changed nov 30, as the sensor is not required
			//	wp_enqueue_script( 'aquila-google-maps',  "https://maps.google.com/maps/api/js?v=3.exp&amp;sensor=false&amp;language=en&libraries=common,util,geocoder,map,overlay,onion,marker,infowindow,controls", array('jquery'), '1.0' );
		  		//wp_enqueue_script( 'aquila-google-maps',  "https://maps.google.com/maps/api/js?v=3.exp&amp;language=en&libraries=common,util,geocoder,map,overlay,onion,marker,infowindow,controls", array('jquery'), '1.0' );
			
			//wp_register_script( 'aquila-google-maps',  "//maps.google.com/maps/api/js?v=3.exp&amp;language=en&libraries=common,util,geocoder,map,overlay,onion,marker,infowindow,controls", array('jquery'), '1.0', true );
			// changed July 14, 2016 as google now requires an api key
				wp_register_script( 'aquila-google-maps',  "//maps.google.com/maps/api/js?key=AIzaSyBrB_tWpTV_xOg6khHXLwIRio8Et48u-r8&v=3.exp&amp;language=en&libraries=common,util,geocoder,map,overlay,onion,marker,infowindow,controls", array('jquery'), '1.0', true );
				wp_register_script( 'aquila-gomap', 		get_stylesheet_directory_uri()."/Site/javascript/gomap/jquery.gomap-1.3.2.min.js", array('jquery', 'aquila-google-maps'), '1.0' , true);
				
				wp_enqueue_script( 'aquila-google-maps');
				wp_enqueue_script( 'aquila-gomap');

			  
			}
			echo "}";
		}

	}

	public static function render_active_background_script() {
		$activeBackgrounds = get_option('i3d_active_backgrounds');
		global $pageTemplate;
		
		if (!is_array($activeBackgrounds)) {
			$activeBackgrounds = array();
		}
		$js = "";
		foreach ($activeBackgrounds as $id => $activeBackground) {
			$random = rand();
			
			
			echo "jQuery(document).ready(function() {\n";
			echo	"jQuery('.{$id}').each(function() {\n";
													
			$dataBottomTop = "";
			$dataTopBottom = "";
			$dataTop 	   = "";
			$dataBottom = "";
			$dataCenter = "";
									
			if (@$activeBackground['parallaxing'] == "vertical-same-direction") {
				$dataBottomTop = "background-position: 0px 0px;";
			    $dataCenter 	= "background-position: 0px -300px;";
				$dataTopBottom = "background-position: 0px -600px;";

			} else if (@$activeBackground['parallaxing'] == "vertical-opposite-direction") {
				$dataBottomTop = "background-position: 0px -600px;";
			    $dataCenter 	= "background-position: 0px -300px;";
				$dataTopBottom = "background-position: 0 0px;";
				
			} else if (@$activeBackground['parallaxing'] == "horizontal-left-to-right") {
				$dataBottomTop = "background-position: -600px 0px;";
			    $dataCenter 	= "background-position: -300px 0px;";
				$dataTopBottom = "background-position: 0px 0px;";
				
			} else if (@$activeBackground['parallaxing'] == "horizontal-right-to-left") {
				$dataBottomTop = "background-position: 0px 0px;";
			    $dataCenter 	= "background-position: -300px 0px;";
				$dataTopBottom = "background-position: -600px 0px;";										
			}
				
			if (@$activeBackground['fade'] == "in") {
				$dataBottomTop .= "opacity: 0;";
				$dataCenter .= "opacity: 1;";										
				$dataTopBottom .= "opacity: 1;";										
				
			} else if (@$activeBackground['fade'] == "in-out") {
				$dataBottomTop .= "opacity: 0;";
				$dataCenter .= "opacity: 1;";										
				$dataTopBottom .= "opacity: 0;";										
				
			} else if (@$activeBackground['fade'] == "out") {
				
				$dataBottomTop .= "opacity: 1;";
				$dataCenter .= "opacity: 1;";										
				$dataTopBottom .= "opacity: 0;";										
			}
			?>
				jQuery(this).attr("data-bottom-top", "<?php echo $dataBottomTop; ?>");
				jQuery(this).attr("data-top-bottom", "<?php echo $dataTopBottom; ?>");
				<?php if ($dataCenter != "") { ?>
				jQuery(this).attr("data-center", "<?php echo $dataCenter; ?>");
				
				<?php } ?>
				
				
<?php		if (@$activeBackground['bordered'] == "1") { ?>
				  jQuery(this).addClass('section-bordered');	
	<?php			}
	
	if (@$activeBackground['cover'] != "") { ?>
				  jQuery(this).addClass('section-covered-<?php echo $activeBackground['cover']; ?>');	
	<?php			}
	       if ($activeBackground['background_type'] == "video") { ?>
		   
				jQuery(this).tubular({videoId: '<?php echo $activeBackground['resources']['video']; ?>'});
				<?php } 
				
				if ($activeBackground['background_type'] == "map" && $pageTemplate != "contact") { ?>
				mapid = "#map_<?php echo $id; ?>";
				jQuery(this).prepend("<div id='map_<?php echo $id; ?>' class='i3d-background-google-map'></div>");
				jQuery(this).find(mapid).height(jQuery(this).height());
				<?php } 

				
			//  	echo " background: url({$fileName}); background-repeat: no-repeat; background-position: center center; background-size: cover; ";	
			  //	echo " padding-top: 20px; padding-bottom: 40px; ";	
				
							if ($activeBackground['background_type'] == "map" && $pageTemplate != "contact") {

				?>init_map_<?php echo $id; ?>();
<?php
				}
						echo "  });	";
	
			echo "});";
			
			if ($activeBackground['background_type'] == "map" && $pageTemplate != "contact") {
			?>
			
            function init_map_<?php echo $id; ?>() {
			//alert("initing <?php echo $id; ?>");
                // Basic options for a simple Google Map
                // For more options see: https://developers.google.com/maps/documentation/javascript/reference#MapOptions
                var mapOptions = {
                    // How zoomed in you want the map to start at (always required)
                    zoom: <?php if (@$activeBackground['resources']['map']['zoom'] != "") { echo $activeBackground['resources']['map']['zoom']; } else { echo "12"; } ?>,
                    disableDefaultUI: true,
					zoomControl: false,
					scrollwheel: false, 

<?php if (@$activeBackground['resources']['map']['lat'] != "" && @$activeBackground['resources']['map']['lng'] != "") { ?>
                    // The latitude and longitude to center the map (always required)
					center: new google.maps.LatLng(<?php echo $activeBackground['resources']['map']['lat']; ?>, <?php echo $activeBackground['resources']['map']['lng']; ?>), 
<?php } ?>

                    // How you would like to style the map. 
                    // This is where you would paste any style found on Snazzy Maps.
                    styles: [	
                    {		featureType:'water',			stylers:[<?php 
																	 if (@$activeBackground['resources']['map']['water']['visibility'] == "colored") { 
																	 ?> {color:'<?php echo @$activeBackground['resources']['map']['water']['color']; ?>'},<?php 
																	 } else if (@$activeBackground['resources']['map']['water']['visibility'] == "hued") { 
																	 ?> {hue:'<?php echo @$activeBackground['resources']['map']['water']['color']; ?>'},<?php 
																	 } 
																	 if (@$activeBackground['resources']['map']['water']['lightness'] != "0" && @$activeBackground['resources']['map']['water']['lightness'] != "") { 
																	 ?> {lightness:'<?php echo @$activeBackground['resources']['map']['water']['lightness']; ?>'},<?php 
																	 }
																	 if (@$activeBackground['resources']['map']['water']['saturation'] != "0" && @$activeBackground['resources']['map']['water']['saturation'] != "") { 
																	 ?> {saturation:'<?php echo @$activeBackground['resources']['map']['water']['saturation']; ?>'},<?php 
																	 }																	 
																	 ?>{visibility:'on'}]	},
				   {		featureType:'landscape',		stylers:[<?php 
																	 if (@$activeBackground['resources']['map']['landscape']['visibility'] == "colored") { 
																	 ?> {color:'<?php echo @$activeBackground['resources']['map']['landscape']['color']; ?>'},<?php 
																	 } else if (@$activeBackground['resources']['map']['landscape']['visibility'] == "hued") { 
																	 ?> {hue:'<?php echo @$activeBackground['resources']['map']['landscape']['color']; ?>'},<?php 
																	 } 
																	 if (@$activeBackground['resources']['map']['landscape']['lightness'] != "0" && @$activeBackground['resources']['map']['landscape']['lightness'] != "") { 
																	 ?> {lightness:'<?php echo @$activeBackground['resources']['map']['landscape']['lightness']; ?>'},<?php 
																	 }
																	 if (@$activeBackground['resources']['map']['landscape']['saturation'] != "0" && @$activeBackground['resources']['map']['landscape']['saturation'] != "") { 
																	 ?> {saturation:'<?php echo @$activeBackground['resources']['map']['landscape']['saturation']; ?>'},<?php 
																	 }
																	 
																	 ?>{visibility:'on'}]	}, 
                    {		featureType:'road.highway',		stylers:[<?php 
																	 if (@$activeBackground['resources']['map']['road-highway']['visibility'] == "hued" || @$activeBackground['resources']['map']['road-highway']['visibility'] == "hued-simplified") { 
																	 ?> {hue:'<?php echo @$activeBackground['resources']['map']['road-highway']['color']; ?>'},<?php 
																	 }
																	 if (@$activeBackground['resources']['map']['road-highway']['lightness'] != "0" && @$activeBackground['resources']['map']['road-highway']['lightness'] != "") { 
																	 ?> {lightness:'<?php echo @$activeBackground['resources']['map']['road-highway']['lightness']; ?>'},<?php 
																	 }
																	 if (@$activeBackground['resources']['map']['road-highway']['saturation'] != "0" && @$activeBackground['resources']['map']['road-highway']['saturation'] != "") { 
																	 ?> {saturation:'<?php echo @$activeBackground['resources']['map']['road-highway']['saturation']; ?>'},<?php 
																	 }
																	 if (@$activeBackground['resources']['map']['road-highway']['visibility'] == "simplified" || @$activeBackground['resources']['map']['road-highway']['visibility'] == "hued-simplified") { 
																	 ?>{visibility:'simplified'} <?php 
																	 } else if (@$activeBackground['resources']['map']['road-highway']['visibility'] == "off") {
																	 ?> {visibility:'off'} <?php 
																	 } else { 
																	 ?>{visibility:'on'}<?php 
																	 } ?>]	},
                     {		featureType:'road.arterial',			
					 											stylers:[<?php 
																	 if (@$activeBackground['resources']['map']['road-arterial']['visibility'] == "hued" || @$activeBackground['resources']['map']['road-arterial']['visibility'] == "hued-simplified") { 
																	 ?> {hue:'<?php echo @$activeBackground['resources']['map']['road-arterial']['color']; ?>'},<?php 
																	 }
																	 if (@$activeBackground['resources']['map']['road-arterial']['lightness'] != "0" && @$activeBackground['resources']['map']['road-arterial']['lightness'] != "") { 
																	 ?> {lightness:'<?php echo @$activeBackground['resources']['map']['road-arterial']['lightness']; ?>'},<?php 
																	 }
																	 if (@$activeBackground['resources']['map']['road-arterial']['saturation'] != "0" && @$activeBackground['resources']['map']['road-arterial']['saturation'] != "") { 
																	 ?> {saturation:'<?php echo@ $activeBackground['resources']['map']['road-arterial']['saturation']; ?>'},<?php 
																	 }
																	 if (@$activeBackground['resources']['map']['road-arterial']['visibility'] == "simplified" || @$activeBackground['resources']['map']['road-arterial']['visibility'] == "hued-simplified") { 
																	 ?>{visibility:'simplified'} <?php 
																	 } else if (@$activeBackground['resources']['map']['road-arterial']['visibility'] == "off") {
																	 ?> {visibility:'off'} <?php 
																	 } else { 
																	 ?>{visibility:'on'}<?php 
																	 } ?>]	},
                    {		featureType:'road.local',		stylers:[<?php 
																	 if (@$activeBackground['resources']['map']['road-local']['visibility'] == "hued" || @$activeBackground['resources']['map']['road-local']['visibility'] == "hued-simplified") { 
																	 ?> {hue:'<?php echo @$activeBackground['resources']['map']['road-local']['color']; ?>'},<?php 
																	 }
																	 if (@$activeBackground['resources']['map']['road-local']['lightness'] != "0" && @$activeBackground['resources']['map']['road-local']['lightness'] != "") { 
																	 ?> {lightness:'<?php echo @$activeBackground['resources']['map']['road-local']['lightness']; ?>'},<?php 
																	 }
																	 if (@$activeBackground['resources']['map']['road-local']['saturation'] != "0" && @$activeBackground['resources']['map']['road-local']['saturation'] != "") { 
																	 ?> {saturation:'<?php echo @$activeBackground['resources']['map']['road-local']['saturation']; ?>'},<?php 
																	 }
																	 if (@$activeBackground['resources']['map']['road-local']['visibility'] == "simplified" || @$activeBackground['resources']['map']['road-local']['visibility'] == "hued-simplified") { 
																	 ?>{visibility:'simplified'} <?php 
																	 } else if (@$activeBackground['resources']['map']['road-local']['visibility'] == "off") {
																	 ?> {visibility:'off'} <?php 
																	 } else { 
																	 ?>{visibility:'on'}<?php 
																	 } ?>]	},																	 
                   <?php /*{		featureType:'road.arterial',				stylers:[{visibility:'on'}] }, */ ?>
                    {		featureType:'administrative',	elementType:'labels.text.fill',		stylers:[{color:'#004257'}]	},
                    {		featureType:'transit',			stylers:[{visibility:'off'}]	},
                    {		featureType:'poi',				stylers:[<?php 
																	 if (@$activeBackground['resources']['map']['poi']['visibility'] == "colored") { 
																	 ?> {color:'<?php echo @$activeBackground['resources']['map']['poi']['color']; ?>'},<?php 
																	 } else if (@$activeBackground['resources']['map']['poi']['visibility'] == "hued") { 
																	 ?> {hue:'<?php echo @$activeBackground['resources']['map']['poi']['color']; ?>'},<?php 
																	 } 
																	 if (@$activeBackground['resources']['map']['poi']['lightness'] != "0" && @$activeBackground['resources']['map']['poi']['lightness'] != "") { 
																	 ?> {lightness:'<?php echo @$activeBackground['resources']['map']['poi']['lightness']; ?>'},<?php 
																	 }
																	 if (@$activeBackground['resources']['map']['poi']['saturation'] != "0" && @$activeBackground['resources']['map']['poi']['saturation'] != "") { 
																	 ?> {saturation:'<?php echo @$activeBackground['resources']['map']['poi']['saturation']; ?>'},<?php 
																	 }																	 
																	if (@$activeBackground['resources']['map']['poi']['visibility'] == "off") {
																	 ?> {visibility:'off'} <?php 
																	 } else { 
																	 ?>{visibility:'on'}<?php 
																	 } ?>]	
															 }]
                };

                // Get the HTML DOM element that will contain your map 
                // We are using a div with id="map" seen below in the <body>
                
				var mapElement = document.getElementById('map_<?php echo $id; ?>');

                // Create the Google Map using out element and options defined above
                var map = new google.maps.Map(mapElement, mapOptions);
            }					
			<?php
		}
	}

	}

	public static function install_widgets() {
		global $wp_filter;
		global $wp_widget_factory;
		global $wp_registered_sidebars;
		global $defaultWidgets; // contains the default widgets to set up
		if (!is_array($defaultWidgets)) {
		  include("config-default.php");	
		  
		}
		//var_dump($defaultWidgets);
		self::debug("In install_widgets()");
		
		$resetSidebars = true;
		
		if (isset($_POST['config']) && $_POST['config'] == "requested") {
		  if (isset($_POST['widget_initialization']) && $_POST['widget_initialization'] == "keep") {
			 $resetSidebars = false;
		  } 
		}
		// note
		// if the previous framework version is not 4, then we
		// will want to wipe out the existing sidebar widgets
		
		$generalSettings = get_option("i3d_general_settings");
		if (isset($wp_filter['sidebars_widgets'])) {	
			$filter_backup = $wp_filter['sidebars_widgets'];
			unset($wp_filter['sidebars_widgets']);
		} else {
			$filter_backup = array();
		}
		
		// get the existing 
		$sidebarWidgets = wp_get_sidebars_widgets();
		$wp_filter['sidebars_widgets'] = $filter_backup;
    	
		if (!isset($defaultWidgets)) {
			I3D_Framework::init();
		}
		
	//	print "test";
       self::debug("top menu id:".I3D_Framework::getMenuID("I3D*Top"));
       self::debug("side menu id:".I3D_Framework::getMenuID("I3D*Side"));
       self::debug("footer menu id:".I3D_Framework::getMenuID("I3D*Footer"));
       self::debug("text links menu id:".I3D_Framework::getMenuID("I3D*Text"));

	   $registeredSidebars = array_keys($wp_registered_sidebars);
	   $registeredSidebars = array_diff($registeredSidebars, array('wp_inactive_widgets'));

		$existingSidebarWidgets = array();
		foreach ($registeredSidebars as $sideBar) {
			if ($resetSidebars) {
			  $sidebarWidgets["$sideBar"] = array();
			} else {
			  $sidebarWidgets["$sideBar"] = (array) $sidebarWidgets["$sideBar"];
			}
			
		}

		
		if (!isset($existingSidebarWidgets['wp_inactive_widgets'])) {
			$existingSidebarWidgets['wp_inactive_widgets'] = array();
		} else {
			$existingSidebarWidgets['wp_inactive_widgets'] = (array) $existingSidebarWidgets['wp_inactive_widgets'];
		}


		foreach ($defaultWidgets as $sideBarName => $widgets) { 
		

			// ensure we're dealing with an empty array
			if (!isset($existingSidebarWidgets["$sideBarName"]) || empty($existingSidebarWidgets["$sideBarName"])) {
				$existingSidebarWidgets["$sideBarName"] = array();
			// otherwise, skip
			} else {
				continue;
			}
			
			$sidebarWidgets = self::init_sidebar_widgets($widgets, $sideBarName, $sidebarWidgets, $existingSidebarWidgets);

		}

       
			unset($sidebarWidgets['wp_inactive_widgets']);
		wp_set_sidebars_widgets($sidebarWidgets);
       self::debug("Done install_widgets()");
	}
	
	public static function init_sidebar_widgets($widgets, $sideBarName, $sidebarWidgets, $existingSidebarWidgets = array()) {
		global $wp_widget_factory;

		foreach ($widgets as $widgetInfo) { // sidebar widgets foreach
			  	$widgetClassName = $widgetInfo['class_name'];
				$widgetDefaultSettings = $widgetInfo['default_settings'];
				
				// if this not a new style custom WP Widget, then skip
				if (!isset($wp_widget_factory->widgets["$widgetClassName"]) || !is_a($wp_widget_factory->widgets["$widgetClassName"], 'WP_Widget')) {
					continue;
				}
				
				// otherwise, continue
				// get the keys widget IDs for this widget class
				$widgetIds = array_keys((array) $wp_widget_factory->widgets["$widgetClassName"]->get_settings());
				$widgetIdBase = $wp_widget_factory->widgets["$widgetClassName"]->id_base;
				
				// the ID for the widget is the size of the largest key + 1 OR, the starting key id (which should be non-zero, non-one)
				$newWidgetId  = $widgetIds ? max($widgetIds) + 1 : 1;

				// reassign the existing widget ids to use a standard form
				foreach ($widgetIds as $key => $widgetID) {
					$widgetIds["$key"] = $widgetIdBase . '-' . $widgetID;
				}
                
				
				// check to make sure this widget isn't active yet
				foreach ($widgetIds as $widgetID) {
					
					if (isset($existingSidebarWidgets["$sideBarName"]) && is_array($existingSidebarWidgets["$sideBarName"]) && in_array($widgetID, $existingSidebarWidgets["$sideBarName"])) {
						continue 2; // skip out of THIS foreach, plus the parent foreach (as in, this widget), and back into the widget sidebar foreach
					}
				}
				// create a new widget
				// get the general settings for your widget class
				$newWidgetSettings = $wp_widget_factory->widgets["$widgetClassName"]->get_settings();
		
				// create a new array position for our new widget ID
				$newWidgetSettings["$newWidgetId"] = $widgetDefaultSettings;
				
				// set up for the new widget id
				$wp_widget_factory->widgets["$widgetClassName"]->_set($newWidgetId);

				// regster the widget
				$wp_widget_factory->widgets["$widgetClassName"]->_register_one($newWidgetId);

				$widgetID = $widgetIdBase."-".$newWidgetId;
				// add the widget to this sidebar
				$sidebarWidgets["$sideBarName"][] = $widgetID;

				self::debug("$sideBarName: $widgetID");

				// save the new settings
				$wp_widget_factory->widgets["$widgetClassName"]->save_settings($newWidgetSettings);
			//	print "\n\nnew widget settings:\n";
			//	var_dump($newWidgetSettings);
			}
//var_dump($sidebarWidgets["$sideBarName"]);
		//exit;
		return $sidebarWidgets;
	}


	/*************************
	 * INIT GENERAL SETTINGS
	 *************************/
	public static function init_generalSettings() {
		//setup an array for the general settings
		$existingI3dSettings = get_option('i3d_general_settings');
		$existingLMSettings = get_option('luckymarble_general_settings');

		if (is_array($existingI3dSettings) && count($existingI3dSettings) > 0) {
		   if ($existingI3dSettings['framework_version'] != "") {
		     $previousVersion = $existingI3dSettings['framework_version'];	
			   
		   } else {
		     $previousVersion = "4.0";	
		   }
		 //  print "existing i3d settings";
		//   var_dump($existingI3dSettings);
		} else if (is_array($existingLMSettings) && count($existingLMSettings) > 0) {
			if ($existingLMSettings['framework_version'] != "") {
				$previousVersion = $existingLMSettings['framework_version'];
			}
		//	print "existing lm settings";
		  //var_dump($existingLMSettings);
			
		} else {
			//print "no exissting settings";
		  $previousVersion = 0;	
		}
		$generalSettings = array();

		$generalSettings['use_search_box'] 				= 1;
		$generalSettings['social_media_facebook_url']   = "https://www.facebook.com/i3dthemes";
		$generalSettings['social_media_twitter_url']    = "http://www.twitter.com/i3dthemes";
		$generalSettings['social_media_tumblr_url']     = "http://newest-themes.tumblr.com/";
		$generalSettings['social_media_youtube_url']    = "http://www.youtube.com/i3dthemes";
		$generalSettings['social_media_pinterest_url']  = "https://pinterest.com/webtemplates1/";
		$generalSettings['social_media_googleplus_url'] = "https://plus.google.com/107435610970474251327";
		$generalSettings['contact_menu_id'] 			= self::getContactFormID("Contact Box");
		$generalSettings['drop_menu_id']			 	= "i3d-dropdown-menu-1";
		
		$generalSettings['default_slider']				= "default-".self::getSignatureSliderID();
		$generalSettings['vector_logo_icon']			= self::$defaultVectorIcon;
		$generalSettings['soundcloud_player_playlist']  = "http://soundcloud.com/the-vaccines";
		$generalSettings['404_show_sitemap']     		= 1;
		$generalSettings['404_show_search_box']  		= 1;
		$generalSettings['404_show_archives']     		= 1;
		$generalSettings['404_show_most_recent_posts']  = 1;
		$generalSettings['mobile_responsive'] 			= 1;
	
		
		if (self::$logoOverrideLocation != "") {
			require_once(ABSPATH . 'wp-admin/includes/media.php');
			require_once(ABSPATH . 'wp-admin/includes/file.php');
			require_once(ABSPATH . 'wp-admin/includes/image.php');
			global $wpdb;
			
			$filename = self::$logoOverrideLocation;
			$description = "KinderCare";
						
			# upload / resize / crop image (to WP images folder)
			media_sideload_image($filename, 0, $description);
			
			$last_attachment = $wpdb->get_row($query = "SELECT * FROM {$wpdb->prefix}posts ORDER BY ID DESC LIMIT 1", ARRAY_A);
			$attachment_id = $last_attachment['ID'];
			
			$generalSettings['custom_logo_filename'] = $attachment_id;
			
		  $generalSettings['custom_logo_status'] 			= 1;
		  $generalSettings['disable_website_name_text_logo'] = 1;
		  
		}
		
		if (self::$headerBGSupport) {
			require_once(ABSPATH . 'wp-admin/includes/media.php');
			require_once(ABSPATH . 'wp-admin/includes/file.php');
			require_once(ABSPATH . 'wp-admin/includes/image.php');
			global $wpdb;
			
			$filename = self::$headerBGLocation;
			$description = "Header Background";
						
			# upload / resize / crop image (to WP images folder)
			media_sideload_image($filename, 0, $description);
			
			$last_attachment = $wpdb->get_row($query = "SELECT * FROM {$wpdb->prefix}posts ORDER BY ID DESC LIMIT 1", ARRAY_A);
			$attachment_id = $last_attachment['ID'];
			
			$generalSettings['header_bg_filename'] = $attachment_id;
			
		}
		
		$generalSettings['404_message']     = "Oops!\nIt looks like we've misplaced the item you're looking for!\nPerhaps one of these would satisfy you?";
		$generalSettings['copyright_message'] = "<span>Copyright</span> &copy; ".date("Y").". All Rights Reserved.";
		$generalSettings['powered_by_message']  = '<a href="http://www.i3dthemes.com/wordpress-themes/?source=wp-theme-footer" target="_top">Wordpress Themes</a> designed by <a href="http://www.i3dthemes.com/?source=wp-theme-footer" target="_top"><i class="fa fa-globe icon-code"></i> i3dTHEMES</a>';
		$generalSettings['framework_version']   = self::$version;
		$generalSettings['upgrade_from']        = $previousVersion;
		
		if (self::$layoutEditorAvailable > 0) {
			$generalSettings['layout_editor'] = 2;
			//$generalSettings['layout_editor'] = 1;
		}
		//print "Previous Version: $previousVersion <br>";
		// save general settings
		add_option('i3d_general_settings', $generalSettings);
	}

	public static function init_layoutSettings() {
		//setup an array for the layout regions
		$layoutRegions = array();
		//$templates = get_page_templates();
//		$templates = array_merge(array("Default" => "index.php"), $templates);
		//global $i3dSupportedSidebars;
		$availableTemplates = array("default" => "Default", "advanced" => "Advanced", "blog" => "Blog", "business" => "Business", "contact" => "Contact", "faqs" => "FAQs",
									"photo-slideshow" => "Photo Slideshow", "team-members" => "Team Members", "under-construction" => "Under Construction", "sitemap" => "Sitemap");
		
		
		//foreach ( $templates as $template_name => $template_filename ) {
		//   $templateShortName = str_replace("template-", "", str_replace(".php", "", $template_filename));
		//   $availableTemplates["$templateShortName"] =  $template_name;
		//}
		//$avilableTemplates
		
		$standard = array('i3d-widget-area-top'          => array('columns' => 2, 'width' => 'contained', 'layout' => '10|2'),
						'i3d-widget-area-header-top'    => array('columns' => 2, 'width' => 'contained', 'layout' => '10|2'),
						'i3d-widget-area-header-main'   => array('columns' => 2, 'width' => 'contained', 'layout' => '6|6'),
						'i3d-widget-area-header-lower'  => array('columns' => 2, 'width' => 'contained', 'layout' => '6|6'),
						'i3d-widget-area-utility'       => array('columns' => 2, 'width' => 'contained', 'layout' => '6|6'),
						'i3d-widget-area-showcase'      => array('columns' => 1, 'width' => 'contained', 'layout' => '12'),
						'i3d-widget-area-seo'           => array('columns' => 1, 'width' => 'contained', 'layout' => '12'),
						'i3d-widget-area-breadcrumb'    => array('columns' => 1, 'width' => 'contained', 'layout' => '12'),
						'i3d-widget-area-main-top'      => array('columns' => 4, 'width' => 'contained', 'layout' => '3|3|3|3'),
						'i3d-widget-area-main'  		=> array('columns' => 2, 'width' => 'contained', 'layout' => '9|3'),
						'i3d-widget-area-main-bottom'   => array('columns' => 1, 'width' => 'contained', 'layout' => '12'),
						'i3d-widget-area-lower'         => array('columns' => 1, 'width' => 'fullscreen', 'layout' => '12'),
						'i3d-widget-area-bottom'        => array('columns' => 1, 'width' => 'contained', 'layout' => '12'),
						'i3d-widget-area-advertising'   => array('columns' => 1, 'width' => 'contained', 'layout' => '12'),
						'i3d-widget-area-footer'        => array('columns' => 3, 'width' => 'contained', 'layout' => '3|6|3'),
						'i3d-widget-area-copyright'     => array('columns' => 1, 'width' => 'contained', 'layout' => '12'));
		
		foreach ($availableTemplates as $template => $templateName) {
			
			$layoutRegions["{$template}"] = $standard;
		    if ($template == "business") {
				$layoutRegions["{$template}"]['i3d-widget-area-main']['layout'] = "12";
			}
			// Avante
			if (self::$layoutVersion == "2") {
				$layoutRegions["{$template}"]['i3d-widget-area-footer']['columns'] = "4";
				$layoutRegions["{$template}"]['i3d-widget-area-footer']['layout'] = "4|4|2|2";
			}
		}
		
		update_option("i3d_layout_regions", $layoutRegions);	
	}




	/************************************
	 * INIT BASIC PAGES
	 ************************************/
	public static function init_pages() {
        self::debug("In init_pages()");
		global $doFullInstall;
		global $lmDefaultPages;
		if (!is_array($lmDefaultPages)) {
			include("config-default.php");
		}
		$existingPages = get_pages();

	
		if ((@$_GET['activated'] == true && (@$_GET['configuration'] == "default" || @$_GET['configuration'] == "debug" || (@$_GET['init_pages'] == 1 || @$_POST['init_pages'] == 1))) || @$_POST['cmd'] == "init"  || @$_GET['cmd'] == "init") {
			$doFullInstall = true;
			I3D_Framework::create_pages($lmDefaultPages);

		} else {
			I3D_Framework::condition_pages($existingPages);
			
		}
       self::debug("Done init_pages()");
		
	}

	public static function create_pages($pages) {
		global $lmSidebars;
		$doneIntro = false;
		       self::debug("In create_pages()");
		$homePage = 0;
		uasort($pages, array("I3D_Framework", "sortPages"));
		$currentStatus = get_option("installation_status_percent");
		foreach ($pages as $pageName => $pagg) {
			if ($currentStatus < 40) {
				$currentStatus += (sizeof($pages) / 15);
				//update_option("installation_status_percent", $currentStatus);
			}
			
					       self::debug("In create_pages(): iteration start {$pagg['data']['post_title']}");

		  if (!page_exists($pagg['data']['post_title'], $pageID)) {
			  $pagg['data'] = str_replace("[theme_root]", get_stylesheet_directory_uri(), $pagg['data']);
				$pageId = wp_insert_post($pagg['data']);

				$lmDefaultPages["$pageName"]["data"]["page_id"] = $pageId;

				if($pagg['data']['post_title'] == "Home" && !$doneIntro) {
					update_option('show_on_front', 'page');
					update_option('page_on_front', $pageId);
					$homePage = $pageId;
				} else if ($pagg['data']['post_title'] == "Blog" || $pagg['data']['post_title'] == "News") {
					update_option("page_for_posts", $pageId);
					wp_update_post(array("ID" => $pageId, "post_parent" => $homePage));
				} else if ($pagg['data']['post_title'] == "About" || $pagg['data']['post_title'] == "About Us") {
					update_option("page_for_team-members", $pageId);
					wp_update_post(array("ID" => $pageId, "post_parent" => $homePage));
				} else if ($pagg['data']['post_title'] == "FAQs") {
					update_option("page_for_faqs", $pageId);
					wp_update_post(array("ID" => $pageId, "post_parent" => $homePage));
				
				} else if ($pagg['data']['post_title'] == "Portfolio") {
					update_option("page_for_portfolio_items", $pageId);
					wp_update_post(array("ID" => $pageId, "post_parent" => $homePage));
				
				} else if ($pagg['data']['post_title'] == "Welcome") {
					update_option('show_on_front', 'page');
					update_option('page_on_front', $pageId);
					$doneIntro = true;
					
				} else {
					wp_update_post(array("ID" => $pageId, "post_parent" => $homePage));
					
				}
				if (sizeof($pagg['child']) > 0) {
 					// currently, do nothing
				}

			} else {
				$pageId = $pageID;
				if ($pageName == "Home") {
					$menuOrder = 1;
				} else if ($pageName == "About") {
					$menuOrder = 2;
				} else {
					$menuOrder = 3;
				}
				wp_update_post(array("ID" => $pageID, "menu_order" => $menuOrder));
			}
					       self::debug("In create_pages(): about to update sidebars {$pagg['data']['post_title']}");

			// always set up the sidebars
			// sidebars have the same key value so.. key and key
	    foreach ($lmSidebars as $key => $value) {
				// activate the sidebar
				if (isset($pagg["sidebars"]["$key"])) {
				  if ($pagg["sidebars"]["$key"] === true) {
					  update_post_meta($pageId, $key, $key);
					  		       self::debug("initialized sidebar ($key) to default value");
				  
				  } else {
					  		       self::debug("initialized sidebar ($key) to ".$pagg['sidebars'][$key]);

				    update_post_meta($pageId, $key, $pagg["sidebars"]["$key"]);
				  }

				// disable the sidebar
				} else {
				  update_post_meta($pageId, $key, "");
				}
	  	}
							       self::debug("In create_pages(): about to update meta data {$pagg['data']['post_title']}");

      	foreach ($pagg["meta"] as $key => $value) {
			self::debug("create_pages(): update_post_meta({$pageId}, {$key}, ...)");
			//print $key."<br>";
			//var_dump($value);
														  
				update_post_meta($pageId, $key, $value);
		  }
		}

		       self::debug("Done create_pages()");
		
	}
	public static function is_slow_server() {
	  return (self::get_post_create_time() > 0.25);
	}
	
	public static function get_post_create_time() {
		 	$start_time =  array_sum(explode(' ', microtime()));	
			//return 0;
			for ($i = 0; $i < 5; $i++) { 
			  $id = wp_insert_post(array("post_name" => "test-post-{$i}", "post_title" => "Test Post {$i}", "post_type" => "page", "post_content" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce velit diam, tristique nec ex at, efficitur consectetur tortor. Donec et nulla quam. Quisque quis odio sed urna molestie laoreet. Duis ac luctus neque, vitae tempor est. Pellentesque sagittis vestibulum rhoncus. Mauris arcu turpis, congue non libero in, placerat dapibus leo. Proin luctus quam nisl, at mollis leo imperdiet eget. Etiam vel ligula placerat lacus efficitur bibendum. In tempor eros et libero euismod ullamcorper. "));
			  wp_delete_post($id, true);
			}
			$finish_time = array_sum(explode(' ', microtime()));
			$total_time = $finish_time - $start_time;
			return $total_time;
		
	}
	public static function condition_pages($pages) {
		self::debug("In condition_pages()");

		global $lmSidebars;
		global $lmDefaultPages;
		if (!is_array($lmDefaultPages)) {
			include("config-default.php");
		}
		
		$count = 0;
		
		$currentStatus = get_option("installation_status_percent");
	

		foreach ($pages as $pageName => $pagg) {
			if ($currentStatus < 40) {
				$currentStatus += (sizeof($pages) / 15);
				//update_option("installation_status_percent", $currentStatus);
			}
		
		
			$pageTitle = $pagg->post_title;
			$pageLayout = @$_POST["page_template__{$pagg->ID}"];
			
			if ($pageLayout == "home") {
		//	if (get_option("page_on_front") == $pagg->ID || (get_option("page_on_front") == "0" && $count++ == 0)) {
				update_option('show_on_front', 'page');
				update_option('page_on_front', $pagg->ID);
				
				$template = $lmDefaultPages["Home"];
			//} else if ($lmDefaultPages["{$pageTitle}"] != "") {
		
			} else if ($pageLayout == "contact") {
				$template = $lmDefaultPages["Contact"];
			
			} else if ($pageLayout == "faqs") {
				$template = $lmDefaultPages["FAQs"];
				
			} else if ($pageLayout == "team-members") {
				$template = $lmDefaultPages["About"];
			
			} else if ($pageLayout == "photo-slideshow") {
				$template = $lmDefaultPages["Photo Gallery"];

			} else if ($pageLayout == "blog") {
				$template = $lmDefaultPages["Blog"];
				
			} else if ($pageLayout == "sitemap") {
				$template = $lmDefaultPages["Sitemap"];
			
			} else {
				
				//print "[".get_option("page_on_front")."]";
				$template = $lmDefaultPages["Privacy Policy"];
				
			}
				       self::debug("condition {$pageTitle} as {$pageLayout}");
		    
			// always set up the sidebars
			// sidebars have the same key value so.. key and key
	    	foreach ($lmSidebars as $key => $value) {
				// activate the sidebar
				if (array_key_exists($key, $template["sidebars"]) && $template["sidebars"]["$key"]) {
				  update_post_meta($pagg->ID, $key, $key);

				// disable the sidebar
				} else {
				  update_post_meta($pagg->ID, $key, "");
				}
	  		}
			foreach ($template["meta"] as $key => $value) {
				if ($key == "i3d_page_title" && $value == "Privacy Policy") {
					$value = "";
				}
				update_post_meta($pagg->ID, $key, $value);
		    }
		}
		//exit;
						       self::debug("Done condition_pages()");

	}

	/************************************
	 * INIT SIDEBARS
	 ************************************/
	public static function init_sideBars() {
		self::debug("In init_sideBars()");

		global $lmSidebars;
		global $lmFrameworkVersion;
		global $_GET;
		global $customComponentSidebars;
	
		
	    $lmSidebars       = get_option('i3d_sidebar_options');
		$previousSidebars = @array_flip(@array_flip($lmSidebars));
		$generalSettings  =  get_option('i3d_general_settings');
		if (!is_array($generalSettings)) {
			$generalSettings = array();
		}
		if (!array_key_exists("framework_version", $generalSettings)) {
			$generalSettings['framework_version'] = 0;
		}
		
		
		
		if ((!isset($lmSidebars) || !is_array($lmSidebars) || sizeof($lmSidebars) == 0 
			 || (isset($_GET['resetsidebars']) && $_GET['resetsidebars'])
			 || $lmFrameworkVersion > $generalSettings['framework_version']) 
			&& array_key_exists('activated', $_GET) && $_GET['activated']) {
		
		  // first, lets wipe out the existing sidebars
		              
		  
			   
				
							$lmSidebars = array(/* 'i3d-unused'           => 'Unused', */
												'i3d-widget-area-header-top'    => 'Header Top',
												'i3d-widget-area-header-main'   => 'Header Main',
												'i3d-widget-area-header-lower'  => 'Header Lower',
												'i3d-widget-area-top'           => 'Top',
												'i3d-widget-area-utility'       => 'Utility',
												'i3d-widget-area-showcase'      => 'Showcase',
												'i3d-widget-area-seo'           => 'SEO',
												'i3d-widget-area-breadcrumb'    => 'Breadcrumb',
												'i3d-widget-area-main-top'      => 'Main Top',
												'i3d-widget-area-main'  		=> 'Main Content Area 1',
												'i3d-widget-area-main-2'		=> 'Main Content Area 2',
												'i3d-widget-area-main-3'     	=> 'Main Content Area 3',
												'i3d-widget-area-main-4' 		=> 'Main Content Area 4',
												'i3d-widget-area-main-5' 		=> 'Main Content Area 5', 
												'i3d-widget-area-main-6'      	=> 'Main Content Area 6',
												'i3d-widget-area-main-bottom'   => 'Main Bottom',
												'i3d-widget-area-lower'         => 'Lower',
												'i3d-widget-area-bottom'        => 'Bottom',
												'i3d-widget-area-advertising'   => 'Advertising',
												'i3d-widget-area-footer'        => 'Footer',
												'i3d-widget-area-copyright'     => 'Copyright',
												'i3d-widget-area-custom-1'      => 'Custom Region 1',									
												'i3d-widget-area-custom-2'      => 'Custom Region 2',									
												'i3d-widget-area-custom-3'      => 'Custom Region 3'									
								   );
				
					self::debug("sizeof additional sidebars = ".sizeof(self::$additionalSidebars));

			
			// only install the widgets if there were no previous sidebars
			if (!isset($previousSidebars) || !is_array($previousSidebars) || sizeof($previousSidebars) == 0) {
			  update_option('luckymarble_create_widgets', true);

			  //unset($lmSidebars['luckymarble-unused-widgets']);
			  update_option('i3d_sidebar_options', $lmSidebars);
		      
			} else {
				//print "is set previous sidebars ".isset($previousSidebars)."<br>";
				//print "is_array previous sidebars ".is_array($previousSidebars)."<br>";
				//print "sizeof previous sidebars ".sizeof($previousSidebars)."<br>";
				//foreach ($previousSidebars as $x => $y) {
				//	print $x."=".$y."<br>";
				//}
			}
			
		} 


			if (sizeof(self::$additionalSidebars) > 0) {
			  foreach (self::$additionalSidebars as $key => $value) {
				  $lmSidebars["$key"] = $value;
			  }
			  
			}
			//var_dump($lmSidebars);
			update_option('i3d_sidebar_options', $lmSidebars);

		
		if (is_array(self::$renamedSidebars) && sizeof(self::$renamedSidebars) > 0) {
		  foreach (self::$renamedSidebars as $key => $value) {
			  $lmSidebars["$key"] = $value;
		  }
		}

		  if (is_array(self::$removedSidebars) && sizeof(self::$removedSidebars) > 0) {
			  
			  foreach (self::$removedSidebars as $sidebar_name => $removable) {
				  unset ($lmSidebars["{$sidebar_name}"]);
				  
			  }		
			update_option('i3d_sidebar_options', $lmSidebars);
		  } else {
			
		  }
			
		  if (sizeof(self::$reorderedSidebars) > 0) {
			  $newSidebars = array();
			  foreach (self::$reorderedSidebars as $shortName) {
				  $newSidebars["i3d-widget-area-{$shortName}"] = $lmSidebars["i3d-widget-area-{$shortName}"];
				  //$lmSidebars["$key"] = $value;
			  }		
			  $lmSidebars = $newSidebars;
			  update_option('i3d_sidebar_options', $lmSidebars);
		  }
			
		
		
		self::debug("Exiting init_sideBars()");

	}

	public static function removeSidebar($key) {
		self::$removedSidebars["i3d-widget-area-{$key}"] = true;
	}


	public static function renameSidebar($from, $to) {
		self::$renamedSidebars["i3d-widget-area-{$from}"] = $to;
	}


	public static function addSidebar($key, $name) {
		self::$additionalSidebars["i3d-widget-area-{$key}"] = $name;
	}
	public static function reorderSidebars($newSidebars = array()) {
		self::$reorderedSidebars = $newSidebars;
	}
	
	// if our default menus do not exist, then create them
    public static function init_menus() {
		self::debug("In init_menus()");

		global $_GET;
		
		
	    $i3dMenus       = get_option('i3d_menu_options');
		if (array_key_exists("resetmenus", $_GET) && $_GET['resetmenus'] == 'true') {
		  $i3dMenus       = array();
		}
		// initialize the menu placeholders
		if ((!isset($i3dMenus) || !is_array($i3dMenus) || sizeof($i3dMenus) == 0) && @$_GET['activated'] == "true") {
			$i3dMenus = array('i3d-dropdown-menu-1' => __('Primary Horizontal Menu', "i3d-framework"),
							  'i3d-dropdown-menu-2' => __('Secondary Horizontal Menu', "i3d-framework"),
							'i3d-dropdown-menu-3' => __('Primary Vertical Menu', "i3d-framework"),
							'i3d-dropdown-menu-4' => __('Secondary Vertical Menu', "i3d-framework"),
							'i3d-dropdown-menu-5' => __('Primary Auxiliary Menu', "i3d-framework"),
							'i3d-dropdown-menu-6' => __('Secondary Auxiliary Menu', "i3d-framework")
				);
			
			  // set up the menu placeholders into the system
			update_option('i3d_menu_options', $i3dMenus);
			self::debug("Initialized i3d_menu_options");
		}
		
		
		$lmMenuExist = array();
	    $menus = wp_get_nav_menus();
		if (array_key_exists("resetmenus", $_GET) && $_GET['resetmenus'] == 'true') {
		  $menus       = array();
		}
		
		
		// only perform initialization upon activation
		if (array_key_exists("activated", $_GET) && $_GET['activated'] == 'true') {
			if (sizeof($menus) == 0 || true) {
			self::debug("init_menus: sizeof menus is zero, or true");
				
			  foreach ($menus as $menu) {
				$lmMenuExist["{$menu->name}"] = true;
			  }
			  
			  if (!isset($lmMenuExists) || !$lmMenuExists["I3D*Side"]) {
				 self::debug("init_menus: I3D*Side");
				  
				 wp_update_nav_menu_object( 0, array('menu-name' => "I3D*Side") );
			  }
		
			  if (!isset($lmMenuExists) || !$lmMenuExists["I3D*Top"]) {
				 wp_update_nav_menu_object( 0, array('menu-name' => "I3D*Top") );
			  }
			  
			  if (!isset($lmMenuExists) || !$lmMenuExists["I3D*Footer"]) {
				 wp_update_nav_menu_object( 0, array('menu-name' => "I3D*Footer") );
			  }
			  
			  if (!isset($lmMenuExists) || !$lmMenuExists["I3D*Text"]) {
				 wp_update_nav_menu_object( 0, array('menu-name' => "I3D*Text") );
			  }			  
		 	 // set_theme_mod( 'nav_menu_locations', array("lm-dropdown-menu" => $topNavMenuID, "lm-secondary-dropdown-menu" => $topNavMenuID, "lm-tertiary-dropdown-menu" => $topNavMenuID) );
			  set_theme_mod('nav_menu_locations', array());

			} else {
			  $menuPosition = array();
			  $menuCount    = 0;
			  $navMenuLocations = get_theme_mod('nav_menu_locations');
			  if (!isset($navMenuLocations['i3d-dropdown-menu-1'])) {
				  $navMenuLocations['i3d-dropdown-menu-1'] = "";
			  }
			  if ($navMenuLocations['i3d-dropdown-menu-1'] == "" || 
					$navMenuLocations['i3d-dropdown-menu-1'] == "0" || 
					(is_object($navMenuLocations['i3d-dropdown-menu-1']) && get_class($navMenuLocations['i3d-dropdown-menu-1']) == "WP_Error")) {
				  // iterate through the available menus that already exist, and assign them to the menus
				  // Note: this only happens upon activation IF the theme's menus are not set already
				  // we also iterate through to see if perhaps there is a I3D*Top already in the system, and if so, assign it to the Primary
				  // menu placeholder reference
				  foreach ($menus as $menuID => $menu) {			
				   // print "$menuCount = {$menu->term_id}<br>";
					$menuPosition["{$menuCount}"] = $menu->term_id;
					if ($menu->name == "I3D*Top") {
						$menuPosition[0] = $menu->term_id;
					}
					$menuCount++;
				  }
				  
				 // set_theme_mod( 'nav_menu_locations', array("lm-dropdown-menu" => $menuPosition[0], "lm-secondary-dropdown-menu" => $menuPosition[1], "lm-tertiary-dropdown-menu" => $menuPosition[2]) );
			      set_theme_mod('nav_menu_locations', array());
			  } else {
				//  print "<pre>";
				  
				//  var_dump($navMenuLocations);
			     // print "</pre>";
			  }
			
			}
		//	exit;
		} 
		self::debug("Exit init_menus()");
	}
	public static function getPageID($pageName) {
		    $pages = get_pages();

		

				  foreach ($pages as $pageID => $page) {			
				    if ($pageName == $page->post_title) {
						return $page->ID;
					}
				  }
				  if (strstr($pageName, "Featured Page")) {
					  $position = str_replace("Featured Page ", "", $pageName);
					  $count = 1;
					  foreach ($pages as $pageID => $page) {
						  if ($count++ == $position) {
							  return $page->ID;
						  }
					  }
					  
				  }
				  return 0;

	}

	public static function getMenuID($menuName) {
		    $menus = wp_get_nav_menus();
		

				  foreach ($menus as $menuID => $menu) {		
				//  print $menuID."==".$menu->name.":".$menu->term_id."<br>";	
				    if ($menuName == $menu->name) {
						return $menu->term_id;
					}
				  }
				  
				  return 0;

	}
	
	
	protected static function init_submenu($navigation_arrays, $menuID, $args, $menuSettings) {
		$secondaryLevelCount = 0;
		
		foreach ($menuSettings['submenu'] as $submenuItem => $subMenuSettings) {
						if (is_array($subMenuSettings)) {
						 $submenuPageID = I3D_Framework::getPageID($subMenuSettings['link']);
							
						} else {
							
						 $submenuPageID = I3D_Framework::getPageID($subMenuSettings);
						}
						$subArgs = array(
							'menu-item-db-id' => 0,
							'menu-item-object-id' => $submenuPageID,
							'menu-item-object' => "page",
							'menu-item-parent-id' => 0,
							'menu-item-position' => $secondaryLevelCount++,
							'menu-item-type' => "post_type",
							'menu-item-title' => $submenuItem,
							'menu-item-url' => '',
							'menu-item-post-status' => 'publish',
							'menu-item-description' => '',
							'menu-item-attr-title' => '',
							'menu-item-target' => '',
							'menu-item-classes' => '',
							'menu-item-xfn' => ''
						);	
						
						// assign a reference id so that we can later get this object
					//	I3D_Framework::$defaultMenus["$menuID"]["$menuItem"]["children"]["$submenuItem"]["reference_id"] = $menu_item_id;

						$args['children']["$submenuItem"] = $subArgs;
						$menu_item_title = $subArgs['menu-item-title'];
						$navigation_arrays["$menuID"]["{$menu_item_title}"] = $subArgs;
						
						if (is_array($subMenuSettings) && @sizeof($subMenuSettings['submenu']) > 0) {
							$temp_array = self::init_submenu($navigation_arrays, $menuID, $subArgs, $subMenuSettings);
						  	$navigation_arrays = $temp_array[0];
						  	$subArgs = $temp_array[1];
							$args['children']["$submenuItem"] = $subArgs;
						
						}
						
						

						
				  }
					  foreach ($args['children'] as $subArg) {
						  $menu_item_title = $subArg['menu-item-title'];
						  $navigation_arrays["$menuID"]["{$menu_item_title}"] = $subArg;
					  }
				  
		//var_dump($args);
	  return array($navigation_arrays, $args);
	}
	public static function init_navigation_v2() {
		require_once( ABSPATH . 'wp-admin/includes/nav-menu.php' );
		global $lmDefaultPages;
		
		$slowServer = self::is_slow_server();
		$navigation_arrays = array();

		foreach (I3D_Framework::$defaultMenus as $menuID => $menuItems) {
			$primaryLevelCount = 0;
			$menu_item_id = -100;
			self::debug("Setting up Custom Navigation for $menuID init_navigation()");
			
			foreach ($menuItems as $menuItem => $menuSettings) {
				if ($slowServer && $menuItem == "Extra Pages") {
					continue;
				}
				$secondaryLevelCount = 0;
				$menu_item_id++;
				
				if ($menuSettings['link'] == "#") {
					$args = array(
						'menu-item-db-id' => 0,
						'menu-item-object-id' => 0,
						'menu-item-object' => "page",
						'menu-item-parent-id' => 0,
						'menu-item-position' => $primaryLevelCount++,
						'menu-item-type' => "custom",
						'menu-item-title' => $menuItem,
						'menu-item-url' => '#',
						'menu-item-post-status' => 'publish',
						'menu-item-description' => '',
						'menu-item-attr-title' => '',
						'menu-item-target' => '',
						'menu-item-classes' => $menuSettings['icon'],
						'menu-item-xfn' => ''
					);							
					
				} else {
					$pageID = I3D_Framework::getPageID($menuSettings['link']);
					if ($pageID == 0) {
						continue;
					}
					
	
					$args = array(
						'menu-item-db-id' => 0,
						'menu-item-object-id' => $pageID,
						'menu-item-object' => "page",
						'menu-item-parent-id' => 0,
						'menu-item-position' => $primaryLevelCount++,
						'menu-item-type' => "post_type",
						'menu-item-title' => $menuItem,
						'menu-item-url' => '',
						'menu-item-post-status' => 'publish',
						'menu-item-description' => '',
						'menu-item-attr-title' => '',
						'menu-item-target' => '',
						'menu-item-classes' => $menuSettings['icon'],
						'menu-item-xfn' => ''
					);							
				}
				 $menu_item_title = $args['menu-item-title'];
				$navigation_arrays["$menuID"]["{$menu_item_title}"] = $args;
				
				if (@sizeof($menuSettings['submenu']) > 0 ) {
				  $temp_array = self::init_submenu($navigation_arrays, $menuID, $args, $menuSettings);
				  $navigation_arrays = $temp_array[0];
				  $args = $temp_array[1];
				  $navigation_arrays["$menuID"]["{$menu_item_title}"] = $args;
				}
					 
					  
			}
		}		
		
		if (function_exists('wp_nav_menu')) {
			// add items to each menu
			$menus = array_keys(I3D_Framework::$defaultMenus);
			update_option("installation_status_percent", 50);

			foreach ($menus as $menu_name) {			
				$current_menu_id = I3D_Framework::getMenuID($menu_name);
				
				$menu_item_parent_id = array(); // used to keep track of all of the menu items db-id
				$existing_menu_items     	= wp_get_nav_menu_items($current_menu_id);
				
				self::debug("{$menu_name} existing menu items: ".sizeof($existing_menu_items));
	
				// test to make sure there are not items already in the menu
				if (sizeof($existing_menu_items) == 0) {
					self::debug("Create {$menu_name}: step 1");
					
					// apply our menu items
					@wp_save_nav_menu_items($current_menu_id, @$navigation_arrays["$menu_name"]);
					self::debug("Create {$menu_name}: step 2");
					
					// retrieve all of the unsorted menu items, ordered
					$unsorted_menu_items = @wp_get_nav_menu_items( $current_menu_id, array('orderby' => 'menu_order', 'output' => ARRAY_A, 'output_key' => 'ID', 'post_status' => 'draft,publish') );
					//var_dump($unsorted_menu_items);
					
					self::debug("Create {$menu_name}: step 3");
				
					// iterate through items, to apply the proper publish status, css class, and also which parent id to use for sub-menu items
					foreach( $unsorted_menu_items as $_item ) {
						$menu_item = $navigation_arrays["{$menu_name}"]["{$_item->title}"];
	
						if (@$menu_item_parent_id["$_item->title"] != "") {
							$menu_item["menu-item-parent-id"] = $menu_item_parent_id["$_item->title"] ;
						}
						
						// iterate through any children of this menu item and add their db-id to the temporary "menu_item_parent_id" 
						// array for lookup and assignement when that particular page comes up in this menu loop
						// (look up to the previous if ($menu_item_parent_id ...
						if (sizeof(@$menu_item['children']) > 0) {
							foreach ($menu_item['children'] as $pageTitle => $pageData) {
								$menu_item_parent_id["$pageTitle"] = $_item->db_id;
							}
						}
						
						// assign the apropriate db-id to this menu item
						$menu_item['menu-item-db-id'] 	= $_item->db_id;
						
						// increment the position, because the default 0 position puts the first item to the bottom of the list
						$menu_item['menu-item-position']++;
						
						// assign the proper icon class, if and only if we signal that it should be set
						$menu_item["menu-item-classes"] = (I3D_Framework::$initMenusWithIcons ? $menu_item["menu-item-classes"] : "");
						
						// update the menu item in the menu (this saves all the new settings)
						wp_update_nav_menu_item( $current_menu_id, $_item->db_id, $menu_item);
						self::debug("Create {$menu_name}: added {$_item->title}");

						
					}
				}
			}
		} // end of wp_nav exists
		

		$locations = get_theme_mod('nav_menu_locations');
		$locations["i3d-dropdown-menu-1"] = I3D_Framework::getMenuID("I3D*Top");	
		$locations["i3d-dropdown-menu-2"] = I3D_Framework::getMenuID("I3D*Text");
		$locations["i3d-dropdown-menu-3"] = I3D_Framework::getMenuID("I3D*Side");
		$locations["i3d-dropdown-menu-5"] = I3D_Framework::getMenuID("I3D*Footer");
		set_theme_mod( 'nav_menu_locations', $locations );
		//print "init_navigation_v2()";
		//var_dump (get_theme_mod("nav_menu_locations"));
		//exit;
		self::debug("Done init_navigation_v2()");		
		
	}
	public static function init_navigation() {
		
		if (sizeof(I3D_Framework::$defaultMenus) > 0 && !@$_POST['config'] == "requested") {
		   self::init_navigation_v2();
		   return;
		}
		 self::debug("Start init_navigation()");

		global $lmDefaultPages;
		global $doFullInstall; // this is set if there was only one or less pages existing
		global $sideNavMenuID;
		global $auxNavMenuID;
		global $topNavMenuID;
		global $_GET;
		if (array_key_exists("configuration", $_GET) && $_GET['configuration'] != "default") {
		//	return;
		}
		require_once( ABSPATH . 'wp-admin/includes/nav-menu.php' );

		$pages = get_pages(array("sort_column" => "menu_order", "hierarchical" => false));
		$primaryNavigationArray 		= array();
		$secondaryNavigationArray     	= array();
		$auxNavigationArray     		= array();
		$textNavigationArray   		 	= array();
		//$subVerticalNavigationArray = array();
		
		// loop through existing pages and addd them to the navigation by default
		$count = 1;
//print "do full install? $doFullInstall<br>";
		$currentStatus = get_option("installation_status_percent");
		
				update_option("installation_status_percent", $currentStatus);


			foreach ($pages as $x => $myPage) {
								self::debug("{$myPage->post_title}");
								
					$args = array(
						'menu-item-db-id' => 0,
						'menu-item-object-id' => $myPage->ID,
						'menu-item-object' => "page",
						'menu-item-parent-id' => 0,
						'menu-item-position' => $count++,
						'menu-item-type' => "post_type",
						'menu-item-title' => $myPage->post_title,
						'menu-item-url' => '',
						'menu-item-post-status' => 'publish',
						'menu-item-description' => '',
						'menu-item-attr-title' => '',
						'menu-item-target' => '',
						'menu-item-classes' => '',
						'menu-item-xfn' => ''
					);							
				if (isset($_POST['config']) && $_POST['config'] == "requested") {
					self::debug("Using REQUESTED Navigation Setup");
						
					  if (isset($_POST['top_menu__'.$myPage->ID]) && $_POST['top_menu__'.$myPage->ID] == "1") {
					self::debug("Adding {$myPage->post_title} to Primary Navigation");
						$primaryNavigationArray["{$myPage->ID}"] = $args;
						  
					  }
					  if (isset($_POST['side_menu__'.$myPage->ID]) && $_POST['side_menu__'.$myPage->ID] == "1") {
					self::debug("Adding {$myPage->post_title} to Secondary Navigation");
						$secondaryNavigationArray["{$myPage->ID}"] = $args;
						  
					  }
					  if (isset($_POST['text_menu__'.$myPage->ID]) && $_POST['text_menu__'.$myPage->ID] == "1") {
					self::debug("Adding {$myPage->post_title} to Text Navigation");
						$textNavigationArray["{$myPage->ID}"] = $args;
						  
					  }
					  if (isset($_POST['text_menu__'.$myPage->ID]) && $_POST['footer_menu__'.$myPage->ID] == "1") {
					self::debug("Adding {$myPage->post_title} to Footer Navigation");
						$auxNavigationArray["{$myPage->ID}"] = $args;
						  
					  }
				} else if ((array_key_exists($myPage->post_title, $lmDefaultPages) && $lmDefaultPages["$myPage->post_title"]["show"])) {
					self::debug("Adding {$myPage->post_title} to Primary Navigation");
	
				
						self::debug("Using Default Navigation Setup");
						if (sizeof ($primaryNavigationArray) < self::$numTopMenuItems) {
							if ((self::$numTopMenuItems == 6 && $myPage->post_title != "Sitemap"  && $myPage->post_title != "Welcome") ||
								 (self::$numTopMenuItems == 5 && $myPage->post_title != "Sitemap" && $myPage->post_title != "Contact" && $myPage->post_title != "Welcome")) {
								$primaryNavigationArray["{$myPage->ID}"] = $args;
								}
						}
						if ($myPage->post_title != "Welcome") {
							$secondaryNavigationArray["{$myPage->ID}"] = $args;
						}
						//$subVerticalNavigationArray
						//initSubVerticalMenu
						if (sizeof ($auxNavigationArray) < 6) {
							if ($myPage->post_title != "Welcome") {
							  $auxNavigationArray["{$myPage->ID}"] = $args;
							}
						}
						if ($myPage->post_title == "Home" || $myPage->post_title == "Contact" || $myPage->post_title == "About") {
							
						  $textNavigationArray["{$myPage->ID}"] = $args;
							  
	
							
						}
				
				} else {
					// skipping
				}
			}
						update_option("installation_status_percent", 45);

		// add navigation to the system
		// use the wordpress 3.0 navigation
		if (function_exists('wp_nav_menu')) {
			self::debug("About to create I3D*Side");

			$sideNavMenuID = I3D_Framework::getMenuID("I3D*Side");
		    $navArray      = array();
			$navItems      = wp_get_nav_menu_items($sideNavMenuID);
			//print sizeof ($navItems);
			if (sizeof($navItems) == 0) {
											self::debug("Create I3D*Side: step 1");

				wp_save_nav_menu_items($sideNavMenuID, $secondaryNavigationArray);

				$unsorted_menu_items = wp_get_nav_menu_items( $sideNavMenuID, array('orderby' => 'menu_order', 'output' => ARRAY_A, 'output_key' => 'ID', 'post_status' => 'draft,publish') );
				$menu_items = array();
											self::debug("Create I3D*Side: step 2");
				// index menu items by db ID
				foreach( $unsorted_menu_items as $_item ) {
					$menu_items["{$_item->db_id}"] = $_item;

					$sideNavigationArray["{$_item->object_id}"]["menu-item-db-id"] = $_item->db_id;
					if (sizeof($lmDefaultPages["$_item->title"]["child"]) > 0) {
						foreach ($lmDefaultPages["$_item->title"]["child"] as $pageTitle => $pageData) {
							$navArray["$pageTitle"]["parent_id"] = $_item->db_id;
						}
					}
					if (isset($navArray["$_item->title"]) && $navArray["$_item->title"]['parent_id'] == "") {
					  $navArray["$_item->title"]['parent_id'] = $_item->parent_id;
					}
				}
											self::debug("Create I3D*Side: step 3");
				
				foreach( $unsorted_menu_items as $_item ) {
					$menu_items["{$_item->db_id}"] = $_item;

					$secondaryNavigationArray["{$_item->object_id}"]["menu-item-db-id"] = $_item->db_id;
              		$secondaryNavigationArray["{$_item->object_id}"]["menu-item-classes"] = (I3D_Framework::$initMenusWithIcons ? I3D_Framework::getIconClass($_item->title) : "");
					if (!isset($navArray["{$_item->title}"])) {
						$secondaryNavigationArray["{$_item->object_id}"]["menu-item-parent-id"] = "";
						
					} else {
						
						$secondaryNavigationArray["{$_item->object_id}"]["menu-item-parent-id"] = $navArray["{$_item->title}"]["parent_id"];
					}
					wp_update_nav_menu_item( $sideNavMenuID, $_item->db_id, $secondaryNavigationArray["{$_item->object_id}"]);
				}
															self::debug("Create I3D*Side: step 4");

			} // end of if navigation items == 0



			// add items to the top menu
			$topNavMenuID = I3D_Framework::getMenuID("I3D*Top");
						update_option("installation_status_percent", 50);
			
	   		$navArray     = array();
			$navItems     = wp_get_nav_menu_items($topNavMenuID);
			
			if (sizeof($navItems) == 0) {
															self::debug("Create I3D*TOP: step 1");

				wp_save_nav_menu_items($topNavMenuID, $primaryNavigationArray);

				$unsorted_menu_items = wp_get_nav_menu_items( $topNavMenuID, array('orderby' => 'menu_order', 'output' => ARRAY_A, 'output_key' => 'ID', 'post_status' => 'draft,publish') );
				var_dump($unsorted_menu_items);
				$menu_items = array();
											self::debug("Create I3D*TOP: step 2");

				// Index menu items by db ID
				foreach( $unsorted_menu_items as $_item ) {
					$menu_items["{$_item->db_id}"] = $_item;
					self::debug("Create I3D*TOP: adding {$_item->title} to menu");
					if (sizeof($lmDefaultPages["$_item->title"]["child"]) > 0) {
						foreach ($lmDefaultPages["$_item->title"]["child"] as $pageTitle => $pageData) {
							$navArray["$pageTitle"]['parent_id'] = $_item->db_id;
						}
					}
					
					if (!isset($navArray["$_item->title"]) || $navArray["$_item->title"]['parent_id'] == "") {
					  $navArray["$_item->title"]['parent_id'] = $_item->parent_id;
					}
				}
				
				
											self::debug("Create I3D*TOP: step 3");

				foreach( $unsorted_menu_items as $_item ) {
					$menu_items["{$_item->db_id}"] = $_item;
					$primaryNavigationArray["{$_item->object_id}"]["menu-item-db-id"] = $_item->db_id;
              		$primaryNavigationArray["{$_item->object_id}"]["menu-item-classes"] = (I3D_Framework::$initMenusWithIcons ? I3D_Framework::getIconClass($_item->title) : "");
					if (!isset($navArray["$_item->title"])) {
						print "nopers: <br>";
						$primaryNavigationArray["{$_item->object_id}"]["menu-item-parent-id"] = "";
						
					} else {
						print "yupz: ".$navArray["$_item->title"]["parent_id"]."<br>";
						$primaryNavigationArray["{$_item->object_id}"]["menu-item-parent-id"] = $navArray["$_item->title"]["parent_id"];
						
					}
					print "updating {$_item->db_id} with {$_item->object_id}<br>";
					wp_update_nav_menu_item( $topNavMenuID, $_item->db_id, $primaryNavigationArray["{$_item->object_id}"]);
				}
															self::debug("Create I3D*TOP: step 4");

			}   // end of if navigation items == 0
			
						update_option("installation_status_percent", 55);
			
			// add a shorter set of items tot he auxilliary menu
			$auxNavMenuID = I3D_Framework::getMenuID("I3D*Footer");
			//print "auxilliary Nav Menu ID ".$auxNavMenuID;
			//exit;
	    	$navArray 	  = array();
			$navItems     = wp_get_nav_menu_items($auxNavMenuID);
			if (sizeof($navItems) == 0) {
				wp_save_nav_menu_items($auxNavMenuID, $auxNavigationArray);

				$unsorted_menu_items = wp_get_nav_menu_items( $auxNavMenuID, array('orderby' => 'menu_order', 'output' => ARRAY_A, 'output_key' => 'ID', 'post_status' => 'draft,publish') );
				$menu_items = array();

				// index menu items by db ID
				$pageCount = 0;
				foreach( $unsorted_menu_items as $_item ) {
					$menu_items["{$_item->db_id}"] = $_item;
					if (!isset($navArray["$_item->title"]) || $navArray["$_item->title"]['parent_id'] == "") {
						$navArray["$_item->title"]['parent_id'] = $_item->parent_id;
					}
				}
						
				foreach( $unsorted_menu_items as $_item ) {
					$menu_items["{$_item->db_id}"] = $_item;
              		$auxNavigationArray["{$_item->object_id}"]["menu-item-db-id"] = $_item->db_id;
              		$auxNavigationArray["{$_item->object_id}"]["menu-item-classes"] = (I3D_Framework::$initMenusWithIcons ? I3D_Framework::getIconClass($_item->title) : "");
              		
					$auxNavigationArray["{$_item->object_id}"]["menu-item-parent-id"] = $navArray["$_item->title"]["parent_id"];

					wp_update_nav_menu_item( $auxNavMenuID, $_item->db_id, $auxNavigationArray["{$_item->object_id}"]);
				}
			}  // end of if navigation items == 0
			
			// add a shorter set of items tot he auxilliary menu
			$textNavMenuID = I3D_Framework::getMenuID("I3D*Text");

			$navArray 	  = array();
			$navItems     = wp_get_nav_menu_items($textNavMenuID);
			if (sizeof($navItems) == 0) {
				wp_save_nav_menu_items($textNavMenuID, $textNavigationArray);

				$unsorted_menu_items = wp_get_nav_menu_items( $textNavMenuID, array('orderby' => 'menu_order', 'output' => ARRAY_A, 'output_key' => 'ID', 'post_status' => 'draft,publish') );
				$menu_items = array();

				// index menu items by db ID
				$pageCount = 0;
				foreach( $unsorted_menu_items as $_item ) {
					
					$menu_items["{$_item->db_id}"] = $_item;

					if (!isset($navArray["$_item->title"]) || $navArray["$_item->title"]['parent_id'] == "") {
						$navArray["$_item->title"]['parent_id'] = $_item->parent_id;
					}
				}
						
				foreach( $unsorted_menu_items as $_item ) {
					$menu_items["{$_item->db_id}"] = $_item;
              		$textNavigationArray["{$_item->object_id}"]["menu-item-db-id"] = $_item->db_id;
					
              		$textNavigationArray["{$_item->object_id}"]["menu-item-classes"] = (I3D_Framework::$initMenusWithIcons ? I3D_Framework::getIconClass($_item->title) : "");
              		$textNavigationArray["{$_item->object_id}"]["menu-item-parent-id"] = $navArray["$_item->title"]["parent_id"];

					wp_update_nav_menu_item( $textNavMenuID, $_item->db_id, $textNavigationArray["{$_item->object_id}"]);
				}
				if (self::$textLinksVersion == 2) {
					wp_update_nav_menu_item($textNavMenuID, 0, array(
						'menu-item-title' =>  __('Call: 555-555-1234', "i3d-framework"),
						'menu-item-classes' => 'fa-mobile',
						'menu-item-url' => "tel://555-555-1234", 
						'menu-item-position' => 99, 
						'menu-item-status' => 'publish'));	
				}
			}  // end of if navigation items == 0
			
		} // end of wp_nav exists
		
		$topNavMenuID = I3D_Framework::getMenuID("I3D*Top");

		$locations = get_theme_mod('nav_menu_locations');
		$locations["i3d-dropdown-menu-1"] = $topNavMenuID;				
		$locations["i3d-dropdown-menu-2"] = I3D_Framework::getMenuID("I3D*Text");				
		$locations["i3d-dropdown-menu-3"] = I3D_Framework::getMenuID("I3D*Side");				
		$locations["i3d-dropdown-menu-5"] = I3D_Framework::getMenuID("I3D*Footer");				
		set_theme_mod( 'nav_menu_locations', $locations );
		
		//print "init_navigation()";
		//var_dump (get_theme_mod("nav_menu_locations"));
		//exit;
		
		self::debug("SET DROP DOWN MENU 1 to {$topNavMenuID}");
		self::debug("Done init_navigation()");

	}
	
	public static function getIconClass($pageName) {
	  if ($pageName == "Home") {
		  return "icon-home";
	  } else if (stristr($pageName, "contact")) {
		  return "icon-envelope";
	  } else if ($pageName == "Blog") {
		  return "icon-rss";
	  } else if ($pageName == "About") {
		  return "icon-user";
	  } else if ($pageName == "FAQs") {
		  return "icon-info-sign";
	  } else if ($pageName == "Privacy Policy") {
		  return "icon-legal";
	  } else if (stristr($pageName, "photo")) {
		  return "icon-picture";
	  } else if ($pageName == "Sitemap") {
		  return "icon-sitemap";
	  }
	}

	public static function addPage($pageBaseData, $pageMetaData, $sidebars = array(), $showInMenu = true, $parentPage = "") {
		global $lmDefaultPages;

		$pageName = $pageBaseData['post_title'];
		if ($parentPage == "") {
		  $lmDefaultPages["$pageName"]["data"]      = $pageBaseData;
		  $lmDefaultPages["$pageName"]["meta"]      = $pageMetaData;
		  $lmDefaultPages["$pageName"]["sidebars"]  = $sidebars;
		  $lmDefaultPages["$pageName"]["show"]      = $showInMenu;
		  $lmDefaultPages["$pageName"]["child"]     = array();
		  $lmDefaultPages["$pageName"]["order"]     = sizeof($lmDefaultPages);
	  	//$lmDefaultPages["$pageName"] = $lmDefaultPages["$pageName"];
		} else {
		  $lmDefaultPages["$parentPage"]["child"]["$pageName"]["data"]      = $pageBaseData;
		  $lmDefaultPages["$parentPage"]["child"]["$pageName"]["meta"]      = $pageMetaData;
		  $lmDefaultPages["$parentPage"]["child"]["$pageName"]["sidebars"]  = $sidebars;
		  $lmDefaultPages["$parentPage"]["child"]["$pageName"]["show"]      = $showInMenu;
		  $lmDefaultPages["$parentPage"]["child"]["$pageName"]["child"]     = array();
		  $lmDefaultPages["$parentPage"]["child"]["$pageName"]["order"]     = sizeof($lmDefaultPages["$parentPage"]["child"]);
	  	  $lmDefaultPages["$pageName"] = $lmDefaultPages["$parentPage"]["child"]["$pageName"];
		}
	}
	function sortPages($a, $b) {
		if ($a["data"]["menu_order"] == $b["data"]["menu_order"]) {
			return 0;
		}

		return $a["data"]["menu_order"] < $b["data"]["menu_order"] ? -1: 1;;
	}

}

//add_action('init', array('I3D_Framework', 'register'), 1998);
  add_action('init', array('I3D_Framework', 'register'));
  if (isset($_GET['debug']) && $_GET['debug'] != "") {
	  I3D_Framework::setDebug(true);
  }
?>