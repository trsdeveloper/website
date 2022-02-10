<?php
function luckymarble_admin_themed_image() {
	global $wpdb, $lmTemplates, $lmColumns;
		
	if(array_key_exists("cmd", $_POST) && $_POST['cmd'] == "save") {
		$positions = array();
		
		foreach($lmTemplates as $template) {
			$templateName = $template['template-name'];
			$templateID = $template['template-folder'];
			$positions[$templateID] = array('top' => $_POST[$templateID.'_top'], 'left' => $_POST[$templateID.'_left']);
		}
	
		update_option('luckymarble_themed_image', array('enabled' => isset($_POST['status']), 'image_id' => $_POST['image'], 'position' => $positions));		
	}	
	$imageOptions = "";
	?>
	<style>
	#select_custom_image {margin: 0px 0x 0px 10px; border: 1px dashed #ccc; padding: 5px;}
	#select_custom_image p {margin: 0px 0px 10px 0px; padding: 0px; font-style: italic;}
	.selected_image {border: 1px solid #999; padding: 10px; background: #fff;}
	</style>
	<div class="wrap">
		<?php 
		I3D_Framework::render_dashboardManager("small", "themed_image");
		I3D_Framework::i3d_screen_icon('themed_image'); 

	    $customLogoProperties = get_option('luckymarble_themed_image');

		
	   
		?>
		<h2>Themed Image</h2>
		<p style="font-style: italic;">The themed image is a transparent PNG image. Transparent meaning the edges of the image are clean, revealing the background of the page, or the image is partially 'transparent' and the image fades into the page background behind it.  If you would like to display a themed image on your website please check the checkbox below and enter the details for your themed image.</p>
		<br />
		<form method="post">
			<input type="checkbox" name="status" id="custom_logo_status" value="1" onclick="check_status(this)" <?php if($customLogoProperties['enabled'] == true) { echo 'checked="checked"'; }?> /> <label for="custom_logo_status">Display a themed image.</label>
			<br /><br />
			<div id="select_custom_image" <?php if(!$customLogoProperties['enabled']) { echo 'style="display: none;"'; }?>>
			<p>Select the image you would like to use for your themed image.  If you have not uploaded your themed image yet, <a href="../content/media-new.php">please click here</a> to proceed to the image upload page.</p>
			<label for="custom_themed_file">Themed Image:</label> <select name="image" id="custom_themed_file" onchange="change_selected_image(this)">
				<option value=''>- SELECT -</option>
			<?php
			$images = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type='attachment' AND (post_mime_type='image/png' OR post_mime_type='image/jpeg' OR post_mime_type='image/gif') ORDER BY post_title"));

			foreach($images as $image) {
			//substr($image->guid,(strpos($image->guid,"/uploads/") +1))
			//$image->ID.'\',\''.$imagePath.'\',\''.$image->post_title.'\',\''.$image->post_excerpt.'\',\''.$image->post_content
				if($customLogoProperties['image_id'] == $image->ID) {
					echo '<option value="'.$image->ID.'" selected="selected">'.$image->post_title.'</option>';
				} else {
					echo '<option value="'.$image->ID.'">'.$image->post_title.'</option>';
				}
				
				$imageOptions .= 'userImages['.$image->ID.'] = "'.site_url() ."/wp-content/".substr($image->guid,(strpos($image->guid,"/uploads/") +1)).'";'."\n";
			}
			?>
			</select>
			<h3>Image Preview</h3>
			<?php
			if(wp_attachment_is_image($customLogoProperties['image_id'])) {
				$metaData = get_post_meta($customLogoProperties['image_id'], '_wp_attachment_metadata', true);
				$fileName = site_url().'/wp-content/uploads/'.$metaData['file'];			
			
				echo '<img src="'.$fileName.'" class="selected_image" id="selected_image" alt="selected image preview" />';				
			} else {
			?>
				<img src="<?php echo get_template_directory_uri() ; ?>/images/no_image_selected.png" class="selected_image" id="selected_image" alt="selected image preview" />
			<?php			
			}
			?>
			<h3>Positioning</h3>
			<?php
			foreach($lmTemplates as $template) {
				$templateName  = $template['template-name'];
				$templateID = $template['template-folder'];
			?>
				<h4>For '<?php echo $template['template-name']; ?>' template:</h4>
				<label for="<?php echo $template['template-folder']; ?>_top">Top:</label> <input type="text" style="width: 3em; text-align: right;" name="<?php echo $templateID; ?>_top" id="<?php echo $template['template-folder']; ?>_top" value="<?php echo (isset($customLogoProperties['position'][$templateID]['top']) ? $customLogoProperties['position'][$templateID]['top'] : 0); ?>" />px<br>
				<label for="<?php echo $template['template-folder']; ?>_left">Left:</label> <input type="text" style="width: 3em; text-align: right;" name="<?php echo $templateID; ?>_left" id="<?php echo $template['template-folder']; ?>_left" value="<?php echo (isset($customLogoProperties['position'][$templateID]['left']) ? $customLogoProperties['position'][$templateID]['left'] : 0); ?>" />px
			<?php
			}		
			?>
			</div>
			<input type="hidden" name="cmd" value="save" />
			<input type="submit" name="nocmd" class="button" value="Save Changes" />						
		</form>
	</div>
	<script>
	var userImages=new Array();
	<?php echo $imageOptions; ?>
	function change_selected_image(option) {
		document.getElementById("selected_image").src = userImages[option.value];
	}
	
	function check_status(el) {
		if(el.checked) {
			document.getElementById('select_custom_image').style.display='block';
		} else {
			document.getElementById('select_custom_image').style.display='none';
		}	
	}
	</script>	
	<?php
}
?>