<?php
function luckymarble_styling() {
	global $templateName;
	global $lmFrameworkVersion;
	
	if ($_GET['config'] == "requested") {
		luckymarble_request_configuration();
	} else {
	?>
  <style>
#settings-tabs h2 { margin-top: 0px !important; padding-top: 0px !important; }
#settings-tabs th { padding: 4px 15px !important;  width: 100px; }
#settings-tabs td { padding: 3px 4px !important; }
#settings-tabs h3 { margin-top: 0px !important; padding-top: 0px !important; margin-bottom: 0px !important; padding-bottom: 0px !important; }

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
.ui-widget-content h3 { font-size: 12pt; }
.ui-widget-content a { color: #333333; }
.ui-widget-header { border: 0px; border-bottom: 1px solid #cccccc; background: repeat-x; color: #ffffff; font-weight: bold; }
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
font-weight: bold; color: #000000; }
.ui-state-active a, .ui-state-active a:link, .ui-state-active a:visited { color: #ffffff; text-decoration: none; }
 #settings-tabs .ui-state-active, #settings-tabs .ui-state-default, #settings-tabs .ui-widget-content .ui-state-default, #settings-tabs .ui-widget-header .ui-state-default {
	-webkit-border-top-left-radius: 3px;
  -webkit-border-top-right-radius: 3px;
  -moz-border-radius-topleft:3px;
  -moz-border-radius-topright: 3px;
  border-top-left-radius: 3px;
  border-top-right-radius: 3px;
}

.ui-widget :active { outline: none; }

.ui-tabs { position: relative; padding: .2em; zoom: 1; } /* position: relative prevents IE scroll bug (element with position: relative inside container with overflow: auto appear as "fixed") */
.ui-tabs .ui-tabs-nav { margin: 0; padding: .2em .2em 0; }

.ui-tabs .ui-tabs-nav li { list-style: none; float: left; position: relative; top: 1px; margin: 0 .2em 1px 0; border-bottom: 0 !important; padding: 0; white-space: nowrap; }
.ui-tabs .ui-tabs-nav li.instruction-tabs { list-style: none; float: left; position: relative; top: 0px; margin: 0 0em 0px 0; border-bottom: 0 !important; padding: 0; white-space: nowrap; }
.ui-tabs .ui-tabs-nav li.instruction-wp-tabs { list-style: none; float: left; position: relative; top: 0px; margin: 0 0em 0px 0; border-bottom: 0 !important; padding: 0; white-space: nowrap; }
.ui-tabs .ui-tabs-nav li a { float: left; padding: .3em .8em; text-decoration: none; }
.ui-tabs .ui-tabs-nav li a.instruction-tabs { padding: .5em 2em .5em !important; font-size: 8pt !important;}
.ui-tabs .ui-tabs-nav li a.instruction-wp-tabs { padding: .5em 2em .5em !important;  font-size: 8pt !important;}

.ui-tabs .ui-tabs-nav li.ui-tabs-selected { margin-bottom: 0; padding-bottom: 0px; background-color: #333333;}
.ui-tabs .ui-tabs-nav li.ui-tabs-selected a, .ui-tabs .ui-tabs-nav li.ui-state-disabled a, .ui-tabs .ui-tabs-nav li.ui-state-processing a { cursor: pointer; }
.ui-tabs .ui-tabs-nav li a, .ui-tabs.ui-tabs-collapsible .ui-tabs-nav li.ui-tabs-selected a { cursor: pointer; } /* first selector in group seems obsolete, but required to overcome bug in Opera applying cursor: text overall if defined elsewhere... */
.ui-tabs .ui-tabs-panel { display: block; border-width: 0; padding: 0em 0em; background: none; }
.ui-tabs .ui-tabs-hide { display: none !important; }
	
	</style>
	
	<script type="text/javascript">
	jQuery(function(){
		jQuery('#settings-tabs').tabs();
	});
	</script>		
  <?php
	$settingOptions = array();
	$settingOptions["General"]["Global"][0]      	= array('file' => 'styles/fonts.css', 'class_line' => "html,body,div,header,footer,nav,article,section,figure,aside,span,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,del,tt,dl,dt,dd,ol,ul,li,table,caption,tbody,tfoot,thead,tr,th,td", 'elements' => array('font-family', 'font-size', 'color'));
	$settingOptions["General"]["Copyright"][0]		= array('file' => 'styles/fonts.css', 'class_line' => "#copyright", 'elements' => array('font-family', 'color', 'font-size'));
	
	$settingOptions["Page Title"]["Styling"][0]  						= array('file' => 'styles/fonts.css', 'class_line' => "#seo_1, #seo_1 a, #seo_1 p, #seo_1 span, #seo_1 div", 'elements' => array('font-family', 'font-size', 'color'));
	$settingOptions["Page Title"]["Primary Layout Positioning"][0]		= array('file' => 'styles/primary.css', 'class_line' => "logos\\*\\/[\s\S]*?#seo_1", 'elements' => array('top', 'left', 'right'));
	$settingOptions["Page Title"]["Secondary Layout Positioning"][0]	= array('file' => 'styles/secondary.css', 'class_line' => "logos\\*\\/[\s\S]*?#seo_1", 'elements' => array('top', 'left', 'right'));
	$settingOptions["Page Title"]["Minimized Layout Positioning"][0]	= array('file' => 'styles/minimized.css', 'class_line' => "logos\\*\\/[\s\S]*?#seo_1", 'elements' => array('top', 'left', 'right'));
	
	$settingOptions["Page Description"]["Styling"][0]	 					= array('file' => 'styles/fonts.css', 'class_line' => "#seo_2, #seo_2 a, #seo_2 p, #seo_2 span, #seo_2 div	", 'elements' => array('font-family', 'font-size', 'color'));
	$settingOptions["Page Description"]["Primary Layout Positioning"][0]	= array('file' => 'styles/primary.css', 'class_line' => "logos\\*\\/[\s\S]*?#seo_2", 'elements' => array('top', 'left', 'right'));
	$settingOptions["Page Description"]["Secondary Layout Positioning"][0]	= array('file' => 'styles/secondary.css', 'class_line' => "logos\\*\\/[\s\S]*?#seo_2", 'elements' => array('top', 'left', 'right'));
	$settingOptions["Page Description"]["Minimized Layout Positioning"][0]	= array('file' => 'styles/minimized.css', 'class_line' => "logos\\*\\/[\s\S]*?#seo_2", 'elements' => array('top', 'left', 'right'));
	
	$settingOptions["Website Name"]["Styling"][0]		= array('file' => 'logo/css/logo.css', 'class_line' => ".websitename, .websitename a, .websitename p, .websitename a:link, .websitename a:visited, .websitename a:active, .websitename a:hover", 'elements' => array('font-family', 'font-size', 'color'));
	$settingOptions["Website Name"]["Gradient"][0]		= array('file' => 'logo/js/logo.js', 'search_line' => "colors:", 'elements' => array('start', 'end'));
	$settingOptions["Website Name"]["Primary Layout Positioning"][0]	= array('file' => 'styles/primary.css', 'class_line' => "logos\\*\\/[\s\S]*?#text_logo", 'elements' => array('top', 'left', 'right'));
	$settingOptions["Website Name"]["Secondary Layout Positioning"][0]	= array('file' => 'styles/secondary.css', 'class_line' => "logos\\*\\/[\s\S]*?#text_logo", 'elements' => array('top', 'left', 'right'));
	$settingOptions["Website Name"]["Minimized Layout Positioning"][0]	= array('file' => 'styles/minimized.css', 'class_line' => "logos\\*\\/[\s\S]*?#text_logo", 'elements' => array('top', 'left', 'right'));

	$settingOptions["Tagline"]["Styling"][0]		= array('file' => 'logo/css/logo.css', 'class_line' => "#logo_tagline, #logo_tagline a, #logo_tagline p, #logo_tagline a:link, #logo_tagline a:visited, #logo_tagline a:active, #logo_tagline a:hover", 'elements' => array('font-family', 'font-size', 'color'));
	$settingOptions["Tagline"]["Primary Layout Positioning"][0]		= array('file' => 'styles/primary.css', 'class_line' => "logos\\*\\/[\s\S]*?#logo_tagline", 'elements' => array('top', 'left', 'right'));
	$settingOptions["Tagline"]["Secondary Layout Positioning"][0]		= array('file' => 'styles/secondary.css', 'class_line' => "logos\\*\\/[\s\S]*?#logo_tagline", 'elements' => array('top', 'left', 'right'));
	$settingOptions["Tagline"]["Minimized Layout Positioning"][0]		= array('file' => 'styles/minimized.css', 'class_line' => "logos\\*\\/[\s\S]*?#logo_tagline", 'elements' => array('top', 'left', 'right'));

	$settingOptions["Top Menu"]["Main Button"][0]      		= array('file' => 'styles/fonts.css', 'class_line' => ".sf-menu-wrapper-top li a,[\s]*?.sf-menu-wrapper-top li a:link,[\s]*?.sf-menu-wrapper-top li a:visited,[\s]*?.sf-menu li a,[\s]*?.sf-menu li a:link,[\s]*?.sf-menu li a:visited,[\s]*?.sf-menu li a:active,[\s]*?.sf-menu li:hover,[\s]*?.sf-menu li.sfHover,[\s]*?.sf-menu li a:focus,[\s]*?.sf-menu li a:hover,[\s]*?.sf-menu li a:active", 'elements' => array('font-family', 'color'));
	$settingOptions["Top Menu"]["Main Button"][1]      		= array('file' => 'styles/fonts.css', 'class_line' => ".sf-menu-wrapper-top ul li a,[\s]*?.sf-menu-wrapper-top ul li a:link,[\s]*?.sf-menu-wrapper-top ul li a:visited,[\s]*?.sf-menu li a,[\s]*?.sf-menu li a:link,[\s]*?.sf-menu li a:visited, .sf-menu li a:active,.sf-menu li:hover,.sf-menu li.sfHover, .sf-menu li a:focus, .sf-menu li a:hover,[\s]*?.sf-menu li a:active", 'elements' => array('font-size'));
	$settingOptions["Top Menu"]["Main Button Hover"][0]		= array('file' => 'styles/fonts.css', 'class_line' => ".sf-menu li a:active,.sf-menu li:hover,.sf-menu li.sfHover, .sf-menu li a:focus, .sf-menu li a:hover, .sf-menu li a:active", 'elements' => array('font-family', 'color'));
	$settingOptions["Top Menu"]["Submenu Button"][0]		= array('file' => 'styles/fonts.css', 'class_line' => ".sf-menu li ul li a,.sf-menu li ul li a:link, .sf-menu li ul li a:visited, .sf-menu li ul li a:active,.sf-menu li ul li:hover,.sf-menu li ul li.sfHover, .sf-menu li ul li a:focus, .sf-menu li ul li a:hover, .sf-menu li ul li a:active", 'elements' => array('font-family', 'color'));
	$settingOptions["Top Menu"]["Submenu Button"][1]		= array('file' => 'styles/fonts.css', 'class_line' => "\SUBMENU  font type and size \\*\\/[\s]*?.sf-menu li ul li a,.sf-menu li ul li a:link, .sf-menu li ul li a:visited, .sf-menu li ul li a:active,.sf-menu li ul li:hover,.sf-menu li ul li.sfHover, .sf-menu li ul li a:focus, .sf-menu li ul li a:hover,[\s]*?.sf-menu li ul li a:active", 'elements' => array('font-size'));
	$settingOptions["Top Menu"]["Submenu Button Hover"][0]	= array('file' => 'styles/fonts.css', 'class_line' => ".sf-menu li ul li a:active,.sf-menu li ul li:hover,.sf-menu li ul li.sfHover, .sf-menu li ul li a:focus, .sf-menu li ul li a:hover, .sf-menu li ul li a:active", 'elements' => array('font-family', 'color'));

	$settingOptions["Side Menu"]["Main Button"][0]      	= array('file' => 'styles/fonts.css', 'class_line' => ".sf-menu-wrapper-side li a,[\s]*?.sf-menu-wrapper-side li a:link,[\s]*?.sf-menu-wrapper-side li a:visited,[\s]*?.sf-vertical li a,[\s]*?.sf-vertical li a:link,[\s]*?.sf-vertical li a:visited,[\s]*?.sf-vertical li a:active,[\s]*?.sf-vertical li:hover,[\s]*?.sf-vertical li.sfHover,[\s]*?.sf-vertical li a:focus,[\s]*?.sf-vertical li a:hover,[\s]*?.sf-vertical li a:active", 'elements' => array('font-family', 'color', 'font-size'));
	$settingOptions["Side Menu"]["Main Button Hover"][0]	= array('file' => 'styles/fonts.css', 'class_line' => ".sf-vertical li a:active,.sf-vertical li:hover,.sf-vertical li.sfHover, .sf-vertical li a:focus, .sf-vertical li a:hover, .sf-vertical li a:active", 'elements' => array('font-family', 'color', 'font-size'));
	$settingOptions["Side Menu"]["Submenu Button"][0]		= array('file' => 'styles/fonts.css', 'class_line' => ".sf-vertical li ul li a,.sf-vertical li ul li a:link, .sf-vertical li ul li a:visited, .sf-vertical li ul li a:active,.sf-vertical li ul li:hover,.sf-vertical li ul li.sfHover, .sf-vertical li ul li a:focus, .sf-vertical li ul li a:hover,[\s]*?.sf-vertical li ul li a:active", 'elements' => array('font-family', 'color', 'font-size'));
	$settingOptions["Side Menu"]["Submenu Button Hover"][0]	= array('file' => 'styles/fonts.css', 'class_line' => ".sf-vertical li ul li a:active,.sf-vertical li ul li:hover,.sf-vertical li ul li.sfHover, .sf-vertical li ul li a:focus, .sf-vertical li ul li a:hover, .sf-vertical li ul li a:active", 'elements' => array('font-family', 'color', 'font-size'));

	$settingOptions["Nivo Slider"]["Title"][0]      	= array('file' => 'styles/fonts.css', 'class_line' => ".nivo-caption h3", 'elements' => array('font-family', 'color', 'font-size'));
	$settingOptions["Nivo Slider"]["Description"][0]	= array('file' => 'styles/fonts.css', 'class_line' => ".nivo-caption p, .nivo-caption, .nivo-caption a", 'elements' => array('font-family', 'color', 'font-size'));
	$settingOptions["Nivo Slider"]["Button"][0]			= array('file' => 'styles/fonts.css', 'class_line' => ".slider_readmore a:link, .slider_readmore a:visited, .slider_readmore a:active", 'elements' => array('font-family', 'color', 'font-size'));
	$settingOptions["Nivo Slider"]["Button Hover"][0]	= array('file' => 'styles/fonts.css', 'class_line' => ".slider_readmore a:hover", 'elements' => array('font-family', 'color', 'font-size'));


	$settingOptions["Footer"]["General"][0] = array('file' => 'styles/fonts.css', 'class_line' => "#footer", 'elements' => array('font-family', 'color', 'font-size'));
	$settingOptions["Footer"]["Title"][0]   	= array('file' => 'styles/fonts.css', 'class_line' => "#footer h3", 'elements' => array('font-family', 'color', 'font-size'));
	$settingOptions["Footer"]["Description"][0] = array('file' => 'styles/fonts.css', 'class_line' => "#footer p", 'elements' => array('font-family', 'color', 'font-size'));
	$settingOptions["Footer"]["List Item"][0]   = array('file' => 'styles/fonts.css', 'class_line' => "#footer li", 'elements' => array('font-family', 'color', 'font-size'));
	$settingOptions["Footer"]["Link"][0]  		= array('file' => 'styles/fonts.css', 'class_line' => "#footer a,", 'elements' => array('font-family', 'color', 'font-size'));
	$settingOptions["Footer"]["Link Hover"][0]  		= array('file' => 'styles/fonts.css', 'class_line' => "#footer a:hover", 'elements' => array('font-family', 'color', 'font-size'));

	if($_POST['cmd'] == "save") {
		$saveSettings = array();
		
		

		foreach($_POST as $key => $value) {
			
			if (strstr($key, "theme_setting__")) {
			  $data = explode("__", $key);
			  $label = ucwords(str_replace("-", " ", $data[1]));
			  $type = ucwords(str_replace("-", " ", $data[2]));
			  $index = $data[3];
			  $elementKey = $data[4];
			  $classLine = $settingOptions["$label"]["$type"]["$index"]["class_line"];
			  $searchLine = $settingOptions["$label"]["$type"]["$index"]["search_line"];

			  $fileName = $settingOptions["$label"]["$type"]["$index"]['file'];
			  if ($fileData["{$fileName}"] == "") {
				$fileData["{$fileName}"] = file_get_contents(get_template_directory()."/Site/".$fileName);
			  }
			  if ($classLine != "") {
			    $pattern = '/('.str_replace('.', '\.', $classLine).'.*?\{[\s\S]*?'.$elementKey.':)(.*?);/si';
			    $replace = '${1}'.stripslashes($value).';';
			  } else {
				if ($elementKey == "start") {
					       //   colors: ["#999999","#111111"],

			      $pattern = '/('.str_replace('.', '\.', $searchLine).'[\s]*?\[)(.*?),/si';
				  $replace = '${1}"'.stripslashes($value).'",';

				} else {
			      $pattern = '/('.str_replace('.', '\.', $searchLine).'.*?,)(.*?)\]/si';
				  $replace = '${1}"'.stripslashes($value).'"]';
				}
				//print $pattern." -- ".$replace."<br>";
			  }
			  //print $replace."<br><br>";
			  $fileData["{$fileName}"] = preg_replace($pattern, $replace, $fileData["{$fileName}"], 1);	
			  //print $fileData["$fileName"];
			  //break;
			 // print $classLine."<br>";
			 
			  
			} else {
				//print $key;
			}
		  
		}
		foreach ($fileData as $fileName => $data) {
		  $fp = fopen(get_template_directory()."/Site/".$fileName, "w");
		  fwrite($fp, $data);
		  fclose($fp);
		}
		
		//if(count($saveSettings) > 0) {
			//update_option('i3d_general_settings', $saveSettings);
		//}
	}
	

	?>
	<div class="wrap">
		<?php 
		I3D_Framework::render_dashboardManager("small", "styling");

		I3D_Framework::i3d_screen_icon('styling'); ?>
		<h2>Theme Styling</h2>

		<?php
		
		if ($_POST['cmd'] == "save") echo '<div id="message" class="updated fade below-h2"><p><strong>Settings saved.</strong></p></div>';
		//if ($_GET['upgraded'])  echo '<div id="message" class="updated fade below-h2"><p><strong>'.$templateName.' has been actived.  Please update your settings as needed.</strong></p></div>';
		?>
		
		<form method="post">
    <div id="settings-tabs">
      <ul class='settings-tabs'>
      <?php foreach ($settingOptions as $label => $data) { ?>
        <li><a href="#tabs-<?php echo strtolower(str_replace(" ", "-", $label)); ?>"><?php echo $label; ?></a></li>
      <?php } ?>
      </ul>
      <?php foreach ($settingOptions as $label => $optionData) { ?>
      <div id="tabs-<?php echo strtolower(str_replace(" ", "-", $label)); ?>">
			<table class="form-table">
                <?php foreach ($optionData as $type => $typeDataArray) { ?>
                	<tr><td colspan="2"><h3><?php echo $type; ?></h3></td></tr>
					<?php foreach ($typeDataArray as $index => $typeData) {?>
				 <?php  foreach ($typeData['elements'] as $elementKey) { 
				   //$folderPath = str_replace(get_bloginfo('wpurl'), "", get_template_directory_uri() );
				   //print "..".$folderPath."/Site/".$typeData['file']."<br>";
				   $fileName = $typeData['file'];
				   if ($fileData["{$fileName}"] == "") {
				     $fileData["{$fileName}"] = file_get_contents(get_template_directory()."/Site/".$fileName);
				   }
				   if ($typeData['class_line'] != "") {
				     $elementDataPattern = '/'.str_replace('.', '\.', $typeData['class_line']).'.*?\{(.*?)\}/si';
				   } else {
					   //print $fileData["{$fileName}"];
				     $elementDataPattern = '/'.str_replace('.', '\.', $typeData['search_line']).'[\s]*?\[(.*?)\]/si';
				   }
				  // print $elementDataPattern."<br>";
				   $matches = array();
				   preg_match($elementDataPattern, $fileData["{$fileName}"], $matches);
				   if ($typeData['class_line'] != "") {
				     $elementDataPattern = '/'.$elementKey.':[\s]?(.*?);/';
				   } else {
					  // print sizeof($matches);
					   if ($elementKey == "start") {
						   $elementDataPattern = '/"(.*?)",/';
					   } else if ($elementKey == "end") {
						   $elementDataPattern = '/,"(.*?)"/';	   
					   }
					  //print $elementDataPattern;
				   }
				   $matches2 = array();
				   preg_match($elementDataPattern, $matches[1], $matches2);
				   //print "<br>".$elementDataPattern." in {$matches[1]} found ".sizeof($matches2)."<br>";
				   //print $fileData["$fileName"];
				  // print strlen($fileData["$fileName"]);
				   //preg_match($elementDataPattern, $fileData["{$fileName}"], $matches);
				  // print sizeof($matches);
                  //  print $fileData;
				  if ($matches2[0] != "") {
					  $thisIdentifier = strtolower(str_replace(" ", "-", $label))."__".strtolower(str_replace(" ", "-", $type))."__".$index."__".$elementKey;
					  ?>
				<tr><th><label for="<?php echo $thisIdentifier; ?>"><?php echo ucwords(str_replace("-", " ", $elementKey)); ?></label></th><td><input type="<?php if ($elementKey == "color") { print "color"; } else { print "text"; } ?>" id="<?php echo $thisIdentifier; ?>" name="theme_setting__<?php echo $thisIdentifier; ?>" value="<?php print htmlentities(trim($matches2[1])); ?>" class="regular-text" /></td></tr>
                      <?php }
				 }
				}
						} ?>
                                                  </table>
      </div>


                        <?php
	  }
	  ?>


	
    </div>
	</div> <!-- /wrap -->
	<?php
	} ?>
    		<input type="hidden" name="cmd" value="save" />
			<input type="submit" name="nocmd" value="Save" />		
		</form>
    <?php
}
?>