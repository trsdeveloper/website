<?php

/***********************************/
/**        Logo WIDGET         **/
/***********************************/
class I3D_Widget_Logo extends WP_Widget {
	function __construct() {
	//function I3D_Widget_Logo() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Your Website Name or Graphic Logo', "i3d-framework") );
		parent::__construct('i3d_logo', __('i3d:Logo', "i3d-framework"), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );
		
		echo $before_widget;
		//print "uhh huh";
		if (I3D_Framework::use_global_layout()) {	
			global $page_id;
			$page_layouts 		= (array)get_post_meta($page_id, "layouts", true);
			
			//var_dump($page_layouts);
			//print "\n".__LINE__."\n<br>";
			$layout_id 	= get_post_meta($page_id, "selected_layout", true);
			//print "\n".__LINE__."\n<br>";
			$row_id = @$instance['row_id'];
			//print "\n".__LINE__."\n<br>";
			$widget_id = @$instance['widget_id'];
			//print "\n".__LINE__."\n<br>";

			$website_name 	= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["website_name"];
			//			print "\n".__LINE__."\n<br>";

	        $text_1 		= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["text_1"];
			//print "\n".__LINE__."\n<br>";
	        $text_2			= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["text_2"];
		//	print "\n".__LINE__."\n<br>";
			if ($website_name != "default" && $website_name != "") {
		//	print "\n".__LINE__."\n<br>";
			  $instance['website_name'] = $website_name;	
			  $instance['text_1'] = $text_1;
			  $instance['text_2'] = $text_2;
			}
		//	print "\n".__LINE__."\n<br>";


			$link 	= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["link"];
			//			print "\n".__LINE__."\n<br>";

	        $link_custom 		= @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["link_custom"];
			//print "\n".__LINE__."\n<br>";
		//	print "\n".__LINE__."\n<br>";
		    if ($link == "disabled") {
				$instance['link'] = "disabled";
			} else if ($link == "custom") {
				$instance['link'] = "custom";
				$instance['link_custom'] = $link_custom;
			} else if ($link == "default") {
				$instance['link'] = "default";
				
			} else if ($link == "*") {
				//$instance['link'] = "";
			}
			

	        $graphic_logo = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["graphic_logo"];
			if ($graphic_logo != "default" && $graphic_logo != "") {
			  $instance['graphic_logo'] = $graphic_logo;	
			}
			
			//	print "\n".__LINE__."\n<br>";
		
	        $tagline_setting = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["tagline_setting"];
	        $tagline 		 = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["tagline"];
			if ($tagline_setting != "default" && $tagline_setting != "") {
			  $instance['tagline_setting'] = $tagline_setting;	
			  $instance['tagline'] = $tagline;	
			}
			//print "\n".__LINE__."\n<br>";
	        $justification	 = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["justification"];
			if ($justification != "default" && $justification != "") {
			  $instance['justification'] = $justification;	
			}
			
			
	        $style	 = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["style"];
			if ($style != "default" && $style != "") {
			  $instance['style'] = $style;	
			}
			
			//print "\n".__LINE__."\n<br>";
				//print "graphic logo: $graphic_logo";
			$vector_icon = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]['vector_icon'];
			$font_awesome_icon = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]['font_awesome_icon'];
			if ($vector_icon != "default" && $vector_icon != "global" && $vector_icon != "") {
				if ($vector_icon == "disabled") {
					$instance['vector_icon'] = "";
				} else if ($vector_icon == "custom") {
					$instance['vector_icon'] = $font_awesome_icon;
				}
			 // $instance['vector_icon'] = $vector_icon;	
			 // $instance['font_awesome_icon'] = $font_awesome_icon;	
			  
			}
			//if ( !isset() ) { $font_awesome_icon = ""; } else { $font_awesome_icon = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]['vector_icon']; }
		}
		

//print "yes";
		i3d_render_logo($instance);
		echo $after_widget;
	}

	public static function getPageInstance($pageID, $defaults = array()) {
		$instance = $defaults;
		$new_instance = get_post_meta($pageID, "i3d_logo_settings", true);
		
		// initialize
		$new_instance = wp_parse_args( (array) $new_instance, array( 'website_name' => '', 'graphic_logo' => '', 'text_1' => '', 'text_2' => '', 'tagline' => '', 'tagline_setting' => '', 'vector_icon' => '', 'justification' => '', 'custom_logo_status' => ''  ) );
			
		if (!is_array($new_instance)) {
			$new_instance = array();
		}
		$generalSettings = get_option('i3d_general_settings');
		if (array_key_exists("graphic_logo", $new_instance)) {
          $instance['graphic_logo'] 		= $new_instance['graphic_logo'];
		} else {
		  $instance['graphic_logo'] = "";
		}
		
		if ($instance['graphic_logo'] == "x") {
			$instance['graphic_logo'] = "";
		} else if ($instance['graphic_logo'] == "") {
			$instance['graphic_logo'] = "default";
		}
		


        $instance['website_name'] 		= $new_instance['website_name'];
		if ($instance['website_name'] == "x") {
			$instance['website_name'] = "";
		} else if ($instance['website_name'] == "") {
			$instance['website_name'] = "default";
		}
		
		
        $instance['text_1'] 			= $new_instance['text_1'];
        $instance['text_2'] 			= $new_instance['text_2'];
        $instance['tagline'] 		  	= $new_instance['tagline'];
		$instance['tagline_setting']  	= $new_instance['tagline_setting'];
		
		if ($instance['tagline_setting'] == "x") {
			$instance['tagline_setting'] = "";
		} else if ($instance['tagline_setting'] == "") {
			$instance['tagline_setting'] = "default";
		}

		$instance['tagline']       		= strip_tags($new_instance['tagline']);
		
		if ($new_instance['graphic_logo'] != "" && $new_instance['graphic_logo'] != "default") {
			$new_instance['graphic_logo'] = $new_instance['actual_graphic_logo'];
		}
		
		$instance['graphic_logo']  = strip_tags($new_instance['graphic_logo']);
		$instance['vector_icon']  = strip_tags($new_instance['vector_icon']);
		$instance['custom_logo_status']  = strip_tags($new_instance['custom_logo_status']);
		if ($instance['vector_icon'] == "x") {
			$instance['vector_icon'] = "";
		} else if ($instance['vector_icon'] == "") {
			$instance['vector_icon'] = "default";
		}		
		
		if ($new_instance['vector_icon'] != "" && $new_instance['vector_icon'] != "default") {
			$new_instance['vector_icon'] = $new_instance['font_awesome_icon'];
		}
		
		//		var_dump($instance);

		$instance['justification'] = $new_instance['justification'];
		return $instance;
	}
	
	
	function layout_configuration_form( $instance, $defaults, $row_id, $widget_id, $layout_id, $page_level = false ) {
	//	var_dump($instance);
	//	var_dump($defaults);
	  $defaults =  wp_parse_args( (array) $defaults, array( 'style' => '', 'link' => "default", 'link_custom' => '', 'website_name' => 'default', 'graphic_logo' => 'default', 'text_1' => '', 'text_2' => '', 'tagline' => '', 'tagline_setting' => 'default', 'vector_icon' => '', 'justification' => '', 'custom_logo_status' => ''  ) );
	  
	  $instance =  wp_parse_args( (array) $instance, array( 'style' => '', 'link' => "default", 'link_custom' => '', 'website_name' => $defaults['website_name'], 'graphic_logo' => $defaults['graphic_logo'], 'text_1' => '', 'text_2' => '', 'tagline' => '', 'tagline_setting' => $defaults['tagline_setting'], 'vector_icon' => '', 'justification' => '', 'custom_logo_status' => ''  ) );
	  global $post;
	  global $i3dTextLogoLines;

	  $layouts = get_option('i3d_layouts');
	  if ($page_level) {
		
		  $prefix = "__i3d_layouts__{$layout_id}__";
			$page_layouts 		= (array)get_post_meta($post->ID, "layouts", true);
			$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"] =  wp_parse_args( (array) @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"], array('style' => '*',  'link' => "*", 'link_custom' => '', 'website_name' => 'default', 'graphic_logo' => 'default', 'text_1' => '', 'text_2' => '', 'tagline' => '', 'tagline_setting' => 'default', 'vector_icon' => 'default', 'justification' => '*' ) );
	        $graphic_logo = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["graphic_logo"];
	        $website_name = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["website_name"];
	        $tagline_setting = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["tagline_setting"];
	        $tagline 		 = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["tagline"];
	        $text_1 		 = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["text_1"];
	        $text_2 		 = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["text_2"];
	        $tagline 		 = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["tagline"];
	        $justification	 = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["justification"];
	        $link 			 = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["link"];
	        $link_custom 			 = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["link_custom"];
	        $style 			 = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]["style"];
						
				//print "graphic logo: $graphic_logo";
			$vector_icon = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]['vector_icon'];
			
				$font_awesome_icon = @$page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]['font_awesome_icon'];
			
			//if ( !isset() ) { $font_awesome_icon = ""; } else { $font_awesome_icon = $page_layouts["$layout_id"]["$row_id"]["configuration"]["$widget_id"]['vector_icon']; }
			$layoutID = $layout_id;
	  } else {
		//  global $layoutID;
		//  var_dump($instance);
		  $prefix = "";
		if ( !isset($instance['website_name']) )   { $website_name = "default"; } else { $website_name = $instance['website_name']; }
		if ( !isset($instance['tagline_setting']) ){ $tagline_setting = "default"; } else { $tagline_setting = $instance['tagline_setting']; }
		if ( !isset($instance['vector_icon']) ) 	{ $font_awesome_icon = ""; } else { $font_awesome_icon = $instance['vector_icon']; }
		$text_1 = strip_tags($instance['text_1']);
		$text_2 = strip_tags($instance['text_2']);
		$link = strip_tags($instance['link']);
		$link_custom = strip_tags($instance['link_custom']);
		$tagline = strip_tags($instance['tagline']);
		$graphic_logo = strip_tags($instance['graphic_logo']);
		$justification = strip_tags($instance['justification']);
		$style = strip_tags($instance['style']);

		if ( !isset($instance['vector_icon']) ) { $font_awesome_icon = ""; } else { $font_awesome_icon = $instance['vector_icon']; }

	  }
	  $rand = rand();
	
	//  print "layoutID: $layoutID";
	//print $graphic_logo;
      ?>
	<div class="input-group">
  		<span class="input-group-addon detailed-addon"><i class="fa fa-image fa-fw"></i> <span class='detailed-label'>Bitmap Logo</span></span>
		<select onChange="setGraphicLogo<?php echo $rand; ?>(this)" class='form-control tt2' title="Graphic Logo" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__graphic_logo">
          <option <?php if ($graphic_logo == "" || $graphic_logo == "disabled") { print "selected"; } ?> value="disabled"><?php _e('Disabled', "i3d-framework"); ?></option>
          <option <?php if ($graphic_logo == "default")  { print "selected"; } ?> value="default"><?php _e('Default', "i3d-framework"); ?></option>
     	  <option <?php if ($graphic_logo != "default" && $graphic_logo != "" && $graphic_logo != "disabled")   { print "selected"; } ?> value="custom"><?php _e('Custom', "i3d-framework"); ?></option>
		</select>
	</div>
    <input type="hidden" id="<?php echo $this->get_field_id('actual_graphic_logo'); ?><?php echo $rand; ?>" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__actual_graphic_logo" value="<?php if ($graphic_logo != "" && $graphic_logo != "default" && $graphic_logo != "disabled")   { print $graphic_logo; } ?>" />
		<?php
		 if ($graphic_logo != "" && $graphic_logo != "default"  && $graphic_logo != "disabled") {
			$metaData = get_post_meta($graphic_logo, '_wp_attachment_metadata', true);
            $fileName = site_url().'/wp-content/uploads/'.$metaData['file']; 
		 } else {
			 $fileName = "";
		 }
        ?>
	   <div class="special_image_placeholder_wrapper" <?php if ($graphic_logo == "" || $graphic_logo == "default" || $graphic_logo == "disabled") { print 'style="display: none;"'; } ?>>
	   <div id="special_image_placeholder_<?php echo $rand; ?>" class="special_image_placeholder" >
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
       <input type='button' id="image_upload_button_<?php echo $rand; ?>" class='button button-primary' value="<?php _e("Choose or Upload Image", "i3d-framework"); ?>" />
	   </center>
	   </div>
<script>
var file_frame<?php echo $rand; ?>;
jQuery('#image_upload_button_<?php echo $rand; ?>').live('click', function( event ){
 
	event.preventDefault();
	// If the media frame already exists, reopen it.
	//if ( typeof pagetype !== 'undefined'  ) {
	//	file_frame<?php echo $rand; ?>.open();
	//	return;
	//}
	// Create the media frame.
	file_frame<?php echo $rand; ?> = wp.media.frames.file_frame = wp.media({
		title: jQuery( this ).data( 'uploader_title' ),
		button: {
			text: jQuery( this ).data( 'uploader_button_text' ),
		},
		multiple: false // Set to true to allow multiple files to be selected
	});

	// When an image is selected, run a callback.
	file_frame<?php echo $rand; ?>.on( 'select', function() {
		// We set multiple to false so only get one image from the uploader
		attachment = file_frame<?php echo $rand; ?>.state().get('selection').first().toJSON();
 		jQuery("#special_image_placeholder_<?php echo $rand; ?>").html("<img src='"+attachment.url+"' width='150px' />");
		jQuery("#<?php echo $this->get_field_id('actual_graphic_logo'); ?><?php echo $rand; ?>").val(attachment.id);
	});
 
	// Finally, open the modal
	file_frame<?php echo $rand; ?>.open(); 
	
	
});

	   function selectGraphicLogo<?php echo $rand; ?>(div, imageID) {
		 jQuery(div).parent().find("div").removeClass("graphic-logo-image-selected");
		 jQuery(div).addClass("graphic-logo-image-selected");
		 jQuery(div).parent().parent().find("#<?php echo $this->get_field_id('actual_graphic_logo'); ?>").val(imageID);
		
	   }
	   function setFontAwesomeIcon(div, icon) {
		 jQuery(div).parent().find("div").removeClass("font-awesome-icon-selected");
		 jQuery(div).addClass("font-awesome-icon-selected");
		 //alert(jQuery(div).parent().parent().html());
		 jQuery(div).parent().parent().find("#<?php echo $this->get_field_id('font_awesome_icon'); ?>").val(icon);
	   }
	   
	   function setGraphicLogo<?php echo $rand; ?>(selectBox) {
		  jQuery(selectBox).parents(".popover-configurations-container").css("height", "auto");
		  if (selectBox.selectedIndex == 0) {
			 jQuery(selectBox).parent().parent().find("div.vector-icons").css("display", "block");  
			 jQuery(selectBox).parent().parent().find("div.special_image_placeholder_wrapper").css("display", "none");  
		  } else if (selectBox.selectedIndex == 1) {
			 jQuery(selectBox).parent().parent().find("div.vector-icons").css("display", "none");  
			 jQuery(selectBox).parent().parent().find("div.special_image_placeholder_wrapper").css("display", "none");  
		  } else {
			 jQuery(selectBox).parent().parent().find("div.vector-icons").css("display", "none");  
			 jQuery(selectBox).parent().parent().find("div.special_image_placeholder_wrapper").css("display", "block");  
		  }
		//  alert(selectBox.selectedIndex);
	   }

		function setVectorIcon<?php echo $rand; ?>(selectBox) {
		  if (selectBox.selectedIndex == 2) {
			 jQuery(selectBox).parent().parent().find("div.available-fontawesome-icons").css("display", "inline-block");  
		  } else {
			 jQuery(selectBox).parent().parent().find("div.available-fontawesome-icons").css("display", "none");  
		  }
	   }
	   function setWebsiteName<?php echo $rand; ?>(selectBox) {
		  if (selectBox.selectedIndex == 2) {
			 jQuery(selectBox).parent().parent().find("div.website-name-custom").css("display", "block");  
		  } else {
			 jQuery(selectBox).parent().parent().find("div.website-name-custom").css("display", "none");  
		  }
	   }
	   function setLink<?php echo $rand; ?>(selectBox) {
		   
		  if (selectBox.options[selectBox.selectedIndex].value == "custom") {
			 jQuery(selectBox).parent().parent().find("div.link-custom").css("display", "block");  
		  } else {
			 jQuery(selectBox).parent().parent().find("div.link-custom").css("display", "none");  
		  }
	   }


function setTagline<?php echo $rand; ?>(selectBox) {
		  if (selectBox.selectedIndex == 2) {
			 jQuery(selectBox).parent().parent().find("div.tagline-custom").css("display", "block");  
		  } else {
			 jQuery(selectBox).parent().parent().find("div.tagline-custom").css("display", "none");  
		  }
	   }	   
 </script>
         <div title="Vector Icon" class='vector-icons tt2'  <?php if ($graphic_logo != "" && $graphic_logo != "disabled") { print 'style="display: none;"'; } ?>>
         <div class='input-group'>
  		<span class="input-group-addon detailed-addon"><i class="fa fa-flag fa-fw"></i> <span class='detailed-label'>Icon</span></span>
        <!-- Font Awesome Icons --> 
		<select class='form-control tt2' onChange="setVectorIcon<?php echo $rand; ?>(this)"  id="<?php echo $this->get_field_id('vector_icon'); ?>"  name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__vector_icon">
          <option <?php if ($font_awesome_icon == "") { print "selected"; } ?> value=""><?php _e('Disabled', "i3d-framework"); ?></option>
          <option <?php if ($font_awesome_icon == "global")  { print "selected"; } ?> value="global"><?php _e('Default', "i3d-framework"); ?></option>
     	  <option <?php if ($font_awesome_icon != "" && $font_awesome_icon != "global")   { print "selected"; } ?> value="custom"><?php _e('Custom', "i3d-framework"); ?></option>
        </select> 
		</div>
    
		<div class='available-fontawesome-icons'  style='vertical-align: top; <?php if ($font_awesome_icon == "" || $font_awesome_icon == "global" || $font_awesome_icon == "disabled") { print 'display: none;'; } else { print "display: inline-block;"; } ?>'>
                  	<?php I3D_Framework::renderFontAwesomeSelect($prefix.$row_id."__configuration__".$widget_id."__font_awesome_icon", @$font_awesome_icon); ?>

		  
		  <?php /* foreach ($fontAwesomeIcons as $icon) { ?>
          <div class='font-awesome-icon <?php if ($icon == $font_awesome_icon) { print "font-awesome-icon-selected"; } ?>' onclick='setFontAwesomeIcon(this, "<?php print $icon; ?>")'><i class='icon-<?php echo $icon; ?>'></i></div>
          <?php } */ ?>
        </div>
        </div>
  
	<div class="input-group  tt2"  title="Website Name" >
  		<span class="input-group-addon detailed-addon"><i class="fa fa-font fa-fw"></i> <span class='detailed-label'>Website Name</span></span>
	  <select  class='form-control'  onChange="setWebsiteName<?php echo $rand; ?>(this)"  name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__website_name">
          <option <?php if ($website_name == "disabled") { print "selected"; } ?> value="disabled"><?php _e('Disabled', "i3d-framework"); ?></option>
          <option <?php if ($website_name == "default")  { print "selected"; } ?> value="default"><?php _e('Default', "i3d-framework"); ?></option>
     	  <option <?php if ($website_name == "custom")   { print "selected"; } ?> value="custom"><?php _e('Custom', "i3d-framework"); ?></option>
	  </select>
	</div>
     <div class="website-name-custom" <?php if ($website_name != "custom") { print 'style="display: none;"'; } ?>>
 		 <input class='form-control' id="<?php echo $this->get_field_id('text_1'); ?>" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__text_1" type="text" value="<?php echo esc_attr($text_1); ?>" placeholder="<?php _e("Website Name", "i3d-framework"); ?>" />
         <?php if ($i3dTextLogoLines == 2) { ?>
 		 <input class='form-control'  id="<?php echo $this->get_field_id('text_2'); ?>" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__text_2" type="text" value="<?php echo esc_attr($text_2); ?>"  placeholder="<?php _e("Secondary Colored Text", "i3d-framework"); ?>"/> 
         <?php } ?>
        </div> 
	
	<div class="input-group  tt2" title="Tagline">
  		<span class="input-group-addon detailed-addon"><i class="fa fa-quote-left fa-fw"></i> <span class='detailed-label'>Tagline</span></span>
	  <select onChange="setTagline<?php echo $rand; ?>(this)" class='form-control'  name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__tagline_setting">
         <option <?php if ($tagline_setting == "" || $tagline_setting == "disabled") { print "selected"; } ?> value="disabled"><?php _e('Disabled',"i3d-framework"); ?></option>
          <option <?php if ($tagline_setting == "default")  { print "selected"; } ?> value="default"><?php _e('Default', "i3d-framework"); ?></option>
     	  <option <?php if ($tagline_setting == "custom")   { print "selected"; } ?> value="custom"><?php _e('Custom', "i3d-framework"); ?></option>
	  </select>
	</div>
	
	 <div class="tagline-custom" <?php if ($tagline_setting != "custom") { print 'style="display: none;"'; } ?>>
                
 		<input  class='form-control' id="<?php echo $this->get_field_id('tagline'); ?>" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__tagline" type="text" value="<?php echo esc_attr($tagline); ?>" placeholder="<?php _e("Custom Tagline", "i3d-framework"); ?>" /> 
        </div>
	<div class="input-group">
  		<span class="input-group-addon detailed-addon"><i class="fa fa-align-left fa-fw"></i> <span class='detailed-label'>Alignment</span></span>
	  <select class='form-control tt2' title="Justification" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__justification">
 <?php if ($prefix != "") { ?>
          <option <?php if ($justification == "default") { print "selected"; } ?> value="default"><?php _e('Default', "i3d-framework"); ?></option>
 
 <?php } ?>
          <option <?php if ($justification == "left") { print "selected"; } ?> value="left"><?php _e('Left', "i3d-framework"); ?></option>
          <option <?php if ($justification == "center") { print "selected"; } ?> value="center"><?php _e('Center', "i3d-framework"); ?></option>
     	  <option <?php if ($justification == "right") { print "selected"; } ?> value="right"><?php _e('Right', "i3d-framework"); ?></option>
	  </select>
	</div>
	<?php if (sizeof(I3D_Framework::$logoStyles) > 0) { ?>
	<div class="input-group">
  		<span class="input-group-addon detailed-addon"><i class="fa fa-paint-brush fa-fw"></i> <span class='detailed-label'>Style</span></span>
	  <select class='form-control tt2' title="Style" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__style">
 <?php if ($prefix != "") { ?>
          <option <?php if ($style == "default") { print "selected"; } ?> value="default"><?php _e('Layout Default', "i3d-framework"); ?></option>
 <?php } ?>
 <?php foreach (I3D_Framework::$logoStyles as $key => $value) { ?>
          <option <?php if (@$style == $key) { print "selected"; } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
<?php } ?>
	  </select>
	</div>
<?php } ?>	
	
	<div class="input-group  tt2"  title="Link" >
  		<span class="input-group-addon detailed-addon"><i class="fa fa-link fa-fw"></i> <span class='detailed-label'>Link</span></span>
	  <select  class='form-control'  onChange="setLink<?php echo $rand; ?>(this)"  name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__link">
          <?php if ($prefix != "") { ?>
		  <option <?php if ($link == "*")  { print "selected"; } ?> value="*"><?php _e('Layout Default', "i3d-framework"); ?></option>  
		  <?php } ?>
		  <option <?php if ($link == "default")  { print "selected"; } ?> value="default"><?php _e('Site Default', "i3d-framework"); ?></option>
          <option <?php if ($link == "disabled") { print "selected"; } ?> value="disabled"><?php _e('Disabled',  "i3d-framework"); ?></option>
     	  <option <?php if ($link == "custom")   { print "selected"; } ?> value="custom"><?php _e('Custom', "i3d-framework"); ?></option>
	  </select>
	</div>
     <div class="link-custom" <?php if ($link != "custom") { print 'style="display: none;"'; } ?>>
 		 <input class='form-control' id="<?php echo $this->get_field_id('link_custom'); ?>" name="<?php echo $prefix.$row_id; ?>__configuration__<?php echo $widget_id; ?>__link_custom" type="url" value="<?php echo esc_attr($link_custom); ?>" placeholder="<?php _e("http://somewebsite.com/", "i3d-framework"); ?>" />
        </div> 
 	  
	  <?php
	}
	function update( $new_instance, $old_instance ) {
				//var_dump($new_instance);

		$instance = $old_instance;
		$instance['justification'] = strip_tags($new_instance['justification']);
		$instance['website_name']  = strip_tags($new_instance['website_name']);
		$instance['tagline_setting']  = strip_tags($new_instance['tagline_setting']);
		$instance['text_1']        = strip_tags($new_instance['text_1']);
		$instance['text_2']        = strip_tags($new_instance['text_2']);
		$instance['link']        = strip_tags($new_instance['link']);
		$instance['link_custom']        = strip_tags($new_instance['link_custom']);
		$instance['tagline']       = strip_tags($new_instance['tagline']);
		$instance['style']       = strip_tags($new_instance['style']);
		if ($new_instance['graphic_logo'] != "" && $new_instance['graphic_logo'] != "default") {
			$new_instance['graphic_logo'] = $new_instance['actual_graphic_logo'];
		}
		$instance['graphic_logo']  = strip_tags($new_instance['graphic_logo']);
		if ($new_instance['vector_icon'] != "" && $new_instance['vector_icon'] != "default" && $new_instance['vector_icon'] != "global") {
			$new_instance['vector_icon'] = str_replace("fa ", "", $new_instance['font_awesome_icon']);
		} 
		$instance['vector_icon']  = strip_tags($new_instance['vector_icon']);
	//	var_dump($instance);
		//print "done";
//	exit;
		return $instance;
	}

    function getFontAwesomeIcons() {
	  $cssFile = @file_get_contents(TEMPLATEPATH."/Site/styles/font-awesome/css/font-awesome.css");	
	  $cssFileArray =  explode("/* Font Awesome uses the Unicode Private Use Area (PUA)", $cssFile);
	  $fontsString = @$cssFileArray[1];
	  $icons = array();
	  $pattern = '/\.icon-([\w]*?)\:before {[\s]*content: "(.*?)";[\s]*}/si';
	  preg_match_all($pattern, $fontsString, $matches);
	  foreach ($matches[1] as $index => $match) {
		  $icons[] = $match;
	  }
	  return $icons;
	

	}
	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'link_custom' => '', 'link' => '', 'title' => '', 'text' => '', 'text_1' => '', 'text_2' => '', 'justification' => '', 'tagline' => '', 'graphic_logo' => '',  ) );
		//var_dump($instance);
		$justification = strip_tags($instance['justification']);
		if ( !isset($instance['website_name']) )   { $website_name = "default"; } else { $website_name = $instance['website_name']; }
		if ( !isset($instance['tagline_setting']) ){ $tagline_setting = "default"; } else { $tagline_setting = $instance['tagline_setting']; }
		if ( !isset($instance['vector_icon']) ) { $font_awesome_icon = ""; } else { $font_awesome_icon = $instance['vector_icon']; }
		if ($font_awesome_icon == "global") {
		//	$font_awesome_icon = "";
		} else {
			$font_awesome_icon = I3D_Framework::conditionFontAwesomeIcon($font_awesome_icon, true);
		}
		//print $font_awesome_icon;
		$text_1 = strip_tags($instance['text_1']);
		$text_2 = strip_tags($instance['text_2']);
		$link = strip_tags($instance['link']);
		$link_custom = strip_tags($instance['link_custom']);
		$tagline = strip_tags($instance['tagline']);
		$graphic_logo = strip_tags($instance['graphic_logo']);
		global $i3dTextLogoLines;
		$rand = rand();
?>


<div class='i3d-widget-container'>
    <div class='i3d-help-region'>
    	<div class='i3d-help-region-closed'><div class='i3d-help-title-bar'><a target="_blank" href="http://www.youtube.com/watch?v=Oow6R0eWd3M"><i class='icon-youtube-play'></i> Watch Help Video &nbsp;  <i  class='icon-external-link'></i></a></div></div>
    </div>
	<div class='i3d-widget-main-large'>
        <div class='widget-section'>
         <!-- Graphic -->
        <label class='label-regular' for="<?php echo $this->get_field_id('graphic_logo'); ?>"><?php _e('Graphic Logo', "i3d-framework"); ?></label>
		<select onChange="setGraphicLogo<?php echo $rand; ?>(this)" id="<?php echo $this->get_field_id('graphic_logo'); ?>" name="<?php echo $this->get_field_name('graphic_logo'); ?>">
          <option <?php if ($graphic_logo == "") { print "selected"; } ?> value=""><?php _e('Disabled', "i3d-framework"); ?></option>
          <option <?php if ($graphic_logo == "default")  { print "selected"; } ?> value="default"><?php _e('Default', "i3d-framework"); ?></option>
     	  <option <?php if ($graphic_logo != "default" && $graphic_logo != "")   { print "selected"; } ?> value="custom"><?php _e('Custom', "i3d-framework"); ?></option>
        </select>
        <input type="hidden" id="<?php echo $this->get_field_id('actual_graphic_logo'); ?>" name="<?php echo $this->get_field_name('actual_graphic_logo'); ?>" value="<?php if ($graphic_logo != "" && $graphic_logo != "default")   { print $graphic_logo; } ?>" />
		<?php
		 if ($graphic_logo != "" && $graphic_logo != "default") {
			$metaData = get_post_meta($graphic_logo, '_wp_attachment_metadata', true);
            $fileName = site_url().'/wp-content/uploads/'.$metaData['file']; 
		 } else {
			 $fileName = "";
		 }
        ?>
	   <div class="special_image_placeholder_wrapper" <?php if ($graphic_logo == "" || $graphic_logo == "default") { print 'style="display: none;"'; } ?>>
	   <div id="special_image_placeholder_<?php echo $rand; ?>" class="special_image_placeholder" >
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
       <input type='button' id="image_upload_button_<?php echo $rand; ?>" class='button button-primary' value="<?php _e("Choose or Upload Image", "i3d-framework"); ?>" />
	   </center>
	   </div>
<script>
var file_frame<?php echo $rand; ?>;
jQuery('#image_upload_button_<?php echo $rand; ?>').live('click', function( event ){
 
	event.preventDefault();
	// If the media frame already exists, reopen it.
	//if ( typeof pagetype !== 'undefined'  ) {
	//	file_frame<?php echo $rand; ?>.open();
	//	return;
	//}
	// Create the media frame.
	file_frame<?php echo $rand; ?> = wp.media.frames.file_frame = wp.media({
		title: jQuery( this ).data( 'uploader_title' ),
		button: {
			text: jQuery( this ).data( 'uploader_button_text' ),
		},
		multiple: false // Set to true to allow multiple files to be selected
	});
 
	// When an image is selected, run a callback.
	file_frame<?php echo $rand; ?>.on( 'select', function() {
		// We set multiple to false so only get one image from the uploader
		attachment = file_frame<?php echo $rand; ?>.state().get('selection').first().toJSON();
 		jQuery("#special_image_placeholder_<?php echo $rand; ?>").html("<img src='"+attachment.url+"' width='150px' />");
		jQuery("#<?php echo $this->get_field_id('actual_graphic_logo'); ?>").val(attachment.id);
	});
 
	// Finally, open the modal
	file_frame<?php echo $rand; ?>.open();
});
 </script> 
 
 </div>
 <div class='widget-section'>
        <div class='vector-icons'  <?php if ($graphic_logo != "") { print 'style="display: none;"'; } ?>>
        <!-- Font Awesome Icons --> 
        <label class='label-regular' for="<?php echo $this->get_field_id('vector_icon'); ?>"><?php _e('Vector Icon', "i3d-framework"); ?></label>
		<select onChange="setVectorIcon<?php echo $rand; ?>(this)"  id="<?php echo $this->get_field_id('vector_icon'); ?>" name="<?php echo $this->get_field_name('vector_icon'); ?>">
          <option <?php if ($font_awesome_icon == "") { print "selected"; } ?> value=""><?php _e('Disabled', "i3d-framework"); ?></option>
          <option <?php if ($font_awesome_icon == "global")  { print "selected"; } ?> value="global"><?php _e('Default', "i3d-framework"); ?></option>
     	  <option <?php if ($font_awesome_icon != "" && $font_awesome_icon != "global")   { print "selected"; } ?> value="custom"><?php _e('Custom', "i3d-framework"); ?></option>
        </select> 
		<?php //echo $font_awesome_icon; ?>
     <!--   <input type="hidden" id="<?php echo $this->get_field_id('font_awesome_icon'); ?>" name="<?php echo $this->get_field_name('font_awesome_icon'); ?>" value="<?php if ($font_awesome_icon != "" && $font_awesome_icon != "default")   { print $font_awesome_icon; } ?>" />-->
		<div class='available-fontawesome-icons'  style='vertical-align: top; <?php if ($font_awesome_icon == "" || $font_awesome_icon == "global") { print 'display: none;'; } else { print "display: inline-block;"; } ?>'>
                  	<?php I3D_Framework::renderFontAwesomeSelect($this->get_field_name('font_awesome_icon'), @$font_awesome_icon); ?>

		  
		  <?php /* foreach ($fontAwesomeIcons as $icon) { ?>
          <div class='font-awesome-icon <?php if ($icon == $font_awesome_icon) { print "font-awesome-icon-selected"; } ?>' onclick='setFontAwesomeIcon(this, "<?php print $icon; ?>")'><i class='icon-<?php echo $icon; ?>'></i></div>
          <?php } */ ?>
        </div>
        </div>
       <script>
	   function selectGraphicLogo<?php echo $rand; ?>(div, imageID) {
		 jQuery(div).parent().find("div").removeClass("graphic-logo-image-selected");
		 jQuery(div).addClass("graphic-logo-image-selected");
		 jQuery(div).parent().parent().find("#<?php echo $this->get_field_id('actual_graphic_logo'); ?>").val(imageID);
	   }
	   function setFontAwesomeIcon(div, icon) {
		 jQuery(div).parent().find("div").removeClass("font-awesome-icon-selected");
		 jQuery(div).addClass("font-awesome-icon-selected");
		 //alert(jQuery(div).parent().parent().html());
		 jQuery(div).parent().parent().find("#<?php echo $this->get_field_id('font_awesome_icon'); ?>").val(icon);
	   }
	   
	   function setGraphicLogo<?php echo $rand; ?>(selectBox) {
		  if (selectBox.selectedIndex == 0) {
			 jQuery(selectBox).parent().parent().find("div.vector-icons").css("display", "block");  
			 jQuery(selectBox).parent().parent().find("div.special_image_placeholder_wrapper").css("display", "none");  
		  } else if (selectBox.selectedIndex == 1) {
			 jQuery(selectBox).parent().parent().find("div.vector-icons").css("display", "none");  
			 jQuery(selectBox).parent().parent().find("div.special_image_placeholder_wrapper").css("display", "none");  
		  } else {
			 jQuery(selectBox).parent().parent().find("div.vector-icons").css("display", "none");  
			 jQuery(selectBox).parent().parent().find("div.special_image_placeholder_wrapper").css("display", "block");  
		  }
	   }

		function setVectorIcon<?php echo $rand; ?>(selectBox) {
		  if (selectBox.selectedIndex == 2) {
			 jQuery(selectBox).parent().parent().find("div.available-fontawesome-icons").css("display", "inline-block");  
		  } else {
			 jQuery(selectBox).parent().parent().find("div.available-fontawesome-icons").css("display", "none");  
		  }
	   }
	   function setWebsiteName<?php echo $rand; ?>(selectBox) {
		  if (selectBox.selectedIndex == 2) {
			 jQuery(selectBox).parent().parent().find("div.website-name-custom").css("display", "block");  
		  } else {
			 jQuery(selectBox).parent().parent().find("div.website-name-custom").css("display", "none");  
		  }
	   }

	   function setLink<?php echo $rand; ?>(selectBox) {
		  if (selectBox.selectedIndex == 2) {
			 jQuery(selectBox).parent().parent().find("div.link-custom").css("display", "block");  
		  } else {
			 jQuery(selectBox).parent().parent().find("div.link-custom").css("display", "none");  
		  }
	   }

function setTagline<?php echo $rand; ?>(selectBox) {
		  if (selectBox.selectedIndex == 2) {
			 jQuery(selectBox).parent().parent().find("div.tagline-custom").css("display", "block");  
		  } else {
			 jQuery(selectBox).parent().parent().find("div.tagline-custom").css("display", "none");  
		  }
	   }	   
	   </script>
       </div>
	   <div class='widget-section'>
        <!-- Text -->
        <label class='label-regular' for="<?php echo $this->get_field_id('website_name'); ?>"><?php _e('Website Name', "i3d-framework"); ?></label>
		<select onChange="setWebsiteName<?php echo $rand; ?>(this)"  id="<?php echo $this->get_field_id('website_name'); ?>" name="<?php echo $this->get_field_name('website_name'); ?>">
          <option <?php if ($website_name == "disabled") { print "selected"; } ?> value="disabled"><?php _e('Disabled', "i3d-framework"); ?></option>
          <option <?php if ($website_name == "default")  { print "selected"; } ?> value="default"><?php _e('Default', "i3d-framework"); ?></option>
     	  <option <?php if ($website_name == "custom")   { print "selected"; } ?> value="custom"><?php _e('Custom', "i3d-framework"); ?></option>
        </select>        
         
         <div class="website-name-custom" <?php if ($website_name != "custom") { print 'style="display: none;"'; } ?>>
 		 <input  id="<?php echo $this->get_field_id('text_1'); ?>" name="<?php echo $this->get_field_name('text_1'); ?>" type="text" value="<?php echo esc_attr($text_1); ?>" placeholder="<?php _e("Website Name", "i3d-framework"); ?>" />
         <?php if ($i3dTextLogoLines == 2) { ?>
 		 <input  id="<?php echo $this->get_field_id('text_2'); ?>" name="<?php echo $this->get_field_name('text_2'); ?>" type="text" value="<?php echo esc_attr($text_2); ?>"  placeholder="<?php _e("Secondary Colored Text", "i3d-framework"); ?>"/> 
         <?php } ?>
        </div> 
          
        
</div>
<div class='widget-section'>
        <!-- tagline -->
        <!-- Text -->
        <label class='label-regular' for="<?php echo $this->get_field_id('tagline_setting'); ?>"><?php _e('Tagline', "i3d-framework"); ?></label>
		<select onChange="setTagline<?php echo $rand; ?>(this)"  id="<?php echo $this->get_field_id('tagline_setting'); ?>" name="<?php echo $this->get_field_name('tagline_setting'); ?>">
          <option <?php if ($tagline_setting == "") { print "selected"; } ?> value=""><?php _e('Disabled', "i3d-framework"); ?></option>
          <option <?php if ($tagline_setting == "default")  { print "selected"; } ?> value="default"><?php _e('Default', "i3d-framework"); ?></option>
     	  <option <?php if ($tagline_setting == "custom")   { print "selected"; } ?> value="custom"><?php _e('Custom', "i3d-framework"); ?></option>
        </select>
         <div class="tagline-custom" <?php if ($tagline_setting != "custom") { print 'style="display: none;"'; } ?>>
                
 		<input id="<?php echo $this->get_field_id('tagline'); ?>" name="<?php echo $this->get_field_name('tagline'); ?>" type="text" value="<?php echo esc_attr($tagline); ?>" placeholder="<?php _e("Custom Tagline", "i3d-framework"); ?>" /> 
        </div>
        </div>
		
<div class='widget-section'>       
        <!-- Text -->
        <label class='label-regular' for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Link', "i3d-framework"); ?></label>
		<select onChange="setLink<?php echo $rand; ?>(this)"  id="<?php echo $this->get_field_id('link'); ?>" name="<?php echo $this->get_field_name('link'); ?>">
          <option <?php if ($link == "default")  { print "selected"; } ?> value="default"><?php _e('Default', "i3d-framework"); ?></option>
          <option <?php if ($link == "disabled") { print "selected"; } ?> value="disabled"><?php _e('Disabled', "i3d-framework"); ?></option>
     	  <option <?php if ($link == "custom")   { print "selected"; } ?> value="custom"><?php _e('Custom', "i3d-framework"); ?></option>
        </select>        
         
         <div class="link-custom" <?php if ($link != "custom") { print 'style="display: none;"'; } ?>>
 		 <input  id="<?php echo $this->get_field_id('link_custom'); ?>" name="<?php echo $this->get_field_name('link_custom'); ?>" type="url" value="<?php echo esc_attr($link_custom); ?>" placeholder="<?php _e("http://somewebsite.com/", "i3d-framework"); ?>" />

        </div> 
		</div>
		
<div class='widget-section'>
	<div class='widget-column-33'>
        <!-- justification -->
        <label class='label-regular' for="<?php echo $this->get_field_id('justification'); ?>"><?php _e('Justification', "i3d-framework"); ?></label>
		<select style='width: 89%' id="<?php echo $this->get_field_id('justification'); ?>" name="<?php echo $this->get_field_name('justification'); ?>">
          <option <?php if ($justification == "left") { print "selected"; } ?> value="left"><?php _e('Left', "i3d-framework"); ?></option>
          <option <?php if ($justification == "center") { print "selected"; } ?> value="center"><?php _e('Center', "i3d-framework"); ?></option>
     	  <option <?php if ($justification == "right") { print "selected"; } ?> value="right"><?php _e('Right', "i3d-framework"); ?></option>
        </select> 
        </div>
	<?php if (sizeof(I3D_Framework::$logoStyles) > 0) { ?>
	<div class='widget-column-33'>
        <!-- justification -->
        <label class='label-regular' for="<?php echo $this->get_field_id('style'); ?>"><?php _e('Style', "i3d-framework"); ?></label>
		<select  style='width: 89%' id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>">
		<?php foreach (I3D_Framework::$logoStyles as $key => $value) { ?>
          <option <?php if ($instance['style'] == $key) { print "selected"; } ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
        <?php } ?>
        </select> 
        </div>	
	<?php  } ?>
		</div>
		
		</div></div>       

<?php
	}
}


?>