<?php

/***********************************/
/**        Featured Post  BOX        **/
/***********************************/
class I3D_Widget_InfoBox extends WP_Widget {
	function __construct() {
	//function I3D_Widget_InfoBox() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Displays a box with an image and page title/description.', "i3d-framework") );
		$control_ops = array('width' => "400px");
		parent::__construct('i3d_infobox', __('i3d:Info Box', "i3d-framework"), $widget_ops, $control_ops);
	}

	public static function footer_animation_hook() {
		?>
     <script>
	 jQuery(document).ready(function() {
			new cbpScroller( document.getElementById( 'content-scroller' ) );
									 });
		</script>
        <?php   
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		global $info_box_count;
		global $total_ibcw;
		$total_ibcw++;
		$instance = wp_parse_args( (array) $instance, array( 'thumbnail_background_color' => '',
															 'thumbnail_hover_transition_time' => '',
															 'thumbnail_hover_color_alpha' => '',
															 'title_text' => '',
															 'thumbnail_background_padding' => '',
															 'thumbnail_border_radius' => '',
															 'mask' => '', 
															 'title_text_2' =>'', 'title_tag' => '', 
															 'thumbnail_mask' => '', 
															 'thumbnail_icon_effect' => '',
															 'thumbnail_hover_color' => '',
															 'thumbnail_hover_icon' => '', 'image_position' => '', 'description_text' => '', 'more_link_text' => '', 'title_text_linkable' => '', 'linkable' => '', 'linktype' => '',  'layout' => '', 'vector_icon' => '', 'justification' => '', 'api_key' => '', 'target' => '', 'flickr_id' => '', 'thumnbail_mask' => '' ) );

		global $lmImageDefaults, $lmWidgetWrapConfig;
		
		
		$layout = $instance['layout'];	
		
						if (@$lmImageDefaults["placeholder-{$layout}"]['width'] == "") {
						  $lmImageDefaults["placeholder-{$layout}"]['width'] = 240;
						  $lmImageDefaults["placeholder-{$layout}"]['height'] = 180;
						}
		
		
		$pageID = $instance['page'];
		$title = get_post_meta($pageID, 'luckymarble_page_title', true);
		$title_text = $instance['title_text'];
		$rand = rand();
		$vectorIcon = "";
		if ($instance['vector_icon'] != "" ) {
			if (!in_array("vector_icon_separate", $lmWidgetWrapConfig["info-box"]["{$layout}"]["options"])) {
 		 $vectorIcon = "<i class='";
			  if (strstr($instance['vector_icon'], "fa-")) {
				  $vectorIcon .= "fa ";
			  }
			  $vectorIcon .= $instance['vector_icon'];
			  $vectorIcon .= "'></i> ";		
			} else {
			  $vectorIcon = 	$instance['vector_icon'];
			}
		}
		//var_dump($lmWidgetWrapConfig['info-box']["{$layout}"]['options']);
		if (!in_array("vector_icon_separate", $lmWidgetWrapConfig["info-box"]["{$layout}"]["options"])) {
			$title_text = $vectorIcon . $title_text;
		}
		$title_text_2 = $instance['title_text_2'];
		$layout = $instance['layout'];
		if ($layout == "") {
			$layout = "thumbnail";
		}
		$title_tag = $instance['title_tag'];
		$image_position = $instance['image_position'];
		if ($title_tag == "") {
			$title_tag = "h2";
			
		}
		$description_text = $instance['description_text'];
		$more_link_text = strip_tags($instance['more_link_text']);
		$title_text_linkable = ($instance['title_text_linkable'] == 1 && $instance['linktype'] != "" && in_array("title_text_linkable", $lmWidgetWrapConfig['info-box']["{$layout}"]['options']));
		$hr = $instance['hr'] == 1;
		$bold_lead_paragraph = $instance['bold_lead_paragraph'] == 1;
		
		$selected_image = strip_tags($instance['page_image']);
		if (!array_key_exists("info-box", $lmWidgetWrapConfig)) {
			$lmWidgetWrapConfig['info-box']["{$layout}"]['widget_html']  = '<a href="[imghref]">[img]</a><h3><a class="title-link" href="[titlehref]">[title]</a></h3><p>[description]</p>';
		}
		$widgetHTML = $lmWidgetWrapConfig['info-box']["{$layout}"]['widget_html'];
		$buttonHTML = $lmWidgetWrapConfig['info-box']["{$layout}"]['button_html'];
		
		// support for KinderCare
		$boxCount = (@$instance['position'] % 4) + 1;
		$widgetHTML = str_replace("[count]", $boxCount, $widgetHTML);
		
		$imageClasses =  $lmWidgetWrapConfig['info-box']["{$layout}"]['img_classes'];
		if ($layout == "animated-image-box" && I3D_Framework::$infoBoxVersion == 2) {
		  	add_action('wp_footer', array('I3D_Widget_InfoBox', 'footer_animation_hook'), 101);
			wp_enqueue_script( 'i3d-modernizr-js');
			// the default position is right, so in this scenario, we need to flip the section and the feature code
			if ($image_position == "left") {
				$widgetHTMLData = explode("<!--split-->", $widgetHTML);
				$widgetHTML = $widgetHTMLData[0].$widgetHTMLData[2].$widgetHTMLData[1].$widgetHTMLData[3];
			}

		}
		
		if (in_array("image_mask", $lmWidgetWrapConfig['info-box']["{$layout}"]['options'])) { 
		$includeMaskHTML = true;	
		} else {
			$includeMaskHTML = false;
		}
		echo $before_widget;
		//$pageData = get_page($pageID);
		// if ( get_post_meta($pageID, '_thumbnail_id', true) || strstr($title, "Feature Item")) { 
		      if ($selected_image == "") {
				  
			    $large_image_url = wp_get_attachment_image_src( get_post_meta($pageID, '_thumbnail_id', true), 'full');
				if ($large_image_url == "" && strstr($title, "Feature Item")) {
					$large_image_url[0] = get_option("siteurl")."/wp-content/themes/".get_template()."/Site/themed_images/portfolio-large-".str_replace("Feature Item ", "", $title).".jpg";
					if (defined('THEME')) {
						$large_image_url[0] = str_replace("_business~", "_".THEME."~", $large_image_url[0]);
					}
				    
				} else if ($large_image_url == "" &&  strstr($title_text,"Example Title")) {
					
					$large_image_url[0] = get_option("siteurl")."/wp-content/themes/".get_template()."/Site/themed_images/portfolio-large-1.jpg";					
				}
				if ($large_image_url != "") {
				 

				 // $image = get_option("siteurl")."/wp-content/themes/".get_template()."/includes/user_view/thumb.php?src=".urlencode(str_replace("-".$large_image_url[1]."x".$large_image_url[2], "", $large_image_url[0]))."&amp;w=".$lmImageDefaults["featured-page-thumbnail"]['width']."&amp;h=".$lmImageDefaults["featured-page-thumbnail"]['height']."&amp;zc=1&amp;q=90&amp;v=1";
				  if (I3D_Framework::$useTimThumb) {
					   $large_image_url[0] = str_replace("/", "|", $large_image_url[0]);
				 	 $image = get_option("siteurl")."/wp-content/themes/".get_template()."/includes/user_view/thumb.php?src=".urlencode($large_image_url[0])."&amp;w=".$lmImageDefaults["featured-page-thumbnail"]['width']."&amp;h=".$lmImageDefaults["featured-page-thumbnail"]['height']."&amp;zc=1&amp;q=90&amp;v=1";
				  } else {
					  
				 	 $image = $large_image_url[0];
				  }
				}
			 } else {
				 
				if (intval($selected_image) > 0) {
						$large_image_url = wp_get_attachment_image_src( $selected_image, 'full');
						$image = $large_image_url[0];
				} else if ($selected_image == "none") {
					$selected_image = "";
					
				} else {
								 
				  //if (I3D_Framework::$useTimThumb) {
					if ($layout == "feature-box") {
						$info_box_count++;
					$image = get_option("siteurl")."/wp-content/themes/".get_template()."/Library/components/feature-boxes/images/fb-{$info_box_count}.jpg";
					} else if ($layout == "ibc") {
						$info_box_count++;
						if ($info_box_count > 4) {
							$info_box_count = $info_box_count - 4;
						}
					$image = get_option("siteurl")."/wp-content/themes/".get_template()."/Library/components/info-box-carousel/images/ibc-image{$info_box_count}.jpg";
						

					} else {
					$image = get_option("siteurl")."/wp-content/themes/".get_template()."/Site/themed-images/placeholders/".$lmImageDefaults["placeholder-{$layout}"]['width']."x".$lmImageDefaults["placeholder-{$layout}"]['height']."/".$selected_image."-".$lmImageDefaults["placeholder-{$layout}"]['width']."x".$lmImageDefaults["placeholder-{$layout}"]['height'].".jpg";
					}
				  //} else {
									 //	 $image = $large_image_url[0];
  
				 // }
					}
			   }
			  
			$widgetHTML = str_replace("[count]", $total_ibcw, $widgetHTML);
					if (defined('THEME')) {
						$image = str_replace("_business~", "_".THEME."~", $image);
						//print "yah";
					}	
					if ($includeMaskHTML) {
						$widgetHTML = str_replace('<a href="[imghref]" class="thumbnail">[img]</a>', "<div class='i3d-widget-image-outer-wrapper'>[img]</div>", $widgetHTML);
					}
	
		if ($includeMaskHTML) {
		  ob_start();
		  ?>
             <style>
#image-wrapper-<?php echo $rand; ?> div.outer { 
	background-color: <?php echo $instance['thumbnail_background_color']; ?>;
	padding: <?php echo $instance['thumbnail_background_padding']; ?> !important; 

	border-radius: <?php echo $instance['thumbnail_border_radius']; ?>;
	-moz-border-radius: <?php echo $instance['thumbnail_border_radius']; ?>;
	-webkit-border-radius: <?php echo $instance['thumbnail_border_radius']; ?>;
<?php if ($instance['thumbnail_mask'] == "") { ?>	border: 0px solid transparent; <?php } ?>

}

#image-wrapper-<?php echo $rand; ?> img { 
	border-radius: <?php echo $instance['thumbnail_border_radius']; ?>;
	-moz-border-radius: <?php echo $instance['thumbnail_border_radius']; ?>;
	-webkit-border-radius: <?php echo $instance['thumbnail_border_radius']; ?>;
	<?php if ($instance['thumbnail_mask'] == "" && false) { ?> border: 1px solid <?php echo $instance['thumbnail_border_color']; ?>;<?php } ?>
}

#image-wrapper-<?php echo $rand; ?> i {

	-moz-transition: all <?php echo $instance['thumbnail_hover_transition_time']; ?>s ease-in-out !important;
	-webkit-transition: all <?php echo $instance['thumbnail_hover_transition_time']; ?>s ease-in-out !important;
	-o-transition: all <?php echo $instance['thumbnail_hover_transition_time']; ?>s ease-in-out !important;
	-ms-transition: all <?php echo $instance['thumbnail_hover_transition_time']; ?>s ease-in-out !important;
	transition: all <?php echo $instance['thumbnail_hover_transition_time']; ?>s ease-in-out !important;
}

#image-wrapper-<?php echo $rand; ?>  a:hover i {
	<?php if ($instance['thumbnail_icon_effect'] == "") { ?>
	-moz-transform: rotate(0deg) !important;
-webkit-transform:  rotate(0deg) !important;
-o-transform:  rotate(0deg) !important;
-ms-transform:  rotate(0deg) !important;
transform:  rotate(0deg) !important;
	<?php } else if ($instance['thumbnail_icon_effect'] == "spin") { ?>
-moz-transform: rotate(1440deg);
-webkit-transform: rotate(1440deg);
-o-transform: rotate(1440deg);
-ms-transform: rotate(1440deg);
transform: rotate(1440deg);
  <?php } ?>
}

#image-wrapper-<?php echo $rand; ?> a {
	padding: 0px;
	border-radius: <?php echo $instance['thumbnail_border_radius']; ?>;
	-moz-border-radius: <?php echo $instance['thumbnail_border_radius']; ?>;
	-webkit-border-radius: <?php echo $instance['thumbnail_border_radius']; ?>;
	background-image: none;
	background-color: rgba(<?php echo I3D_Framework::hex2RGB($instance['thumbnail_hover_color'], true) ?>);
	background-color: rgba(<?php echo I3D_Framework::hex2RGB($instance['thumbnail_hover_color'], true) ?>, <?php echo $instance['thumbnail_hover_color_alpha']; ?>);
	
	-moz-transition: all <?php echo $instance['thumbnail_hover_transition_time']; ?>s ease-in-out !important;
	-webkit-transition: all <?php echo $instance['thumbnail_hover_transition_time']; ?>s ease-in-out !important;
	-o-transition: all <?php echo $instance['thumbnail_hover_transition_time']; ?>s ease-in-out !important;
	-ms-transition: all <?php echo $instance['thumbnail_hover_transition_time']; ?>s ease-in-out !important;
	transition: all <?php echo $instance['thumbnail_hover_transition_time']; ?>s ease-in-ou !importantt;
}

</style>         
<?php
$widgetHTML .= ob_get_clean();
		}
								
			 $img = "";
		$maskData = "";
		$maskURL = "";
		$mask = "";
		$maskType = "";
		if ($includeMaskHTML) {
			$mask = $instance['thumbnail_mask'];
			if ($instance['thumbnail_mask'] != "") {
				
			$maskData = "data-mask='".get_stylesheet_directory_uri()."/Site/graphics/masks/{$mask}.png'";
			  $imageClasses = " special-mask";
			  $maskType = $instance['thumbnail_mask_aspect'];
			} else {
				
				$widgetHTML = str_replace("i3d-widget-image-outer-wrapper", "i3d-widget-image-outer-wrapper-thumbnail", $widgetHTML);
			}
		} 
	    if ($instance['thumbnail_mask'] != "") {
			wp_enqueue_script( 'aquila-mask-js',    get_stylesheet_directory_uri()."/Site/javascript/mask.js", array('jquery'), '1.0', true );

}			
			 
			 // put masking information here
			  if ($image != "") {
				$img = '<img '.$maskData.' class="'.$imageClasses.'"';
				if ($instance['thumbnail_mask'] == '') { 
				  $img .= ' width="'.$lmImageDefaults["featured-page-{$layout}"]['width'].'" height="'.$lmImageDefaults["featured-page-{$layout}"]['height'].'"';
				} 
				$img .= ' alt="" src="'.$image.'">';
			    
			  }
			  if ($includeMaskHTML) {
				$img = "<div id='image-wrapper-{$rand}' class='".($mask != "" ? " special-mask-container" : "")." i3d-widget-image-wrapper {$maskType}'><div class='outer'><div class='inner'>".$img.'<a href="[imghref]" class="thumbnail">'."<i class='fa {$instance['thumbnail_hover_icon']}'></i></a></div></div></div>";
			  }
			 $widgetHTML = str_replace("[img]", $img, $widgetHTML);
		
		if ($instance['linktarget'] != "") {
		    $widgetHTML = str_replace('<a href="[imghref]" class="thumbnail">', '<a href="[imghref]" class="thumbnail"  target="'.$instance['linktarget'].'">', $widgetHTML);
		} 		   
		if ($instance['linktype'] == "") {
				  $widgetHTML = str_replace("[imghref]", "", $widgetHTML);
					
				} else if ($instance['linktype'] == "internal") {
				  $widgetHTML = str_replace("[imghref]", get_page_link($pageID), $widgetHTML);
					
				} else if ($instance['linktype'] == "external") {
				  $widgetHTML = str_replace("[imghref]", $instance['external_url'], $widgetHTML);
					
				}	
	    //print $image_position;
		$widgetHTML = str_replace("[image_position]", $image_position, $widgetHTML);
		$widgetHTML = str_replace("[hover_icon]", "hi-icon-".@$instance['hover_icon'], $widgetHTML);
		$widgetHTML = str_replace("[content_position]", ($image_position == "left" ? "right" : "left"), $widgetHTML);
		

		
		if (!empty($title_text)) { 
		  if ($title_text_linkable) { 
		    //$widgetHTML = str_replace("[title]", "<a class='title-link' href='[titlehref]'>[title]</a>", $widgetHTML);
		    $newTitleText = "<a class='title-link' href='[titlehref]'>[title]</a>";
		  
		    if ($instance['linktarget'] != "") {
		      $newTitleText = str_replace("<a ", "<a target='{$instance['linktarget']}' ", $newTitleText);
		    } 
		    $widgetHTML = str_replace("[title]", $newTitleText, $widgetHTML);
		  
		  
		  }
		  $widgetHTML = str_replace("[title]", $title_text, $widgetHTML);
  		  $widgetHTML = str_replace("[title_tag]", $title_tag, $widgetHTML);
		  
		} else if ( !empty( $title ) ) { 
		  if ($title_text_linkable) { 
		    $newTitleText = "<a class='title-link' href='[titlehref]'>[title]</a>";
		  
		    if ($instance['linktarget'] != "") {
		      $newTitleText = str_replace("<a ", "<a target='{$instance['linktarget']}' ", $newTitleText);
		    } 
		    $widgetHTML = str_replace("[title]", $newTitleText, $widgetHTML);
		  }		
		  $widgetHTML = str_replace("[title]", $title, $widgetHTML);
  		  $widgetHTML = str_replace("[title_tag]", $title_tag, $widgetHTML);

		 } else {
		 
  		  $widgetHTML = str_replace("<[title_tag]>", "", $widgetHTML);
  		  $widgetHTML = str_replace("</[title_tag]>", "", $widgetHTML);
  		  $widgetHTML = str_replace("[title]", "", $widgetHTML);
		 }
		 $widgetHTML = str_replace("[title2]", $title_text_2, $widgetHTML);
		 $widgetHTML = str_replace("[vector_icon]", $vectorIcon, $widgetHTML);
		 if ($instance['linktype'] == "internal") {
				  $widgetHTML = str_replace("[titlehref]", get_page_link($pageID), $widgetHTML);
					
				} else if ($instance['linktype'] == "external") {
				  $widgetHTML = str_replace("[titlehref]", $instance['external_url'], $widgetHTML);
					
				}
		 
		// $widgetHTML = str_replace("[titlehref]",get_page_link($pageID), $widgetHTML);
       
			 
			if (!empty($description_text)) {
				$description = $description_text;
			} else {
				$description = get_post_meta($pageID, 'luckymarble_page_description', true)."&nbsp;";

			
			}
			
		

							$more_link_text = $instance['more_link_text'];
		//if ($more_link_text != "") {
		//	$description .= '<a class="more-link" href="'.get_page_link($pageID).'" title="'.$title.'">'.$more_link_text.'</a>';
		//}
		if ($buttonHTML != "") {
			if ($more_link_text != "" && $instance['linktype'] != "") {
				$buttonHTML = str_replace("[button link text]", $more_link_text, $buttonHTML);
				$linkID = "";
				if ($instance['linktype'] == "") {
				  $buttonHTML = str_replace("[linkhref]", "", $buttonHTML);
					
				} else if ($instance['linktype'] == "internal") {
				  $buttonHTML = str_replace("[linkhref]", get_page_link($pageID), $buttonHTML);
					
				} else if ($instance['linktype'] == "external") {
				  $buttonHTML = str_replace("[linkhref]", $instance['external_url'], $buttonHTML);
					
				}
			} else {
				$buttonHTML = "";
			}
		}
		
		if ($instance['linktarget'] != "") {
		  $buttonHTML = str_replace("<a ", "<a target='{$instance['linktarget']}' ", $buttonHTML);
		  $widgetHTML = str_replace("<a ", "<a target='{$instance['linktarget']}' ", $widgetHTML);
		}
		$widgetHTML = str_replace("[btn]", $buttonHTML, $widgetHTML);
		if ($hr) {
		  $widgetHTML = str_replace("[hr]", "<hr/>", $widgetHTML);
		} else {
		  $widgetHTML = str_replace("[hr]", "", $widgetHTML);
		
		}
		
		if ($bold_lead_paragraph) {
			$description = "<strong>".preg_replace("/\n/", "</strong>\n", $description, 1, $count);
			$description = str_replace("\r", "", $description);
			if ($count == 0) {
				$description .= "</strong>";
			}
		}
		$description = nl2br($description);
		$widgetHTML = str_replace("[description]", $description, $widgetHTML);
		

		echo $widgetHTML;
		
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['page'] = $new_instance['page'];
		$instance['vector_icon'] = $new_instance['vector_icon'];
		$instance['title_text'] = $new_instance['title_text'];
		$instance['title_text_2'] = $new_instance['title_text_2'];
		$instance['title_text_linkable'] = $new_instance['title_text_linkable'];
		$instance['description_text'] = $new_instance['description_text'];
		$instance['more_link_text'] = $new_instance['more_link_text'];
		if ($new_instance['page_image'] == "media-library") {
		  $instance['page_image'] = $new_instance['selected_media_image'];
			
		} else {
		  $instance['page_image'] = $new_instance['page_image'];
		}
		$instance['linktype'] = $new_instance['linktype'];
		$instance['layout'] = $new_instance['layout'];
		$instance['linktarget'] = $new_instance['linktarget'];
		$instance['external_url']= strip_tags($new_instance['external_url']);
		$instance['title_tag']= strip_tags($new_instance['title_tag']);
		$instance['image_position']= strip_tags($new_instance['image_position']);
		$instance['bold_lead_paragraph']= $new_instance['bold_lead_paragraph'];
		$instance['hover_icon']= $new_instance['hover_icon'];
		$instance['hr']= $new_instance['hr'];
		$instance['thumbnail_mask'] 	= $new_instance['thumbnail_mask']; 
		$instance['thumbnail_mask_aspect'] 	= $new_instance['thumbnail_mask_aspect']; 
		$instance['thumbnail_background_color'] 	= $new_instance['thumbnail_background_color']; 
		$instance['thumbnail_background_padding'] 	= $new_instance['thumbnail_background_padding']; 
		$instance['thumbnail_border_radius'] 	= $new_instance['thumbnail_border_radius']; 
		$instance['thumbnail_border_color'] 	= $new_instance['thumbnail_border_color']; 
		$instance['thumbnail_hover_color'] 	= $new_instance['thumbnail_hover_color']; 
		$instance['thumbnail_hover_color_alpha'] 	= $new_instance['thumbnail_hover_color_alpha']; 
		$instance['thumbnail_hover_icon'] 	= $new_instance['thumbnail_hover_icon']; 
		$instance['thumbnail_icon_effect'] 	= $new_instance['thumbnail_icon_effect']; 
		
		$instance['thumbnail_hover_transition_time'] 	= $new_instance['thumbnail_hover_transition_time']; 
		return $instance;
	}

	function form( $instance ) {
		global $lmWidgetWrapConfig;
		$instance = wp_parse_args( (array) $instance, array('page' => '', 
															'page_image' => '', 
															'title_text' => '', 
															'title_text_2' => '', 
															'title_text_linkable' => '', 
															'description_text' => '', 
															'more_link_text' => '', 
															'linktype' => '', 
															'image_position' => '',
															'bold_lead_paragraph' => '',
															'linktarget' => '',
															'external_url' => '',
															'title_tag' => '',
															'layout' => '',
															'hr' => '') );
		$pageID = strip_tags($instance['page']);
		$title_text = $instance['title_text'];
		$title_text_2 = $instance['title_text_2'];
		$title_text_linkable = $instance['title_text_linkable'];
		$description_text = $instance['description_text'];
		$more_link_text = strip_tags($instance['more_link_text']);
		$linktype = strip_tags($instance['linktype']);
		$image_position = strip_tags(@$instance['image_position']);
		$selected_image = strip_tags($instance['page_image']);
		$layout = $instance['layout'];
		$hr = $instance['hr'];
		$bold_lead_paragraph = $instance['bold_lead_paragraph'];	
		$linktarget = $instance['linktarget'];
		$external_url = $instance['external_url'];
		$title_tag = $instance['title_tag'];
		$random = rand();
		$rand = $random;
		global $lmImageDefaults; 
		
				$borderRadii   	= array("1px", "2px", "3px", "4px", "5px", "10px", "15px", "1%", "2%", "3%", "4%", "5%", "10%", "15%");
		$padding	 	= array("1px", "2px", "3px", "4px", "5px", "10px", "15px", "1%", "2%", "3%", "4%", "5%", "10%", "15%");

?>

    <style>
div.featured-page-widget-container h2 { margin-top: 0px !important; padding-top: 0px !important; }
div.featured-page-widget-container th { padding: 4px 15px !important;  width: 100px; }
div.featured-page-widget-container td { padding: 3px 4px !important; }
div.featured-page-widget-container h3 { margin-top: 0px !important; padding-top: 0px !important; margin-bottom: 0px !important; padding-bottom: 0px !important; }


.rounded-box {
	-webkit-border-radius: 3px;
	-moz-border-radius: 3px;
	border-radius: 3px;
}


div.featured-page-widget-container div {
	margin-top: 10px;
}
.featured-page-widget-image-placeholder { width: 200px; margin: auto; border: 1px solid #cccccc; background-color: #ffffff; padding: 10px; padding-bottom: 7px;}
.featured-page-widget-image-placeholder img { width: 100%; }
.i3d_fpw .widget .widget-inside { font-size: 10px; }
.i3d_fpw .ui-tabs { padding: 0px; }
.i3d_fpw .ui-widget-content { background-image: none; background-color: transparent; }
.i3d_fpw .ui-widget-content .ui-state-active { background-color: transparent !important; border-color: #cccccc;  }
.i3d_fpw .ui-state-active a:link { color: #333333 !important; }

</style>	
<script>

jQuery("a.widget-action").bind("click", function() {
			//	shrinkVideoRegion(this);									

});
 
jQuery("a.widget-control-close").bind("click", function() {
			//	shrinkVideoRegion(this);									

});
</script>
<div class='i3d-widget-container'>
    <div class='i3d-help-region'>
    <div class='i3d-help-region-closed'><div class='i3d-help-title-bar'><a target="_blank" href="http://www.youtube.com/watch?v=dNuDaqijf_s"><i class='icon-youtube-play'></i> Watch Help Video &nbsp;  <i  class='icon-external-link'></i></a></div></div>
  <!--  <div class='i3d-help-region-opened i3d-help-region-hidden'>
    <div class='i3d-help-title-bar'>Hide <i class='icon-chevron-right'></i></div>
<iframe width="420" height="315" src="//www.youtube.com/embed/dNuDaqijf_s" frameborder="0" allowfullscreen></iframe>
    </div>-->
    </div>
<div class='i3d-widget-main-large'>

   <div class='i3d_fpw'>

    <div class='featured-page-widget-container featured-page-widget-<?php echo $random; ?>' id="featured-page-widget-<?php echo $random; ?>">
      <ul>
        <li><a href="#featured-page-widget-<?php echo $random; ?>-layout" onclick="setSelectedTab<?php echo $random; ?>('layout')"><i class='icon-eye-open'></i></a></li>
        <li><a href="#featured-page-widget-<?php echo $random; ?>-linkage" onclick="setSelectedTab<?php echo $random; ?>('linkage')"><i class='icon-link'></i></a></li>
        <li><a href="#featured-page-widget-<?php echo $random; ?>-text" onclick="setSelectedTab<?php echo $random; ?>('text')"><i class='icon-font'></i></a></li>
        <li class='i3d_fpw_image'><a href="#featured-page-widget-<?php echo $random;?>-image" onclick="setSelectedTab<?php echo $random; ?>('image')"><i class='icon-picture'></i></a></li>
      </ul>
      <div id="featured-page-widget-<?php echo $random; ?>-layout">
		<p><label style='font-weight: bold' for="<?php echo $this->get_field_id('layout'); ?>"><?php _e('Layout',"i3d-framework"); ?></label>
		<select onchange="changeLayout<?php echo $random; ?>(this)" class='widefat' id="<?php echo $this->get_field_id('layout'); ?>" name="<?php echo $this->get_field_name('layout'); ?>">
          <?php foreach ($lmWidgetWrapConfig['info-box'] as $infoBoxLayout => $configuration) { ?>
          <option <?php if ($layout == $infoBoxLayout) { print "selected"; } ?> value="<?php echo $infoBoxLayout; ?>"><?php echo $configuration['title']; ?></option>
          <?php } ?>
        </select>
        </p>
      </div>
      
      <div id="featured-page-widget-<?php echo $random; ?>-linkage">
        <p class='i3d_fpw_hover_icon'><label style='font-weight: bold' for="<?php echo $this->get_field_id('hover_icon'); ?>"><?php _e('Hover Icon',"i3d-framework"); ?></label>
		<select  class="widefat" id="<?php echo $this->get_field_id('hover_icon'); ?>" name="<?php echo $this->get_field_name('hover_icon'); ?>">
          <option <?php if ($instance['hover_icon'] == "mobile") { print "selected"; } ?> value="mobile">Mobile</option>
          <option <?php if ($instance['hover_icon'] == "screen") { print "selected"; } ?> value="screen">Screen</option>
          <option <?php if ($instance['hover_icon'] == "earth") { print "selected"; } ?> value="earth">Earth</option>
          <option <?php if ($instance['hover_icon'] == "support") { print "selected"; } ?> value="support">Support</option>
          <option <?php if ($instance['hover_icon'] == "locked") { print "selected"; } ?> value="locked">Locked</option>
          <option <?php if ($instance['hover_icon'] == "cog") { print "selected"; } ?> value="cog">Cog</option>
          <option <?php if ($instance['hover_icon'] == "clock") { print "selected"; } ?> value="clock">Clock</option>
          <option <?php if ($instance['hover_icon'] == "videos") { print "selected"; } ?> value="videos">Video</option>
          <option <?php if ($instance['hover_icon'] == "list") { print "selected"; } ?> value="list">List</option>
          <option <?php if ($instance['hover_icon'] == "refresh") { print "selected"; } ?> value="refresh">Refresh</option>
          <option <?php if ($instance['hover_icon'] == "images") { print "selected"; } ?> value="images">Images</option>
          <option <?php if ($instance['hover_icon'] == "pencil") { print "selected"; } ?> value="pencil">Pencil</option>
          <option <?php if ($instance['hover_icon'] == "link") { print "selected"; } ?> value="link">Link</option>
          <option <?php if ($instance['hover_icon'] == "mail") { print "selected"; } ?> value="mail">Mail</option>
          <option <?php if ($instance['hover_icon'] == "location") { print "selected"; } ?> value="location">Location</option>
          <option <?php if ($instance['hover_icon'] == "archive") { print "selected"; } ?> value="archive">Archive</option>
          <option <?php if ($instance['hover_icon'] == "chat") { print "selected"; } ?> value="chat">Chat</option>
          <option <?php if ($instance['hover_icon'] == "bookmark") { print "selected"; } ?> value="bookmark">Bookmark</option>
          <option <?php if ($instance['hover_icon'] == "user") { print "selected"; } ?> value="user">User</option>
          <option <?php if ($instance['hover_icon'] == "contract") { print "selected"; } ?> value="contract">Contract</option>
          <option <?php if ($instance['hover_icon'] == "star") { print "selected"; } ?> value="star">Star</option>
        </select>
        </p>



		<p><label style='font-weight: bold' for="<?php echo $this->get_field_id('linktype'); ?>"><?php _e('Link Type',"i3d-framework"); ?></label>
		<select onchange='setLinkType<?php echo $random; ?>(this)' class="widefat" id="<?php echo $this->get_field_id('linktype'); ?>" name="<?php echo $this->get_field_name('linktype'); ?>">
          <option <?php if ($linktype == "") { print "selected"; } ?> value="">None</option>
          <option <?php if ($linktype == "internal") { print "selected"; } ?> value="internal">Internal Page</option>
          <option <?php if ($linktype == "external") { print "selected"; } ?> value="external">External URL</option>
        </select>
        </p>
		<p class='linktype-internal' <?php if ($linktype != "internal") { print "style='display: none;'"; } ?>><label style='font-weight: bold' for="<?php echo $this->get_field_id('page'); ?>"><?php _e('Page',"i3d-framework"); ?></label>
    
		<select onchange='setPlaceholderImage<?php echo $random; ?>(this.form["<?php echo $this->get_field_name('page_image'); ?>"], "featured-page-widget-<?php echo $random; ?>-image-placeholder")' class="widefat" id="<?php echo $this->get_field_id('page'); ?>" name="<?php echo $this->get_field_name('page'); ?>">
    <?php
		$pages = get_pages();
		$selectedImages = array();
foreach ($pages as $pagg) {
  	$option = '<option ';
		if ($pagg->ID == $pageID) { 
		  $option .= 'selected ';
		}
		$featuredImageURL = wp_get_attachment_image_src( get_post_meta($pagg->ID, '_thumbnail_id', true), 'medium');
		$selectedImages["{$pagg->ID}"] = $featuredImageURL;
		$option .= 'value="'.$pagg->ID.'">';
	$option .= $pagg->post_title;
	$option .= '</option>';
	echo $option;
  }
 ?>
    </select></p>      
          <p class='linktype-external' <?php if ($linktype != "external") { print "style='display: none;'"; } ?>><label style='font-weight: bold' for="<?php echo $this->get_field_id('external_url'); ?>"><?php _e('URL',"i3d-framework"); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('external_url'); ?>" name="<?php echo $this->get_field_name('external_url'); ?>" type="text" value="<?php echo $external_url; ?>" /></p>

		<p class='linktype-target' <?php if ($linktype == "") { print "style='display: none;'"; } ?>><label style='font-weight: bold' for="<?php echo $this->get_field_id('linktarget'); ?>"><?php _e('Target',"i3d-framework"); ?></label>
		<select  class="widefat" id="<?php echo $this->get_field_id('linktarget'); ?>" name="<?php echo $this->get_field_name('linktarget'); ?>">
          <option <?php if ($linktarget == "") { print "selected"; } ?> value="">Same Window</option>
          <option <?php if ($linktarget == "_blank") { print "selected"; } ?> value="_blank">New Window</option>
        </select>
        </p>
      </div>
      <div id="featured-page-widget-<?php echo $random; ?>-text">
    <p><label style='font-weight: bold' for="<?php echo $this->get_field_id('title_text'); ?>"><?php _e('Title Text',"i3d-framework"); ?></label>
		<br/><span class='i3d_fpw_title_tag'><select id="<?php echo $this->get_field_id('title_tag'); ?>" name="<?php echo $this->get_field_name('title_tag'); ?>">
          <option value="h1">H1</option>
          <option <?php if ($title_tag == "h2" || $title_tag == "") { print "selected"; } ?> value="h2">H2</option>
          <option <?php if ($title_tag == "h3") { print "selected"; } ?> value="h3">H3</option>
          <option <?php if ($title_tag == "h4") { print "selected"; } ?> value="h4">H4</option>
        </select>
        </span>
        <?php I3D_Framework::renderFontAwesomeSelect($this->get_field_name('vector_icon'), @$instance['vector_icon']); ?>

        <input id="<?php echo $this->get_field_id('title_text'); ?>" name="<?php echo $this->get_field_name('title_text'); ?>" type="text" value="<?php echo $title_text; ?>" />
<span class='i3d_fpw_title_text_2'><input style='width: 340px' id="<?php echo $this->get_field_id('title_text_2'); ?>" name="<?php echo $this->get_field_name('title_text_2'); ?>" type="text" value="<?php echo $title_text_2; ?>" /></span>

    
    <p class='i3d_fpw_title_text_linkable'><input style='margin-top: 4px;' type='checkbox' id="<?php echo $this->get_field_id('title_text_linkable'); ?>" name="<?php echo $this->get_field_name('title_text_linkable'); ?>" value='1' <?php if ($title_text_linkable == "1") { echo "checked"; } ?> /> <label class='next-to-checkbox' for="<?php echo $this->get_field_id('title_text_linkable'); ?>"><?php _e('Title Text Linkable',"i3d-framework"); ?> </label>
		</p>
    <p class='i3d_fpw_hr'><input style='margin-top: 4px;' type='checkbox' id="<?php echo $this->get_field_id('hr'); ?>" name="<?php echo $this->get_field_name('hr'); ?>" value='1' <?php if ($hr == "1") { echo "checked"; } ?> /> <label for="<?php echo $this->get_field_id('hr'); ?>"><?php _e('Separate Title &amp; Desc with &lt;hr&gt;',"i3d-framework"); ?> </label>
		</p>

    <p class='i3d_fpw_description'><label style='font-weight: bold' for="<?php echo $this->get_field_id('description_text'); ?>"><?php _e('Description Text',"i3d-framework"); ?></label>
		<textarea class="widefat" id="<?php echo $this->get_field_id('description_text'); ?>" name="<?php echo $this->get_field_name('description_text'); ?>"><?php echo $description_text; ?></textarea></p>

    <p class='i3d_fpw_description'><input style='margin-top: 4px;' type='checkbox' id="<?php echo $this->get_field_id('bold_lead_paragraph'); ?>" name="<?php echo $this->get_field_name('bold_lead_paragraph'); ?>" value='1' <?php if ($bold_lead_paragraph == "1") { echo "checked"; } ?> /> <label for="<?php echo $this->get_field_id('bold_lead_paragraph'); ?>"><?php _e('Bold Lead Paragraph',"i3d-framework"); ?> </label>
		</p>
    
        
    <p><label style='font-weight: bold' for="<?php echo $this->get_field_id('more_link_text'); ?>"><?php _e('Button/Link Label',"i3d-framework"); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('more_link_text'); ?>" name="<?php echo $this->get_field_name('more_link_text'); ?>" type="text" value="<?php echo $more_link_text; ?>" /></p>
      
      </div>
      
      <div id="featured-page-widget-<?php echo $random; ?>-image">

  
        		
        <p class='i3d_fpw_image_position'><label style='font-weight: bold' for="<?php echo $this->get_field_id('image_position'); ?>"><?php _e('Position',"i3d-framework"); ?></label>
		<select  class="widefat" id="<?php echo $this->get_field_id('linktarget'); ?>" name="<?php echo $this->get_field_name('image_position'); ?>">
          <option <?php if ($image_position == "left") { print "selected"; } ?> value="left">Left</option>
          <option <?php if ($image_position == "right") { print "selected"; } ?> value="right">Right</option>
        </select>
        </p>

 <p>
    <?php
	$hasMediaLibraryImage = false;
	if ($selected_image != "" && is_numeric($selected_image)) {
	  $hasMediaLibraryImage = true;	
	}
	?>
	
		<select onchange='setPlaceholderImage<?php echo $random; ?>(this, "featured-page-widget-<?php echo $random; ?>-image-placeholder")' class="widefat" id="<?php echo $this->get_field_id('page_image'); ?>" name="<?php echo $this->get_field_name('page_image'); ?>">
          <option value="">-- Use Page's Featured Image --</option>
          <option <?php if ($selected_image == "none")    { print "selected"; } ?> value="none">-- No Image --</option>
          <option <?php if ($selected_image == "holder1") { print "selected"; } ?> value="holder1">Themed Image 1</option>
          <option <?php if ($selected_image == "holder2") { print "selected"; } ?> value="holder2">Themed Image 2</option>
          <option <?php if ($selected_image == "holder3") { print "selected"; } ?> value="holder3">Themed Image 3</option>
          <option <?php if ($selected_image == "holder4") { print "selected"; } ?> value="holder4">Themed Image 4</option>
          <option <?php if ($hasMediaLibraryImage) { print "selected"; } ?> value="media-library">Media Library Image</option>
<?php
/*
global $wpdb;
	$imageUploads = $wpdb->get_results("SELECT * FROM {$wpdb->posts} WHERE post_type='attachment' AND (post_mime_type='image/jpeg' OR post_mime_type='image/png' OR post_mime_type='image/gif')");
$mediaImages = "var mediaImages{$random} = new Array();\n";
foreach($imageUploads as $image) {
		$imagePath = substr($image->guid,(strrpos($image->guid,"/") +1));
			
			$large_image_url = wp_get_attachment_image_src( $image->ID, 'full');
			$mediaImages .= "mediaImages{$random} [{$image->ID}] = \"{$large_image_url[0]}\";\n";
?>
 <option <?php if ($selected_image == $image->ID) { print "selected"; } ?> value="<?php echo $image->ID; ?>"><?php echo $imagePath; ?></option>

<?php	}
*/
	?>
          
        </select>
        <script>
		<?php //echo $mediaImages; ?>
		</script>
		<?php
		 if ($selected_image != "" && is_numeric($selected_image)) {
			$metaData = get_post_meta($selected_image, '_wp_attachment_metadata', true);
            $fileName = I3D_Framework::get_image_upload_path(@$metaData['file']);
		 } else {
			 $fileName = "";
		 }
        ?>
		<div <?php if (!$hasMediaLibraryImage) { ?>style='display: none;'<?php } ?> id="special_image_placeholder_wrapper_<?php echo $random; ?>">
	   <div id="special_image_placeholder_<?php echo $random; ?>" class="special_image_placeholder2">
			<?php if ($fileName != "") { ?>
			<img src='<?php echo $fileName; ?>' />
			<?php } else { ?>
			
			<span class="fa-stack fa-4x">
  <i class="fa fa-square fa-stack-2x"></i>
  <i class="fa fa-picture-o fa-stack-1x fa-inverse"></i>
</span>
			<?php } ?>
	   </div>
	   <center>
       <input type='button' id="image_upload_button_<?php echo $random; ?>" class='button button-primary' value="<?php _e("Choose or Upload Image", "i3d-framework"); ?>" />
	   </center>
	   </div>
	   <input type="hidden" id="<?php echo $random."__image"; ?>" name="<?php echo $this->get_field_name('selected_media_image'); ?>" value="<?php echo $selected_image ?>" />

<script>
var file_frame;
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
 		jQuery("#special_image_placeholder_<?php echo $random; ?>").html("<img src='"+attachment.url+"' width='150px' />");
		jQuery("#<?php echo $random?>__image").val(attachment.id);
	});
 
	// Finally, open the modal
	file_frame.open();
});
 </script>
		
<div class='featured-page-widget-image-placeholder' id="featured-page-widget-<?php echo $random; ?>-image-placeholder" <?php  if ($selected_image == "none" || $hasMediaLibraryImage) { print "style='display:none;'"; } ?>><?php 
if ($selected_image == "") { 
  if (@$selectedImages["{$pageID}"][0] == "") {
?>No featured image is yet set up for this page.<br/>To set an image, please:<ol><li>Go to Pages</li><li>Edit 'your page'</li><li>Click on the 'set featured image' on the right configuration bar</li><li>Select/Upload your image</li><li>Click 'use as featured image' near bottom of dialog box</li><li>Click the 'Update' button to save your page</il></ul><?php

} else {
?><img src='<?php print $selectedImages["{$pageID}"][0]; ?>' /><?php 
}
} else if ($selected_image == "none") {
	 

} else {
	if (intval($selected_image) > 0) {
		$large_image_url = wp_get_attachment_image_src( $selected_image, 'full');
	?><img src='<?php echo $large_image_url[0]; ?>' /><?php
	} else {
		//print $selected_image;
		//print "<br>".is_int($selected_image);
?><img src='<?php echo get_template_directory_uri(); ?>/Site/themed-images/placeholders/<?php echo $lmImageDefaults['placeholder']['width']."x".$lmImageDefaults['placeholder']['height']; ?>/<?php echo $selected_image; ?>-<?php echo $lmImageDefaults['placeholder']['width']."x".$lmImageDefaults['placeholder']['height']; ?>.jpg' /><?php }  } ?></div>
</p>  
     
        <div class='i3d_fpw_image_mask image-widget<?php echo $rand; ?> image-widget-editor'>

            
        <h3>Advanced Image Display</h3>
        <div class='image-editor-50'>
 		<label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_mask'); ?>"><?php _e('Mask',"i3d-framework"); ?></label><br/>        
		<select onchange='setMaskOptions<?php echo $rand; ?>(this)' style='width: 98%' id="<?php echo $this->get_field_id('thumbnail_mask'); ?>" name="<?php echo $this->get_field_name('thumbnail_mask'); ?>">
          <option value="">None</option>
          <?php foreach (I3D_Framework::get_image_masks() as $mask_id => $mask) { ?>
          <option <?php if ($instance['thumbnail_mask'] == $mask_id) { print "selected"; } ?> value="<?php echo $mask_id; ?>"><?php echo $mask['name']; ?></option>
          <?php } ?>
        </select>         
        </div>
        <div class='image-editor-50' id='image-mask-options-<?php echo $rand; ?>' <?php if (@$instance['thumbnail_mask'] == "") { echo "style='display: none;'"; }?>>
  		<label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_mask_aspect'); ?>"><?php _e('Aspect Ratio',"i3d-framework"); ?></label><br/>        
		<select  style='width: 98%' id="<?php echo $this->get_field_id('thumbnail_mask_aspect'); ?>" name="<?php echo $this->get_field_name('thumbnail_mask_aspect'); ?>">
          <option  <?php if (@$instance['thumbnail_mask_aspect'] == "crop") { print "selected"; } ?> value="crop">Mask A/R  (Crop Image)</option>
          <option  <?php if (@$instance['thumbnail_mask_aspect'] == "stretch") { print "selected"; } ?> value="stretch">Image A/R (Stretch Mask)</option>
        </select>         
       
        </div> 
  		<br/>
        <div class='image-editor-33'>
        <label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_background_color'); ?>"><?php _e('BG Color',"i3d-framework"); ?></label><br/>        
		<input style='width: 60px;' type='color' id="<?php echo $this->get_field_id('thumbnail_background_color'); ?>" name="<?php echo $this->get_field_name('thumbnail_background_color'); ?>" value="<?php echo @$instance['thumbnail_background_color']; ?>">
  		</div>
                <div class='image-editor-33'>

         <label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_background_padding'); ?>"><?php _e('BG Padding',"i3d-framework"); ?></label><br/>
		<select style='width: 75px;' id="<?php echo $this->get_field_id('thumbnail_background_padding'); ?>" name="<?php echo @$this->get_field_name('thumbnail_background_padding'); ?>">
          <option value="">None</option>
          <?php foreach ($padding as $pad) { ?>
          <option <?php if (@$instance['thumbnail_background_padding'] == $pad) { print "selected"; } ?> value="<?php echo $pad; ?>"><?php echo $pad; ?></option>
          <?php } ?>
        </select>    
   		</div>
        
   		<div class='image-editor-33' style='display: none'>
        <label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_border_color'); ?>"><?php _e('Border Color',"i3d-framework"); ?></label><br/>        
		<input style='width: 60px;' type='color' id="<?php echo $this->get_field_id('thumbnail_border_color'); ?>" name="<?php echo $this->get_field_name('thumbnail_border_color'); ?>" value="<?php echo @$instance['thumbnail_border_color']; ?>">
        </div>       
        
        <div class='image-editor-33'>
        <label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_border_radius'); ?>"><?php _e('Border Radius',"i3d-framework"); ?></label><br/>
		<select style='width: 75px;' id="<?php echo $this->get_field_id('thumbnail_border_radius'); ?>" name="<?php echo @$this->get_field_name('thumbnail_border_radius'); ?>">
          <option value="">None</option>
          <?php foreach ($borderRadii as $radius) { ?>
          <option <?php if (@$instance['thumbnail_border_radius'] == $radius) { print "selected"; } ?> value="<?php echo $radius; ?>"><?php echo $radius; ?></option>
          <?php } ?>
        </select>         
        </div>

        <br/>

        
        <div class='image-editor-33'>
        <label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_hover_color'); ?>"><?php _e('Hover Color',"i3d-framework"); ?></label><br/>        
		<input style='width: 60px;' type='color' id="<?php echo $this->get_field_id('thumbnail_hover_color'); ?>" name="<?php echo $this->get_field_name('thumbnail_hover_color'); ?>" value="<?php echo @$instance['thumbnail_hover_color']; ?>">
  		</div>
        
        <div class='image-editor-33'>
        <label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_hover_color_alpha'); ?>"><?php _e('Hover Alpha',"i3d-framework"); ?></label><br/>
		<select style='width: 75px;' id="<?php echo $this->get_field_id('thumbnail_hover_color_alpha'); ?>" name="<?php echo $this->get_field_name('thumbnail_hover_color_alpha'); ?>">
          <option value="0">0%</option>
          <option <?php if (@$instance['thumbnail_hover_color_alpha'] == ".10") { print "selected"; } ?> value=".10">10%</option>
          <option <?php if (@$instance['thumbnail_hover_color_alpha'] == ".25") { print "selected"; } ?> value=".25">25%</option>
          <option <?php if (@$instance['thumbnail_hover_color_alpha'] == ".50") { print "selected"; } ?> value=".5">50%</option>
          <option <?php if (@$instance['thumbnail_hover_color_alpha'] == ".75") { print "selected"; } ?> value=".75">75%</option>
          <option <?php if (@$instance['thumbnail_hover_color_alpha'] == ".90") { print "selected"; } ?> value=".90">90%</option>
          <option <?php if (@$instance['thumbnail_hover_color_alpha'] == "1.0") { print "selected"; } ?> value="1.0">100%</option>
        </select>         
  		</div>
        <div class='image-editor-33'>
        <label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_hover_transition_time'); ?>"><?php _e('Effect Time',"i3d-framework"); ?></label><br/>
		<select style='width: 75px;' id="<?php echo $this->get_field_id('thumbnail_hover_transition_time'); ?>" name="<?php echo $this->get_field_name('thumbnail_hover_transition_time'); ?>">
          <option value=".25">.25 second</option>
          <option <?php if (@$instance['thumbnail_hover_transition_time'] == ".5") { print "selected"; } ?> value=".5">.5s</option>
          <option <?php if (@$instance['thumbnail_hover_transition_time'] == ".75") { print "selected"; } ?> value=".75">.75s</option>
          <option <?php if (@$instance['thumbnail_hover_transition_time'] == "1") { print "selected"; } ?> value="1">1 second</option>
          <option <?php if (@$instance['thumbnail_hover_transition_time'] == "1.25") { print "selected"; } ?> value="1.25">1.25s</option>
          <option <?php if (@$instance['thumbnail_hover_transition_time'] == "1.5") { print "selected"; } ?> value="1.5">1.5s</option>
          <option <?php if (@$instance['thumbnail_hover_transition_time'] == "1.75") { print "selected"; } ?> value="1.75">1.75s</option>
          <option <?php if (@$instance['thumbnail_hover_transition_time'] == "2.0") { print "selected"; } ?> value="2">2s</option>
        </select>         
  		</div>

        <div class='image-editor-33'>
              <label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_hover_icon'); ?>"><?php _e('Hover Icon',"i3d-framework"); ?></label><br/>        
        <?php I3D_Framework::renderFontAwesomeSelect($this->get_field_name('thumbnail_hover_icon'), @$instance['thumbnail_hover_icon'], false, '-- None --', '-- None -- '); ?>
  		</div>
        
        <div class='image-editor-33'>
        <label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_icon_effect'); ?>"><?php _e('Icon Effect',"i3d-framework"); ?></label><br/>
		<select style='width: 75px;' id="<?php echo $this->get_field_id('thumbnail_icon_effect'); ?>" name="<?php echo $this->get_field_name('thumbnail_icon_effect'); ?>">
          <option value="">None</option>
          <option <?php if (@$instance['thumbnail_icon_effect'] == "spin") { print "selected"; } ?> value="spin">Spin</option>
        </select>         
  		</div>
  		<br/>
        </div> 
      </div>
    </div>
    </div>
    </div>
    </div>
      <style>
	
	.image-widget<?php echo $rand; ?> .tooltip-inner {
		width: 420px;
		max-width: 420px;
	}
	
	.image-widget<?php echo $rand; ?> .tooltip-inner2 {
		width: 150px;
		max-width: 150px;

	}
	.image-widget-editor label { font-weight: bold; }
	.image-widget-editor .gallery-block-chooser { margin-top: 0px; display: inline-block;  vertical-align: top }

	.image-widget-editor .image-editor-33 { display: inline-block; width: 31%; vertical-align: top; } 
	.image-widget-editor .image-editor-66 { display: inline-block; width: 64%; vertical-align: top; } 
	.image-widget-editor .image-editor-66 input { width: 90%; margin-top: 1px;}
	.image-widget-editor .image-editor-50 input { width: 90%; margin-top: 1px;}
	.image-widget-editor .image-editor-50 select { width: 98%; margin-top: 1px;}
	.image-widget-editor .image-editor-50 { display: inline-block; width: 48%; vertical-align: top; } 
	.image-widget-editor h3 { background-color: #eeeeee; line-height: 40px; padding-left: 10px; margin-bottom: 0px; }
	.colorpicker input { width: auto !important; } 
	.special_image_placeholder2 {
	background-color: #ffffff;
    border: 1px solid #cccccc;
    margin: auto;
    padding: 10px 10px 7px;
    width: 200px;	
	margin-bottom: 7px;
	text-align: center;
	}
	
	.special_image_placeholder2 img {
	  width: 100%;	
	}
	</style>  


<script>
	function setMaskOptions<?php echo $rand; ?>(selectBox) {
	  if (selectBox.options[selectBox.selectedIndex].value == "") {
		jQuery("#image-mask-options-<?php echo $rand; ?>").css("display", "none");  
	  } else {
		jQuery("#image-mask-options-<?php echo $rand; ?>").css("display", "inline-block");  
		  
	  }
	}	
</script>
<script type="text/javascript">
jQuery(document).ready(function() {
								changeLayout<?php echo $random; ?>(jQuery('#<?php echo $this->get_field_id('layout'); ?>'));
								});
function changeLayout<?php echo $random; ?>(selectBox) {
	// reset options
		  jQuery(selectBox).parents(".i3d_fpw").find(".i3d_fpw_image").css("display", "none");
		  jQuery(selectBox).parents(".i3d_fpw").find(".i3d_fpw_title_text_linkable").css("display", "none");
		  jQuery(selectBox).parents(".i3d_fpw").find(".i3d_fpw_title_text_2").css("display", "none");
		  jQuery(selectBox).parents(".i3d_fpw").find(".i3d_fpw_title_tag").css("display", "none");
		  jQuery(selectBox).parents(".i3d_fpw").find(".i3d_fpw_hr").css("display", "none");
		  jQuery(selectBox).parents(".i3d_fpw").find(".i3d_fpw_image_position").css("display", "none");
		  jQuery(selectBox).parents(".i3d_fpw").find(".i3d_fpw_hover_icon").css("display", "none");
		  jQuery(selectBox).parents(".i3d_fpw").find(".i3d_fpw_image_mask").css("display", "none");
		  jQuery(selectBox).parents(".i3d_fpw").find(".i3d_fpw_description").css("display", "block");
		  

<?php foreach ($lmWidgetWrapConfig['info-box'] as $infoBoxLayout => $configuration) { ?>
  if (jQuery(selectBox).val() == "<?php echo $infoBoxLayout; ?>") {
	  
	<?php
	foreach ($configuration['options'] as $option) {
		if ($option == "no_description") { ?>
	  jQuery(selectBox).parents(".i3d_fpw").find(".i3d_fpw_description").css("display", "none");
	  jQuery(selectBox).parents(".i3d_fpw").find("span.i3d_fpw_description").css("display", "none");
			<?php
		} else {
		?>
	  jQuery(selectBox).parents(".i3d_fpw").find(".i3d_fpw_<?php echo $option; ?>").css("display", "block");
	  jQuery(selectBox).parents(".i3d_fpw").find("span.i3d_fpw_<?php echo $option; ?>").css("display", "inline");
	<?php }
	}
	?>
  
  }
  <?php }
  ?>
} 
	


function tabSelected<?php echo $random; ?>() {
	var widgetID = jQuery("#featured-page-widget-<?php echo $random; ?>").parents(".widget-inside").find('input.widget-id').val();
  	var myTargetTab = getCookie<?php echo $random; ?>(widgetID);
//  alert (targetBox);
//  alert(myTargetTab);
  return myTargetTab;
}
function setSelectedTab<?php echo $random; ?>(targetTab) {
	var widgetID = jQuery("#featured-page-widget-<?php echo $random; ?>").parents(".widget-inside").find('input.widget-id').val();
	//alert(jQuery("#featured-page-widget-<?php echo $random; ?>").parents(".widget-inside").html());
	//alert(jQuery("#featured-page-widget-<?php echo $random; ?>").html());
	//alert(widgetID);
	document.cookie = widgetID+"="+targetTab;
	//alert (document.cookie);
}

function getCookie<?php echo $random; ?>(c_name){
var c_value = document.cookie;
var c_start = c_value.indexOf(" " + c_name + "=");
if (c_start == -1)
  {
  c_start = c_value.indexOf(c_name + "=");
  }
if (c_start == -1)
  {
  c_value = null;
  }
else
  {
  c_start = c_value.indexOf("=", c_start) + 1;
  var c_end = c_value.indexOf(";", c_start);
  if (c_end == -1)
  {
c_end = c_value.length;
}
c_value = unescape(c_value.substring(c_start,c_end));
}
return c_value;
}
function setLinkType<?php echo $random; ?>(selectBox) {
	if (selectBox.selectedIndex == 0) {
      jQuery(selectBox).parent().parent().find(".linktype-external").css("display", "none");
      jQuery(selectBox).parent().parent().find(".linktype-internal").css("display", "none");	
      jQuery(selectBox).parent().parent().find(".linktype-target").css("display", "none");
	} else if (selectBox.selectedIndex == 1) {
      jQuery(selectBox).parent().parent().find(".linktype-external").css("display", "none");
      jQuery(selectBox).parent().parent().find(".linktype-internal").css("display", "block");	
      jQuery(selectBox).parent().parent().find(".linktype-target").css("display", "block");
	} else if (selectBox.selectedIndex == 2) {
      jQuery(selectBox).parent().parent().find(".linktype-external").css("display", "block");
      jQuery(selectBox).parent().parent().find(".linktype-internal").css("display", "none");
      jQuery(selectBox).parent().parent().find(".linktype-target").css("display", "block");
		
	}
}

function setPlaceholderImage<?php echo $random; ?>(selectBox, targetBlock) {
  var selectedImage = selectBox.options[selectBox.selectedIndex].value;
 // alert(selectedImage);
 <?php global $lmImageDefaults; ?>
  
  if (selectedImage == "") {
	  jQuery("#special_image_placeholder_wrapper_<?php echo $rand; ?>").css("display", "none");
	  
    var selectedPage = selectBox.form['<?php echo $this->get_field_name('page'); ?>'].options[selectBox.form['<?php echo $this->get_field_name('page'); ?>'].selectedIndex].value;
	var featuredPageURL = '';
	<?php foreach ($selectedImages as $pageID => $featuredURL) { ?>
	if (selectedPage == <?php echo $pageID; ?>) {
		var featuredPageURL = '<?php echo $featuredURL[0]; ?>'; 
	}
	<?php } ?>
	if (featuredPageURL == "") {
		var html = "No featured image is yet set up for this page.<br/>To set an image, please:<ol><li>Go to Pages</li><li>Edit 'your page'</li><li>Click on the 'set featured image' on the right configuration bar</li><li>Select/Uplaod your image</li><li>Click 'use as featured image' near bottom of dialog box</li><li>Click the 'Update' button to save your page</il></ul>";
	} else {
		var html = "<img src='" + featuredPageURL + "' />";
	}
	  jQuery("#" + targetBlock).css("display", "block");	

	
  } else if (selectedImage == "none") {
	var html = "No Image";  
		  jQuery("#special_image_placeholder_wrapper_<?php echo $random; ?>").css("display", "none");

       jQuery("#" + targetBlock).css("display", "none");	
  } else if (selectedImage == "media-library") {
	  //alert("yup");
	  	  jQuery("#special_image_placeholder_wrapper_<?php echo $random; ?>").css("display", "block");
  		jQuery("#" + targetBlock).css("display", "none");	

  } else {
	  	  	  jQuery("#special_image_placeholder_wrapper_<?php echo $rand; ?>").css("display", "none");

	if (!parseInt(selectedImage)) {
	  var html = "<img src='<?php echo get_template_directory_uri(); ?>/Site/themed-images/placeholders/<?php echo $lmImageDefaults['placeholder']['width']."x".$lmImageDefaults['placeholder']['height']; ?>/" + selectedImage + "-<?php echo $lmImageDefaults['placeholder']['width']."x".$lmImageDefaults['placeholder']['height']; ?>.jpg' />"; 
	} else {
	  var html = "<img src='" + mediaImages<?php echo $random; ?>[selectedImage] + "' />"; 		
	}
	//alert(html);
  jQuery("#" + targetBlock).css("display", "block");	
  }
  jQuery("#" + targetBlock).html(html);	
}



</script>
	<script type="text/javascript">
	jQuery(function(){
		var tabSel = tabSelected<?php echo $random; ?>();
		if (tabSel == "text") {
			selected = 2;
		} else if (tabSel == "linkage") {
			selected = 1;
		} else if (tabSel == "image") {
			selected = 3;
		} else {
			selected = 0;
		}
		jQuery('.featured-page-widget-<?php echo $random; ?>').tabs({active: selected});
	});
	</script>
<?php
	}
	
	
}
?>