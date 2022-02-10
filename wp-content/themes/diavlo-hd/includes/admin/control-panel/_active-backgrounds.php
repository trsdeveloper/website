<?php
function i3d_active_backgrounds() { 
 
  if (@$_GET['cmd'] == "reset") {
	update_option('i3d_active_backgrounds', array());
	wp_redirect(admin_url("admin.php?page=i3d_active_backgrounds"));
   } else if (@$_GET['cmd'] == "init") {
	  I3D_Framework::init_active_backgrounds(true);
	wp_redirect(admin_url("admin.php?page=i3d_active_backgrounds"));
 
  } else if (@$_GET['cmd'] == "new" && @$_POST['cmd2'] != __('Cancel', "i3d-framework")) {
	  i3d_create_active_background();
      return;
  } else if (@$_POST['cmd2'] == __('Cancel', "i3d-framework")) {
	  
	wp_redirect(admin_url("admin.php?page=i3d_active_backgrounds"));

  } else if (@$_GET['active_background'] != "") {
	if (@$_GET['action'] == "trash") {
	  $activeBackgrounds = get_option('i3d_active_backgrounds');
	  unset($activeBackgrounds[$_GET['active_background']]);
	  update_option('i3d_active_backgrounds', $activeBackgrounds);
	  wp_redirect(admin_url("admin.php?page=i3d_active_backgrounds"));

	} else {
	  i3d_active_background_editor($_GET['active_background']);
	  return;
	}
  } else if (@$_POST['active_background'] != "") {
	 // print "yes";
	  
	 i3d_content_group_editor(@$_POST['active_background']); 
	 return;
  }
  
  $activeBackgrounds = get_option('i3d_active_backgrounds');
  if (!is_array($activeBackgrounds)) {
	  $activeBackgrounds = array();
  }
  
  
?>
  <div class='wrap'>
  <h2>Active Backgrounds <a class="add-new-h2" href="admin.php?page=i3d_active_backgrounds&cmd=new">Add New</a></h2>
    <p>Active Backgrounds are user defined backgrounds which may be used for page widget regions.</p>

  <table cellspacing="0" class="wp-list-table widefat fixed posts">
	<thead>
	<tr>
		<th class="display-none manage-column column-cb check-column" id="cb" scope="col"><label for="cb-select-all-1" class="screen-reader-text">Select All</label><input type="checkbox" id="cb-select-all-1"></th>
        <th class="manage-column" id="title" scope="col"><span>Title</span></th>
    </tr>
	</thead>

	<tfoot>
	<tr>
		<th class="display-none manage-column column-cb check-column" id="cb" scope="col"><label for="cb-select-all-2" class="screen-reader-text">Select All</label><input type="checkbox" id="cb-select-all-1"></th>
        <th class="manage-column" id="title" scope="col"><span>Title</span></th>
    </tr>
	</tfoot>
	<tbody id="the-list">
<?php if (sizeof($activeBackgrounds) == 0) { ?>
  				<tr valign="top" class="slider-none hentry alternate" id="slider-none">
				<th class="display-none check-column" scope="row">
					
							</th>
						<td class="post-title page-title column-title" colspan="1">There are currently no Active Backgrounds created.  Click "add new" at the top of the page to create an Active Background.
</td>
		</tr>

<?php } 
//var_dump($sliders);
?>
<?php foreach ($activeBackgrounds as $activeBackground) { ?>
    
				<tr valign="top" class="slider-<?php echo $activeBackground['id']; ?> hentry alternate" id="slider-<?php echo $activeBackground['id']; ?>">
				<th class="display-none check-column" scope="row">
					<label for="cb-select-<?php echo $activeBackground['id']; ?>" class="screen-reader-text">Select <?php echo $activeBackground['title']; ?></label>
				<input type="checkbox" value="<?php echo $activeBackground['id']; ?>" name="slider[]" id="cb-select-<?php echo $activeBackground['id']; ?>">
							</th>
						<td class="post-title page-title column-title"><strong><a title="Edit '<?php echo $activeBackground['title']; ?>'" href="?page=i3d_active_backgrounds&active_background=<?php echo $activeBackground['id']; ?>&amp;action=edit" class="row-title"><?php echo $activeBackground['title']; ?></a></strong>
<div class="row-actions"><span class="edit"><a title="Edit this item" href="?page=i3d_active_backgrounds&active_background=<?php echo $activeBackground['id']; ?>&amp;action=edit">Edit</a> | </span><span class="trash"><a href="?page=i3d_active_backgrounds&active_background=<?php echo $activeBackground['id']; ?>&amp;action=trash" title="Delete this Background" class="submitdelete">Delete</a></span></div>
</td>
		</tr>
<?php } ?>        
		</tbody>
</table>

    </div>
    <?php
}

function i3d_create_active_background() {
 		 $activeBackgrounds = get_option('i3d_active_backgrounds');
		 $id = "ab_".I3D_Framework::get_unique_id("i3d_active_backgrounds");
		   $activeBackgrounds["{$id}"] = array('id' => $id,
									 'title' => "New Active Background",
									 'background_type' => "image",
									 'parallaxing' => "",
									 'fade' => "",
									 "bordered" => "",
									 'resources' => array('map' => array("zoom" => 12))
									 
								     );
		   
		   update_option('i3d_active_backgrounds', $activeBackgrounds);
		   wp_redirect(admin_url("admin.php?page=i3d_active_backgrounds&active_background={$id}&action=edit"));

		   
		   return;

  
}

function i3d_active_background_editor($activeBackgroundID) {
	global $wpdb;
	$activeBackgrounds = get_option('i3d_active_backgrounds');
	$activeBackground  = $activeBackgrounds["{$activeBackgroundID}"];
	// var_dump($_POST);
	if(array_key_exists("cmd", $_POST) && $_POST['cmd'] == "save") {
		$activeBackgrounds["{$activeBackgroundID}"]["title"]          = stripslashes($_POST['title']);
		$activeBackgrounds["{$activeBackgroundID}"]["background_type"]   = stripslashes($_POST['background_type']);
		$activeBackgrounds["{$activeBackgroundID}"]["background_visibility"]   = stripslashes(@$_POST['background_visibility']);
		$activeBackgrounds["{$activeBackgroundID}"]["background_desktop_min_height"]   = stripslashes(@$_POST['background_desktop_min_height']);
		$activeBackgrounds["{$activeBackgroundID}"]["background_mobile_min_height"]    = stripslashes(@$_POST['background_mobile_min_height']);
		$activeBackgrounds["{$activeBackgroundID}"]["parallaxing"]   = stripslashes($_POST['parallaxing']);
		$activeBackgrounds["{$activeBackgroundID}"]["bordered"]   = stripslashes(@$_POST['bordered']);
		$activeBackgrounds["{$activeBackgroundID}"]["cover"]   = stripslashes(@$_POST['cover']);
		$activeBackgrounds["{$activeBackgroundID}"]["fade"]   = $_POST['fade'];
		$activeBackgrounds["{$activeBackgroundID}"]["resources"]["image"]   = @$_POST['image__1'];
		$activeBackgrounds["{$activeBackgroundID}"]["resources"]["video"]   = @$_POST['video__1'];
		if (@$_POST['address__1'] != "") { 
			$latLong = i3d_get_latlng_from_google_maps(@$_POST['address__1']);
			$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['address']   = @$_POST['address__1'];
			$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['lat']   = @$latLong['lat'];
			$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['lng']   = @$latLong['lng'];
		} else {
			$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['address']   = "";
			$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['lat']   = @$_POST['lat__1'];
			$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['lng']   = @$_POST['lng__1'];
			
		}
		//var_dump($activeBackgrounds["{$activeBackgroundID}"]["resources"]);
		
		$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['zoom']   = @$_POST['zoom__1'];
		$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['poi']["visibility"]   			= @$_POST['map__poi__visibility'];
		$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['poi']["color"]   				= @$_POST['map__poi__color'];
		$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['poi']["lightness"]   			= @$_POST['map__poi__lightness'];
		$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['poi']["saturation"]   			= @$_POST['map__poi__saturation'];
		
		$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['water']["visibility"]   		= @$_POST['map__water__visibility'];
		$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['water']["color"]   			= @$_POST['map__water__color'];
		$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['water']["lightness"]   		= @$_POST['map__water__lightness'];
		$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['water']["saturation"]   		= @$_POST['map__water__saturation'];
		
		$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['landscape']["visibility"]   	= @$_POST['map__landscape__visibility'];
		$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['landscape']["color"]   		= @$_POST['map__landscape__color'];
		$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['landscape']["lightness"]   	= @$_POST['map__landscape__lightness'];
		$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['landscape']["saturation"]   	= @$_POST['map__landscape__saturation'];
		
		$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['road-highway']["visibility"]   = @$_POST['map__road-highway__visibility'];
		$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['road-highway']["color"]   		= @$_POST['map__road-highway__color'];
		$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['road-highway']["lightness"]   	= @$_POST['map__road-highway__lightness'];
		$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['road-highway']["saturation"]   = @$_POST['map__road-highway__saturation'];

		$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['road-arterial']["visibility"]   = @$_POST['map__road-arterial__visibility'];
		$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['road-arterial']["color"]   		= @$_POST['map__road-arterial__color'];
		$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['road-arterial']["lightness"]   	= @$_POST['map__road-arterial__lightness'];
		$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['road-arterial']["saturation"]   = @$_POST['map__road-arterial__saturation'];
		
		$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['road-local']["visibility"]   	= @$_POST['map__road-local__visibility'];
		$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['road-local']["color"]   		= @$_POST['map__road-local__color'];
		$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['road-local']["lightness"]   	= @$_POST['map__road-local__lightness'];
		$activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]['road-local']["saturation"]   	= @$_POST['map__road-local__saturation'];

//var_dump($activeBackgrounds["{$activeBackgroundID}"]["resources"]["map"]);
		$activeBackground = $activeBackgrounds["{$activeBackgroundID}"];
		update_option("i3d_active_backgrounds", $activeBackgrounds);
	}

//var_dump($activeBackground);

?>

	<style>
	#sortable li { cursor: move; background-color: #ffffff;}
		#sortable label {width: 100px; display: inline-block; font-weight: bold;}
		#sortable input.text_input {width: 200px;}
		table.form_field { background-color: #ffffff;  }

		div.loading {
			background-image: url(<?php echo I3D_Framework::getAuxIconSrc('loading-bg'); ?>) !important;
			background-repeat: no-repeat !important;
			background-position: center center !important;
			height: 40px;
		}

		div.image-choice-featured { font-weight: bold; line-height: 17px; width: 217px !important; height: 148px; float: left; margin: 2px; padding: 2px; border: 1px solid #cccccc; border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px; }
		div.image-choice { width: 69px !important; height: 69px; float: left; margin: 2px; padding: 2px; border: 1px solid #cccccc; border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px; }
    div.image-selected {
			background-color: #ffcc00;
		}

		div.change-image-link {
			display: block; padding: 2px; border-radius: 2px; -moz-border-radius: 2px; -webkit-border-radius: 2px; border: 1px solid #cccccc !important;
		}
		
		
		.editorvisual .span3  { height: 100px; margin: 1%; width: 22.5%; 		 float: left;     }
		.editorvisual .span6  { height: 100px; margin: 1%; width: 47.5%;		 float: left;	}
		.editorvisual .span9  { height: 100px; margin: 1%; width: 71.5%;		 float: left;	}
		.editorvisual .span12 { height: 100px; margin: 1%; width: 98%;		 float: left;	}
		
		div.change-image-link img { margin-bottom: -5px; cursor: pointer; }
		#sortable li { border: 1px solid #dadada;}
		.editorvisual .visual { display: block; }
		
		.editordesign .visual { display: none; }
		.editordesign .design { display:inherit; }
		.editorvisual .design { display: none !important; }
		.editorvisual .span3 .visual50 { display: none !important; }
		.editordesign select.design { display: inline-block; }
		#sortable.editorvisual .span3 label { width: auto !important; }
		a.mceButton.mce_i3d_cpg { display: none; }



th.header h3{
  font-family: sans-serif;
  margin: 0px;
  padding: 0px;
  float: left;
  margin-right: 10px;
  line-height: 25px;
}

th.header input, th.header select {
  font-family: sans-serif;
}

th.header select { font-size: 9pt; }
.remove { font-size: 10px !important; 
float: right;

}
.form-options label, label.shortcode {
	font-weight: bold;
	display: block;
}
.mce-i3d_cpg { display: none; } 
a#form_description_i3d_contact_form { display: none; }
.input-prepend select {
    -moz-box-sizing: content-box;
    font-size: 14px;
    height: 20px;
    padding-bottom: 4px;
    padding-top: 4px;
}
#wp-form_description-wrap { margin-top: -30px; padding-left: 10px;}
#shortcode input[readonly] { cursor: pointer !important; background-color: #ffffff !important;}
div.fa-wrapper ul { margin-bottom: 0px; }
div.fa-wrapper { vertical-align: top; margin-left: -4px; }
div.wp-editor-wrap  { margin-top: -0px; padding-left: 0px;}
#shortcode input[readonly] { cursor: pointer !important; background-color: #ffffff !important;}
.mceResize { display: none !important; }
.mceIframeContainer iframe { height: 130px !important; }
div.input-group-indented .input-group-addon { width: 200px; }
</style>

<script>
function i3d_change_background_type(selectBox) {
  jQuery(".resource-type").css("display", "none");
  
  if (jQuery(selectBox).val() == "image") {
		jQuery("#resource__image").css("display", "block");
		jQuery("#resource__parallaxing").css("display", "block");
	  
  } else if (jQuery(selectBox).val() == "video") {
		jQuery("#resource__video").css("display", "block");
		jQuery("#resource__parallaxing").css("display", "none");
	  
  } else if (jQuery(selectBox).val() == "map") {
		jQuery("#resource__map").css("display", "block");
		jQuery("#resource__parallaxing").css("display", "none");
	  
  }

}

function i3d_change_background_visibility(selectBox) {
  
  if (jQuery(selectBox).val() == "always") {
		jQuery("#background_visibility_options").css("display", "block");
	  
  } else {
		jQuery("#background_visibility_options").css("display", "none");
	  
  }
}

</script>
	<div class="wrap">
	

		<h2>Manage Active Background <a class="add-new-h2" href="admin.php?page=i3d_active_backgrounds">Cancel</a></h2>

   <form method="post">
   <input type='hidden' name="cmd" value="save" />
<input style='float: right; padding: 0px 0px !important; width: 150px; margin-right: 10px;' type="submit" name="nocmd" class="button button-primary" value="<?php _e("Save Changes", "i3d-framework"); ?>" />
<ul class="nav nav-tabs">
  <li <?php if (@$_POST['cmd'] != "save" || true) { ?>class="active"<?php } ?>><a href="#settings" data-toggle="tab">Settings</a></li>
  
  <?php /* <li <?php if (@$_POST['cmd'] == "save") { ?>class="active"<?php } ?>><a href="#panels" data-toggle="tab">Content Panels</a></li> 
  <li><a href="#shortcode" data-toggle="tab">Shortcode</a></li> */ ?>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane <?php if (@$_POST['cmd'] != "save" || true) { ?>active<?php } ?>" id="settings">
  <ul style='max-width: 950px;' class='form-options'>
          <li style='padding-top: 10px;'>


      <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-quote-left'></i> <?php _e("Name", "i3d-framework"); ?></span>
          
          <input  class='form-control' style='max-width: 200px' type='text' name='title' value="<?php echo $activeBackground['title']; ?>" />
           </div>
          </li>
         
 
 

          <li>
          <li >


      <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-quote-left'></i> <?php _e("Display", "i3d-framework"); ?></span>
          
          <select name="background_visibility" class='form-control' style='max-width: 225px' onchange='i3d_change_background_visibility(this)'>
             <option <?php if (@$activeBackground['background_visibility'] == "only-when-content-exists") { echo "selected"; } ?> value="only-when-content-exists"><?php _e("Only When Content Exists", "i3d-framework"); ?></option>
           <option <?php if (@$activeBackground['background_visibility'] == "always") { echo "selected"; } ?> value="always"><?php _e("Always", "i3d-framework"); ?></option>
          </select>           
		  </div>
          
         
          <div id="background_visibility_options" <?php if (@$activeBackground['background_visibility'] != "always") { echo "style='display:none;'"; } ?>>


      <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-desktop'></i> <?php _e("Desktop Min Height", "i3d-framework"); ?></span>
          <select name="background_desktop_min_height" class='form-control' style='max-width: 225px'>
		  <?php for ($i = 50; $i <= 500; $i+=50) { ?>
             <option <?php if (@$activeBackground['background_desktop_min_height'] == $i || ($i == 300 && @$activeBackground['background_desktop_min_height'] == "")) { echo "selected"; } ?> value="<?php echo $i; ?>"><?php echo $i; ?>px</option>
		  <?php } ?>
          </select>           
        
		  </div>
      <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-mobile'></i> <?php _e("Mobile Min Height", "i3d-framework"); ?></span>
           <select name="background_mobile_min_height" class='form-control' style='max-width: 225px'>
		  <?php for ($i = 50; $i <= 500; $i+=50) { ?>
             <option <?php if (@$activeBackground['background_mobile_min_height'] == $i || ($i == 150 && @$activeBackground['background_mobile_min_height'] == "")) { echo "selected"; } ?> value="<?php echo $i; ?>"><?php echo $i; ?>px</option>
		  <?php } ?>
          </select>           
         
        
		  </div>
</div>
          </li>
 
 

          <li>		  
          <label><?php _e("Background", "i3d-framework"); ?></label>
       <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-expand'></i> <?php _e("Type", "i3d-framework"); ?></span>

 
          <select name="background_type" class='form-control' style='max-width: 225px' onchange='i3d_change_background_type(this)'>
            <option <?php if (@$activeBackground['background_type'] == "image") { echo "selected"; } ?> value="image"><?php _e("Image", "i3d-framework"); ?></option>
            <option <?php if (@$activeBackground['background_type'] == "video") { echo "selected"; } ?> value="video"><?php _e("Video", "i3d-framework"); ?></option>
            <option <?php if (@$activeBackground['background_type'] == "map") { echo "selected"; } ?> value="map"><?php _e("Google Map", "i3d-framework"); ?></option>
          </select>
          </div>
          </li>
         <li id="resource__parallaxing" <?php if (@$activeBackground['background_type'] != "image") { echo "style='display:none;'"; } ?>>
       <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-exchange'></i> <?php _e("Parallaxing", "i3d-framework"); ?></span>

 
          <select name="parallaxing" class='form-control' style='max-width: 225px'>
            <option value=""><?php _e("None", "i3d-framework"); ?></option>
            <option <?php if (@$activeBackground['parallaxing'] == "vertical-same-direction") { echo "selected"; } ?> value="vertical-same-direction"><?php _e("Vertical (Scroll By)", "i3d-framework"); ?></option>
            <option <?php if (@$activeBackground['parallaxing'] == "vertical-opposite-direction") { echo "selected"; } ?> value="vertical-opposite-direction"><?php _e("Vertical (Reveal)", "i3d-framework"); ?></option>
            <option <?php if (@$activeBackground['parallaxing'] == "horizontal-left-to-right") { echo "selected"; } ?> value="horizontal-left-to-right"><?php _e("Horizontal - Left to Right", "i3d-framework"); ?></option>
            <option <?php if (@$activeBackground['parallaxing'] == "horizontal-right-to-left") { echo "selected"; } ?> value="horizontal-right-to-left"><?php _e("Horizontal - Right to Left", "i3d-framework"); ?></option>
          </select>
          </div>
          </li>
         <li>
       <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-signal'></i> <?php _e("Fading", "i3d-framework"); ?></span>

 
          	<select name="fade" class='form-control' style='max-width: 225px'>
            	<option value=""><?php _e("None", "i3d-framework"); ?></option>
            	<option <?php if (@$activeBackground['fade'] == "in") 	 { echo "selected"; } ?> value="in"><?php _e("In", "i3d-framework"); ?></option>
            	<option <?php if (@$activeBackground['fade'] == "in-out") { echo "selected"; } ?> value="in-out"><?php _e("In and Out", "i3d-framework"); ?></option>
            	<option <?php if (@$activeBackground['fade'] == "out") 	 { echo "selected"; } ?> value="out"><?php _e("Out", "i3d-framework"); ?></option>
          	</select>
          </div>
          </li>
         <li>
       <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-object-ungroup'></i> <?php _e("Cover", "i3d-framework"); ?></span>

 
          	<select name="cover" class='form-control' style='max-width: 225px'>
            	<option value=""><?php _e("None", "i3d-framework"); ?></option>
            	<option <?php if (@$activeBackground['cover'] == "dots") 	 { echo "selected"; } ?> value="dots"><?php _e("Dots", "i3d-framework"); ?></option>
            	<option <?php if (@$activeBackground['cover'] == "half-dots") 	 { echo "selected"; } ?> value="half-dots"><?php _e("Dots (Half)", "i3d-framework"); ?></option>
          	</select>
          </div>
          </li>
         <li>
       <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-square-o'></i> <?php _e("Border", "i3d-framework"); ?></span>

 
          	<select name="bordered" class='form-control' style='max-width: 225px'>
            	<option value=""><?php _e("No", "i3d-framework"); ?></option>
            	<option <?php if (@$activeBackground['bordered'] == "1") 	 { echo "selected"; } ?> value="1"><?php _e("Yes", "i3d-framework"); ?></option>
          	</select>
          </div>
          </li>

         <li class='resource-type' id='resource__image' <?php if ($activeBackground['background_type'] != "image") { echo "style='display:none;'"; } ?>>
          
		  <label><?php _e("Image", "i3d-framework"); ?></label>

    
		<?php
		  $currentImage = @$activeBackground['resources']["image"];
		  if ($currentImage != "" && is_numeric($currentImage)) {
			$metaData = get_post_meta($currentImage, '_wp_attachment_metadata', true); 
			$fileName = site_url().'/wp-content/uploads/'.$metaData['file']; 
		 } else {
			$fileName = "";
		 }
		 $i = 1;
        ?>
			<div class='panel panel-default' style='margin-left: 10px; float: left; margin-right: 10px;'>
<div class='panel-body'>
		
	   <div id="special_image_placeholder_<?php echo $i; ?>" class="ab_image_placeholder">
			<?php if ($fileName != "") { ?>
			<img src='<?php echo $fileName; ?>' />
			<?php } else { ?>
			<!--
			<span class="fa-stack fa-4x">
  <i class="fa fa-square fa-stack-2x"></i>
  <i class="fa fa-picture-o fa-stack-1x fa-inverse"></i>
</span>-->
			<?php } ?>
	   </div>
	   <div class='text-center'>
       <input type='button' id="image_upload_button_<?php echo $i; ?>" class='button button-primary' style='margin-top: 10px;' value="<?php _e("Choose or Upload Image", "i3d-framework"); ?>" /><br />
       <input type='button' id="image_clear_button_<?php echo $i; ?>" class='button'  style=' <?php if ($fileName == "") { print "display:none; "; } ?> margin-top: 10px;' value="<?php _e("Remove Image", "i3d-framework"); ?>" />
	   </div>
	   <input type="hidden" id="<?php echo "image__{$i}"; ?>" name="image__<?php echo $i; ?>" value="<?php echo $currentImage ?>" />

<script>
var file_frame;

jQuery('#image_clear_button_<?php echo $i; ?>').live('click', function( event ){
																	   	event.preventDefault();

																	  // alert("should remove");
			jQuery("#image__<?php echo $i?>").val("");
 		jQuery("#special_image_placeholder_<?php echo $i; ?>").html("<!--<span class='fa-stack fa-4x'><i class='fa fa-square fa-stack-2x'></i><i class='fa fa-picture-o fa-stack-1x fa-inverse'></i></span>-->");
		jQuery("#image_clear_button_<?php echo $i; ?>").css("display", "none");

																	   });

jQuery('#image_upload_button_<?php echo $i; ?>').live('click', function( event ){
 
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
 		jQuery("#special_image_placeholder_<?php echo $i; ?>").html("<img src='"+attachment.url+"' width='150px' />");
		jQuery("#image__<?php echo $i?>").val(attachment.id);
 		jQuery("#image_clear_button_<?php echo $i; ?>").css("display", "");
		
	});
 
	// Finally, open the modal
	file_frame.open();
});
 </script>
  </div>
  </div>


	

          </li>
         <li class='resource-type'  id='resource__video' <?php if ($activeBackground['background_type'] != "video") { echo "style='display:none;'"; } ?>>
       <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-youtube'></i> <?php _e("Video ID", "i3d-framework"); ?></span>
			<input type='text' class='form-control' name='video__1' style='max-width: 225px' value="<?php echo @$activeBackground['resources']['video']; ?>" />
 

          </div>
		 
		 </li>

         <li class='resource-type'  id='resource__map' <?php if ($activeBackground['background_type'] != "map") { echo "style='display:none;'"; } ?>>
		<div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-map-marker'></i> <?php _e("Address", "i3d-framework"); ?></span>
			<input type='text' class='form-control' name='address__1' style='max-width: 225px' value="<?php echo @$activeBackground['resources']['map']['address']; ?>" />
 

         
			<input type='text' title="Latitude" placholder='Latitude' class='form-control input-mini' style='margin-left: 10px; width: 120px;' name='lat__1' value="<?php echo @$activeBackground['resources']['map']['lat']; ?>" />
			<input type='text' title="Longitude" placholder='Longitude' class='form-control input-mini' style='margin-left: 10px; width: 120px;'  name='lng__1' value="<?php echo @$activeBackground['resources']['map']['lng']; ?>" />
 

          </div>		 
			<div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-search-plus'></i> <?php _e("Zoom", "i3d-framework"); ?></span>
			<select class='form-control' name='zoom__1' style='max-width: 225px'>
			  <?php for ($i = 3; $i <= 15; $i++) { ?>
			  <option value='<?php echo $i; ?>' <?php if ($i == @$activeBackground['resources']['map']['zoom']) { print "selected"; } ?>><?php echo $i; ?></option>
			  <?php } ?>
			</select>
 

         


          </div>
		    		           <label><?php _e("Styles", "i3d-framework"); ?></label>
<script>
  function i3d_changeMapStyler(selectBox) {
	var theID = jQuery(selectBox).attr("id");
	//alert(theID);
	//alert(jQuery(selectBox).val());
	if (jQuery(selectBox).val() == "hued" || jQuery(selectBox).val() == "hued-simplified" || jQuery(selectBox).val() == "colored" || jQuery(selectBox).val() == "colored-simplified") {
	   	jQuery("#" + theID + "__options").css("display", "inline");
	} else {
	   	jQuery("#" + theID + "__options").css("display", "none");
	}
	
	if (jQuery(selectBox).val() != "off") {
	   	jQuery("#" + theID + "__options_default").css("display", "inline");
	} else {
	   	jQuery("#" + theID + "__options_default").css("display", "none");
	}	
  }
</script>
			<div class="input-group input-group-indented">
            	<span class="input-group-addon"><?php _e("Points Of Interest", "i3d-framework"); ?></span>
				<select class='form-control' name='map__poi__visibility' id="map__poi" style='max-width: 225px' onchange='i3d_changeMapStyler(this)'> 
					<?php echo i3d_renderSelectOptions(array("on" => __("Default", "i3d-framework"), "hued" => __("Hued", "i3d-framework"), "colored" => __("Colored", "i3d-framework"), "off" => __("Off", "i3d-framework")), @$activeBackground['resources']['map']['poi']['visibility']); ?>
				</select>
				<div id="map__poi__options_default" style="<?php if (@$activeBackground['resources']['map']['poi']['visibility'] == "off") { echo "display: none;"; } ?>">
				
					<select name='map__poi__lightness' class='form-control' style='width: 175px; margin-left: 10px;'>
					  <option value="-75" <?php if (@$activeBackground['resources']['map']['poi']['lightness'] == "-75") { print "selected"; } ?>>-75% Lightness</option>
					  <option value="-50" <?php if (@$activeBackground['resources']['map']['poi']['lightness'] == "-50") { print "selected"; } ?>>-50% Lightness</option>
					  <option value="-25" <?php if (@$activeBackground['resources']['map']['poi']['lightness'] == "-25") { print "selected"; } ?>>-25% Lightness</option>
					  <option value="0" <?php if (@$activeBackground['resources']['map']['poi']['lightness'] == "" || @$activeBackground['resources']['map']['poi']['lightness'] == "0") { print "selected"; } ?>>Normal Lightness</option>
					  <option value="25" <?php if (@$activeBackground['resources']['map']['poi']['lightness'] == "25") { print "selected"; } ?>>+25% Lightness</option>
					  <option value="50" <?php if (@$activeBackground['resources']['map']['poi']['lightness'] == "50") { print "selected"; } ?>>+50% Lightness</option>
					  <option value="75" <?php if (@$activeBackground['resources']['map']['poi']['lightness'] == "75") { print "selected"; } ?>>+75% Lightness</option>
					</select>
					<select name='map__poi__saturation' class='form-control'  style='width: 175px; margin-left: 10px;'>
					  <option value="-100" <?php if (@$activeBackground['resources']['map']['poi']['saturation'] == "-100") { print "selected"; } ?>>-100% Saturation</option>
					  <option value="-75" <?php if (@$activeBackground['resources']['map']['poi']['saturation'] == "-75") { print "selected"; } ?>>-75% Saturation</option>
					  <option value="-50" <?php if (@$activeBackground['resources']['map']['poi']['saturation'] == "-50") { print "selected"; } ?>>-50% Saturation</option>
					  <option value="-25" <?php if (@$activeBackground['resources']['map']['poi']['saturation'] == "-25") { print "selected"; } ?>>-25% Saturation</option>
					  <option value="0" <?php if (@$activeBackground['resources']['map']['poi']['saturation'] == "" || @$activeBackground['resources']['map']['poi']['saturation'] == "0") { print "selected"; } ?>>Normal Saturation</option>
					</select>
				</div>
				<div id="map__poi__options" style="<?php if (@$activeBackground['resources']['map']['poi']['visibility'] != "hued" && @$activeBackground['resources']['map']['poi']['visibility'] != "colored") { echo "display: none;"; } ?>">
					<input type='color' class='form-control' placeholder='Example: #336699' name='map__poi__color' style='margin-left: 10px; width: 50px;' value="<?php if (@$activeBackground['resources']['map']['poi']['color'] == "") { echo "#C9DFAF"; } else { echo @$activeBackground['resources']['map']['poi']['color']; } ?>" />
   				</div>
			</div>

			<div class="input-group input-group-indented">
            	<span class="input-group-addon"><?php _e("Water", "i3d-framework"); ?></span>
				<select class='form-control' name='map__water__visibility' id="map__water" style='max-width: 225px' onchange='i3d_changeMapStyler(this)'> 
					<?php echo i3d_renderSelectOptions(array("on" => __("Default", "i3d-framework"), "hued" => __("Hued", "i3d-framework"), "colored" => __("Colored", "i3d-framework"), "off" => __("Off", "i3d-framework")), @$activeBackground['resources']['map']['water']['visibility']); ?>
				</select>
				<div id="map__water__options_default" style="<?php if (@$activeBackground['resources']['map']['water']['visibility'] == "off") { echo "display: none;"; } ?>">
				
					<select name='map__water__lightness' class='form-control' style='width: 175px; margin-left: 10px;'>
					  <option value="-75" <?php if (@$activeBackground['resources']['map']['water']['lightness'] == "-75") { print "selected"; } ?>>-75% Lightness</option>
					  <option value="-50" <?php if (@$activeBackground['resources']['map']['water']['lightness'] == "-50") { print "selected"; } ?>>-50% Lightness</option>
					  <option value="-25" <?php if (@$activeBackground['resources']['map']['water']['lightness'] == "-25") { print "selected"; } ?>>-25% Lightness</option>
					  <option value="0" <?php if (@$activeBackground['resources']['map']['water']['lightness'] == "" || @$activeBackground['resources']['map']['water']['lightness'] == "0") { print "selected"; } ?>>Normal Lightness</option>
					  <option value="25" <?php if (@$activeBackground['resources']['map']['water']['lightness'] == "25") { print "selected"; } ?>>+25% Lightness</option>
					  <option value="50" <?php if (@$activeBackground['resources']['map']['water']['lightness'] == "50") { print "selected"; } ?>>+50% Lightness</option>
					  <option value="75" <?php if (@$activeBackground['resources']['map']['water']['lightness'] == "100") { print "selected"; } ?>>+75% Lightness</option>
					</select>
					<select name='map__water__saturation' class='form-control'  style='width: 175px; margin-left: 10px;'>
					  <option value="-100" <?php if (@$activeBackground['resources']['map']['water']['saturation'] == "-100") { print "selected"; } ?>>-100% Saturation</option>
					  <option value="-75" <?php if (@$activeBackground['resources']['map']['water']['saturation'] == "-75") { print "selected"; } ?>>-75% Saturation</option>
					  <option value="-50" <?php if (@$activeBackground['resources']['map']['water']['saturation'] == "-50") { print "selected"; } ?>>-50% Saturation</option>
					  <option value="-25" <?php if (@$activeBackground['resources']['map']['water']['saturation'] == "-25") { print "selected"; } ?>>-25% Saturation</option>
					  <option value="0" <?php if (@$activeBackground['resources']['map']['water']['saturation'] == "" || @$activeBackground['resources']['map']['water']['saturation'] == "0") { print "selected"; } ?>>Normal Saturation</option>
					</select>
				</div>
				<div id="map__water__options" style="<?php if (@$activeBackground['resources']['map']['water']['visibility'] != "hued" && @$activeBackground['resources']['map']['water']['visibility'] != "colored") { echo "display: none;"; } ?>">
					<input type='color' class='form-control' placeholder='Example: #8FBBFE' name='map__water__color' style='margin-left: 10px; width: 50px;' value="<?php if (@$activeBackground['resources']['map']['water']['color'] == "") { echo "#8FBBFE"; } else { echo @$activeBackground['resources']['map']['water']['color']; } ?>" />
   				</div>
			</div>
			

			<div class="input-group input-group-indented">
            	<span class="input-group-addon"><?php _e("Landscape", "i3d-framework"); ?></span>
				<select class='form-control' name='map__landscape__visibility' id="map__landscape" style='max-width: 225px' onchange='i3d_changeMapStyler(this)'> 
					<?php echo i3d_renderSelectOptions(array("on" => __("Default", "i3d-framework"), "hued" => __("Hued", "i3d-framework"), "colored" => __("Colored", "i3d-framework"), "off" => __("Off", "i3d-framework")), @$activeBackground['resources']['map']['landscape']['visibility']); ?>
				</select>
				<div id="map__landscape__options_default" style="<?php if (@$activeBackground['resources']['landscape']['road-highway']['visibility'] == "off") { echo "display: none;"; } ?>">
				
					<select name='map__landscape__lightness' class='form-control' style='width: 175px; margin-left: 10px;'>
					  <option value="-75" <?php if (@$activeBackground['resources']['map']['landscape']['lightness'] == "-75") { print "selected"; } ?>>-75% Lightness</option>
					  <option value="-50" <?php if (@$activeBackground['resources']['map']['landscape']['lightness'] == "-50") { print "selected"; } ?>>-50% Lightness</option>
					  <option value="-25" <?php if (@$activeBackground['resources']['map']['landscape']['lightness'] == "-25") { print "selected"; } ?>>-25% Lightness</option>
					  <option value="0" <?php if (@$activeBackground['resources']['map']['landscape']['lightness'] == "" || @$activeBackground['resources']['map']['landscape']['lightness'] == "0") { print "selected"; } ?>>Normal Lightness</option>
					  <option value="25" <?php if (@$activeBackground['resources']['map']['landscape']['lightness'] == "25") { print "selected"; } ?>>+25% Lightness</option>
					  <option value="50" <?php if (@$activeBackground['resources']['map']['landscape']['lightness'] == "50") { print "selected"; } ?>>+50% Lightness</option>
					  <option value="75" <?php if (@$activeBackground['resources']['map']['landscape']['lightness'] == "75") { print "selected"; } ?>>+75% Lightness</option>
					</select>
					<select name='map__landscape__saturation' class='form-control'  style='width: 175px; margin-left: 10px;'>
					  <option value="-100" <?php if (@$activeBackground['resources']['map']['landscape']['saturation'] == "-100") { print "selected"; } ?>>-100% Saturation</option>
					  <option value="-75" <?php if (@$activeBackground['resources']['map']['landscape']['saturation'] == "-75") { print "selected"; } ?>>-75% Saturation</option>
					  <option value="-50" <?php if (@$activeBackground['resources']['map']['landscape']['saturation'] == "-50") { print "selected"; } ?>>-50% Saturation</option>
					  <option value="-25" <?php if (@$activeBackground['resources']['map']['landscape']['saturation'] == "-25") { print "selected"; } ?>>-25% Saturation</option>
					  <option value="0" <?php if (@$activeBackground['resources']['map']['landscape']['saturation'] == "" || @$activeBackground['resources']['map']['landscape']['saturation'] == "0") { print "selected"; } ?>>Normal Saturation</option>
					</select>
				</div>				
				<div id="map__landscape__options" style="<?php if (@$activeBackground['resources']['map']['landscape']['visibility'] != "hued" && @$activeBackground['resources']['map']['landscape']['visibility'] != "colored") { echo "display: none;"; } ?>">
					<input type='color' class='form-control' placeholder='Example: #F2EDE7' name='map__landscape__color' style='margin-left: 10px; width: 50px;' value="<?php if (@$activeBackground['resources']['map']['landscape']['color'] == "") { echo "#F2EDE7"; } else { echo @$activeBackground['resources']['map']['landscape']['color']; } ?>" />
   				</div>
			</div>
			<?php //var_dump($activeBackground['resources']['map']); ?>
			<div class="input-group input-group-indented">
            	<span class="input-group-addon"><?php _e("Highway", "i3d-framework"); ?></span>
				<select class='form-control' name='map__road-highway__visibility' id="map__road-highway" style='max-width: 225px' onchange='i3d_changeMapStyler(this)'> 
					<?php echo i3d_renderSelectOptions(array("on" => __("Default", "i3d-framework"), "simplified" => __("Default (Simplified)", "i3d-framework"), "hued" => __("Hued", "i3d-framework"), "hued-simplified" => __("Hued (Simplified)", "i3d-framework"), "off" => __("Off", "i3d-framework")), @$activeBackground['resources']['map']['road-highway']['visibility']); ?>
				</select>
				<div id="map__road-highway__options_default" style="<?php if (@$activeBackground['resources']['map']['road-highway']['visibility'] == "off") { echo "display: none;"; } ?>">
				
					<select name='map__road-highway__lightness' class='form-control' style='width: 175px; margin-left: 10px;'>
					  <option value="-75" <?php if (@$activeBackground['resources']['map']['road-highway']['lightness'] == "-75") { print "selected"; } ?>>-75% Lightness</option>
					  <option value="-50" <?php if (@$activeBackground['resources']['map']['road-highway']['lightness'] == "-50") { print "selected"; } ?>>-50% Lightness</option>
					  <option value="-25" <?php if (@$activeBackground['resources']['map']['road-highway']['lightness'] == "-25") { print "selected"; } ?>>-25% Lightness</option>
					  <option value="0" <?php if (@$activeBackground['resources']['map']['road-highway']['lightness'] == "" || @$activeBackground['resources']['map']['road-highway']['lightness'] == "0") { print "selected"; } ?>>Normal Lightness</option>
					  <option value="25" <?php if (@$activeBackground['resources']['map']['road-highway']['lightness'] == "25") { print "selected"; } ?>>+25% Lightness</option>
					  <option value="50" <?php if (@$activeBackground['resources']['map']['road-highway']['lightness'] == "50") { print "selected"; } ?>>+50% Lightness</option>
					  <option value="75" <?php if (@$activeBackground['resources']['map']['road-highway']['lightness'] == "75") { print "selected"; } ?>>+75% Lightness</option>
					</select>
					<select name='map__road-highway__saturation' class='form-control'  style='width: 175px; margin-left: 10px;'>
					  <option value="-100" <?php if (@$activeBackground['resources']['map']['road-highway']['saturation'] == "-100") { print "selected"; } ?>>-100% Saturation</option>
					  <option value="-75" <?php if (@$activeBackground['resources']['map']['road-highway']['saturation'] == "-75") { print "selected"; } ?>>-75% Saturation</option>
					  <option value="-50" <?php if (@$activeBackground['resources']['map']['road-highway']['saturation'] == "-50") { print "selected"; } ?>>-50% Saturation</option>
					  <option value="-25" <?php if (@$activeBackground['resources']['map']['road-highway']['saturation'] == "-25") { print "selected"; } ?>>-25% Saturation</option>
					  <option value="0" <?php if (@$activeBackground['resources']['map']['road-highway']['saturation'] == "" || @$activeBackground['resources']['map']['road-highway']['saturation'] == "0") { print "selected"; } ?>>Normal Saturation</option>
					</select>
				</div>
				<div id="map__road-highway__options" style="<?php if (@$activeBackground['resources']['map']['road-highway']['visibility'] != "hued" && @$activeBackground['resources']['map']['road-highway']['visibility'] != "hued-simplified") { echo "display: none;"; } ?>">
					<input type='color' class='form-control' placeholder='Example: #F2EDE7' name='map__road-highway__color' style='margin-left: 10px; width: 50px;' value="<?php if (@$activeBackground['resources']['map']['road-highway']['color'] == "") { echo "#F2EDE7"; } else { echo @$activeBackground['resources']['map']['road-highway']['color']; } ?>" />
   				</div>
			</div>
			<div class="input-group input-group-indented">
            	<span class="input-group-addon"><?php _e("Arterial Roads", "i3d-framework"); ?></span>
				<select class='form-control' name='map__road-arterial__visibility' id="map__road-arterial" style='max-width: 225px' onchange='i3d_changeMapStyler(this)'> 
					<?php echo i3d_renderSelectOptions(array("on" => __("Default", "i3d-framework"), "simplified" => __("Default (Simplified)", "i3d-framework"), "hued" => __("Hued", "i3d-framework"), "off" => __("Off", "i3d-framework")), @$activeBackground['resources']['map']['road-arterial']['visibility']); ?>
				</select>
				<div id="map__road-arterial__options_default" style="<?php if (@$activeBackground['resources']['map']['road-arterial']['visibility'] == "off") { echo "display: none;"; } ?>">
				
					<select name='map__road-arterial__lightness' class='form-control' style='width: 175px; margin-left: 10px;'>
					  <option value="-75" <?php if (@$activeBackground['resources']['map']['road-arterial']['lightness'] == "-75") { print "selected"; } ?>>-75% Lightness</option>
					  <option value="-50" <?php if (@$activeBackground['resources']['map']['road-arterial']['lightness'] == "-50") { print "selected"; } ?>>-50% Lightness</option>
					  <option value="-25" <?php if (@$activeBackground['resources']['map']['road-arterial']['lightness'] == "-25") { print "selected"; } ?>>-25% Lightness</option>
					  <option value="0" <?php if (@$activeBackground['resources']['map']['road-arterial']['lightness'] == "" || @$activeBackground['resources']['map']['road-arterial']['lightness'] == "0") { print "selected"; } ?>>Normal Lightness</option>
					  <option value="25" <?php if (@$activeBackground['resources']['map']['road-arterial']['lightness'] == "25") { print "selected"; } ?>>+25% Lightness</option>
					  <option value="50" <?php if (@$activeBackground['resources']['map']['road-arterial']['lightness'] == "50") { print "selected"; } ?>>+50% Lightness</option>
					  <option value="75" <?php if (@$activeBackground['resources']['map']['road-arterial']['lightness'] == "75") { print "selected"; } ?>>+75% Lightness</option>
					</select>
					<select name='map__road-arterial__saturation' class='form-control'  style='width: 175px; margin-left: 10px;'>
					  <option value="-100" <?php if (@$activeBackground['resources']['map']['road-arterial']['saturation'] == "-100") { print "selected"; } ?>>-100% Saturation</option>
					  <option value="-75" <?php if (@$activeBackground['resources']['map']['road-arterial']['saturation'] == "-75") { print "selected"; } ?>>-75% Saturation</option>
					  <option value="-50" <?php if (@$activeBackground['resources']['map']['road-arterial']['saturation'] == "-50") { print "selected"; } ?>>-50% Saturation</option>
					  <option value="-25" <?php if (@$activeBackground['resources']['map']['road-arterial']['saturation'] == "-25") { print "selected"; } ?>>-25% Saturation</option>
					  <option value="0" <?php if (@$activeBackground['resources']['map']['road-arterial']['saturation'] == "" || @$activeBackground['resources']['map']['road-arterial']['saturation'] == "0") { print "selected"; } ?>>Normal Saturation</option>
					</select>
				</div>
				<div id="map__road-arterial__options" style="<?php if (@$activeBackground['resources']['map']['road-arterial']['visibility'] != "hued" && @$activeBackground['resources']['map']['road-arterial']['visibility'] != "hued-simplified") { echo "display: none;"; } ?>">
					<input type='color' class='form-control' placeholder='Example: #F2EDE7' name='map__road-arterial__color' style='margin-left: 10px; width: 50px;' value="<?php if (@$activeBackground['resources']['map']['road-arterial']['color'] == "") { echo "#F2EDE7"; } else { echo @$activeBackground['resources']['map']['road-arterial']['color']; } ?>" />
   				</div>

			</div>
			<div class="input-group input-group-indented">
            	<span class="input-group-addon"><?php _e("Local Roads", "i3d-framework"); ?></span>
				<select class='form-control' name='map__road-local__visibility' id="map__road-local" style='max-width: 225px' onchange='i3d_changeMapStyler(this)'> 
					<?php echo i3d_renderSelectOptions(array("on" => __("Default", "i3d-framework"), "simplified" => __("Default (Simplified)", "i3d-framework"), "hued" => __("Hued", "i3d-framework"), "hued-simplified" => __("Hued (Simplified)", "i3d-framework"), "off" => __("Off", "i3d-framework")), @$activeBackground['resources']['map']['road-local']['visibility']); ?>
				</select>
				<div id="map__road-local__options_default" style="<?php if (@$activeBackground['resources']['map']['road-local']['visibility'] == "off") { echo "display: none;"; } ?>">
				
					<select name='map__road-local__lightness' class='form-control' style='width: 175px; margin-left: 10px;'>
					  <option value="-75" <?php if (@$activeBackground['resources']['map']['road-local']['lightness'] == "-75") { print "selected"; } ?>>-75% Lightness</option>
					  <option value="-50" <?php if (@$activeBackground['resources']['map']['road-local']['lightness'] == "-50") { print "selected"; } ?>>-50% Lightness</option>
					  <option value="-25" <?php if (@$activeBackground['resources']['map']['road-local']['lightness'] == "-25") { print "selected"; } ?>>-25% Lightness</option>
					  <option value="0" <?php if (@$activeBackground['resources']['map']['road-local']['lightness'] == "" || @$activeBackground['resources']['map']['road-local']['lightness'] == "0") { print "selected"; } ?>>Normal Lightness</option>
					  <option value="25" <?php if (@$activeBackground['resources']['map']['road-local']['lightness'] == "25") { print "selected"; } ?>>+25% Lightness</option>
					  <option value="50" <?php if (@$activeBackground['resources']['map']['road-local']['lightness'] == "50") { print "selected"; } ?>>+50% Lightness</option>
					  <option value="75" <?php if (@$activeBackground['resources']['map']['road-local']['lightness'] == "75") { print "selected"; } ?>>+75% Lightness</option>
					</select>
					<select name='map__road-local__saturation' class='form-control'  style='width: 175px; margin-left: 10px;'>
					  <option value="-100" <?php if (@$activeBackground['resources']['map']['road-local']['saturation'] == "-100") { print "selected"; } ?>>-100% Saturation</option>
					  <option value="-75" <?php if (@$activeBackground['resources']['map']['road-local']['saturation'] == "-75") { print "selected"; } ?>>-75% Saturation</option>
					  <option value="-50" <?php if (@$activeBackground['resources']['map']['road-local']['saturation'] == "-50") { print "selected"; } ?>>-50% Saturation</option>
					  <option value="-25" <?php if (@$activeBackground['resources']['map']['road-local']['saturation'] == "-25") { print "selected"; } ?>>-25% Saturation</option>
					  <option value="0" <?php if (@$activeBackground['resources']['map']['road-local']['saturation'] == "" || @$activeBackground['resources']['map']['road-local']['saturation'] == "0") { print "selected"; } ?>>Normal Saturation</option>
					</select>
				</div>
				<div id="map__road-local__options" style="<?php if (@$activeBackground['resources']['map']['road-local']['visibility'] != "hued" && @$activeBackground['resources']['map']['road-local']['visibility'] != "hued-simplified") { echo "display: none;"; } ?>">
					<input type='color' class='form-control' placeholder='Example: #F2EDE7' name='map__road-local__color' style='margin-left: 10px; width: 50px;' value="<?php if (@$activeBackground['resources']['map']['road-local']['color'] == "") { echo "#F2EDE7"; } else { echo @$activeBackground['resources']['map']['road-local']['color']; } ?>" />
   				</div>

			</div>


		 </li>

        </ul> 
  
  </div>

</div>
       
     

	</form>
	</div>
	<?php
}
function i3d_get_latlng_from_google_maps($address) {
	$address = urlencode($address);

    $url = "http://maps.googleapis.com/maps/api/geocode/json?address=$address&sensor=false";
//print $url;
    // Make the HTTP request
    $data = @file_get_contents($url);
    // Parse the json response
    $jsondata = json_decode($data,true);
//var_dump($jsondata);
    // If the json data is invalid, return empty array
    if (!check_status($jsondata))   return array();

    $LatLng = array(
        'lat' => $jsondata["results"][0]["geometry"]["location"]["lat"],
        'lng' => $jsondata["results"][0]["geometry"]["location"]["lng"],
    );

    return $LatLng;
}
function check_status($jsondata) {
    if ($jsondata["status"] == "OK") return true;
    return false;
}

function i3d_active_backgrounds_contextual_help( $contextual_help, $screen_id, $screen ) { 
		

	if (strstr($screen->id, '_page_i3d_active_backgrounds')) {
		ob_start();
		?>
        <h3>Content Panel Groups</h3>
        <p>You can create as many CPGs as you need for your website.  Click on the "<strong>Add New</strong>" button below to create a new form.</p>
       <!-- <p><a style='margin: 5px 0px;' class='btn btn-default' href="http://youtu.be/8YEIT1koYLs" target="_blank"><i class='fa fa-play-circle'></i> Watch The Help Video</a></p>-->

        
        <p><strong>Special Operations</strong></p>
        <ul>
        	<li><a onclick='return confirm("Are you certain you wish to delete all of your CPGs? This cannot be undone.")' href="?page=i3d_content_panels&cmd=reset">Delete All CPGs</a> <span class='label label-danger'>Warning -- this cannot be undone!</span></li>
        	<li><a href="?page=i3d_content_panels&cmd=init">Install Default CPG</a></li>
        </ul>
        <?php
	
		
		$contextual_help = ob_get_clean();


		}
	return $contextual_help;
}
add_action( 'contextual_help', 'i3d_active_backgrounds_contextual_help', 10, 3 );

?>