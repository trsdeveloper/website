<?php
global $post, $columnSelectedId, $lmTemplates, $lmColumns, $defaultTemplate, $lmNivoVersion, $templateName;

 if (I3D_Framework::$headerBGSupport) { 
?>


<?php } ?>
<div class='tab-pane special-region non-visible intro home default advanced blog contact faqs sitemap team-members under-construction events-calendar' id="tabs-header">
<div class='well'>
  <h4>Header Background</h4>
  <p>Specify an image to use in header background.  If no image is specified, then the global setting for the site will be used.</p>
 <ul>
                                    <li>

										<div style='height: 80px;'>

            
											<?php
											$random = rand();
                                            if(wp_attachment_is_image(get_post_meta($post->ID, 'header_bg_image', true))) {
                                                $metaData = get_post_meta(get_post_meta($post->ID, 'header_bg_image', true), '_wp_attachment_metadata', true);
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
	   <input type="hidden" id="header_bg_filename" name="__i3d_header_bg_image" value="<?php echo get_post_meta($post->ID, 'header_bg_image', true); ?>" />

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
</div>

</div>