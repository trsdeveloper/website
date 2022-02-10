<?php
function i3d_request_configuration() {
	global $templateName;
	global $availableConfigurations;
	global $lmDefaultPages;
			$templateName2 = str_replace(' ', '_', ucwords($templateName));
   $templates = get_page_templates();
   //$templates = array_merge(array("Default" => "index.php"), $templates);
   global $i3dSupportedSidebars;
   $availableTemplates = array("default" => "Default");
   foreach ( $templates as $template_name => $template_filename ) {
	   $templateShortName = str_replace("template-", "", str_replace(".php", "", $template_filename));
	   $availableTemplates["$templateShortName"] =  $template_name;
	   
   }
$pages = get_pages();
?>
<?php 
function tryToSelectLayout($template, $pageTitle) {
  if ($template == "team-members" && stristr($pageTitle, "about")) {
	  print " selected";
	  return;
  } else if ($template == "faqs" && (stristr($pageTitle, "faq") || stristr($pageTitle, "questions"))) {
    print " selected";
	return;
  } else if ($template == "home" && stristr($pageTitle, "home")) {
	print " selected";
	return;
  } else if ($template == "blog" && stristr($pageTitle, "blog")) {
    print " selected";
	return;
  } else if ($template == "contact" && stristr($pageTitle, "contact")) {
    print " selected";
	return;
  } else if ($template == "sitemap" && stristr($pageTitle, "sitemap")) {
    print " selected";
	return;
  } else if ($template == "photo-slideshow" && stristr($pageTitle, "photo")) {
    print " selected";
	return;
  }
	
}
function tryToSelectMenu($menu, $pageTitle) {
  if ($menu == "top") {
	  if (stristr($pageTitle, "home") ||
		  stristr($pageTitle, "about") ||
		  stristr($pageTitle, "blog") ||
		  stristr($pageTitle, "photo") ||
		  stristr($pageTitle, "contact") ||
		  stristr($pageTitle, "faq")) {
		
		  print " checked";
		  return;
	  }
  } else if ($menu == "side") {
	  if (stristr($pageTitle, "home") ||
		  stristr($pageTitle, "about") ||
		  stristr($pageTitle, "photo") ||
		  stristr($pageTitle, "contact") ||
		  stristr($pageTitle, "faq")) {
		  print " checked";
		  return;
	  }
  } else if ($menu == "text") {
	  if (stristr($pageTitle, "home") ||
		  stristr($pageTitle, "about") ||
		  stristr($pageTitle, "contact")) {
		
		  print " checked";
		  return;
	  }
  } else if ($menu == "footer") {
	  if (stristr($pageTitle, "home") ||
		  stristr($pageTitle, "about") ||
		  stristr($pageTitle, "blog") ||
		  stristr($pageTitle, "photo") ||
		  stristr($pageTitle, "contact") ||
		  stristr($pageTitle, "privacy") ||
		  stristr($pageTitle, "sitemap") ||
		  stristr($pageTitle, "faq")) {
		
		  print " checked";
		  return;
	  }
  }
}


?>
<style>
  #setting-error-tgmpa { display: none; }
  .update-nag { display: none; }
</style>
<script>
  function startProgress() {
	  jQuery("#config-options").css("display", "none");
	  jQuery("#progress-box-wrapper").css("display", "block");
	  	//jQuery.ajax({ url: "themes.php?activated=true&configuration=" });
		statusTimeout = setTimeout("checkStatus()", 0);
	//checkStatus();

  }
  
	var installationStatus = 0;
	
	function checkStatus() {
		jQuery.ajax({ url: "admin.php?page=i3d-settings&install=progress" }).done( function(data) {
																																
		jQuery("#current-step").html(jQuery(data).find("#status").text());
		installationStatus = parseInt(jQuery(data).find("#status-percent").text());
		if (installationStatus >= 100) {
			
			//alert("yup");
			jQuery("#cog-icon").removeClass("icon-spin");
			jQuery("#cog-icon").removeClass("icon-cog");
			jQuery("#cog-icon").addClass("icon-ok");
			
			jQuery("#progress-bar").css("width", "100%");
			jQuery("#percentage").html("100%");
			//alert(jQuery("#percentage").html());
			jQuery("#progress-bar").removeClass("progress-bar-warning");	
			jQuery("#progress-bar").removeClass("progress-bar-danger");	
			jQuery("#progress-bar").addClass("progress-bar-success");	
			
			jQuery("#progress-bar-wrapper").removeClass("active");
			jQuery("#progress-bar-wrapper").removeClass("progress-striped");
			jQuery("#installation-complete").css("display", "block");
			jQuery("#current-step").html("Installation Complete!");
			clearTimeout(statusTimeout);
		    return;
		} else {
			//installationStatus += 10;
		}
		if (installationStatus > 25) {
			jQuery("#progress-bar").removeClass("progress-bar-danger");
			jQuery("#progress-bar").addClass("progress-bar-warning");

		}
		if (installationStatus > 65) {
			jQuery("#progress-bar").removeClass("progress-bar-warning");	
		}
		if (installationStatus > 85) {
			jQuery("#progress-bar").addClass("progress-bar-success");	
		}
		
		jQuery("#progress-bar").css("width", installationStatus + "%");
		jQuery("#percentage").html(installationStatus + "%");
		statusTimeout = setTimeout("checkStatus()", 2000);
		});	
		
	}
	
	function toggleiframe() {
		
	  if (jQuery("#hidden-frame").hasClass("visible-iframe")) {
	    jQuery("#hidden-frame").removeClass("visible-iframe");
	  } else {
	    jQuery("#hidden-frame").addClass("visible-iframe");
		  
	  }
	}
	

  
</script>
<style>
	#progress-box {
		width: 500px; 
		margin: auto; 
	}
	#info-box {
		max-width: 750px; 
		margin: auto; 
		margin-top: 50px;
	}
	#config-options h2 { margin-top: 65px; }
	#progress-box h2, #progress-box h3 { font-weight: normal; margin-top: 0px; }
	#percentage { font-size: 8pt; margin-bottom: 20px; }
	#progress-bar-wrapper { margin-bottom: 0px; }
	blockquote p { font-size: 11pt; }
	</style>
<div class="" style='padding-left: 20px !important;' id='config-options'>
<div class='container'>
		<h2 class='text-center'><i class='icon-cog'></i> Theme Configuration</h2>
    <style>
		ul#lm_dashboard_manager {}
#lm_dashboard_manager li { margin-right: 15px; cursor: pointer; float: left; width: 240px; border: 1px solid #cccccc; height: 60px; padding: 3px; border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px; }
#lm_dashboard_manager li:hover { background-color: #eee; }
#lm_dashboard_manager img { float: left; padding-top: 4px; padding-right: 10px; padding-left: 7px;}
#lm_dashboard_manager h5 { font-size: 10pt; font-weight: bold; margin: 0px; padding: 0px; padding-bottom: 3px;}
#lm_dashboard_manager p { margin: 0px; padding:0px;  line-height: 1.14; font-size: 12px !important}
#lm_dashboard_manager a { color: #333333; text-decoration: none;}
#lm_dashboard_manager a:hover { color: #000; }
#lm_dashboard_manager a:hover h5 { color: #000; }
#lm_dashboard_manager a:hover p { color: #333; }
/*
div#custom-pages {
	opacity: 0;
	filter:alpha(opaicty=0);
}
*/

.table-striped tbody > tr:nth-child(2n) > td {
	background-color: #ffffff;
}
.table td.text-center { text-align: center; }
label { display: inline-block; }
input[type="radio"] { margin-top: 0px; }
#optional_configurations label { width: 210px; }
#hidden-frame {
	display: none;
}
.visible-iframe {
	display: block !important;
    border: 1px solid #cccccc;
	margin: auto;
    width: 80%;
    height: 275px;
}
		</style>    
  <p class='text-center'>Tell us how you would like your theme initialized.</p>

        <div class=''>
        <!--<div class='span6' id="default-setup">  
  <h4><i class='icon-certificate'></i> Default Setup <?php if (sizeof($pages) < 2) { ?><span class='label label-success'>Recommended</span><?php } ?></h4>
  <p>If you're starting a brand new site<?php if (sizeof($pages) < 2) { ?> <b>(and it appears you are)</b><?php } ?>, we recommend this option.  With this option, we will create a set of standard pages and configure them for you with all the bells and whistles as you would expect.</p>
   <?php if (sizeof($pages) >= 2) { ?><p>Your existing set of pages will be kept, however they will not appear in the navigation, nor will they have any of the templates or styles applied to them.</p><?php } ?>

    <a href='?page=i3d-settings&activated=true&configuration=default' class='btn <?php if (sizeof($pages) < 2) { ?>btn-success<?php } ?>'  ><i class='icon-bolt'></i> Go For It!</a>
  </div>
  -->
    <form method="post" onsubmit='startProgress()' target='hidden-frame'>
  <br/>
<p><b>The following will be created</b>:</p>
  <ul class='fa-ul'>
    <li><i class='fa fa-check-square'></i> Menus</li>
    <li><i class='fa fa-check-square'></i> Sidebars</li>
  </ul>
  <br/>
<p><b>Optional initialization options</b>:</p>
<?php $benchmark = I3D_Framework::get_post_create_time(); 
$slowServer = I3D_Framework::is_slow_server();
if ($slowServer && false) { ?>
<div class='alert alert-danger'>It appears you may be on a slower server.  If you run into problems with initializing any of the following components, you may use the "Theme Framework Extender" plugin, that we also include, 
to initialize your theme.</div>
<?php } ?>
<!-- benchmark: <?php echo $benchmark; ?> --> 
  <ul class='fa-ul' id='optional_configurations'>
    <li><input type='checkbox' checked name="init_pages" 				id="init_pages" 				value="1" /> <label for="init_pages">Pages</label> <span class='label label-success'>Recommended</span></li>
    <li><input type='checkbox' checked name="init_widgets" 				id="init_widgets" 				value="1" /> <label for="init_widgets">Widgets</label> <span class='label label-success'>Recommended</span></li>
    <li><input type='checkbox' <?php if (!$slowServer) { ?>checked<?php } ?> name="init_forms" 				id="init_forms" 				value="1" /> <label for="init_forms">Forms</label> <span class='label label-success'>Recommended</span></li>
    <?php if (I3D_Framework::$optionalStyledBackgrounds > 0 ) { ?>
	<li><input type='checkbox' <?php if (!$slowServer) { ?>checked<?php } ?> name="init_active_backgrounds" 	id="init_active_backgrounds"	value="1" /> <label for="init_active_backgrounds">Active Backgrounds</label> <span class='label label-success'>Recommended</span></li>
    <?php } ?>
	<?php if (I3D_Framework::$focalBoxVersion == 0) { ?>
    <li><input type='checkbox' <?php if (!$slowServer) { ?>checked<?php } ?> name="init_calls_to_action" 		id="init_calls_to_action"			value="1" /> <label for="init_calls_to_action">Calls To Action</label> <span class='label label-success'>Recommended</span></li>
    <?php } ?>	

	<?php if (I3D_Framework::$focalBoxVersion > 0 ) { ?>
    <li><input type='checkbox' <?php if (!$slowServer) { ?>checked<?php } ?> name="init_focal_boxes" 			id="init_focal_boxes"			value="1" /> <label for="init_focal_boxes">Focal Boxes</label> <span class='label label-success'>Recommended</span></li>
    <?php } ?>	
	<li><input type='checkbox' <?php if (!$slowServer) { ?>checked<?php } ?> name="init_posts" 				id="init_posts"					value="1" /> <label for="init_posts">Example Posts</label> <span class='label label-default'>Optional</span></li>
	<li><input type='checkbox' <?php if (!$slowServer) { ?>checked<?php } ?> name="init_content_panel_groups" id="init_content_panel_groups"	value="1" /> <label for="init_content_panel_groups">Example Content Panel Groups</label> <span class='label label-default'>Optional</span></li>
  
    <?php if (I3D_Framework::$isotopePortfolioVersion > 0) { ?>
	<li><input type='checkbox'  name="init_portfolio_items" 		id="init_portfolio_items"	<?php if (!$slowServer) { ?>checked<?php } ?> value="1" /> <label for="init_portfolio_items">Example Portfolio Items</label> <span class='label label-default'>Optional</span></li>
	<?php } ?>
	<li><input type='checkbox'  name="init_faqs" 				id="init_faqs"			<?php if (!$slowServer) { ?>checked<?php } ?> 		value="1" /> <label for="init_faqs">Example FAQs</label> <span class='label label-default'>Optional</span></li>
    <li><input type='checkbox'  name="init_testimonials" 		id="init_testimonials"	<?php if (!$slowServer) { ?>checked<?php } ?> 		value="1" /> <label for="init_testimonials">Example Quotations</label> <span class='label label-default'>Optional</span></li>
    <li><input type='checkbox'  name="init_team_members" 		id="init_team_members"	<?php if (!$slowServer) { ?>checked<?php } ?> 		value="1" /> <label for="init_team_members">Example Team Members</label> <span class='label label-default'>Optional</span></li>
 <!--     -->
  </ul>
  	 <br/>

  
	  
	
      <?php if (sizeof($pages) > 1) { ?>
	  <input type='hidden' name="config" value="requested" />
	  

  <div class='span12 well' id="custom-setup" >
  <h4><i class='icon-sitemap'></i> Page &amp Navigation Setup <?php if (sizeof($pages) >= 2 && false) { ?><span class='label label-success'>Recommended</span><?php } ?></h4>
<p>Choose the template layout, as well as which menu you want each page to be included in.</p>
<!--<p>We recommend this option if you already have a site existing<?php if (sizeof($pages) >= 2) { ?> <b>(and it appears you do)</b><?php } ?>, and just want to convert those existing pages over to the styles as one would expect to see.</p>-->
  <!--    <a id="open-custom-pages-button" onclick='openCustom()' class='btn <?php if (sizeof($pages) >= 2) { ?>btn-success<?php } ?>' ><i class='icon-cogs'></i> Configure</a>-->
   <table class='table table-bordered table-striped'>
     <tr class='info'>
       <td><b>Page</b></td>
       <td><b>Layout</b></td>
       <td class='text-center'><b>Top Menu</b></td>
       <td class='text-center'><b>Side Menu</b></td>
       <td class='text-center'><b>Text Links</b></td>
       <td class='text-center'><b>Footer Menu</b></td>
     </tr>

     <?php 
	 $pages = get_pages();
	 foreach ($pages as $page) { ?>
     <tr>
       <td class='page-template-selector'><?php echo $page->post_title; ?></td>
       <td>
       <select name="page_template__<?php print $page->ID; ?>">
         <?php foreach ($availableTemplates as $template => $templateFileName) {
			 if ($templateFileName == "Default") {
				 $templateFileName = "Default (Minimized)";
			 }
			 ?>
         <option value="<?php echo $template; ?>" <?php tryToSelectLayout($template, $page->post_title); ?> ><?php echo $templateFileName; ?></option>
         <?php } ?>
       </select>
       </td>
       <td class='text-center'><input type='checkbox' name="top_menu__<?php print $page->ID; ?>" value="1" <?php tryToSelectMenu("top", $page->post_title); ?> /></td>
       <td class='text-center'><input type='checkbox' name="side_menu__<?php print $page->ID; ?>" value="1" <?php tryToSelectMenu("side", $page->post_title); ?> /></td>
       <td class='text-center'><input type='checkbox' name="text_menu__<?php print $page->ID; ?>" value="1" <?php tryToSelectMenu("text", $page->post_title); ?> /></td>
       <td class='text-center'><input type='checkbox' name="footer_menu__<?php print $page->ID; ?>" value="1" <?php tryToSelectMenu("footer", $page->post_title); ?> /></td>
     </tr>
     <?php } ?>
     </table>
     <?php } ?>
     
     <?php
		$existingI3dSettings = get_option('i3d_general_settings');
		$existingLMSettings  = get_option('luckymarble_general_settings');

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
		  // print "existing lm settings";
		  // var_dump($existingLMSettings);
			
		} else {
			//print "no exissting settings";
		  $previousVersion = 0;	
		}
	 if ($previousVersion == 0) { 
	 
	 } else if ($previousVersion < 4 ) { ?>
	 <br/>
	 <h4><i class='icon-code-fork'></i> Widget &amp Sidebar Setup</h4>
     <p>Any existing standard WordPress Widgets will be saved and moved to the "Inactive Widgets" panel on the Widgets configuration page.  As
     this theme uses many custom widgets to give you more power and control, your site will be initialized and configured with our specialized widgets.  After initialization,
     you may change the configuration as you wish.</p>
     <input type='hidden' name='widget_initialization' value='reset' />
    <?php } else { ?>
	 <br/>
	<h4><i class='icon-code-fork'></i> Widget &amp Sidebar Setup</h4>
    <p>We have detected that you are upgrading from an existing Aquila Framework wordpress theme.  You have the option to:</p>
    <ul>
      <li><input type='radio' checked value='keep' name='widget_initialization' id="widget_initialization_keep" /> <label for="widget_initialization_keep">KEEP the EXISTING widgets in their sidebars</label></li>
      <li> - or - </li>
      <li><input type='radio' value='reset' name='widget_initialization' id="widget_initialization_reset"  /> <label for="widget_initialization_reset">RESET all of the sidebars to the default configuration</label></li>
    </ul>
    <?php } ?>
	
	
     <button onclick='submitCustom(this)' class='btn btn-success pull-right' style='margin-right: 20px;' >Continue <i class='icon-angle-right'></i></button>
  </div>
  </form>

  </div>
  </div>
</div>
<div id='progress-box-wrapper'  style="display: none">
      <div id="progress-box" class='text-center'>
        <h2>Theme Installation Progress</h2>
        <i id='cog-icon' class='icon-cog icon-spin' onclick='toggleiframe()'></i>
		<div id='progress-bar-wrapper' class='progress progress-striped active'>
           <div id='progress-bar' class='progress-bar bar-danger' style='width: 0%'></div>
        </div>
        <div id='percentage'>&nbsp;</div>
        <div id='current-step' class='current-step'>&nbsp;</div>
      </div>
      <div id="info-box">
        <div class='info-region well text-left' style='margin-top: 20px;'>
        <h3>Did You know?</h3>
        <blockquote>
        <p>WordPress started in 2003 with a single bit of code to enhance the typography of everyday writing and with fewer users than you can count on your fingers and toes. Since then it has grown to be the largest self-hosted blogging tool in the world, used on millions of sites and seen by tens of millions of people every day.</p>
        <small>WordPress.org</small>
        </blockquote>
        </div>
        <div id='installation-complete' class='text-right' style='display: none;'>
        <a id='finished-installing' class='btn btn-success' href="admin.php?page=i3d-settings">Continue</a>
        </div>
      </div>
	  <iframe name='hidden-frame' id='hidden-frame'></iframe>

</div>
 <script>
 function submitCustom(theButton) {
	// theButton.form.target="_self";
	 theButton.form.action="?page=i3d-settings&upgraded=true&activated=true&reset=true&configuration=custom";
	 theButton.form.submit();
 }
 function openCustom() {
	jQuery("#default-setup").animate({'opacity': 0});
	jQuery("#default-setup").css("display", "none");
	jQuery("#open-custom-pages-button").animate({'opacity': 0});
	jQuery("#custom-pages").animate({'opacity': 1});
	jQuery("#custom-setup").addClass("span12").removeClass("span6");
	
 }
 
 document.getElementById('finished-installing').onclick = function(){
    window.btn_clicked = true;      
};
window.onbeforeunload = function(){
    if(!window.btn_clicked){
        return 'The installation process has not finished -- please wait until it has completed.';
    }
};	
</script>
	<?php
}
?>