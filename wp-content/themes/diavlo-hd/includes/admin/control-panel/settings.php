<?php
function i3d_admin_settings() {    
	global $templateName;
	global $i3dFrameworkVersion;
	global $i3dFrameworkRevision;
	global $lmIncludedComponents;
	global $typography;
	global $i3dBootstrapVersion;
	
	//$forceReload = false; // this is used for those settings which require a full page reload due to a global setting that would enable/disable different menu/options, such as the layout editor in version 4.3
	//echo I3D_Framework::getSignatureSliderID();
	
	// if the user clicks on the "refresh google fonts" button in the Typography section, this will fetch the latest list available from Google
	if (array_key_exists("refresh", $_GET) && $_GET['refresh'] == "fonts") {
		I3D_Framework::refreshGoogleFonts();

	
	// this is used when the user uploads a new image, via the "Branding" tab, for the FavIcons section
	} else if (array_key_exists("render", $_GET) && $_GET['render'] == "favicons-list") {
		$ob = ob_get_clean();
		$generalSettings = get_option('i3d_general_settings');
		renderFavIconListItems($generalSettings);
		exit;
	
	
	// when the installation starts, this will invoke the progress page
	} else if (array_key_exists('install', $_GET) && $_GET['install'] == "start") {
		i3d_show_installation_progress();
		
	// in the background, this will output the current status of the isntallation
	} else if (array_key_exists('install', $_GET) && $_GET['install'] == "progress") {
		$installationStatus = get_option("installation_status");
		$installationStatusPercent = get_option("installation_status_percent");
		if (!$installationStatus) {
			$installationStatus = "Please Wait...";
		}
		if (!$installationStatusPercent) {
			$installationStatusPercent = 0;
		}
		print "<div id='status'>{$installationStatus}</div>";
		print "<div id='status-percent'>{$installationStatusPercent}</div>";

	// if this is not a simple installation, such as if an existing site exists, then we need to invoke the "request configuration" page
	} else if (array_key_exists('config', $_GET) && $_GET['config'] == "requested") {
		i3d_request_configuration();
	
	// otherwise show the theme framework settings page
	} else { 

	// only used for i3dTHEMES direct purchase licenses
	 if (array_key_exists("show", $_GET) && $_GET['show'] == "whatsnew") {
		I3D_Framework::fetchExtensions();
	 }

	
// handle save
		$settingOptions = array();
		if(array_key_exists("cmd", $_POST) && $_POST['cmd'] == "save") {
			$saveSettings = array();
		
			if($_POST['wp_setting__page_on_front'] == "" || ($_POST['wp_setting__page_on_front'] == $_POST['wp_setting__page_for_posts'])) {
				update_option('show_on_front', 'posts');
			} else {
				update_option('show_on_front', 'page');
			}

			foreach($_POST as $key => $value) {
				if(substr($key,0,12) == "wp_setting__") {
					update_option(substr($key,12), stripslashes($value));
				} else if (substr($key,0,9) == "setting__") {					
					$newKeyData = explode("__", $key);
					
					if ($newKeyData[1] == "layout_editor") {
					   $tmp = get_option("i3d_general_settings");
					   if ($tmp['layout_editor'] != $value && $value == 1) {
						   $layouts = get_option('i3d_layouts', array());
						  // print sizeof($layouts);
						   if (sizeof($layouts) == 0) {
							
						     I3D_Framework::init_layouts(true);
						   }
					   }
					}
					
					
					if (sizeof($newKeyData) == 2) {
						$saveSettings[substr($key,9)] = stripslashes($value);
					
					} else if (sizeof($newKeyData) == 3) {
						$first = $newKeyData[1]; 
						$second = $newKeyData[2]; 
						$saveSettings["$first"]["$second"] = stripslashes($value);
				
					// primarily used for the "timed theme" settings, which use a multi-dimensional array to oranize data
					} else if (sizeof($newKeyData) == 4) {
						$first 	= $newKeyData[1]; 
						$second = $newKeyData[2]; 
						$third 	= $newKeyData[3]; 

						if ($second != "newtemp") {
							$saveSettings["$first"]["$second"]["$third"] = stripslashes($value);
						}
					// primarily used for the "timed theme" settings, which use a multi-dimensional array to oranize data
					} else if (sizeof($newKeyData) == 5) {
						$first 	= $newKeyData[1]; 
						$second = $newKeyData[2]; 
						$third 	= $newKeyData[3]; 
						$fourth = $newKeyData[4];
						
						if ($second != "newtemp") {
							$saveSettings["$first"]["$second"]["$third"]["$fourth"] = stripslashes($value);
						}
					// primarily used for the "timed theme" settings, which use a multi-dimensional array to oranize data
					} else if (sizeof($newKeyData) == 6) {
						$first 	= $newKeyData[1]; 
						$second = $newKeyData[2]; 
						$third 	= $newKeyData[3]; 
						$fourth = $newKeyData[4];
						$fifth  = $newKeyData[5];
						
						if ($second != "newtemp") {
							$saveSettings["$first"]["$second"]["$third"]["$fourth"]["$fifth"] = stripslashes($value);
						}
					// primarily used for the "timed theme" settings, which use a multi-dimensional array to oranize data
					} else if (sizeof($newKeyData) == 7) {
						$first 	= $newKeyData[1]; 
						$second = $newKeyData[2]; 
						$third 	= $newKeyData[3]; 
						$fourth = $newKeyData[4];
						$fifth  = $newKeyData[5];
						$sixth  = $newKeyData[6];
						
						if ($second != "newtemp") {
							$saveSettings["$first"]["$second"]["$third"]["$fourth"]["$fifth"]["$sixth"] = stripslashes($value);
						}
					}
				} else if (substr($key,0,16) == "layout_regions__") {
					$newKeyData = explode("__", $key);
					$layout = $newKeyData[1]; // default, business, magazine, etc
					$layoutRegion = $newKeyData[2]; // top, header top, main, footer
					$layoutKey = $newKeyData[3];
				
					$layoutRegions["$layout"]["$layoutRegion"]["$layoutKey"] = $value;
				} else if (substr($key, 0, 12) == "typography__") {
					$newKeyData = explode("__", $key);
					$index = $newKeyData[2];
				
					$field = $newKeyData[1]; // font-color, font size, index key
					if ($field != "index-key") {
				  		$path = $_POST["typography__index-key__{$index}"];				  
				  		$typography->set($path, $field, $value);
					}		  
				}
			} // end of foreach
			
			//$typography->clear();
			
			$typography->save();
			
			// if this theme supports multiple theme styles, then handle the saving of such settings
			if (sizeof(I3D_Framework::$themeStyleOptions) > 0) {
				// temporarily stored posted data in a temp array
				$timedThemeSettings = $saveSettings['theme_styles'];
				if (!is_array($timedThemeSettings)) {
					$timedThemeSettings = array();
				}
				
				$timedThemes = array();
				// iterate through the timed themes in the order that htey were sent in the post data
				// and save them to a new array
				foreach($_POST['timed_themes'] as $id) {
					if ($id != "newtemp") {
						$timedThemes[] = $timedThemeSettings["$id"];
					}
				}
				//$timedThemes = array();
				// re-apply the new array to the general theme settings
				$saveSettings['theme_styles'] = $timedThemes;
			//	var_dump($timedThemes[0]);
			}
			
			if (count($layoutRegions) > 0) {
				update_option("i3d_layout_regions", $layoutRegions);	
			}
		
			if(count($saveSettings) > 0) {
				update_option('i3d_general_settings', $saveSettings);
			}
			
			//print "saved";
		} // end of save
	
     
	 	// load/reload theme general settings
	  	$generalSettings 	= get_option('i3d_general_settings', array());
 		$generalSettings 	= wp_parse_args( (array) $generalSettings, array("drop_menu_id" => '', 'contact_menu_id' => '', 'use_search_box' => '', 'default_slider' => '', 'contact_panel_enabled' => '', 'contact_panel_icon_set' =>'', 'contact_panel_icon' => '', 'contact_panel_icon_close' => '', 'contact_panel_icon_close_set' => '', 'layout_type' => '', 'mobile_responsive' => '', 'tablet_responsive' => '', 'layout_max_content_width' => '', 'page_edge_style' => '', 'page_inner_style' => '', 'page_outer_style' => '' ) );	
		$generalSettings 	= wp_parse_args( (array) $generalSettings, array("website_name" => '', 'text_1' => '', 'text_2' => '', 'tagline_setting' => '', 'tagline' => '', 'custom_logo_setting' =>'', 'custom_logo_status' => '', 'custom_logo_filename' => '', 'custom_logo_retina_image_id' => '', 'disable_website_name_text_logo' => '', 'primary_theme_style' => '', 'theme_styles' => array()) );
 		$generalSettings 	= wp_parse_args( (array) $generalSettings, array("soundcloud_player_enabled" => '', 'soundcloud_player_autoplay' => '', 'soundcloud_player_playlist' => '') );
 		$generalSettings 	= wp_parse_args( (array) $generalSettings, array("copyright_message" => '', 'powered_by_message' => '', '404_message' => '', '404_show_search_bar' => '', '404_show_sitemap' => '', '404_show_archives' => '', '404_show_most_recent_posts' => '') );

		$themeInfo 			= wp_get_theme();	  
		$layoutRegions 		= get_option("i3d_layout_regions", array());
		if (!isset($_GET['tab'])) {
			$_GET['tab'] = "";
		}
		
		if (!isset($_GET['subtab'])) {
			$_GET['subtab'] = "";
		}
		
?>
<div id='i3d-fw-title-bar'>
<?php 
		$themeLogoFilename = get_template_directory() ."/Site/graphics/theme-logo.png";

		if (file_exists($themeLogoFilename)) {
			?><img src='<?php echo get_template_directory_uri()."/Site/graphics/theme-logo.png"; ?>' style=' width: 32px;' /><?php
		} else {
			I3D_Framework::i3d_screen_icon('aquila',  'width: 32px;');
		}
        ?>
		<h1><?php echo $themeInfo->Name; ?> Theme Settings</h1>
</div>
<?php if ($_GET['phpinfo'] == "1") {
	phpinfo();
	exit;
}
?>
<div class="wrap settings-wrap">

	<div class="settings-wrap-inner">
		<form method="post" style='display: inline; margin-bottom: 0px; padding-bottom: 0px;' target='saveframe' action="../wp-admin/admin.php?page=i3d-settings&tab=<?php echo $_GET['tab']?>">
        	<div id='saveregion'>
            	<div class='pull-left spinnerx'></div>
        		<button id="savebutton" class='pull-right btn btn-success' onclick='saveForm(this)'>Save</button> 
        		<button id="savebutton" class='pull-right btn btn-info' style='margin-right: 10px;' onclick='goWidgets()'><i class='icon-cogs'></i> Widgets</button> 
        	</div>
			<?php if (array_key_exists("upgraded", $_GET) && $_GET['upgraded']) { ?><div  class="alert alert-info" style="margin-bottom: 0px"><p><strong><?php echo $templateName; ?> has been activated.  Please update your settings as needed.</strong></p></div><?php } ?>

    		<div id="tabs">
      			<ul class='nav nav-tabs text-center'>
        			<li><a data-toggle='tab' id="tab-tabs-welcome" 			href="#tabs-welcome"><i class='fa fa-map'></i><br/><?php 			_e("Welcome", "i3d-framework"); ?></a></li>
        			<li><a data-toggle='tab' id="tab-tabs-initialization" 	href="#tabs-initialization"><i class='fa fa-toggle-on'></i><br/><?php 				_e("Initialization", "i3d-framework"); ?></a></li>
					<li><a data-toggle='tab' id="tab-tabs-configure" 		href="#tabs-configure"><i class='fa fa-dashboard'></i><br/><?php 				_e("Control Panel", "i3d-framework"); ?></a></li>
        			<li><a data-toggle='tab' id="tab-tabs-tutorials" 		href="#tabs-tutorials"><i class='fa fa-graduation-cap'></i><br/><?php 	_e("Instructions", "i3d-framework"); ?></a></li>
        			<li><a data-toggle='tab' id="tab-tabs-support" 			href="#tabs-support"><i class='fa fa-life-ring'></i><br/><?php 			_e("Support", "i3d-framework"); ?></a></li>
      			</ul>
      
      			<div id="tabs_container" class='tab-content'>
      			<?php
      			if (ini_get("max_input_vars") < 4000) {
      			
				if (ini_get("user_ini.filename") != "") {
			  		$ini_filename = $_SERVER['DOCUMENT_ROOT']."/".ini_get("user_ini.filename");
				} else {
			  		$ini_filename = $_SERVER['DOCUMENT_ROOT']."/"."php.ini";
				}
			
				if ($fp = fopen($ini_filename, "a+")) {
					fwrite($fp, "max_input_vars=4000\n");
					fclose($fp);
					$created_file = true;
					print "<!-- created {$ini_filename} -->";
				} else {
				   print "<!-- ini failed to create {$ini_filename} -->";
				}
if (!$created_file) { ?>

<style>
.alert-wrapper { max-width: 990px; margin: auto; padding: 20px 0px 20px; }
.alert-wrapper .alert { margin-bottom: 0px; }
#tabs .alert-wrapper h4 { margin: 0px; padding: 0px 0px 10px; }
</style>      			
      			<div class='alert-wrapper'>
      			<div class='alert alert-danger'><h4>Uh oh!</h4>We have detected that your web hosting is set up to only allow <?php echo ini_get("max_input_vars"); ?> input variables.  In order for this theme to properly
      			save its settings, you need to change this setting to a higher number.  Please add the following line to your <code>.user.ini</code> or <code>php.ini</code> file, or as your web hosting provider for instructions on where to update this setting.
			 <br/> <br/><code>max_input_vars=4000</code>
			 </div>
			 </div>
 <?php
 } 
 } else { ?><!-- passed input variable test --><?php } ?>      			
        			<div id="tabs-welcome" class='tab-pane'>
   						
						<div id="new-setting-error-tgmpa" class=''></div>
						
            			<div class='vector-icon-box-container'>
            				<div class='row-fluid'>
                                 <div class="col-xs-3">
                                    <div class='vector-icon-info-box'>
                                        <div class="hi-icon-wrap hi-icon-effect-1 hi-icon-effect-1a"><a class="hi-icon fa fa-toggle-off" href="#" onclick="jQuery('#tab-tabs-initialization').tab('show')">Initialization</a></div>
                                        <h3 class="small-caps text-center">Initialization</h3>
                                        <p class="text-center">Initialize sample data such as pages and posts, special components, and custom posts, here.</p>
                                        <p class='text-center'><a class="btn btn-primary" href="#" onclick="jQuery('#tab-tabs-initialization').tab('show')">Start Initializing &raquo;</a></p>
                                    </div>
                                </div>
 
                                <div class="col-xs-3">
                                    <div class='vector-icon-info-box'>
                                        <div class="hi-icon-wrap hi-icon-effect-1 hi-icon-effect-1a"><a class="hi-icon fa fa-dashboard" href="#" onclick="jQuery('#tab-tabs-configure').tab('show')">Control Panel</a></div>
                                        <h3 class="small-caps text-center">Control Panel</h3>
                                        <p class="text-center">Configure site-wide theme specific settings, such as your logo, social media accounts, and custom typography, here.</p>
                                        <p class='text-center'><a class="btn btn-primary" href="#" onclick="jQuery('#tab-tabs-configure').tab('show')">Start Configuring &raquo;</a></p>
                                    </div>
                                </div>
    
                                <div class="col-xs-3">
                                    <div class='vector-icon-info-box'>
                                        <div class="hi-icon-wrap hi-icon-effect-1 hi-icon-effect-1a"><a class="hi-icon fa fa-graduation-cap" href="#" onclick="jQuery('#tab-tabs-tutorials').tab('show')">Tutorials</a></div>
                                        <h3 class="small-caps text-center">Instructions</h3><p class="text-center">Learn how to configure every part of this theme with our comprehensive text and and video tutorials.</p>
                                        <p class='text-center'><a class="btn btn-primary" href="#" onclick="jQuery('#tab-tabs-tutorials').tab('show')">Start Learning &raquo;</a></p>
                                    </div>
                                </div>
                    
                                <div class="col-xs-3">
                                    <div class='vector-icon-info-box'>
                                        <div class="hi-icon-wrap hi-icon-effect-1 hi-icon-effect-1a"><a class="hi-icon fa fa-life-ring" href="#" onclick="jQuery('#tab-tabs-support').tab('show')">Support</a></div>
                                        <h3 class="small-caps text-center">Support</h3><p class="text-center">We're here if you need us!  We want this to be the best theme it can be, so if something isn't working, we will fix it!</p>
                                        <p class='text-center'><a class="btn btn-primary" href="#" onclick="jQuery('#tab-tabs-support').tab('show')">Get Help &raquo;</a></p>
                                    </div>
                                </div>
                            </div>						
						<div style='clear: both;'><br/></div>
						
						<div class='row-fluid'>
						  <div class='col-xs-12'>

						</div>
						</div>
						
						<?php /*
							<div class='alert alert-info' style='margin-top: 5px;'>Framework Version <?php echo I3D_Framework::getFrameworkVersion(); ?> (<?php echo I3D_Framework::getFrameworkVersionName(); ?>:<?php echo I3D_Framework::getFrameworkConfigurationName(); ?>)</div>
						*/
						?>

                			<div style='clear: both;'></div>
        				</div>
        			</div>
					<div id="tabs-initialization" class='tab-pane'>
					<div class='framework-checklist-wrapper'><h4>Initialization</h4>
					<p>Below, you will find a list of features and post types that are supported in this theme framework.  You may enable any you wish to use.</p>
					</div>
						<div class='panel panel-default theme-setup-checklist'>
						  <div class='panel-body'>
<?php
/*** INIT SECTION ***/
if (@$_GET['cmd'] == "init") {
	if ($_GET['type'] == "faqs") {
		I3D_Framework::init_faqs();
	}
	if ($_GET['type'] == "team_members") {
		I3D_Framework::init_team_members();
	}
	if ($_GET['type'] == "portfolio_items") {
		I3D_Framework::init_portfolio_items();
	}
	if ($_GET['type'] == "testimonials") {
		I3D_Framework::init_testimonials();
	}
	if ($_GET['type'] == "posts") {
		I3D_Framework::init_posts();
		
	}
	if ($_GET['type'] == "content_panel_groups") {
		I3D_Framework::init_content_panel_groups();		
	}

	if ($_GET['type'] == "focal_boxes") {
		I3D_Framework::init_focal_boxes();
	}

	if ($_GET['type'] == "calls_to_action") {
		I3D_Framework::init_calls_to_action();
	}

	if ($_GET['type'] == "active_backgrounds") {
		I3D_Framework::init_active_backgrounds();
	}
	
	if ($_GET['type'] == "pages") {
		I3D_Framework::init_pages();
		I3D_Framework::init_photo_slideshow();
		I3D_Framework::init_navigation();
	}

	if ($_GET['type'] == "forms") {
		I3D_Framework::init_forms();
	}

	if ($_GET['type'] == "widgets") {
		I3D_Framework::install_widgets();
	}
	if (@$_GET['jump'] == "posts") {
	  wp_redirect(admin_url("edit.php"));
	  
	} else if (@$_GET['jump'] == "forms") {
	  wp_redirect(admin_url("admin.php?page=i3d_contact_forms"));
	  
	} else if (@$_GET['jump'] == "active_backgrounds") {
	  wp_redirect(admin_url("admin.php?page=i3d_active_backgrounds"));
	  
	} else if (@$_GET['jump'] == "calls_to_action") {
	  wp_redirect(admin_url("admin.php?page=i3d_calls_to_action"));
	  
	} else if (@$_GET['jump'] == "focal_boxes") {
	  wp_redirect(admin_url("admin.php?page=i3d_focal_boxes"));
	  
	} else if (@$_GET['jump'] == "content_panel_groups") {
	  wp_redirect(admin_url("admin.php?page=i3d_content_panels"));
	  
	} else if (@$_GET['jump'] == "testimonials") {
	  wp_redirect(admin_url("edit.php?post_type=i3d-testimonial"));
	  
	} else if (@$_GET['jump'] == "portfolio_items") {
	  wp_redirect(admin_url("edit.php?post_type=i3d-portfolio-item"));
	  
	} else if (@$_GET['jump'] == "widgets") {
	  wp_redirect(admin_url("widgets.php"));
	  
	} else if (@$_GET['jump'] == "team_members") {
	  wp_redirect(admin_url("edit.php?post_type=i3d-team-member"));
	  
	} else if (@$_GET['jump'] == "faqs") {
	  wp_redirect(admin_url("edit.php?post_type=i3d-faq"));
	  
	} else if (@$_GET['jump'] == "pages") {
	  wp_redirect(admin_url("edit.php?post_type=page"));

	} else {
	  wp_redirect(admin_url("admin.php?page=i3d-settings&tab=tabs-initialization"));	
	}


}


?>
						  
						  
  				<table class='table table-striped'>
<?php $published_posts = sizeof(get_pages()); ?>
							  <tr>
								<td><h5>Pages <?php if ($published_posts <= 1 ) { ?><span class='label label-danger'>Recommended</span><?php } ?></h5>

<?php if ($published_posts <= 1 ) { ?><p>We can create you a standard website that you can use to build upon.</p><?php } ?>

	
								</td>
								<td class='text-right'>
						<?php		if ($published_posts <= 1) { ?>
<div class="btn-group pull-right">
  <a href='?page=i3d-settings&cmd=init&type=pages' class='btn btn-default item-button btn-sm'>Create Sample Pages/Navigation</a>
  <button type="button" class="btn btn-sm btn-default dropdown-toggle  item-toggle  btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="?page=i3d-settings&cmd=init&type=pages">Create &amp; Return Here</a></li>
    <li><a href="?page=i3d-settings&cmd=init&type=pages&jump=pages">Create &amp; Manage Pages</a></li>
  </ul>
</div>						
						
						

     <?php  } else { ?>

								
								<span class='label label-success pull-right label-large'><i class='glyphicon glyphicon-ok'></i> <?php echo $published_posts; ?> Page<?php if ($published_posts != 1) { ?>s<?php } ?> existing</p></span>
								<?php } ?>
								</td>
							  </tr>		
							  
<?php 

		$count_posts = wp_count_posts();
		$published_posts = $count_posts->publish;

?>
							  <tr>
								<td><h5>Posts <?php if ($published_posts <= 1 ) { ?><span class='label label-info'>Optional</span><?php } ?></h5>

<?php if ($published_posts <= 1 ) { ?><p>We can create some sample blog posts so that you can see how your blog page would look with content.</p><?php } ?>

	
								</td>
								<td class='text-right'>
						<?php		if ($published_posts <= 1) { ?>
<div class="btn-group pull-right">
 <a href='?page=i3d-settings&cmd=init&type=posts' class='btn btn-default btn-sm item-button'>Create Sample Posts</a>
  <button type="button" class="btn btn-sm btn-default dropdown-toggle  item-toggle  btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="?page=i3d-settings&cmd=init&type=posts">Create &amp; Return Here</a></li>
    <li><a href="?page=i3d-settings&cmd=init&type=posts&jump=posts">Create &amp; Manage Posts</a></li>
  </ul>
</div>	

	  

     <?php  } else { ?>

								
								<span class='label label-success pull-right label-large'><i class='glyphicon glyphicon-ok'></i> <?php echo $published_posts; ?> Post<?php if ($published_posts != 1) { ?>s<?php } ?> existing</p></span>
								<?php } ?>
								</td>
							  </tr>									  
<?php $widgetCount = 0;
global $wp_registered_widgets;
$sidebarWidgets = wp_get_sidebars_widgets();
$sidebars = get_option('i3d_sidebar_options');
if (!is_array($sidebars)) {
	$sidebars = array();
}
//var_dump($sidebars);
foreach ($sidebarWidgets as $sidebarName => $widgets) {
	//print $sidebarName."<br>";
    if ($widgets !== NULL) {
	if (array_key_exists($sidebarName, $sidebars)) {
	foreach ($widgets as $widgetID) {
	
	if (strpos($wp_registered_widgets["$widgetID"]['callback']['0']->id_base, "i3d_") !== false) {
		$widgetCount++;
	}
	}
	}
				 }
}
	?>
							  <tr>
								<td><h5>Widgets <?php if ($widgetCount == 0 ) { ?><span class='label label-danger'>Recommended</span><?php } ?></h5>

<?php if ($widgetCount == 0 ) { ?><p>We recommend having the default wigets installed and initalized.</p><?php } ?>

	
								</td>
								<td class='text-right'>
						<?php		if ($widgetCount == 0) { ?>
	
<div class="btn-group pull-right">
 <a href='?page=i3d-settings&cmd=init&type=widgets' class='btn btn-default btn-sm item-button'>Initialize Default Widgets</a>
  <button type="button" class="btn btn-sm btn-default dropdown-toggle  item-toggle  btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="?page=i3d-settings&cmd=init&type=widgets">Create &amp; Return Here</a></li>
    <li><a href="?page=i3d-settings&cmd=init&type=widgets&jump=widgets">Create &amp; Manage Widgets</a></li>
  </ul>
</div>	
     <?php  } else { ?>

								
								<span class='label label-success pull-right label-large'><i class='glyphicon glyphicon-ok'></i> <?php echo $widgetCount; ?> Widget<?php if ($widgetCount != 1) { ?>s<?php } ?> existing</p></span>
								<?php } ?>
								</td>
							  </tr>							  				  
						  </table>
						  
						    <h5 class='section-type'>Special Components</h5>
						    <table class='table table-striped'>
							  <?php $cfs = get_option("i3d_contact_forms"); 
							  if (!is_array($cfs)) {
								  $cfs = array();
							  }
							  ?>
							  <tr>
								<td><h5>Contact Forms <?php if (count($cfs) == 0 ) { ?><span class='label label-danger'>Recommended</span><?php } ?></h5>


	
	
								</td>
								<td class='text-right'>
								<?php if (count($cfs) == 0 ) { ?>
<div class="btn-group pull-right">
 <a href='?page=i3d-settings&cmd=init&type=forms' class='btn btn-default btn-sm item-button'>Initialize Default Forms</a>
  <button type="button" class="btn btn-sm btn-default dropdown-toggle  item-toggle  btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="?page=i3d-settings&cmd=init&type=forms">Create &amp; Return Here</a></li>
    <li><a href="?page=i3d-settings&cmd=init&type=forms&jump=forms">Create &amp; Manage Forms</a></li>
  </ul>
</div>	
								<?php } else { ?>
								<span class='label label-success pull-right label-large'><i class='glyphicon glyphicon-ok'></i> <?php echo count($cfs); ?> Forms existing</span>
								<?php } ?>
								</td>
							  </tr>

<?php $abs = get_option("i3d_active_backgrounds");
  if (!is_array($abs)) {
	  $abs = array();
  }
 ?>
							  <tr>
								<td><h5>Active Backgrounds <?php if (count($abs) == 0 ) { ?><span class='label label-danger'>Recommended</span><?php } ?></h5>


	
	
								</td>
								<td class='text-right'>
								<?php if (count($abs) == 0 ) { ?>

<div class="btn-group pull-right">
 <a href='?page=i3d-settings&cmd=init&type=active_backgrounds' class='btn btn-default btn-sm item-button'>Initialize Default Backgrounds</a>
  <button type="button" class="btn btn-sm btn-default dropdown-toggle  item-toggle  btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="?page=i3d-settings&cmd=init&type=active_backgrounds">Create &amp; Return Here</a></li>
    <li><a href="?page=i3d-settings&cmd=init&type=active_backgrounds&jump=active_backgrounds">Create &amp; Manage Backgrounds</a></li>
  </ul>
</div>	


								<?php } else { ?>
								<span class='label label-success pull-right label-large'><i class='glyphicon glyphicon-ok'></i> <?php echo count($abs); ?> Active Backgrounds existing</span>
								<?php } ?>
								</td>
							  </tr>
	<?php if (I3D_Framework::$focalBoxVersion > 0 ) { ?>

<?php $fbs = get_option("i3d_focal_boxes");
  if (!is_array($fbs)) {
	  $fbs = array();
  }

 ?>
							  <tr>
								<td><h5>Focal Boxes <?php if (count($fbs) == 0 ) { ?><span class='label label-danger'>Recommended</span><?php } ?></h5></td>
								<td class='text-right'>
								<?php if (count($fbs) == 0 ) { ?>
<div class="btn-group pull-right">
 <a href='?page=i3d-settings&cmd=init&type=focal_boxes' class='btn btn-default btn-sm item-button'>Initialize Sample Focal Boxes</a>
  <button type="button" class="btn btn-sm btn-default dropdown-toggle  item-toggle  btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="?page=i3d-settings&cmd=init&type=focal_boxes">Create &amp; Return Here</a></li>
    <li><a href="?page=i3d-settings&cmd=init&type=focal_boxes&jump=focal_boxes">Create &amp; Manage Focal Boxes</a></li>
  </ul>
</div>	



								<?php } else { ?>
								<span class='label label-success pull-right label-large'><i class='glyphicon glyphicon-ok'></i> <?php echo count($fbs); ?> Focal Boxes existing</span>
								<?php } ?>
								</td>
							  </tr>
<?php } ?>	

	<?php if (I3D_Framework::$focalBoxVersion == 0 ) { ?>

<?php $ctas = get_option("i3d_calls_to_action");
  if (!is_array($ctas)) {
	  $ctas = array();
  }


 ?>
							  <tr>
								<td><h5>Calls To Action <?php if (count($ctas) == 0 ) { ?><span class='label label-danger'>Recommended</span><?php } ?></h5></td>
								<td class='text-right'>
								<?php if (count($ctas) == 0 ) { ?>


<div class="btn-group pull-right">
 <a href='?page=i3d-settings&cmd=init&type=calls_to_action' class='btn btn-default btn-sm item-button'>Initialize Sample CTAs</a>
  <button type="button" class="btn btn-sm btn-default dropdown-toggle  item-toggle  btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="?page=i3d-settings&cmd=init&type=calls_to_action">Create &amp; Return Here</a></li>
    <li><a href="?page=i3d-settings&cmd=init&type=calls_to_action&jump=calls_to_action">Create &amp; Manage CTAs</a></li>
  </ul>
</div>	

								<?php } else { ?>
								<span class='label label-success pull-right label-large'><i class='glyphicon glyphicon-ok'></i> <?php echo count($ctas); ?> CTAs existing</span>
								<?php } ?>
								</td>
							  </tr>
<?php } ?>	

<?php  $cpgs = get_option("i3d_content_panel_groups");
  if (!is_array($cpgs)) {
	  $cpgs = array();
  }

 ?>
							  <tr>
								<td><h5>Content Panel Groups <?php if (count($cpgs) == 0 ) { ?><span class='label label-info'>Optional</span><?php } ?></h5>


	
	
								</td>
								<td class='text-right'>
								<?php if (count($cpgs) == 0 ) { ?>

<div class="btn-group pull-right">
 <a href='?page=i3d-settings&cmd=init&type=content_panel_groups' class='btn btn-default btn-sm item-button'>Initialize Sample CPG</a>
  <button type="button" class="btn btn-sm btn-default dropdown-toggle  item-toggle  btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="?page=i3d-settings&cmd=init&type=content_panel_groups">Create &amp; Return Here</a></li>
    <li><a href="?page=i3d-settings&cmd=init&type=content_panel_groups&jump=content_panel_groups">Create &amp; Manage CPG</a></li>
  </ul>
</div>	


								<?php } else { ?>
								<span class='label label-success pull-right label-large'><i class='glyphicon glyphicon-ok'></i> <?php echo count($cpgs); ?> CPGs existing</span>
								<?php } ?>
								</td>
							  </tr>
							</table>
							<?php 
							
							  $installed_plugins = get_plugins();
							//  var_dump($installed_plugins);
							  if ( ! isset( $installed_plugins['kindercare-tf-extender/kindercare-tf-extender.php'] ) ) {
								 $frameworkExists = false;
							
							  } else {
								  $frameworkExists = true;
								  
							  }
							  ?>
<h5 class='section-type'>Custom Post Types</h5>
													    <table class='table table-striped'>

							 <?php
							 if (post_type_exists("i3d-faq")) {
							 	$count_posts = wp_count_posts("i3d-faq");
								$published_posts = $count_posts->publish;
							 } else {
								$published_posts = 0;
							 }
	?>
							  <tr>
								<td><h5>Frequently Asked Questions <?php if ($published_posts == 0 ) { ?><span class='label label-info'>Optional</span><?php } ?></h5>
								<p>The FAQ Custom Post Type are used on the Frequently Asked Questions page.</p>
								<?php if (!post_type_exists("i3d-faq")) { ?><p class='requires'>Requires Framework Extender Plugin Activation</p><?php } else { ?>
								<!--<p class='item-status'>You have <?php echo $published_posts; ?> FAQ<?php if ($published_posts != 1) { ?>s<?php } ?> existing.</p>-->
								<?php } ?>
								</td>
								<td class='text-right'>
								
								 <?php if (!post_type_exists("i3d-faq")) { ?>
								 <?php if ($frameworkExists) { ?>
								<a class='btn btn-default'  href='plugins.php'  onclick='confirm("You will need to ACTIVATE the \"i3d Framework Extender\" plugin on the next page.")'>Activate Framework Extension Plugin</a>
								<?php } else { ?>
								<a class='btn btn-default'  href='themes.php?page=tgmpa-install-plugins'  onclick='confirm("You will need to INSTALL the \"i3d Framework Extender\" plugin on the next page.")'>Install Framework Extension Plugin</a>
								<?php } ?>
								<?php } else { ?>
	<?php if ($published_posts == 0) { ?>
	
<div class="btn-group pull-right">
 <a href='?page=i3d-settings&cmd=init&type=faqs' class='btn btn-default btn-sm item-button'>Create Sample FAQs</a>
  <button type="button" class="btn btn-sm btn-default dropdown-toggle  item-toggle  btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="?page=i3d-settings&cmd=init&type=faqs">Create &amp; Return Here</a></li>
    <li><a href="?page=i3d-settings&cmd=init&type=faqs&jump=faqs">Create &amp; Manage FAQs</a></li>
  </ul>
</div>	

     <?php } else { ?>
	 <span class='label label-success pull-right label-large'><i class='glyphicon glyphicon-ok'></i> Active</span>
	 <?php } ?>
								
								<?php } ?>
								</td>
							  </tr>
							
<?php
 if (post_type_exists("i3d-testimonial")) {
	$count_posts = wp_count_posts("i3d-testimonial");
	$published_posts = $count_posts->publish;
 } else {
	 $published_posts = 0;
 }
	?>							 
							  <tr>
								<td><h5>Quotations/Testimonials <?php if ($published_posts == 0 ) { ?><span class='label label-info'>Optional</span><?php } ?></h5>
								<p>This custom post type is used in the quotation rotator featured on the home page</p>
								<?php if (!post_type_exists("i3d-testimonial")) { ?><p class='requires'>Requires Framework Extender Plugin Activation</p><?php } else { ?>
								
								<?php } ?>
								</td>
								<td class='text-right'>
								 <?php if (!post_type_exists("i3d-testimonial")) { ?>
								 <?php if ($frameworkExists) { ?>
								<a class='btn btn-default'  href='plugins.php'  onclick='confirm("You will need to ACTIVATE the \"i3d Framework Extender\" plugin on the next page.")'>Activate Framework Extension Plugin</a>
								<?php } else { ?>
								<a class='btn btn-default'  href='themes.php?page=tgmpa-install-plugins'  onclick='confirm("You will need to INSTALL the \"i3d Framework Extender\" plugin on the next page.")'>Install Framework Extension Plugin</a>
								<?php } ?>
								<?php } else { ?>
<?php
	if ($published_posts == 0) { ?>
<div class="btn-group pull-right">
 <a href='?page=i3d-settings&cmd=init&type=testimonials' class='btn btn-default btn-sm item-button'>Create Sample Quotes</a>
  <button type="button" class="btn btn-sm btn-default dropdown-toggle  item-toggle  btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="?page=i3d-settings&cmd=init&type=testimonials">Create &amp; Return Here</a></li>
    <li><a href="?page=i3d-settings&cmd=init&type=testimonials&jump=testimonials">Create &amp; Manage Quotes</a></li>
  </ul>
</div>

     <?php } else { ?>
	  <span class='label label-success pull-right label-large'><i class='glyphicon glyphicon-ok'></i> <?php echo $published_posts; ?> Quotations existing</span>
	 
	 <?php } ?>								
								
								<?php } ?>
								</td>
							  </tr>
							
						  
							  <?php
							   if (post_type_exists("i3d-team-member")) {
	$count_posts = wp_count_posts("i3d-team-member");
	$published_posts = $count_posts->publish;
							   } else {
								$published_posts = 0;   
							   }
	
?>
							  <tr>
								<td><h5>Team Members <?php if ($published_posts == 0 ) { ?><span class='label label-info'>Optional</span><?php } ?></h5>
								<p>This custom post type is used on the staff/about us page, and optionally for the home page isotope photo gallery</p>
								<?php if (!post_type_exists("i3d-team-member")) { ?><p class='requires'>Requires Framework Extender Plugin Activation</p><?php } else { ?>
								
								<?php } ?>
								</td>
								<td class='text-right'>
								<?php if (!post_type_exists("i3d-team-member")) { ?>
								 <?php if ($frameworkExists) { ?>
								<a class='btn btn-default'  href='plugins.php'  onclick='confirm("You will need to ACTIVATE the \"i3d Framework Extender\" plugin on the next page.")'>Activate Framework Extension Plugin</a>
								<?php } else { ?>
								<a class='btn btn-default'  href='themes.php?page=tgmpa-install-plugins'  onclick='confirm("You will need to INSTALL the \"i3d Framework Extender\" plugin on the next page.")'>Install Framework Extension Plugin</a>
								<?php } ?>
								<?php } else { ?>
									<?php if ($published_posts == 0) { ?>
<div class="btn-group pull-right">
 <a href='?page=i3d-settings&cmd=init&type=team_members' class='btn btn-default btn-sm item-button'>Create Sample Team Members</a>
  <button type="button" class="btn btn-sm btn-default dropdown-toggle  item-toggle  btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="?page=i3d-settings&cmd=init&type=team_members">Create &amp; Return Here</a></li>
    <li><a href="?page=i3d-settings&cmd=init&type=team_members&jump=team_members">Create &amp; Manage Team Members</a></li>
  </ul>
</div>
     <?php } else { ?>
	  <span class='label label-success pull-right label-large'><i class='glyphicon glyphicon-ok'></i> <?php echo $published_posts; ?> Team Members existing</span>
	 <?php } ?>
								
								<?php } ?>
								</td>
							  </tr>
							
							  
<?php
if (I3D_Framework::$isotopePortfolioVersion > 0) {
 if (post_type_exists("i3d-portfolio-item")) {
	$count_posts = wp_count_posts("i3d-portfolio-item");
	$published_posts = $count_posts->publish;
 } else {
	 $published_posts = 0;
 }
?>
							  <tr>
								<td><h5>Portfolio Items <?php if ($published_posts == 0 ) { ?><span class='label label-info'>Optional</span><?php } ?></h5>
								<p>An optional custom post type, this is used if you wish to showcase items/projects/photos, especially in the context of an isotope photo gallery</p>
								<?php if (!post_type_exists("i3d-portfolio-item")) { ?><p class='requires'>Requires Framework Extender Plugin Activation</p><?php } else { ?>
								
								<?php } ?>
								</td>
								<td class='text-right'>
								<?php if (!post_type_exists("i3d-portfolio-item")) { ?>
								 <?php if ($frameworkExists) { ?>
								<a class='btn btn-default'  href='plugins.php'  onclick='confirm("You will need to ACTIVATE the \"i3d Framework Extender\" plugin on the next page.")'>Activate Framework Extension Plugin</a>
								<?php } else { ?>
								<a class='btn btn-default'  href='themes.php?page=tgmpa-install-plugins'  onclick='confirm("You will need to INSTALL the \"i3d Framework Extender\" plugin on the next page.")'>Install Framework Extension Plugin</a>
								<?php } ?>
								<?php } else { 
								
								?>
								<?php if ($published_posts == 0) { ?>

<div class="btn-group pull-right">
 <a href='?page=i3d-settings&cmd=init&type=portfolio_items' class='btn btn-default btn-sm item-button'>Create Sample Portfolio Items</a>
  <button type="button" class="btn btn-sm btn-default dropdown-toggle  item-toggle  btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="caret"></span>
    <span class="sr-only">Toggle Dropdown</span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="?page=i3d-settings&cmd=init&type=portfolio_items">Create &amp; Return Here</a></li>
    <li><a href="?page=i3d-settings&cmd=init&type=portfolio_items&jump=portfolio_items">Create &amp; Manage Portfolio Items</a></li>
  </ul>
</div>
     <?php } else { ?>
	  <span class='label label-success pull-right label-large'><i class='glyphicon glyphicon-ok'></i> <?php echo $published_posts; ?> Portfolio Items existing</span>
	 <?php } ?>

								<?php } ?>
</td>
							  </tr>
							  <?php } ?>
								
							</table>
						  </div>
						</div>					
					</div>
					<div id="tabs-configure" class='tab-pane'>
                        <ul class="nav nav-pills" >
                            <li <?php if ($_GET['subtab'] == "") { ?>class='active'<?php } ?>><a href="#quickstart" data-toggle="tab">Quickstart</a></li>
                            <li <?php if ($_GET['subtab'] == "style") { ?>class='active'<?php } ?>><a href="#style" data-toggle="tab">Look &amp Feel</a></li>
                            <li <?php if ($_GET['subtab'] == "branding") { ?>class='active'<?php } ?>><a href="#branding" data-toggle="tab">Branding</a></li>
                            <li <?php if ($_GET['subtab'] == "social") { ?>class='active'<?php } ?>><a href="#social" data-toggle="tab">Social Networks</a></li>
                            <li <?php if ($_GET['subtab'] == "customcode") { ?>class='active'<?php } ?>><a href="#customcode" data-toggle="tab">Custom Code</a></li>
                            <li <?php if ($_GET['subtab'] == "external-assets") { ?>class='active'<?php } ?>><a href="#external-assets" data-toggle="tab">External Assets</a></li>
                            <li <?php if ($_GET['subtab'] == "footer") { ?>class='active'<?php } ?>><a href="#footer" data-toggle="tab">Footer</a></li>
                            <li <?php if ($_GET['subtab'] == "404") { ?>class='active'<?php } ?>><a href="#four04" data-toggle="tab">404 Page</a></li>
                           <?php if (!I3D_Framework::use_global_layout()) { ?><li><a data-toggle='tab' id="tab-tabs-layouts" href="#tabs-layouts">Advanced <i class='icon-warning-sign tt' title='This is for advanced users.'></i></a></li><?php } ?>
                        </ul>
        				<div class="tab-content">
          					<div class="tab-pane<?php if ($_GET['subtab'] == "") { ?> active<?php } ?>" id="quickstart">
          						<!--<div class='updated updated-blue' style='padding: 10px; border-top: 1px solid #eeeeee;'>Be sure to go through the <b>Quickstart</b> settings page before continuing.</div>-->
          						<h4>The Basics</h4>
          						<ul class='input-items'>
									<li><label for="site_name">Website Name <i class='tt icon-info-sign' data-toggle="tooltip" title="This is used in your page titles and helps to identify you in search engine listings.  This will also display as your website title if you do not specify a custom website title within the General->Logo tab, or on each Page's BRANDING region."></i></label><input type="text" id="site_name" name="wp_setting__blogname" value="<?php form_option('blogname'); ?>" class="regular-text" /></li>
 									<li><label for="tagline">Default Tagline <i class='tt icon-info-sign' data-toggle="tooltip" title="A short description of your company, or slogan, that usually shows up under your Website Name"></i></label><input type="text" id="tagline" name="wp_setting__blogdescription" value="<?php form_option('blogdescription'); ?>" class="regular-text" /></li>
		    						<li><label for="admin_email">Email Address <i class='tt icon-info-sign' data-toggle="tootip" title="This address is used for admin purposes, such as new user notification." ></i></label><input type="email" id="admin_email" name="wp_setting__admin_email" value="<?php form_option('admin_email'); ?>" class="regular-text" /></li>           
          						</ul>
          						<h4>Default Pages</h4>
 		  						<ul class='input-items'>
                                    <li><label for="page_on_front">Home Page <i class='tt icon-info-sign' data-toggle="tootip" title="Choose the page you wish to use as the page the user first views when they visit your site." ></i></label><?php echo i3d_render_select("page_on_front", "-- Select Page --", get_pages(), get_option("page_on_front"), "pages"); ?></li>           
                                    <li><label for="page_for_posts">Blog Page <i class='tt icon-info-sign' data-toggle="tootip" title="Choose the page you want to use as your blog." ></i></label><?php echo i3d_render_select("page_for_posts", "-- Select Page --", get_pages(), get_option("page_for_posts"), "pages"); ?></li>           
                                    <li><label for="page_for_team-members">Team Members Page <i class='tt icon-info-sign' data-toggle="tootip" title="Choose the page you want to use to display the Team Members custom-post-type posts." ></i> </label><?php echo i3d_render_select("page_for_team-members", "-- Select Page --", get_pages(), get_option("page_for_team-members"), "pages"); ?></li>           
                                    <li><label for="page_for_faqs">FAQs Page <i class='tt icon-info-sign' data-toggle="tootip" title="Choose the page you want to use to display the FAQs custom-post-type posts." ></i> </label><?php echo i3d_render_select("page_for_faqs", "-- Select Page --", get_pages(), get_option("page_for_faqs"), "pages"); ?></li>           
                                    <li><label for="page_for_portfolio_items">Portfolio Items Page <i class='tt icon-info-sign' data-toggle="tootip" title="Choose the page you want to use to display the Portfolio Items custom-post-type posts." ></i> </label><?php echo i3d_render_select("page_for_portfolio_items", "-- Select Page --", get_pages(), get_option("page_for_portfolio_items"), "pages"); ?></li>           
                                    <li><label for="page_for_portfolio_items">Search Results Page <i class='tt icon-info-sign' data-toggle="tootip" title="Choose the page you want to use to display the Search Results." ></i> </label><?php echo i3d_render_select("page_for_search_results", "-- Select Page --", get_pages(), get_option("page_for_search_results"), "pages"); ?></li>           
                                    <?php if (I3D_Framework::$eventsCalendarSupport && is_plugin_active("the-events-calendar/the-events-calendar.php")) { ?>
                                    <li><label for="page_for_events">Events Calendar Page <i class='tt icon-info-sign' data-toggle="tootip" title="Choose the page you want to use to display the Events Calendar items." ></i> </label><?php echo i3d_render_select("page_for_events", "-- Select Page --", get_pages(), get_option("page_for_events"), "pages"); ?></li>           
                                    <?php } ?>
								</ul>
          

								<h4>Global Settings</h4>
								<ul class='input-items'>
									<li><label for="drop_menu_id">Primary Navigation <i class='tt icon-info-sign' data-toggle="tootip" title="Choose the menu you wish to use as a default for your primary navigation." ></i> </label><?php echo i3d_render_select("drop_menu_id", "-- Select Menu --", I3D_Framework::getAvailableMenus(), $generalSettings["drop_menu_id"], "select"); ?></li>           
                                    <?php if (I3D_Framework::$enableDropDownContactBox) { ?>
									<li><label for="contact_menu_id">Drop Down Contact Box <i class='tt icon-info-sign' data-toggle="tootip" title="Choose the contact form you wish to appear as a drop down at the top of your page." ></i> </label><?php echo i3d_render_select("contact_menu_id", "-- Select Contact Form --", I3D_Framework::getAvailableContactForms(), $generalSettings["contact_menu_id"], "select"); ?></li>           
                                    <?php } ?>
									<?php if (I3D_Framework::$globalSearchVersion == 1) { ?><li><label for="use_search_form">Search Box <i class='tt icon-info-sign' data-toggle="tootip" title="Show the site search box, that allows the user to search blog postings or pages." ></i> </label><?php echo i3d_render_select("use_search_box", "", array('1' => 'Enabled', '0' => 'Disabled'), $generalSettings["use_search_box"], "select"); ?></li><?php } ?>
                                    <?php if (sizeof(I3D_Framework::getSliders()) > 0) { ?>
									<li>
                                    	<label for="setting__default_slider">Default Slider <i class='tt icon-info-sign' data-toggle="tootip" title="Choose the slider you want to use as the default for those layouts that use a slider." ></i> </label>
										<select class='input-xlarge' name="setting__default_slider" id="setting__default_slider"><?php i3d_display_slider_options($generalSettings['default_slider']); ?></select>	
									</li>
									<?php } ?>
            						<?php if (I3D_Framework::$contactPanelVersion > 0) { ?>
									<li>
                                    	<label for="setting__contact_panel_enabled">Contact Panel <i class='tt icon-info-sign' data-toggle="tootip" title="The drop down panel at the top of the page." ></i></label>
			    						<select class='input-xlarge'  name="setting__contact_panel_enabled" id="setting__contact_panel_enabled" >
                      						<option <?php if ($generalSettings['contact_panel_enabled'] == "x")   { print "selected"; } ?> value="x">Off</option>
											<?php if (I3D_Framework::use_global_layout()) { ?>
											<option <?php if ($generalSettings['contact_panel_enabled'] == "globally" || $generalSettings['contact_panel_enabled'] == "")  { print "selected"; } ?> value="globally">Enabled</option>											
											<?php } else { ?>

											<option <?php if ($generalSettings['contact_panel_enabled'] == "globally" || $generalSettings['contact_panel_enabled'] == "")  { print "selected"; } ?> value="globally">Enabled Globally</option>
     	  									<option <?php if ($generalSettings['contact_panel_enabled'] == "page-by-page")   { print "selected"; } ?> value="page-by-page">Enabled Page-by-Page</option>
										    <?php } ?>
										</select>
									</li>
									<?php if (I3D_Framework::$contactPanelVersion == 1) { ?>
            						<li id="contact_panel_icon" <?php if ($generalSettings['contact_panel_enabled'] == "x") { ?>style='display: none;'<?php } ?>><label for="setting__contact_panel_icon">Contact Panel Icon <i class='tt icon-info-sign' data-toggle="tootip" title="The icon that the user clicks, for the drop down panel at the top of the page." ></i></label>
			                   		<?php 
										if ($generalSettings['contact_panel_icon_set'] == "") {
											$generalSettings['contact_panel_icon'] = "fa-envelope-o";
										}
										I3D_Framework::renderFontAwesomeSelect("setting__contact_panel_icon", $generalSettings['contact_panel_icon']); ?>
										<input type="hidden" name="setting__contact_panel_icon_set" value="1" />
									</li>   
									
            						<li id="contact_panel_icon_close" <?php if ($generalSettings['contact_panel_enabled'] == "x") { ?>style='display: none;'<?php } ?>><label for="setting__contact_panel_icon_close">Close Contact Panel Icon</label>
									<?php 
										if ($generalSettings['contact_panel_icon_set'] == "") {
										   $generalSettings['contact_panel_icon_close'] = "fa-envelope";
										}
							   			I3D_Framework::renderFontAwesomeSelect("setting__contact_panel_icon_close", $generalSettings['contact_panel_icon_close']); ?>
									</li>            
									<?php } // end of if $contactPanelVersion == 1 ?>
            						<?php } // end of if $contactPanelVersion > 0 ?>
									<li><label for="disable_admin_bar">Admin Bar <i class='tt icon-info-sign' data-toggle="tootip" title="Show or hide the admin bar, if you are logged, while browsing the website." ></i> </label><?php echo i3d_render_select("disable_admin_bar", "", array('0' => 'Enabled', '1' => 'Disabled'), @$generalSettings["disable_admin_bar"], "select"); ?></li>           
									<li><label for="horizontal_menu_activation">Horizontal Menu Activation <i class='tt icon-info-sign' data-toggle="tootip" title="The default action is to 'click-to-open' a drop menu, however you may opt to change this to a 'hover-to-open' action." ></i> </label><?php echo i3d_render_select("horizontal_menu_activation", "", array('0' => 'Click-To-Open', '1' => 'Hover-To-Open'), @$generalSettings["horizontal_menu_activation"], "select"); ?></li>           
									
          						</ul>
								
								<?php if ($i3dBootstrapVersion >= 3.0) { ?>
          						<h4>Layout</h4>
								<ul class='input-items'>
                                    <li><label for="mobile_responsive">Mobile Responsive <i class='tt icon-info-sign' data-toggle="tootip" title="Choose whether you want your site to be responsive for mobile browsers." ></i></label><?php echo i3d_render_select("mobile_responsive", "", array('1' => 'On', '0' => 'Off'), $generalSettings['mobile_responsive'], "select"); ?></li>           
                                    <li><label for="tablet_responsive">Tablet Responsive <i class='tt icon-info-sign' data-toggle="tootip" title="Choose whether you want your site to be responsive for tablet browsers." ></i></label><?php echo i3d_render_select("tablet_responsive", "", array('1' => 'On', '0' => 'Off'), $generalSettings['tablet_responsive'], "select"); ?></li>           
                                    <li><label for="layout_max_content_width">Maximum Content Width <i class='tt icon-info-sign' data-toggle="tootip" title="Choose maximum content width.  If nothing is specified, the default will be used." ></i></label><input type="text" id="max_content_width" name="setting__layout_max_content_width" value="<?php echo $generalSettings["layout_max_content_width"]; ?>" placeholder='1170px'  /></li>
									<?php if (sizeof(I3D_Framework::$optionalPageStyledEdges) > 0) { ?>
		    						<li><label for="page_edge_style">Default Edge Style <i class='tt icon-info-sign' data-toggle="tootip" title="Select the sitewide (global) setting for the content edging style." ></i></label><?php echo i3d_render_select("page_edge_style", "", I3D_Framework::$optionalPageStyledEdges, $generalSettings["page_edge_style"], "select"); ?></li>
									<?php } ?>       
 									<?php if (sizeof(I3D_Framework::$optionalPageInnerBackground) > 0) { ?>
		    						<li><label for="page_inner_style">Default Inner Box Style <i class='tt icon-info-sign' data-toggle="tootip" title="Select the sitewide (global) setting for the default inner box background." ></i></label><?php echo i3d_render_select("page_inner_style", "", I3D_Framework::$optionalPageInnerBackground, $generalSettings["page_inner_style"], "select"); ?></li>
									<?php } ?>          
									<?php if (sizeof(I3D_Framework::$optionalPageOuterBackground) > 0) { ?>
		    						<li><label for="page_outer_style">Default Outer Box Style <i class='tt icon-info-sign' data-toggle="tootip" title="Select the sitewide (global) setting for the outer box background." ></i></label><?php echo i3d_render_select("page_outer_style", "", I3D_Framework::$optionalPageOuterBackground, $generalSettings["page_outer_style"], "select"); ?></li>
									<?php } ?> 
									<?php if (I3D_Framework::$layoutEditorAvailable == 1 && @$generalSettings['layout_editor'] < 2) { ?>
                                    <li><label for="layout_editor">Global Layout Manager <i class='tt icon-info-sign' data-toggle="tootip" title="Choose whether you want to use the global layout manager." ></i></label><?php echo i3d_render_select("layout_editor", "", array('1' => 'On', '0' => 'Off'), @$generalSettings['layout_editor'], "select", "force_reload = true;"); ?></li>           
									
									<?php } else { ?>
									<input type='hidden' name="setting__layout_editor" value="<?php echo @$generalSettings['layout_editor']; ?>" />
									<?php } ?>
									
								</ul>
								
								<?php } ?>	      
          					</div> <!-- end of quickstart section -->
 

 							<div id="style" class='tab-pane<?php if ($_GET['subtab'] == "style") { ?> active<?php } ?>'>
 							<?php if (count(I3D_Framework::$themeStyleOptions) > 0) { ?>
								<h4>
								
								Display <a onclick='add_timed_theme()' class='btn btn-xs btn-default pull-right' style='margin-top: 3px;'><i class='fa fa-plus'></i> Add Timed Skin</a></h4>
          						<?php
								$theme_counter 	= 0;
								$themeStyles 	= @($generalSettings['theme_styles']);	  
								?>
          						<ul class='input-items'>
 		    						<li class='timed-theme' id='timed_theme__<?php echo $theme_counter; ?>'>
            							<label for="primary_theme_style">Primary Skin <i class='tt icon-info-sign' data-toggle="tootip" title="Choose the style for your theme." ></i></label>
										<?php 
			  							if (!isset($themeStyles["{$theme_counter}"]["style"])) {
			 	 							$themeStyles["{$theme_counter}"]["style"] = "";
			  							}
										
										echo i3d_render_select("theme_styles__{$theme_counter}__style", "", I3D_Framework::$themeStyleOptions, $themeStyles["{$theme_counter}"]["style"], "select:array:name", "handleThemeStyleChange(this)", 'class="form-control" style="max-width: 75px; display: inline-block;"'); ?><?php
										
										foreach (I3D_Framework::$themeStyleOptions as $style => $styleInfo) { 
			  								if (!isset($themeStyles["{$theme_counter}"]["{$style}_color"])) {
			 	 								$themeStyles["{$theme_counter}"]["{$style}_color"] = "";
			  								}
											
			    							echo "<span class='theme-selection'";
				  							if ($style == $themeStyles["{$theme_counter}"]["style"] || ($style ==  I3D_Framework::$themeDefaultStyle && $themeStyles["{$theme_counter}"]["style"] == "")) {
				  							} else {
					  							echo "style='display: none;'";
				  							}
											echo ">";
											
											echo i3d_render_select("theme_styles__{$theme_counter}__{$style}_color", "", $styleInfo['colors'], $themeStyles["{$theme_counter}"]["{$style}_color"], "select", "handleThemeStyleColorChange(this)",  'class="form-control" style="max-width: 75px; display: inline-block;"'); 
			    							echo "</span>";
											
										} ?>
										
										<div class='theme-layers' id='theme-layers-<?php echo $theme_counter; ?>'>
										  
										  <?php 
										  foreach (I3D_Framework::$themeStyleOptions as $style => $styleInfo) { 
										    $availableLayers = array();
											$allLayers = $styleInfo['layers'];
											
											if (!is_array($allLayers)) {
												$allLayers = array();
											}
											foreach ($allLayers as $type => $layers) { ?>
											<div class='theme-layer-block theme-layers-<?php echo $style; ?>-<?php echo $type; ?>'>
												<ul>
											  	<?php foreach ($layers as $index => $layerData) {
													    
														if ($layerData) {
															$layerName = $layerData['name'];
															$layerAvailableStates = array_reverse($layerData['states'], true);
															$layerDefaultState = $layerData['default_state'];
															?>
											    	<li>
														<label style='line-height: 40px; margin-right: 10px;' ><?php echo $layerName; ?></label>
														<div class='pull-right' style='line-height: 35px;'>
															<div data-toggle="buttons" class="btn-group">
															    <?php 
																//var_dump($themeStyles["{$theme_counter}"]["$style"]["layers"]["$type"]);
																foreach ($layerAvailableStates as $state => $stateDescription) { 
																      	$isSelectedState = false;
																		$buttonState = "btn-default";
																		if (@$themeStyles["{$theme_counter}"]["$style"]["layers"]["$type"]["$index"] == "" && $state == $layerDefaultState) {
																			$isSelectedState = true;
																		} else if (@$themeStyles["{$theme_counter}"]["$style"]["layers"]["$type"]["$index"] != "" && @$themeStyles["{$theme_counter}"]["$style"]["layers"]["$type"]["$index"] == $state) {
																		    $isSelectedState = true;
																		}
																		
																		if ($state == "0" && $isSelectedState) {
																			$buttonState = "btn-default btn-disabled active";
																		} else if ($state == "0") {
																			$buttonState = "btn-default btn-disabled";
																		} else if ($isSelectedState) {
																			$buttonState = "btn-success btn-enabled active";
																		} else {
																		    $buttonState = "btn-enabled btn-default";	
																		}
																		?>
																<label class="btn btn-sm <?php echo $buttonState; ?>"><input type="radio" <?php if ($isSelectedState) { print "checked=''"; } ?> id="setting__theme_styles__<?php echo $theme_counter; ?>__<?php echo $style; ?>__layers__<?php echo $type; ?>__<?php echo $index; ?>-<?php echo $state; ?>" name="setting__theme_styles__<?php echo $theme_counter; ?>__<?php echo $style; ?>__layers__<?php echo $type; ?>__<?php echo $index; ?>" value="<?php echo $state; ?>"><?php echo $stateDescription ?></label>
																<?php } // end of foreach ?>
															</div>	
														</div>									
													</li>
											  	<?php } 
													} // end of foreach layers ?>
											    </ul>
											</div>
											<?php } ?>
										
										<?php } ?>
										</div>
										
										<a id='layer-selector-<?php echo $theme_counter; ?>' data-title="Available Layers" data-toggle="popover" data-placement="left" class='btn btn-xs btn-default pull-right layer-selector' style='margin-top: 3px;'><i class='fa fa-edit'></i> Layers</a>

              							<input type="hidden" name="timed_themes[]" value="<?php echo $theme_counter; ?>" />

									</li> 
																											
																											
          
          						</ul>

		  						<ul id="sortable-theme-settings"  class='input-items'>
								<?php
								$timedThemes = $themeStyles;
								
								// the first "theme" is the primary/default theme, that is not timed
								array_shift($timedThemes);
								
								foreach ($timedThemes as $themeMarker => $themeData) {
									$theme_counter++;
									?> 
									<li class='timed-theme' id='timed_theme__<?php echo $theme_counter; ?>'>
										<label class='<?php if ($themeData['frequency'] == "daterange") { ?>double-height<?php } ?>'>Timed Theme <a onclick='remove_timed_theme("<?php echo $theme_counter; ?>")' class='btn btn-xs btn-danger pull-right' style='margin-top: 3px; margin-right: 15px;'>Remove</a></label>
									<?php			 
									if (!isset($themeStyles["{$theme_counter}"]["style"])) {
										$themeStyles["{$theme_counter}"]["style"] = "";
									}
									
									echo i3d_render_select("theme_styles__{$theme_counter}__style", "", I3D_Framework::$themeStyleOptions, $themeStyles["{$theme_counter}"]["style"], "select:array:name", "handleThemeStyleChange(this)", 'class="form-control" style="max-width: 75px; display: inline;"'); ?><?php
									
									foreach (I3D_Framework::$themeStyleOptions as $style => $styleInfo) { 
										if (!isset($themeStyles["{$theme_counter}"]["{$style}_color"])) {
											$themeStyles["{$theme_counter}"]["{$style}_color"] = "";
										}
										
			    						echo "<span class='theme-selection'";
										if ($style == $themeStyles["{$theme_counter}"]["style"] || ($style == "default" && $themeStyles["{$theme_counter}"]["style"] == "")) {
				  						} else {
											echo "style='display: none;'";
										}
										echo ">";
				
										echo i3d_render_select("theme_styles__{$theme_counter}__{$style}_color", "", $styleInfo['colors'], $themeStyles["{$theme_counter}"]["{$style}_color"], "select", "handleThemeStyleColorChange(this)", 'class="form-control" style="max-width: 75px;  display: inline;"'); 
			    						echo "</span>";
									} ?>            
              
										<div style='display: inline-block'>
											<select name="setting__theme_styles__<?php echo $theme_counter; ?>__frequency" onchange='setThemeFrequency(this)' class='form-control' style='max-width: 100px; display: inline;'>
												<option value='daily'>Daily</option>
												<option <?php if (@$themeData['frequency'] == "daterange") { echo "selected"; } ?> value='daterange'>Date Range</option>
											</select>
										</div> 
										<div class='i3d-theme-styles-times-container'>
											<div style='display: inline-block; vertical-align: top;'>
												<div <?php if ($themeData['frequency'] == "daily") { ?>style='display: none;'<?php } ?> class='input-group date' id="theme_styles__<?php echo $theme_counter; ?>__start_date_block"><input id="setting__theme_styles__<?php echo $theme_counter; ?>__start_date" name="setting__theme_styles__<?php echo $theme_counter; ?>__start_date" type='text' value="<?php echo $themeData['start_date']; ?>" placeholder="Start Date" class='form-control' style='max-width: 90px;' /><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
												<div  class='input-group date' id="theme_styles__<?php echo $theme_counter; ?>__start_time_block"><input id="setting__theme_styles__<?php echo $theme_counter; ?>__start_time" name="setting__theme_styles__<?php echo $theme_counter; ?>__start_time" data-date-format="HH:mm:ss" type='text' value="<?php echo $themeData['start_time']; ?>" placeholder="Start Time" class='form-control' style='max-width: 90px;' /><span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></div>
											</div>
											<div id="theme_styles__<?php echo $theme_counter; ?>__date_block-separator" style='display: inline-block; padding-left: 8px; padding-right: 8px;  text-align: center; line-height:  <?php if ($themeData['frequency'] == "daily") { ?>28px<?php } else { ?>55px<?php } ?>;'>to</div>
											<div style='display: inline-block; vertical-align: top;'>
												<div <?php if ($themeData['frequency'] == "daily") { ?>style='display: none;'<?php } ?> class='input-group date' id="theme_styles__<?php echo $theme_counter; ?>__end_date_block"><input id="setting__theme_styles__<?php echo $theme_counter; ?>__end_date" name="setting__theme_styles__<?php echo $theme_counter; ?>__end_date" type='text' value="<?php echo $themeData['end_date']; ?>" placeholder="End Date" class='form-control' style='max-width: 90px;' /><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
												<div  class='input-group date' id="theme_styles__<?php echo $theme_counter; ?>__end_time_block"><input id="setting__theme_styles__<?php echo $theme_counter; ?>__end_time" name="setting__theme_styles__<?php echo $theme_counter; ?>__end_time"  data-date-format="HH:mm:ss" type='text' value="<?php echo $themeData['end_time']; ?>" placeholder="End Time" class='form-control' style='max-width: 90px;' /><span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></div>
											</div>
											<script type="text/javascript">
											jQuery(function() {
												jQuery('#theme_styles__<?php echo $theme_counter; ?>__start_date_block').datetimepicker({ pickTime: false, useSeconds: false, minuteStepping: 15 });
												jQuery('#theme_styles__<?php echo $theme_counter; ?>__end_date_block').datetimepicker({ pickTime: false, useSeconds: false, minuteStepping: 15 });
											
												jQuery('#theme_styles__<?php echo $theme_counter; ?>__start_time_block').datetimepicker({ pickDate: false, useSeconds: false, minuteStepping: 15 });
												jQuery('#theme_styles__<?php echo $theme_counter; ?>__end_time_block').datetimepicker({ pickDate: false, useSeconds: false, minuteStepping: 15 });
											});
											</script>		
										</div>  
										
<div class='theme-layers' id='theme-layers-<?php echo $theme_counter; ?>'>
										  
										  <?php 
										  foreach (I3D_Framework::$themeStyleOptions as $style => $styleInfo) { 
										    $availableLayers = array();
											$allLayers = $styleInfo['layers'];
											
											if (!is_array($allLayers)) {
												$allLayers = array();
											}
											foreach ($allLayers as $type => $layers) { ?>
											<div class='theme-layer-block theme-layers-<?php echo $style; ?>-<?php echo $type; ?>'>
												<ul>
<?php foreach ($layers as $index => $layerData) {
													    
														if ($layerData) {
															$layerName = $layerData['name'];
															$layerAvailableStates = array_reverse($layerData['states'], true);
															$layerDefaultState = $layerData['default_state'];
															?>
											    	<li>
														<label style='line-height: 40px; margin-right: 10px;' ><?php echo $layerName; ?></label>
														<div class='pull-right' style='line-height: 35px;'>
															<div data-toggle="buttons" class="btn-group">
															    <?php foreach ($layerAvailableStates as $state => $stateDescription) { 
																      	$isSelectedState = false;
																		$buttonState = "btn-default";
																		if (@$themeStyles["{$theme_counter}"]["$style"]["layers"]["$type"]["$index"] == "" && $state == $layerDefaultState) {
																			$isSelectedState = true;
																		} else if (@$themeStyles["{$theme_counter}"]["$style"]["layers"]["$type"]["$index"] != "" && @$themeStyles["{$theme_counter}"]["$style"]["layers"]["$type"]["$index"] == $state) {
																		    $isSelectedState = true;
																		}
																		
																		if ($state == "0" && $isSelectedState) {
																			$buttonState = "btn-default btn-disabled active";
																		} else if ($state == "0") {
																			$buttonState = "btn-default btn-disabled";
																		} else if ($isSelectedState) {
																			$buttonState = "btn-success btn-enabled active";
																		} else {
																		    $buttonState = "btn-enabled btn-default";	
																		}
																		?>
																<label class="btn btn-sm <?php echo $buttonState; ?>"><input type="radio" <?php if ($isSelectedState) { print "checked=''"; } ?> id="setting__theme_styles__<?php echo $theme_counter; ?>__<?php echo $style; ?>__layers__<?php echo $type; ?>__<?php echo $index; ?>-<?php echo $state; ?>" name="setting__theme_styles__<?php echo $theme_counter; ?>__<?php echo $style; ?>__layers__<?php echo $type; ?>__<?php echo $index; ?>" value="<?php echo $state; ?>"><?php echo $stateDescription ?></label>
																<?php } // end of foreach ?>
															</div>	
														</div>									
													</li>
											  	<?php } 
													} // end of foreach layers ?>
											    </ul>
											</div>
											<?php } ?>
										
										<?php } ?>
										</div>
										
										<a id='layer-selector-<?php echo $theme_counter; ?>' data-title="Available Layers" data-toggle="popover" data-placement="left" class='btn btn-xs btn-default pull-right layer-selector' style='margin-top: 3px;'><i class='fa fa-edit'></i> Layers</a>
										
										<input type="hidden" name="timed_themes[]" value="<?php echo $theme_counter; ?>" />
            						
									</li>

								<?php 
								} 
								?>
								</ul>
							
								<ul style='display: none;' id='temp-timed-theme-settings'>
									<li class='timed-theme' id='timed_theme__newtemp'>
										<label>Timed Theme <a onclick='remove_timed_theme("newtemp")' class='btn btn-xs btn-danger pull-right' style='margin-top: 3px; margin-right: 15px;'>Remove</a></label>
										<?php			  
										echo i3d_render_select("theme_styles__newtemp__style", "", I3D_Framework::$themeStyleOptions, "", "select:array:name", "handleThemeStyleChange(this)", 'class="form-control" style="max-width: 75px; display: inline;"'); ?><?php
										foreach (I3D_Framework::$themeStyleOptions as $style => $styleInfo) { 
											echo "<span class='theme-selection'";
											if ($style == I3D_Framework::$themeDefaultStyle) {
											} else {
												echo "style='display: none;'";
											}
											echo ">";
											echo i3d_render_select("theme_styles__newtemp__{$style}_color", "", $styleInfo['colors'], "", "select", "", 'class="form-control" style="max-width: 75px;  display: inline;"'); 
											echo "</span>";
										}
										?>            
										<div style='display: inline-block'>
											<select name="setting__theme_styles__newtemp__frequency" onchange='setThemeFrequency(this)' class='form-control' style='max-width: 100px; display: inline;'>
												<option value='daily'>Daily</option>
												<option value='daterange'>Date Range</option>
											</select>
										</div> 
										<div class='i3d-theme-styles-times-container' >
											<div style='display: inline-block; vertical-align: top;'>
												<div style='display: none;'  class='input-group date' id="theme_styles__newtemp__start_date_block"><input id="setting__theme_styles__newtemp__start_date" name="setting__theme_styles__newtemp__start_date" type='text' value="" placeholder="Start Date" class='form-control' style='max-width: 90px;' /><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
												<div  class='input-group date' id="theme_styles__newtemp__start_time_block"><input id="setting__theme_styles__newtemp__start_time" name="setting__theme_styles__newtemp__start_time" data-date-format="HH:mm:ss" type='text' value="" placeholder="Start Time" class='form-control' style='max-width: 90px;' /><span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></div>
											</div>
											<div id="theme_styles__newtemp__date_block-separator" style='display: inline-block; padding-left: 8px; padding-right: 8px;  text-align: center; line-height: 28px;'>to</div>
											<div style='display: inline-block; vertical-align: top;'>
												<div  style='display: none;' class='input-group date' id="theme_styles__newtemp__end_date_block"><input id="setting__theme_styles__newtemp__end_date" name="setting__theme_styles__newtemp__end_date" type='text' value="" placeholder="End Date" class='form-control' style='max-width: 90px;' /><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
												<div  class='input-group date' id="theme_styles__newtemp__end_time_block"><input id="setting__theme_styles__newtemp__end_time" name="setting__theme_styles__newtemp__end_time"  data-date-format="HH:mm:ss" type='text' value="" placeholder="End Time" class='form-control' style='max-width: 90px;' /><span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></div>
											</div>
											
											
										</div>  
										
										<div class='theme-layers' id='theme-layers-newtemp'>
										  
										  <?php 
										  foreach (I3D_Framework::$themeStyleOptions as $style => $styleInfo) { 
										    $availableLayers = array();
											$allLayers = $styleInfo['layers'];
											
											if (!is_array($allLayers)) {
												$allLayers = array();
											}
											foreach ($allLayers as $type => $layers) { ?>
											<div class='theme-layer-block theme-layers-<?php echo $style; ?>-<?php echo $type; ?>'>
												<ul>
												<?php 
													$theme_counter = "newtemp";
													foreach ($layers as $index => $layerData) {
													    
														if ($layerData) {
															$layerName = $layerData['name'];
															$layerAvailableStates = array_reverse($layerData['states'], true);
															$layerDefaultState = $layerData['default_state'];
															?>
											    	<li>
														<label style='line-height: 40px; margin-right: 10px;' ><?php echo $layerName; ?></label>
														<div class='pull-right' style='line-height: 35px;'>
															<div data-toggle="buttons" class="btn-group">
															    <?php foreach ($layerAvailableStates as $state => $stateDescription) { 
																      	$isSelectedState = false;
																		$buttonState = "btn-default";
																		if ($state == $layerDefaultState) {
																			$isSelectedState = true;
																		}
																		
																		if ($state == "0" && $isSelectedState) {
																			$buttonState = "btn-default btn-disabled active";
																		} else if ($state == "0") {
																			$buttonState = "btn-default btn-disabled";
																		} else if ($isSelectedState) {
																			$buttonState = "btn-success btn-enabled active";
																		} else {
																		    $buttonState = "btn-enabled btn-default";	
																		}
																		?>
																<label class="btn btn-sm <?php echo $buttonState; ?>"><input type="radio" <?php if ($isSelectedState) { print "checked=''"; } ?> id="setting__theme_styles__<?php echo $theme_counter; ?>__<?php echo $style; ?>__layers__<?php echo $type; ?>__<?php echo $index; ?>-<?php echo $state; ?>" name="setting__theme_styles__<?php echo $theme_counter; ?>__<?php echo $style; ?>__layers__<?php echo $type; ?>__<?php echo $index; ?>" value="<?php echo $state; ?>"><?php echo $stateDescription ?></label>
																<?php } // end of foreach ?>
															</div>	
														</div>									
													</li>
											  	<?php } 
													} // end of foreach layers ?>											    </ul>
											</div>
											<?php } ?>
										
										<?php } ?>
										</div>
										
										<a id='layer-selector-<?php echo $theme_counter; ?>' data-title="Available Layers" data-toggle="popover" data-placement="left" class='btn btn-xs btn-default pull-right layer-selector' style='margin-top: 3px;'><i class='fa fa-edit'></i> Layers</a>
	
										<input type="hidden" name="timed_themes[]" value="newtemp" />
										
									</li>
									
								</ul>
         
								<?php } ?>
	 
								<?php if (array_key_exists("google-fonts", $_GET) && $_GET['google-fonts'] == "refreshed") { ?>
								<div class='updated' style='padding: 10px; border-top: 1px solid #eeeeee;'>The latest Google Fonts have been loaded successfully!</div>
								<?php } ?>
								<h4>Look &amp; Feel<a href='admin.php?page=i3d-settings&refresh=fonts' class='btn btn-info btn-xs pull-right' style='margin-top: 3px;'>Reload Google Fonts</a>
								</h4>
								<div id='i3d-typography-settings'>
								<?php 
								$section = "";
								foreach ($typography->items as $index => $item) { 
								  if ($item['section'] != $section) {
									  if ($section != "") {
										print "</ul>";  
									  }
									  $section = $item['section'];
									  
								    print "<h5>{$section}</h5>";
									print "<ul class='input-items'>";
								  }
								  ?>
									<li>
										<label><?php echo $item['name']; ?></label>
										<div class='settings-typography-column'>
										<?php $typography->renderComponents($index, $item['elements']); ?>
										</div>
									</li>           
								<?php } ?>
								</ul>
								</div>
								<div class='color-picker' id="colorpicker"></div>

							</div> <!-- end of look & feel / style section --> 
          
		  
		  
<script>
/*
	var f = jQuery.farbtastic('#colorpicker');

		jQuery('#i3d-typography-settings input[rel=color]')
      .each(function () { jQuery.farbtastic('#colorpicker').linkTo(this); jQuery(this).css('opacity', 0.75);})
      .focus(function() {
		  jQuery("#colorpicker").css("top", jQuery(this).offset().top - 80);
          jQuery(".colorwell-selected").css('opacity', 0.75).removeClass('colorwell-selected');
       
	    jQuery.farbtastic('#colorpicker').linkTo(this);
        jQuery('#colorpicker').css('opacity', 1);
        jQuery(this).css('opacity', 1).addClass('colorwell-selected');
      });	
	  */
	  
   jQuery(document).ready(function() {

	var originalOffsetFromTop = 0;
	var f = jQuery.farbtastic('#colorpicker');
    var p = jQuery('#colorpicker').css('opacity', 0.00);
    var selectedX = null;
	
    jQuery('.colorwell')
      .each(function () { jQuery.farbtastic('#colorpicker').linkTo(this); jQuery(this).css('opacity', 0.75); })
      .focus(function() {
   //     if (selectedX) {
			//if (originalOffsetFromTop == 0) {
			//	originalOffsetFromTop = jQuery("#colorpicker").offset().top;
				
			//} 
		  jQuery("#colorpicker").css("top", jQuery(this).offset().top - 80);
          jQuery(".colorwell-selected").css('opacity', 0.75).removeClass('colorwell-selected');
       
	    jQuery.farbtastic('#colorpicker').linkTo(this);
        jQuery('#colorpicker').css('opacity', 1);
        jQuery(this).css('opacity', 1).addClass('colorwell-selected');
      });
	  
	  
	  jQuery(document).click(function(event) {

										  if (!jQuery(event.target).hasClass("colorwell")) {
											   jQuery('#colorpicker').css('opacity', 0.0);
										  }
										  });
   });
   
   
</script>
							<div class="tab-pane<?php if ($_GET['subtab'] == "branding") { ?> active<?php } ?>" id="branding">
                                <?php if (I3D_Framework::$headerBGSupport) { ?>
								<h4>Header Background Image</h4>
                                <ul class='input-items'>
                                    <li>
                                    	<label  class='full-height-3x'>Choose Background Image <i class='tt icon-info-sign' data-toggle="tootip" title="Select a background image to use.  This may be overridden on a page-by-page basis." ></i>
									</label>
										<div style='height: 80px;'>

            
											<?php
											$random = rand();
                                            if(wp_attachment_is_image($generalSettings['header_bg_filename'])) {
                                                $metaData = get_post_meta($generalSettings['header_bg_filename'], '_wp_attachment_metadata', true);
                                                $fileName = I3D_Framework::get_image_upload_path($metaData['file']);			
                                                
                                            } else {
												$fileName = get_template_directory_uri()."/includes/admin/images/no_image_selected.png";
												$fileName = "";
                                            }


	
        ?>
		<div id="special_image_placeholder_wrapper_<?php echo $random; ?>">
	   	<div id="special_image_placeholder_<?php echo $random; ?>" class="special_image_placeholder3" style='display: inline-block;'>
			<?php if ($fileName != "") { ?>
			<img src='<?php echo $fileName; ?>' style='height: 80px;' />
			<?php } else { ?>
			
			<span class="fa-stack fa-3x">
  <i class="fa fa-square fa-stack-2x"></i>
  <i class="fa fa-picture-o fa-stack-1x fa-inverse"></i>
</span>
			<?php } ?>
	   </div>
	   
       <input style='vertical-align: middle; display: inline-block;' type='button' id="image_upload_button_<?php echo $random; ?>" class='button button-primary' value="<?php _e("Choose or Upload Image", "i3d-framework"); ?>" />
	   <input style='vertical-align: middle; display: inline-block;' type='button' id="clear_image_upload_button_<?php echo $random; ?>" class='button button-secondary <?php if ($fileName == "") { ?>hidden-block<?php } ?> ' value="<?php _e("Clear Image", "i3d-framework"); ?>" />
	   </div>
	   <input type="hidden" id="header_bg_filename" name="setting__header_bg_filename" value="<?php echo $generalSettings['header_bg_filename'] ?>" />

<script>
var file_frame;
jQuery('#clear_image_upload_button_<?php echo $random; ?>').live('click', function( event ){
	 		jQuery("#special_image_placeholder_<?php echo $random; ?>").html("<span class='fa-stack fa-3x'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-picture-o fa-stack-1x fa-inverse'></i></span>");
		jQuery("#header_bg_filename").val("");
		jQuery(this).addClass("hidden-block");
		
																			   
																				   });

jQuery('#image_upload_button_<?php echo $random; ?>').live('click', function( event ){
 
	event.preventDefault();
	// If the media frame already exists, reopen it.
	if ( typeof pagetype !== 'undefined'  ) {
		file_frame.open();
		return;
	}
 
	// Create the media frame.
	file_frame = wp.media.frames.file_frame = wp.media({
		title: jQuery( this ).data( 'uploader_title' ),
		button: {
			text: jQuery( this ).data( 'uploader_button_text' ),
		},
		multiple: false // Set to true to allow multiple files to be selected
	});
 
	// When an image is selected, run a callback.
	file_frame.on( 'select', function() {
		// We set multiple to false so only get one image from the uploader
		attachment = file_frame.state().get('selection').first().toJSON();
 		jQuery("#special_image_placeholder_<?php echo $random; ?>").html("<img src='"+attachment.url+"' height='80px' />");
		jQuery("#header_bg_filename").val(attachment.id);
		jQuery("#clear_image_upload_button_<?php echo $random; ?>").removeClass("hidden-block");
	});
 
	// Finally, open the modal
	file_frame.open();
});
 </script>
		
											
            							</div>
            						</li>
									</ul>							
							<?php } ?>
								<h4>Vector Icon</h4>
								<p style='margin-left: 10px;'>The default vector icon is only rendered if page settings for the logo do not enable the bigmap logo, and have the vector logo setting as "site default".</p>
          						<ul class='input-items'>
									<li><label for="vector_logo_icon">FontAwesome Icon <i class='tt icon-info-sign' data-toggle="tootip" title="Specify the class name for your icon." ></i></label>
                					<?php I3D_Framework::renderFontAwesomeSelect("setting__vector_logo_icon", $generalSettings['vector_logo_icon']); ?>     
                					</li>  
          						</ul>
          
								<h4>Textual Logo</h4>
								<ul class='input-items'>
            						<li>
                                    	<label for='i3d_logo_settings_3'>Website Title <i class='tt icon-info-sign' data-toggle="tooltip" title="Use this setting to override the Website Name (on the previous tab) as the default setting for your site.  This can be overriden within the BRANDING section on a page-by-page basis."></i></label>
										<select onchange='useTextLogo(this)' class='input-xlarge' name="setting__website_name" id="i3d_logo_settings_3" >
                                            <option <?php if ($generalSettings['website_name'] == "default") { print "selected"; } ?> value="default">-- Use Default Site Name --</option>
                                            <option <?php if (isset($generalSettings['website_name']) &&
																$generalSettings['website_name'] != "" && 
																$generalSettings['website_name'] != "default") { print "selected"; } ?> value="custom">-- Custom --</option>
        								</select>
        								<span id='i3d_logo_settings_text_logo' <?php if ($generalSettings['website_name'] != "custom") { print "class='non-visible'"; } ?>>
        									<input name="setting__text_1" value="<?php echo $generalSettings['text_1']; ?>" type='text'  style='margin-left: 10px;' placeholder='In First Color' />
											<input name="setting__text_2" value="<?php echo $generalSettings['text_2']; ?>" type='text'  placeholder='In Second Color' />	
										</span>
									</li>   
									<li>
										<label for='setting__tagline_setting'>Tagline<i class='tt icon-info-sign' data-toggle="tooltip" title="Use this setting to override the default Tagline (on the previous tab) as the default setting for your site. "></i></label>
										<select onChange="useTagline(this)" class='input-xlarge'  name="setting__tagline_setting" id="setting__tagline_setting" >
                                            <option <?php if ($generalSettings['tagline_setting'] == "default")  { print "selected"; } ?> value="default">-- Use Site Description --</option>
                                            <option <?php if ($generalSettings['tagline_setting'] == "disabled")  { print "selected"; } ?> value="disabled">-- Disabled --</option>
                                            <option <?php if ($generalSettings['tagline_setting'] == "custom")   { print "selected"; } ?> value="custom">-- Custom --</option>
                                        </select>
										<span id='i3d_logo_settings_tagline' <?php if ($generalSettings['tagline_setting'] != "custom") { print "class='non-visible'"; } ?>>                
        									<input name="setting__tagline" value="<?php echo $generalSettings['tagline']; ?>"  type="text"  style='margin-left: 10px;' placeholder='Custom Tagline' /> 
										</span>
                                    </li>
                                </ul>      

								<h4>Logo Link</h4>
								<ul class='input-items'>
            						<li>
                                    	<label for='i3d_logo_settings_link'>Link To <i class='tt icon-info-sign' data-toggle="tooltip" title="Use this setting to override the default link settig for the logo at the top of your site. "></i></label>
										<select onchange='setLink(this)' class='input-xlarge' name="setting__link" id="i3d_logo_settings_link" >
                                            <option <?php if (@$generalSettings['link'] == "default") { print "selected"; } ?> value="default">-- Use Default (<?php echo home_url(); ?>) --</option>
                                            <option <?php if (@$generalSettings['link'] == "disabled") { print "selected"; } ?> value="disabled">-- Disabled --</option>
                                            <option <?php if (@$generalSettings['link'] == "custom") { print "selected"; } ?> value="custom">-- Custom --</option>
        								</select>
        								<span id='i3d_logo_settings_link_custom' <?php if (@$generalSettings['link'] != "custom") { print "class='non-visible'"; } ?>>
        									<input name="setting__link_custom" value="<?php echo @$generalSettings['link_custom']; ?>" type='text'  style='margin-left: 10px;' placeholder='http://www.somewebsite.com/' />
										</span>
									</li>   
                                </ul>      

								
								<h4>Graphic Logo</h4>
                                 <div class='text-right' style='margin-top: -30px; margin-bottom: 10px;'>Video Help: Why is my graphic logo not showing up? <a href='https://youtu.be/I6m5Lc8Fh8U' target='_blank'>Click here to watch the video tutorial.</a></div>
                               <ul class='input-items'>
                                    <li class='custom_logo_status'><label for="custom_logo_status">Use Bitmap Logo <i class='tt icon-info-sign' data-toggle="tootip" title="Provide your own graphic logo for more impact." ></i></label><input type="checkbox" id="custom_logo_status" value="1" name="setting__custom_logo_status" onclick="check_status(this)" <?php if(isset($generalSettings['custom_logo_status']) && $generalSettings['custom_logo_status'] == '1') { echo 'checked="checked"'; }?> /></li>           
                                    <li <?php if(!isset($generalSettings['custom_logo_status']) || !$generalSettings['custom_logo_status']) { //echo 'style="display: none;"';
									}?> >
                                    	<label  class='full-height-3x'>Choose Graphic <i class='tt icon-info-sign' data-toggle="tootip" title="Select from Transparent PNG files uploaded to the media gallery" ></i>
										<?php if (I3D_Framework::$recommendedLogoDimensions != "") { ?><span class='additional-info'>Recommended <?php echo I3D_Framework::$recommendedLogoDimensions; ?></span><?php } ?></label>
										<div style='height: 80px;'>

            
											<?php
											$random = rand();
                                            if(wp_attachment_is_image($generalSettings['custom_logo_filename'])) {
                                                $metaData = get_post_meta($generalSettings['custom_logo_filename'], '_wp_attachment_metadata', true);
                                                $fileName = I3D_Framework::get_image_upload_path($metaData['file']);			
                                                
                                            } else {
												$fileName = get_template_directory_uri()."/includes/admin/images/no_image_selected.png";
												$fileName = "";
                                            }


	
        ?>
		<div id="special_image_placeholder_wrapper_<?php echo $random; ?>">
	   	<div id="special_image_placeholder_<?php echo $random; ?>" class="special_image_placeholder2" style='display: inline-block;'>
			<?php if ($fileName != "") { ?>
			<img src='<?php echo $fileName; ?>' style='height: 80px;' />
			<?php } else { ?>
			
			<span class="fa-stack fa-3x">
  <i class="fa fa-square fa-stack-2x"></i>
  <i class="fa fa-picture-o fa-stack-1x fa-inverse"></i>
</span>
			<?php } ?>
	   </div>
	   
       <input style='vertical-align: middle; display: inline-block;' type='button' id="image_upload_button_<?php echo $random; ?>" class='button button-primary' value="<?php _e("Choose or Upload Image", "i3d-framework"); ?>" />
	   <input style='vertical-align: middle; display: inline-block;' type='button' id="clear_image_upload_button_<?php echo $random; ?>" class='button button-secondary <?php if ($fileName == "") { ?>hidden-block<?php } ?> ' value="<?php _e("Clear Image", "i3d-framework"); ?>" />
	   </div>
	   <input type="hidden" id="custom_logo_file" name="setting__custom_logo_filename" value="<?php echo $generalSettings['custom_logo_filename'] ?>" />

<script>
var file_frame;
jQuery('#clear_image_upload_button_<?php echo $random; ?>').live('click', function( event ){
	 		jQuery("#special_image_placeholder_<?php echo $random; ?>").html("<span class='fa-stack fa-3x'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-picture-o fa-stack-1x fa-inverse'></i></span>");
		jQuery("#custom_logo_file").val("");
		jQuery(this).addClass("hidden-block");
		
																			   
																				   });

jQuery('#image_upload_button_<?php echo $random; ?>').live('click', function( event ){
 
	event.preventDefault();
	// If the media frame already exists, reopen it.
	if ( typeof pagetype !== 'undefined'  ) {
		file_frame.open();
		return;
	}
 
	// Create the media frame.
	file_frame = wp.media.frames.file_frame = wp.media({
		title: jQuery( this ).data( 'uploader_title' ),
		button: {
			text: jQuery( this ).data( 'uploader_button_text' ),
		},
		multiple: false // Set to true to allow multiple files to be selected
	});
 
	// When an image is selected, run a callback.
	file_frame.on( 'select', function() {
		// We set multiple to false so only get one image from the uploader
		attachment = file_frame.state().get('selection').first().toJSON();
 		jQuery("#special_image_placeholder_<?php echo $random; ?>").html("<img src='"+attachment.url+"' height='80px' />");
		jQuery("#custom_logo_file").val(attachment.id);
		jQuery("#clear_image_upload_button_<?php echo $random; ?>").removeClass("hidden-block");
	});
 
	// Finally, open the modal
	file_frame.open();
});
 </script>
		
											
            							</div>
            						</li>
                					<li <?php if(!@$generalSettings['custom_logo_status'] ) { //echo 'style="display: none;"';
									}?> >
                                    	<label for="custom_logo_file_retina" class='full-height-3x'>Choose Retina Graphic <i class='tt icon-info-sign' data-toggle="tootip" title="This graphic should be twice as tall and twice as wide as the standard graphic logo." ></i>
										
										<?php if (I3D_Framework::$recommendedRetinaLogoDimensions != "") { ?><span class='additional-info'>Recommended <?php echo I3D_Framework::$recommendedRetinaLogoDimensions; ?></span><?php } ?></label>
										
										</label>
    
										
										<div style='height: 80px;'>

            
											<?php
											$random = rand();
                                            if(wp_attachment_is_image(@$generalSettings['custom_logo_file_retina'])) {
                                                $metaData = get_post_meta($generalSettings['custom_logo_file_retina'], '_wp_attachment_metadata', true);
                                                $fileName = I3D_Framework::get_image_upload_path($metaData['file']);			
                                                
                                            } else {
												$fileName = get_template_directory_uri()."/includes/admin/images/no_image_selected.png";
												$fileName = "";
                                            }


	
        ?>
		<div id="special_image_placeholder2_wrapper_<?php echo $random; ?>">
	   	<div id="special_image_placeholder2_<?php echo $random; ?>" class="special_image_placeholder2" style='display: inline-block;'>
			<?php if ($fileName != "") { ?>
			<img src='<?php echo $fileName; ?>' style='max-height: 50px;' />
			<?php } else { ?>
			
			<span class="fa-stack fa-3x">
  <i class="fa fa-square fa-stack-2x"></i>
  <i class="fa fa-picture-o fa-stack-1x fa-inverse"></i>
</span>
			<?php } ?>
	   </div>
	   
       <input style='vertical-align: middle; display: inline-block;' type='button' id="image_upload_button2_<?php echo $random; ?>" class='button button-primary' value="<?php _e("Choose or Upload Image", "i3d-framework"); ?>" />
	   <input style='vertical-align: middle; display: inline-block;' type='button' id="clear_image_upload_button2_<?php echo $random; ?>" class='button button-secondary <?php if ($fileName == "") { ?>hidden-block<?php } ?>' value="<?php _e("Clear Image", "i3d-framework"); ?>" />
	 
	   </div>
	   <input type="hidden" id="custom_logo_file_retina" name="setting__custom_logo_file_retina" value="<?php echo @$generalSettings['custom_logo_file_retina'] ?>" />

<script>
var file_frame;

jQuery('#clear_image_upload_button2_<?php echo $random; ?>').live('click', function( event ){
	 		jQuery("#special_image_placeholder2_<?php echo $random; ?>").html("<span class='fa-stack fa-3x'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-picture-o fa-stack-1x fa-inverse'></i></span>");
		jQuery("#custom_logo_file").val("");
		jQuery(this).addClass("hidden-block");
		
																			   
																				   });

jQuery('#image_upload_button2_<?php echo $random; ?>').live('click', function( event ){
 
	event.preventDefault();
	// If the media frame already exists, reopen it.
	if ( typeof pagetype !== 'undefined'  ) {
		file_frame.open();
		return;
	}
 
	// Create the media frame.
	file_frame = wp.media.frames.file_frame = wp.media({
		title: jQuery( this ).data( 'uploader_title' ),
		button: {
			text: jQuery( this ).data( 'uploader_button_text' ),
		},
		multiple: false // Set to true to allow multiple files to be selected
	});
 
	// When an image is selected, run a callback.
	file_frame.on( 'select', function() {
		// We set multiple to false so only get one image from the uploader
		attachment = file_frame.state().get('selection').first().toJSON();
 		jQuery("#special_image_placeholder2_<?php echo $random; ?>").html("<img src='"+attachment.url+"' height='80px' />");
		jQuery("#custom_logo_file_retina").val(attachment.id);
		jQuery("#clear_image_upload_button2_<?php echo $random; ?>").removeClass("hidden-block");
	});
 
	// Finally, open the modal
	file_frame.open();
});
 </script>
		
											
            							</div>										
                                    </li>           
                					<li <?php if(!$generalSettings['custom_logo_status']) { echo 'style="display: none;"'; }?> class="custom_logo_status_enabled custom_logo_regular_height" >
                                    	<label for="disable_website_name_text_logo">Disable "Website Name" Text <i class='tt icon-info-sign' data-toggle="tootip" title="Disable the 'website name' text logo that is displayed by default." ></i></label>
                                        <input type="checkbox" id="disable_website_name_text_logo" name="setting__disable_website_name_text_logo" value="1" <?php if($generalSettings['disable_website_name_text_logo'] == true) { echo 'checked="checked"'; }?> />
									</li>           

                                </ul>
								<script>
									var userImages = new Array();
									var templatePath = "<?php echo get_template_directory_uri() ; ?>";
									<?php echo @$imageOptions; ?>
								</script>	


          						<h4 style='clear: both;' >FavIcons  		<a href='javascript:;' onclick='goFavIcoMediaWindow()' class='btn btn-default' style='margin-bottom: -7px; margin-top: -5px;'><i class='fa fa-upload'></i></a></h4>
                                <ul class='input-items' id='favicons-container'>
                                	<?php renderFavIconListItems($generalSettings); ?>
                                </ul>
          					</div> <!-- end of branding section -->
							
          					<div class="tab-pane<?php if ($_GET['subtab'] == "social") { ?> active<?php } ?>" id="social">
								<ul class='input-items'>
									<li><label for="social_media_apple_url"><img src="../wp-content/themes/<?php echo get_template(); ?>/Site/icons/images/fc-webicon-apple-s.png" /> Apple App Store URL <i class='tt icon-info-sign' data-toggle="tootip" title="URL of your Apple AppStore app." ></i></label><input type="url" id="social_media_apple_url" name="setting__social_media_apple_url" value="<?php echo @($generalSettings["social_media_apple_url"]); ?>" /></li>           
									<li><label for="social_media_behance_url"><img src="../wp-content/themes/<?php echo get_template(); ?>/Site/icons/images/fc-webicon-behance-s.png" /> Behance URL <i class='tt icon-info-sign' data-toggle="tootip" title="URL of your Behance page." ></i></label><input class='input-xxlarge'  type="url" id="social_media_behance_url" name="setting__social_media_behance_url" value="<?php echo @($generalSettings["social_media_behance_url"]); ?>" /></li>           
									<li><label for="social_media_bitbucket_url"><img src="../wp-content/themes/<?php echo get_template(); ?>/Site/icons/images/fc-webicon-bitbucket-s.png" /> BitBucket URL <i class='tt icon-info-sign' data-toggle="tootip" title="URL of your BitBucket page." ></i></label><input class='input-xxlarge'  type="url" id="social_media_bitbucket_url" name="setting__social_media_bitbucket_url" value="<?php echo @($generalSettings["social_media_bitbucket_url"]); ?>" /></li>           
									<li><label for="social_media_blogger_url"><img src="../wp-content/themes/<?php echo get_template(); ?>/Site/icons/images/fc-webicon-blogger-s.png" /> Blogger URL <i class='tt icon-info-sign' data-toggle="tootip" title="URL of your Blogger page." ></i></label><input class='input-xxlarge'  type="url" id="social_media_blogger_url" name="setting__social_media_blogger_url" value="<?php echo @($generalSettings["social_media_blogger_url"]); ?>" /></li>           
									<li><label for="social_media_dribble_url"><img src="../wp-content/themes/<?php echo get_template(); ?>/Site/icons/images/fc-webicon-dribbble-s.png" /> Dribble URL <i class='tt icon-info-sign' data-toggle="tootip" title="URL of your Dribble page." ></i></label><input class='input-xxlarge'  type="url" id="social_media_dribble_url" name="setting__social_media_dribble_url" value="<?php echo @($generalSettings["social_media_dribble_url"]); ?>" /></li>           
									<li><label for="social_media_dropbox_url"><img src="../wp-content/themes/<?php echo get_template(); ?>/Site/icons/images/fc-webicon-dropbox-s.png" /> Dropbox URL <i class='tt icon-info-sign' data-toggle="tootip" title="URL of your Dropbox page." ></i></label><input class='input-xxlarge'  type="url" id="social_media_dropbox_url" name="setting__social_media_dropbox_url" value="<?php echo @($generalSettings["social_media_dropbox_url"]); ?>" /></li>           
									<li><label for="social_media_facebook_url"><img src="../wp-content/themes/<?php echo get_template(); ?>/Site/icons/images/fc-webicon-facebook-s.png" /> Facebook URL <i class='tt icon-info-sign' data-toggle="tooltip" title="URL of your Facebook page."></i></label><input class='input-xxlarge'  type="url" id="social_media_facebook_url" name="setting__social_media_facebook_url" value="<?php echo @($generalSettings["social_media_facebook_url"]); ?>" /></li>
									<li><label for="social_media_flickr_url"><img src="../wp-content/themes/<?php echo get_template(); ?>/Site/icons/images/fc-webicon-flickr-s.png" /> Flickr URL <i class='tt icon-info-sign' data-toggle="tootip" title="URL of your Flickr page." ></i></label><input class='input-xxlarge'  type="url" id="social_media_flickr_url" name="setting__social_media_flickr_url" value="<?php echo @($generalSettings["social_media_flickr_url"]); ?>" /></li>           
									<li><label for="social_media_github_url"><img src="../wp-content/themes/<?php echo get_template(); ?>/Site/icons/images/fc-webicon-github-s.png" /> GitHub URL <i class='tt icon-info-sign' data-toggle="tootip" title="URL of your GitHub page." ></i></label><input class='input-xxlarge'  type="url" id="social_media_github_url" name="setting__social_media_github_url" value="<?php echo @($generalSettings["social_media_github_url"]); ?>" /></li>           
									<li><label for="social_media_google_url"><img src="../wp-content/themes/<?php echo get_template(); ?>/Site/icons/images/fc-webicon-googleplus-s.png" /> Google+ URL <i class='tt icon-info-sign' data-toggle="tootip" title="URL of your Google+ page."></i></label><input class='input-xxlarge'  type="url" id="social_media_google_url" name="setting__social_media_googleplus_url" value="<?php echo @($generalSettings["social_media_googleplus_url"]); ?>" /></li>         
									<li><label for="social_media_googleplay_url"><img src="../wp-content/themes/<?php echo get_template(); ?>/Site/icons/images/fc-webicon-googleplay-s.png" /> GooglePlay URL <i class='tt icon-info-sign' data-toggle="tootip" title="URL of your GooglePlay app." ></i></label><input class='input-xxlarge'  type="url" id="social_media_googleplay_url" name="setting__social_media_googleplay_url" value="<?php echo @($generalSettings["social_media_googleplay_url"]); ?>" /></li>          
									<li><label for="social_media_houzz_url"><img src="../wp-content/themes/<?php echo get_template(); ?>/Site/icons/images/fc-webicon-houzz-s.png" /> Houzz URL <i class='tt icon-info-sign' data-toggle="tootip" title="URL of your HOuzz page." ></i></label><input class='input-xxlarge'  type="url" id="social_media_houzz_url" name="setting__social_media_houzz_url" value="<?php echo @($generalSettings["social_media_houzz_url"]); ?>" /></li>
									<li><label for="social_media_instagram_url"><img src="../wp-content/themes/<?php echo get_template(); ?>/Site/icons/images/fc-webicon-instagram-s.png" /> Instagram URL <i class='tt icon-info-sign' data-toggle="tootip" title="URL of your Instagram page." ></i></label><input class='input-xxlarge'  type="url" id="social_media_instagram_url" name="setting__social_media_instagram_url" value="<?php echo @($generalSettings["social_media_instagram_url"]); ?>" /></li>
									<li><label for="social_media_linkedin_url"><img src="../wp-content/themes/<?php echo get_template(); ?>/Site/icons/images/fc-webicon-linkedin-s.png" /> LinkedIn URL <i class='tt icon-info-sign' data-toggle="tootip" title="URL of your LinkedIn page." ></i></label><input class='input-xxlarge'  type="url" id="social_media_linkedin_url" name="setting__social_media_linkedin_url" value="<?php echo @($generalSettings["social_media_linkedin_url"]); ?>" /></li>          
									<li><label for="social_media_pinterest_url"><img src="../wp-content/themes/<?php echo get_template(); ?>/Site/icons/images/fc-webicon-pinterest-s.png" /> Pinterest URL <i class='tt icon-info-sign' data-toggle="tootip" title="URL of your Pinterest page." ></i></label><input class='input-xxlarge'  type="url" id="social_media_pinterest_url" name="setting__social_media_pinterest_url" value="<?php echo @($generalSettings["social_media_pinterest_url"]); ?>" /></li>
									<li><label for="social_media_rss_url"><img src="../wp-content/themes/<?php echo get_template(); ?>/Site/icons/images/fc-webicon-rss-s.png" /> RSS (External) URL <i class='tt icon-info-sign' data-toggle="tootip" title="If you have an extral RSS feed such as Feedburner, enter it here.  If you leave this field blank, we will use the built in WordPress feed. page." ></i></label><input class='input-xxlarge' type="url" id="social_media_rss_url" name="setting__social_media_rss_url" value="<?php echo @($generalSettings["social_media_rss_url"]); ?>" /></li>           
									<li><label for="social_media_skype_url"><img src="../wp-content/themes/<?php echo get_template(); ?>/Site/icons/images/fc-webicon-skype-s.png" /> Skype URL <i class='tt icon-info-sign' data-toggle="tootip" title="URL of your Skype account." ></i></label><input class='input-xxlarge'  type="url" id="social_media_skype_url" name="setting__social_media_skype_url" value="<?php echo @($generalSettings["social_media_skype_url"]); ?>" /></li>
									<li><label for="social_media_tripadvisor_url"><img src="../wp-content/themes/<?php echo get_template(); ?>/Site/icons/images/fc-webicon-tripadvisor-s.png" /> TripAdvisor URL <i class='tt icon-info-sign' data-toggle="tootip" title="URL of your TripAdvisor page." ></i></label><input class='input-xxlarge'  type="url" id="social_media_tripadvisor_url" name="setting__social_media_tripadvisor_url" value="<?php echo @($generalSettings["social_media_tripadvisor_url"]); ?>" /></li>
									<li><label for="social_media_tumblr_url"><img src="../wp-content/themes/<?php echo get_template(); ?>/Site/icons/images/fc-webicon-tumblr-s.png" /> Tumblr URL <i class='tt icon-info-sign' data-toggle="tootip" title="URL of your Tumblr blog." ></i></label><input class='input-xxlarge'  type="url" id="social_media_tumblr_url" name="setting__social_media_tumblr_url" value="<?php echo @($generalSettings["social_media_tumblr_url"]); ?>" /></li>
									<li><label for="social_media_twitter_url"><img src="../wp-content/themes/<?php echo get_template(); ?>/Site/icons/images/fc-webicon-twitter-s.png" /> Twitter URL <i class='tt icon-info-sign' data-toggle="tooltip" title="URL of your Twitter page."></i></label><input class='input-xxlarge'  type="url" id="social_media_twitter_url" name="setting__social_media_twitter_url" value="<?php echo @($generalSettings["social_media_twitter_url"]); ?>" /></li>
									<li><label for="social_media_vimeo_url"><img src="../wp-content/themes/<?php echo get_template(); ?>/Site/icons/images/fc-webicon-vimeo-s.png" /> Vimeo URL <i class='tt icon-info-sign' data-toggle="tootip" title="URL of your Vimeo page." ></i></label><input class='input-xxlarge'  type="url" id="social_media_vimeo_url" name="setting__social_media_vimeo_url" value="<?php echo @($generalSettings["social_media_vimeo_url"]); ?>" /></li>           
									<li><label for="social_media_youtube_url"><img src="../wp-content/themes/<?php echo get_template(); ?>/Site/icons/images/fc-webicon-youtube-s.png" /> YouTube URL <i class='tt icon-info-sign' data-toggle="tootip" title="URL of your YouTube page." ></i></label><input class='input-xxlarge'  type="url" id="social_media_youtube_url" name="setting__social_media_youtube_url" value="<?php echo @($generalSettings["social_media_youtube_url"]); ?>" /></li>           
								</ul>          
							</div> <!-- end of social media references section -->
							
          					<div class="tab-pane<?php if ($_GET['subtab'] == "customcode") { ?> active<?php } ?>" id="customcode">
								<ul class='input-items'>
									<li><label class='full-height' for="tracking_code">Analytics Code <i class='tt icon-info-sign' data-toggle="tooltip" title="You can use this region to specify your Google Analytics code."></i></label><textarea class='input-xxlarge' id="tracking_code" name="setting__tracking_code"><?php echo @($generalSettings["tracking_code"]); ?></textarea></li>
									<li><label class='full-height' for="code_end_of_head">Before &lt;/head&gt; Tag<i class='tt icon-info-sign' data-toggle="tooltip" title="This region is often used for custom HTML/JS that needs to run within the head region of the page."></i></label><textarea class='input-xxlarge' id="code_end_of_head" name="setting__code_end_of_head"><?php echo @($generalSettings["code_end_of_head"]); ?></textarea></li>
									<li><label class='full-height' for="code_end_of_body">Before &lt;/body&gt; Tag<i class='tt icon-info-sign' data-toggle="tootip" title="This region is often used for custom HTML/JS that needs to run at the end of the page, just prior to the closing body (&lt;/body&gt;) tag."></i></label><textarea class='input-xxlarge' id="code_end_of_body" name="setting__code_end_of_body"><?php echo @($generalSettings["code_end_of_body"]); ?></textarea></li>           
									<li><label class='full-height' for="code_custom_css">Custom CSS <i class='tt icon-info-sign' data-toggle="tootip" title="If you have your own CSS styles you wish to add globally, you can specify them here." ></i></label><textarea class='input-xxlarge' id="code_custom_css" name="setting__code_custom_css"><?php echo @($generalSettings["code_custom_css"]); ?></textarea></li>           
								</ul>
          					</div> <!-- end of custom code section -->

           					<div class="tab-pane<?php if ($_GET['subtab'] == "external-assets") { ?> active<?php } ?>" id="external-assets">
              					<!--
								<h4>SoundCloud <a class='btn btn-xs btn-info' target='_blank' href='https://soundcloud.com/'><i class='fa fa-external-link'></i></a></h4>

								<ul class='input-items'>
									<li>
										<label for="soundcloud_player_enabled">SoundCloud MP3 Player <i class='tt icon-info-sign' data-toggle="tooltip" title="Enable this to show the SoundCloud MP3 Player"></i></label>
										<select class='input-xlarge'  name="setting__soundcloud_player_enabled" id="setting__soundcloud_player_enabled" >
											<option <?php if ($generalSettings['soundcloud_player_enabled'] == "")   { print "selected"; } ?> value="">Off</option>
											<option <?php if ($generalSettings['soundcloud_player_enabled'] == "globally")  { print "selected"; } ?> value="globally">Enabled Globally</option>
											<option <?php if ($generalSettings['soundcloud_player_enabled'] == "page-by-page")   { print "selected"; } ?> value="page-by-page">Enabled Page-by-Page</option>
										</select>
									</li>
									<li><label class='full-height' for="soundcloud_player_playlist">Global Playlist URL <i class='tt icon-info-sign' data-toggle="tooltip" title="Copy and Paste in your SoundCloud playlist URL here."></i></label><textarea class='input-xxlarge' id="soundcloud_player_playlist" name="setting__soundcloud_player_playlist"><?php echo $generalSettings['soundcloud_player_playlist']; ?></textarea></li>
									<li>
										<label for="soundcloud_player_autoplay">AutoPlay <i class='tt icon-info-sign' data-toggle="tootip" title="Enable this if you want the audio to automatically start."></i></label>
										<select class='input-xlarge'  name="setting__soundcloud_player_autoplay" id="setting__soundcloud_player_autoplay" >
											<option <?php if ($generalSettings['soundcloud_player_autoplay'] == "")  { print "selected"; } ?> value="">Off</option>
											<option <?php if ($generalSettings['soundcloud_player_autoplay'] == "1")   { print "selected"; } ?> value="1">On</option>
										</select>                
									</li>           
								</ul>
								-->
								<?php if (I3D_Framework::$fontAwesomeVersionDefinable) { ?>
								<h4>FontAwesome <a class='btn btn-xs btn-info' target='_blank' href='http://fortawesome.github.io/Font-Awesome/'><i class='fa fa-external-link'></i></a></h4>
								<ul class='input-items'>
									<li>
										<label for="font_awesome_version">Version <i class='tt icon-info-sign' data-toggle="tooltip" title="Choose which version you would like the framework to load for your theme and administrative area."></i></label>
										<select class='input-xlarge'  name="setting__font_awesome_version" id="setting__font_awesome_version" >
											<option <?php if (@$generalSettings['font_awesome_version'] == "")   { print "selected"; } ?> value="">Latest via CDN (Recommended)</option>
											<option <?php if (@$generalSettings['font_awesome_version'] == "cdn-4.x")  { print "selected"; } ?> value="cdn-4.x">4.x via CDN (Currently <?php echo I3D_Framework::$fontAwesomeVersion_4x; ?>)</option>
											<option <?php if (@$generalSettings['font_awesome_version'] == "cdn-3.2.1")  { print "selected"; } ?> value="cdn-3.2.1">3.2.1 via CDN</option>
											<option <?php if (@$generalSettings['font_awesome_version'] == "local-4.x")  { print "selected"; } ?> value="local-4.x">4.x stored locally (Currently <?php echo I3D_Framework::$fontAwesomeVersion_4x; ?>)</option>
											<option <?php if (@$generalSettings['font_awesome_version'] == "local-3.2.1")  { print "selected"; } ?> value="local-3.2.1">3.2.1 stored locally</option>
										</select>
									</li>
        
								</ul>		
								<?php } ?>						
							</div> <!-- end of soundcloud mp3 player section -->
							
          					<div class="tab-pane<?php if ($_GET['subtab'] == "footer") { ?> active<?php } ?>" id="footer">
          						<ul class='input-items'>
									<li class='full-height-2x'><label for="copyright_message">Copyright Message <i class='tt icon-info-sign' data-toggle="tooltip" title="A global copyright statement that appears at the bottom of your pages."></i></label><textarea id="copyright_message" name="setting__copyright_message" class='input-xxlarge'><?php echo $generalSettings["copyright_message"]; ?></textarea></li>
 									<li class='full-height-2x'><label for="powered_by_message">"Powered By" Message <i class='tt icon-info-sign' data-toggle="tooltip" title="A global, optional, 'Powered By' message that appears at the bottom of your pages."></i></label><textarea id="powered_by_message" name="setting__powered_by_message" class='input-xxlarge'><?php echo $generalSettings["powered_by_message"]; ?></textarea></li>
          						</ul>
          					</div>
          
		  					<div class="tab-pane<?php if ($_GET['subtab'] == "404") { ?> active<?php } ?>" id="four04">
          						<ul class='input-items'>
									<li class='full-height-2x'><label for="404_message">404 Page Message <i class='tt icon-info-sign' data-toggle="tooltip" title="Place the message you want displayed in the 404 page."></i></label><textarea id="404_message" name="setting__404_message" class='input-xxlarge'><?php echo $generalSettings["404_message"]; ?></textarea></li>
									<li><label for="404_message">Show Search Bar <i class='tt icon-info-sign' data-toggle="tooltip" title="Enable this if you want to show the site-search bar"></i></label><input type="checkbox" name="setting__404_show_search_bar" id="404_show_search_bar" value="1"  <?php if(isset($generalSettings['404_show_search_bar']) && $generalSettings['404_show_search_bar'] == true) { echo 'checked="checked"'; }?> /></li>
									<li><label for="404_show_sitemap">Show Sitemap <i class='tt icon-info-sign' data-toggle="tooltip" title="Enable this if you want a list of pages, that are in your site, displayed on the 404 page."></i></label><input type="checkbox" name="setting__404_show_sitemap" id="404_show_sitemap" value="1"  <?php if($generalSettings['404_show_sitemap'] == true) { echo 'checked="checked"'; }?> /></li>
									<li><label for="404_show_archives">Show Archives <i class='tt icon-info-sign' data-toggle="tooltip" title="Enable this if you want a list of links to archived posts displayed on the 404 page"></i></label><input type="checkbox" name="setting__404_show_archives" id="404_show_archives" value="1"  <?php if($generalSettings['404_show_archives'] == true) { echo 'checked="checked"'; }?> /></li>
									<li><label for="404_show_most_recent_posts">Show Recent Posts <i class='tt icon-info-sign' data-toggle="tooltip" title="Enable this if you want a list recent blog posts displayed on the 404 page"></i></label><input type="checkbox" name="setting__404_show_most_recent_posts" id="404_show_most_recent_posts" value="1"  <?php if($generalSettings['404_show_most_recent_posts'] == true) { echo 'checked="checked"'; }?> /></li>
          						</ul>
          					</div>

							<div id="tabs-layouts" class='tab-pane'>
								<p style='margin-left: 20px;'>These settings are what are used when you create a new page based off of one of these layouts.  Typically, you shouldn't need to change these settings unless you find you want to change the default layout of your templates.</p>
								<?php 
								$templates = get_page_templates();
								global $i3dSupportedSidebars;
								$availableTemplates = array("default" => "Default");
								foreach ( $templates as $template_name => $template_filename ) {
									$templateShortName = str_replace("template-", "", str_replace(".php", "", $template_filename));
									$availableTemplates["$templateShortName"] =  $template_name;
								}
								?>
    							<ul class="nav nav-pills" style='margin-bottom: 0px; margin-top: 0px; margin-left: 10px;'>
								<?php
								$layoutMenuSelected = false;
								foreach ($availableTemplates as $template => $templateFileName) { ?>
									<li <?php if (!$layoutMenuSelected) { $layoutMenuSelected = true; print "class='active'"; } ?>><a href="#template-layout-<?php echo $template; ?>" data-toggle="tab"><?php echo $templateFileName; ?></a></li>
								<?php 
								} 
								?>
								</ul>
								
        						<div class="tab-content">
								<?php
								$layoutMenuSelected = false;
								foreach ($availableTemplates as $template => $templateFileName) { ?>        
          							<div class="tab-pane <?php if (!$layoutMenuSelected) { $layoutMenuSelected = true; print "active"; } ?>" id="template-layout-<?php echo $template; ?>">
          								<!--<h5 style='margin-left: 10px;'><?php echo $templateFileName; ?></h5>-->
          								<?php      
										$regions = $i3dSupportedSidebars;
										$templateAuxName = ($template == 'default' ? "" : "template-").$template;
										?>
			    						<ul class='input-items'>
										<?php
										foreach ($regions as $regionID => $regionInfo) { 
							   				if (in_array($templateAuxName, $regionInfo['configurable'])) { ?>
                  							<li>
												<label class='full-height-3x'><?php echo $regionInfo['name']; ?> Region</label>
												<div class='settings-layout-column'>
													<span class='label'>Columns</span>
													<select class='input-mini layout-columns-select' id="layout_regions__<?php echo $template; ?>__<?php echo $regionID; ?>__columns" name="layout_regions__<?php echo $template; ?>__<?php echo $regionID; ?>__columns">
														<?php echo i3d_renderSelectOptions(array("1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5", "6" => "6"), $layoutRegions["{$template}"]["{$regionID}"]["columns"]); ?>
													</select>
													<select class='input-medium' id="layout_regions__<?php echo $template; ?>__<?php echo $regionID; ?>__width" name="layout_regions__<?php echo $template; ?>__<?php echo $regionID; ?>__width">
														<?php echo i3d_renderSelectOptions(array("contained" => "Contained", "fullscreen" => "Full Screen"), $layoutRegions["{$template}"]["{$regionID}"]["width"]); ?>
													</select>
													<br/>
													<span class='label text-center'>Layout</span>               
													<input class="input-mini layout-holder" type="hidden"  id="layout_regions__<?php echo $template; ?>__<?php echo $regionID; ?>__layout" name="layout_regions__<?php echo $template; ?>__<?php echo $regionID; ?>__layout" value="<?php echo @($layoutRegions["{$template}"]["{$regionID}"]["layout"]); ?>" />
													<div data-toggle="tooltip" class="slider-range"></div>
												</div>
											</li>           
											<?php 
											}
										} 
										?>
										</ul>
                            		</div>
                            	<?php
							   	}
								?>
								</div>
							</div> <!-- end of layouts tab -->
						</div> <!-- end of tab-content for "control panel" tabs -->
      				</div> <!-- end of control panel tab content -->
            
					<div id="tabs-tutorials" class='tab-pane'>
            			<ul class="nav nav-pills" >
							<li class='active'><a href="#helpcenter" data-toggle="tab">Instructions</a></li>
							<li><a href="#changelog" data-toggle="tab">Changelog</a></li>
						</ul>        
            			<div class='tab-content'>
              				<div class='active tab-pane' id='helpcenter'>
                 			<?php if (I3D_Framework::$supportType == "tf") { ?>
								<h3>Learning Centre</h3>
                   				<p>We include a set of help documents with your download package -- please check there first for instructions.  You may also find the most up to date instruction set <a target="_blank" href='http://i3dthemes.net/kindercare/'>here</a>.
								  For troubleshooting information, you make look in our forums on our website for more information: <a target="_blank" href='http://i3dthemes.net/forums/'>forums and learning centre</a>.</p>
<!--
 								<div class='vector-icon-box-container small-icons'>
            						<div class='row-fluid'>
                    					<div class="col-sm-4">
                        					<div class='vector-icon-info-box'>
                            					<div class="hi-icon-wrap hi-icon-effect-1 hi-icon-effect-1a"><a class="hi-icon fa fa-info-circle" href="http://i3dthemes.net/forums/forum/getting-started/">Getting Started</a></div>
                            					<h3 class="small-caps text-center">Getting Started</h3>
												<p class='text-center'>Installation and the Framework Basics</p>
												<p class='text-center'><a class="btn btn-primary" href="http://i3dthemes.net/forums/forum/getting-started/">Get Learning &raquo;</a></p>
											</div>
										</div>
										<div class="col-sm-4">
											<div class='vector-icon-info-box'>
												<div class="hi-icon-wrap hi-icon-effect-1 hi-icon-effect-1a"><a class="hi-icon fa fa-cogs" href="http://i3dthemes.net/forums/forum/widgets/">Widgets</a></div>
												<h3 class="small-caps text-center">Widgets</h3>
												<p class='text-center'>So many widgets, learn about them here.</p>
												<p class='text-center'><a class="btn btn-primary" href="http://i3dthemes.net/forums/forum/widgets/">Get Learning &raquo;</a></p>
											</div>
										</div>
                    
										<div class="col-sm-4">
											<div class='vector-icon-info-box'>
												<div class="hi-icon-wrap hi-icon-effect-1 hi-icon-effect-1a"><a class="hi-icon fa fa-puzzle-piece" href="http://i3dthemes.net/forums/forum/page-templates/">Page Templates</a></div>
												<h3 class="small-caps text-center">Page Templates</h3>
												<p class='text-center'>A multitude of page layouts to choose from.</p>
												<p class='text-center'><a class="btn btn-primary" href="http://i3dthemes.net/forums/forum/page-templates/">Get Learning &raquo;</a></p>
											</div>
										</div>                    
										<div style='clear: both;'></div>
									</div>
                  
									<div class='row-fluid' style='padding-top: 10px;'>
										<div class="col-sm-6">
											<div class='vector-icon-info-box'>
												<div class="hi-icon-wrap hi-icon-effect-1 hi-icon-effect-1a"><a class="hi-icon fa fa-puzzle-piece" href="http://i3dthemes.net/forums/forum/special-components/">Special Components</a></div>
												<h3 class="small-caps text-center">Special Components</h3>
												<p class='text-center'>Contact Forms, Calls to Action, Sliders, and more.</p>
												<p class='text-center'><a class="btn btn-primary" href="http://i3dthemes.net/forums/forum/special-components/">Get Tinkering &raquo;</a></p>
											</div>
										</div>
						
										<div class="col-sm-6">
											<div class='vector-icon-info-box'>
												<div class="hi-icon-wrap hi-icon-effect-1 hi-icon-effect-1a"><a class="hi-icon fa fa-pencil" href="http://i3dthemes.net/forums/forum/custom-post-types/">Special Post Types</a></div>
												<h3 class="small-caps text-center">Special Post Types</h3>
												<p class='text-center'>Quotations, Team Members, and FAQs</p>
												<p class='text-center'><a class="btn btn-primary" href="http://i3dthemes.net/forums/forum/custom-post-types/">Get Tinkering &raquo;</a></p>
											</div>
										</div>
										
										<div style='clear: both;'></div>
									</div>
									
									<div class='row-fluid' style='padding-top: 10px;'>
										<div class="col-sm-12">
											<div class='vector-icon-info-box'>
												<div class="hi-icon-wrap hi-icon-effect-1 hi-icon-effect-1a"><a class="hi-icon fa fa-book" href="http://i3dthemes.net/forums/forum/<?php echo strtolower($themeInfo->Name); ?>/">"<?php echo $themeInfo->Name; ?>" Specific Tutorials</a></div>
												<h3 class="small-caps text-center">"<?php echo $themeInfo->Name; ?>" Specific Tutorials</h3>
												<p class='text-center'>Learn all the ins and outs for the <?php echo $themeInfo->Name; ?> theme.</p>
												<p class='text-center'><a class="btn btn-primary" href="http://i3dthemes.net/forums/forum/<?php echo strtolower($themeInfo->Name); ?>/">Bust a Groove &raquo;</a></p>
											</div>
										</div>
									</div>
					
									<div style='clear: both;'></div>
									
								</div>
								-->
								<?php } else { ?>
								<div class='video-container'>
									<h3 class='overview-sub-title'>Introduction Videos</h3>
									<p>Over 40 minutes of introduction of the basics of our Aquila framework.  These videos include a tour of the framework dashboard as well as the basics of working with widgets.  We've marked videos
									of significant importance as a colored button.</p>
									<p>Get a short but informative introduction into the basics of the Aquila framework.  This series includes a tour of the framework dashboard, as well as the basics of working with widgets.</p>
									<p>Three videos, Aproximately 45 Minutes Total</p>
									<!--
									<a href='http://youtu.be/_-I38mdoZcc' class='btn btn-primary' target="_blank">"Introduction" <i class='icon-youtube-play'></i></a>
									-->
									<a href='https://youtu.be/c13vBdNQUZk' class='btn btn-primary' target="_blank">"Introduction" (v4.3) <i class='icon-youtube-play'></i></a>
									<?php if (!I3D_Framework::use_global_layout()) { ?>
									<a href='http://youtu.be/GETTbapAEDE' class='btn btn-default' target="_blank">"Working With Widgets" (Legacy Editor) <i class='icon-youtube-play'></i></a>
									<?php } else { ?>
									<a href='https://youtu.be/HiibUwgFWmQ' class='btn btn-default' target="_blank">"Working With Widgets" (v4.3) <i class='icon-youtube-play'></i></a>
									
									<?php } ?>
									
									<a href='http://youtu.be/iUrzT01SmTk' class='btn btn-default' target="_blank">"Updating Your Theme" <i class='icon-youtube-play'></i></a>
									<div style='clear: both;'></div>
								</div>
								
								<div class='video-container'>
									<h3 class='overview-sub-title'>Working With Page Layouts</h3>
									<p>We include a number of page layouts in this framework.  It is important to be familiar with all of the available features for each different page layout.</p>
									
									<p>13 videos, Aproximately 29 Minutes Total</p>
									<?php if (I3D_Framework::use_global_layout()) { ?>
									<a href='https://youtu.be/6wdr7mcF7oE' class='btn btn-primary' target="_blank">"Layout Editor -- In Depth" (v4.3) <i class='icon-youtube-play'></i></a>
									<a href='https://youtu.be/k9_KbXz0-sc' class='btn btn-primary' target="_blank">"Migrating from Pre-4.3 Framework" (v4.3) <i class='icon-youtube-play'></i></a>
									<br/>
									<?php } ?>
									
									<?php if ($themeInfo->get("Name") == "Portico HD") { ?>
									
									<?php if (!I3D_Framework::use_global_layout()) { ?>
									<a href='http://youtu.be/ChTRkt8Ed5w' class='btn btn-primary' target="_blank">"Intro/Landing" <i class='icon-youtube-play'></i></a>
									<?php } else { ?>
									<a href='https://youtu.be/cB-gaoDWrJU' class='btn btn-default' target="_blank">"Intro/Landing (v4.3)" <i class='icon-youtube-play'></i></a>

									<?php } ?>
									<?php } ?>
									
									<?php if (!I3D_Framework::use_global_layout()) { ?>
									<a href='http://youtu.be/XhDU9teg8PM' class='btn btn-primary' target="_blank">"Home" <i class='icon-youtube-play'></i></a>
									<a href='http://youtu.be/87V6yEON_BM' class='btn btn-primary' target="_blank">"Blog" <i class='icon-youtube-play'></i></a>
									<a href='http://youtu.be/rIvDCctQGsA' class='btn btn-primary' target="_blank">"Contact" <i class='icon-youtube-play'></i></a>
									<a href='http://youtu.be/Q2wVhxVkwfs' class='btn btn-primary' target="_blank">"Team Members" <i class='icon-youtube-play'></i></a>
									<a href='http://youtu.be/uu1dDor1LVI' class='btn btn-primary' target="_blank">"FAQs" <i class='icon-youtube-play'></i></a>
									<a href='http://youtu.be/d3-Zg8JVPQI' class='btn btn-primary' target="_blank">"Minimized (default)" <i class='icon-youtube-play'></i></a>
									<a href='http://youtu.be/od9RZMOPbWU' class='btn btn-default' target="_blank">"Photo Slideshow" <i class='icon-youtube-play'></i></a>
									<a href='http://youtu.be/DlRXvWUoNFw' class='btn btn-default' target="_blank">"Sitemap" <i class='icon-youtube-play'></i></a>
									<a href='http://youtu.be/dS0CV5zCka8' class='btn btn-default' target="_blank">"Under Construction" <i class='icon-youtube-play'></i></a>
									<a href='http://youtu.be/Ua4caIztS90' class='btn btn-default' target="_blank">"404 (Page Not Found)" <i class='icon-youtube-play'></i></a>
									<a href='http://youtu.be/0JOBL0iYBag' class='btn btn-default' target="_blank">"Advanced" <i class='icon-youtube-play'></i></a>
									<?php } else { ?>
									<a href='https://youtu.be/-tuTbXnvRIY' class='btn btn-default' target="_blank">"Home" (v4.3) <i class='icon-youtube-play'></i></a>
									<a href='https://youtu.be/RV0kWcKloe4' class='btn btn-default' target="_blank">"Blog" (v4.3) <i class='icon-youtube-play'></i></a>
									<a href='https://youtu.be/4-uOLUHd_3s' class='btn btn-default' target="_blank">"Contact" (v4.3) <i class='icon-youtube-play'></i></a>
									<a href='https://youtu.be/LeKiDUH7cR4' class='btn btn-default' target="_blank">"About Us" (v4.3) <i class='icon-youtube-play'></i></a>
									<a href='https://youtu.be/V6MxN_P8liA' class='btn btn-default' target="_blank">"FAQs" (v4.3) <i class='icon-youtube-play'></i></a>
									<!--<a href='http://youtu.be/d3-Zg8JVPQI' class='btn btn-primary' target="_blank">"Minimized (default)" <i class='icon-youtube-play'></i></a>-->
									<a href='https://youtu.be/7WX5h6XgDec' class='btn btn-default' target="_blank">"Photo Slideshow" (v4.3)<i class='icon-youtube-play'></i></a>
									<a href='https://youtu.be/0qj5fZV4VII' class='btn btn-default' target="_blank">"Sitemap" (v4.3) <i class='icon-youtube-play'></i></a>
									<a href='https://youtu.be/R90cUb1HRUI' class='btn btn-default' target="_blank">"Under Construction" (v4.3) <i class='icon-youtube-play'></i></a>
									<a href='https://youtu.be/TLeVQVia19U' class='btn btn-default' target="_blank">"404 (Page Not Found)" (v4.3) <i class='icon-youtube-play'></i></a>
									<!--<a href='http://youtu.be/0JOBL0iYBag' class='btn btn-default' target="_blank">"Advanced" <i class='icon-youtube-play'></i></a>-->
									<a href='https://youtu.be/818h-AP8lG0' class='btn btn-default' target="_blank">"Creating A New Page" (v4.3) <i class='icon-youtube-play'></i></a>
									
									<?php } ?>
									<div style='clear: both;'></div>
									<h4>General Concepts</h4>
									
									<a href='http://youtu.be/Sh41P0JvlGc' class='btn btn-default' target="_blank">"SoundCloud MP3 Player" <i class='icon-youtube-play'></i></a>
									<?php if (!I3D_Framework::use_global_layout()) { ?>
									<a href='http://youtu.be/pJ5imjhcaz0' class='btn btn-default' target="_blank">"Stylized Regions" <i class='icon-youtube-play'></i></a>

									<?php } else { ?>
										<?php if ($themeInfo->get("Name") == "Diavlo HD") { ?>
										<a href='https://youtu.be/NOj0wQugmPE' class='btn btn-primary' target="_blank">"Contact Panel"  <i class='icon-youtube-play'></i></a>
										<?php } ?>									
									<?php } ?>
									<div style='clear: both;'></div>
								</div>
			  
								<div class='video-container'>
									<h3 class='overview-sub-title'>Custom Post Types and Special Components</h3>
									<p>Included with the framework are a number of custom post types, and special components.  Learn how to work with each of them in this series.</p>
									<p>Four videos, Aproximately 18 Minutes Total</p>
									
									
						
										<?php if ($themeInfo->get("Name") == "Portico HD") { ?>
										<a href='http://youtu.be/JPKGhJgrbTk' class='btn btn-primary' target="_blank">"Isotope Portfolio" <i class='icon-youtube-play'></i></a>
										<?php } else if ($themeInfo->get("Name") == "Diavlo HD") { ?>
										<a href='http://youtu.be/JPKGhJgrbTk' class='btn btn-primary' target="_blank">"Isotope Portfolio" <i class='icon-youtube-play'></i></a>
										<?php if (!I3D_Framework::use_global_layout()) { ?>
										<a href='http://youtu.be/9-W_Q3LCfNE' class='btn btn-primary' target="_blank">Footer "Get-In-Touch" Label<i class='icon-youtube-play'></i></a>
										<?php } ?> 
										<?php } ?>       
									  
									<a href='http://youtu.be/YgiJJNuv3jM' class='btn btn-primary' target="_blank">"Testimonials" <i class='icon-youtube-play'></i></a>
									<a href='http://youtu.be/Q2wVhxVkwfs' class='btn btn-primary' target="_blank">"Team Members" <i class='icon-youtube-play'></i></a>
									<a href='http://youtu.be/PNa5Ixc7RII' class='btn btn-primary' target="_blank">"Sliders" <i class='icon-youtube-play'></i></a>
									<a href='http://youtu.be/ProIrVGePk4' class='btn btn-primary' target="_blank">"Contact Forms" <i class='icon-youtube-play'></i></a>
									<a href='http://youtu.be/8YEIT1koYLs' class='btn btn-primary' target="_blank">"Calls To Action" <i class='icon-youtube-play'></i></a>
									<div style='clear: both;'></div>
								</div>
								
								<div class='video-container'>
									<h3 class='overview-sub-title'>Working With Widgets</h3>
									<p>As much of the site's content is managed via widgets (Info Boxes, Sliders, Phone Numbers) it is important to familiarize yourself with the our widgets and how they operate.</p>
									<p>In this video series, we'll talk about everything from positioning of widgets within a page region, to the individual widgets and how they operate.</p>
									<p>21 videos, Aproximately 51 Minutes Total</p>
									<?php if (!I3D_Framework::use_global_layout()) { ?>
									<a href='http://youtu.be/GETTbapAEDE' class='btn btn-primary' target="_blank">"Working With Widgets" (Legacy Editor) <i class='icon-youtube-play'></i></a>
									<a href='http://www.youtube.com/watch?v=kOeBvTKIMQA' class='btn btn-primary' target="_blank"><i class='icon-star-empty'></i>"Content Region" <i class='icon-youtube-play'></i></a>
									<a href='http://www.youtube.com/watch?v=B_iWyMGvUv8' class='btn btn-primary' target="_blank">"Column Break" <i class='icon-youtube-play'></i></a>
									<?php } else { ?>
									<a href='https://youtu.be/HiibUwgFWmQ' class='btn btn-primary' target="_blank">"Working With Widgets" (v4.3) <i class='icon-youtube-play'></i></a>								
									<a href='http://www.youtube.com/watch?v=kOeBvTKIMQA' class='btn btn-default' target="_blank">"Content Region" <i class='icon-youtube-play'></i></a>
									<a href='http://www.youtube.com/watch?v=B_iWyMGvUv8' class='btn btn-default' target="_blank">"Column Break" <i class='icon-youtube-play'></i></a>
									<?php } ?>
									
									<a href='http://youtu.be/le4IRokbFiQ' class='btn btn-default' target="_blank">"Breadcrumb Links" <i class='icon-youtube-play'></i> </a>
									<a href='http://www.youtube.com/watch?v=t56xRHF5Mxc' class='btn btn-default' target="_blank">"Contact Form" <i class='icon-youtube-play'></i></a>
									<a href='http://www.youtube.com/watch?v=62RXnLGcOC8' class='btn btn-default' target="_blank">"Contact Form Menu" <i class='icon-youtube-play'></i></a>
									<a href='http://www.youtube.com/watch?v=gxNEJqLBfII' class='btn btn-default' target="_blank">"Font Sizer" <i class='icon-youtube-play'></i></a>
									<a href='http://www.youtube.com/watch?v=meGDMofqpGQ' class='btn btn-default' target="_blank">"Contact Details" <i class='icon-youtube-play'></i></a>
									<a href='http://youtu.be/O6pWvXLc40g' class='btn btn-default' target="_blank">"HTML Box" <i class='icon-youtube-play'></i></a>
									<a href='http://www.youtube.com/watch?v=XcJnY-NYx3Q' class='btn btn-default' target="_blank">"Image/Banner" <i class='icon-youtube-play'></i></a>
									<a href='http://www.youtube.com/watch?v=dNuDaqijf_s' class='btn btn-default' target="_blank">"Info Box" <i class='icon-youtube-play'></i></a>
									<a href='http://www.youtube.com/watch?v=Oow6R0eWd3M' class='btn btn-default' target="_blank">"Website Title/Logo" <i class='icon-youtube-play'></i></a>
									<a href='http://www.youtube.com/watch?v=NkZI5tbnh7E' class='btn btn-default' target="_blank">"Custom Menu" <i class='icon-youtube-play'></i></a>
									<a href='http://www.youtube.com/watch?v=DGn5bE7vcY4' class='btn btn-default' target="_blank">"Phone Number" <i class='icon-youtube-play'></i></a>
									<a href='http://www.youtube.com/watch?v=l_SX5F1WSno' class='btn btn-default' target="_blank">"SEO Tags" <i class='icon-youtube-play'></i></a>
									<a href='http://www.youtube.com/watch?v=PNa5Ixc7RII' class='btn btn-default' target="_blank">"Slider Region" <i class='icon-youtube-play'></i></a>
									<a href='http://www.youtube.com/watch?v=iVpQLb4gO10' class='btn btn-default' target="_blank">"Social Media Icons" <i class='icon-youtube-play'></i></a>
									<a href='http://youtu.be/nHkNTpl91hs' class='btn btn-default' target="_blank">"Blog Super Summary" <i class='icon-youtube-play'></i></a>
									<a href='http://www.youtube.com/watch?v=YgiJJNuv3jM' class='btn btn-default' target="_blank">"Testimonial Rotator" <i class='icon-youtube-play'></i></a>
									<a href='http://www.youtube.com/watch?v=LxMalGndGIE' class='btn btn-default' target="_blank">"Twitter Feed" <i class='icon-youtube-play'></i></a>
									<a href='http://youtu.be/8YEIT1koYLs' class='btn btn-default' target="_blank">"Calls To Action" <i class='icon-youtube-play'></i></a>
									<div style='clear: both;'></div>						
								</div>
	
								<div class='video-container'>
									<h3 class='overview-sub-title'>Troubleshooting</h3>
									<p>We may find that over time there are small glitches in the system.  If we do, we'll post troubleshooting videos here.</p>
									<a href='http://youtu.be/RSXBNenPuMw' class='btn btn-default' target="_blank">"Top Horizontal Menu" <i class='icon-youtube-play'></i></a>
									<div style='clear: both;'></div>
								</div>
							<?php } ?>
							</div>
						
							<div id='changelog' class='tab-pane'>
								<h3>Changelog</h3>
								
								<table class='table table-striped'>
									<tr class='info'>
										<td>Version</td><td>Date</td><td>Update</td>
									</tr>
								
									<?php foreach (I3D_Framework::get_update_log() as $updateEntry) { ?>
									<tr>
										<td><?php echo $updateEntry['version']; ?></td>
										<td><?php echo $updateEntry['date']; ?></td>
										<td>
											<p class='update-summary'><?php echo $updateEntry['summary']; ?></p>
											<ul>
											<?php foreach ($updateEntry['items'] as $updateEntryItem) {
											if (!array_key_exists("qualifier", $updateEntryItem) || in_array($themeInfo->Name, $updateEntryItem['qualifier'])) { ?>
											<li><span class='<?php echo $updateEntryItem['label_class']; ?>'><?php echo $updateEntryItem['label']; ?></span> <?php echo $updateEntryItem['description']; ?></li>
											<?php } ?>
											<?php } ?>
											</ul>
										</td>
									</tr>
									<?php } ?>
								</table>
							</div> <!-- end of changelog -->
						</div> <!-- end of tab-content -->
					</div> <!-- end of instructions panel -->
				
					<div id="tabs-support" class='tab-pane'>
					<?php if (get_option("i3d_license_type") == "multi-site") { ?>
					<h3>Support</h3>
					<p>The license type for this product is registered as a special "multi-site" edition.</p>
					<p>  Support for multi-site edition themes is available by contacting your developer directly, or (if
					you purchased this theme yourself), by logging in to your account where you purchase was made, and initiating a support ticket.</p>
					
					<?php } else if (get_option("i3d_license_type") == "developer") { ?>
					<h3>Support</h3>
					<p>The license type for this product is registered as a special "developer" edition.</p>
					<p> Support for developer edition themes is available by contacting your developer directly, or (if
					you purchased this theme yourself), by logging in to your account where you purchase was made, and initiating a support ticket.</p>
					<?php } else { ?>
						<h3>Contact Us</h3>
						<p>Have a problem not covered by our knoweldge base, or have an idea for a feature that we have not included?  You've come to the right place.</p>
						
						<section>
							<h4>Support</h4>
							<?php if (I3D_Framework::$supportType == "i3d") { ?>
							<p>For support, we have two methods by which to contact us.</p>
							<?php } ?>
							<ul>
							<?php if (I3D_Framework::$supportType == "i3d") { ?>
							  <li style='font-size: 9pt; background-color: #eeeeee; margin-bottom: 10px;padding: 10px; '><!--<b>Option #1:</b> -->Via your account at <a href='https://my.luckymarble.com/'>my.luckymarble.com</a><br/>
							<!--  <b>Response Type:</b> Priority<br />-->
							  <b>Response Time:</b> 24-48 hours (Monday-Friday)</li>
							<?php } ?>
							<!--
							  <li style='font-size: 9pt; background-color: #eeeeee; margin-bottom: 10px;padding: 10px; '><?php if (I3D_Framework::$supportType == "i3d") { ?><b>Option #2:</b><?php } ?>Via email <a href="mailto:support@i3dthemes.zendesk.com">support@i3dthemes.zendesk.com</a><br/>
							  <b>Response Type:</b> Normal<br />
							  <b>Response Time:</b> <?php if (I3D_Framework::$supportType == "i3d") { ?>36-72<?php } else { ?>24-48<?php } ?> hours (Monday-Friday)</li>
							</ul>
							<!--
							<p>
							Initiate a support ticket by emailing <a href="mailto:support@i3dthemes.zendesk.com">support@i3dthemes.zendesk.com</a>
							</p>
							<p><b>Reponse Type:</b> Priority</p>
						
							<p><b>Response Time:</b> 36-48 hours (Monday-Friday) -- often much faster.</p>
						-->
							<p><b>Help us help you faster</b> by including the following details:</p>
							<ul class="fa-ul">
								<li><i class='fa-li fa fa-check-square'></i> Your website address</li>
								<li><i class='fa-li fa fa-check-square'></i> Your dashboard username and password</li>
								<li><i class='fa-li fa fa-check-square'></i> A detailed description of the problem</li>
							</ul>
						</section>
						<!--
						<section>
							<h4>Suggestion</h4>
							<p>Send us your suggestion by emailing <a href="mailto:suggestions@i3dthemes.zendesk.com">suggestions@i3dthemes.zendesk.com</a></p>
							<p><b>Reponse Type:</b> Normal</p>
							
							<p><b>Response Time:</b> 3-5 business days (Monday-Friday) -- often much faster.</p>
							
							<p><b>Help us help you faster</b> by including the following details:</p>
							<ul class="fa-ul">
								<li><i class='fa-li fa fa-check-square'></i> A detailed description of your suggestion</li>
							</ul>
						</section> 
						-->        
						<?php } ?>  
					</div> <!-- end of support section -->
    			</div> <!-- tabs container -->
			</div> <!-- tabs -->
    
    		<input type="hidden" name="cmd" value="save" />
		</form>   
	</div>  <!-- settings wrap inner -->
</div> <!-- settings wrap -->

<iframe name='saveframe' id='saveframe' style='border: 0px; display: none;'></iframe>

	
<script>
jQuery(document).ready(function(jQuery) {							
   jQuery("#tabs .tt").tooltip();
   jQuery("#tabs ul").tab();
	<?php if ($_GET['tab'] == "tabs-configure") { ?>
	jQuery("#tab-tabs-configure").tab("show");
	<?php } else if ($_GET['tab'] == "tabs-tutorials") { ?>
	jQuery("#tab-<?php echo $_GET['tab']; ?>").tab("show");
	<?php } else if ($_GET['tab'] == "tabs-initialization") { ?>
	jQuery("#tab-<?php echo $_GET['tab']; ?>").tab("show");

	<?php } else if ($_GET['tab'] == "tabs-support") { ?>
	jQuery("#tab-<?php echo $_GET['tab']; ?>").tab("show");
	<?php } else { ?>
	jQuery("#tab-tabs-welcome").tab("show");
	<?php } ?>
});		

	jQuery(document).ready(function() {
		window.send_to_editor = function(html) {
			
			jQuery.ajax({url:"?page=i3d-settings&render=favicons-list"}).done(function(data) {
																					  jQuery("ul#favicons-container").html(data);
																				
																					  });

 		tb_remove();
		}
	});
</script>    
<?php
	}
} // end of show i3d_admin_settings function


function i3d_display_slider_options($currentValue) {
	global $post;

	$sliders = get_option('i3d_sliders');
	$i3dAvailableSliders = I3D_Framework::getSliders();

	if(is_array($sliders) && !empty($sliders)){
		foreach($sliders as $sliderID => $slider){
			if($currentValue == $sliderID){
				echo "<option value='$sliderID' selected>{$slider['slider_title']} (".$i3dAvailableSliders[$slider['slider_type']]['title'].")</option>\n";
			}else{
				echo "<option value='$sliderID'>{$slider['slider_title']} (".$i3dAvailableSliders[$slider['slider_type']]['title'].")</option>\n";
			}
		}
	}
}

function i3d_renderSelectOptions($options, $selectedValue, $labelField = "") {
	$selectBox = "";
	foreach($options as $value => $labelObj) {
		if ($labelField != "") {
			$label = $labelObj[$labelField];
		} else {
			$label = $labelObj;
		}
		if($selectedValue == $value || ($value == '0' && $selectedValue == "")) {
			$selectBox  .= '<option value="'.$value.'" selected="selected">'.$label.'&nbsp;</option>';
			
		} else {
			$selectBox  .=  '<option value="'.$value.'">'.$label.'&nbsp;</option>';
		}
	}	
	return $selectBox;
}

function renderFavIconListItems($generalSettings) { ?>
	<li class='custom-icon-sm'><label for="setting__custom_fav_ico">Custom Favicon <i class='tt icon-info-sign' data-toggle="tootip" title="Provide your own graphic .ico file for general bookmark and the browser tab icon (16 x 16px)" ></i></label>
    <?php I3D_Framework::renderImageChooser("custom_fav_icon", @$generalSettings['custom_fav_icon'], "x-icon,ico,gif", "image-chooser-preview", array(16,16), array(16,16) ); ?>
	</li>
	<?php 
	ob_start();
	$haveIcons = I3D_Framework::renderImageChooser("custom_icon_iphone", @$generalSettings['custom_icon_iphone'], "png", "image-chooser-preview", array(57,57), array(57,57)); 
	$iconHTML = ob_get_clean();
	?>
	<li class='custom-icon-<?php if ($haveIcons) { print "lg"; } else { print "sm"; } ?>'><label for="setting__custom_fav_ico">Apple iPhone Icon <i class='tt icon-info-sign' data-toggle="tootip" title="Provide your own graphic .png (57 x 57px) for Apple iPhone displays." ></i></label>
		<?php echo $iconHTML; ?>
	</li>
	<?php 
	ob_start();
	$haveIcons = I3D_Framework::renderImageChooser("custom_icon_iphone_retina", @$generalSettings['custom_icon_iphone_retina'], "png", "image-chooser-preview", array(114,114), array(114,114)); 
	$iconHTML = ob_get_clean();				
	?>
	
	<li class='custom-icon-<?php if ($haveIcons) { print "lg"; } else { print "sm"; } ?>'><label for="setting__custom_fav_ico">Apple iPhone Retina Icon <i class='tt icon-info-sign' data-toggle="tootip" title="Provide your own graphic .png (114 x 114px) for Apple iPhone Retina displays." ></i></label>
		<?php echo $iconHTML; ?>
	</li>
	<?php 
	ob_start();
	$haveIcons = I3D_Framework::renderImageChooser("custom_icon_ipad", @$generalSettings['custom_icon_ipad'], "png", "image-chooser-preview", array(72,72), array(72,72));
	$iconHTML = ob_get_clean();
	?>              
	<li class='custom-icon-<?php if ($haveIcons) { print "lg"; } else { print "sm"; } ?>'><label for="setting__custom_fav_ico">Apple iPad Icon <i class='tt icon-info-sign' data-toggle="tootip" title="Provide your own graphic .png (72 x 72px) for Apple iPad displays." ></i></label>
		<?php echo $iconHTML; ?>
	</li>
	<?php 
	ob_start();
	$haveIcons = I3D_Framework::renderImageChooser("custom_icon_ipad_retina", @$generalSettings['custom_icon_ipad_retina'], "png", "image-chooser-preview", array(144,144), array(144,144)); 
	$iconHTML = ob_get_clean();
	?>
	<li class='custom-icon-<?php if ($haveIcons) { print "lg"; } else { print "sm"; } ?>'><label for="setting__custom_fav_ico">Apple iPad Retina Icon <i class='tt icon-info-sign' data-toggle="tootip" title="Provide your own graphic .png (144 x 144px) for Apple iPad Retina displays." ></i></label>
		<?php echo $iconHTML; ?>
	</li>  
	<?php
}
		  
function i3d_render_select($id, $defaultSetting, $options = array(), $selectedValue = "", $type = "select", $onChange = "", $inline = "") {
	$selectBox = "";
	$selectName = "";
	if ($type == "select2:array:name" || $type == "select2") {
		$selectName = $id;
	} else {
		$selectName = ($type == "pages" ? "wp_" : "")."setting__{$id}";
	}
	$selectBox = "<select id='{$id}' name='{$selectName}' ".($onChange == "" ? "" : "onchange='{$onChange}'")." {$inline}>";
	if ($defaultSetting != "") {
		$selectBox .= "<option value=''>{$defaultSetting}</option>";
	}
	if ($type == "pages") {
		foreach($options as $option) {
			if($selectedValue == $option->ID) {
				$selectBox .= '<option value="'.$option->ID.'" selected="selected">'.$option->post_title.'&nbsp;</option>';
			} else {
				$selectBox .= '<option value="'.$option->ID.'">'.$option->post_title.'&nbsp;</option>';
			}
		}
	} else if ($type == "select" || $type == "select2") {
		foreach($options as $o_value => $o_label) {
			if($selectedValue == $o_value || ($o_value == "0" && $selectedValue == "")) {
				$selectBox  .= '<option value="'.$o_value.'" selected="selected">'.$o_label.'&nbsp;</option>';
			} else {
				$selectBox  .=  '<option value="'.$o_value.'">'.$o_label.'&nbsp;</option>';
			}
		}				  
	} else if ($type == "select:array:name" || $type == "select2:array:name") {
		foreach($options as $key => $array) {
			if($selectedValue == $key) {
				$selectBox  .= '<option value="'.$key.'" selected="selected">'.$array['name'].'&nbsp;</option>';
			} else {
				$selectBox  .=  '<option value="'.$key.'">'.$array['name'].'&nbsp;</option>';
			}
		}				  
	}
	$selectBox .= "</select>";
	
	return $selectBox;
}	  
?>