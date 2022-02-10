<?php
function i3d_focal_boxes() { 

	if (@$_GET['cmd'] == "reset") {
	update_option('i3d_focal_boxes', array());
	wp_redirect(admin_url("admin.php?page=i3d_focal_boxes"));
  } else if (@$_GET['cmd'] == "init") {
	  I3D_Framework::init_focal_boxes(true);
	wp_redirect(admin_url("admin.php?page=i3d_focal_boxes"));
  
  } else if (@$_GET['cmd'] == "new" && @$_POST['cmd2'] != __('Cancel', "i3d-framework")) {
	  i3d_create_focal_box();
      return;
  } else if (@$_POST['cmd2'] == __('Cancel', "i3d-framework")) {
	  
	wp_redirect(admin_url("admin.php?page=i3d_focal_boxes"));

  } else if (@$_GET['focal_box'] != "") {
	if (@$_GET['action'] == "trash") {
	  $fbs = get_option('i3d_focal_boxes');
	  unset($fbs[$_GET['focal_box']]);
	  update_option('i3d_focal_boxes', $fbs);
	  wp_redirect(admin_url("admin.php?page=i3d_focal_boxes"));

	} else {
	  i3d_focal_box_editor($_GET['focal_box']);
	  return;
	}
  } else if (@$_POST['focal_box'] != "") {
	 // print "yes";
	  
	 i3d_focal_box_editor($_POST['focal_box']); 
	 return;
  }
  
  $fbs = get_option('i3d_focal_boxes');
  if (!is_array($fbs)) {
	  $fbs = array();
  }
  
  
?>
  <div class='wrap'>
  <h2>Focal Boxes <a class="add-new-h2" href="admin.php?page=i3d_focal_boxes&cmd=new">Add New</a></h2>
  <p>A "Focal Box" is a combination image box and text section which animates as the user scrolls down the page.  Focal Boxes are normally displayed in the middle of the home or landing page.  You can 
  have more than one Focal Box on a page, and placed on as many pages as you wish.</p>

  <table cellspacing="0" class="wp-list-table widefat fixed posts">
	<thead>
	<tr>
		<th style="" class="manage-column column-cb check-column" id="cb" scope="col"><label for="cb-select-all-1" class="screen-reader-text">Select All</label><input type="checkbox" id="cb-select-all-1"></th>
        <th style="" class="manage-column" id="title" scope="col"><span>Title</span></th>
    </tr>
	</thead>

	<tfoot>
	<tr>
		<th style="" class="manage-column column-cb check-column" id="cb" scope="col"><label for="cb-select-all-2" class="screen-reader-text">Select All</label><input type="checkbox" id="cb-select-all-1"></th>
        <th style="" class="manage-column" id="title" scope="col"><span>Title</span></th>
    </tr>
	</tfoot>
	<tbody id="the-list">
<?php if (sizeof($fbs) == 0) { ?>
  				<tr valign="top" class="slider-none hentry alternate" id="slider-none">
				<th class="check-column" scope="row">
					
							</th>
						<td class="post-title page-title column-title" colspan="1">There are currently no 'Focal Boxes' in the system.  Click "add new" at the top of the page to create a new 'Focal Box'.
</td>
		</tr>

<?php } 
//var_dump($sliders);
?>
<?php foreach ($fbs as $fb) { ?>
    
				<tr valign="top" class="slider-<?php echo $fb['id']; ?> hentry alternate" id="slider-<?php echo $fb['id']; ?>">
				<th class="check-column" scope="row">
				  <label for="cb-select-<?php echo $fb['id']; ?>" class="screen-reader-text">Select <?php echo $fb['title']; ?></label>
				  <input type="checkbox" value="<?php echo $fb['id']; ?>" name="slider[]" id="cb-select-<?php echo $fb['id']; ?>">
							</th>
						<td class="post-title page-title column-title"><strong><a title="Edit '<?php echo $fb['title']; ?>'" href="?page=i3d_focal_boxes&focal_box=<?php echo $fb['id']; ?>&amp;action=edit" class="row-title"><?php echo $fb['title']; ?></a></strong>
<div class="row-actions"><span class="edit"><a title="Edit this item" href="?page=i3d_focal_boxes&focal_box=<?php echo $fb['id']; ?>&amp;action=edit">Edit</a> | </span><span class="trash"><a href="?page=i3d_focal_boxes&focal_box=<?php echo $fb['id']; ?>&amp;action=trash" title="Delete this Focal-Box" class="submitdelete">Delete</a></span></div>
</td>
		</tr>
<?php } ?>        
		</tbody>
</table>

    </div>
    <?php
}

function i3d_create_focal_box() {
 		 $fbs = get_option('i3d_focal_boxes');
		 $id = "fb_".I3D_Framework::get_unique_id("i3d_focal_boxes");
		   $fbs["{$id}"] = array('id' => $id,
									 'title' => "New Focal Box",
									 'layout' => 'image-left'
								     );
		   
		   update_option('i3d_focal_boxes', $fbs);
		   wp_redirect(admin_url("admin.php?page=i3d_focal_boxes&focal_box={$id}&action=edit"));

		   
		   return;

  
}

function i3d_focal_box_editor($id) {
	global $wpdb;
	$fbs = get_option('i3d_focal_boxes');
	$fb  = $fbs["{$id}"];
	 
	//print "My id is $id<br>";
	if(array_key_exists("cmd", $_POST) && $_POST['cmd'] == "save") {
		 foreach ($_POST as $x => $y) {
	     // print $x."=".$y."<br>";
		   
         }
		$objects = array();
		
		if(array_key_exists("objects", $_POST) && is_array($_POST['objects'])) {
			foreach($_POST['objects'] as $object_id) {
			  $objects[] = array('type' => $_POST["{$object_id}__type"],
								'width' => $_POST["{$object_id}__width"],
								'text' => stripslashes($_POST["{$object_id}__text"]),
								'text_2' => stripslashes($_POST["{$object_id}__text_2"]),
								'size' => $_POST["{$object_id}__size"],
								'style' => $_POST["{$object_id}__style"],
								'style_2' => $_POST["{$object_id}__style_2"],
								'align' => $_POST["{$object_id}__align"],
								'link' => $_POST["{$object_id}__link"],
								'external_link' => $_POST["{$object_id}__external_link"],
								'animate_action' => $_POST["{$object_id}__animate_action"]);
								
			 
			}
		}
		//var_dump($objects);
		$fbs["{$id}"]["title"]          = stripslashes($_POST['title']);
		$fbs["{$id}"]["layout"]         = stripslashes($_POST['layout']);
		$fbs["{$id}"]["images"]			= array(0 => @$_POST['image__0'], 1 => @$_POST['image__1'], 2 => @$_POST['image__2']);
		$fbs["{$id}"]["objects"]        = $objects;

		$fb = $fbs["{$id}"];
		update_option("i3d_focal_boxes", $fbs);
		wp_redirect("admin.php?page=i3d_focal_boxes&focal_box={$id}&action=edit&tab=fields");
	}


function getTextSizeOptions($selectedOption = "") {
	$textFormatOptions = "";
	$formatOptions = array("title1" => "Title 1", "title2" => "Title 2", "description" => "Description");


	foreach ($formatOptions as $key => $value) {
		$textFormatOptions .= '<option value="'.$key.'"';
		if ($key == $selectedOption || ($selectedOption == "" && $key == "h3")) { 
		$textFormatOptions .= " selected";
		}
		$textFormatOptions .= '>';
		$textFormatOptions .= $value;
		$textFormatOptions .= '</option>';
	}
  return $textFormatOptions;
}

function getTextStylingOptions($selectedOption) {
  $textStylingOptions = "";
  $formatStyles = array();
  if (I3D_Framework::$callToActionVersion == 2) {
	if (sizeof(I3D_Framework::$callToActionStyles) > 0) {
	  $formatStyles = I3D_Framework::$callToActionStyles;
		
	} else {
	  $formatStyles = array("" => "Default", "cta-1" => "Cursive Font", "cta-extra-padding" => "Extra Top/Bottom Padding");
	}
  } 
  
  foreach ($formatStyles as $key => $value) {
		$textStylingOptions .= '<option value="'.$key.'"';
		if ($key == $selectedOption || ($selectedOption == "" && $key == "")) { 
		$textStylingOptions .= " selected";
		}
		$textStylingOptions .= '>';
		$textStylingOptions .= $value;
		$textStylingOptions .= '</option>';	  
  }
   return $textStylingOptions;
 
	
}

function getAlignOptions($selectedOption = "") {
	$textFormatOptions = "";
	$formatOptions = array("text-center" => "Center", "text-left" => "Left", "text-right" => "Right");
   // print "my selectedOption == $selectedOption";
	foreach ($formatOptions as $key => $value) {
		$textFormatOptions .= '<option value="'.$key.'"';
		if ($key == $selectedOption) { 
		$textFormatOptions .= " selected";
		}
		$textFormatOptions .= '>';
		$textFormatOptions .= $value;
		$textFormatOptions .= '</option>';
	}
  return $textFormatOptions;
}

function getAnimationOptions($selectedOption = "") {
	$textFormatOptions = "";
	$animationOptions = array("slideInLeft"  => "Slide In Left", 
							  "slideInRight" => "Slide In Right",
							  "slideInDown"  => "Slide In Down",
							  "bounceIn"  => "Bounce In",
							  "bounceInDown"  => "Bounce In Down",
							  "bounceInUp"  => "Bounce In Up",
							  "bounceInLeft"  => "Bounce In Left",
							  "bounceInRight"  => "Bounce In Right",
							  "fadeIn"  => "Fade In",
							  "fadeInUp"  => "Fade In Up",
							  "fadeInDown"  => "Fade In Down",
							  "fadeInLeft"  => "Fade In Left",
							  "fadeInRight"  => "Fade In Right",
							  "fadeInUpBig"  => "Fade In Up Big",
							  "fadeInDownBig"  => "Fade In Down Big",
							  "fadeInLeftBig"  => "Fade In Left Big",
							  "fadeInRightBig"  => "Fade In Right Big"
							  );

	foreach ($animationOptions as $key => $value) {
		$textFormatOptions .= '<option value="'.$key.'"';
		if ($key == $selectedOption) { 
		$textFormatOptions .= " selected";
		}
		$textFormatOptions .= '>';
		$textFormatOptions .= $value;
		$textFormatOptions .= '</option>';
	}
  return $textFormatOptions;
}

function getPageOptions($selectedPage = "") {
	$pages = get_pages();
	$redirectPageOptions = "";

	foreach ($pages as $page) {
		$redirectPageOptions .= '<option value="'.$page->ID.'"';
		if ($page->ID == $selectedPage) { 
		$redirectPageOptions .= " selected";
		}
		$redirectPageOptions .= '>';
		$redirectPageOptions .= addslashes($page->post_title);
		$redirectPageOptions .= '</option>';
	}
		$redirectPageOptions .= '<option value="**external**"';
		if ("**external**" == $selectedPage) { 
		$redirectPageOptions .= " selected";
		}
		$redirectPageOptions .= '>';
		$redirectPageOptions .= __("-- External URL -- ", "i3d-framework");
		$redirectPageOptions .= '</option>';
	
  return $redirectPageOptions;
}
	$objectTypes  = '<option style="disabled" value="">-- Choose Object Type --&nbsp;</option>';
	$objectTypes .= '<option value="text">Text</option>';
	$objectTypes .= '<option value="button">Button</option>';

	$objectWidths  = '<option value="span12">100%</option>';
	$objectWidths .= '<option value="span9">75%</option>';
	$objectWidths .= '<option value="span6">50%</option>';
	$objectWidths .= '<option value="span3">25%</option>';

?>

	<style>
	ul#sortable { margin-left: 0px; } 
	th.header { border: 0px !important;  padding-top: 0px; }
	table.widefat { border: 0px; !important; }
	#sortable li { cursor: move; background-color: #ffffff;}
		#sortable label {width: 100px; display: inline-block; font-weight: bold;}
		#sortable input.text_input {width: 200px;}
		table.form_field { background-color: #ffffff;  }
		ul.form-options { margin-left: 0px; } 

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
		
		
		.editorvisual .span3  { height: 136px; margin: 1%; width: 22.5%; 		 float: left;     }
		.editorvisual .span6  { height: 136px; margin: 1%; width: 47.5%;		 float: left;	}
		.editorvisual .span9  { height: 136px; margin: 1%; width: 71.5%;		 float: left;	}
		.editorvisual .span12 { height: 136px; margin: 1%; width: 98%;		 float: left;	}
		/* table.form_field {  display: block; border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; } */
		
		.editordesign .span3 { width: 100%; margin: 0px; margin-bottom: 10px; }
		.editordesign .span6 { width: 100%; margin: 0px; margin-bottom: 10px;  }
		.editordesign .span9 { width: 100%; margin: 0px; margin-bottom: 10px; }
		.editordesign .span12 { width: 100%; margin: 0px; margin-bottom: 10px;  }
		
		div.change-image-link img { margin-bottom: -5px; cursor: pointer; }
		#sortable li { border: 1px solid #dadada;}
		.editorvisual .visual { display: block; }
		
		.editordesign .visual { display: none; }
		.editordesign .design { display: auto;;  }
		.editorvisual .design { display: none !important; }
		.editorvisual .span3 .visual50 { display: none !important; }
		.editorvisual .span3 .visual50x { width: 15% !important; }
		.editorvisual .span3 .visual50a input { width: 70% !important; }
		.editordesign select.design { display: inline-block; }
		#sortable.editorvisual .span3 label { width: auto !important; }
		.editorvisual .span3 input[type=text] { width: 100%; }
		.editorvisual .span6 input[type=text] { width: 65%; }
		.editorvisual .span9 input[type=text] { width: 80%; }
		.editorvisual .span12 input[type=text] { width: 60%; }
		#sortable label.btn { width: auto !important; }
		
  </style>

  <link rel='stylesheet' type='text/css' href='<?php echo site_url() ; ?>/wp-admin/load-styles.php?c=1&amp;load=thickbox' />
	<script type="text/javascript">
	jQuery(function($) {
		jQuery("#sortable").sortable();
	    //jQuery("#sortable li").resizable({grid: 50});
	});

function changeMode(button) {
  if (button.value == "design") {
	
    jQuery("#sortable").removeClass("editorvisual");
    jQuery("#sortable").addClass("editordesign");
	  
  } else {
    jQuery("#sortable").removeClass("editordesign");
    jQuery("#sortable").addClass("editorvisual");
	
  }
}

var stylesheetDirectory = "<?php echo get_stylesheet_directory_uri() ; ?>";

	function changeFieldType(selectBox,id) {
		var selectedValue = selectBox.value;
		//jQuery("#" + id + "__type").val(jQuery(selectBox).val());

	jQuery("#field_details_all__"+id).find(".field_details_container").css("display", "none");
    
		if (selectedValue != "") {
		  jQuery("#field_details__"+id+"__" + selectedValue).css("display", "block");
		  if (selectedValue != "separator") {
		    jQuery("#field_details__"+id+"__all").css("display", "block");
		  } 
		  if (selectedValue != "separator" && selectedValue != "label" && selectedValue != "heading" && selectedValue != "radio" && selectedValue != "checkbox") {
		    jQuery("#field_details__"+id+"__required").css("display", "block");
			  
		  }
		  
		  if (selectedValue == "radio" || selectedValue == "select") {
		    jQuery("#field_details__"+id+"__options").css("display", "block");
			  
		  }
		  if (selectedValue == "textarea" || selectedValue == "url" || selectedValue == "email") {
		    jQuery("#field_details__"+id+"__text").css("display", "block");
			  
		  }
		  
		  
		//  selectBox.options[0].disabled = true;
		}
	}
	function changeFieldWidth(selectBox,id) {
		var selectedValue = selectBox.value;
		
		jQuery("li#field__"+id).removeClass("span12");
		jQuery("li#field__"+id).removeClass("span9");
		jQuery("li#field__"+id).removeClass("span6");
		jQuery("li#field__"+id).removeClass("span3");
		jQuery("li#field__"+id).addClass(selectedValue);
		//jQuery("#" + id + "__width").val(selectedValue);
    
	}
	function remove_field(id) {
		//get containing div element (container)
		var container = document.getElementById('sortable');

		//get div element to remove
		var olddiv = document.getElementById('field__'+id);

		//remove the div element from the container
		container.removeChild(olddiv);
	}	

	function add_new_form_item() {
		var id = "";
		var source = "";
		var title = "Example Field Name";
		var caption = "Example Default Value";
		var description = "Example Long Description";
		var linkLabel = "Click Here";

		jQuery("#sortable").append('<li id="field__new'+counter+'" class="span12">' +
		 '<table id="new'+counter+'__table" class="form_field" cellspacing="0" width="100%" height="100%">' +
		 '<tr>' + 													 
		 '<td>' +
		 '<div class="visual"><label for="new'+counter+'__width">Width</label><select onchange="changeFieldWidth(this,\'new'+counter+'\')" id="new'+counter+'__width" name="new'+counter+'__width"><?php echo $objectWidths; ?></select></div>' +
		 '<label class="visual50" for="new'+counter+'__type">Object Type</label><select onchange="changeFieldType(this,\'new'+counter+'\')" id="new'+counter+'__type" name="new'+counter+'__type"><?php echo $objectTypes; ?></select><br />' +
		 '<div id="field_details_all__new'+counter+'">' +
		 '<div class="field_details_container" id="field_details__new'+counter+'__all" style="display: none;">' +
		   '<label class="design" for="new'+counter+'__animate_action">Animation</label><select class="design" id="new'+counter+'__animate_action" name="new'+counter+'__animate_action"><?php echo getAnimationOptions(); ?></select><br class="design" />' +
		   '<label class="visual50" for="new'+counter+'__text">Text</label><input type="text" id="new'+counter+'__text" name="new'+counter+'__text" /><br />' +
		   '<label class="design" for="new'+counter+'__align">Align</label><select class="design" id="new'+counter+'__align" name="new'+counter+'__align"><?php echo getAlignOptions(); ?></select><br  class="design" />' +
		 '</div>' + 
		 '<div class="design field_details_container" id="field_details__new'+counter+'__text" style="display: none;">' +
		   '<label class="design" for="new'+counter+'__size">Size</label><select class="design" id="new'+counter+'__size" name="new'+counter+'__size"><?php echo getTextSizeOptions(); ?></select><br />' +
		 '</div>' +	 
		 '<div class="design field_details_container" id="field_details__new'+counter+'__button" style="display: none;">' +
		   '<label class="design" for="new'+counter+'__link">Link</label><select onchange="checkPageURL(this)" class="design" id="new'+counter+'__link" name="new'+counter+'__link"><?php echo getPageOptions() ?></select>' +
		   '<input class="external_link" id="new'+counter+'__link_external" name="new'+counter+'__external_link" style="display: none;" type="url" placeholder="example: http://www.somewebsite.com/somepage.htm" value="" />' + 
		   '<br />' + 
		 '</div>' +

		 '</div>' +
		 '</td>' + 
		 '<td valign="top" align="right" style="width: 75px;"><input type="hidden" id="new'+counter+'__object_id" name="new'+counter+'__object_id" value="'+id+'" /><input type="hidden" name="objects[]" value="new'+counter+'" />' +
		 '<input class="remove button" type="button" name="nocmd" value="Remove" onclick="remove_field(\'new'+counter+'\')" />' +
		 '</td>' +															 
		 '</tr></table></li>');

		counter++;
	}

	var counter = 1;
	</script>


<style>

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
#shortcode input[readonly] { cursor: pointer !important; background-color: #ffffff !important;}
.input-prepend select {
    -moz-box-sizing: content-box;
    font-size: 14px;
    height: 20px;
    padding-bottom: 4px;
    padding-top: 4px;
}
.width-buttons .btn { padding-left: 8px; padding-right: 8px; }
ul#sortable li.span3 .btn-danger { display: none;}
input.external_link { width: 300px; margin-left: 10px; }
</style>
<script type="text/javascript">
  function setFocalBoxLayout(value, image) {
	  jQuery(image).parent().find("img").removeClass("focal-box-layout-icon-selected");
	  jQuery(image).addClass("focal-box-layout-icon-selected");
	  jQuery("#layout").val(value);
	 
	if (value == "image-left") {
	  jQuery(".blog__grid").css("display", "none");	
	  jQuery(".blog__rows").css("display", "block");	
	} else if (value == "image-right") {
	  jQuery(".blog__grid").css("display", "block");	
	  jQuery(".blog__rows").css("display", "none");	
	} else if (value == "image-only") {
	  jQuery(".blog__grid").css("display", "none");	
	  jQuery(".blog__rows").css("display", "none");	
	}
  }
</script>
	<div class="wrap">
	

		<h2>Manage Focal Box <a class="add-new-h2" href="admin.php?page=i3d_focal_boxes">Cancel</a></h2>

   <form method="post">
<input style='float: right;  margin-right: 10px;' type="submit" name="nocmd" class="btn btn-success" value="<?php _e("Save Changes", "i3d-framework"); ?>" />
<ul class="nav nav-tabs">
  <li <?php if (!array_key_exists("tab", $_GET)) { ?>class="active"<?php } ?>><a href="#settings" data-toggle="tab"><?php _e("Settings", "i3d-framework"); ?></a></li>
  <li <?php if (array_key_exists("tab", $_GET) && $_GET['tab'] == "images") { ?>class="active"<?php } ?>><a href="#images" data-toggle="tab"><?php _e("Images", "i3d-framework"); ?></a></li>
  <li <?php if (array_key_exists("tab", $_GET) && $_GET['tab'] == "fields") { ?>class="active"<?php } ?>><a href="#fields" data-toggle="tab"><?php _e("Text Fields", "i3d-framework"); ?></a></li>
  <li><a href="#shortcode" data-toggle="tab"><?php _e("Shortcode", "i3d-framework"); ?></a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content" style='padding-top: 5px;' >
  <div class="tab-pane <?php if (!array_key_exists("tab", $_GET)) { ?>active<?php } ?>" id="settings">
	<ul style='padding-top:10px; max-width: 500px;' class='form-options'>
    	<li>
      		<div class="input-group input-group-indented">
            	<span class="input-group-addon"><i class='fa fa-fw fa-quote-left'></i> <?php _e("Title", "i3d-framework"); ?></span>
				<input class='form-control' style='max-width: 200px;' type='text' name='title' value="<?php echo $fb['title']; ?>" />
 			</div>
		</li>
 		<li style='padding-left:10px;'>
			<label class='primary-label' for="blog__style"><?php _e("Box Layout", "i3d-framework"); ?></label>
        	<input type='hidden' name='layout' id='layout' value='<?php echo @$fb['layout']; ?>' />
        	<div>
          		<img onclick='setFocalBoxLayout("image-left", 	this)' title='<?php _e("Image Left", "i3d-framework"); ?>' class='focal-box-layout-icon <?php if ($fb['layout'] == "image-left") { echo " focal-box-layout-icon-selected"; } ?>' src='<?php echo get_template_directory_uri(); ?>/includes/admin/images/focal-box-layout-image-left.png' />
          		<img onclick='setFocalBoxLayout("image-right", 	this)' title='<?php _e("Image Right", "i3d-framework"); ?>' class='focal-box-layout-icon <?php if ($fb['layout'] == "image-right") { echo " focal-box-layout-icon-selected"; } ?>' src='<?php echo get_template_directory_uri(); ?>/includes/admin/images/focal-box-layout-image-right.png' />
          		<img onclick='setFocalBoxLayout("image-only", 	this)' title='<?php _e("Image Only", "i3d-framework"); ?>' class='focal-box-layout-icon <?php if ($fb['layout'] == "image-only") { echo " focal-box-layout-icon-selected"; } ?>' src='<?php echo get_template_directory_uri(); ?>/includes/admin/images/focal-box-layout-image-only.png' />
        	</div>
		</li>	
     </ul>  
  </div>
  <div class="tab-pane <?php if (array_key_exists("tab", $_GET) && $_GET['tab'] == "images") { ?>active<?php } ?>" id="images">
  	
      
		<?php
		for ($i = 0; $i < 3; $i++) {
		  $currentImage = @$fb['images']["$i"];
		  if ($currentImage != "" && is_numeric($currentImage)) {
			$metaData = get_post_meta($currentImage, '_wp_attachment_metadata', true); 
			$fileName = site_url().'/wp-content/uploads/'.$metaData['file']; 
		 } else {
			$fileName = "";
		 }
        ?>
			<div class='panel panel-default' style='float: left; margin-right: 10px;'>
			  <div class='panel-heading'><?php _e("Image ".($i + 1), "i3d-framework"); ?></div>
<div class='panel-body'>
		
	   <div id="special_image_placeholder_<?php echo $i; ?>" class="fb_image_placeholder">
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
<?php } ?>
  </div>  
  <div class="tab-pane <?php if (array_key_exists("tab", $_GET) && $_GET['tab'] == "fields") { ?>active<?php } ?>" id="fields">

			<input type="hidden" name="cmd" value="save" />

        <input type='hidden' value='<?php echo $id; ?>' name='call_to_action' />
		<table class="widefat" style="max-width: 950px; min-width: 580px;">
		<thead>

		<tr><th class='header'><!--<h3>Objects</h3>-->
		<div class="btn-group mode-selector" data-toggle="buttons">
          <label class="btn btn-default active">
            <input type="radio" name="mode" value="design" id="__mode_design" checked onchange='changeMode(this)'> <i class='fa fa-fw fa-edit'></i> Details
          </label>
          <label class="btn btn-default">
            <input type="radio" name="mode" value="visual" id="__mode_visual" onchange='changeMode(this)'> <i class='fa fa-fw fa-table'></i> Layout
          </label>
        </div> 
        
   <input onclick='add_new_form_item()' style='float: right; padding: 3px 8px !important;' type="button"  class="btn btn-info" value="Add New Object" />
</th></tr>
		</thead>
		<tbody>
		<?php
		
			$objects = @$fb['objects'];
			
			
			
			$counter = 0;
			if (!is_array($objects)) {
				$objects = array();
			}

?>
		<tr>
		<td valign="top">
<?php
//var_dump($cta);
			echo '<ul id="sortable" class="editordesign">';
			foreach($objects as $object) {
			//only list image if it still exists
				//if(wp_attachment_is_image($image['id']) || $image['id'] == "default") {


	
	$objectTypes = '<option '.($object['type'] == "text" ? "selected='selected'" : "").' value="text">Text</option>';
	$objectTypes .= '<option '.($object['type'] == "button" ? "selected='selected'" : "").' value="button">Button</option>';

	$objectWidths  = '<option '.($object['width'] == "span12" ? "selected='selected'" : "").' value="span12">100%</option>';
	$objectWidths .= '<option '.($object['width'] == "span9" ? "selected='selected'" : "").' value="span9">75%</option>';
	$objectWidths .= '<option '.($object['width'] == "span6" ? "selected='selected'" : "").' value="span6">50%</option>';
	$objectWidths .= '<option '.($object['width'] == "span3" ? "selected='selected'" : "").' value="span3">25%</option>';
					

?>
				<li id="field__<?php echo $counter; ?>" class="<?php echo $object['width']?>">
		 <table id="<?php echo $counter; ?>__table" class="form_field" cellspacing="0" width="100%" height="100%">
		 <tr>											 
		 <td>
       <!--  <input type='hidden'  id="<?php echo $counter; ?>__type" name="<?php echo $counter; ?>__type" value="<?php echo $object['type']; ?>" />-->
		 <input class="remove btn btn-danger" type="button" name="nocmd" value="Remove" onclick="remove_field('<?php echo $counter; ?>')" />
	<div class="btn-group visual width-buttons clearfix" data-toggle="buttons" style='margin-bottom: 10px;'>
    <label class="btn btn-default <?php if ($object['width'] == "span3") { print "active"; } ?>">
    	<input name="<?php echo $counter; ?>__width" type='radio' value='span3' <?php if ($object['width'] == "span3")  { print "checked"; } ?> onchange='changeFieldWidth(this,"<?php echo $counter; ?>")'>25%
    </label>
    <label class="btn btn-default <?php if ($object['width'] == "span6") { print "active"; } ?>">
    	<input name="<?php echo $counter; ?>__width" type='radio' value='span6' <?php if ($object['width'] == "span6")  { print "checked"; } ?> onchange='changeFieldWidth(this,"<?php echo $counter; ?>")'>50%
    </label>
    <label class="btn btn-default <?php if ($object['width'] == "span9") { print "active"; } ?>">
    	<input name="<?php echo $counter; ?>__width"  type='radio' value='span9' <?php if ($object['width'] == "span9")  { print "checked"; } ?> onchange='changeFieldWidth(this,"<?php echo $counter; ?>")'>75%
    </label>
    <label class="btn btn-default <?php if ($object['width'] == "span12") { print "active"; } ?>">
    	<input name="<?php echo $counter; ?>__width"  type='radio' value='span12' <?php if ($object['width'] == "span12") { print "checked"; } ?> onchange='changeFieldWidth(this,"<?php echo $counter; ?>")'>100%
    </label>
    </div>
   <!-- <input type='hidden' id="<?php echo $counter; ?>__width" name="<?php echo $counter; ?>__width" value="<?php echo $object['width']; ?>" />-->         
         <!--<div class="visual"><label for="<?php echo $counter; ?>__width">Width</label><select onchange="changeFieldWidth(this,'<?php echo $counter; ?>')" id="<?php echo $counter; ?>__width" name="<?php echo $counter; ?>__width"><?php echo $objectWidths; ?></select></div>-->
		<div class="btn-group mode-selector" data-toggle="buttons">
          <label class="btn btn-default <?php if ($object['type'] == "text") { print "active"; } ?>">
    		<input value='text'   name="<?php echo $counter; ?>__type" type="radio" <?php if ($object['type'] == "text") { print "checked"; } ?> onchange='changeFieldType(this,"<?php echo $counter; ?>")'><i class='icon-font'></i> Text
          </label>
          <label class="btn btn-default <?php if ($object['type'] == "button") { print "active"; } ?>">
   			<input value='button' name="<?php echo $counter; ?>__type" type="radio" <?php if ($object['type'] == "button") { print "checked"; } ?> onchange='changeFieldType(this,"<?php echo $counter; ?>")'><i class='icon-link'></i> Button
          </label>
        </div> 		 
             <div class="btn-group" data-toggle="buttons-radio">
    </div>
    <!--
         <label class="visual50" for="<?php echo $counter; ?>__type">Object Type</label><select onchange="changeFieldType(this,'<?php echo $counter; ?>')" id="<?php echo $counter; ?>__type" name="<?php echo $counter; ?>__type"><?php echo $objectTypes; ?></select>--><br />
		 <div id="field_details_all__<?php echo $counter; ?>" style='margin-top: 10px;'>

         <div class="field_details_container" id="field_details__<?php echo $counter; ?>__all">
           <div class="input-group input-group-flush design">
            <span class="input-group-addon"><i class='fa fa-fw fa-align-center'></i> <?php _e("Align", "i3d-framework"); ?></span>

           <select class="design form-control" style='max-width: 200px;'  id="<?php echo $counter; ?>__align" name="<?php echo $counter; ?>__align"><?php echo getAlignOptions($object['align']); ?></select><br  class="design" />
          </div>
       		<div class="input-group input-group-flush visual50a">
            <span class="input-group-addon visual50x"><i class='fa fa-fw fa-font'></i> <?php _e("Text", "i3d-framework"); ?></span>
         
          <input class='form-control' type="text" id="<?php echo $counter; ?>__text" name="<?php echo $counter; ?>__text" value="<?php echo htmlentities($object['text']); ?>" /><br />
		</div>
		 </div>
		 <div class="design field_details_container" id="field_details__<?php echo $counter; ?>__text" <?php if ($object['type'] != "text") { ?>style="display: none;"<?php } ?>>
           
            <div class="input-group input-group-flush">
            <span class="input-group-addon"><i class='fa fa-fw fa-text-height'></i> <?php _e("Size", "i3d-framework"); ?></span>

		  
           <select class="form-control" style='max-width: 200px;' id="<?php echo $counter; ?>__size" name="<?php echo $counter; ?>__size"><?php echo getTextSizeOptions(@$object['size']); ?></select><br />
           </div>
         </div>	

		 <div class="design field_details_container" id="field_details__<?php echo $counter; ?>__button" <?php  if (@$object['type'] != "button") { ?>style="display: none;"<?php } ?>>
           
           <div class="input-group input-group-flush">
            <span class="input-group-addon"><i class='fa fa-fw fa-link'></i> <?php _e("Link", "i3d-framework"); ?></span>
            
         
<select onchange="checkPageURL(this)" class="form-control" style="max-width: 200px;" id="<?php echo $counter; ?>__link" name="<?php echo $counter; ?>__link">
<?php echo getPageOptions(@$object['link']) ?></select>
<input class="external_link" id="<?php echo $counter; ?>__link_external" name="<?php echo $counter; ?>__external_link" <?php if (@$object['link'] != "**external**") { ?>style='display: none;'<?php } ?> type='url' placeholder='example: http://www.somewebsite.com/somepage.htm' value="<?php echo @$object['external_link']; ?>" />
<br />
         </div>
         </div>


		 </div>
         
         
    
         
         <input type="hidden" name="objects[]" value="<?php echo $counter; ?>" />
		 </td>														 
		 </tr></table>
         </li>

<?php

					$counter++;
			//	}
			}
		?>
			</ul>
            
		</td>
		</tr>
		</tbody>
		</table>  
  </div>
  <script>
  function checkPageURL(selectBox) {
	if (selectBox.options[selectBox.selectedIndex].value == "**external**") {
		jQuery("#" + selectBox.id + "_external").css("display", "inline-block");
	} else {
		jQuery("#" + selectBox.id + "_external").css("display", "none");
	}
  }
  </script>
  <div class="tab-pane" id="shortcode">
   <p>You can copy and place this shortcode within any page.  Simply click in the text area below, and press CTRL/CMD-C on your keyboard.  Then, within the edit region of your page, paste (CTRL/CMD-V) the shortcode, and then save your page.</p>
  		 <span class="input-prepend" style='padding-left: 10px; display: block;'>
           <span class="add-on" style='width: 150px'><i class='icon-share'></i> <?php _e("Shortcode", "i3d-framework"); ?></span><input readonly onclick='this.select();' onfocus='this.select();' class='input-xlarge' type="text" value="[i3d_fb id=<?php echo $id; ?>]" />
</span>
  </div>   
        
        
       
	</form>
	</div>
	<?php
}

function i3d_focal_boxes_contextual_help( $contextual_help, $screen_id, $screen ) { 
	
	if (strstr($screen->id, '_page_i3d_focal_boxes')) {
		ob_start();
		?>
        <h3>Focal Boxes</h3>
        <p>You can create as many Focal Boxes as you need for your website.  Click on the "<strong>Add New</strong>" button below to create a new Focal Box.</p>
       <?php if (I3D_Framework::$supportType == "i3d") { ?><p><a style='margin: 5px 0px;' class='btn btn-default' href="http://youtu.be/8YEIT1koYLs" target="_blank"><i class='fa fa-play-circle'></i> Watch The Help Video</a></p><?php } ?>

        
        <p><strong>Special Operations</strong></p>
        <ul>
        	<li><a onclick='return confirm("Are you certain you wish to delete all of your Focal Boxess? This cannot be undone.")' href="?page=i3d_focal_boxes&cmd=reset">Delete All Focal Boxes</a> <span class='label label-danger'>Warning -- this cannot be undone!</span></li>
        	<li><a href="?page=i3d_focal_boxes&cmd=init">Install Default Focal Boxes</a></li>
        </ul>
        <?php
	
		
		$contextual_help = ob_get_clean();

	
	}
	return $contextual_help;
}
add_action( 'contextual_help', 'i3d_focal_boxes_contextual_help', 10, 3 );

?>