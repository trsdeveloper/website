<?php function i3d_render_logo($instance = array()) {
		$generalSettings = get_option('i3d_general_settings');
			global $i3dTextLogoLines;
			global $i3dFontAwesomeVersion;
			$fileName = "";
			$rawVectorIcon = "";
		$generalSettings = wp_parse_args( (array) $generalSettings, array( 'website_name' => '', 'tagline_setting' => ''  ) );
		$instance = wp_parse_args( (array) $instance, array( 'justification' => '', 'graphic_logo' => '', 'website_name' => '', 'tagline_setting' => ''  ) );

?>
<?php if ($instance['style'] == "footer" && (I3D_Framework::$logoVersion == 6 || I3D_Framework::$logoVersion == 7)) { 
  ob_start();
  
  } ?>
<div id='logo-wrapper'<?php 
if ($instance['justification'] == "right") { 
	print " class='pull-right text-right";
	if (I3D_Framework::$logoVersion == "6") { 
		print " logo"; 
	} else if (I3D_Framework::$logoVersion == "7") {
		print " logo-wrapper";	
	}
	print "'"; 
} else if ($instance['justification'] == "center") {
	print " class='text-center"; 

	if (I3D_Framework::$logoVersion == "6") { 
		print " logo"; 
	} else if (I3D_Framework::$logoVersion == "7") {
		print " logo-wrapper";	
	}
	print "'"; 
}  else {
	if (I3D_Framework::$logoVersion == "6") { 
  		print " class='logo'"; 
	} else if (I3D_Framework::$logoVersion == "7") {
		print " class='logo-wrapper'";	
	}
}

?>>
<?php

	

				if (@$instance['link'] == "default" || @$instance['link'] == "") {
					if (@$generalSettings['link'] == "default" || @$generalSettings['link'] == "") {
					  $link = home_url();	
					} else if (@$generalSettings['link'] == "disabled") {
						$link = "";
					} else if (@$generalSettings['link'] == "custom") {
					  $link = @$generalSettings['link_custom'];
					}
				} else if (@$instance['link'] == "disabled") {
					$link = "";
				} else if (@$instance['link'] == "custom") {
					$link = $instance['link_custom'];
				}

				if (!array_key_exists("custom_logo_status", $generalSettings)) {
					$generalSettings['custom_logo_status'] = 0;
				}

                $customLogoStatus = $generalSettings['custom_logo_status'] == 1;
				$lmCustomLogo['enabled'] = $customLogoStatus;
				
				// if the "graphic_logo" from the page level settings
				if ($instance['graphic_logo'] == "x" || $instance['graphic_logo'] == "disabled") {
						$customLogoStatus = false;
						$lmCustomLogo['enabled'] = false;
				}
					// if we are instructed to not use a graphic logo, then check for a vector icon
					if ($instance['graphic_logo'] == "x" ||  $instance['graphic_logo'] == "disabled" || ($instance['graphic_logo'] == "" && !$customLogoStatus)) {
						if (defined("THEME_ICON")) {
						  $vectorIcon = "<i class='".I3D_Framework::conditionFontAwesomeIcon(constant("THEME_ICON"))."'></i> ";	
							
						} else {
							
							$instance['vector_icon'] = I3D_Framework::conditionFontAwesomeIcon(@$instance['vector_icon']);
							if ($instance['vector_icon'] != "" && $instance['vector_icon'] != "default" && $instance['vector_icon'] != "global") {
							$vectorIcon =  I3D_Framework::conditionFontAwesomeIcon($instance['vector_icon']);
								if (I3D_Framework::$logoVersion == "6") {
									$vectorIcon .= " fa-fw fa-3x";
								}
							  $vectorIcon = "<i class='fa {$vectorIcon}'></i> ";	
							} else if ($instance['vector_icon'] == "default" || $instance['vector_icon'] == "global" || $instance['vector_icon'] != "x") {
							  $vectorIcon =  I3D_Framework::conditionFontAwesomeIcon($generalSettings['vector_logo_icon']);
							  if ($vectorIcon != "") {
								if (!strstr($vectorIcon, "icon-") && I3D_Framework::$fontAwesomeVersion == "3") {
								  $vectorIcon = "icon-".$vectorIcon;	
								} else if (strstr($vectorIcon, "fa-") && I3D_Framework::$fontAwesomeVersion == "4" && !strstr($vectorIcon, "fa fa-")) {
								  $vectorIcon = "fa ".$vectorIcon;	
								} else if (!strstr($vectorIcon, "fa fa-") && I3D_Framework::$fontAwesomeVersion == "4") {
								  $vectorIcon = "fa fa-".$vectorIcon;	
								}
								$rawVectorIcon = $vectorIcon;
								if (I3D_Framework::$logoVersion == "6") {
									$vectorIcon .= " fa-fw fa-3x";
								}
								
							    $vectorIcon = "<i class='{$vectorIcon}'></i> ";	
							  
							  }
							}
						}
						$lmCustomLogo['enabled'] = false;
					} else if (($instance['graphic_logo'] == "" || $instance['graphic_logo'] == "default") && $lmCustomLogo['enabled']) {
                        $metaData = get_post_meta($generalSettings['custom_logo_filename'], '_wp_attachment_metadata', true);
                        $fileName = I3D_Framework::get_image_upload_path(@$metaData['file']); 
						
					} else if ($instance['graphic_logo'] != "x") {
					
                        $metaData = get_post_meta(@$instance['graphic_logo'], '_wp_attachment_metadata', true);
                        $fileName = I3D_Framework::get_image_upload_path(@$metaData['file']); 
						
					} else {
					
					}
					
						
					if ($instance['website_name'] == "default" && $generalSettings['website_name'] == "custom") {
					  $instance['text_1'] = str_replace("  ", "&nbsp; ", $generalSettings['text_1']);
					  $instance['text_2'] = str_replace("  ", "&nbsp; ", $generalSettings['text_2']);
					}
					
					if ($instance['website_name'] == "default" && $generalSettings['website_name'] != "custom") {
						  $websiteName = str_replace("  ", "&nbsp; ", get_bloginfo('name'));
						  if (I3D_Framework::$logoVersion == "4") { 
						    $websiteName = "<span class='website-text1'>{$websiteName}</span>";
						  } 
						  
					} else if ($instance['website_name'] == "" || $instance['website_name'] == "disabled") {
						$websiteName = ""; 
						
					} else {
						
						if (defined("PRODUCT_NAME")) {
						  $websiteName = constant("PRODUCT_NAME");
						  if (I3D_Framework::$logoVersion == "4") { 
						    $websiteName = "<span class='website-text1'>{$websiteName}</span>";
							$websiteName .= " <span class='website-text2'>".constant("PRODUCT_STYLE")."</span>";
						  } else { 
							$websiteName .= " <span>".constant("PRODUCT_STYLE")."</span>";
						  }
						} else {
						  $websiteName = str_replace("  ", "&nbsp; ", @$instance['text_1'])."";
						  if (I3D_Framework::$logoVersion == "4") { 
						    $websiteName = "<span class='website-text1'>{$websiteName}</span>";
						  } else if (I3D_Framework::$logoVersion == "6") { 
						  	$websiteName = "<span class='brand1'>{$websiteName}</span>";
						  }
						  
						  if ($i3dTextLogoLines == 2 && $instance['text_2'] != "") {
							if (I3D_Framework::$logoVersion == "4") { 
							  $websiteName .= " <span class='website-text2'>{$instance['text_2']}</span>";
							} else if (I3D_Framework::$logoVersion == "6") { 
							  $websiteName .= " <span class='brand2 xbold'>{$instance['text_2']}</span>";

							} else { 

							  $websiteName .= " <span>{$instance['text_2']}</span>";
							}
						  }
						}
					}
					if ($instance['tagline_setting'] == "default" && $generalSettings['tagline_setting'] == "custom") {
					  $instance['tagline'] = $generalSettings['tagline'];
					}

					if ($instance['tagline_setting'] == "default" && $generalSettings['tagline_setting'] == "disabled") {
					  $tagline = "";
					} else 	if ($instance['tagline_setting'] == "default"  && $generalSettings['tagline_setting'] != "custom") {
						$tagline = get_bloginfo('description');
					} else if ($instance['tagline_setting'] == "" || $instance['tagline_setting'] == "disabled") {
						$tagline = ""; 
					} else {
						$tagline = $instance['tagline'];
					}
					?>
<div id='website-name-tagline-wrapper' class='<?php if (I3D_Framework::$logoVersion == "8") { ?>website-name-wrapper <?php } ?><?php if ($tagline != "") { ?>has-tagline<?php } else { ?>no-tagline<?php } ?><?php if ($lmCustomLogo['enabled']) { ?> has-graphic-logo<?php } ?>'><?php 
if($lmCustomLogo['enabled'] || (I3D_Framework::$logoVersion == "6" && @$vectorIcon != "") ) { 
?><div id="graphic-logo"<?php if (I3D_Framework::$logoVersion == "6" ) { echo " class='graphic-logo'"; } ?>><?php if (I3D_Framework::$logoVersion == "6" && @$vectorIcon != "") { echo $vectorIcon; } else { ?><?php if ($link != "") { ?><a href="<?php echo $link; ?>"><?php } ?><img src="<?php echo $fileName; ?>" alt='<?php echo get_bloginfo('name'); ?>' title='<?php echo get_bloginfo('name'); ?>' /><?php if ($link != "") { ?></a><?php } } ?></div><?php 
}	
if (!$lmCustomLogo['enabled'] || @$generalSettings['disable_website_name_text_logo'] == "") {
	if ($websiteName != "") { 
		$websiteName = str_replace("  ", "&nbsp; ", str_replace("&nbsp;", " ", $websiteName));
		?><div <?php
        if (I3D_Framework::$logoVersion == "2" || I3D_Framework::$logoVersion == "3" || I3D_Framework::$logoVersion == "4" || I3D_Framework::$logoVersion == "5" || I3D_Framework::$logoVersion == "6" || I3D_Framework::$logoVersion == "7" || I3D_Framework::$logoVersion == "8") { 
			?>class="website-name"<?php } else { ?>id="website-name"<?php } ?>><?php 

								if (I3D_Framework::$logoVersion == "5" || I3D_Framework::$logoVersion == "6" || I3D_Framework::$logoVersion == "8") {
									?><h1><?php if ($link != "") { ?><a href="<?php echo $link; ?>"><?php } ?><?php if (I3D_Framework::$logoVersion != "6") {  echo @$vectorIcon; } ?><?php echo @$websiteName; ?><?php if ($link != "") { ?></a><?php } ?></h1>
								<?php } else if (I3D_Framework::$logoVersion == "4") {
									?><div class="website-name-hover"><?php if ($link != "") { ?><a href="<?php echo $link; ?>"><?php } ?><?php echo @$vectorIcon; ?><?php echo @$websiteName; ?><?php if ($link != "") { ?></a><?php } ?></div><?php
									} else if (I3D_Framework::$logoVersion != "3") { ?><h3 <?php
                                if (I3D_Framework::$logoVersion == "2") { 
								?>class="animated bounceInDown"<?php } else { ?><?php } ?>><?php if ($link != "") { ?><a href="<?php echo $link; ?>"><?php } ?>
								<?php } ?>
								<?php if (I3D_Framework::$logoVersion != "4" && I3D_Framework::$logoVersion != "5" && I3D_Framework::$logoVersion != "6" && I3D_Framework::$logoVersion != "8") { ?><?php echo @$vectorIcon; ?><?php echo @$websiteName; ?><?php if (I3D_Framework::$logoVersion != "3") { ?><?php if ($link != "") { ?></a><?php } 
								?></h3><?php } ?>
								<?php } ?>
								<?php if (I3D_Framework::$logoVersion != "6") { ?></div><?php }
								 }
				}
				  if ($tagline != "") { 
				  if (I3D_Framework::$logoVersion == "6") { 
				  ?><h6 class='lighter'><?php echo $tagline; ?></h6><?php 
				  } else { ?><div <?php
                                if (I3D_Framework::$logoVersion == "2" || I3D_Framework::$logoVersion == "3" || I3D_Framework::$logoVersion == "4" || I3D_Framework::$logoVersion == "5"  || I3D_Framework::$logoVersion == "7" ) { 
								?>class="tagline"<?php } else { ?>id="tagline"<?php } ?>><?php if (I3D_Framework::$logoVersion < 3) { ?><h4 <?php if (@$vectorIcon != "") { print "class='padleft-tagline'"; } ?>><?php } ?><?php echo @$tagline; ?><?php if (I3D_Framework::$logoVersion < 3) { ?></h4><?php } ?></div><?php 
								} 
								} 
			if (I3D_Framework::$logoVersion == "6") { ?></div><?php } 
			?></div></div><?php
			if ($instance['style'] == "footer" && (I3D_Framework::$logoVersion == 6 || I3D_FRamework::$logoVersion == 7)) {
				if (I3D_Framework::$logoVersion == 6) {
					$websiteNameTag = "h3";
					$taglineTag = "h6";
				} else if (I3D_Framework::$logoVersion == 7) {
					$websiteNameTag = "h2";
					$taglineTag = "h4";
		   
				}
	ob_get_clean();  
	if ( $instance['graphic_logo'] != "" && $instance['graphic_logo'] != "disabled") { 
					
                        $metaData = get_post_meta(@$instance['graphic_logo'], '_wp_attachment_metadata', true);
                        $fileName = I3D_Framework::get_image_upload_path(@$metaData['file']); 
?><img class='footer-graphic-logo' src="<?php echo $fileName;?>" alt='footer-logo' /><?php
	} else {
	  ?><i data-wow-delay="1s" class="wow fadeInDown <?php echo $rawVectorIcon; ?> fa-fw fa-5x"></i><?php } ?>
<<?php echo $taglineTag; ?> data-wow-delay=".5s" class="wow zoomIn lighter"><?php echo $tagline; ?></<?php echo $taglineTag; ?>>
<<?php echo $websiteNameTag; ?> data-wow-delay="1s" class="wow fadeInUp"><?php if ($link != "") { ?><a href="<?php echo $link; ?>"><?php } ?><?php echo $websiteName; ?><?php if ($link != "") { ?></a><?php } ?></<?php echo $websiteNameTag; ?>>
<?php } ?>             
<?php } ?>