<?php

function i3d_save_meta_data($postID) {	
ini_set ( "max_execution_time" , "0" );
$fieldsToUpdate = array();

	foreach($_POST as $key => $value) {
		//print $key."=".$value."<br>";
		if(substr($key,0,6) == "__i3d_") {
			$fieldName = substr($key, 6);
			//str_replace("__i3d_", "", $key);
			if (strstr($fieldName, "__")) {
				$fieldNameData = explode("__", $fieldName);
				$fieldName = $fieldNameData[0];
				$fieldAttributeName = $fieldNameData[1];
				
				//print $fieldName."<br>";
				if (@$fieldsToUpdate["$fieldName"] != "") {
				  $fieldData = $fieldsToUpdate["$fieldName"];
				} else {
				  $fieldData = (array)get_post_meta($postID, $fieldName, true);
				}
				//print "v".$fieldNameData[5]."<br>";
				if (@$fieldNameData[2] != "") {
				  if (@$fieldNameData[3] != "") {
					 if (@$fieldNameData[4] != "") {

						if (@$fieldNameData[5] != "") {
							$third = $fieldNameData[3];
							$fourth = $fieldNameData[4];
							$fifth = @$fieldNameData[5];
							if (!@is_array(@$fieldData["{$fieldAttributeName}"])) {
								$fieldData["{$fieldAttributeName}"] = array();
							}
							if (!@is_array(@$fieldData["{$fieldAttributeName}"]["{$fieldNameData[2]}"])) {
							  $fieldData["{$fieldAttributeName}"]["{$fieldNameData[2]}"] = array();
							}

							if (!@is_array(@$fieldData["{$fieldAttributeName}"]["{$fieldNameData[2]}"]["{$third}"])) {
							  $fieldData["{$fieldAttributeName}"]["{$fieldNameData[2]}"]["{$third}"] = array();
							}

							if (!@is_array(@$fieldData["{$fieldAttributeName}"]["{$fieldNameData[2]}"]["{$third}"]["{$fourth}"])) {
							  $fieldData["{$fieldAttributeName}"]["{$fieldNameData[2]}"]["{$third}"]["{$fourth}"]= array();
							}

							if (!@is_array(@$fieldData["{$fieldAttributeName}"]["{$fieldNameData[2]}"]["{$third}"]["{$fourth}"]["{$fifth}"])) {
							  $fieldData["{$fieldAttributeName}"]["{$fieldNameData[2]}"]["{$third}"]["{$fourth}"]["{$fifth}"] = array();
							}
							if ($fifth == "social_media_icon") {
								$sixth = $fieldNameData[6];
				    			$fieldData["{$fieldAttributeName}"]["{$fieldNameData[2]}"]["{$third}"]["{$fourth}"]["social_icon__".$sixth] = stripslashes($value);
								//print $sixth."=".$value."<br>";
							} else {
				    			$fieldData["{$fieldAttributeName}"]["{$fieldNameData[2]}"]["{$third}"]["{$fourth}"]["{$fifth}"] = stripslashes($value);
							}
						} else {
				    		$fieldData["{$fieldAttributeName}"]["{$fieldNameData[2]}"]["{$fieldNameData[3]}"]["{$fieldNameData[4]}"] = $value;
							
						}
						
						if ($third == "actual_graphic_logo") {
						//  print "third";	
						}
						if ($fourth == "actual_graphic_logo") {
						//  print "fourth";	
						}
					 } else {
				    	$fieldData["{$fieldAttributeName}"][$fieldNameData[2]][$fieldNameData[3]] = $value;
						 
					 }
					// print "[".$fieldData."]";
					//print $fieldAttributeName.":".$fieldNameData[2].":".$fieldNameData[3]."<br>";
					  
				  } else {
				    $fieldData["{$fieldAttributeName}"][$fieldNameData[2]] = $value;
					  
				  }
				} else {
				  $fieldData["{$fieldAttributeName}"] = $value;
				}
				$fieldsToUpdate["$fieldName"] = $fieldData;
				//var_dump($fieldData);
				//update_post_meta($postID, $fieldName, $fieldData);
			//	var_dump($fieldData);
			
			} else {
				$fieldsToUpdate["$fieldName"] = $value;

			}
	
		} else if(substr($key,0,9) == "__global_") {
			$fieldName = substr($key, 9);
			update_option($fieldName, $value);
			
		}
		
	}
	//exit;
	foreach ($fieldsToUpdate as $fieldName => $fieldData) {
		//print "updating $fieldName<br>";
		//var_dump($fieldData);
		if ($fieldName == "layouts") {
			//var_dump($fieldData['primary']['logo-social-search']['configuration']['socialmediaicons']);
		}
		update_post_meta($postID, $fieldName, $fieldData);
	
	}
	
	//exit();
}
function i3d_page_options() {
	  				$generalSettings = get_option('i3d_general_settings');
	?>
    <style>
	.ui-helper-hidden { display: none; }
.ui-helper-hidden-accessible { position: absolute; left: -99999999px; }
.ui-helper-reset { margin: 0; padding: 0; border: 0; outline: 0; line-height: 1.3; text-decoration: none; font-size: 100%; list-style: none; }
.ui-helper-clearfix:after { content: "."; display: block; height: 0; clear: both; visibility: hidden; }
.ui-helper-clearfix { display: inline-block; }
/* required comment for clearfix to work in Opera \*/
* html .ui-helper-clearfix { height:1%; }
.ui-helper-clearfix { display:block; }
/* end clearfix */

.ui-widget-content { border: 0px solid #ccc; background: ; color: #333333; }
.slider-range { border: 1px solid #ccc !important; }
.ui-widget-content h3 { font-size: 12pt; }
.ui-widget-content a { color: #333333; }
.ui-widget-header { border: 0px; border-bottom: 1px solid #cccccc !important; background: repeat-x; color: #ffffff; font-weight: bold; }
.ui-widget-header a { color: #ffffff; }


.ui-state-default, .ui-widget-content .ui-state-default,  .ui-widget-header .ui-state-default {
	border: 1px solid #cccccc; 
	background: #ddd; 
	font-weight: bold; 
	color: #666666; 
  background-repeat: repeat-x;
}

.rounded-box {
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
}


.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited { color: #666666; text-decoration: none; }
.ui-state-hover, .ui-widget-content .ui-state-hover, .ui-widget-header .ui-state-hover, .ui-state-focus, .ui-widget-content .ui-state-focus, .ui-widget-header .ui-state-focus { border: 1px solid #cccccc; background: #eeeeee; font-weight: bold; color: #3473D1; }
.ui-state-hover a, .ui-state-hover a:hover { color: #666666; text-decoration: none; }
.ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active
{ border: 1px solid #333333;
font-weight: bold; color: #000000;
  background-color: #666 !important;
}
.ui-state-active a, .ui-state-active a:link, .ui-state-active a:visited { color: #ffffff; text-decoration: none; }
 #page-options-tabs .ui-state-active, #settings-tabs .ui-state-default, #page-options-tabs .ui-widget-content .ui-state-default, #page-options-tabs .ui-widget-header .ui-state-default {
	-webkit-border-top-left-radius: 3px;
  -webkit-border-top-right-radius: 3px;
  -moz-border-radius-topleft:3px;
  -moz-border-radius-topright: 3px;
  border-top-left-radius: 3px;
  border-top-right-radius: 3px;
  border-bottom: 1px solid #cccccc !important;
}

.ui-widget :active { outline: none; }

.ui-tabs { position: relative; padding: .2em; zoom: 1; } /* position: relative prevents IE scroll bug (element with position: relative inside container with overflow: auto appear as "fixed") */
.ui-tabs .ui-tabs-nav { margin: 0; padding: .2em .2em 0; }

.ui-tabs .ui-tabs-nav li { border-bottom: 0px !important; list-style: none; float: left; position: relative; top: 1px; margin: 0 .2em 1px 0;  padding: 0; white-space: nowrap; }
.ui-tabs .ui-tabs-nav li a { float: left; padding: .3em .8em; text-decoration: none; }
.ui-tabs .ui-tabs-nav li a.instruction-tabs { padding: .5em 2em .5em !important; font-size: 8pt !important;}
.ui-tabs .ui-tabs-nav li a.instruction-wp-tabs { padding: .5em 2em .5em !important;  font-size: 8pt !important;}

.ui-tabs .ui-tabs-nav li.ui-tabs-selected { margin-bottom: 0; padding-bottom: 0px; background-color: #333333;}
.ui-tabs .ui-tabs-nav li.ui-tabs-selected a, .ui-tabs .ui-tabs-nav li.ui-state-disabled a, .ui-tabs .ui-tabs-nav li.ui-state-processing a { cursor: pointer; }
.ui-tabs .ui-tabs-nav li a, .ui-tabs.ui-tabs-collapsible .ui-tabs-nav li.ui-tabs-selected a { cursor: pointer; } /* first selector in group seems obsolete, but required to overcome bug in Opera applying cursor: text overall if defined elsewhere... */
.ui-tabs .ui-tabs-panel { display: block; border-width: 0; padding: 0em 0em; background: none; }
.ui-tabs .ui-tabs-hide { display: none !important; }
input, textarea, button { 	
    -moz-box-sizing:content-box !important;
	-webkit-box-sizing:content-box !important;
	-ms-box-sizing:content-box !important;
	box-sizing:content-box !important; 
	} 
.non-visible { display: none !important; } 
/* body { font-size: 11px; } */ 
.layout-table .well { margin-bottom: 2px !important; margin-top: 2px !important; }
#i3d_page_options div.handlediv { display: none; }
#i3d_page_options h3.hndle { display: none; }
#i3d_page_options div.inside { background-color: #ffffff; padding: 0px; }
#i3d_page_options h2 { font-size: 18pt; font-family: Verdana, Geneva, sans-serif; margin-top: 0px;  margin-bottom: 0px;}
#i3d_page_options h5 { font-size: 14px; font-family: Verdana, Geneva, sans-serif; margin-top: 0px; margin-bottom: 0px;}
#i3d_page_options p { font-size: 10pt; }
#i3d_page_options p.lead { font-size: 11pt; }
.alert { padding-right: 4px; padding-left: 4px; }
.toggle-group .dropdown-menu { min-width: 60px; }
.toggle-group i,
.toggle-group span
{ width: 15px; display: inline-block; }
.toggle-group { margin-top: -5px;  }
.toggle-group.tt { border-bottom-width: 0px !important; z-index: 99; position: relative; }
div.layout-table {  height: 2700px;  }
div.layout-table-inner { position: absolute; width: 98.5% }
table.layout-table { }
.well ul { margin-left: 0px; padding-left: 0px; }

div.span3 .alert.well { }
div.span2 .alert.well .toggle-group { clear: right; }
div.span2 .alert.well div.toggle-group:nth-child(3) { margin-top: 2px; margin-right: 0px !important; }


.layout-columns-select { width: 50px; }
.alert-margined { }
.layout-width-select   { width: 200px; }
.layout-sidebar-select { width: 200px; }

@media all and (max-width: 1300px) {
div.span3 .alert.well .toggle-group { clear: right; }
div.span3 .alert.well div.toggle-group:nth-child(3) { margin-top: 2px; margin-right: 0px !important; }
}

@media all and (max-width: 1200px) {
div.span4 .alert.well .toggle-group { clear: right; }
div.span4 .alert.well div.toggle-group:nth-child(3) { margin-top: 2px; margin-right: 0px !important; }
}

@media all and (max-width: 1100px) {
div.span5 .alert.well .toggle-group { clear: right; }
div.span5 .alert.well div.toggle-group:nth-child(3) { margin-top: 2px; margin-right: 0px !important; }
}
	</style>
          <script type="text/javascript">

									
									
//jQuery(document).ready(function() {
								//alert("yeahvv");
							<?php if (!I3D_Framework::use_global_layout()) { ?>
			  jQuery(document).ready(function() {
		setSpecialRegions(jQuery("#page_template").val());
			  });
		//alert("v");
		<?php } ?>
		//alert("e");
								
									
								//	alert("another");
		//jQuery('#page-options-tabs').tabs({ active: 5 });
		jQuery("#i3d_page_options").removeClass("postbox");
		
		<?php if (I3D_Framework::use_global_layout()) { ?>
		if (jQuery("#postdivrich").length > 0 ) {
			// move the i3d_page_options div block above the content editor
			
			//jQuery("#postdivrich").prepend(jQuery("#i3d_page_options"));			
			
			//jQuery("#wp-content-wrap").addClass("non-visible");
			//jQuery("#post-status-info").addClass("non-visible");
			
			jQuery("#tab-editor").parent("li").removeClass("non-visible");
			jQuery("#postdivrich").css("opacity", "1");

			jQuery('#tab-editor').on('shown.bs.tab', function (e) {
														   jQuery(this).tab("show");
														   jQuery("#wp-content-wrap").removeClass("non-visible");
														   jQuery("#post-status-info").removeClass("non-visible");
														 });
			jQuery(".nav-tabs li a").bind("click", function(e) {
														//	alert(jQuery(this).attr("id"));
															if (jQuery(this).attr("id") != "tab-editor") {
														 		e.preventDefault();
														   		jQuery(this).tab("show");
														   		//jQuery("#wp-content-wrap").addClass("non-visible");
														   	//	jQuery("#post-status-info").addClass("non-visible");
														   
														   
																			 } else {
																				//jQuery('html, body').animate({scrollTop: jQuery("#page-options-tabs").offset().top}, 1000);
																				//alert();
																				jQuery('html, body').animate({scrollTop: jQuery(document).scrollTop() + 10}, 0);
																				jQuery('html, body').animate({scrollTop: jQuery(document).scrollTop() - 10}, 0);
 
																			 }
																			 
												   
																					 
														 });

		}
		jQuery("#normal-sortables").css("display", "block");
		<?php } else { ?>
			jQuery("#postdivrich").css("opacity", "1");
		
		<?php } ?>
		jQuery("#normal-sortables").css("display", "block");
		
		
	//});
	</script>	
<?php include('includes/_layout-global.php'); ?>      
    
      <div>
	    <?php if (I3D_Framework::use_global_layout()) {
			include("includes/layout-chooser.php");
			} ?>
		<?php include('includes/intro.php'); ?>
		<?php include('includes/home.php'); ?>
		<?php include('includes/advanced.php'); ?>
		<?php include('includes/sitemap.php'); ?>
		<?php include('includes/blog.php'); ?>
		<?php include('includes/faqs.php'); ?>
		<?php include('includes/contact.php'); ?>
		<?php include('includes/team-members.php'); ?>
		<?php include('includes/minimized.php'); ?>
		<?php include('includes/under-construction.php'); ?>
		<?php include('includes/photo-slideshow.php'); ?>
		<?php include('includes/events-calendar.php'); ?>
        <div style='clear: both;'></div>
        <div id="page-options-tabs">
          <ul class='setting-tabs nav nav-tabs'>
<?php if (I3D_Framework::use_global_layout()) { ?>
         <!--   <li class='special-region non-visible intro home default contact faqs photo-slideshow sitemap team-members under-construction advanced events-calendar'><a data-toggle="tab" href="#tabs-editor" id='tab-editor'>Content</a></li>-->
            <li class='special-region non-visible blog'><a data-toggle='tab' href="#tabs-blog-settings" id='tab-blog-settings'>Blog Settings</a></li>

			<li><a data-toggle="tab" href="#tabs-layout-container" id='tab-layout-container'>Layout Overrides</a></li>

<?php } ?>
            <!-- global tabs -->
<?php if (!I3D_Framework::use_global_layout()) { ?>			
            <li class='special-region non-visible intro home default blog contact faqs photo-slideshow sitemap team-members under-construction advanced events-calendar'><a data-toggle="tab" href="#tabs-general" id='tab-general'>General</a></li>
<?php } ?>
<?php if (I3D_Framework::$headerBGSupport) { ?>
            <li class='special-region non-visible intro home default advanced blog contact faqs sitemap team-members under-construction events-calendar'><a data-toggle="tab" href="#tabs-header" id='tab-header'>Header</a></li>

<?php } ?>
<?php if (count(I3D_Framework::$themeStyleOptions) > 0) { ?>
            <li class='special-region non-visible default blog faqs sitemap team-members'><a data-toggle="tab" href="#tabs-theme-styles" id='tab-theme-styles'>Theme Layers</a></li>

<?php } ?>
            <li class='special-region non-visible intro home default advanced blog contact faqs sitemap team-members under-construction events-calendar'><a data-toggle='tab' href="#tabs-properties" id='tab-properties'>
			<?php if (I3D_Framework::use_global_layout()) { ?>Page Header Titles<?php } else { ?>Seach Engine Optimization<?php } ?></a></li>

			<!-- page specific settings -->
            <li class='special-region non-visible photo-slideshow'><a data-toggle='tab' href="#tabs-photo-slideshow-settings" id='tab-slideshow-settings'>Slideshow</a></li>
            <li class='special-region non-visible intro'><a data-toggle='tab' href="#tabs-intro-settings" id='tab-intro-settings'>Menu Labels</a></li>
            <li class='special-region non-visible contact'><a data-toggle='tab' href="#tabs-contact-settings" id='tab-contact-settings'>Map</a></li>
            <li class='special-region non-visible sitemap'><a data-toggle='tab' href="#tabs-sitemap-settings" id='tab-sitemap-settings'>Sitemap</a></li>
            <?php if (!I3D_Framework::use_global_layout()) { ?>
			<li class='special-region non-visible blog'><a data-toggle='tab' href="#tabs-blog-settings" id='tab-blog-settings'>Blog Settings</a></li>
            <?php } ?>
			<li class='special-region non-visible faqs'><a data-toggle='tab' href="#tabs-faqs-settings" id='tab-faqs-settings'>FAQ Settings</a></li>
          	<?php if (I3D_Framework::$isotopePortfolioVersion > 0) { ?><li class='special-region non-visible team-members'><a data-toggle='tab' href="#tabs-team-members-settings" id='tab-team-members-settings'>Team Member Settings</a></li><?php } ?>
            
             <?php if (!I3D_Framework::use_global_layout()) {    ?>       
            <!-- layout tabs -->
            <li class='special-region non-visible intro'><a data-toggle='tab' href="#tabs-intro-layout" id='tab-intro-layout'>Layout Manager</a></li>
            <li class='special-region non-visible home'><a data-toggle='tab' href="#tabs-home-layout" id='tab-home-layout'>Layout Manager</a></li>
            <li class='special-region non-visible default'><a data-toggle='tab' href="#tabs-minimized-layout" id='tab-minimized-layout'>Layout Manager</a></li>
            <li class='special-region non-visible advanced'><a data-toggle='tab' href="#tabs-advanced-layout" id='tab-advanced-layout'>Layout Manager</a></li>
            <li class='special-region non-visible blog'><a data-toggle='tab' href="#tabs-blog-layout" id='tab-blog-layout'>Layout Manager</a></li>
            <li class='special-region non-visible contact'><a data-toggle='tab' href="#tabs-contact-layout" id='tab-contact-layout'>Layout Manager</a></li>
            <li class='special-region non-visible faqs'><a data-toggle='tab' href="#tabs-faqs-layout" id='tab-faqs-layout'>Layout Manager</a></li>
            <li class='special-region non-visible photo-slideshow'><a data-toggle='tab' href="#tabs-photo-slideshow-layout" id='tab-intro-layout'>Layout</a></li>
            <li class='special-region non-visible sitemap'><a data-toggle='tab' href="#tabs-sitemap-layout" id='tab-sitemap-layout'>Layout Manager</a></li>
            <li class='special-region non-visible team-members'><a data-toggle='tab' href="#tabs-team-members-layout" id='tab-team-members-layout'>Layout Manager</a></li>
             <li class='special-region non-visible under-construction'><a data-toggle='tab' href="#tabs-under-construction-layout" id='tab-under-construction-layout'>Layout Manager</a></li> 
             <li class='special-region non-visible events-calendar'><a data-toggle='tab' href="#tabs-events-calendar-layout" id='tab-events-calendar-layout'>Layout Manager</a></li> 

            <?php } ?>
          </ul>
          
          <div class='tab-content'> 
<?php if (I3D_Framework::use_global_layout()) { ?>
            <div class='tab-pane fade' id="tabs-editor"></div>
            <div class='tab-pane fade' id="tabs-layout-container">
			<?php include ("includes/layout-manager.php"); ?>
			</div>

<?php } ?>

            <div class='tab-pane fade  special-region non-visible intro home default advanced blog contact faqs photo-slideshow sitemap team-members under-construction events-calendar' id="tabs-properties">
          	<?php include('includes/seo.php'); ?>
            </div>
<?php if (!I3D_Framework::use_global_layout()) { ?>			
            <div class='tab-pane fade in <?php if (I3D_Framework::use_global_layout()) { ?>active<?php } ?> advanced special-region non-visible intro home default advanced blog contact faqs photo-slideshow sitemap team-members under-construction events-calendar' id="tabs-general">
          	<?php include('includes/general.php'); ?>
            </div>
<?php } ?>            
            
   <?php if (count(I3D_Framework::$themeStyleOptions) > 0) { ?>
      <div class='tab-pane fade in special-region non-visible default blog contact faqs sitemap team-members' id="tabs-theme-styles">
          <?php include('includes/theme-layer-styles.php'); ?>
</div>
<?php } ?>
      	
			<?php include('includes/header-tabs.php'); ?>
			<?php include('includes/intro-tabs.php'); ?>
			<?php include('includes/home-tabs.php'); ?>
			<?php include('includes/advanced-tabs.php'); ?>
			<?php include('includes/blog-tabs.php'); ?>
			<?php include('includes/sitemap-tabs.php'); ?>
			<?php include('includes/faqs-tabs.php'); ?>
			<?php include('includes/contact-tabs.php'); ?>
			<?php include('includes/team-members-tabs.php'); ?>
			<?php include('includes/minimized-tabs.php'); ?>
			<?php include('includes/photo-slideshow-tabs.php'); ?>
			<?php include('includes/under-construction-tabs.php'); ?>
			<?php include('includes/events-calendar-tabs.php'); ?>
 			<?php // include('includes/minimized.php'); ?>
 			<?php //include('includes/advanced.php'); ?>
 			<?php //include('includes/blog.php'); ?>
 			<?php //include('includes/contact.php'); ?>
 			<?php //include('includes/faqs.php'); ?>
 			<?php //include('includes/photo-slideshow.php'); ?>
 			<?php //include('includes/sitemap.php'); ?>
 			<?php //include('includes/team-members.php'); ?>
 			<?php //include('includes/under-construction.php'); ?>
            </div>
            <div style='clear: both;'></div>
          </div>
      </div>
<script>
function setSidebars(layout) {
	var layout = layout.replace(/.php/, '');
	//alert(layout);
	jQuery(".optional-sidebars tr.configurable").addClass("non-editable");
	//if (layout == "default") {
	  jQuery(".optional-sidebars tr." + layout).removeClass("non-editable");
	//} else {
		
	//}
	
	
}


function setSpecialFocalBoxFields(layout) {
	//alert(layout);
	var ctas = jQuery("." + layout + " div.layout-table").find(".i3d_fb");
	//alert(ctas.length);
	if (ctas.length == 0) {
	  jQuery(".special-widgets.focal-boxes").addClass("non-visible");
	} else {
	  jQuery(".special-widgets.focal-boxes").removeClass("non-visible");
	  jQuery(".special-widgets.focal-boxes").find(".focal-box_2").addClass("non-visible");  
	  jQuery(".special-widgets.focal-boxes").find(".focal-box_3").addClass("non-visible");  
	 // alert("v");
	  for (i = 1; i <= ctas.length; i++) {
		 // alert("x" + i);
	    jQuery(".special-widgets.focal-boxes").find(".focal-box_" + i).removeClass("non-visible");  
	  }
	}

}


function setSpecialCTAFields(layout) {
	//alert(layout);
	var ctas = jQuery("." + layout + " div.layout-table").find(".i3d_cta");
	//alert(ctas.length);
	if (ctas.length == 0) {
	  jQuery(".special-widgets.calls-to-action").addClass("non-visible");
	} else {
	  jQuery(".special-widgets.calls-to-action").removeClass("non-visible");
	  jQuery(".special-widgets.calls-to-action").find(".call-to-action_2").addClass("non-visible");  
	  jQuery(".special-widgets.calls-to-action").find(".call-to-action_3").addClass("non-visible");  
	 // alert("v");
	  for (i = 1; i <= ctas.length; i++) {
		 // alert("x" + i);
	    jQuery(".special-widgets.calls-to-action").find(".call-to-action_" + i).removeClass("non-visible");  
	  }
	}

}

function setSpecialRegions(layout) {
	var layout = layout.replace(/.php/, '');
	layout = layout.replace(/template-/, '');
	jQuery(".special-region").addClass("non-visible");
	jQuery(".special-widgets").addClass("non-visible");
	jQuery(".special-widgets").each(function() {
											 if (jQuery(this).hasClass("layout")) {
												 jQuery(this).removeClass("non-visible");
											 }
											 });
//alert("new setSpecialRegions");
	var count = jQuery("." + layout).removeClass("non-visible");
	if (layout == "advanced") {
//		alert("may");
		jQuery('#page-options-tabs li:eq(1) a').tab("show"); 
	//	alert("be");
	} else {
		//jQuery('#page-options-tabs li:eq(0) a').tab("show"); 
		
	}
		
	/*
	if (layout == "home") {
		jQuery('#page-options-tabs').tabs("option", "active", 0); 	
	} else if (layout == "default") {
		jQuery('#page-options-tabs').tabs("option", "active", 1); 	
	} else if (layout == "advanced") {
		jQuery('#page-options-tabs').tabs("option", "active", 2); 
	} else if (layout == "blog") {
		jQuery('#page-options-tabs').tabs("option", "active", 3); 	
	} else if (layout == "contact") {
		jQuery('#page-options-tabs').tabs("option", "active", 4); 	
	} else if (layout == "faqs") {
		jQuery('#page-options-tabs').tabs("option", "active", 5); 
	} else if (layout == "photo-slideshow") {
		jQuery('#page-options-tabs').tabs("option", "active", 6); 
	} else  if (layout == "sitemap") {
		jQuery('#page-options-tabs').tabs("option", "active", 7); 	
	} else  if (layout == "team-members") {
		jQuery('#page-options-tabs').tabs("option", "active", 8); 	
	} else  if (layout == "under-construction") {
		jQuery('#page-options-tabs').tabs("option", "active", 9); 	
	} 
	*/
	setSpecialCTAFields(layout);
	setSpecialFocalBoxFields(layout);
}

	


jQuery(document).ready(function() {
								<?php if (!I3D_Framework::use_global_layout()) { ?>
jQuery("#page_template").bind("change", function() {
												 var selectedLayout = jQuery(this).val();
								setSidebars(selectedLayout);
								setSpecialRegions(selectedLayout);
												});


								
setSidebars(jQuery("#page_template").val());
<?php } else { ?>
<?php } ?>
});
</script>
	
      <?php
      
	
}

function i3d_add_meta_boxes() {	
	$columnSelected = 0;
	add_meta_box('i3d_page_options', 'Page Configuration', 'i3d_page_options', 'page', 'normal', 'high');
	
	//add_action('save_post', 'i3d_save_meta_data');
	add_action('pre_post_update', 'i3d_save_meta_data');
}

add_action('admin_menu', 'i3d_add_meta_boxes');


?>