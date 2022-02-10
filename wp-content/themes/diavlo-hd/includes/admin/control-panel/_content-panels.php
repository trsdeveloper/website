<?php
function i3d_content_panels() { 
 
  if (@$_GET['cmd'] == "reset") {
	update_option('i3d_content_panel_groups', array());
	wp_redirect(admin_url("admin.php?page=i3d_content_panels"));
   } else if (@$_GET['cmd'] == "init") {
	  I3D_Framework::init_content_panel_groups(true);
	wp_redirect(admin_url("admin.php?page=i3d_content_panels"));
 
  } else if (@$_GET['cmd'] == "new" && @$_POST['cmd2'] != __('Cancel', "i3d-framework")) {
	  i3d_create_content_group();
      return;
  } else if (@$_POST['cmd2'] == __('Cancel', "i3d-framework")) {
	  
	wp_redirect(admin_url("admin.php?page=i3d_content_panels"));

  } else if (@$_GET['group'] != "") {
	if (@$_GET['action'] == "trash") {
	  $panelGroups = get_option('i3d_content_panel_groups');
	  unset($panelGroups[$_GET['group']]);
	  update_option('i3d_content_panel_groups', $panelGroups);
	  wp_redirect(admin_url("admin.php?page=i3d_content_panels"));

	} else {
	  i3d_content_group_editor($_GET['group']);
	  return;
	}
  } else if (@$_POST['group'] != "") {
	 // print "yes";
	  
	 i3d_content_group_editor(@$_POST['group']); 
	 return;
  }
  
  $panelGroups = get_option('i3d_content_panel_groups');
  if (!is_array($panelGroups)) {
	  $panelGroups = array();
  }
  
  
?>
  <div class='wrap'>
  <h2>Content Panel Groups <a class="add-new-h2" href="admin.php?page=i3d_content_panels&cmd=new">Add New</a></h2>
    <p>A content panel group is a set of content regions, organized so that you can switch between the content regions, either by way of TAB or COLLAPSABLE ACCORDION.</p>
  <!--  <a style='margin: 5px 0px;' class='button button-primary' href="http://youtu.be/ProIrVGePk4" target="_blank"><i class='icon-youtube'></i> Watch The Help Video</a>-->

  <table cellspacing="0" class="wp-list-table widefat fixed posts">
	<thead>
	<tr>
		<th style="display: none;"  class="manage-column column-cb check-column" id="cb" scope="col"><label for="cb-select-all-1" class="screen-reader-text">Select All</label><input type="checkbox" id="cb-select-all-1"></th>
        <th style="" class="manage-column" id="title" scope="col"><span>Title</span></th>
    </tr>
	</thead>

	<tfoot>
	<tr>
		<th style="display: none;"  class="manage-column column-cb check-column" id="cb" scope="col"><label for="cb-select-all-2" class="screen-reader-text">Select All</label><input type="checkbox" id="cb-select-all-1"></th>
        <th style="" class="manage-column" id="title" scope="col"><span>Title</span></th>
    </tr>
	</tfoot>
	<tbody id="the-list">
<?php if (sizeof($panelGroups) == 0) { ?>
  				<tr valign="top" class="slider-none hentry alternate" id="slider-none">
				<th style="display: none;" class="check-column" scope="row">
					
							</th>
						<td class="post-title page-title column-title" colspan="1">There are currently no content panel groups created.  Click "add new" at the top of the page to create a panel group.
</td>
		</tr>

<?php } 
//var_dump($sliders);
?>
<?php foreach ($panelGroups as $panelGroup) { ?>
    
				<tr valign="top" class="slider-<?php echo $panelGroup['id']; ?> hentry alternate" id="slider-<?php echo $panelGroup['id']; ?>">
				<th style="display: none;"  class="check-column" scope="row">
					<label for="cb-select-<?php echo $panelGroup['id']; ?>" class="screen-reader-text">Select <?php echo $panelGroup['title']; ?></label>
				<input type="checkbox" value="<?php echo $panelGroup['id']; ?>" name="slider[]" id="cb-select-<?php echo $panelGroup['id']; ?>">
							</th>
						<td class="post-title page-title column-title"><strong><a title="Edit '<?php echo $panelGroup['title']; ?>'" href="?page=i3d_content_panels&group=<?php echo $panelGroup['id']; ?>&amp;action=edit" class="row-title"><?php echo $panelGroup['title']; ?></a></strong>
<div class="row-actions"><span class="edit"><a title="Edit this item" href="?page=i3d_content_panels&group=<?php echo $panelGroup['id']; ?>&amp;action=edit">Edit</a> | </span><span class="trash"><a href="?page=i3d_content_panels&group=<?php echo $panelGroup['id']; ?>&amp;action=trash" title="Delete this Form" class="submitdelete">Delete</a></span></div>
</td>
		</tr>
<?php } ?>        
		</tbody>
</table>

    </div>
    <?php
}

function i3d_create_content_group() {
 		 $groups = get_option('i3d_content_panel_groups');
		 $id = "cpg_".I3D_Framework::get_unique_id("i3d_content_panel_group");
		   $groups["{$id}"] = array('id' => $id,
									 'title' => "New Content Panel Group",
									 'content_type' => "tabs"
								     );
		   
		   update_option('i3d_content_panel_groups', $groups);
		   wp_redirect(admin_url("admin.php?page=i3d_content_panels&group={$id}&action=edit"));

		   
		   return;

  
}

function i3d_content_group_editor($groupID) {
	global $wpdb;
	$groups = get_option('i3d_content_panel_groups');
	$group  = $groups["{$groupID}"];
	 
	if(array_key_exists("cmd", $_POST) && $_POST['cmd'] == "save") {
		 foreach ($_POST as $x => $y) {
	   //  print $x."=".$y."<br>";
         }

		$panels = array();
//print "up";
		if(array_key_exists("panels", $_POST) && is_array($_POST['panels'])) {
		  foreach($_POST['panels'] as $id) {
			  $panels[] = array('icon' => $_POST["{$id}__icon"],
								'label' => $_POST["{$id}__label"],
								'content' => stripslashes($_POST["{$id}__content"]));
								
			 
		}
	  }
		//$sliders["{$sliderID}"]["slides"] = $portfolioImages;
		$groups["{$groupID}"]["title"]          = stripslashes($_POST['title']);
		$groups["{$groupID}"]["content_type"]   = stripslashes($_POST['content_type']);
		$groups["{$groupID}"]["title_wrap"]     = stripslashes($_POST['title_wrap']);
		$groups["{$groupID}"]["description"]     = stripslashes($_POST['description']);
		$groups["{$groupID}"]["panels"]   = $panels;
		$group = $groups["{$groupID}"];
		//var_dump($group);
		update_option("i3d_content_panel_groups", $groups);
	}



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

  </style>

  <link rel='stylesheet' type='text/css' href='<?php echo site_url() ; ?>/wp-admin/load-styles.php?c=1&amp;load=thickbox' />
	<script type="text/javascript">
	jQuery(function($) {
		jQuery("#sortable").sortable({cancel: ".wp-editor-wrap,.fa-icon-chooser,input,textarea,button,select,option" });
	    //jQuery("#sortable li").resizable({grid: 50});
	});



	var stylesheetDirectory = "<?php echo get_stylesheet_directory_uri() ; ?>";


	function remove_panel(id) {
		//get containing div element (container)
		var container = document.getElementById('sortable');

		//get div element to remove
		var olddiv = document.getElementById('panel__'+id);

		//remove the div element from the container
		container.removeChild(olddiv);
	}	
	<?php 
	ob_start();
    //wp_editor( "", "FIELDID", array('textarea_rows' => 3, 'media_buttons' => false) );
	$editor = ob_get_clean();
	$editor = str_replace("\n", "", $editor);
	$editor = str_replace("'", "\\'", $editor);
	$editor = str_replace("FIELDID", "new__'+counter+'", $editor);
	ob_start();
	I3D_Framework::renderFontAwesomeSelect("{$counter}__icon", $panel['icon']); 
	$icon = ob_get_clean();
	$icon = str_replace("\r\n", "", $icon);
	$icon = str_replace("'", "\\'", $icon);
	?> 
	
	function add_new_panel_item() {
		var id = "";
		var source = "";
		var title = "Example Field Name";
		var caption = "Example Default Value";
		var description = "Example Long Description";
		var linkLabel = "Click Here";

		jQuery("#sortable").append('<li id="panel__new'+counter+'" class="span12">' +
		 '<table id="new'+counter+'__table" class="form_field" cellspacing="0" width="100%" height="100%">' +
		 '<tr>' + 													 
		 '<td>' +
		 '<label for="new'+counter+'__icon">Icon</label>' + 
         '<input type="text" id="new'+counter+'_icon" name="new'+counter+'__icon" value="" /><br />' +
		 '<label for="new'+counter+'__label">Label</label><input type="text" id="new'+counter+'__label" name="new'+counter+'__label" value="" /><br />' +
		 '<label for="new'+counter+'__content">Content</label>' + 
         '<textarea type="text" id="new'+counter+'_content" name="new'+counter+'__content"></textarea><br />' +
		 '<input type="hidden" id="new'+counter+'__panel_id" name="new'+counter+'__panel_id" value="'+id+'" /><input type="hidden" name="panels[]" value="new'+counter+'" />' +
		 '<input class="remove button" type="button" name="nocmd" value="Remove" onclick="remove_panel(\'new'+counter+'\')" />' +
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
</style>
	<div class="wrap">
	

		<h2>Manage Content Panel Group Form  <a class="add-new-h2" href="admin.php?page=i3d_content_panels">Cancel</a></h2>

   <form method="post">
<input style='float: right; padding: 0px 0px !important; width: 150px; margin-right: 10px;' type="submit" name="nocmd" class="button button-primary" value="<?php _e("Save Changes", "i3d-framework"); ?>" />
<ul class="nav nav-tabs">
  <li <?php if (@$_POST['cmd'] != "save") { ?>class="active"<?php } ?>><a href="#settings" data-toggle="tab">Settings</a></li>
  <li <?php if (@$_POST['cmd'] == "save") { ?>class="active"<?php } ?>><a href="#panels" data-toggle="tab">Content Panels</a></li>
  <li><a href="#shortcode" data-toggle="tab">Shortcode</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane <?php if (@$_POST['cmd'] != "save") { ?>active<?php } ?>" id="settings">
  <ul style='max-width: 950px;' class='form-options'>
   <ul style='max-width: 950px;' class='form-options'>
          <li>
          <label><?php _e("Title", "i3d-framework"); ?></label>
      <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-text-height'></i> <?php _e("Size", "i3d-framework"); ?></span>
          

          <select name="title_wrap"   class='form-control' style='max-width: 200px' >
            <option value="x" <?php if (@$group['title_wrap'] == "x") { ?>selected<?php } ?>>-- Do Not Display --</option>
            <option value="h1" <?php if (@$group['title_wrap'] == "h1") { ?>selected<?php } ?>>H1 (largest)</option>
            <option value="h2" <?php if (@$group['title_wrap'] == "h2") { ?>selected<?php } ?>>H2 (larger)</option>
            <option value="h3" <?php if (@$group['title_wrap'] == "h3" || @$group['title_wrap'] == "") { ?>selected<?php } ?>>H3 (default)</option>
            <option value="h3" <?php if (@$group['title_wrap'] == "h4") { ?>selected<?php } ?>>H4 (smaller)</option>
          </select>
          </div>

      <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-quote-left'></i> <?php _e("Text", "i3d-framework"); ?></span>
          
          <input  class='form-control' style='max-width: 200px' type='text' name='title' value="<?php echo $group['title']; ?>" />
           </div>
          </li>
          <li style='margin-top: 20px;'><label><?php _e("Description", "i3d-framework"); ?></label>
            <div style='padding-left: 10px; margin-bottom: 20px;'>
          <?php wp_editor( @$group['description'], 'description', array('textarea_rows' => 3, 'media_buttons' => true) ); ?> 
            </div>
          </li>

 
 

          <li>
          <label><?php _e("Content", "i3d-framework"); ?></label>
       <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-expand'></i> <?php _e("Selector Type", "i3d-framework"); ?></span>

 
          <select name="content_type" class='form-control' style='max-width: 200px'>
            <option <?php if ($group['content_type'] == "tabs") { echo "selected"; } ?> value="tabs">Tabs</option>
            <option <?php if ($group['content_type'] == "pills") { echo "selected"; } ?> value="pills">Pills</option>
            <option <?php if ($group['content_type'] == "accordion") { echo "selected"; } ?> value="accordion">Accordion</option>
          </select>
          </div>
          </li>


        </ul> 
  
  </div>
  <div class="tab-pane <?php if (@$_POST['cmd'] == "save") { ?>active<?php } ?>" id="panels">
       

        <input type='hidden' value='<?php echo $groupID; ?>' name='group' />
		<table class="widefat" style="max-width: 950px; min-width: 580px;">
		<thead>

		<tr><th class='header'><h3>Panels</h3>

   <input onclick='add_new_panel_item()' style='float: right; padding: 3px 8px !important; width: 150px;' type="button"  class="button button-primary" value="Add New Panel" />
</th></tr><!--<th style='text-align: center'>&nbsp;</th></tr>-->
		</thead>
		<tbody>
		<?php
		
			$panels = @$group['panels'];
			
			
			
			$counter = 0;
			if (!is_array($panels)) {
				$panels = array();
			}

?>
		<tr>
		<td valign="top">
        <ul id="sortable">
<?php foreach($panels as $panel) { ?>
				<li id="panel__<?php echo $counter; ?>">
		 <table id="<?php echo $counter; ?>__table" class="form_field" cellspacing="0" width="100%" height="100%">
		 <tr>											 
		 <td>
		  <input class="remove button" type="button" name="nocmd" value="Remove" onclick="remove_panel('<?php echo $counter; ?>')" />
		  <label style='margin-top: 8px;' for="<?php echo $counter; ?>__icon">Icon</label>
          <div class='fa-wrapper' style='display: inline-block;'><?php I3D_Framework::renderFontAwesomeSelect("{$counter}__icon", $panel['icon']); ?></div><br/>
		 <label for="<?php echo $counter; ?>__label">Label</label><input type="text" id="<?php echo $counter; ?>__label" name="<?php echo $counter; ?>__label" value="<?php echo $panel['label']; ?>" /><br />
		 <label for="<?php echo $counter; ?>__content">Content</label><br/>
          <?php wp_editor( $panel['content'], "{$counter}__content", array('textarea_rows' => 5, 'media_buttons' => true) ); ?> 

         <input type="hidden" name="panels[]" value="<?php echo $counter; ?>" />
		 </td>														 
		 </tr></table>
         </li>

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
  
  </div>
  <div class="tab-pane" id="shortcode">
  <p>You can copy and place this shortcode within any page.  Simply click in the text area below, and press CTRL/CMD-C on your keyboard.  Then, within the edit region of your page, paste (CTRL/CMD-V) the shortcode, and then save your page.</p>
  		        
      <div class="input-group input-group-indented">
            <span class="input-group-addon"><i class='fa fa-fw fa-share'></i> <?php _e("Shortcode", "i3d-framework"); ?></span>

           <input readonly onclick='this.select();' onfocus='this.select();'  class='form-control' style='max-width: 200px' type="text" value="[i3d_cpg id=<?php echo $groupID; ?>]" />
</span>
  </div>
</div>
       
     

	</form>
	</div>
	<?php
}

function i3d_content_panel_groups_contextual_help( $contextual_help, $screen_id, $screen ) { 
	//if (I3D_Framework::$supportType == "i3d") { 

	if (strstr($screen->id, '_page_i3d_content_panels')) {
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

	//} 
	}
	return $contextual_help;
}
add_action( 'contextual_help', 'i3d_content_panel_groups_contextual_help', 10, 3 );

?>