<?php
function i3d_sliders() { 
	$availableSliders = I3D_Framework::getSliders();
	if (@$_GET['cmd'] == "reset") {
		update_option('i3d_sliders', array());
		wp_redirect(admin_url("admin.php?page=i3d_sliders"));
	} else if (@$_GET['cmd'] == "init") {
		I3D_Framework::init_sliders(true);
		wp_redirect(admin_url("admin.php?page=i3d_sliders"));
			
	} else if (@$_GET['cmd'] == "new" && @$_POST['cmd2'] != __('Cancel', "i3d-framework")) {
		i3d_create_slider();
		return;
	} else if (@$_POST['cmd2'] == __('Cancel', "i3d-framework")) {
		wp_redirect(admin_url("admin.php?page=i3d_sliders"));

	} else if (@$_GET['slider'] != "") {
		if (@$_GET['action'] == "trash") {
			$sliders = get_option('i3d_sliders');
			unset($sliders[$_GET['slider']]);
			
			update_option('i3d_sliders', $sliders);
			wp_redirect(admin_url("admin.php?page=i3d_sliders"));

		} else {
			i3d_slider_editor($_GET['slider']);
			return;
		}
	} else if (@$_POST['slider'] != "") {	  
		i3d_slider_editor($_POST['slider']); 
		return;
	}
  
	$sliders = get_option('i3d_sliders');
	if (!is_array($sliders)) {
		$sliders = array();
	}
  
  
?>
  <div class='wrap'>
  <h2>Sliders <a class="add-new-h2" href="admin.php?page=i3d_sliders&cmd=new">Add New</a></h2>

  <table cellspacing="0" class="wp-list-table widefat fixed posts">
	<thead>
	<tr>
		<th style="display: none;" class="manage-column column-cb check-column" id="cb" scope="col"><label for="cb-select-all-1" class="screen-reader-text">Select All</label><input type="checkbox" id="cb-select-all-1"></th>
        <th style="" class="manage-column" id="title" scope="col"><span>Title</span></th>
        <th style="width: 20%" class="manage-column" id="type" scope="col"><span>Slider Type</span></th>
        <th style="width: 10%" class="manage-column" id="slides" scope="col"><span>Slides</span></th>
    </tr>
	</thead>

	<tfoot>
	<tr>
		<th style="display: none;" class="manage-column column-cb check-column" id="cb" scope="col"><label for="cb-select-all-2" class="screen-reader-text">Select All</label><input type="checkbox" id="cb-select-all-1"></th>
        <th style="" class="manage-column" id="title" scope="col"><span>Title</span></th>
        <th style="" class="manage-column" id="type" scope="col"><span>Slider Type</span></th>
        <th style="" class="manage-column" id="slides" scope="col"><span>Slides</span></th>
    </tr>
	</tfoot>
	<tbody id="the-list">
<?php if (sizeof($sliders) == 0) { ?>
  				<tr valign="top" class="slider-none hentry alternate" id="slider-none">
				<th style='display: none;' class="check-column" scope="row">
					
							</th>
						<td class="post-title page-title column-title" colspan="3">There are currently no sliders in the system.  Click "add new" at the top of the page to create a new slider.
</td>
		</tr>

<?php } 
//var_dump($sliders);
?>
<?php foreach ($sliders as $slider) { 
  if (array_key_exists($slider['slider_type'], $availableSliders)) {
?>
    
				<tr valign="top" class="slider-<?php echo $slider['id']; ?> hentry alternate" id="slider-<?php echo $slider['id']; ?>">
				<th style='display: none;'  class="check-column" scope="row">
					<label for="cb-select-<?php echo $slider['id']; ?>" class="screen-reader-text">Select <?php echo $slider['slider_title']; ?></label>
				<input type="checkbox" value="<?php echo $slider['id']; ?>" name="slider[]" id="cb-select-<?php echo $slider['id']; ?>">
							</th>
						<td class="post-title page-title column-title"><strong><a title="Edit '<?php echo $slider['slider_title']; ?>'" href="?page=i3d_sliders&amp;slider=<?php echo $slider['id']; ?>&amp;action=edit" class="row-title"><?php echo $slider['slider_title']; ?></a></strong>
<div class="row-actions"><span class="edit"><a title="Edit this item" href="?page=i3d_sliders&slider=<?php echo $slider['id']; ?>&amp;action=edit">Edit</a> | </span><span class="trash"><a href="?page=i3d_sliders&slider=<?php echo $slider['id']; ?>&amp;action=trash" title="Delete this Slider" class="submitdelete">Delete</a></span></div>
</td>
<td class="post-author"><?php echo $availableSliders[$slider['slider_type']]['title']; ?></td>
<td class="post-author"><?php echo count($slider['slides']); ?></td>

		</tr>
<?php } 
}
?>        
		</tbody>
</table>

    </div>
    <?php
}

function i3d_create_slider() {
	//global $i3dAvailableSliders;
	$availableSliders = I3D_Framework::getSliders();
	//var_dump($availableSliders);
	
	if (@$_POST['cmd2'] == __('Create', "i3d-framework")) {
 		 $sliders = get_option('i3d_sliders');
		 $id = $_POST['id'];
		 if (@$_POST['slider_title'] != "" && @$_POST['slider_type'] != "") {
		   $sliders["{$id}"] = array('id' => $_POST['id'],
									 'slider_title' => $_POST['slider_title'],
								     'slider_type'  => $_POST['slider_type']);
		   
		   update_option('i3d_sliders', $sliders);
		  // var_dump($sliders);
		  // exit;
		  	  wp_redirect(admin_url("admin.php?page=i3d_sliders&slider={$id}&action=edit"));

		   i3d_slider_editor($id);
		   
		   return;
		 } else {
			 if (@$_POST['slider_title'] == "") {
				 $titleMessage = __("You must provide a name for this slider.","i3d-framework");
			 }
			 if ($_POST['slider_type'] == "") {
				 $typeMessage =  __("You must select a slider type.","i3d-framework");
			 }
		 }
	}
?>
  <div class='wrap'>
  <h2>Create Slider <a class="add-new-h2" href="admin.php?page=i3d_sliders">Cancel</a></h2>
  <div   id="poststuff">
<div class="postbox">
<h3 class="hndle"><span>Basic Settings</span></h3>
<div class="inside">
  <form method="post">
    <input type='hidden' name="id" value="<?php echo "s_".wp_create_nonce("i3d_slider".mktime()); ?>" />
            <table>
              <tr>
                <td style='font-weight: bold'>Slider Type</td>
                <td colspan='3'>
               
                  <select name='slider_type' id='slider_type'>
                    <option value=''>-- Choose Slider Type --</option>
					<?php foreach ($availableSliders as $sliderType => $sliderInfo) { ?>
					<option value='<?php echo $sliderType; ?>'><?php echo $sliderInfo['title']; ?></option>
                    <?php 
					}
					//echo i3d_render_select($availableSliders, @$_POST['slider_type'], "title"); ?>
                  </select><?php if (@$typeMessage != "") { ?><i style='margin-left: 10px; color: #ff0000;' class='icon-warning-sign tt' title="<?php echo $typeMessage; ?>"></i><?php } ?>
                  </td>
              </tr>
               <tr>
                <td style='font-weight: bold'>Slider Title</td>
                <td colspan='3'>
				  <input name='slider_title' id='slider_title' type="text" value="<?php echo @$_POST['slider_title']; ?>" />
                  <?php if (@$titleMessage != "") { ?><i style='margin-left: 10px; color: #ff0000;' class='icon-warning-sign tt' title="<?php echo $titleMessage; ?>"></i><?php } ?>
                </td>
              </tr>
               <tr>
                <td >&nbsp;</td>
                <td colspan='3'>
		<input type="submit" name="cmd2" class="button button-primary" value="<?php _e('Create', "i3d-framework"); ?>" />					
        <input type="submit" name="cmd2" class="button" value="<?php _e('Cancel', "i3d-framework"); ?>" />
                  </td>
              </tr>

           </table>




 </form>
      
        

      </div>
</div></div>

    </div>
<script>    
jQuery(document).ready(function(jQuery) {
								
    jQuery(".tt").tooltip();
								});
</script>
   <?php 
  
}



function i3d_slider_editor($sliderID) {
	
	
	global $wpdb;
	global $lmNivoVersion;
	global $lmPortfolioConfig;
	$sliders = get_option('i3d_sliders');
	$slider = $sliders["{$sliderID}"];
	
	$galleries = I3D_Framework::getSliders();
 
    $basicFields = array("short_description");
	if(array_key_exists("cmd", $_POST) && $_POST['cmd'] == "save") {

		$portfolioImages = array();

		if(array_key_exists("images", $_POST) && is_array($_POST['images'])) {
		  foreach($_POST['images'] as $id) {
			  if (array_key_exists($id.'__linktype', $_POST) && $_POST[$id.'__linktype'] == "external") {
				  $_POST[$id.'__link'] = @$_POST[$id.'__external__link'];
				  $_POST[$id.'__title'] = @$_POST[$id.'__external__title'];
				 // $_POST[$id.'__short_description'] = $_POST[$id.'__external__short_description'];
				  $_POST[$id.'__description'] = @$_POST[$id.'__external__description'];
				  $_POST[$id.'__link_label'] = @$_POST[$id.'__external__link_label'];
				  $_POST[$id.'__link_target'] = @$_POST[$id.'__external__link_target'];
				  $_POST[$id.'__citation'] = @$_POST[$id.'__external__citation'];
				  $_POST[$id.'__subtitle'] = @$_POST[$id.'__external__subtitle'];

				} else if (array_key_exists($id.'__linktype', $_POST) && $_POST[$id.'__linktype'] == "post") {
				  $_POST[$id.'__link'] = @$_POST[$id.'__post'];
				    $_POST[$id.'__title'] = @$_POST[$id.'__post__title'];
				  //$_POST[$id.'__short_description'] = $_POST[$id.'__page__short_description'];
				  $_POST[$id.'__description'] = @$_POST[$id.'__post__description'];
				  $_POST[$id.'__link_label'] = @$_POST[$id.'__post__link_label'];
				  $_POST[$id.'__link_target'] = @$_POST[$id.'__post__link_target'];
				  $_POST[$id.'__citation'] = @$_POST[$id.'__post__citation'];
				  $_POST[$id.'__subtitle'] = @$_POST[$id.'__post__subtitle'];
				  
				} else if (array_key_exists($id.'__linktype', $_POST) && $_POST[$id.'__linktype'] == "page") {
				  $_POST[$id.'__link'] = @$_POST[$id.'__page'];
				  
				    $_POST[$id.'__title'] = @$_POST[$id.'__page__title'];
				 
				 // $_POST[$id.'__short_description'] = $_POST[$id.'__page__short_description'];
				  $_POST[$id.'__description'] = @$_POST[$id.'__page__description'];
				  $_POST[$id.'__citation'] = @$_POST[$id.'__page__citation'];
				  $_POST[$id.'__link_label'] = @$_POST[$id.'__page__link_label'];
				  $_POST[$id.'__link_target'] = @$_POST[$id.'__page__link_target'];
				  $_POST[$id.'__subtitle'] = @$_POST[$id.'__page__subtitle'];

				}

		    if ($_POST[$id.'__image_id'] == "default") {
				  foreach ($basicFields as $key) {
					if (!array_key_exists($id."__".$key, $_POST)) {
					  $_POST[$id."__".$key] = "";
				    }
				  }

				  foreach ($basicFields as $key) {
					if (!array_key_exists($id."__".$key, $_POST)) {
					  $_POST[$id."__".$key] = "";
				    }
				  }
				  
				  $portfolioImages[] = array('id' => $_POST[$id.'__image_id'], 
											 'link_type' => $_POST[$id.'__linktype'], 
											 'image' => $_POST[$id.'__file_name'],
											 'slide_cover' => @$_POST[$id.'__slide_cover'],
											 'slide_label' => @$_POST[$id.'__slide_label'],
											 'title' => stripslashes($_POST[$id.'__title']), 
											 'citation' => stripslashes($_POST[$id.'__citation']),
											 'subtitle' => stripslashes($_POST[$id.'__subtitle']),
											 'description' => stripslashes($_POST[$id.'__description']),
											 'link' => $_POST[$id.'__link'],
											 'link_label' => $_POST[$id.'__link_label'],
											 'link_target' => $_POST[$id.'__link_target']);
			
			} else {

					//print "save new";
				  $portfolioImages[] = array('id' => $_POST[$id.'__image_id'], 
											 'link_type' => $_POST[$id.'__linktype'],
											 'title' => stripslashes($_POST[$id.'__title']), 
											 'slide_cover' => @$_POST[$id.'__slide_cover'],
											 'slide_label' => @$_POST[$id.'__slide_label'],
											 'citation' => stripslashes($_POST[$id.'__citation']),
											 'subtitle' => stripslashes($_POST[$id.'__subtitle']),
											 'description' => stripslashes($_POST[$id.'__description']),
											 'link' => $_POST[$id.'__link'],
											 'link_label' => $_POST[$id.'__link_label'],
											 'link_target' => $_POST[$id.'__link_target']);
			
			}
			
		}
	  }
	  
							//print "<pre>".print_r($portfolioImages)."</pre>";

		if (@$_POST['slider_title'] != "") {
			$sliders["{$sliderID}"]["slider_title"] = @$_POST['slider_title'];
		}
		$sliders["{$sliderID}"]["slides"] = $portfolioImages;
		$sliders["{$sliderID}"]["slide_time"] = @$_POST['slide_time'];
		$sliders["{$sliderID}"]["height"] = @$_POST['height'];
		$sliders["{$sliderID}"]["width"] = @$_POST['width'];
		if ($sliders["$sliderID"]["slider_type"] == "carousel-slider") {
			$sliders["{$sliderID}"]["background-overlay"] = @$_POST['background-overlay'];
			$sliders["{$sliderID}"]["primary-logo"] = @$_POST['primary-logo'];
			$sliders["{$sliderID}"]["primary-tagline"] = @$_POST['primary-tagline'];
			$sliders["{$sliderID}"]["sidebar"] = @$_POST['sidebar'];
			$sliders["{$sliderID}"]["secondary-logo"] = @$_POST['secondary-logo'];
			$sliders["{$sliderID}"]["secondary-tagline"] = @$_POST['secondary-tagline'];
			$sliders["{$sliderID}"]["social-media-title"] = @$_POST['social-media-title'];
			$sliders["{$sliderID}"]["social-media-icons"] = array();
			foreach ($_POST as $key => $value) {
				if (strpos($key, "social_media_icon__") !== false) {
				  $sliders["{$sliderID}"]["social-media-icons"]["{$key}"] = $value;
				}
			}
			
			
				
			
		}
		if ($sliders["$sliderID"]["slider_type"] == "welcome-slider") {
					$sliders["{$sliderID}"]["background-type"] = @$_POST['background-type'];
			$sliders["{$sliderID}"]["background-video-id"] = @$_POST['background-video-id'];
			$sliders["{$sliderID}"]["background-image-id"] = @$_POST['background-image-id'];
			$sliders["{$sliderID}"]["background-image-animation"] = @$_POST['background-image-animation'];
			$sliders["{$sliderID}"]["background-attachment"] = @$_POST['background-attachment'];
			$sliders["{$sliderID}"]["background-cover"] = @$_POST['background-cover'];
			$sliders["{$sliderID}"]["background-video-audio"] = @$_POST['background-video-audio'];
			$sliders["{$sliderID}"]["background-video-repeat"] = @$_POST['background-video-repeat'];
			$sliders["{$sliderID}"]["background-active-id"] = @$_POST['background-active-id'];
			$sliders["{$sliderID}"]["background-video-pause-on-scroll"] = @$_POST['background-video-pause-on-scroll'];
			
			
	
		}
		//unset($sliders["{$sliderID}"]["slide_time"]);
		$slider = $sliders["{$sliderID}"];
		//var_dump($slider);
		update_option("i3d_sliders", $sliders);
	}

	$pages = get_pages();
	$newPageOptions = "";

	foreach ($pages as $page) {
		$newPageOptions .= '<option value="'.$page->ID.'">';
		$newPageOptions .= addslashes($page->post_title);
		$newPageOptions .= '</option>';
	}

	$posts = get_posts(array('numberposts' => 25));
	$newPostOptions = "";

	foreach ($posts as $post) {
		$newPostOptions .= '<option value="'.$post->ID.'">';
		$newPostOptions .= addslashes($post->post_title);
		$newPostOptions .= '</option>';
	}



	$linkToTypes  = '<option value="">-- Choose Link Type --&nbsp;</option>';
	$linkToTypes .= '<option value="page">Internal Page</option>';
	$linkToTypes .= '<option value="post">Blog Post</option>';
	$linkToTypes .= '<option value="external">External URL</option>';
	?>

	<style>
	#sortable li { cursor: move; }
		#sortable label {width: 10em; display: inline-block; vertical-align: top; padding-top: 7px;}
		#sortable input.text_input {width: 200px;}
		textarea.text_input { width: 80%; height: 80px; }
		table.portfolio_image img {border: 1px solid #ccc;}
		table.portfolio_image { background-color: #ffffff;  }
		td.uploaded_images {vertical-align: top; text-align: center; background: #ddd;}
		td.uploaded_images img {margin-bottom: 5px; border: 1px solid #ccc; max-width: 80px; max-height: 80px;}
		div.imageChooser {
			background-color: #ffffff;
			width: 565px;
			z-index: 2;
		}
		div.imageChooser h4 { margin: 0px; padding: 0px; font-size: 11pt; padding-bottom: 8px;}
		div.imageChooser div { width: 100%; }
		div.imageBrowser { max-height: 159px; overflow: auto; }

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
		div.change-image-link img { margin-bottom: -5px; cursor: pointer; }
		#sortable li { border: 1px solid #dadada; }
		.update-nag { display: none; }
		#manage-sliders .input-group-addon { width: 1%; }
		#manage-sliders .input-group { white-space: nowrap; }
		#manage-sliders .input-group .right-addon { display: table-cell;  padding-left: 5px;vertical-align: middle; padding-top: 0px;}
		.welcome-slider td.thumbnail-cell { display: none; }
		
		.hidden-block { display: none !important; }
		.special_image_placeholder2 { border: 1px solid #cccccc; height: 34px; vertical-align: top;   text-align: center;
		
		-webkit-border-top-right-radius: 5px;
-webkit-border-bottom-right-radius: 5px;
-moz-border-radius-topright: 5px;
-moz-border-radius-bottomright: 5px;
border-top-right-radius: 5px;
border-bottom-right-radius: 5px;
		
		}
		
		.special_image_placeholder2 i.fa { 
		  margin: 8px;
		  color: #aaa;
		}
		
		.special_image_placeholder2 img { 
				-webkit-border-top-right-radius: 5px;
-webkit-border-bottom-right-radius: 5px;
-moz-border-radius-topright: 5px;
-moz-border-radius-bottomright: 5px;
border-top-right-radius: 5px;
border-bottom-right-radius: 5px;
max-height: 32px;
		}

  </style>

  <link rel='stylesheet' type='text/css' href='<?php echo site_url() ; ?>/wp-admin/load-styles.php?c=1&amp;load=thickbox' />
	<script type="text/javascript">
	jQuery(function($) {
		jQuery("#sortable").sortable();
	});


var stylesheetDirectory = "<?php echo get_stylesheet_directory_uri() ; ?>";



	function add_new_portfolio_item() {
		var id = "";
		var source = "";
		var title = "Example Title";
		var caption = "Example Short Description";
		var description = "Example Long Description";
		var linkLabel = "Click Here";

		jQuery("#sortable").append('<li id="image__new'+counter+'">' +
															 '<div class="imageChooser" style="display: none;" id="new'+counter+'__image_chooser">' +
																	'<table class="widefat" style="width: 100%;"><thead>' +
																	  '<tr><th style="padding-bottom: 0px;"><a style="float: right" href="javascript:closeImageBrowser(\'new'+counter+'\')" class="button add-new-h2">Close</a> <a style="float: right" onclick="goMediaWindow()" href="javascript:;"  class="button add-new-h2">Upload New Image</a><h4 style="margin-bottom: 0px; padding-bottom: 0px; margin-top: 0px;">Choose Image</h4></th></tr></thead>' +
																		'<tbody>' +
																		'<tr><td>' +
																		'' +
															 '<div class="imageBrowser"></div>' +
															 '</td></tr></tbody></table></div>' +
															 '<table id="new'+counter+'__table" class="portfolio_image" cellspacing="0" width="100%">' +
															 '<tr><td valign="top" style="width: 66px" class="thumbnail-cell">' +
															 '<a id="new'+counter+'__img_lnk" style="display: block; padding: 3px; border-radius: 5px; -moz-border-radius: 5px; -webkit-border-radius: 5px; border: 1px solid #ff0000;" href="javascript:chooseImage(\'new'+counter+'\')"><?php I3D_framework::i3d_screen_icon('no-image', 'width: 60px; border: 0px;', "new'+counter+'__img"); ?></a></td>' +
															 '<td>' +
															 '<label for="new'+counter+'__link">Link To</label><select onchange="changeLinkType(this,\'new'+counter+'\')" id="new'+counter+'__linktype" name="new'+counter+'__linktype"><?php echo $linkToTypes; ?></select><br />' +
<?php if ($slider['slider_type'] == "fullscreen-slider")   {?>
															'<div id="link_details__new'+counter+'__slide">'+
															  '<label for="new'+counter+'__slide_cover">Slide Cover</label><select id="new'+counter+'__slide_cover" name="new'+counter+'__slide_cover">'+
															  '<option value="">- No Cover -&nbsp;</option>'+
															  '<option value="vertical-line"><?php _e("Vertical Lines", "i3d-framework"); ?></option>'+
															  '<option value="dot-light"><?php _e("Light Dots", "i3d-framework"); ?></option>'+
															  '<option value="horizontal-line"><?php _e("Horizontal Lines", "i3d-framework"); ?></option>'+
															  '<option value="dot-dark"><?php _e("Dark Dots", "i3d-framework"); ?></option>'+
															  '<option value="diagonal-right"><?php _e("Diagonal Lines", "i3d-framework"); ?></option>'+
															  '</select>'+
															'</div>'+
<?php } ?>
															 '<div id="link_details__new'+counter+'__page" style="display: none;">' +
															   '<label for="new'+counter+'__page">Page</label><select onchange="changePageSelected(this,\'new'+counter+'\')" id="new'+counter+'__page" name="new'+counter+'__page"><option value="">- No Page -&nbsp;</option><?php echo $newPageOptions; ?></select><br />' +
<?php if ($slider['slider_type'] == "nivo-slider" ||																							 
		  $slider['slider_type'] == "fullscreen-carousel" ||
		  $slider['slider_type'] == "jumbotron-carousel" ||		  
		  $slider['slider_type'] == "parallax-slider" ||		  
		  $slider['slider_type'] == "bootstrap-slider" ||		  
		  $slider['slider_type'] == "fullscreen-slider" ||		  
		  $slider['slider_type'] == "welcome-slider"
		  ) {?>
	'<label for="new'+counter+'__page__title">Title</label><input type="text" class="text_input" id="new'+counter+'__page__title" name="new' +counter + '__page__title" value="'+title+'" /><br />'+
<?php } ?>																 
																 '<label for="new'+counter+'__page__description">Description</label><textarea class="text_input" id="new'+counter+'__page__description" name="new'+counter+'__page__description">'+description+'</textarea><br />' +
<?php if ($slider['slider_type'] == "fullscreen-slider")   {?>
																'<label for="new'+counter+'__page__citation">Citation</label><input type="text" class="text_input" id="new'+counter+'__page__citation" name="new'+counter+'__page__citation" value="" /><br />' +
<?php } ?>
																'<div id="link_details__new'+counter+'__page__misc" style="">' +
<?php if ($slider['slider_type'] == "nivo-slider" ||																							 
		  $slider['slider_type'] == "fullscreen-carousel" ||
		  $slider['slider_type'] == "jumbotron-carousel" ||		  
		  $slider['slider_type'] == "parallax-slider" ||		  
		  $slider['slider_type'] == "bootstrap-slider" ||		  
		  $slider['slider_type'] == "fullscreen-slider" ||		  
		  $slider['slider_type'] == "welcome-slider"
		  )   {?>																 
																	 '<label for="new'+counter+'__page__link_label">Link Label</label><input type="text" class="text_input" id="new'+counter+'__page__link_label" name="new'+counter+'__page__link_label" value="'+linkLabel+'" /><br />' +
<?php } ?>
																	 '<label for="new'+counter+'__page__link_target">Link Target</label><select id="new'+counter+'__page__link_target" name="new'+counter+'__page__link_target"><option value="_self">Current Window&nbsp;</option><option value="_blank">New Window</option></select><br />' +
																 '</div>' +
															 '</div>' +
															 '<div id="link_details__new'+counter+'__post" style="display: none;">' +
															   '<label for="new'+counter+'__post">Post</label><select onchange="changePostSelected(this,\'new'+counter+'\')" id="new'+counter+'__post" name="new'+counter+'__post"><option value="">- Newest Post -&nbsp;</option><?php echo $newPostOptions; ?></select><br />' +
																 '<div id="new'+counter+'__post__title_grp">' +
<?php if ($slider['slider_type'] == "nivo-slider" ||																							 
		  $slider['slider_type'] == "fullscreen-carousel" ||
		  $slider['slider_type'] == "jumbotron-carousel" ||		  
		  $slider['slider_type'] == "parallax-slider" ||		  
		  $slider['slider_type'] == "bootstrap-slider" ||		  
		  $slider['slider_type'] == "fullscreen-slider" ||		  
		  $slider['slider_type'] == "welcome-slider"
		  ) {?>
	'<label for="new'+counter+'__post__title">Title</label><input type="text" class="text_input" id="new'+counter+'__post__title" name="new' +counter + '__post__title" value="'+title+'" /><br />'+
<?php } ?>																 
																   '<label for="new'+counter+'__post__description">Description</label><textarea class="text_input" id="new'+counter+'__post__description" name="new'+counter+'__post__description">'+description+'</textarea><br/>' +
<?php if ($slider['slider_type'] == "fullscreen-slider")   {?>
																'<label for="new'+counter+'__post__citation">Citation</label><input type="text" class="text_input" id="new'+counter+'__post__citation" name="new'+counter+'__post__citation" value="" /><br />' +
<?php } ?>																 
																 
																 '</div>' +
																 '<div id="link_details__new'+counter+'__post__misc" style="">' +
<?php if ($slider['slider_type'] == "nivo-slider" ||																							 
		  $slider['slider_type'] == "fullscreen-carousel" ||
		  $slider['slider_type'] == "jumbotron-carousel" ||		  
		  $slider['slider_type'] == "parallax-slider" ||		  
		  $slider['slider_type'] == "bootstrap-slider" ||		  
		  $slider['slider_type'] == "fullscreen-slider" ||		  
		  $slider['slider_type'] == "welcome-slider"
		  )   {?>																 																 
																	 '<label for="new'+counter+'__post__link_label">Link Label</label><input type="text" class="text_input" id="new'+counter+'__post__link_label" name="new'+counter+'__post__link_label" value="'+linkLabel+'" /><br />' +
<?php } ?>
																	 '<label for="new'+counter+'__post__link_target">Link Target</label><select id="new'+counter+'__post__link_target" name="new'+counter+'__post__link_target"><option value="_self">Current Window&nbsp;</option><option value="_blank">New Window</option></select><br />' +
																 '</div>' +
																'</div>' +
															 '<div id="link_details__new'+counter+'__external" style="display: none;">' +
													       '<label for="new'+counter+'__external__link">External URL</label><input class="text_input" type="text" id="new' +counter + '__external__link" name="new'+counter+'__external__link" value="http://www.example.com/" /><br />' +
<?php if ($slider['slider_type'] == "nivo-slider" ||																							 
		  $slider['slider_type'] == "fullscreen-carousel" ||
		  $slider['slider_type'] == "jumbotron-carousel" ||		  
		  $slider['slider_type'] == "parallax-slider" ||		  
		  $slider['slider_type'] == "bootstrap-slider" ||		  
		  $slider['slider_type'] == "fullscreen-slider" ||		  
		  $slider['slider_type'] == "welcome-slider"
		  ) {?>
	'<label for="new'+counter+'__external__title">Title</label><input type="text" class="text_input" id="new'+counter+'__external__title" name="new' +counter + '__external__title" value="'+title+'" /><br />'+
<?php } ?>																 

'<label for="new'+counter+'__external__description">Description</label><textarea class="text_input" id="new'+counter+'__external__description" name="new'+counter+'__external__description">'+description+'</textarea><br />' +
<?php if ($slider['slider_type'] == "fullscreen-slider")   {?>
																'<label for="new'+counter+'__external__citation">Citation</label><input type="text" class="text_input" id="new'+counter+'__external__citation" name="new'+counter+'__external__citation" value="" /><br />' +
<?php } ?>
																 '<div id="link_details__new'+counter+'__misc">' +
<?php if ($slider['slider_type'] == "nivo-slider" ||																							 
		  $slider['slider_type'] == "fullscreen-carousel" ||
		  $slider['slider_type'] == "jumbotron-carousel" ||		  
		  $slider['slider_type'] == "parallax-slider" ||		  
		  $slider['slider_type'] == "bootstrap-slider" ||		  
		  $slider['slider_type'] == "fullscreen-slider" ||		  
		  $slider['slider_type'] == "welcome-slider"
		  )   {?>																								 
																	 '<label for="new'+counter+'__external__link_label">Link Label</label><input type="text" class="text_input" id="new'+counter+'__external__link_label" name="new'+counter+'__external__link_label" value="'+linkLabel+'" /><br />' +
<?php } ?>
																	 '<label for="new'+counter+'__external__link_target">Link Target</label><select id="new'+counter+'__external__link_target" name="new'+counter+'__external__link_target"><option value="_self">Current Window&nbsp;</option><option value="_blank">New Window</option></select><br />' +
																 '</div>' +
															 '</div>' +
															 '<td>&nbsp;</td>' + 

															 '</td>' + 
															 '<td valign="top" align="right" style="width: 100px;"><input type="hidden" id="new'+counter+'__image_id" name="new'+counter+'__image_id" value="'+id+'" /><input type="hidden" name="images[]" value="new'+counter+'" />' +
															 '<input class="button" type="button" name="nocmd" value="Remove" onclick="remove_portfolio_image(\'new'+counter+'\')" />' +
															 '</td>' +															 
															 '</tr></table></li>');

		counter++;
	}

	var counter = 1;
	</script>

	<div class="wrap" id="manage-sliders">
		<h2>Manage <?php print $galleries[$slider['slider_type']]['title'];?>  <a class="add-new-h2" href="admin.php?page=i3d_sliders">Cancel</a></h2>
        <h4 style='margin-top: 0px;'><?php 
		 if (@$_GET['page_id'] != "") {
		$page = get_page($_GET['page_id']);
		
		print "'".$page->post_title."' Slider";
		} else {
		//print "Default Slider";
			
		}
		?>
		</h4>
        <?php if ($galleries[$slider['slider_type']]["set_images"] == -1) { ?>
		<p style="font-style: italic;">To add an image to your slider, click on the "Add New" button, select the "Link Type", and then click on the "Image" thumbnail to the left.</p>
		<?php } ?>
		<?php $pathToCacheFolder = get_theme_root()."/".get_template()."/includes/user_view/cache/"; 
		$cacheFolder = str_replace($_SERVER['DOCUMENT_ROOT'], "", $pathToCacheFolder);
		if (!is_writable($pathToCacheFolder)) { ?>
        <div id="message" class="error fade below-h2" style='padding: 15px; display: inline-block;'><b>Warning!  "Tim-Thumb" cache folder is not writable!</b><br/>  In order to view these images in your website, you need to change the permissions on your <b><?php echo $cacheFolder; ?></b> folder to <b>755</b></div>
        <?php } ?>
        <form method="post" class="<?php echo $slider['slider_type']; ?>">
        <input type='hidden' value='<?php echo $sliderID; ?>' name='slider' />
		<table class="widefat" style="max-width: 950px; min-width: 580px;">
		<thead>

		<tr><th>
        <ul>
 <li class='inline-block-li'>
            <label class='primary-label'><?php _e("Name", "i3d-framework"); ?></label>
					  <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-header'></i></span>

           
              <input class='form-control '  style='margin-left: 0px;' type="text" placeholder="Slider Name" value="<?php echo @$slider['slider_title']; ?>" name="slider_title" />

            
				</div>
             </li>
			        
        <li class='inline-block-li'>
        <label class='primary-label'><?php _e("Slide Interval", "i3d-framework"); ?></label>
		  <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-clock-o'></i></span>

          <select name='slide_time' class='form-control'>
          <?php for ($i = 3; $i <= 10; $i++) { ?>
            <option <?php if (@$slider['slide_time'] == $i) { echo 'selected'; } ?> value='<?php echo $i; ?>'><?php echo $i; ?></option>
            <?php } ?>
         </select>
		 <div class="right-addon">
         <?php _e("seconds", "i3d-framework"); ?>
		 </div>
		 </div>
         </li>

         
            <li class='inline-block-li'>
            <label class='primary-label'><?php _e("Width", "i3d-framework"); ?></label>
					  <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-arrows-h'></i></span>

              <?php
			  
			  $sliderConfig = I3D_Framework::getSlider($slider['slider_type']);
				$imageDimension = $sliderConfig['dimensions'];
			  if (I3D_Framework::sliderDimensionConfigurable($slider['slider_type'], "width")) { ?>
              <input class='form-control '  style='margin-left: 0px; width: 75px;' type="text" placeholder="<?php echo @$imageDimension['width']; ?>" value="<?php echo @$slider['width']; ?>" name="width" />

             <?php } else { ?><div class="right-addon right-addon-bordered">
             	<?php echo @$imageDimension['width']; ?></div>
        	 <?php } ?>
				</div>
             </li>

         <?php if (I3D_Framework::sliderDimensionConfigurable($slider['slider_type'], "height")) { ?>
            <li class='inline-block-li'>
            <label class='primary-label'><?php _e("Height", "i3d-framework"); ?></label>
					  <div class="input-group input-group-indented">
            		   <span class="input-group-addon"><i class='fa fa-fw fa-arrows-v'></i></span>
			
              		   <input class='form-control' style='margin-left: 0px; width: 75px;' type="text" placeholder="<?php echo @$imageDimension['height']; ?>" value="<?php echo @$slider['height']; ?>" name="height" />
					   </div>
             </li>
		<?php } else { ?><div class="right-addon">
             	<?php echo @$imageDimension['height']; ?></div>
        <?php } ?>
		</div>
         </ul>
</th></tr>
<?php if ($slider['slider_type'] == "welcome-slider") { ?>
<tr>
  <th>
<ul>
        
        <li class='inline-block-li'>
        <label class='primary-label'><?php _e("Background", "i3d-framework"); ?></label>

		  <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-gear'></i></span>

          <select name='background-type' class='form-control' id='background-type' onchange='setBackgroundType(this)'>
		    <option value="">None</option>
			<option <?php if (@$slider['background-type'] == "video") { echo "selected"; } ?> value="video">Video</option>
			<option <?php if (@$slider['background-type'] == "image") { echo "selected"; } ?> value="image">Image</option>
			<option <?php if (@$slider['background-type'] == "active") { echo "selected"; } ?> value="active">Active Background</option>
          </select>
		 </div>
		  <div class="input-group input-group-indented input-group-background-active <?php if (@$slider['background-type'] != "active") { echo "hidden-block"; } ?>">
            <span class="input-group-addon"><i class='fa fa-fw fa-map-marker'></i></span>

			  <select name='background-active-id' class='form-control' id='background-active-id'>
				<option value="">-- Choose Active Background --</option>
				<?php   $activeBackgrounds = get_option('i3d_active_backgrounds');
  if (!is_array($activeBackgrounds)) {
	  $activeBackgrounds = array();
  }
  foreach ($activeBackgrounds as $aid => $activeBackground) { ?>
  <option value="<?php echo $activeBackground['id']; ?>" <?php if (@$slider['background-active-id'] == $activeBackground['id']) { echo "selected"; } ?>><?php echo $activeBackground['title']; ?></option>
  <?php } ?>
			  </select>
		 </div>

		 <div class="input-group input-group-indented input-group-background-video <?php if (@$slider['background-type'] != "video") { echo "hidden-block"; } ?>">
            <span class="input-group-addon"><i class='fa fa-fw fa-video-camera'></i></span>
            <input style='margin-left: 0px;' type="text" name='background-video-id' class='form-control' placeholder="example: abc123def456" value="<?php echo @$slider['background-video-id']; ?>" />
		 </div>

		  <div class="input-group input-group-indented input-group-background-video <?php if (@$slider['background-type'] != "video") { echo "hidden-block"; } ?>">
            <span class="input-group-addon"><i class='fa fa-fw fa-pause'></i></span>

			  <select name='background-video-pause-on-scroll' class='form-control' id='background-video-pause-on-scroll'>
				<option value="1">Pause On Scroll</option>
				<option <?php if (@$slider['background-video-pause-on-scroll'] == "0") { echo "selected"; } ?> value="0">Continue Playing On Scroll</option>
			  </select>
		 </div>
		 
		 
		  <div class="input-group input-group-indented input-group-background-video <?php if (@$slider['background-type'] != "video") { echo "hidden-block"; } ?>">
            <span class="input-group-addon"><i class='fa fa-fw fa-volume-up'></i></span>

			  <select name='background-video-audio' class='form-control' id='background-video-audio'>
				<option value="">Audio Off</option>
				<option <?php if (@$slider['background-video-audio'] == "1") { echo "selected"; } ?> value="1">Audio On</option>
			  </select>
		 </div>
		 
		 <div class="input-group input-group-indented input-group-background-video <?php if (@$slider['background-type'] != "video") { echo "hidden-block"; } ?>">
            <span class="input-group-addon"><i class='fa fa-fw fa-retweet'></i></span>

			  <select name='background-video-repeat' class='form-control' id='background-video-repeat'>
				<option value="">Repeat</option>
				<option <?php if (@$slider['background-video-repeat'] == "0") { echo "selected"; } ?> value="0">No Repeat</option>
			  </select>
		 </div>
		 		 		 
		  <div class="input-group input-group-indented input-group-background-image <?php if (@$slider['background-type'] != "image") { echo "hidden-block"; } ?>">
            <span class="input-group-addon"><i class='fa fa-fw fa-image'></i></span>


											<?php
											$random = rand();
                                            if(wp_attachment_is_image(@$slider['background-image-id'])) {
                                                $metaData = get_post_meta(@$slider['background-image-id'], '_wp_attachment_metadata', true);
                                                $fileName = I3D_Framework::get_image_upload_path($metaData['file']);			
                                                
                                            } else {
												$fileName = get_template_directory_uri()."/includes/admin/images/no_image_selected.png";
												$fileName = "";
                                            }


	
        ?>
		<div id="special_image_placeholder_wrapper_<?php echo $random; ?>">
	   	<div id="special_image_placeholder_<?php echo $random; ?>" class="special_image_placeholder2" style='display: inline-block;'>
			<?php if ($fileName != "") { ?>
			<img src='<?php echo $fileName; ?>' style='height: 80px;' />
			<?php } else { ?>

  <i class="fa fa-ban"></i>

			<?php } ?>
	   </div>
	   
       <input style='vertical-align: middle; display: inline-block; margin-top: 1px;' type='button' id="image_upload_button_<?php echo $random; ?>" class='button button-primary' value="<?php _e("Choose or Upload Image", "i3d-framework"); ?>" />
	   <input style='vertical-align: middle; display: inline-block;  margin-top: 1px;' type='button' id="clear_image_upload_button_<?php echo $random; ?>" class='button button-secondary <?php if ($fileName == "") { ?>hidden-block<?php } ?> ' value="<?php _e("Clear Image", "i3d-framework"); ?>" />
	   </div>
	   <input type="hidden" id="image_id" name='background-image-id' class='form-control'  value="<?php echo @$slider['background-image-id']; ?>" />
	  

<script>
var file_frame;
function setBackgroundType(selectBox) {
  selectedIndex = selectBox.selectedIndex;
  jQuery(".input-group-background-video").addClass("hidden-block");
  jQuery(".input-group-background-image").addClass("hidden-block");
  if (selectBox.options[selectedIndex].value == "image") {
  	jQuery(".input-group-background-image").removeClass("hidden-block");
  } else if (selectBox.options[selectedIndex].value == "video") {
  	jQuery(".input-group-background-video").removeClass("hidden-block");
  } else if (selectBox.options[selectedIndex].value == "active") {
  	jQuery(".input-group-background-active").removeClass("hidden-block");
	  
  }
}
jQuery('#clear_image_upload_button_<?php echo $random; ?>').live('click', function( event ){
	 		jQuery("#special_image_placeholder_<?php echo $random; ?>").html('<i class="fa fa-ban"></i>');
		jQuery("#image_id").val("");
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
		jQuery("#image_id").val(attachment.id);
		jQuery("#clear_image_upload_button_<?php echo $random; ?>").removeClass("hidden-block");
	});
 
	// Finally, open the modal
	file_frame.open();
});

function setAnimationIcon(selectBox) {
  selectedIndex = selectBox.selectedIndex;
  if (selectBox.options[selectedIndex].value == "0") {
  	jQuery(selectBox).parents("div.input-group-background-image").find(".fa-star").removeClass("fa-spin");
  } else if (selectBox.options[selectedIndex].value == "1") {
  	jQuery(selectBox).parents("div.input-group-background-image").find(".fa-star").addClass("fa-spin");
  } 
}
 </script>




          	

		 	</div>
		  <div class="input-group input-group-indented input-group-background-image <?php if (@$slider['background-type'] != "image") { echo "hidden-block"; } ?>">
            <span class="input-group-addon"><i class='fa fa-fw fa-star <?php if (@$slider['background-image-animation'] != "0") { echo "fa-spin"; } ?> '></i></span>

          <select name='background-image-animation' class='form-control' onchange="setAnimationIcon(this)">
		    <option value="1">Animation Enabled</option>
			<option  <?php if (@$slider['background-image-animation'] == "0") { echo "selected"; } ?> value="0">Animation Disabled</option>
          </select>
		 </div>
			
         </li>
		 
        
        <li class='inline-block-li'>
        <label class='primary-label'><?php _e("Background Attachment", "i3d-framework"); ?></label>

 		<div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-arrows-v'></i></span>

			  <select name='background-attachment' class='form-control' id='background-attachment'>
				<option value="">Fixed</option>
				<option <?php if (@$slider['background-attachment'] == "static") { echo "selected"; } ?> value="static">Static</option>
			  </select>
		 </div>		 
		 </div>
	   </li>
	    <li class='inline-block-li'>
        <label class='primary-label'><?php _e("Background Cover", "i3d-framework"); ?></label>

		 
		  <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-object-ungroup'></i></span>

			  <select name='background-cover' class='form-control' id='background-cover'>
				<option value="">Cover Enabled</option>
				<option <?php if (@$slider['background-cover'] == "0") { echo "selected"; } ?> value="0">Cover Disabled</option>
			  </select>
		 </div>		
		 </li>		 
		 </ul>
		 </th>
		 </tr>

<?php } ?>
<?php if ($slider['slider_type'] == "carousel-slider") { ?>
<tr>
  <th>
<ul>
        
        <li class='inline-block-li'>
        <label class='primary-label'><?php _e("Primary Branding", "i3d-framework"); ?></label>

		  <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-rocket'></i></span>

          <select name='primary-logo' class='form-control'>
		    <option value="">No Logo</option>
			<option <?php if (@$slider['primary-logo'] == "default-graphic-logo") { echo "selected"; } ?> value="default-graphic-logo">Default Graphic Logo</option>
			<option <?php if (@$slider['primary-logo'] == "default-text-logo") { echo "selected"; } ?> value="default-text-logo">Default Site Name</option>
          </select>
		 </div>
		  <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-quote-right'></i></span>

          <select name='primary-tagline' class='form-control'>
		    <option value="">No Tagline</option>
			<option <?php if (@$slider['primary-tagline'] == "default-tagline") { echo "selected"; } ?> value="default-tagline">Default Tagline</option>
          </select>
		 </div>
		  <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-image'></i></span>

          <select name='background-overlay' class='form-control'>
		    <option value="">Background Overlay Enabled</option>
			<option <?php if (@$slider['background-overlay'] == "disabled") { echo "selected"; } ?> value="disabled">Background Overlay Disabled</option>
          </select>
		 </div>
         </li>
		 </ul>
		 </th>
		 </tr>
		 <tr>
		 <td>
		 <ul>
         <li class='inline-block-li'>
			<label class='primary-label'><?php _e("Sidebar", "i3d-framework"); ?></label>
	
			  <div class="input-group input-group-indented">
				<span class="input-group-addon"><i class='fa fa-fw fa-columns'></i></span>
	
			  <select name='sidebar' class='form-control'>
				<option value="disabled">Disabled</option>
				<option <?php if (@$slider['sidebar'] == "") { echo "selected"; } ?> value="">Enabled</option>
			  </select>
			 </div>		   
		 </li>
            <li class='inline-block-li'>
        <label class='primary-label'><?php _e("Secondary Branding", "i3d-framework"); ?></label>

		  <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-rocket'></i></span>

          <select name='secondary-logo' class='form-control'>
		    <option value="">No Logo</option>
			<option <?php if (@$slider['secondary-logo'] == "default-graphic-logo") { echo "selected"; } ?> value="default-graphic-logo">Default Graphic Logo</option>
			<option <?php if (@$slider['secondary-logo'] == "default-text-logo") { echo "selected"; } ?> value="default-text-logo">Default Site Name</option>
          </select>
		 </div>
		 <?php /*
		  <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-quote-right'></i></span>

          <select name='secondary-tagline' class='form-control'>
		    <option value="">No Tagline</option>
			<option <?php if (@$slider['secondary-tagline'] == "default-tagline") { echo "selected"; } ?> value="default-tagline">Default Tagline</option>
          </select>
		 </div>
		 */ ?>
             </li>

            <li class='inline-block-li' style='max-width: 30%'>
            <label class='primary-label'><?php _e("Social Media", "i3d-framework"); ?></label>
					  <div class="input-group input-group-indented">
            		   <span class="input-group-addon"><i class='fa fa-fw fa-quote-right'></i></span>
			
              		   <input class='form-control' style='margin-left: 0px;' type="text" placeholder="Social Media Title" value="<?php echo @$slider['social-media-title']; ?>" name="social-media-title" />
					   </div>
 
 					  <div class="" style='margin-left: 10px;'>
			
<ul>
              <?php
			  		$generalSettings = get_option('i3d_general_settings');
$didRSS = false;
			  foreach ($generalSettings as $key => $value) { 
			    if (strstr($key, "social_media_") && $value != "") {
					$sm = str_replace("social_media_", "", $key);
					$sm = str_replace("_url", "", $sm);
					$didRSS = ($sm == "rss");
					?>
                <li style='width: 50px; display: inline-block; border: 1px solid #cccccc; padding: 5px; border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px;'><input style='vertical-align: top; margin-top: 3px; margin-right: 5px;' type="checkbox" id="social_media_icon__<?php echo $sm; ?>" name="social_media_icon__<?php echo $sm; ?>" value="1" <?php if (@$slider['social-media-icons']["social_media_icon__{$sm}"] == "1") { echo "checked"; } ?> /><label for="social_media_icon__<?php echo $sm; ?>"><i class="fa fa-<?php 
				if ($sm == "googleplus") {
					echo "google-plus";
				} else {
				echo $sm;
				}?>"></i></label></li>       
                <?php } 
			  }
			  if (!$didRSS) {
			  ?>   
                <li style='width: 50px; display: inline-block; border: 1px solid #cccccc; padding: 5px; border-radius: 3px; -moz-border-radius: 3px; -webkit-border-radius: 3px;'><input style='vertical-align: top; margin-top: 3px; margin-right: 5px;' type="checkbox" id="social_media_icon__rss" name="social_media_icon__rss" value="1" <?php if (@$slider['social-media-icons']["social_media_icon__rss"] == "1") { echo "checked"; } ?> /><label for="social_media_icon__rss"><i class='fa fa-fw fa-rss'></i></label></li>       
               <?php } ?>
             </ul>          
			 					   </div>

             </li>

		</div>
         </ul>  
  </td>
<?php } ?>
		</thead>
		<thead>

		<tr><th><input style='float: right; margin-right: 0px; padding: 3px 8px !important;' type="submit" name="nocmd" class="button button-primary" value="<?php _e("Save Changes", "i3d-framework"); ?>" />
   <?php if ($galleries[$slider['slider_type']]["set_images"] == -1) { ?><input onclick='add_new_portfolio_item()' style=' padding: 3px 8px !important;' type="button"  class="button" value="Add New Slide" /><?php } ?>
</th></tr><!--<th style='text-align: center'>&nbsp;</th></tr>-->
		</thead>
		<tbody>
		<?php
		
			$portfolioImages = @$slider['slides'];
			
			if ($galleries[$slider['slider_type']]["set_images"] > -1 && (!is_array($portfolioImages) || sizeof($portfolioImages) == 0)) {
				$portfolioImages = array();
				for ($imageCount = 1; $imageCount <= $galleries["$gallery"]["set_images"]; $imageCount++) {
					if ($gallery == "image_menu") {
					  $portfolioImages[] = array('id' => 'default', 'link_type' => 'menu', 'image' => '/Site/themed_images/'.$lmPortfolioConfig['default-image-prefix']."{$imageCount}.jpg", 'menu' => "0");
						
					} else {
					  $portfolioImages[] = array('id' => 'default', 'link_type' => 'page', 'image' => '/Site/themed_images/'.$lmPortfolioConfig['default-image-prefix']."{$imageCount}.jpg",'title' => "Topic #{$imageCount}",'short_description' => 'Short description goes here','description' => "Topic #{$imageCount} Description",'link' => '','link_label' => '','link_target' => '_self');
					}
				}
				if ($gallery == "accordion_menu") {
					$portfolioImages = array("text" => array("title" => "Header Content Region", "text" => "Insert text or just delete this text and leave this area blank! Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s."),
										 "images" => $portfolioImages);		
				}
				update_option($galleries[$gallery]['settings'], $portfolioImages);
			} 
			
			$counter = 0;
			if (!is_array($portfolioImages)) {
				$portfolioImages = array();
			}

?>
		<tr>
		<td valign="top">
<?php

			echo '<ul id="sortable">';
			foreach($portfolioImages as $image) {
			//	var_dump($image);
			//only list image if it still exists
				//if(wp_attachment_is_image($image['id']) || $image['id'] == "default") {

					$pageOptions = "";
					$postOptions = "";
					$isPage     = $image['link_type'] == "page";
					$isPost     = $image['link_type'] == "post";
					$isExternal = $image['link_type'] == "external";
					$isMenu     = $image['link_type'] == "menu";
					$isPlain 	= $image['link_type'] == "none";
					
					
					foreach ($pages as $page) {

						if(@$image['link'] == $page->ID) {
							$pageOptions .= '<option selected="selected" value="'.$page->ID.'">';
							$pageOptions .= $page->post_title;
							$pageOptions .= '</option>';
						//	$isInternal = true;
						} else {
							$pageOptions .= '<option value="'.$page->ID.'">';
							$pageOptions .= $page->post_title;
							$pageOptions .= '</option>';
						}
					}

					foreach ($posts as $post) {

						if(@$image['link'] == $post->ID) {
							$postOptions .= '<option selected="selected" value="'.$post->ID.'">';
							$postOptions .= $post->post_title;
							$postOptions .= '</option>';

						//	$isInternal = true;
						} else {
							$postOptions .= '<option value="'.$post->ID.'">';
							$postOptions .= $post->post_title;
							$postOptions .= '</option>';
						}
					}
	
						$linkToTypes  = '<option value="">-- Choose Link Type --&nbsp;</option>';
						$linkToLabel = "Link To";
	$linkToTypes .= '<option '.($image['link_type'] == "page" ? "selected='selected'" : "").' value="page">Internal Page</option>';
	$linkToTypes .= '<option '.($image['link_type'] == "post" ? "selected='selected'" : "").'  value="post">Blog Post</option>';
	$linkToTypes .= '<option '.($image['link_type'] == "external" ? "selected='selected'" : "").' value="external">External URL</option>';

				
?>
				<li id="image__<?php echo $counter; ?>">
															 <div class="imageChooser" style="display: none;" id="<?php echo $counter; ?>__image_chooser">
																	<table class="widefat" style="width: 100%;"><thead>
																	  <tr><th style="padding-bottom: 0px;"><a style="float: right;" href="javascript:closeImageBrowser('<?php echo $counter; ?>')" class="button add-new-h2">Close</a> <a style="float: right" onclick="goMediaWindow()" href="javascript:;"  class="button add-new-h2">Upload New Image</a><h4 style="margin-bottom: 0px; padding-bottom: 0px; margin-top: 0px;">Choose Image</h4></th></tr></thead>
																		<tbody>
																		<tr><td>

															 <div class="imageBrowser"></div>
															 </td></tr></tbody></table></div>
        	<table id="<?php echo $counter; ?>__table" class="portfolio_image" cellspacing="0" width="100%">
          	<tr>


                                <?php if($image['id'] == "default") { ?>
																	<td valign="top" width="66px" class="thumbnail-cell"><a id="<?php echo $counter; ?>__img_lnk" class='change-image-link' href="javascript:chooseImage('<?php echo $counter; ?>')"><img id='<?php echo $counter; ?>__img' src="<?php print get_template_directory_uri() .$image['image']?>"  width="60" /><input type="hidden" name="<?php echo $counter; ?>__file_name" value="<?php echo $image['image']; ?>"  /></a></td>
																<?php } else if ($image['id'] == "x") { ?>
																<?php } else if ($image['id'] == "") { ?>
                                 <td valign="top" style="width: 66px" class="thumbnail-cell"><div id="<?php echo $counter; ?>__img_lnk" class='change-image-link' onclick="chooseImage('<?php echo $counter; ?>')"><?php I3D_framework::i3d_screen_icon('no-image', 'width: 60px; border: 0px;', "{$counter}__img"); ?></div></td>
																<?php } else if ($image['id'] == "featured_image") {
																		$imageID = get_post_meta($image['link'], '_thumbnail_id', true);
																	//	$postData = get_post($_POST['resource_id']);
																		$large_image_url = wp_get_attachment_image_src( $imageID);
																		if ($large_image_url != "") { ?>
                                     <td valign="top" style="width: 66px"><div id="<?php echo $counter; ?>__img_lnk" class='change-image-link' onclick="chooseImage('<?php echo $counter; ?>')"><?php echo str_replace("/>", "id='{$counter}__img' />", wp_get_attachment_image($imageID, array(60, 60), false)); ?></div>
                                     </td>

                                    <?php

																		} else { ?>
                                 <td valign="top" style="width: 66px"><div id="<?php echo $counter; ?>__img_lnk" class='change-image-link' onclick="chooseImage('<?php echo $counter; ?>')"><?php I3D_framework::i3d_screen_icon('featured-post', 'width: 60px; border: 0px;', "{$counter}__img"); ?></div></td>


                                    <?php
																		}

																?>


																<?php } else { ?>
                                 <td valign="top" style="width: 66px"><div id="<?php echo $counter; ?>__img_lnk" class='change-image-link' onclick="chooseImage('<?php echo $counter; ?>')"><?php echo str_replace("/>", "id='{$counter}__img' />", wp_get_attachment_image($image['id'], array(60, 60), false)); ?></div></td>
                                <?php } ?>
															 <td>
															 
															 
															
															 <label for="<?php echo $counter; ?>__link"><?php echo $linkToLabel; ?></label><select onchange="changeLinkType(this,'<?php echo $counter; ?>')" id="<?php echo $counter; ?>__linktype" name="<?php echo $counter; ?>__linktype"><?php echo $linkToTypes;?></select><br />
															
<?php if ($slider['slider_type'] == "fullscreen-slider") { ?>
<div id="link_details__<?php echo $counter; ?>__slide">
  <label for="<?php echo $counter; ?>__slide_cover">Slide Cover</label><select id="<?php echo $counter; ?>__slide_cover" name="<?php echo $counter; ?>__slide_cover">
  <option value="">- No Cover -&nbsp;</option>
  <option value="vertical-line" <?php if ($image['slide_cover'] == "vertical-line") { print "selected"; } ?>><?php _e("Vertical Lines","i3d-framework"); ?></option>
  <option value="dot-light" <?php if ($image['slide_cover'] == "dot-light") { print "selected"; } ?>><?php _e("Light Dots","i3d-framework"); ?></option>
  <option value="horizontal-line" <?php if ($image['slide_cover'] == "horizontal-line") { print "selected"; } ?>><?php _e("Horizontal Lines","i3d-framework"); ?></option>
  <option value="dot-dark" <?php if ($image['slide_cover'] == "dot-dark") { print "selected"; } ?>><?php _e("Dark Dots","i3d-framework"); ?></option>
  <option value="diagonal-right" <?php if ($image['slide_cover'] == "diagonal-right") { print "selected"; } ?>><?php _e("Diagonal Lines","i3d-framework"); ?></option>
  </select>
</div>
<?php } ?>
<?php if ($slider['slider_type'] == "carousel-slider") { ?>
<label for="<?php echo $counter; ?>__page__slide_label">Slide Label</label><input type="text" class="text_input" id="<?php echo $counter; ?>__slide_label" name="<?php echo $counter; ?>__slide_label" value="<?php echo @$image['slide_label']; ?>" /><br />
<?php } ?>											 
                                                             
                                                             <div id="link_details__<?php echo $counter; ?>__page" <?php if (!$isPage) { echo 'style="display: none;"'; } ?>>
															   <label for="<?php echo $counter; ?>__page">Page</label><select onchange="changePageSelected(this,'<?php echo $counter; ?>')" id="<?php echo $counter; ?>__page" name="<?php echo $counter; ?>__page"><option value="">- No Page -&nbsp;</option><?php echo $pageOptions;?></select><br />
<?php if ($slider['slider_type'] == "nivo-slider" ||																							 
		  $slider['slider_type'] == "fullscreen-carousel" ||
		  $slider['slider_type'] == "jumbotron-carousel" ||		  
		  $slider['slider_type'] == "bootstrap-slider" ||		  
		  $slider['slider_type'] == "parallax-slider" ||		  
		  $slider['slider_type'] == "fullscreen-slider" ||		  
		  $slider['slider_type'] == "carousel-slider" ||		  
		  $slider['slider_type'] == "welcome-slider") {?>
	<label for="<?php echo $counter; ?>__page__title">Title</label><input type="text" class="text_input" id="<?php echo $counter; ?>__page__title" name="<?php echo $counter; ?>__page__title" value="<?php echo $image['title']; ?>" /><br />
<?php } ?>
<?php if ($slider['slider_type'] == "carousel-slider" ||	$slider['slider_type'] == "bootstrap-slider" ||		  
		  $slider['slider_type'] == "welcome-slider") { ?>
<label for="<?php echo $counter; ?>__page__subtitle">Sub-Title</label><input type="text" class="text_input" id="<?php echo $counter; ?>__page__subtitle" name="<?php echo $counter; ?>__page__subtitle" value="<?php echo @$image['subtitle']; ?>" /><br />
<?php } ?>
																 <label for="<?php echo $counter; ?>__page__description"><?php if (
		  $slider['slider_type'] == "fullscreen-slider" || $slider['slider_type'] == "caroucel-slider" || $slider['slider_type'] == "welcome-slider" || $slider['slider_type'] == "bootstrap-slider") {?>Description<?php } else { ?>Alternate Text<?php } ?></label><textarea class="text_input" id="<?php echo $counter; ?>__page__description" name="<?php echo $counter; ?>__page__description"><?php echo $image['description']; ?></textarea><br />
<?php if ($slider['slider_type'] == "fullscreen-slider") { ?>
<label for="<?php echo $counter; ?>__page__citation">Citation</label><input type="text" class="text_input" id="<?php echo $counter; ?>__page__citation" name="<?php echo $counter; ?>__page__citation" value="<?php echo $image['citation']; ?>" /><br />
<?php } ?>

          
																 <div id="link_details__<?php echo $counter; ?>__page__misc" <?php if ($isPage && $image['link'] == "" || !$isPage) { echo 'style="display: none;"'; } ?>>
																	 <label for="<?php echo $counter; ?>__page__link_target">Link Target</label><select id="<?php echo $counter; ?>__page__link_target" name="<?php echo $counter; ?>__page__link_target"><option value="_self">Current Window&nbsp;</option><option <?php echo (@$image['link_target'] == "_blank" ? ' selected="selected"' : ''); ?> value="_blank">New Window</option></select><br />
<?php if ($slider['slider_type'] == "nivo-slider" ||																								 
		  $slider['slider_type'] == "fullscreen-carousel" ||
		  $slider['slider_type'] == "jumbotron-carousel" ||		  
		  $slider['slider_type'] == "parallax-slider" ||	  
		  $slider['slider_type'] == "video-slider" ||		  
		  $slider['slider_type'] == "bootstrap-slider" ||		  
		  $slider['slider_type'] == "fullscreen-slider" ||		  
		  $slider['slider_type'] == "carousel-slider" ||		  
		  $slider['slider_type'] == "welcome-slider") {?>
<label for="<?php echo $counter; ?>__page__link_label"><?php if ($slider['slider_type'] == "fullscreen-slider" || $slider['slider_type'] == "bootstrap-slider") { ?>Button<?php } else { ?>Link<?php } ?> Label</label><input type="text" class="text_input" id="<?php echo $counter; ?>__page__link_label" name="<?php echo $counter; ?>__page__link_label" value="<?php echo @$image['link_label']; ?>" /><br />
<?php } ?>
                                                                     
																 </div>
															 </div>
                                                             
															 <div id="link_details__<?php echo $counter; ?>__post" <?php if (!$isPost) { echo 'style="display: none;"'; } ?>>
															   <label for="<?php echo $counter; ?>__post">Post</label><select onchange="changePostSelected(this,'<?php echo $counter; ?>')" id="<?php echo $counter; ?>__page" name="<?php echo $counter; ?>__post"><option value="">- Newest Post -&nbsp;</option><?php echo $postOptions; ?></select><br />
<?php if ($slider['slider_type'] == "nivo-slider"	||																							 
		  $slider['slider_type'] == "fullscreen-carousel" ||
		  $slider['slider_type'] == "jumbotron-carousel" ||		  
		  $slider['slider_type'] == "parallax-slider" ||		  
		  $slider['slider_type'] == "amazing-slider" ||		  
		  $slider['slider_type'] == "bootstrap-slider" ||		  
		  $slider['slider_type'] == "video-slider" ||		  
		  $slider['slider_type'] == "fullscreen-slider" ||		  
		  $slider['slider_type'] == "carousel-slider" ||		  
		  $slider['slider_type'] == "welcome-slider") { ?>
	<label for="<?php echo $counter; ?>__post__title">Title</label><input type="text" class="text_input" id="<?php echo $counter; ?>__post__title" name="<?php echo $counter; ?>__post__title" value="<?php echo $image['title']; ?>" /><br />
<?php } ?>
<?php if ($slider['slider_type'] == "carousel-slider" ||		 
				  $slider['slider_type'] == "bootstrap-slider" ||	
		  $slider['slider_type'] == "welcome-slider") { ?>
<label for="<?php echo $counter; ?>__post__subtitle">Sub-Title</label><input type="text" class="text_input" id="<?php echo $counter; ?>__post__subtitle" name="<?php echo $counter; ?>__post__subtitle" value="<?php echo @$image['subtitle']; ?>" /><br />
<?php } ?>

<label for="<?php echo $counter; ?>__post__description"><?php if ($slider['slider_type'] == "fullscreen-slider" || $slider['slider_type'] == "bootstrap-slider" || $slider['slider_type'] == "carousel-slider") {?>Description<?php } else { ?>Alternate Text<?php } ?></label><textarea class="text_input" id="<?php echo $counter; ?>__post__description" name="<?php echo $counter; ?>__post__description"><?php echo $image['description']; ?></textarea><br />
<?php if ($slider['slider_type'] == "fullscreen-slider") { ?>
<label for="<?php echo $counter; ?>__post__citation">Citation</label><input type="text" class="text_input" id="<?php echo $counter; ?>__post__citation" name="<?php echo $counter; ?>__post__citation" value="<?php echo $image['citation']; ?>" /><br />
<?php } ?>
<div id="link_details__<?php echo $counter; ?>__post__misc" <?php if (!$isPost && false) { echo 'style="display: none;"'; } ?>>
																	 <label for="<?php echo $counter; ?>__post__link_target">Link Target</label><select id="<?php echo $counter; ?>__post__link_target" name="<?php echo $counter; ?>__post__link_target"><option value="_self">Current Window&nbsp;</option><option <?php echo (@$image['link_target'] == "_blank" ? ' selected="selected"' : ''); ?> value="_blank">New Window</option></select><br />
<?php if ($slider['slider_type'] == "nivo-slider" ||																							 
		  $slider['slider_type'] == "fullscreen-carousel" ||
		  $slider['slider_type'] == "jumbotron-carousel" ||		  
		  $slider['slider_type'] == "parallax-slider" ||		  
		  $slider['slider_type'] == "amazing-slider" ||		  
		  $slider['slider_type'] == "bootstrap-slider" ||		  
		  $slider['slider_type'] == "video-slider" ||		  
		  $slider['slider_type'] == "fullscreen-slider" ||		  
		  $slider['slider_type'] == "carousel-slider" ||		  
		  $slider['slider_type'] == "welcome-slider") { ?>
	<label for="<?php echo $counter; ?>__post__link_label"><?php if ($slider['slider_type'] == "fullscreen-slider" ||		  
		  $slider['slider_type'] == "carousel-slider" ||	
		  $slider['slider_type'] == "bootstrap-slider" ||
		  $slider['slider_type'] == "welcome-slider") { ?>Button<?php } else { ?>Link<?php } ?> Label</label><input type="text" class="text_input" id="<?php echo $counter; ?>__post__link_label" name="<?php echo $counter; ?>__post__link_label" value="<?php echo @$image['link_label']; ?>" /><br />
<?php } ?>
																 </div>
															 </div>
                                                             <div id="link_details__<?php echo $counter; ?>__external" <?php if (!$isExternal) { echo 'style="display: none;"'; } ?>>
													       <label for="<?php echo $counter; ?>__external__link">External URL</label><input class="text_input" type="text" id="<?php echo $counter; ?>__external__link" name="<?php echo $counter; ?>__external__link" value="<?php if ($isExternal) { echo @$image['link']; } else { echo "http://www.example.com/"; } ?>" /><br />
<?php if ($slider['slider_type'] == "nivo-slider" ||																							 
		  $slider['slider_type'] == "fullscreen-carousel" ||
		  $slider['slider_type'] == "jumbotron-carousel" ||		  
		  $slider['slider_type'] == "parallax-slider" ||		  
		  $slider['slider_type'] == "amazing-slider" ||		  
		  $slider['slider_type'] == "bootstrap-slider" ||		  
		  $slider['slider_type'] == "video-slider" ||		  
		  $slider['slider_type'] == "fullscreen-slider" ||		  
		 $slider['slider_type'] == "carousel-slider" ||		  
		  $slider['slider_type'] == "welcome-slider") {?>
	<label for="<?php echo $counter; ?>__external__title">Title</label><input type="text" class="text_input" id="<?php echo $counter; ?>__external__title" name="<?php echo $counter; ?>__external__title" value="<?php echo $image['title']; ?>" /><br />
<?php } ?>
<?php if ($slider['slider_type'] == "carousel-slider" ||
		  $slider['slider_type'] == "bootstrap-slider" ||		  
		  $slider['slider_type'] == "welcome-slider") { ?>
<label for="<?php echo $counter; ?>__external__subtitle">Sub-Title</label><input type="text" class="text_input" id="<?php echo $counter; ?>__external__subtitle" name="<?php echo $counter; ?>__external__subtitle" value="<?php echo @$image['subtitle']; ?>" /><br />
<?php } ?>                                                              
																 <label for="<?php echo $counter; ?>__external__description"><?php if ($slider['slider_type'] == "carousel-slider" ||$slider['slider_type'] == "bootstrap-slider" ||
		  $slider['slider_type'] == "fullscreen-slider") {?>Description<?php } else { ?>Alternate Text<?php } ?></label><textarea class="text_input" id="new<?php echo $counter; ?>__external__description" name="<?php echo $counter; ?>__external__description"><?php echo $image['description']; ?></textarea><br />
																 
<?php if ($slider['slider_type'] == "fullscreen-slider") { ?>
<label for="<?php echo $counter; ?>__external__citation">Citation</label><input type="text" class="text_input" id="<?php echo $counter; ?>__external__citation" name="<?php echo $counter; ?>__external__citation" value="<?php echo $image['citation']; ?>" /><br />
<?php } ?>                                                                 
                                                                 <div id="link_details__<?php echo $counter; ?>__misc">
																	 <label for="<?php echo $counter; ?>__external__link_target">Link Target</label><select id="<?php echo $counter; ?>__external__link_target" name="<?php echo $counter; ?>__external__link_target"><option value="_self">Current Window&nbsp;</option><option <?php echo (@$image['link_target'] == "_blank" ? ' selected="selected"' : ''); ?> value="_blank">New Window</option></select><br />

<?php if ($slider['slider_type'] == "nivo-slider" ||																								 
		  $slider['slider_type'] == "fullscreen-carousel" ||
		  $slider['slider_type'] == "jumbotron-carousel" ||		  
		  $slider['slider_type'] == "parallax-slider" ||		  
		  $slider['slider_type'] == "bootstrap-slider" ||		  
		  $slider['slider_type'] == "fullscreen-slider" ||		  
		 
		  $slider['slider_type'] == "carousel-slider" ||		  
		  $slider['slider_type'] == "welcome-slider") {?>
	<label for="<?php echo $counter; ?>__external__link_label"><?php if ($slider['slider_type'] == "fullscreen-slider" || $slider['slider_type'] == "bootstrap-slider") { ?>Button<?php } else { ?>Link<?php } ?> Label</label><input type="text" class="text_input" id="<?php echo $counter; ?>__external__link_label" name="<?php echo $counter; ?>__external__link_label" value="<?php echo @$image['link_label']; ?>" /><br />
<?php } ?>

																 </div>
															 </div>
															 
															 </td><td valign="top" align="right" style="width: 100px;"><input type="hidden" id="<?php echo $counter; ?>__image_id" name="<?php echo $counter; ?>__image_id" value="<?php echo $image['id']; ?>" /><input type="hidden" name="images[]" value="<?php echo $counter; ?>" />
															<input class='button' type="button" name="nocmd" value="Remove" onclick="remove_portfolio_image('<?php echo $counter; ?>')" />

															 </td></tr></table></li>

<?php

					$counter++;
			//	}
			}
		?>
			</ul>
			<input type="hidden" name="cmd" value="save" />
		</td>
		</tr>
		</tbody>
		</table>
	</form>
	</div>
	<?php
}

function i3d_sliders_contextual_help( $contextual_help, $screen_id, $screen ) { 
	if (I3D_Framework::$supportType == "i3d") { 

	if (strstr($screen->id, '_page_i3d_sliders')) {
		ob_start();
		?>
        <h3>Sliders</h3>
        <p>You can create as many sliders as you need for your website.  Click on the "<strong>Add New</strong>" button below to create a slider.</p>
        <p><a style='margin: 5px 0px;' class='btn btn-default' href="http://youtu.be/PNa5Ixc7RII" target="_blank"><i class='fa fa-play-circle'></i> Watch The Help Video</a></p>


        <p><strong>Special Operations</strong></p>
        <ul>
        	<li><a onclick='return confirm("Are you certain you wish to delete all of your sliders? This cannot be undone.")' href="?page=i3d_sliders&cmd=reset">Delete All Sliders</a> <span class='label label-danger'>Warning -- this cannot be undone!</span></li>
        	<li><a href="?page=i3d_sliders&cmd=init">Install Default Sliders</a></li>
        </ul>
        <?php
		
		
		$contextual_help = ob_get_clean();

	} 
	}
	return $contextual_help;
}
add_action( 'contextual_help', 'i3d_sliders_contextual_help', 10, 3 );

?>