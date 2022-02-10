<?php

/***********************************/
/**        Image WIDGET        **/
/***********************************/
class I3D_Widget_Image extends WP_Widget {
	function __construct() {
	//function I3D_Widget_Image() {
		$widget_ops = array('classname' => 'widget_text', 'description' => __( 'Renders a an image with optional link.', "i3d-framework") );
		parent::__construct('i3d_image', __('i3d:Image', "i3d-framework"), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );
		$instance = wp_parse_args( (array) $instance, array( 'thumbnail_background_color' => '',
															 'thumbnail_mask_aspect' => '',
															 'thumbnail_mask' => '',
															 'margin' => '',
															 'image' => '',
															 'link_url' => '',
															 'link_target' => '',
															 'justification' => '',
															 'thumbnail_background_padding' => '',
															 'thumbnail_border_radius' => '',
															 'thumbnail_border_color' => '', 
															 'thumbnail_hover_transition_time' => '',
															 'thumbnail_icon_effect' => '',
															 'thumbnail_hover_color_alpha' => '',
															 'thumbnail_hover_color' => '',
															 'thumbnail_hover_icon' => '') );
		
		$rand = rand();
	    if ($instance['thumbnail_mask'] != "") {
			wp_enqueue_script( 'aquila-mask-js',    get_stylesheet_directory_uri()."/Site/javascript/mask.js", array('jquery'), '1.0', true );

		}		

		$imageID = $instance['image'];
		$link_url = $instance['link_url'];
		$link_target = $instance['link_target'];
		$margin = $instance['margin'];

		$justification = $instance['justification'];
		
                        $metaData = get_post_meta($imageID, '_wp_attachment_metadata', true);
                        $fileName = site_url().'/wp-content/uploads/'.$metaData['file']; 
		
		echo $before_widget;
		
		$maskData = "";
		$maskURL = "";
		$mask = "";
		$maskType = "";
		if ($instance['thumbnail_mask'] != "") {
			$mask = $instance['thumbnail_mask'];
			$maskData = "data-mask='".get_stylesheet_directory_uri()."/Site/graphics/masks/{$mask}.png' class='special-mask i3d-widget-image'";
		    $maskURL = get_stylesheet_directory_uri()."/includes/user_view/flickr.php?f=";
			$maskType = $instance['thumbnail_mask_aspect'];
		} else {
			$maskData = "class='i3d-widget-image'";
		}

		if ($imageID != "") {
			?>
   <style>
#image-wrapper-<?php echo $rand; ?> div.outer { 
background-color: rgba(<?php echo I3D_Framework::hex2RGB($instance['thumbnail_background_color'], true); ?>, <?php echo @$instance['thumbnail_background_transparency']; ?>);
padding: <?php echo $instance['thumbnail_background_padding']; ?> !important; 

	border-radius: <?php echo $instance['thumbnail_border_radius']; ?>;
	-moz-border-radius: <?php echo $instance['thumbnail_border_radius']; ?>;
	-webkit-border-radius: <?php echo $instance['thumbnail_border_radius']; ?>;
<?php if ($mask == "" && false) { ?>	border: 1px solid transparent; <?php } ?>

}

#image-wrapper-<?php echo $rand; ?> img { 
 /*  position: absolute;*/
   <?php if ($instance['thumbnail_border_radius'] != "") { ?>
	border-radius: <?php echo $instance['thumbnail_border_radius']; ?>;
	-moz-border-radius: <?php echo $instance['thumbnail_border_radius']; ?>;
	-webkit-border-radius: <?php echo $instance['thumbnail_border_radius']; ?>;
	<?php } ?>
	<?php if ($mask == "" && false) { ?> border: 1px solid <?php echo $instance['thumbnail_border_color']; ?>;<?php } ?>
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
	border-radius: <?php echo $instance['thumbnail_border_radius']; ?>;
	-moz-border-radius: <?php echo $instance['thumbnail_border_radius']; ?>;
	-webkit-border-radius: <?php echo $instance['thumbnail_border_radius']; ?>;
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
		  if ($instance['thumbnail_hover_icon'] == "") {
		    if ($link_url != "") {
		    			  echo "<a href='{$link_url}'";
		    			  if ($link_target != "") {
		    				  echo " target='{$link_target}'";
		    			  }
		    			  echo ">";
		    
		  }
		  }
		  echo "<div id='image-wrapper-{$rand}' class='i3d-widget-image-wrapper {$maskType}";
		  if ($justification == "right") {
			  echo " pull-right text-right";
		  } else if ($justification == "center") {
			  echo " text-center";
		  } else {
			  echo " text-left";
		  }
		  if ($mask != "") { echo " special-mask-container"; } 
		  
		  echo "'";
		  
		  if ($margin != "") {
			  echo " style='margin: {$margin}'";
		  }
		  echo ">";
		  echo "<div class='outer'><div class='inner'>";
		  
		  echo "<img {$maskData} src='{$fileName}' />";
		  if ($link_url != "" && $instance['thumbnail_hover_icon'] != "") {
			  echo "<a href='{$link_url}'";
			  if ($link_target != "") {
				  echo " target='{$link_target}'";
			  }
			  echo "><i class='fa {$instance['thumbnail_hover_icon']}'></i>";

			  echo "</a>";
		  }
		  echo "</div>";
		  echo "</div>";
		  echo "</div>";
		    if ($instance['thumbnail_hover_icon'] == "") {
		  		    if ($link_url != "") {
		  		    		
		  		    
		  		    			  echo "</a>";
		  		  }
		  }
		}
		
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['justification'] = strip_tags($new_instance['justification']);
		$instance['link_target'] = strip_tags( $new_instance['link_target'] ); 
		$instance['link_url'] = strip_tags( $new_instance['link_url'] ); 
		$instance['image'] = strip_tags( $new_instance['image'] ); 
		$instance['margin'] = strip_tags( $new_instance['margin'] ); 
		$instance['thumbnail_mask'] 	= $new_instance['thumbnail_mask']; 
		$instance['thumbnail_mask_aspect'] 	= $new_instance['thumbnail_mask_aspect']; 
		$instance['thumbnail_background_color'] 	= $new_instance['thumbnail_background_color']; 
		$instance['thumbnail_background_padding'] 	= $new_instance['thumbnail_background_padding']; 
		$instance['thumbnail_background_transparency'] 	= $new_instance['thumbnail_background_transparency']; 
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
				$instance = wp_parse_args( (array) $instance, array( 'thumbnail_background_color' => '',
															 'thumbnail_mask_aspect' => '',
															 'thumbnail_mask' => '',
															 'margin' => '',
															 'image' => '',
															 'link_url' => '',
															 'link_target' => '',
															 'justification' => '',
															 'thumbnail_background_padding' => '',
															 'thumbnail_background_transparency' => '0.0',
															 'thumbnail_border_radius' => '',
															 'thumbnail_border_color' => '', 
															 'thumbnail_hover_transition_time' => '',
															 'thumbnail_icon_effect' => '',
															 'thumbnail_hover_color_alpha' => '',
															 'thumbnail_hover_color' => '',
															 'thumbnail_hover_icon' => '') );

		//$instance = wp_parse_args( (array) $instance, array( 'show_icon' => '1', 'justification' => 'left', 'text' => '' ) );
		$justification = strip_tags($instance['justification']);
		$link_target = strip_tags($instance['link_target']);
		$link_url = strip_tags($instance['link_url']);
		$image = strip_tags($instance['image']);
		$margin = strip_tags($instance['margin']);
		$random = rand();
		$rand = $random;

		$borderRadii   	= array("1px", "2px", "3px", "4px", "5px", "10px", "15px", "1%", "2%", "3%", "4%", "5%", "10%", "15%");
		$padding	 	= array("1px", "2px", "3px", "4px", "5px", "10px", "15px", "1%", "2%", "3%", "4%", "5%", "10%", "15%");

?>
<script>
	function setMaskOptions<?php echo $rand; ?>(selectBox) {
	  if (selectBox.options[selectBox.selectedIndex].value == "") {
		jQuery("#image-mask-options-<?php echo $rand; ?>").css("display", "none");  
	  } else {
		jQuery("#image-mask-options-<?php echo $rand; ?>").css("display", "inline-block");  
		  
	  }
	}	
</script>
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
	.special_image_placeholder {  min-height: 100px; text-align: center; padding: 7px; }

	.special_image_placeholder img { width: 150px; height: auto; border-radius: 5px; -webkit-border-radius: 5px; -moz-border-radius: 5px; }
	
	
	</style>
<div class='i3d-widget-container image-widget-editor'>
    <div class='i3d-help-region'>
    <div class='i3d-help-region-closed'><div class='i3d-help-title-bar'><a target="_blank" href="http://www.youtube.com/watch?v=XcJnY-NYx3Q"><i class='icon-youtube-play'></i> Watch Help Video &nbsp;  <i  class='icon-external-link'></i></a></div></div>

    </div>
<div class=''>
        <h3>Image</h3>

        <input type="hidden" id="<?php echo $random."__image"; ?>" name="<?php echo $this->get_field_name('image'); ?>" value="<?php echo $image ?>" />
		
		<?php
		 if ($image != "") {
			$metaData = get_post_meta($image, '_wp_attachment_metadata', true);
            $fileName = site_url().'/wp-content/uploads/'.$metaData['file']; 
		 } else {
			 $fileName = "";
		 }
        ?>
	   <div id="special_image_placeholder_<?php echo $rand; ?>" class="special_image_placeholder">
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
<script>
var file_frame;
jQuery('#image_upload_button_<?php echo $rand; ?>').live('click', function( event ){
 
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
 		jQuery("#special_image_placeholder_<?php echo $rand; ?>").html("<img src='"+attachment.url+"' width='150px' />");
		jQuery("#<?php echo $random?>__image").val(attachment.id);
	});
 
	// Finally, open the modal
	file_frame.open();
});
 </script>

        <h3>Basic Image Display</h3>

        <div class='image-editor-50'>
<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Margin',"i3d-framework"); ?></label>
		<input  class="widefat" id="<?php echo $this->get_field_id('margin'); ?>" name="<?php echo $this->get_field_name('margin'); ?>" type="text" placeholder="0px 0px 0px 0px" value="<?php echo $margin; ?>" /></p>
</div>
        <div class='image-editor-50'>
        <!-- justification -->
        <label for="<?php echo $this->get_field_id('justification'); ?>"><?php _e('Justification',"i3d-framework"); ?></label>
		<select  id="<?php echo $this->get_field_id('justification'); ?>" name="<?php echo $this->get_field_name('justification'); ?>">
          <option <?php if ($justification == "left") { print "selected"; } ?> value="left"><?php _e('Left',"i3d-framework"); ?></option>
          <option <?php if ($justification == "center") { print "selected"; } ?> value="center"><?php _e('Center',"i3d-framework"); ?></option>
     	  <option <?php if ($justification == "right") { print "selected"; } ?> value="right"><?php _e('Right',"i3d-framework"); ?></option>
        </select> 
        </div>
       
        <script>
	   function selectImage<?php echo $random; ?>(div, imageID) {
		 jQuery(div).parent().find("div").removeClass("graphic-logo-image-selected");
		 jQuery(div).addClass("graphic-logo-image-selected");
		 jQuery(div).parent().parent().find("#<?php echo $random."__image"; ?>").val(imageID);
	   }
            
			</script>
            
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
        <div class='image-editor-50' id='image-mask-options-<?php echo $rand; ?>' <?php if ($instance['thumbnail_mask'] == "") { echo "style='display: none;'"; }?>>
  		<label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_mask_aspect'); ?>"><?php _e('Aspect Ratio',"i3d-framework"); ?></label><br/>        
		<select  style='width: 98%' id="<?php echo $this->get_field_id('thumbnail_mask_aspect'); ?>" name="<?php echo $this->get_field_name('thumbnail_mask_aspect'); ?>">
          <option  <?php if ($instance['thumbnail_mask_aspect'] == "crop") { print "selected"; } ?> value="crop">Mask A/R  (Crop Image)</option>
          <option  <?php if ($instance['thumbnail_mask_aspect'] == "stretch") { print "selected"; } ?> value="stretch">Image A/R (Stretch Mask)</option>
        </select>         
       
        </div> 
  		<br/>
        <div class='image-editor-33'>
        <label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_background_color'); ?>"><?php _e('BG Color',"i3d-framework"); ?></label><br/>        
		<input style='width: 60px;' type='color' id="<?php echo $this->get_field_id('thumbnail_background_color'); ?>" name="<?php echo $this->get_field_name('thumbnail_background_color'); ?>" value="<?php echo $instance['thumbnail_background_color']; ?>">
  		</div>

        <div class='image-editor-33'>
        <label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_background_transparency'); ?>"><?php _e('BG Trans',"i3d-framework"); ?></label><br/>        
		<select  style='width: 98%' id="<?php echo $this->get_field_id('thumbnail_background_transparency'); ?>" name="<?php echo $this->get_field_name('thumbnail_background_transparency'); ?>">
          <option  <?php if ($instance['thumbnail_background_transparency'] == "0") { print "selected"; } ?> value="0.0">100%</option>
          <option  <?php if ($instance['thumbnail_background_transparency'] == "0.25") { print "selected"; } ?> value="0.25">75%</option>
          <option  <?php if ($instance['thumbnail_background_transparency'] == "0.50") { print "selected"; } ?> value="0.50">50%</option>
          <option  <?php if ($instance['thumbnail_background_transparency'] == "0.75") { print "selected"; } ?> value="0.75">25%</option>
          <option  <?php if ($instance['thumbnail_background_transparency'] == "1") { print "selected"; } ?> value="1.0">0%</option>
         </select>    		
  		</div>
				
        <div class='image-editor-33'>
         <label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_background_padding'); ?>"><?php _e('BG Padding',"i3d-framework"); ?></label><br/>
		<select style='width: 75px;' id="<?php echo $this->get_field_id('thumbnail_background_padding'); ?>" name="<?php echo $this->get_field_name('thumbnail_background_padding'); ?>">
          <option value="">None</option>
          <?php foreach ($padding as $pad) { ?>
          <option <?php if ($instance['thumbnail_background_padding'] == $pad) { print "selected"; } ?> value="<?php echo $pad; ?>"><?php echo $pad; ?></option>
          <?php } ?>
        </select>    
   		</div>
        
   		<div class='image-editor-33' style='display: none'>
        <label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_border_color'); ?>"><?php _e('Border Color',"i3d-framework"); ?></label><br/>        
		<input style='width: 60px;' type='color' id="<?php echo $this->get_field_id('thumbnail_border_color'); ?>" name="<?php echo $this->get_field_name('thumbnail_border_color'); ?>" value="<?php echo $instance['thumbnail_border_color']; ?>">
        </div>       
        
        <div class='image-editor-33'>
        <label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_border_radius'); ?>"><?php _e('Border Radius',"i3d-framework"); ?></label><br/>
		<select style='width: 75px;' id="<?php echo $this->get_field_id('thumbnail_border_radius'); ?>" name="<?php echo $this->get_field_name('thumbnail_border_radius'); ?>">
          <option value="">None</option>
          <?php foreach ($borderRadii as $radius) { ?>
          <option <?php if ($instance['thumbnail_border_radius'] == $radius) { print "selected"; } ?> value="<?php echo $radius; ?>"><?php echo $radius; ?></option>
          <?php } ?>
        </select>         
        </div>

        <br/>
        <h3>Link</h3>
        <div class='image-editor-66'>
        <label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('URL',"i3d-framework"); ?></label><br/> 
                <input class="widefat" id="<?php echo $this->get_field_id('link_url'); ?>" name="<?php echo $this->get_field_name('link_url'); ?>" type="url" value="<?php echo $link_url; ?>" /></p>
        </div>

        <div class='image-editor-33'><label for="<?php echo $this->get_field_id('link_target'); ?>"><?php _e('Open In',"i3d-framework"); ?></label>  <br/>      
		<select style='width: 120px; padding: 4px; line-height: 30px; height: 30px;' id="<?php echo $this->get_field_id('link_target'); ?>" name="<?php echo $this->get_field_name('link_target'); ?>">
           <option <?php if ($instance['link_target'] == '') { print "selected"; } ?> value="">Same Window</option>
         <option <?php if ($instance['link_target'] == '_blank') { print "selected"; } ?> value="_blank">New Window</option>
        </select>         
    
        </div>
        
        <div class='image-editor-33'>
        <label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_hover_color'); ?>"><?php _e('Hover Color',"i3d-framework"); ?></label><br/>        
		<input style='width: 60px;' type='color' id="<?php echo $this->get_field_id('thumbnail_hover_color'); ?>" name="<?php echo $this->get_field_name('thumbnail_hover_color'); ?>" value="<?php echo $instance['thumbnail_hover_color']; ?>">
  		</div>
        
        <div class='image-editor-33'>
        <label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_hover_color_alpha'); ?>"><?php _e('Hover Alpha',"i3d-framework"); ?></label><br/>
		<select style='width: 75px;' id="<?php echo $this->get_field_id('thumbnail_hover_color_alpha'); ?>" name="<?php echo $this->get_field_name('thumbnail_hover_color_alpha'); ?>">
          <option value="0">0%</option>
          <option <?php if ($instance['thumbnail_hover_color_alpha'] == ".10") { print "selected"; } ?> value=".10">10%</option>
          <option <?php if ($instance['thumbnail_hover_color_alpha'] == ".25") { print "selected"; } ?> value=".25">25%</option>
          <option <?php if ($instance['thumbnail_hover_color_alpha'] == ".50") { print "selected"; } ?> value=".5">50%</option>
          <option <?php if ($instance['thumbnail_hover_color_alpha'] == ".75") { print "selected"; } ?> value=".75">75%</option>
          <option <?php if ($instance['thumbnail_hover_color_alpha'] == ".90") { print "selected"; } ?> value=".90">90%</option>
          <option <?php if ($instance['thumbnail_hover_color_alpha'] == "1.0") { print "selected"; } ?> value="1.0">100%</option>
        </select>         
  		</div>
        <div class='image-editor-33'>
        <label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_hover_transition_time'); ?>"><?php _e('Effect Time',"i3d-framework"); ?></label><br/>
		<select style='width: 75px;' id="<?php echo $this->get_field_id('thumbnail_hover_transition_time'); ?>" name="<?php echo $this->get_field_name('thumbnail_hover_transition_time'); ?>">
          <option value=".25">.25 second</option>
          <option <?php if ($instance['thumbnail_hover_transition_time'] == ".5") { print "selected"; } ?> value=".5">.5s</option>
          <option <?php if ($instance['thumbnail_hover_transition_time'] == ".75") { print "selected"; } ?> value=".75">.75s</option>
          <option <?php if ($instance['thumbnail_hover_transition_time'] == "1") { print "selected"; } ?> value="1">1 second</option>
          <option <?php if ($instance['thumbnail_hover_transition_time'] == "1.25") { print "selected"; } ?> value="1.25">1.25s</option>
          <option <?php if ($instance['thumbnail_hover_transition_time'] == "1.5") { print "selected"; } ?> value="1.5">1.5s</option>
          <option <?php if ($instance['thumbnail_hover_transition_time'] == "1.75") { print "selected"; } ?> value="1.75">1.75s</option>
          <option <?php if ($instance['thumbnail_hover_transition_time'] == "2.0") { print "selected"; } ?> value="2">2s</option>
        </select>         
  		</div>

        <div class='image-editor-33'>
              <label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_hover_icon'); ?>"><?php _e('Hover Icon',"i3d-framework"); ?></label><br/>        
        <?php I3D_Framework::renderFontAwesomeSelect($this->get_field_name('thumbnail_hover_icon'), $instance['thumbnail_hover_icon'], false, '-- None --', '-- None -- '); ?>
  		</div>
        
        <div class='image-editor-33'>
        <label style='padding-top: 10px;' for="<?php echo $this->get_field_id('thumbnail_icon_effect'); ?>"><?php _e('Icon Effect',"i3d-framework"); ?></label><br/>
		<select style='width: 75px;' id="<?php echo $this->get_field_id('thumbnail_icon_effect'); ?>" name="<?php echo $this->get_field_name('thumbnail_icon_effect'); ?>">
          <option value="">None</option>
          <option <?php if ($instance['thumbnail_icon_effect'] == "spin") { print "selected"; } ?> value="spin">Spin</option>
        </select>         
  		</div>
  		<br/>

            
            </div>
            </div>
<?php
	}
}


?>